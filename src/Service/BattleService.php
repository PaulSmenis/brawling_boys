<?php

namespace App\Service;

use App\Entity\Megaman;
use Doctrine\Common\Collections\ArrayCollection;

class BattleService
{
    public Megaman $first_fighter;
    public Megaman $second_fighter;

    public function battle(): ArrayCollection
    {
        $foe_1 = $this->first_fighter;
        $foe_2 = $this->second_fighter;

        $log = [];

        $turn = 0;

        while ($this->isAlive($foe_1) &&
               $this->isAlive($foe_2)) {

            $log[] = $this->attack($foe_1, $foe_2, $turn);
            $turn = ($turn) ? 0 : 1;
        }   // Можно ещё станы добавить, типа два и более подряд, но я не успел
        
        $log[] = ($this->isAlive($foe_1) ? $foe_2->getName() : $foe_1->getName()) . ' is dead!';
        return new ArrayCollection($log);
    }

    /**
     * Нанести урон и отдать сообщение. $direction -- Кто кому угрожает; TRUE -- foe_1 наносит урон foe_2, FALSE -- наоборот
     * @param Megaman $foe_1
     * @param Megaman $foe_2
     * @param string $bodypart_name
     * @return string
     */
    private function attack(Megaman $foe_1, Megaman $foe_2, string $bodypart_name): string
    {
        //$message = '';

        $damage = $this->countDamage($foe_1);
        $part = $foe_2->getBody()->getBodypart($bodypart_name);

        if (!$part)
            return 'You tried to hit ' . $foe_2->getName() . '"s ' . $bodypart_name . ' but he hasn"t any!';
        $part_health = $part->getHealth();

        $weapon = $foe_1->getBody()->getInventory()->getWielded();
        $weapon_name = ($weapon === NULL) ? 'bare hands' : $weapon->getItemType();  

        if (rand(1, 100) <= $damage['chance'] * 100) {

            $part->setHealth($part_health - $damage['damage']);

            $message = $foe_1->getName() . ' ' . $damage['type'] . ' ' . 
                       $foe_2->getName() . '"s '. $bodypart_name .' with ' . 
                       $weapon_name . ' ('. $damage['damage'] .' dmg). ';

            if ($part->getHealth() <= 0) {
                $message .= 'His ' . $bodypart_name . ' is mutilated!';
                $part->setHealth(0);
               // unset($part);
            }
        } else {
            $message = $foe_1->getName() . ' missed!';
        }

        return $message;
    }

    /**
     * Потенциальный урон чела в зависимости от статов и того, что в руках. Возвращает [урон, тип, шанс]
     */
    private function countDamage(Megaman $man): array
    {
        $inventory = $man->getBody()->getInventory();
        $bullets = $inventory->getItemsQuantity('bullet');
        $weapon = $inventory->getWielded();

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
        return $vitals->forAll(function($value) {
            var_dump($value);
            return $value->getHealth() > 0;
        });
    }
}