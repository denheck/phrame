<?php

namespace Phrame\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Builder extends Command
{
    public function __construct($name, \Monolog\Logger $logger)
    {
        parent::__construct($name);
        $this->logger = $logger;
    }

    protected function configure()
    {
        $this->setName('builder')
             ->setDescription('Run predefined builder')
             ->addArgument(
                'builder',
                InputArgument::REQUIRED,
                'Which builder would you like to run?'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $builderPath = realpath($input->getArgument('builder'));
        // TODO: make builder text a different color

        preg_match('/.*\/(.*).php$/', $builderPath, $matches);
        $builderName = $matches[1];

        // TODO: test executing builders from multiple different locations
        $output->writeln("Running builder $builderName... ");

        require_once($builderPath);

        $source = substr($builderPath, 0, strrpos($builderPath, '/'));
        
        $builder = new $builderName($this->logger);

        // get answers
        $helper = $this->getHelper('question');
        $prompt = new \Phrame\Console\Prompt($helper, $input, $output);
        $builder->setPrompt($prompt);

        $builder->setDestination(getcwd());
        $builder->setSource($source);

        $builder->assemble();
    }
}
