@php
    $user = auth()->user();
@endphp
<div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
    <div class=" dropdown-header noti-title">
        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
    </div>
    @if($user->hasPermissionTo('edit_users'))
        <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="dropdown-item">
            <i class="ni ni-single-02"></i>
            <span>{{ __('My profile') }}</span>
        </a>
    @endif
    @if($user->hasPermissionTo('manage_settings'))
        <a href="{{ route('settings.index') }}" class="dropdown-item">
            <i class="ni ni-settings-gear-65"></i>
            <span>{{ __('Settings') }}</span>
        </a>
    @endif
    <div class="dropdown-divider"></div>
    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
        <i class="ni ni-user-run"></i>
        <span>{{ __('Logout') }}</span>
    </a>
</div>
