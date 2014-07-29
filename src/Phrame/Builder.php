<?php

namespace Phrame;

abstract class Builder
{
    /**
     * @var array $config
     */
    protected $config = array();

    /**
     * The files generated by your project
     * @var string $generatedFiles
     */
    protected $generatedFiles;

    /**
     * @var \Monolog\Logger $logger
     */
    private $logger;

    private $questions;

    private $destination;

    /**
     * @param \Monolog\Logger $logger
     */
    public function __construct(\Monolog\Logger $logger)
    {
        $this->logger = $logger;
        $this->handleErrors();
    }

    /**
     * @param string $configFile JSON configuration file's name
     */
    public function setConfig($configFile)
    {
        $source = $this->getSource();
        // TODO: handle erroneous JSON
        // TODO: handle source and dest paths, i.e. trailing slashe vs no trailing slash
        $this->config = json_decode($configFile);
    }

    /**
     * @param string $directory create folders at destination
     * @param int $mode file permission mode as an octal number
     * @param bool $recursive create nested directories
     * @return bool
     */
    public function mkdir($directory, $mode = 0777, $recursive = true)
    {
        $this->generatedFiles[] = $directory;

        $destination = $this->getDestination();
        $destination .= DIRECTORY_SEPARATOR . trim($directory, " \t\n\r\0\x0B/");

        $this->logger->addDebug("Creating directory '$destination'...");

        // TODO: maybe restrict permissions more
        return mkdir($destination, 0777, true);
    }

    /**
     * @param string $fromFile path to file relative to generator's source
     * @param string $toFile path to destination relative to generator's destination
     * @return bool
     */
    public function copy($fromFile, $toFile)
    {
        $destination = $this->getDestination();
        $source = $this->getSource();

        $sourceFile = $source . DIRECTORY_SEPARATOR . $fromFile;
        $destinationFile = $destination . DIRECTORY_SEPARATOR . $toFile;

        $this->logger->addDebug("Copying '$sourceFile' to '$destinationFile'...");

        return copy(
            $sourceFile,
            $destinationFile
        );
    }

    /**
     * generator lives in this directory
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    public function getDestination()
    {
        return $this->destination;
    }

    public function assemble()
    {
        // TODO: default should parse config file and take appropriate action
        //       based on parameters passed. This allows the user to write
        //       generators in JSON only if needed. JSON is parsed sequentially
        //       and each key will call a public method on generate.
    }

    public function setPrompt(\Phrame\PromptInterface $prompt)
    {
        $this->prompt = $prompt;
    }

    public function prompt($question, $key)
    {
        $answer = $this->prompt->question($question, $key);
        $this->config[$key] = $answer;
    }

    public function log($message, $level = 'info')
    {
        $this->logger->log($level, $message);
    }

    /**
     * remove all generated content
     */
    private function removeGenerated()
    {
        $destination = $this->getDestination();
        $ds = DIRECTORY_SEPARATOR;

        foreach ($this->generatedFiles as $generatedFile) {
            $generatedPath = $destination . $ds . $generatedFile;

            if (is_dir($generatedPath)) {
                while (strlen($generatedPath) > strlen($destination . $ds)) {
                    rmdir($generatedPath);
                    $generatedPath = substr($generatedPath, 0, strrpos($generatedPath, $ds));
                }
            } else {
                // TODO: finish me
                //unlink($generatedFile);
            }
        }
    }

    /**
     * throw exceptions in favor of php warnings if a generator fails to copy
     * or move a file
     */
    private function handleErrors()
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline, array $errcontext) {
            // error was suppressed with the @-operator
            if (0 === error_reporting()) {
                return false;
            }

            $this->removeGenerated();

            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
    }
}
