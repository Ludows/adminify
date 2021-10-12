{!! form_start($form) !!}
    <div class="card">
        <div class="card-header">
            {!! form_row($form->title) !!}
        </div>
        <div class="card-body">
            <div class="row js-dropzone">
                <div class="#Accordion_zone">
                    <div class="accordion" id="formBuilderAccordion">
                        @if(!empty($query))
    
                        @else
                            Create your fields
                        @endif
                    </div>
                    
                </div>
                
                
            </div>
        </div>
    </div>
{!! form_end($form, false) !!}

