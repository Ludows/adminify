@php
    //dd($options);
    $isNew = isset($new) ? $new : false;
    $identifier = '__ID__';
    $title = isset($new) && $new == true ? __('admin.formbuilder.newItem') : isset($item) ?? $item->label;
@endphp
    <div class="card">
      <div class="card-header" id="heading{{ $identifier }}">
        <h2 class="mb-0">
          <button id="titleChange{{ $identifier }}" class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $identifier }}" aria-expanded="false" aria-controls="collapse{{ $identifier }}">
            {{ $title }}
          </button>
        </h2>
      </div>

      <div id="collapse{{ $identifier }}" class="collapse" aria-labelledby="heading{{ $identifier }}" data-parent="#formBuilderAccordion">
        <div class="card-body">
            <div class="card text-center">
                <div id="PreviewComponent{{ $identifier }}"></div>
                <div class="card-header">
                  <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item">
                      <a class="nav-link active" data-block="#General{{ $identifier }}" href="#">{{ __('admin.formbuilder.general') }}</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-block="#Skin{{ $identifier }}" href="#">{{ __('admin.formbuilder.skin') }}</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-block="#Advanced{{ $identifier }}" href="#">{{ __('admin.formbuilder.advanced') }}</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="TabContent{{ $identifier }}">
                        <div class="tab-pane fade show active" id="General{{ $identifier }}" role="tabpanel">
                            {{ form_row($options['children']['label']) }}
                            {{ form_row($options['children']['required']) }}
                            {{ form_row($options['children']['max_length']) }}
                        </div>
                        <div class="tab-pane fade" id="Skin{{ $identifier }}" role="tabpanel">
                            {{ form_row($options['children']['label_show']) }}
                            {{ form_row($options['children']['label_attr']) }}
                            {{ form_row($options['children']['attr']) }}
                            {{ form_row($options['children']['wrapper']) }}
                        </div>
                        <div class="tab-pane fade" id="Advanced{{ $identifier }}" role="tabpanel">...</div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
