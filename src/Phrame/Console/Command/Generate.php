<?php

namespace Phrame\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Generate extends Command
{
    protected function configure()
    {
        $this->setName('generate')
             ->setDescription('Run predefined generator task')
             ->addArgument(
                'generator',
                InputArgument::REQUIRED,
                'Which generator would you like to run?'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generator = $input->getArgument('generator');
        // TODO: make generator text a different color
        $output->writeln("Running generator $generator... ");
    }
}
