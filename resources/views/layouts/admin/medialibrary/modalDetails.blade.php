<div class="modal fade" id="modalDetails" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <div class="d-flex w-100 align-items-center justify-content-between">
                <div>
                    <h5 class="modal-title">{!! __('admin.media.file') !!}</h5>
                </div>
                <div>
                    <button class="btn-outline-primary btn js-previous-detail">
                        previous
                    </button>
                    <button class="btn-outline-primary btn js-next-detail">
                        next
                    </button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-5">
                    <img id="imageOriginal" class="img-fluid" alt="" src="">
                </div>
                <div class="col-lg-7">
                    <form method="POST" action="#">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control js-metadatas" placeholder="{!! __('admin.media.description') !!}"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control js-metadatas" placeholder="{!! __('admin.media.alt') !!}"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{--  <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{!! __('admin.media.close') !!}</button>
          <button type="button" class="btn btn-primary disabled">{!! __('admin.media.select') !!}</button>
        </div>  --}}
      </div>
    </div>
  </div>
