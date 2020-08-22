<?php

namespace App\Service;

use App\Entity\Megaman;
use App\Service\MegamanService;
use Doctrine\Common\Collections\ArrayCollection;

class BattleService
{
    private $foe_1;
    private $foe_2;

    /**
     * Провести Б И Т В У
     */
    public function battle($foe_1, $foe_2): ArrayCollection
    {
        $this->foe_1 = $foe_1;
        $this->foe_2 = $foe_2;

        $parts = $foe_1->getBody()->getBodypart('head')::BODYPARTS_LIST;

        $log = [];

        $turn = 0;

        while ($this->isAlive($this->foe_1) &&
               $this->isAlive($this->foe_2)) {

            $log[] = $this->attack($turn, $parts[array_rand($parts)]);
            $turn = ($turn) ? 0 : 1;
        }   // Можно ещё станы добавить, типа два и более подряд, но я не успел
        
        $log[] = ($this->isAlive($this->foe_1) ? $this->foe_2->getName() : $this->foe_1->getName()) . ' is dead!';

        return new ArrayCollection($log);
    }

    /**
     * Нанести урон и отдать сообщение. $direction -- Кто кому угрожает; TRUE -- foe_1 наносит урон foe_2, FALSE -- наоборот
     */
    private function attack(bool $direction, string $bodypart_name): string 
    {
        if ($direction) {
            $attacker = $this->foe_1;
            $attacked = $this->foe_2;
        } else {
            $attacker = $this->foe_2;
            $attacked = $this->foe_1;
        }

        $message = '';

        $damage = $this->countDamage($attacker);
        $part = $attacked->getBody()->getBodypart($bodypart_name);

        if (!$part)
            return 'You tried to hit ' . $attacked->getName() . '"s ' . $bodypart_name . ' but he hasn"t any!';
        $part_health = $part->getHealth();

        $weapon = $attacker->getBody()->getInventory()->getWielded();
        $weapon_name = ($weapon === NULL) ? 'bare hands' : $weapon->getItemType();  

        if (rand(1, 100) <= $damage['chance'] * 100) {

            $part->setHealth($part_health - $damage['damage']);

            $message = $attacker->getName() . ' ' . $damage['type'] . ' ' . 
                       $attacked->getName() . '"s '. $bodypart_name .' with ' . 
                       $weapon_name . ' ('. $damage['damage'] .' dmg). ';

            if ($part->getHealth() <= 0) {
                $message .= 'His ' . $bodypart_name . ' is mutilated!';
                $part->setHealth(0);
               // unset($part);
            }
        } else {
            $message = $attacker->getName() . ' missed!';
        }

        return $message;
    }

    /**
     * Потенциальный урон чела в зависимости от статов и того, что в руках. Возвращает [урон, тип, шанс]
     */
    private function countDamage(Megaman $man): Array
    {
        $inventory = $man->getBody()->getInventory();
        $bullets = $inventory->getItemsQuantity('bullet');
        $weapon = $inventory->getWielded();

        $damage;
        $damage_kind;

        $damage_kinds = ['bruised', 'shot', 'smashed', 'tried to hit', 'stabbed', 'cut', 'smacked', 'scarred'];

        if ($weapon) {
            $weapon_name = $weapon->getItemType();
            if (in_array($weapon_name, ['AK', 'pistol'])) {
                if ($bullets) {
                    $damage = ($weapon_name === 'AK') ? rand(60, 100) : rand(20, 50);
                    $damage_kind = 1;
                } else {
                    $damage = ($weapon_name === 'AK') ? rand(25, 35) : rand(15, 25);
                    $damage_kind = 2;
                }               // Некрасиво, но логика нормальная. Мб перепишу
            } else {
                if ($weapon_name === 'knife') {
                    if (rand(0, 1)) {
                        $damage = rand(17, 22);
                        $damage_kind = 4;
                    } else if (rand(0, 1)) {
                        $damage = rand(16, 19);
                        $damage_kind = 5;
                    } else {
                        $damage = rand(15, 18);
                        $damage_kind = 7;
                    }
                } else {
                    $damage = rand(3, 6);
                    $damage_kind = rand(0, 1) ? 3 : 6;
                }
            }
        } else {
            $damage = $man->getSTR() + (int) ($man->getAGI() / 2);
            $damage_kind = 0;
        } 

        $chance = 0; // коэффициент

        switch ($damage_kind) {
            case 0:
            case 2:
                $chance = $man->getAGI() / 100;
                break;
            case 1:
                $chance = $man->getPER() / 100;
                break;
            case 3:
                $chance = $man->getLUC() / 100;
                break;
        }
        $chance += $man->getLUC();
        $chance = $chance > 1 ? 1 : $chance;

        return ['damage' => $damage, 'type' => $damage_kinds[$damage_kind], 'chance' => $chance];
    }

    private function isAlive(Megaman $man): bool 
    {
        $vitals = new ArrayCollection(
            array_map(
                fn($x) => $man->getBody()->getBodypart($x), 
                ['torso', 'neck', 'head']
            )
        );

        return $vitals->forAll(function($key, $value) {
            return $value->getHealth() > 0;
        });
    }
}