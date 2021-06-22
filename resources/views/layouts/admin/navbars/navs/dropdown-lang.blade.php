<div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
    @foreach($langs as $lang)
        @php
            $arrayParameters = ['lang' => $lang];
            if(request()->isCrudPattern) {
                $arrayParameters[request()->singleParam] = request()->{request()->singleParam}->id;
            }
        @endphp
        <a href="{{ route( $currentRouteName , $arrayParameters) }}" class="dropdown-item">
            <i class="ni ni-single-02"></i>
            <span>{{ __($lang) }}</span>
        </a>
    @endforeach


</div>
