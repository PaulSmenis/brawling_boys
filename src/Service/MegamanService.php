<?php

namespace App\Service;

use App\Entity\Megaman;
use App\Entity\Body;
use App\Entity\Bodypart;
use App\Entity\Inventory;
use App\Entity\InventoryItems;

class MegamanService
{
    private function getRandomItem(): InventoryItems 
    {
        $items = ['medkit' => 10, 'knife' => 10, 'pistol' => 15, 'bullet' => 1, 'bandage' => 5, 'AK' => 25];

        $item = array_rand($items);

        $i = new InventoryItems();
        $i->setItemType($item);
        $i->setVolume($items[$item]);

        return $i;
    }

    private function getRandomInventory(): Inventory 
    {
        $i = new Inventory();
        $vol = rand(30, 100);
        $i->setVolume($vol);

        for ($x = 0, $capacity = 0, $item = $this->getRandomItem();
             $x < rand(0, 10) && $capacity + $item->getVolume() <= $vol;
             $x++) {

            $type = $item->getItemType();

            $i->addItem($item);
            $capacity += $item->getVolume();
            $item = $this->getRandomItem();
        }
        return $i;
    }

    private function getRandomBodypart(string $name = 'foo'): Bodypart 
    {
        $b = new Bodypart();
        $b->setHealth(rand(5, 10) * 10);
        $b->setName($name);
        return $b;
    }

    private function getRandomBody(): Body 
    {
        $b = new Body();
        $b->setInventory($this->getRandomInventory());

        foreach (['leg', 'hand', 'arm', 'foot', 'knee',
                  'elbow', 'hand', 'ear', 'eye'] as $part) {
                $b->addBodypart($this->getRandomBodypart('left '. $part));
                $b->addBodypart($this->getRandomBodypart('right '. $part));
        } // Чисто сэкономить пару проверочных условий
        foreach(['head', 'torso', 'neck', 'pee-pee'] as $part) {
            $b->addBodypart($this->getRandomBodypart($part));
        }
        return $b;
    }

    public function createRandomMegamen($quantity): Array 
    {
        $faker = \Faker\Factory::create();
        $faker->seed(rand(0, 1000));

        $megamen = [];
    
        for ($i = 0; $i < $quantity; $i++) {

            $megaman = new Megaman();
            $birth_date = $faker->dateTimeInInterval('-50 years');
            $name = $faker->name;

            $megaman->setBirthDate($birth_date); 
            $megaman->setName($name);
            $megaman->setBody($this->getRandomBody());

            $megaman->setSTR(rand(1, 10));
            $megaman->setPER(rand(1, 10));
            $megaman->setEND(rand(1, 10));
            $megaman->setCHA(rand(1, 10));
            $megaman->setINTELLECT(rand(1, 10));
            $megaman->setAGI(rand(1, 10));
            $megaman->setLUC(rand(1, 10));

            $megamen[] = $megaman;
        }
        return $megamen;
    }
}