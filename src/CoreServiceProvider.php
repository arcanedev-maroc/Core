<?php namespace Arcanesoft\Core;

use Arcanesoft\Core\Bases\PackageServiceProvider;

/**
 * Class     FoundationServiceProvider
 *
 * @package  Arcanesoft\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CoreServiceProvider extends PackageServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'core';

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the base path of the package.
     *
     * @return string
     */
    public function getBasePath()
    {
        return dirname(__DIR__);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the service provider.
     */
    public function register()
    {
        parent::register();

        $this->registerConfig();
        $this->registerArcanesoftDatabase();
        $this->registerProviders([
            Providers\AuthorizationServiceProvider::class,
            Providers\PackagesServiceProvider::class,
        ]);
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        parent::boot();

        $this->registerProvider(Providers\RouteServiceProvider::class);

        $this->publishTranslations();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            //
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Services Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the Core service provider.
     */
    protected function registerCoreServiceProvider()
    {
        // Skip the core service provider registration (self).
    }

    /**
     * Register Foundation database.
     */
    private function registerArcanesoftDatabase()
    {
        // Keep it or using a real DBMS ?
        $connection = $this->config()->get('core.database.default', 'sqlite');

        $this->config()->set(
            'database.connections.arcanesoft',
            $this->config()->get("core.database.connections.{$connection}")
        );
    }
}
