<?php
declare (strict_types=1);

namespace Vohinc\GsutilSync\Process;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class AbstractProcess
 *
 * @package Vohinc\GsutilSync\Process
 */
abstract class AbstractProcess implements ProcessInterface
{
    /**
     * @var Process
     */
    protected $process;

    /**
     * AbstractProcess constructor.
     *
     * @param $command
     *
     * @throws \Symfony\Component\Process\Exception\RuntimeException
     */
    public function __construct($command)
    {
        $this->process = new Process($command);
    }

    /**
     * @return string
     * @throws \Symfony\Component\Process\Exception\ProcessFailedException
     * @throws \Symfony\Component\Process\Exception\LogicException
     */
    public function getOutput()
    {
        if (!$this->process->isSuccessful()) {
            throw new ProcessFailedException($this->process);
        }

        return $this->process->getOutput();
    }
}
