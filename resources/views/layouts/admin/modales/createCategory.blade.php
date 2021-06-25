<x-adminify-modal id="{{ $id ?? 'modalCreateCategory' }}" modalClasses="" title="Créer une catégorie">

    <div class="row">
        @if($createCategory)
            <div class="col-12">
                {{--  {{ dd($form) }}  --}}
                {!! form($createCategory) !!}
            </div>
        @endif
    </div>


</x-adminify-modal>
