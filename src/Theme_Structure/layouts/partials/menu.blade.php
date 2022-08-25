@php
    $wrapper_tag = isset($wrapper_tag) ? $wrapper_tag : 'ul';
    $wrapper_class = isset($wrapper_class) ? $wrapper_class : 'navbar-nav';
    $item_tag = isset($item_tag) ? $item_tag : 'li';
    $item_class = isset($item_class) ? $item_class : 'nav-item';
    $link_tag = isset($link_tag) ? $link_tag : 'a';
    $link_class = isset($link_class) ? $link_class : 'nav-link';
    $active_class = isset($active_class) ? $active_class : 'active';
    $items = isset($items) ? $items : [];
@endphp

<{!! $wrapper_tag !!} class="{!! $wrapper_class !!}">

    @foreach ($items as $item)

        @if($item->type == 'custom')
            <{!! $item_tag !!} class="{!! $item_class !!}">
                <{!! $link_tag !!} class="{!! $link_class !!}" aria-current="page" target="{!! $item->open_new_tab == 0 ? '_self' : '_blank'  !!}" href="{{  $item->related->url }}">
                    {{ empty($item->overwrite_title) ? $item->related->title : $item->overwrite_title }}
                </{!! $link_tag !!}>
            </{!! $item_tag !!}>
            @if(!empty($item->childs))
                @include('theme::'. $theme .'.layouts.partials.menu', [
                    'items' => $item->childs
                ])
            @endif

        @else
            <{!! $item_tag !!} class="{!! $item_class !!}">
                <{!! $link_tag !!} class="{!! $link_class !!} {!! $request->is( join('/', $item->related->url)) ? $active_class : ''  !!}" aria-current="page" target="{!! $item->open_new_tab == 0 ? '_self' : '_blank'  !!}" href="{{  $item->related->urlpath }}">
                    {{ empty($item->overwrite_title) ? $item->related->title : $item->overwrite_title }}
                </{!! $link_tag !!}>
            </{!! $item_tag !!}>

            @if(!empty($item->childs))
                @include('theme::'. $theme .'.layouts.partials.menu', [
                    'items' => $item->childs
                ])
            @endif
        @endif

    @endforeach

</{!! $wrapper_tag !!}>
