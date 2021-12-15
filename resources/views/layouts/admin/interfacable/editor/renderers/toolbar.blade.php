<div class="toolbar toolbar-element shadow-lg rounded-lg bg-white p-2" data-visual-element="{{ $uuid }}">
    <div class="btn-group" role="group">

        @foreach($items as $item)

            @if($item['type'] == 'button')
                <button type="button" data-action="{{ lowercase($item['name']) }}" data-visual-element="{{ $uuid }}" class="js-btn-action btn btn-outline-default css-{{ lowercase($item['name']) }}"><span>{!! __('admin.editor.'.$item['name']) !!}</span></button>
            @endif

            @if($item['type'] == 'dropdown')
                <div class="btn-group" role="group">
                    <button id="btnGroup_{{ $uuid }}" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span>{!! __('admin.editor.'.$item['name']) !!}</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroup_{{ $uuid }}">
                        @if(isset($item['childs']))
                            @foreach($item['childs'] as $child)
                                <a data-visual-element="{{ $uuid }}" data-action="{{ lowercase($child['name']) }}" class="js-btn-action dropdown-item css-{{ lowercase($child['name']) }}" href="#"><span>{!! __('admin.editor.'.$child['name']) !!}</span></a>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif

        @endforeach
      </div>
</div>
