<div class="container h-100">
    <div class="row">
        <div class="col-12">
            <div class="title_zone" contenteditable="true">
                {{ $isCreate ? __('admin.editor.addTitle') : $page->title }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12" id="renderZoneWidgets">
            @if($isCreate && !empty(old('content')))
                Tata
            @endif
            @if($isEdit)
               {!! $page->content !!} 
            @endif
        </div>
    </div>
</div>
