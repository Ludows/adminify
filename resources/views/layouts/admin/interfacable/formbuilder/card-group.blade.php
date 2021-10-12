@php
    $identifier = Str::random(10);
    $isNew = isset($new) ? $new : false;
    $title = isset($new) && $new == true ? __('admin.formbuilder.newItem') : $item->label;  
@endphp
    <div class="card">
      <div class="card-header" id="heading{{ $identifier }}">
        <h2 class="mb-0">
          <button id="titleChange{{ $identifier }}" class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            {{ $title }}
          </button>
        </h2>
      </div>
  
      <div id="collapse{{ $identifier }}" class="collapse" aria-labelledby="heading{{ $identifier }}" data-parent="#formBuilderAccordion">
        <div class="card-body">
            <div class="card text-center">
                <div class="card-header">
                  <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item">
                      <a class="nav-link active" data-block="#General{{ $identifier }}" href="#">__('admin.formbuilder.general')</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-block="#Skin{{ $identifier }}" href="#">__('admin.formbuilder.skin')</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-block="#Advanced{{ $identifier }}" href="#">__('admin.formbuilder.advanced')</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="TabContent{{ $identifier }}">
                        <div class="tab-pane fade show active" id="General{{ $identifier }}" role="tabpanel">

                        </div>
                        <div class="tab-pane fade" id="Skin{{ $identifier }}" role="tabpanel">...</div>
                        <div class="tab-pane fade" id="Advanced{{ $identifier }}" role="tabpanel">...</div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>