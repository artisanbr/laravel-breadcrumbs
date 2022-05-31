<?php
/**
 * @var \DevApex\Breadcrumbs\Models\BreadcrumbsBag $breadcrumbs
 */
?>
@unless ($isEmpty ?? false)
    @section('title', $breadcrumbs->itens->last()->title)
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb {{ $breadcrumbs->list_class }}">
            @foreach ($breadcrumbs->itens as $breadcrumb)
                @if (!$loop->last)
                    <li class="breadcrumb-item {{ $breadcrumbs->item_class }}">
                        @if($breadcrumb->url)
                        <a href="{{ $breadcrumb->url }}" class="{{ $breadcrumbs->link_class }}">
                            {{ $breadcrumb->title }}
                        </a>
                        @else
                            {{ $breadcrumb->title }}
                        @endif
                    </li>
                @else
                    <li class="breadcrumb-item active {{ $breadcrumbs->item_class_active }}" aria-current="page">{{ $breadcrumb->title }}</li>
                @endif

            @endforeach
        </ol>
    </nav>
@endunless
