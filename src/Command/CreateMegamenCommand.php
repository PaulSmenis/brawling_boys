<?php

namespace App\Command;


use App\Service\MegamanService;

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

    public function __construct(EntityManagerInterface $entityManager, MegamanService $createMegamen)
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
        ->createRandomMegamen($input->getArgument('amount'));

        $stringified_inventory = function($megaman) {
            $str = "";
            foreach ($megaman->getBody()->getInventory()->getItems() as $item) {
                $str .= $item->getItemType() . ' ';
            }
            return $str . "\n";
        };

        foreach ($megamen as $index => $megaman) {

            $output->writeln([
                'New megaman ('. ($index + 1) .') has been created:',
                'Birth date: ' . $megaman->getBirthDate()->format('d/m/Y'),
                'Name: ' . $megaman->getName(),
                'Average health: ' . $megaman->getAverageHealth(),
                'Inventory: ' . $stringified_inventory($megaman)
            ]);

            $this->entityManager->persist($megaman);
        }
        
        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
