<?php
namespace ArtisanLabs\Breadcrumbs\Models;

class BreadcrumbsItem
{
    public $title;
    /**
     * @var null
     */
    public $url;

    public function __construct($title, $url = null)
    {

        $this->title = $title;
        $this->url = $url;
    }
}
