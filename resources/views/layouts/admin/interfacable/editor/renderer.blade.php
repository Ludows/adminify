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
            {{-- {!! dd($request) !!} --}}
            @if(!empty(old('content')))
                {!! json_decode(old('content')) !!}
            @elseif (!empty($page))
                {!! $page->content !!}
            @else

            @endif
        </div>
    </div>
</div>
