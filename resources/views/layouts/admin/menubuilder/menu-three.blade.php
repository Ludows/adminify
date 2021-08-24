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
            <h5 class="card-title">{!! __('admin.menu.three') !!}</h5>
            <input name="menuthree" value="" type="hidden" />
            @php
                $three = $menu_three->makeThree;
            @endphp
            @if(count($three) > 0)
                <ul id="sortable" class="list-group zone_menu_items">
                    @foreach($three as $menu_item)
                        @include('adminify::layouts.admin.menubuilder.menu-item', ['item' => $menu_item, 'new' => false, 'isCustom' => $menu_item->type == 'custom'])
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
            <div class="d-flex align-items-center justify-content-between">
                {!! form_row($forms['formCreateMenu']->suppress_menu) !!}
                {!! form_row($forms['formCreateMenu']->submit, [
                    'wrapper' => ['class' => 'form-group mb-0'],
                ]) !!}
            </div>
            {!! form_end($forms['formCreateMenu'], false) !!}
        </div>
        {!! form($forms['formDeleteMenu'], ['id' => 'deleteMenu']) !!}
    @endif
</div>

@push('modales')
    @include('adminify::layouts.admin.modales.modaleFileManager')
@endpush
