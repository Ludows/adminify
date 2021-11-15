<div class="sidebar">
    <div class="row">
        <div class="col-12">
            <input type="text" class="form-control js-search-widget" placeholder="{{ __('admin.editor.search_widget') }}">
        </div>
    </div>

    <div id="widgetZone" class="row widget_zone">

        @foreach ($widgets as $widget)
            <div class="col-6">
                <div  class="card shadow js-handle">
                    <div class="card-body text-center">
                      <i class="{{ $widget->icon }}"></i>
                      <p class="card-text small text-muted">
                         {{ $widget->name }}
                      </p>
                    </div>
                </div>
            </div>
        @endforeach
       
    </div>

</div>
