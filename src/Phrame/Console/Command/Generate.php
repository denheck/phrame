<?php

namespace Phrame\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Generate extends Command
{
    public function __construct($name, \Monolog\Logger $logger)
    {
        parent::__construct($name);
        $this->logger = $logger;
    }

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
        $generatorPath = $input->getArgument('generator');
        // TODO: make generator text a different color

        preg_match('/.*\/(.*).php$/', $generatorPath, $matches);
        $generatorName = $matches[1];

        $cwd = getcwd();

        // TODO: test executing generators from multiple different locations

        if (file_exists($generatorPath)) {
            $source = $generatorPath;
        }

        if (file_exists($cwd . DIRECTORY_SEPARATOR . $generatorPath)) {
            $source = $cwd . DIRECTORY_SEPARATOR . $generatorPath;
        }

        $output->writeln("Running generator $generatorName... ");

        require_once($generatorPath);

        $generator = new $generatorName($this->logger);

        // get answers
        $helper = $this->getHelper('question');
        $prompt = new \Phrame\Console\Prompt($helper, $input, $output);
        $generator->setPrompt($prompt);

        $generator->setDestination(getcwd());
        $generator->setSource($source);

        $generator->generate();
    }
}
