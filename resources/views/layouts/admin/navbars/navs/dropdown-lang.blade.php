<div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
    @foreach($langs as $lang)
        @php
            $arrayParameters = ['lang' => $lang];
            if(request()->isCrudPattern) {
                $arrayParameters[request()->singleParam] = request()->{request()->singleParam}->id ?? \Route::current()->parameter(request()->singleParam);;
            }
        @endphp
        <a href="{{ route( $currentRouteName , $arrayParameters) }}" class="dropdown-item">
            <img width="25" alt="{{ $lang }}" src="{{ asset('adminify/img/flags') }}/{{ $lang }}.svg">
            <span>{{ __('admin.'.$lang) }}</span>
        </a>
    @endforeach


</div>
