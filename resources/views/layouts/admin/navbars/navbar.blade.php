@auth()
    @include('adminify::layouts.admin.navbars.navs.auth')
@endauth

@guest()
    @include('adminify::layouts.admin.navbars.navs.guest')
@endguest
