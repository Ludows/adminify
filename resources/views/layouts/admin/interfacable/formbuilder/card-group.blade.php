@php
    if(isset($options['is_prototype']) && $options['is_prototype']) {
        $new = true;
    }

    $unique = uuid(20);

    $isNew = isset($new) ? $new : false;
    $identifier = '__NAME__';
    $functionnal_identifier = '__FUNCTIONAL__';
    $title = isset($new) && $new == true ? __('admin.formbuilder.newItem') : isset($item) ?? $item->label;
@endphp

    <div style="display:none;" id="card{{ $functionnal_identifier }}" class="card">
      <div class="card-header" id="heading{{ $functionnal_identifier }}">
        <h2 class="mb-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <button data-original-label="{{ $title }}" id="titleChange{{ $functionnal_identifier }}" class="btn btn-link btn-block text-left js-handle" type="button" data-toggle="collapse" data-target="#collapse{{ $functionnal_identifier }}" aria-expanded="false" aria-controls="collapse{{ $functionnal_identifier }}">
                        {{ $title }}
                    </button>
                </div>
                <div>
                    <button data-functional="{{ $functionnal_identifier }}" {!! !$isNew ? "data-field-id='". $item->id ."'" : ''  !!} class="btn btn-danger js-delete" data-toggle="tooltip" data-placement="top" title="{{ __('admin.formbuilder.delete') }}" type="button"><i style="font-size:14px" class="ni ni-fat-remove"></i></button>
                    <button data-functional="{{ $functionnal_identifier }}" {!! !$isNew ? "data-field-id='". $item->id ."'" : ''  !!} class="btn btn-secondary js-dupplicate" data-toggle="tooltip" data-placement="top" title="{{ __('admin.formbuilder.dupplicate') }}" type="button"><i style="font-size:14px" class="ni ni-single-copy-04"></i></button>
                </div>
            </div>

        </h2>
      </div>

      <div id="collapse{{ $functionnal_identifier }}" class="collapse" aria-labelledby="heading{{ $functionnal_identifier }}" data-parent="#formBuilderAccordion">
        <div class="card-body p-0">
            <div class="card shadow-none">
                <div class="p-4 bg-secondary" id="PreviewComponent{{ $functionnal_identifier }}"></div>
                <div class="card-header">
                  <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#General{{ $functionnal_identifier }}">{{ __('admin.formbuilder.general') }}</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#Skin{{ $functionnal_identifier }}">{{ __('admin.formbuilder.skin') }}</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="TabContent{{ $functionnal_identifier }}">
                        <div class="tab-pane fade show active" id="General{{ $functionnal_identifier }}" role="tabpanel">
                            {!! form_row($options['children']['field_type'], [
                                'attr' => [
                                    'datatype' => '__TOREPLACE__',
                                    'data-functional' => $functionnal_identifier,
                                    'data-replace' => 'fields[__REPLACE__][field_type]'
                                ]
                            ]) !!}
                            {!! form_row($options['children']['multiple'], [
                                'attr' => [
                                    'data-functional' => $functionnal_identifier,
                                    'data-replace' => 'fields[__REPLACE__][multiple]'
                                ]
                            ]) !!}
                            {!! form_row($options['children']['expanded'], [
                                'attr' => [
                                    'data-functional' => $functionnal_identifier,
                                    'data-replace' => 'fields[__REPLACE__][expanded]'
                                ]
                            ]) !!}
                            {!! form_row($options['children']['choices'], [
                                'wrapper' => [
                                    'id' => 'choices_'.$functionnal_identifier,
                                ],
                                'attr' => [
                                    'data-functional' => $functionnal_identifier,
                                    'data-replace' => 'fields[__REPLACE__][choices]'
                                ]
                            ]) !!}
                            {!! form_row($options['children']['selected'], [
                                'wrapper' => [
                                    'id' => 'selected_'.$functionnal_identifier,
                                ],
                                'attr' => [
                                    'data-functional' => $functionnal_identifier,
                                    'data-replace' => 'fields[__REPLACE__][selected]'
                                ]
                            ]) !!}
                            {!! form_row($options['children']['max_length'], [
                                'wrapper' => [
                                    'id' => 'max_length_'.$functionnal_identifier,
                                ],
                                'attr' => [
                                    'data-functional' => $functionnal_identifier,
                                    'data-replace' => 'fields[__REPLACE__][max_length]'
                                ]
                            ]) !!}

                            {!! form_row($options['children']['value'], [
                                'wrapper' => [
                                    'id' => 'value_'.$functionnal_identifier,
                                ],
                                'attr' => [
                                    'data-functional' => $functionnal_identifier,
                                    'data-replace' => 'fields[__REPLACE__][value]'
                                ]
                            ]) !!}

                            {!! form_row($options['children']['default_value'], [
                                'wrapper' => [
                                    'id' => 'default_value_'.$functionnal_identifier,
                                ],
                                'attr' => [
                                    'data-replace' => 'fields[__REPLACE__][default_value]'
                                ]
                            ]) !!}

                            {!! form_row($options['children']['label_show'], [
                                'attr' => [
                                    'data-functional' => $functionnal_identifier,
                                    'data-replace' => 'fields[__REPLACE__][label_show]'
                                ]
                            ]) !!}

                            {!! form_row($options['children']['checked'], [
                                'wrapper' => [
                                    'id' => 'checked_'.$functionnal_identifier,
                                ],
                                'attr' => [
                                    'data-functional' => $functionnal_identifier,
                                    'data-replace' => 'fields[__REPLACE__][checked]'
                                ]
                            ]) !!}

                            {!! form_row($options['children']['required'], [
                                'attr' => [
                                    'data-functional' => $functionnal_identifier,
                                    'data-replace' => 'fields[__REPLACE__][required]'
                                ]
                            ]) !!}
                        </div>
                        <div class="tab-pane fade" id="Skin{{ $functionnal_identifier }}" role="tabpanel">
                            {!! form_row($options['children']['label_attr'], [
                                'attr' => [
                                    'data-functional' => $functionnal_identifier,
                                    'data-replace' => 'fields[__REPLACE__][label_attr]'
                                ]
                            ]) !!}
                            {!! form_row($options['children']['attr'], [
                                'attr' => [
                                    'data-location' => '#example_'.$functionnal_identifier,
                                    'data-functional' => $functionnal_identifier,
                                    'data-replace' => 'fields[__REPLACE__][attr]'
                                ]
                            ]) !!}
                            {!! form_row($options['children']['wrapper'], [
                                'attr' => [
                                    'data-functional' => $functionnal_identifier,
                                    'data-replace' => 'fields[__REPLACE__][wrapper]'
                                ]
                            ]) !!}
                            {!! form_row($options['children']['custom_error_message'], [
                                'attr' => [
                                    'data-functional' => $functionnal_identifier,
                                    'data-replace' => 'fields[__REPLACE__][custom_error_message]'
                                ]
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
