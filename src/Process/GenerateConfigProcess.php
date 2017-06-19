<?php
declare (strict_types=1);

namespace Vohinc\GsutilSync\Process;

use Illuminate\Support\Facades\File;
use Vohinc\GsutilSync\Exceptions\MissingKeyFileException;

/**
 * Class GenerateConfigProcess
 *
 * @package Vohinc\GsutilSync\Process
 */
class GenerateConfigProcess implements ProcessInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $config;

    /**
     * GenerateConfigProcess constructor.
     *
     * @param $path
     * @param $config
     */
    public function __construct($path, $config)
    {
        $this->path = $path;
        $this->config = $config;
    }


    /**
     * Run process
     *
     * @return mixed
     */
    public function run()
    {
        $this->makeDirectory();
        $this->isKeyExists();

        File::put($this->path, $this->complile());

        return true;
    }

    private function isKeyExists()
    {
        if (File::exists($this->config['key'])) {
            return true;
        }

        throw new MissingKeyFileException();
    }

    /**
     * Create directory
     */
    private function makeDirectory()
    {
        if (!File::isDirectory(dirname($this->path))) {
            File::makeDirectory(dirname($this->path), 0755, true);
        }
    }

    /**
     * @return mixed
     */
    private function complile()
    {
        $stub = File::get(__DIR__.'/../stubs/boto.stub');

        $this->replaceKey($stub)
            ->replaceProjectId($stub);

        return $stub;
    }

    /**
     * Replace key path to stub
     *
     * @param $stub
     *
     * @return $this
     */
    private function replaceKey(&$stub)
    {
        $stub = str_replace('{{key}}', $this->config['key'], $stub);

        return $this;
    }

    /**
     * Replace project id to stub
     *
     * @param $stub
     *
     * @return $this
     */
    private function replaceProjectId(&$stub)
    {
        $stub = str_replace('{{projectId}}', $this->config['projectId'], $stub);

        return $this;
    }
}
