<?php
declare(strict_types=1);

namespace Vohinc\GsutilSync\Process;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Wilderborn\Partyline\Facade as Partyline;

/**
 * Class SyncProcess
 *
 * @package Vohinc\GsutilSync\Process
 */
class SyncProcess extends AbstractProcess
{
    /**
     * @var
     */
    private $config;

    /**
     * SyncProcess constructor.
     *
     * @param $path
     * @param $config
     *
     * @throws \Symfony\Component\Process\Exception\RuntimeException
     */
    public function __construct($path, $config)
    {
        $this->path = $path;
        $this->config = $config;
        parent::__construct($this->command());
    }

    /**
     * Run process
     *
     * @return mixed
     * @throws \Symfony\Component\Process\Exception\RuntimeException
     * @throws \Symfony\Component\Process\Exception\LogicException
     */
    public function run()
    {
        $this->process->run(function ($type, $buffer) {
            Partyline::info($buffer);
        });
    }

    /**
     * @return string
     */
    private function command()
    {
        return <<<EOF
        export BOTO_PATH={$this->config['boto']}
        {$this->config['bin']} -m rsync -r -x "^\..*" {$this->path} \
        gs://{$this->config['bucket']}/{$this->path()}
EOF;
    }

    /**
     * Combine path
     *
     * @return string
     */
    private function path()
    {
        $basename = basename($this->path);
        if ($root = $this->config['root']) {
            return "{$root}/{$basename}/";
        }

        return $basename;
    }
}
