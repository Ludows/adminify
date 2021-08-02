<x-adminify-modal id="{{ $id ?? 'modalSaveTemplate' }}" modalClasses="" title="{{ __('admin.model.title') }}">

    <div class="row">
        @if($saveTemplate)
            <div class="col-12">
                {{--  {{ dd($form) }}  --}}
                {!! form($saveTemplate) !!}
            </div>
        @endif
    </div>


</x-adminify-modal>
