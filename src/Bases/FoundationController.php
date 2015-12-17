<?php namespace Arcanesoft\Core\Bases;

/**
 * Class     FoundationController
 *
 * @package  Arcanesoft\Foundation\Bases
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class FoundationController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Instantiate the controller.
     */
    public function __construct()
    {
        parent::__construct();

        $this->initSeo();
        $this->registerBreadcrumbs('foundation');
        $this->setTemplate(config('arcanesoft.foundation.template'));
    }

    /* ------------------------------------------------------------------------------------------------
     |  SEO Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Init SEO.
     */
    private function initSeo()
    {
        $this->seo()->disableOpenGraph();
        $this->seo()->disableTwitter();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Breadcrumbs Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the breadcrumbs home item (root).
     *
     * @return array
     */
    protected function getBreadcrumbsHomeItem()
    {
        return [
            'title' => trans('foundation::generals.home'),
            'url'   => route('foundation::home'),
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Views Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Display the view.
     *
     * @param  string  $name
     * @param  array   $data
     *
     * @return \Illuminate\View\View
     */
    protected function view($name, array $data = [])
    {
        if ( ! is_null($this->viewNamespace)) {
            $name = "{$this->viewNamespace}::$name";
        }

        return parent::view($name, $data);
    }

    /**
     * Do random stuff before rendering view.
     */
    protected function beforeViewRender()
    {
        $this->loadBreadcrumbs();
    }
}