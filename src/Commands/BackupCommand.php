<?php
declare (strict_types=1);

namespace Vohinc\GsutilSync\Commands;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Vohinc\GsutilSync\Exceptions\MissingBinException;
use Vohinc\GsutilSync\Exceptions\MissingConfigException;
use Vohinc\GsutilSync\Process\CheckBinFileProcess;
use Vohinc\GsutilSync\Process\CheckCfgProcess;
use Vohinc\GsutilSync\Process\SyncProcess;

/**
 * Class BackupCommand
 *
 * @package Vohinc\GsutilSync\Commands
 */
class BackupCommand extends AbstractCommand
{
    /**
     * @var string
     */
    protected $signature = 'gsutil:sync';

    /**
     * @var string
     */
    protected $description = 'Run gsutil sync';

    /**
     *
     * @throws \Symfony\Component\Process\Exception\RuntimeException
     * @throws \Symfony\Component\Process\Exception\LogicException
     */
    public function handle()
    {
        try {
            if ($this->checkBin($this->config['bin']) && $this->checkConfig($this->config['boto'])) {
                $paths = $this->config['paths'];

                foreach ($paths as $path) {
                    $this->sync($path);
                }
            }
        } catch (MissingBinException $ex) {
            $this->error('Sorry, Missing bin file. Please install `gsutil` or setup correct path');
        }  catch (MissingConfigException $ex) {
            $this->error('Sorry, Missing config file. Please run `php artisan gsutil:config` to create config file');
        }
    }

    /**
     * @param $path
     *
     * @return mixed
     * @throws \Vohinc\GsutilSync\Exceptions\MissingBinException
     */
    private function checkBin($path)
    {
        $process = new CheckBinFileProcess($path);
        return $process->run();
    }

    /**
     * @param $path
     *
     * @return bool
     * @throws \Vohinc\GsutilSync\Exceptions\MissingConfigException
     */
    private function checkConfig($path)
    {
        $process = new CheckCfgProcess($path);
        return $process->run();
    }

    /**
     * @param $path
     *
     * @throws \Symfony\Component\Process\Exception\RuntimeException
     */
    private function sync($path)
    {
        try {
            $process = new SyncProcess($path, $this->config);
            $this->info($process->run());
        } catch (ProcessFailedException $ex) {
            $this->error($ex->getMessage());
        }
    }
}
