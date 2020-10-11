<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;

class BdRedoCommand extends Command
{
    protected static $defaultName = 'bd:redo';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $command = $this->getApplication()->find('doctrine:database:drop');
        $greetInput = new ArrayInput(['--force' => true]);
        $command->run($greetInput, $output);

        $command = $this->getApplication()->find('doctrine:database:create');
        $greetInput = new ArrayInput([]);
        $command->run($greetInput, $output);

        $command = $this->getApplication()->find('doctrine:schema:update');
        $greetInput = new ArrayInput(['--force' => true]);
        $command->run($greetInput, $output);

        $command = $this->getApplication()->find('doctrine:fixtures:load');
        $greetInput = new ArrayInput([]);
        $command->run($greetInput, $output);

        return 0;
    }
}
