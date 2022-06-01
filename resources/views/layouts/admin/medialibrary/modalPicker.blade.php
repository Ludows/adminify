<div class="modal fade" id="modalPicker" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{!! __('admin.media.file') !!}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-12 col-lg-7">
                  @include('adminify::layouts.admin.index.pages.mediasv2', [
                      'pageElements' => false,
                      'withModal' => false
                  ])
              </div>
              <div class="col-12 col-lg-5">
                  @include('adminify::layouts.admin.medialibrary.previewZone', [
                      'useSingleDeytroyImage' => true,
                      'cssClassPreview' => 'col-12',
                      'cssClassFormPreview' => 'col-12',
                  ])
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{!! __('admin.media.close') !!}</button>
        <button type="button" class="btn btn-primary js-select-media disabled">{!! __('admin.media.select') !!}</button>
      </div>
    </div>
  </div>
</div>
