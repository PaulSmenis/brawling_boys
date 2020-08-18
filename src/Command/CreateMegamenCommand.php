<?php

namespace App\Command;


use App\Service\CreateMegamen;

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
    private $createMegamen;

    public function __construct(EntityManagerInterface $entityManager, CreateMegamen $createMegamen)
    {
        $this->entityManager = $entityManager;
        $this->createMegamen = $createMegamen;

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
        $megamen = $this->createMegamen
        ->create($input->getArgument('amount'));

        foreach ($megamen as $i => $megaman) {
            $output->writeln(
                ["\n".
                'New megaman ('. ($i + 1) .') has been created:'
                ."\n".
                 'Birth date: ' . $megaman->getBirthDate()->format('d/m/Y')
                ."\n".
                'Name: ' . $megaman->getName()
                ."\n".
                'Average health: ' . $megaman->getAverageHealth()]
            );
            $this->entityManager->persist($megaman);
        }
        
        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
