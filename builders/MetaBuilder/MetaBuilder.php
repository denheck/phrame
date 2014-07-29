<?php

class MetaBuilder extends \Phrame\Builder
{
    public function assemble()
    {
        $this->prompt(
            "What is the name of your new builder?",
            "builder-name"
        );

        $builderName = $this->config['builder-name'];
        $this->log("Assembling your '$builderName' builder...");

        $builderDirectory = "{$builderName}Builder";
        $templateDirectory = "$builderDirectory/templates";

        // make builder and template directories
        $this->mkdir($templateDirectory);
        $this->copy('templates/Builder.php', "$templateDirectory/Builder.php");
    }
}
