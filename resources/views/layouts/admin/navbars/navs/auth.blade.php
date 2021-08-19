<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md bg-gradient-primary" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand -->
        <div class="">
            <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{ route('home.dashboard') }}">{{ __('admin.root') }}</a>
            <a href="#" class="btn btn-default js-search-btn btn-sm rounded">
                <i class="fas fa-search"></i>
            </a>
        </div>
        
        <!-- Form -->
        {{--  <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
            @csrf
            <div class="form-group mb-0">
                <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input class="form-control js-search" placeholder="Search" type="text">
                </div>
            </div>
        </form>  --}}
        {{-- <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            
        </ul> --}}
        
            <!-- Langs -->
            <ul class="navbar-nav align-items-center d-none d-md-flex">
                <li class="nav-item dropdown">
                    <a class="nav-link pr-0 text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @include('adminify::layouts.admin.navbars.navs.avatar', ['withName' => true])
                    </a>
                    @include('adminify::layouts.admin.navbars.navs.dropdown-user')
                </li>
                @if($useMultilang)
                    <li class="nav-item dropdown">
                        <a class="nav-link pr-0 text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $currentLang }}
                        </a>
                        @include('adminify::layouts.admin.navbars.navs.dropdown-lang')
                    </li>
                @endif
            </ul>
        

    </div>
</nav>
