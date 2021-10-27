{!! form_start($form) !!}
    <div class="card">
        {!! form_row($form->user_id) !!}
        <div class="card-header">
            {!! form_row($form->title) !!}
        </div>
        <div class="card-body">
            <div class="row js-dropzone">
                <div id="Accordion_zone" class="col-12">
                    <div class="accordion" id="formBuilderAccordion">
                        @php
                            $errors = session()->get('errors');
                        @endphp
                        @if(isset($errors))
                            <div id="alertNoFields" class="alert alert-danger">
                                {!! !empty($errors) ? $errors->first() : '' !!}
                            </div>
                        @endif

                        @if($isCreate && empty($query))
                            {{--  // aucun champ et c'est une création  --}}
                            <span id="noFieldsText">{{ __('admin.formbuilder.noFields') }}</span>
                        @endif
                         @if(!empty($query) && !$isCreate)
                            @foreach ($query as $field)
                               {!! form_row($form->fields) !!}
                            @endforeach
                        @endif 
                    </div>

                </div>


            </div>
        </div>
        <div class="card-footer">
            {!! form_row($form->submit) !!}
        </div>
    </div>

    <div id="prototypeField" class="d-none" data-proto="{{ form_row($form->fields->prototype()) }}"></div>
{!! form_end($form, false) !!}

