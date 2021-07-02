<x-adminify-modal id="{{ $id ?? 'globalSearch' }}" modalClasses="" title="{{ __('admin.global_search') }}">
    <form method="POST" action="{{ route('searchable') }}" class="">
        @csrf
        <div class="form-group mb-0">
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input id="js-search-entity" class="form-control" placeholder="{{ __('admin.search') }}" type="text">
            </div>
        </div>
    </form>
    <div id="appendSearchable"></div>
</x-adminify-modal>
