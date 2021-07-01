@php
    $hasCreateLink = isset($createLink) ? true : false;
@endphp
<div class="card">
    <div class="card-header d-flex {{ $hasCreateLink ? 'justify-content-between' : '' }} align-items-center">
        <div>{{ __('admin.last.'.$type) }}</div>
        @if($hasCreateLink)
            <div><a href="{{ $createLink }}" class="btn btn-sm btn-primary">{{ __('admin.create.'.$type) }}</a></div>
        @endif
    </div>
        @if($data->count() > 0)
            <ul class="list-group list-group-flush">
                @foreach($data as $item)
                    <li class="list-group-item d-flex align-items-center justify-content-between">
                        <div>
                            {{ $item->{$column} }}
                        </div>
                        <div>
                            <a href="{{ route( $plural.'.edit', [ $type =>  $item->id] ) }}">{{ __('admin.edit.'.$type) }}</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="card-body">
                {{ __('admin.nocontent.'.$type) }}
            </div>
        @endif

</div>
