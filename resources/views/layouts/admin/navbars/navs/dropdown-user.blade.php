<div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
    <div class=" dropdown-header noti-title">
        <h6 class="text-overflow m-0">{{ __('admin.welcome') }}</h6>
    </div>
    @if($user->hasPermissionTo('edit_users'))
        <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="dropdown-item">
            <i class="ni ni-single-02"></i>
            <span>{{ __('admin.profile') }}</span>
        </a>
    @endif
    @if($user->hasPermissionTo('update_profile'))
        <a href="{{ route('users.profile.edit', ['user' => $user->id]) }}" class="dropdown-item">
            <i class="ni ni-settings-gear-65"></i>
            <span>{{ __('admin.update_profile') }}</span>
        </a>
    @endif
    @if($user->hasPermissionTo('create_settings'))
        <a href="{{ route('settings.index') }}" class="dropdown-item">
            <i class="ni ni-settings-gear-65"></i>
            <span>{{ __('admin.menuback.settings') }}</span>
        </a>
    @endif
    <div class="dropdown-divider"></div>
    <a href="{{ route('auth.logout') }}" class="dropdown-item" onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
        <i class="ni ni-user-run"></i>
        <span>{{ __('admin.logout') }}</span>
    </a>
</div>
