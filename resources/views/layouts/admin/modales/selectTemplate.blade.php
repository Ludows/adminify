<x-adminify-modal id="{{ $id ?? 'modalSelectTemplate' }}" modalClasses="" title="{{ __('admin.model.title') }}">

    <div class="row">
        @if($selectTemplate)
            <div class="col-12">
                {{--  {{ dd($form) }}  --}}
                {!! form($selectTemplate) !!}
            </div>
        @endif
    </div>


</x-adminify-modal>
