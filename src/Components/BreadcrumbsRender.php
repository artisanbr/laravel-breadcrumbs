<?php

namespace ArtisanLabs\Breadcrumbs\Components;

use ArtisanLabs\Breadcrumbs\Providers\Breadcrumbs;
use Illuminate\View\Component;

class BreadcrumbsRender extends Component
{

    public function render()
    {
        $breadcrumbs = Breadcrumbs::renderBag();
        $isEmpty = Breadcrumbs::isEmpty();
        return view(config('breadcrumbs.view'), compact('breadcrumbs', 'isEmpty'));
    }

}
