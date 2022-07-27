<?php
/**
 * @var \DevApex\Breadcrumbs\Models\BreadcrumbsBag $breadcrumbs
 */
?>
@unless ($isEmpty ?? false)
    @section('title', $breadcrumbs->itens->last()->title)

    <ul class="breadcrumb breadcrumb-separatorless {{ $breadcrumbs->list_class }}">
        @foreach ($breadcrumbs->itens as $breadcrumb)

            <li class="breadcrumb-item {{ $breadcrumbs->item_class }} {{ $loop->last ? $breadcrumbs->item_class_active : '' }}">
                @if($breadcrumb->url && !$loop->last)
                    <a href="{{ $breadcrumb->url }}" class="{{ $breadcrumbs->link_class }}">
                        {{ $breadcrumb->title }}
                    </a>
                @else
                    {{ $breadcrumb->title }}
                @endif
            </li>

            @if (!$loop->last)
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
            @endif

        @endforeach
    </ul>
@endunless
