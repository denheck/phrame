<?php

namespace Phrame;

class Generator
{
    private $config;

    /**
     * @param string $configFile JSON configuration file's name
     */
    public function setConfig($configFile)
    {
        $source = $this->getSource();
        // TODO: handle erroneous JSON
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
        return mkdir($destination . PATH_SEPARATOR . trim($directory, " \t\n\r\0\x0B/"));
    }
}
