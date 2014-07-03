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
}
