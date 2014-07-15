<?php

namespace Phrame\Console;

use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// TODO: add default values
class Prompt implements \Phrame\PromptInterface
{
    public function __construct(QuestionHelper $helper, InputInterface $input, OutputInterface $output)
    {
        $this->helper = $helper;
        $this->input = $input;
        $this->output = $output;
    }

    public function question($question)
    {
        $question = new Question($question);
        return $this->helper->ask($this->input, $this->output, $question);
    }
}
