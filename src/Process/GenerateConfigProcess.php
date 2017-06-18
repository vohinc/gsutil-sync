<?php
declare (strict_types=1);

namespace Vohinc\GsutilSync\Process;

use Illuminate\Support\Facades\File;

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

        File::put($this->path, $this->complile());

        return true;
    }

    private function makeDirectory()
    {
        if (!File::isDirectory(dirname($this->path))) {
            File::makeDirectory(dirname($this->path), 0755, true);
        }
    }

    private function complile()
    {
        $stub = File::get(__DIR__.'/../stubs/boto.stub');

        $this->replaceKey($stub)
            ->replaceProjectId($stub);

        return $stub;
    }

    private function replaceKey(&$stub)
    {
        $stub = str_replace('{{key}}', $this->config['key'], $stub);

        return $this;
    }

    private function replaceProjectId(&$stub)
    {
        $stub = str_replace('{{projectId}}', $this->config['projectId'], $stub);

        return $this;
    }
}
