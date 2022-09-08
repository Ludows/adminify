<div id="{{ $options['sibling'] }}">
    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif

    @if($showLabel && $options['label'] !== false && $options['label_show'])
        {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
    @endif

    @if($showField)
            <div class="accordion" id="accordion-{{ $options['sibling'] }}">
                @foreach ( (array)$options['children'] as $child )
                    <div class="card">
                        <div class="card-header" id="heading{{ $loop->index }}">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $loop->index }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse{{ $loop->index }}">
                                    Item {!! $loop->index !!}
                                </button>
                            </h2>
                        </div>

                        <div id="collapse{{ $loop->index }}" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ $loop->index }}" data-parent="#accordion-{{ $options['sibling'] }}">
                            <div class="card-body">
                                {{--  {!! dd($child->getForm()) !!}  --}}
                                @php
                                    // now we retrieve the form class from collectiontype
                                    $childForm = $child->getForm();
                                    //now we get all fields
                                    $childFields = $childForm->getFields();
                                    //dd($childFields);
                                @endphp
                                @foreach ($childFields as $key => $field)
                                    {!! form_row($childForm->{$key}) !!}
                                @endforeach
                                {{--  {!! form($child->getForm()) !!}  --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary js-add-row">Add Item</button>
            </div>

        <div class="collection-container" data-prototype="{{ form_row($options['currentForm']->{$options['name']}->prototype()) }}"></div>

        @include('vendor/laravel-form-builder/errors')
        @include('vendor/laravel-form-builder/help_block')
    @endif
    @if($options['wrapper'] !== false)
        </div>
    @endif

    @if ($options['isAjax'])
        <script type="text/javascript">
            $(function() {
                let Sibling_text = "{{ $options['sibling'] }}";
                let Sibling = $('#'+Sibling_text);
                let Collection_container = Sibling.find('.collection-container');
                let Accordion = Sibling.find('#accordion-{{ $options["sibling"] }}');
                let btnAdd = Sibling.find('.js-add-row');
                let scopedTemplateAccordionItem = '{!! $options["accordion_item"] !!}';
                let required_fields = Sibling.find('[required="required"]');
                btnAdd.on('click', function(e) {
                    e.preventDefault();
                    var count = Accordion.children().length;
                    console.log('count', count)
                    var proto = Collection_container.data('prototype').replace(/{{ $options['prototype_name'] }}/g, count);
                    var proto_item = scopedTemplateAccordionItem.replace(/{{ $options['prototype_name'] }}/g, count).replace(/##FORM##/g, proto).replace(/##SIBLING##/g, Sibling_text);
                    Accordion.append(proto_item);
                    required_fields = Sibling.find('[required="required"]');
                })
            })
        </script>
    @else
        @push('js')
            <script type="text/javascript">
                $(function() {
                    let Sibling_text = "{{ $options['sibling'] }}";
                    let Sibling = $('#'+Sibling_text);
                    let Collection_container = Sibling.find('.collection-container');
                    let Accordion = Sibling.find('#accordion-{{ $options["sibling"] }}');
                    let btnAdd = Sibling.find('.js-add-row');
                    let scopedTemplateAccordionItem = '{!! $options["accordion_item"] !!}';
                    let required_fields = Sibling.find('[required="required"]');
                    btnAdd.on('click', function(e) {
                        e.preventDefault();
                        var count = Accordion.children().length;
                        console.log('count', count)
                        var proto = Collection_container.data('prototype').replace(/{{ $options['prototype_name'] }}/g, count);
                        var proto_item = scopedTemplateAccordionItem.replace(/{{ $options['prototype_name'] }}/g, count).replace(/##FORM##/g, proto).replace(/##SIBLING##/g, Sibling_text);
                        Accordion.append(proto_item);
                        required_fields = Sibling.find('[required="required"]');
                    })
                })
            </script>
        @endpush
    @endif
</div>
