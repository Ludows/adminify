{{--  <x-modal></x-modal>  --}}

<div class="modal fade {{ $modalClasses ?? '' }}" tabindex="-1" role="dialog" id="{{ $id ?? '' }}">
    <div class="modal-dialog {{ $modalDialogClasses ?? '' }}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body {{ $modalBodyClass }}">
                {!! $slot !!}
            </div>
            @if(isset($btnSave) && $btnSave != "" || isset($btnClear) && $btnClear != "")
                <div class="modal-footer">
                    <?php if(isset($btnSave) && $btnSave != "") { ?>
                        <button type="button" class="btn js-accept btn-primary disabled">{{ $btnSave }}</button>
                    <?php } ?>
                    <?php if(isset($btnClear) && $btnClear != "") { ?>
                        <button type="button" class="btn js-clear btn-secondary" data-dismiss="modal">{{ $btnClear }}</button>
                    <?php } ?>
                </div>
            @endif
        </div>
    </div>
</div>
