<div class="col d-flex justify-content-between align-items-center text-right">
    <input id="" class="form-control js-search-entity" placeholder="Search" type="text">
    @if($showCreate)
        <div class="ml-lg-3 mt-3 mt-lg-0">
            <a href="{{ route($name.'.create', ['lang' => $useMultilang ? $currentLang : '']) }}" class="btn btn-sm btn-primary"> {{ __('admin.'.$name.'.create') }}</a>
        </div>
    @endif
</div>