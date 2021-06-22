@php
    $identifier = Str::random(10);
@endphp
{{-- {{ dd($item->related) }} --}}
<li class="list-group-item" id="list-group-item-{{ $identifier }}" data-target="#collapse-{{ $identifier }}" aria-expanded="false" aria-controls="collapse-{{ $identifier }}">
    <span data-replace="{{ $item->related->title }}" class="handle handle-click-collapse d-block">{{ $item->related->title }}</span>
    <div class="collapse js-collapse" id="collapse-{{ $identifier }}">
        <div class="card card-body">
            <input type="hidden" menu-three-key="menu-item-id" value="{{ $item->id }}"/>
            <input type="hidden" menu-three-key="id" value="{{ $item->related->id }}"/>
            <input type="hidden" menu-three-key="type" value="{{ $item->type }}"/>
            <input type="hidden" menu-three-key="delete" value="0"/>
            <input type="hidden" menu-three-key="title" value="{{ $item->related->title }}"/>
            <input type="hidden" menu-three-key="slug" value="{{ $item->related->slug }}"/>
            <div class="form-group">
                <label for="title_nav_{{ $identifier }}">Titre de navigation @todo trad</label>
                <input type="text" menu-three-key="overwrite_title" data-sel="#list-group-item-{{ $identifier }} .handle-click-collapse" value="{{ $item->overwrite_title }}" class="form-control js-change-title" id="title_nav_{{ $identifier }}">
            </div>
            <div class="call_media" id="media-{{ $identifier }}">
                <div class="row row-selection"></div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary">Call Media @trad</button>
                    <input type="hidden" data-path="{{ $item->media->path ?? '' }}" menu-three-key="media_src" value="{{ $item->media->src ?? '' }}" />
                </div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input {{ $item->open_new_tab == 1 ? 'checked="checked"' : '' }} menu-three-key="open_new_tab" class="form-check-input" type="checkbox" value="" id="openOnglet_{{ $identifier }}">
                    <label class="form-check-label" for="openOnglet_{{ $identifier }}">
                        Ouvrir dans un autre onglet ? @trad
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="classes_{{ $identifier }}">Classes @todo trad</label>
                <input value="{{ $item->class }}" menu-three-key="class" type="text" class="form-control" id="classes_{{ $identifier }}">
            </div>
        </div>
        <div class="card-footer">
            <a href="#" data-el="list-group-item-{{ $identifier }}" class="text-underline js-suppress text-danger">Supprimer @trad</a>
            <a href="#" data-el="collapse-{{ $identifier }}" class="text-underline js-close text-default">Fermer @trad</a>
        </div>
    </div>
    <ul style="width:80%; border: 1px solid transparent;" id="nested-sortable-{{ $identifier }}" class="nested_sortable list-group">
        @if(isset($item->childs))
            @foreach($item->childs as $child)
                @include('layouts.admin.menubuilder.menu-item', ['item' => $child])
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


