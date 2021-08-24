@php
    $identifier = Str::random(10);
    $isNew = isset($new) ? $new : false;
    $title = isset($new) && $new == true ? $item->title : $item->related->title;

    $id = null;
    if(!$isCustom && $isNew) {
        $id = $item->id;
    }
    elseif(!$isNew) {
        $id = $item->related->id;
    }
    
    $type = isset($type) ? $type : $item->type;
    $slug = isset($new) && $new == true ? $item->slug : $item->related->slug;
    
@endphp
{{-- {{ dd($item->related) }} --}}
<li class="list-group-item p-0" id="list-group-item-{{ $identifier }}" data-target="#collapse-{{ $identifier }}" aria-expanded="false" aria-controls="collapse-{{ $identifier }}">
    <span data-replace="{{ $title }}" class="handle handle-click-collapse d-block p-3">{{ $title }}</span>
    <div class="collapse js-collapse mt-3" id="collapse-{{ $identifier }}">
        <div class="card mb-0">
            <div class="card-body">
            @if(isset($new) && $new == false)
                <input type="hidden" menu-three-key="menu-item-id" value="{{ $item->id }}"/>
            @endif
            @if(!$isCustom && $isNew)
                <input type="hidden" menu-three-key="id" value="{{ $id }}"/>
            @elseif(!$isNew)
                <input type="hidden" menu-three-key="id" value="{{ $id }}"/>
            @endif
            <input type="hidden" menu-three-key="type" value="{{ $type }}"/>
            <input type="hidden" menu-three-key="delete" value="{{ $isNew ? 1 : 0 }}"/>
            <input type="hidden" menu-three-key="title" value="{{ $title }}"/>
            <input type="hidden" menu-three-key="slug" value="{{ $slug }}"/>
            <div class="form-group">
                <label for="title_nav_{{ $identifier }}">{{ __('admin.form.title_navigation') }}</label>
                <input type="text" menu-three-key="overwrite_title" data-sel="#list-group-item-{{ $identifier }} .handle-click-collapse" value="{{ $item->overwrite_title }}" class="form-control js-change-title" id="title_nav_{{ $identifier }}">
            </div>
            <div class="call_media" id="media-{{ $identifier }}">
                <div class="row row-selection"></div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary">{{ __('admin.form.select_media') }}</button>
                    <input type="hidden" data-path="{{ $item->media->path ?? '' }}" menu-three-key="media_id" value="{{ $item->media->id ?? '' }}" />
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input {{ $item->open_new_tab == 1 && $item instanceof \Ludows\Adminify\Models\MenuItem ? 'checked="checked"' : '' }} menu-three-key="open_new_tab"  type="checkbox" class="custom-control-input" id="openOnglet_{{ $identifier }}">
                    <label for="openOnglet_{{ $identifier }}"  class="custom-control-label">{{ __('admin.form.open_other_tab') }}</label>
                </div>
            </div>
            <div class="form-group">
                <label for="classes_{{ $identifier }}">{{ __('admin.form.css_classes') }}</label>
                <input value="{{ $item->class ?? '' }}" menu-three-key="class" type="text" class="form-control" id="classes_{{ $identifier }}">
            </div>
        </div>
    </div>
        <div class="card-footer bg-secondary">
            <a href="#"{!! !$isNew ? 'data-menuitem-id="'.$id.'"' : '' !!} data-el="list-group-item-{{ $identifier }}" class="text-underline js-suppress text-danger">{{ __('admin.form.delete') }}</a>
            <a href="#" data-el="collapse-{{ $identifier }}" class="text-underline js-close text-default">{{ __('admin.form.close_menu_item') }}</a>
        </div>
    </div>
    <ul style="width:80%; border: 1px solid transparent;" id="nested-sortable-{{ $identifier }}" class="nested_sortable list-group">
        @if(isset($item->childs))
            @foreach($item->childs as $child)
                @include('adminify::layouts.admin.menubuilder.menu-item', ['item' => $child, 'new' => false, 'isCustom' => $type == 'custom'])
            @endforeach
        @endif
    </ul>
</li>

@push('js')
    <script>
        window.admin.lfmFields.push({
            selector: "media-{{ $identifier }}",
            options: [],
            multilang: {!! $useMultilang !!},
            currentLang: '{!! $currentLang !!}'
        })
    </script>
@endpush


