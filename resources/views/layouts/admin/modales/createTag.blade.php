<x-adminify-modal id="{{ $id ?? 'modalCreateTag' }}" modalClasses="" title="{{ __('admin.model.title') }}">

    <div class="row">
        @if($createTag)
            <div class="col-12">
                {{--  {{ dd($form) }}  --}}
                {!! form($createTag) !!}
            </div>
        @endif
    </div>


</x-adminify-modal>
