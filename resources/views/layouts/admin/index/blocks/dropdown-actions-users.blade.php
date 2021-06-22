<div class="dropdown">
    @php
        $currentUserId = auth()->user()->id;
    @endphp
    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-ellipsis-v"></i>
    </a>

        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
            <a class="dropdown-item" href="{{ route($name.'.edit', [ 'user' => $data->id, 'lang' => $useMultilang ? $currentLang : '']) }}">{{ __('edit.'.$name) }}</a>
            @if($currentUserId != $data->id)
                <div class="dropdown-item">
                    @if($forms)
                        {!! form($forms[$loop->index]) !!}
                    @endif
                </div>
            @endif
        </div>
</div>
