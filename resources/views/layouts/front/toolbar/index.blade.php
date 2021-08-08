{{-- Toolbar View Includes... --}}

{{-- {{ dd($items) }} --}}
<b-navbar type="dark" variant="dark">
    <b-navbar-nav>
        @foreach ($items as $item)
            @if(isset($item['paths']))
                <b-nav-item-dropdown text="{{ $item['title'] }}" right>
                    @foreach ($item['paths'] as $path)
                        <b-dropdown-item href="{{ $path['url'] }}">
                            @if(isset($path['icon']))
                                <i class="">{!! $path['icon'] !!}</i>
                            @endif
                            {{ $path['title'] }}
                        </b-dropdown-item>
                    @endforeach
                </b-nav-item-dropdown>
            @else
                <b-nav-item href="{{ $item['url'] }}">
                    @if(isset($item['icon']))
                        <i class="">{!! $item['icon'] !!}</i>
                    @endif
                    {{ $item['title'] }}
                </b-nav-item>
            @endif
        @endforeach

    </b-navbar-nav>
</b-navbar>
