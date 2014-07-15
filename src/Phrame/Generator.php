<?php

namespace Phrame;

abstract class Generator
{
    /**
     * @var array $config
     */
    protected $config = array();

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
        $destination = $this->getDestination();
        $destination .= DIRECTORY_SEPARATOR . trim($directory, " \t\n\r\0\x0B/");

        $this->logger->addDebug("Creating directory '$destination'...");

        return mkdir($destination);
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

    public function generate()
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
}
