<?php namespace Arcanesoft\Core\Providers;

use Arcanedev\Support\ServiceProvider;
use Arcanesoft\Core\Helpers;

/**
 * Class     HelpersServiceProvider
 *
 * @package  Arcanesoft\Core\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class HelpersServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->registerSidebarHelper();
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [
            'arcanesoft.helpers.sidebar',
            Helpers\Sidebar\Contracts\Sidebar::class,
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Helpers Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the Sidebar Helper.
     */
    private function registerSidebarHelper()
    {
        $this->singleton(
            'arcanesoft.helpers.sidebar',
            Helpers\Sidebar\Manager::class
        );

        $this->bind(
            Helpers\Sidebar\Contracts\Sidebar::class,
            'arcanesoft.helpers.sidebar'
        );
    }
}
