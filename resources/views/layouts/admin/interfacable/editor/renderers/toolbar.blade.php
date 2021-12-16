<div class="toolbar toolbar-element shadow-lg rounded-lg bg-white p-2" data-visual-element="{{ $uuid }}">
    <div class="btn-group" role="group">

        @foreach($items as $item)

            @if($item['type'] == 'button')
                <button type="button" title="{!! __('admin.editor.'.$item['name']) !!}" data-action="{{ lowercase($item['name']) }}" data-visual-element="{{ $uuid }}" class="js-btn-action btn btn-{{ $item['btn_bg'] }} css-{{ lowercase($item['name']) }}">
                    <i class="ni {{ $item['icon'] }}"></i>
                </button>
            @endif

            @if($item['type'] == 'dropdown')
                <div class="btn-group" role="group">
                    <button id="btnGroup_{{ $uuid }}" title="{!! __('admin.editor.'.$item['name']) !!}" type="button" class="btn btn-{{ $item['btn_bg'] }} dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="ni {{ $item['icon'] }}"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroup_{{ $uuid }}">
                        @if(isset($item['childs']))
                            @foreach($item['childs'] as $child)
                                <a data-visual-element="{{ $uuid }}" data-action="{{ lowercase($child['name']) }}" class="js-btn-action dropdown-item css-{{ lowercase($child['name']) }}" href="#">
                                    <i class="ni {{ $child['icon'] }}"></i><span>{!! __('admin.editor.'.$child['name']) !!}</span></a>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif

        @endforeach
      </div>
</div>
