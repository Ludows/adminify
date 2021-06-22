
@php
    $withName = isset($withName) ? $withName : false;
@endphp
<div class="media align-items-center">
    <span class="avatar avatar-sm rounded-circle">
        @php
            $user = auth()->user();
            $avatar = $user->avatar;
        @endphp
        @if(isset($avatar))
            <img alt="Image placeholder" src="{{ asset('myuploads/medias/') }}/{{ $avatar->src }}">
        @else
            @todo
            {{-- <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg"> --}}
        @endif
    </span>
    @if($withName)
        <div class="media-body ml-2 d-none d-lg-block">
            <span class="mb-0 text-sm  font-weight-bold">{{ $user->name }}</span>
        </div>
    @endif
</div>
