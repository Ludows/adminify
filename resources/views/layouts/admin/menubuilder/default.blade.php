
<div class="container-fluid" id="menuBuilder">
    @if(count($menu_switcher) > 0 && $isEditNamedRoute)
        <div class="row">
            <div class="col-12 menu-switcher-area">
                @include('adminify::layouts.admin.menubuilder.menu-switcher')
            </div>
        </div>
    @endif
    <div class="row">
        @if($isEditNamedRoute)
            <div class="col-lg-4 col-12 sticky-top sidebar-area">
                @include('adminify::layouts.admin.menubuilder.sidebar')
            </div>
        @endif
        <div class="menu-three-area {{ $isEditNamedRoute ? 'col-lg-8' : 'col-lg-12' }} col-12">
            @include('adminify::layouts.admin.menubuilder.menu-three', ['mediaMode' => $canAttachMedia])
        </div>
    </div>
</div>

@include('adminify::layouts.admin.medialibrary.modalPicker', [
    'typed_files' => app('Ludows\Adminify\Libs\MediaService')->getListingTypedFiles(),
    'dates' => app('Ludows\Adminify\Libs\MediaService')->getListingDates(),
    'isSelectionMode' => true,
    'isMulti' => false
])

@php
    add_asset('default',  asset('adminify').'/back/js/menuBuilder.js' );
@endphp


