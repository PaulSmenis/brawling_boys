<?php

namespace App\Command;

use App\Entity\Megaman;

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
            ->addArgument('amount', InputArgument::REQUIRED, 'Argument description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $manager = $this->entityManager;

        $men = ['Fire', 'Snow', 'Fart', 'Air', 'Earth', 'Food', 'Cat', 'Forest', 'Mint'];

        $str_date_num = function() {
            $a = rand(0, 12);
            return $a > 9 ?: '0'.$a;    
        }; 

        $random_date = function() use ($str_date_num) {
            return new \DateTime(rand(1980, 2020).'-'.
                            $str_date_num().'-'.
                           $str_date_num());
        };

        $health; $birth_date; $name;

        for ($i = 0; $i < $input->getArgument('amount'); $i++) {

            $random_megaman = new Megaman(
                $health = rand(1, 100), 
                $birth_date = $random_date(), 
                $name = $men[array_rand($men)].'man'
            );

            $output->writeln(
                ["\n".
                'New megaman ('. ($i + 1) .') has been created:'
                ."\n".
                'Health: ' . $health
                ."\n".
                 'Birth date: ' . $birth_date->format('d/m/Y')
                ."\n".
                'Name: ' . $name]
            );

            $manager->persist($random_megaman);
        }
        $manager->flush();

        return Command::SUCCESS;
    }
}
