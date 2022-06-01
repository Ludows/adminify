<div class="modal fade" id="modalDetails" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <div class="d-flex w-100 align-items-center justify-content-between">
                <div>
                    <h5 class="modal-title">{!! __('admin.media.file') !!}</h5>
                </div>
                <div>
                    <button class="btn-outline-primary btn js-modal-detail" data-type="previous">
                        previous
                    </button>
                    <button class="btn-outline-primary btn js-modal-detail" data-type="next">
                        next
                    </button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                </div>
            </div>
        </div>
        <div class="modal-body">
            @include('adminify::layouts.admin.medialibrary.previewZone', [])
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger js-single-destroy-media">{!! __('admin.media.delete_image') !!}</button>
        </div>
      </div>
    </div>
  </div>
