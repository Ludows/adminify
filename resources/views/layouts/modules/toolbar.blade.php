<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-1 small sticky" style="z-index: 1030;">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        @foreach ($items as $item)
            @if(isset($item['paths']))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white js-dropdowns" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        {{ $item['title'] }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach ($item['paths'] as $path)
                            @if(!empty($path['url']))
                                <a class="dropdown-item" href="{{ $path['url'] }}">
                                    @if(!empty($path['icon']))
                                        <i class="">{!! $path['icon'] !!}</i>
                                    @endif
                                    {{ $path['title'] }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </li>
            @else
                @if(!empty($item['url']))
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ $item['url'] }}">
                            @if(!empty($item['icon']))
                                <i class="">{!! $item['icon'] !!}</i>
                            @endif
                            {{ $item['title'] }}
                        </a>
                    </li>
                @endif
            @endif
        @endforeach
      </ul>

    </div>
  </nav>

  @push('js')
    <script data-swup-ignore-script="data-swup-ignore-script">
        let dropdowns = Array.prototype.slice.call(document.querySelectorAll('.js-dropdowns'));

        dropdowns.forEach((dropdown) => {
        dropdown.addEventListener('click', function(e) {
            e.preventDefault();

            this.nextElementSibling.classList.toggle('show');
        })
        })

    </script>
  @endpush

