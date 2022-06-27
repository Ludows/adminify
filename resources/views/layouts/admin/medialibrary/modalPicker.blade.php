
@php
$isMulti = isset($multiple) ? $multiple : false;
$selectionMode = isset($isSelectionMode) ? $isSelectionMode : false;
@endphp
<div class="modal fade" id="modalPicker" tabindex="-1">
<div class="modal-dialog modal-xl">
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
              @include('adminify::layouts.admin.index.pages.medias', [
                  'pageElements' => false,
                  'withModal' => false,
                  'isSelectionMode' => $selectionMode,
                  'multiple' => $isMulti
              ])
          </div>
          <div id="previewBlock" class="col-12 col-lg-5 invisible">
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
