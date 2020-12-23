<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Filesystem\Filesystem;

/**
 * Class ConfigSettingsLoader
 * @package App\Classes
 */
class ConfigSettingsService
{
    /**
     * @var string $environment
     */
    protected $environment;

    /**
     * @var string $path
     */
    protected $path;

    /**
     * @var Filesystem $fileSystem
     */
    protected $fileSystem;

    /**
     * ConfigSettingsLoader constructor.
     * @param null $environment
     */
    public function __construct($environment = null)
    {
        $this->environment = $environment;
        $this->path = base_path();
        $this->fileSystem = new Filesystem();
    }

    /**
     * Load custom config settings.
     * When an error occurs the app should not crash, log the error and skip the custom settings
     *
     * @return void
     */
    public function load() : void
    {
        try {
            foreach($this->getSettings() as $key => $value) {
                if(config($key)) {
                    config([$key => $value]);
                }
            }
        } catch (\Throwable $e) {
            //app continues
        }
    }

    /**
     * Get the settings from the settings file
     *
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function getSettings() : array
    {
        $file = $this->getFile();
        if ( ! $this->fileSystem->exists($path = $file))
        {
            return array();
        }

        return Arr::dot($this->fileSystem->getRequire($path));
    }

    /**
     * Get the settings file
     *
     * @return string
     */
    private function getFile() : string
    {
        if ($this->environment)
        {
            return $this->path.'/.settings.'.$this->environment.'.php';
        }

        return $this->path.'/.settings.php';
    }
}
