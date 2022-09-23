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

    protected             $bag;
    protected             $bagDefaults;
    protected ViewFactory $viewFactory;
    protected bool $ignoreDefaults = false;

    public function __construct(ViewFactory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
        $this->bag = new BreadcrumbsBag();
        $this->bagDefaults = new BreadcrumbsBag();
    }

    public function make($title, $url = null, $ignore_defaults = false): BreadcrumbsBag
    {
        $this->ignoreDefaults = $ignore_defaults;

        $this->bag->add($title, $url);
        return $this->bag();
    }

    public function defaults($title, $url = null): BreadcrumbsBag
    {
        $this->bagDefaults = new BreadcrumbsBag();
        $this->bagDefaults->add($title, $url);
        return $this->bagDefaults;
    }

    public function defaultParent($title, $url = null){
        return $this->defaultsBag()->parent($title, $url);
    }

    public function defaultAdd($title, $url = null){
        return $this->defaultsBag()->add($title, $url);
    }

    public function defaultsBag(): BreadcrumbsBag
    {
        return $this->bagDefaults;
    }

    public function bag(){
        return $this->bag;
    }

    public function add($title, $url = null){
        return $this->bag()->add($title, $url);
    }

    public function parent($title, $url = null){
        return $this->bag()->parent($title, $url);
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


    public function renderBag(): BreadcrumbsBag
    {
        $bag = new BreadcrumbsBag();

        if(!$this->ignoreDefaults){
            $bag->itens = $this->bagDefaults->itens->merge($this->bag->itens);
        }else{
            $bag->itens = $this->bag->itens;
        }

        return $bag;
    }

    public function render(): View
    {
        $view = config('breadcrumbs.view');


        $breadcrumbs = $this;
        $breadcrumbs->bag = $this->renderBag();

        return $this->viewFactory->make($view, compact('breadcrumbs'));
    }


}
