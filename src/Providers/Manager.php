<?php

namespace DevApex\Breadcrumbs\Providers;

/*use Diglactic\Breadcrumbs\Exceptions\DuplicateBreadcrumbException;
use Diglactic\Breadcrumbs\Exceptions\InvalidBreadcrumbException;
use Diglactic\Breadcrumbs\Exceptions\UnnamedRouteException;
use Diglactic\Breadcrumbs\Exceptions\ViewNotSetException;*/

use DevApex\Breadcrumbs\Models\BreadcrumbsItem;
use DevApex\Breadcrumbs\Models\BreadcrumbsBag;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;

/**
 * The main Breadcrumbs singleton class, responsible for registering, generating and rendering breadcrumbs.
 */
class Manager
{
    use Macroable;

    protected $bag;
    protected $bagDefaults;

    public function __construct(ViewFactory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
        $this->bag = new BreadcrumbsBag();
        $this->bagDefaults = new BreadcrumbsBag();
    }

    public function make($title, $url = null, $ignore_defaults = false){

        if(!$ignore_defaults){
            $this->bag->itens = $this->bagDefaults->itens;
        }

        $this->bag->add($title, $url);
        return $this->bag;
    }

    public function defaults($title, $url = null){
        $this->bagDefaults = new BreadcrumbsBag();
        $this->bagDefaults->add($title, $url);
        return $this->bagDefaults;
    }

    public function bag(){
        return $this->bag;
    }

    public function list_class($class){
        $this->bag->list_class = $class;
    }

    public function item_class($class){
        $this->bag->item_class = $class;
    }

    public function item_class_active($class){
        $this->bag->item_class_active = $class;
    }

    public function link_class($class){
        $this->bag->link_class = $class;
    }

    public function isEmpty(){
        return !$this->bag || !$this->bag->itens->count();
    }

    /**
     * Render breadcrumbs for a page with the default view.
     *
     * @param string|null $name The name of the current page.
     * @param mixed ...$params The parameters to pass to the closure for the current page.
     * @return \Illuminate\Contracts\View\View The generated view.
     */
    public function render(): View
    {
        $view = config('breadcrumbs.view');

        $breadcrumbs = $this;

        return $this->viewFactory->make($view, compact('breadcrumbs'));
    }
}
