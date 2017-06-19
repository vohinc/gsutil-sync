<?php
declare(strict_types=1);

namespace Vohinc\GsutilSync\Providers;

use Illuminate\Support\ServiceProvider;
use Vohinc\GsutilSync\Commands\BackupCommand;
use Vohinc\GsutilSync\Commands\ConfigCommand;

/**
 * Class GsutilSyncProvider
 *
 * @package Vohinc\GsutilSync\Providers
 */
class GsutilSyncProvider extends ServiceProvider
{
    /**
     * Config path
     * @var string
     */
    protected $configPath = __DIR__ . '/../../config/gsutil-sync.php';

    /**
     *
     */
    public function boot()
    {
        $this->publishes([
            $this->configPath => $this->app->configPath().'/gsutil-sync.php',
        ], 'config');
    }

    /**
     *
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath, 'gsutil-sync');
        $this->app->register(\Wilderborn\Partyline\ServiceProvider::class);
        $this->app->alias(\Wilderborn\Partyline\Facade::class, 'Partyline');

        $this->app->bind('command.gsutil.sync:run', BackupCommand::class);
        $this->app->bind('command.gsutil.sync:config', ConfigCommand::class);

        $this->commands([
            'command.gsutil.sync:run',
            'command.gsutil.sync:config',
        ]);
    }
}
