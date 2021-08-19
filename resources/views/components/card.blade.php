@php
    $hasCreateLink = isset($createLink) ? true : false;
@endphp
<div class="card">
    <div class="card-header d-flex {{ $hasCreateLink ? 'justify-content-between' : '' }} align-items-center">
        <div>{{ __('admin.last_entity', ['entity' => $type]) }}</div>
        @if($hasCreateLink)
            <div><a href="{{ $createLink }}" class="btn btn-sm btn-primary">{{ __('admin.table.modules.btn_create', ['entity' => $type]) }}</a></div>
        @endif
    </div>
        @if(!empty($data))
            <ul class="list-group list-group-flush">
                @foreach($data as $item)
                    <li class="list-group-item d-flex align-items-center justify-content-between">
                        <div>
                            {{ $item->{$show} }}
                        </div>
                        <div>
                            <a href="{{ route( $plural.'.edit', [ $type =>  $item->id] ) }}">{{ __('admin.edit_entity', ['entity' => $type]) }}</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="card-body">
                {{ __('admin.table.listings.no_datas') }}
            </div>
        @endif

</div>
