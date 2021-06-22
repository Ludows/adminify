<div class="card">
    @if($isEditNamedRoute)
        {!! form_start($forms['formCreateMenu']) !!}
    @endif
    <h5 class="card-header">
        {{-- {{ dd($formCreateMenu) }} --}}
        @if($isCreatedNamedRoute)
            {!! form($forms['formCreateMenu']) !!}
        @else
            {!! form_row($forms['formCreateMenu']->title) !!}
        @endif

    </h5>
    @if(isset($menu_three))
        <div class="card-body">
            <h5 class="card-title">{!! _i('menu.three') !!}</h5>
            <input name="menuthree" value="" type="hidden" />
            @php
                $three = $menu_three->makeThree;
            @endphp
            @if(count($three) > 0)
                <ul id="sortable" class="list-group zone_menu_items">
                    @foreach($three as $menu_item)
                        @include('layouts.admin.menubuilder.menu-item', ['item' => $menu_item])
                    @endforeach
                </ul>
            @else
                <ul id="sortable" class="list-group zone_menu_items">
                </ul>
            @endif

        </div>
    @endif

    @if($isEditNamedRoute)
        <div class="card-footer">
            {!! form_row($forms['formCreateMenu']->suppress_menu) !!}
            {!! form_row($forms['formCreateMenu']->submit) !!}
            {!! form_end($forms['formCreateMenu'], false) !!}
        </div>
        {!! form($forms['formDeleteMenu'], ['id' => 'deleteMenu']) !!}
    @endif
</div>

@push('modales')
    @if(isset($menu_three) && count($three) > 0)
        @include('layouts.admin.modales.modaleFileManager')
    @endif
@endpush
