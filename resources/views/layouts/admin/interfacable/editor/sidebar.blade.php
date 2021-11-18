<div class="sidebar sidebar_widgets">
    <div class="row">
        <div class="col-12">
            <input type="text" class="form-control js-search-widget" placeholder="{{ __('admin.editor.search_widget') }}">
        </div>
    </div>

    <div id="widgetZone" class="row widget_zone">

        @foreach ($widgets as $widgetKeyName  => $widget)

            @php
                $getAssets = $widget->addEditorAsset();
            @endphp

            @if(!empty($getAssets['css']))
                @foreach ($getAssets['css'] as $cssPath)
                    <link type="rel/stylesheet" href="{{ $cssPath }}">
                @endforeach
            @endif

            @if(!empty($getAssets['js']))
                @foreach ($getAssets['js'] as $jsPath)
                    <script type="text/javascript" src="{{ $jsPath }}"></script>
                @endforeach
            @endif
            <div class="col-6">
                <div data-widget="{{ $widgetKeyName }}" class="card shadow js-handle">
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
