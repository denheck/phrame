<?php

// TODO: should show source and destination directories with more verbose logging aka
// SOURCE: /foo/bar/
// DEST: /new/location/
// TODO: resolve where the generated files should go
class ModelGenerator extends \Phrame\Generator
{
    /**
     *  This is the only method which will be called directly on this class
     */
    public function generate()
    {
        $this->ask();

        // log generator info to command line
        $this->log("Generating your stuff...");

        // make directories at path to destination, usually the current working directory
        $this->mkdir('app/controllers/');

        // TODO: should this method prompt if file will be overwritten?
        // copy files from generator root filepath to application root filepath
        $this->copy('templates/config.yml', 'files/config.yml');

        // run another generator (future addition)
        //$this->runGenerator('OtherGenerator');

        // returns path to destination, usually the current working directory
        $destPath = $this->getDestination();

        // returns path to source, usually the directory this file can be found in
        $sourcePath = $this->getSource();

        // TODO: examples for generating files from a template

        // set default configuration options using a config file
        // will look in $this->getSource()
        // (prompt method will override config options)
        $this->setConfig('config-file.json');

        // access configuration options via
        $face = $this->config('your-face');
    }

    /**
     * This is separated from the generate method for brevity only
     */
    private function ask()
    {
        // used to ask the user a question on the command line
        // parameter 1: what the user will see on the command line
        // parameter 2: key to access config option via "$this->config('username')"
        // parameter 3 (optional): default if user doesn't answer
        $this->prompt("What is your name?", "username", "beelzebub");
        $this->prompt("Where are you from?", "place");
    }
}


/**
 * Features:
 * 1. phrame generate = render templates, copy files, make directories, etc
 * 2. phrame generate-interface interface dest = render file which implements an interface
 * 3. generators clean up after themselves if they fail by deleting all generated
 *    files and folders
 */

/**
 * TODO:
 * 1. Switch to PSR-4 autoloading
 * 2. Implement a generator generator (Yo Dawg...)
 * 3. Implement a generator test generator
 * 4. Integration Tests
 *
 * NICETOHAVES
 * 1. Test logging
 */
