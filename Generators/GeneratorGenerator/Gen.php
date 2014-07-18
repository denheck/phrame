<?php

class Gen extends \Phrame\Builder
{
    public function generate()
    {
        $this->ask();

        $generatorName = $this->config['generator-name'];
        $this->log("Generating your '$generatorName' generator...");

        $generatorDirectory = "{$generatorName}Generator";
        $templateDirectory = "$generatorDirectory/templates";

        // make generator and template directories
        $this->mkdir($templateDirectory);
        $this->copy('templates/Generator.php', "$templateDirectory/Generator.php");
    }

    private function ask()
    {
        $this->prompt(
            "What is the name of your new generator?",
            "generator-name"
        );
    }
}
