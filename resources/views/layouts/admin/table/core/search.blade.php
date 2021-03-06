@php
 $showCreate = isset($showCreate) ? $showCreate : true;
 $showSearchBar = isset($showSearchBar) ? $showSearchBar : true;

@endphp
<div class="col d-flex justify-content-end align-items-center text-right">
    @if(isset($showSearchBar) && $showSearchBar)
        <input id="" class="form-control js-search-entity" placeholder="{{ __('admin.table.modules.search', ['entity' => $name]) }}" type="text">
    @endif
    @if(isset($showCreate) && $showCreate)
        <div class="ml-lg-3 mt-3 mt-lg-0">
            @php
                $a = [];
                if($useMultilang) {
                    $a['lang'] = $currentLang;
                }
            @endphp
            <a href="{{ route($name.'.create', $a) }}" class="btn btn-sm btn-primary"> {{ __('admin.table.modules.btn_create', ['entity' => $name]) }}</a>
        </div>
    @endif
</div>
