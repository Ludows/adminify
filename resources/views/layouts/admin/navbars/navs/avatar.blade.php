
@php
$withName = isset($withName) ? $withName : false;
$user = user();
$avatar = $user->avatar;
//dd($avatar);
@endphp
<div class="media align-items-center">
@if(isset($avatar))
    <span class="avatar avatar-sm rounded-circle">
        <img alt="{{ $user->name }}" src="{{ $avatar->path }}">
    </span>
@endif
@if($withName)
    <div class="media-body ml-2 d-none d-lg-block">
        <span class="mb-0 text-sm  font-weight-bold">{{ $user->name }}</span>
    </div>
@endif
</div>
