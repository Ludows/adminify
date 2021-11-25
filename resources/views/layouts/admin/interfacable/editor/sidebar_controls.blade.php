<div class="sidebar sidebar_controls">
    <ul class="nav nav-pills bg-secondary sticky-top mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="pills-global-settings-tab" data-toggle="pill" href="#global-settings-tab" role="tab" aria-controls="global-settings-tab" aria-selected="true">Global Settings</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="pills-blocs-settings-tab" data-toggle="pill" href="#blocs-settings-tab" role="tab" aria-controls="blocs-settings-tab" aria-selected="false">Bloc</a>
        </li>
      </ul>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="global-settings-tab" role="tabpanel" aria-labelledby="pills-global-settings-tab">
            {!! form($form) !!}
        </div>
        <div class="tab-pane fade" id="blocs-settings-tab" role="tabpanel" aria-labelledby="pills-blocs-settings-tab">
            <div class="js-no-bloc-selected d-block h3 text-center border p-3 rounded">
                {{ __('admin.editor.noBlocSelected') }}
            </div>
        </div>
      </div>
</div>
