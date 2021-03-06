<?php
declare(strict_types=1);

namespace Vohinc\GsutilSync\Commands;

use Exception;
use Vohinc\GsutilSync\Exceptions\MissingKeyFileException;
use Vohinc\GsutilSync\Process\GenerateConfigProcess;

/**
 * Class ConfigCommand
 *
 * @package Vohinc\GsutilSync\Commands
 */
class ConfigCommand extends AbstractCommand
{
    /**
     * @var string
     */
    protected $signature = 'gsutil:config';

    /**
     * @var string
     */
    protected $description = 'Generate gsutil config';

    /**
     *
     */
    public function handle()
    {
        try {
            $process = new GenerateConfigProcess($this->config['boto'], $this->config);
            if ($process->run()) {
                $this->info('Create gsutil config success.');
            }
        } catch (MissingKeyFileException $ex) {
            $this->error('No such key file, please check use full path for key path.');
        } catch (Exception $ex) {
            $this->error($ex->getMessage());
        }
    }
}
