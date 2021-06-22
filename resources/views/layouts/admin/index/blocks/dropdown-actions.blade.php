{{--  <div class="dropdown">
    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-ellipsis-v"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
        <a class="dropdown-item" href="{{ route($name.'.edit', [ $editParam ?? Str::singular( $data->getTable() ) => $data->id, 'lang' => $useMultilang ? $currentLang : '']) }}">{{ _i($name.'.edit') }}</a>
        <div class="dropdown-item">
            @if(isset($forms))
                {!! form($forms[$loop->index]) !!}
            @endif
        </div>

    </div>
</div>  --}}

{!! render_action($action) !!}
