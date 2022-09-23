
@php
$isMulti = isset($multiple) ? $multiple : false;
$selectionMode = isset($isSelectionMode) ? $isSelectionMode : false;
@endphp
<style>
    #modalPicker {
        padding: 0 !important; // override inline padding-right added from js
      }
       #modalPicker .modal-dialog {
        width: 100%;
        max-width: none;
        height: 100%;
        margin: 0;
      }
       #modalPicker .modal-content {
        height: 100%;
        border: 0;
        border-radius: 0;
      }
       #modalPicker .modal-body {
        overflow-y: auto;
      }

      #modalPicker .js-modal-details img {
        border: 4px solid transparent;
      }
      #modalPicker .js-modal-details.selected img {
        border-color: var(--primary)
      }
</style>
<div class="modal fade" id="modalPicker" tabindex="-1">
<div class="modal-dialog modal-xl">
<div class="modal-content">
  <div class="modal-header border-bottom">
    <h5 class="modal-title">{!! __('admin.media.file') !!}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
      <div class="row no-gutters">
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
