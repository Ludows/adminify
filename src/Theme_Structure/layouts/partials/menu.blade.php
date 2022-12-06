@php
    $wrapper_tag = isset($wrapper_tag) ? $wrapper_tag : 'ul';
    $wrapper_class = isset($wrapper_class) ? $wrapper_class : 'navbar-nav';
    $item_tag = isset($item_tag) ? $item_tag : 'li';
    $item_class = isset($item_class) ? $item_class : 'nav-item';
    $link_tag = isset($link_tag) ? $link_tag : 'a';
    $link_class = isset($link_class) ? $link_class : 'nav-link';
    $active_class = isset($active_class) ? $active_class : 'active';
    $items = isset($items) ? $items : [];
    $renderItem = true;
    $beforeRender = function($item) {
        return $item;
    }
    $config_childs = isset($config_childs) && is_array($config_childs) ? $config_childs : [];
@endphp

<{!! $wrapper_tag !!} class="{!! $wrapper_class !!}">

    @foreach ($items as $item)

        @if(!empty($renderIf))
            @php
                $results_of_render = $renderIf($item);
                if(is_bool($results_of_render)) {
                    $renderItem = $results_of_render;
                }
            @endphp
        @endif

        @if($renderItem)

            @php
                $result_of_item = $beforeRender($item);
                if($result_of_item) {
                    $item = $result_of_item;
                }
            @endphp
        
            @if($item->type == 'custom')
                <{!! $item_tag !!} class="{!! $item_class !!}">
                    <{!! $link_tag !!} class="{!! $link_class !!}" aria-current="page" target="{!! $item->open_new_tab == 0 ? '_self' : '_blank'  !!}" href="{{  $item->related->url }}">
                        {{ empty($item->overwrite_title) ? $item->related->title : $item->overwrite_title }}
                    </{!! $link_tag !!}>
                </{!! $item_tag !!}>
                @if(!empty($item->childs))
                    @include('theme::'. $theme .'.layouts.partials.menu', array_merge([
                        'items' => $item->childs
                    ], $config_childs))
                @endif

            @else
                <{!! $item_tag !!} class="{!! $item_class !!}">
                    <{!! $link_tag !!} class="{!! $link_class !!} {!! $request->is( join('/', $item->related->url)) ? $active_class : ''  !!}" aria-current="page" target="{!! $item->open_new_tab == 0 ? '_self' : '_blank'  !!}" href="{{  $item->related->urlpath }}">
                        {{ empty($item->overwrite_title) ? $item->related->title : $item->overwrite_title }}
                    </{!! $link_tag !!}>
                </{!! $item_tag !!}>

                @if(!empty($item->childs))
                    @include('theme::'. $theme .'.layouts.partials.menu', array_merge([
                        'items' => $item->childs
                    ], $config_childs))
                @endif
            @endif
        @endif

    @endforeach

</{!! $wrapper_tag !!}>
