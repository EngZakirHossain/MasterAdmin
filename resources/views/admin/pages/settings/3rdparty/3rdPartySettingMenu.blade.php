<ul class="nav nav-pills flex-column flex-md-row mb-4">
    <li class="nav-item ">
        <a class="nav-link @if (request()->routeIs('admin.settings.socialite')) active @endif"
            href="{{ route('admin.settings.socialite') }}"><i class="ti-xs ti ti-users me-1"></i>
            Socialite Login</a>
    </li>
    <li class="nav-item ">
        <a class="nav-link " href="#"><i class="ti-xs ti ti-link me-1"></i>
            SMS Config</a>
    </li>

</ul>
