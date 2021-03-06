<?php
declare(strict_types=1);

/** @noinspection PhpUnusedParameterInspection */
/** @noinspection PhpUndefinedNamespaceInspection */
/** @noinspection PhpUndefinedMethodInspection */
/** @noinspection PhpUndefinedFunctionInspection */
/** @noinspection PhpUndefinedFieldInspection */
/** @noinspection PhpUndefinedClassInspection */

namespace Level23\Druid;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Foundation\Application as LaravelApplication;

/**
 * Class DruidServiceProvider
 *
 * @package Level23\Druid
 * @codeCoverageIgnore
 */
class DruidServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->registerDruidClient();
    }

    /**
     * Publish and merge the config
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__ . '/../config/config.php');

        if ($this->app instanceof LaravelApplication) {
            $this->publishes([$source => config_path('druid.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('druid');
        }

        $this->mergeConfigFrom($source, 'druid');
    }

    /**
     * Register the application bindings.
     *
     * @return void
     */
    protected function registerDruidClient()
    {
        $this->setupConfig();

        $this->app->singleton(DruidClient::class, function () {
            $client = new DruidClient($this->app['config']['druid']);
            $client->setLogger($this->app['log']);

            return $client;
        });

        $this->app->bind('druid', DruidClient::class);
    }
}