<?php

namespace App\DataFixtures;

use App\Entity\Megaman;
use App\Service\MegamanService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $megaman_service;

    public function __construct(MegamanService $service)
    {
        $this->megaman_service = $service;
    }

    public function load(ObjectManager $manager)
    {
        $megamen = $this->megaman_service->createRandomMegamen(10);

        $megamen->map(
            fn($x) => $manager->persist($x)
        );
 
        $manager->flush();
    }
}