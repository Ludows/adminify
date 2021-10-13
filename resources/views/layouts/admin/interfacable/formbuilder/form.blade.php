{!! form_start($form) !!}
    <div class="card">
        <div class="card-header">
            {!! form_row($form->title) !!}
        </div>
        <div class="card-body">
            <div class="row js-dropzone">
                <div id="Accordion_zone">
                    <div class="accordion" id="formBuilderAccordion">
                        @if($isCreate && empty($query))
                            {{--  // aucun champ et c'est une création  --}}
                            {{ __('admin.formbuilder.noFields') }}
                        @endif
                        @if(!empty($query) && !$isCreate)
                            @foreach ($query as $field)
                                @include('adminify::layouts.admin.interfacable.formbuilder.card-group', [
                                    'item' => $field,
                                    'fields' => $form->fields->getChildren()[0],
                                    'index' => $loop->index
                                ])
                            @endforeach
                        @endif
                    </div>

                </div>


            </div>
        </div>
    </div>
{!! form_end($form, false) !!}

