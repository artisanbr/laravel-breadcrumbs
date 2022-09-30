<?php

namespace ArtisanLabs\Breadcrumbs\Models;

use Illuminate\Support\Collection;

class BreadcrumbsBag
{
    /**
     * @var Collection|BreadcrumbsItem[]
     */
    public $itens;

    public $list_class;
    public $item_class;
    public $item_class_active;
    public $link_class;

    public function __construct()
    {
        $this->itens = new Collection;
    }

    public function parent($title, $url = null): static
    {
        $this->beforeOf($title, $url);
        return $this;
    }

    public function add($title, $url = null): static
    {
        $this->itens->push(new BreadcrumbsItem($title, $url));
        return $this;
    }

    public function beforeOf($title, $url = null): static
    {
        $this->itens->prepend(new BreadcrumbsItem($title, $url));
        return $this;
    }
}
