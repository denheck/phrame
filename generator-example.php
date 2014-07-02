<?php

// TODO: resolve where the generated files should go
class ModelGenerator extends \Phrame\Generator
{
    /**
     * if this method is present, it will ask users for information which will
     * be stored in appropriate properties on the ModelGenerator Object
     */
    public function ask()
    {
        // used to ask the user a question on the command line
        // parameter 1: what the user will see on the command line
        // parameter 2: property to store response on ModelGenerator
        // parameter 3 (optional): default if user doesn't answer
        $this->prompt("What is your name?", "username", "beelzebub");
        $this->prompt("Where are you from?", "place");
    }

    /**
     *  This method will run the generator
     */
    public function generate()
    {
        // log generator info to command line
        $this->log("Generating your stuff...");

        // make directories at root of application
        $this->mkdir('app/controllers/');

        // copy files from generator root filepath to application root filepath
        $this->copy('templates/config.yml', 'files/config.yml');

        // run another generator
        $this->runGenerator('OtherGenerator');

        // TODO: examples for generating files from a template
    }
}


/**
 * Features:
 * 1. phrame generate = render templates, copy files, make directories, etc
 */

/**
 * TODO:
 * 1. Switch to PSR-4 autoloading
 */
