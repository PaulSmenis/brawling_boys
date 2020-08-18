<?php

namespace App\Command;

use App\Entity\Megaman;
use App\Entity\Body;
use App\Entity\Inventory;
use App\Entity\Medkit;
use App\Entity\Bodypart;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateMegamenCommand extends Command
{
    protected static $defaultName = 'app:create-megamen';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates n randomized megamen and fetches them to the DB')
            ->addArgument('amount', InputArgument::REQUIRED, 'Quantity of megamen being created')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $manager = $this->entityManager;
        $faker = \Faker\Factory::create();
        $faker->seed(rand(0, 1000));

        $str_date_num = function(): string {
            $a = rand(0, 12);
            return $a > 9 ?: '0'.$a;    
        }; 

        $random_date = function() use ($str_date_num): \DateTime {
            return new \DateTime(rand(1980, 2020).'-'.
                            $str_date_num().'-'.
                           $str_date_num());
        };

        $random_medkit = function(): Medkit {
            $m = new Medkit();
            $m->setHealingCapacity(rand(1, 100));
            $m->setVolume(rand(1, 10));
            return $m;
        };

        $random_inventory = function() use ($random_medkit): Inventory {
            $i = new Inventory();
            $i->setVolume(rand(30, 100));

            for ($x = 0, $capacity = 0, $kit = $random_medkit();
                 $x < rand(0, 10) && $i->getVolume() - $kit->getVolume() <= $capacity;
                 $x++) {
                $i->putMedkit($kit);
                $capacity += $kit->getVolume();
                $kit = $random_medkit();
            }
            return $i;
        };

        $random_bodypart = function(string $name): Bodypart {
            $b = new Bodypart();
            $b->setHealth(rand(5, 10) * 10);
            $b->setName($name);
            return $b;
        };

        $random_body = function() use ($random_inventory, $random_bodypart): Body {
            $b = new Body();
            $b->setInventory($random_inventory());

            foreach (['leg', 'hand', 'arm', 'foot', 'knee',
                      'elbow', 'hand', 'ear', 'eye'] as $part) {
                    $b->addBodypart($random_bodypart('left '. $part));
                    $b->addBodypart($random_bodypart('right '. $part));
            } // Чисто сэкономить пару проверочных условий
            foreach(['head', 'torso', 'neck', 'pee-pee'] as $part) {
                $b->addBodypart($random_bodypart($part));
            }
            return $b;
        };

        $average_health = function(Megaman $man): float {
            $bodyparts = $man->getBody()->getBodypart();
            $sum = $n = 0;
            foreach ($bodyparts as $part) {
                $sum += $part->getHealth();
                $n++;
            }
            return (int) ($sum / $n);
        };

        for ($i = 0; $i < $input->getArgument('amount'); $i++) {

            $megaman = new Megaman();
            $birth_date = $random_date();
            $name = $faker->name;

            $megaman->setBirthDate($birth_date); 
            $megaman->setName($name);
            $megaman->setBody($random_body());

            $output->writeln(
                ["\n".
                'New megaman ('. ($i + 1) .') has been created:'
                ."\n".
                 'Birth date: ' . $birth_date->format('d/m/Y')
                ."\n".
                'Name: ' . $name
                ."\n".
                'Average health: ' . $average_health($megaman)]
            );
            $manager->persist($megaman);
        }
        $manager->flush();

        return Command::SUCCESS;
    }
}
