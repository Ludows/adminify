{{--  {{ dd($logo) }}  --}}
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow">
    <div class="container">
      <a class="navbar-brand" href="{!! $home_url ?? '#' !!}">
          @if(!empty($logo))
            <img alt="{{ $logo->alt }}" src="{{ image($logo->getRelativePath(), ['h' => 80, 'w' => 80])  }}" />
          @endif
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainMenu">
        @include('theme::'. $theme .'.layouts.partials.menu', [
            'items' => $main_menu ?? [],
            'wrapper_class' => 'navbar-nav me-auto mb-2 mb-lg-0'
        ])
        {{--  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            @if (!empty($main_menu))
                @foreach ($main_menu as $item)
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ $item->related->urlpath }}">{{ $item->related->title }}</a>
                    </li>
                @endforeach
            @endif
        </ul>  --}}
        @if(Route::has('globalsearch'))
            <search url="{{ route('globalsearch') }}" crsf="{{ csrf_token() }}" />
        @endif
        {{--  <form method="POST" action="{{ route('globalsearch') }}" class="d-flex">
          @csrf
          <input class="form-control me-2" name="query" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>  --}}
      </div>
    </div>
  </nav>
