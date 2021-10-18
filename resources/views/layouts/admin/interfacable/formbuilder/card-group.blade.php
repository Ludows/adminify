@php
    if(isset($options['is_prototype']) && $options['is_prototype']) {
        $new = true;
    }

    $isNew = isset($new) ? $new : false;
    $identifier = '__NAME__';
    $title = isset($new) && $new == true ? __('admin.formbuilder.newItem') : isset($item) ?? $item->label;
@endphp
    <div id="card{{ $identifier }}" class="card">
      <div class="card-header" id="heading{{ $identifier }}">
        <h2 class="mb-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <button id="titleChange{{ $identifier }}" class="btn btn-link btn-block text-left js-handle" type="button" data-toggle="collapse" data-target="#collapse{{ $identifier }}" aria-expanded="false" aria-controls="collapse{{ $identifier }}">
                        {{ $title }}
                    </button>
                </div>
                <div>
                    <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="{{ __('admin.formbuilder.delete') }}" type="button"><i style="font-size:14px" class="ni ni-fat-remove"></i></button>
                    <button class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="{{ __('admin.formbuilder.dupplicate') }}" type="button"><i style="font-size:14px" class="ni ni-single-copy-04"></i></button>
                </div>
            </div>

        </h2>
      </div>

      <div id="collapse{{ $identifier }}" class="collapse" aria-labelledby="heading{{ $identifier }}" data-parent="#formBuilderAccordion">
        <div class="card-body p-0">
            <div class="card shadow-none">
                <div class="p-4 bg-secondary" id="PreviewComponent{{ $identifier }}"></div>
                <div class="card-header">
                  <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#General{{ $identifier }}">{{ __('admin.formbuilder.general') }}</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#Skin{{ $identifier }}">{{ __('admin.formbuilder.skin') }}</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="TabContent{{ $identifier }}">
                        <div class="tab-pane fade show active" id="General{{ $identifier }}" role="tabpanel">
                            {!! form_row($options['children']['label']) !!}
                            {!! form_row($options['children']['choices']) !!}
                            {!! form_row($options['children']['max_length']) !!}
                            {!! form_row($options['children']['default_value']) !!}

                            {!! form_row($options['children']['label_show']) !!}
                            {!! form_row($options['children']['required']) !!}
                        </div>
                        <div class="tab-pane fade" id="Skin{{ $identifier }}" role="tabpanel">
                            {!! form_row($options['children']['label_attr']) !!}
                            {!! form_row($options['children']['attr']) !!}
                            {!! form_row($options['children']['wrapper']) !!}
                            {!! form_row($options['children']['custom_error_message']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
