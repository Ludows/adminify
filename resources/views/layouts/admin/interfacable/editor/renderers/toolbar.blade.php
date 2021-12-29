<div class="toolbar toolbar-element shadow-lg rounded-lg bg-white p-2" data-visual-element="{{ $uuid }}">
    <div class="btn-group" role="group">

        @foreach($items as $item)
            @if($loop->index < $editor['patterns']['max_tooltip_items_show'])
                <button type="button" title="{!! __('admin.editor.'.$item['name']) !!}" data-action="{{ lowercase($item['name']) }}" data-visual-element="{{ $uuid }}" class="js-btn-action btn btn-{{ $item['btn_bg'] }} css-{{ lowercase($item['name']) }}">
                    <i class="ni {{ $item['icon'] }}"></i>
                </button>
            @endif
        @endforeach
        <div class="btn-group" role="group">
            <button id="btnGroup_{{ $uuid }}" title="{!! __('admin.editor.moreOptions') !!}" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i class="ni ni-settings-gear-65"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroup_{{ $uuid }}">
                @foreach ($items as $item)
                    @if($loop->index > $editor['patterns']['max_tooltip_items_show'])
                        <a data-visual-element="{{ $uuid }}" data-action="{{ lowercase($item['name']) }}" class="js-btn-action dropdown-item css-{{ lowercase($item['name']) }}" href="#">
                            <i class="ni {{ $item['icon'] }}"></i><span>{!! __('admin.editor.'.$item['name']) !!}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
      </div>
</div>
