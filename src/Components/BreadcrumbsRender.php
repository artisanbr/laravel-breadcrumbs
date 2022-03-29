<?php

namespace DevApex\Breadcrumbs\Components;

use DevApex\Breadcrumbs\Providers\Breadcrumbs;
use Illuminate\View\Component;

class BreadcrumbsRender extends Component
{

    public function render()
    {
        $breadcrumbs = Breadcrumbs::bag();
        $isEmpty = Breadcrumbs::isEmpty();
        return view(config('breadcrumbs.view'), compact('breadcrumbs', 'isEmpty'));
    }

}
