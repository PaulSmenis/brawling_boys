<?php

namespace App\Service;

use App\Entity\Megaman;
use App\Entity\Body;
use App\Entity\Bodypart;
use App\Entity\Inventory;
use App\Entity\InventoryItems;
use Doctrine\Common\Collections\ArrayCollection;
use Faker\Factory;

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

            $i->addItem($item);
            $capacity += $item->getVolume();
            $item = $this->getRandomItem();
        }

        $i->setWielded(rand(1, 5) > 3 ? NULL : $this->getRandomItem());

        return $i;
    }

    private function getRandomBody(): Body 
    {
        $b = new Body();
        $b->setInventory($this->getRandomInventory());

        foreach((new Bodypart)::BODYPARTS_LIST as $part) { 
            $b->addBodypart($part);
        }

        return $b;
    }

    public function createRandomMegamen($quantity): ArrayCollection
    {
        $faker = Factory::create();
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

        return new ArrayCollection($megamen);
    }
}