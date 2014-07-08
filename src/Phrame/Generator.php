<?php

namespace Phrame;

abstract class Generator
{
    /**
     * @var StdClass $config
     */
    private $config;

    /**
     * @var \Monolog\Logger $logger
     */
    private $logger;

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
}
