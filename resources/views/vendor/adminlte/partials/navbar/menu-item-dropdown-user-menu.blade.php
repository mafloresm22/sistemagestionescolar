@php( $logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout') )
@php( $profile_url = View::getSection('profile_url') ?? config('adminlte.profile_url', 'logout') )

@if (config('adminlte.usermenu_profile_url', false))
    @php( $profile_url = Auth::user()->adminlte_profile_url() )
@endif

@if (config('adminlte.use_route_url', false))
    @php( $profile_url = $profile_url ? route($profile_url) : '' )
    @php( $logout_url = $logout_url ? route($logout_url) : '' )
@else
    @php( $profile_url = $profile_url ? url($profile_url) : '' )
    @php( $logout_url = $logout_url ? url($logout_url) : '' )
@endif

<li class="nav-item dropdown user-menu">

    {{-- User menu toggler --}}
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        @if(config('adminlte.usermenu_image'))
            <img src="{{ Auth::user()->adminlte_image() }}"
                 class="user-image img-circle elevation-2"
                 alt="{{ Auth::user()->name }}">
        @endif
        <span @if(config('adminlte.usermenu_image')) class="d-none d-md-inline" @endif>
            {{ Auth::user()->name }}
        </span>
    </a>

    {{-- User menu dropdown --}}
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        {{-- User menu header --}}
        @if(!View::hasSection('usermenu_header') && config('adminlte.usermenu_header'))
            <li class="user-header {{ config('adminlte.usermenu_header_class', 'bg-primary') }}
                @if(!config('adminlte.usermenu_image')) h-auto @endif">
                @if(config('adminlte.usermenu_image'))
                    <img src="{{ Auth::user()->adminlte_image() }}"
                         class="img-circle elevation-2"
                         alt="{{ Auth::user()->name }}">
                @endif
                <p class="@if(!config('adminlte.usermenu_image')) mt-0 @endif">
                    {{ Auth::user()->name }}
                    @if(config('adminlte.usermenu_desc'))
                        <small>{{ Auth::user()->adminlte_desc() }}</small>
                    @endif
                </p>
            </li>
        @else
            @yield('usermenu_header')
        @endif

        {{-- Configured user menu links --}}
        @each('adminlte::partials.navbar.dropdown-item', $adminlte->menu("navbar-user"), 'item')

        {{-- User menu body --}}
        @hasSection('usermenu_body')
            <li class="user-body">
                @yield('usermenu_body')
            </li>
        @endif

        {{-- User menu footer --}}
        <li class="user-footer">
            @if($profile_url)
                <a href="{{ $profile_url }}" class="nav-link btn btn-default btn-flat d-inline-block">
                    <i class="fa fa-fw fa-user text-lightblue"></i>
                    {{ __('adminlte::menu.profile') }}
                </a>
            @endif
            <a class="btn btn-default btn-flat float-right @if(!$profile_url) btn-block @endif"
               href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-fw fa-power-off text-red"></i>
                {{ __('adminlte::adminlte.log_out') }}
            </a>
            <form id="logout-form" action="{{ $logout_url }}" method="POST" style="display: none;">
                @if(config('adminlte.logout_method'))
                    {{ method_field(config('adminlte.logout_method')) }}
                @endif
                {{ csrf_field() }}
            </form>
        </li>

    </ul>

</li>

<style>
    /* Premium User Menu Styles */
    .user-menu .dropdown-menu {
        border-radius: 15px !important;
        border: none !important;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
        animation: userMenuEntrance 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes userMenuEntrance {
        from { opacity: 0; transform: scale(0.9) translateY(-10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .bg-primary-custom {
        background: linear-gradient(135deg, #007bff 0%, #00d2ff 100%) !important;
        border-bottom: 3px solid rgba(255,255,255,0.1);
    }

    .user-header img {
        border: 4px solid rgba(255,255,255,0.2) !important;
        transition: transform 0.4s ease;
        padding: 2px;
        background: white;
    }

    .user-header:hover img {
        transform: scale(1.1) rotate(5deg);
    }

    .user-header {
        height: 185px !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 10px !important;
    }

    .user-header p {
        margin-top: 10px !important;
        margin-bottom: 0 !important;
        line-height: 1.2 !important;
    }

    .user-header small {
        margin-top: 5px !important;
        display: block !important;
        font-weight: 500;
        opacity: 0.9;
    }

    .user-footer {
        background-color: #f8f9fa !important;
        border-top: 1px solid #eee !important;
        padding: 15px !important;
    }

    .user-footer .btn {
        border-radius: 8px !important;
        font-weight: 600;
        transition: all 0.2s;
    }

    .user-footer .btn-default:hover {
        background: #e9ecef !important;
        transform: translateY(-1px);
    }

    .user-menu .nav-link span {
        font-weight: 600;
        letter-spacing: 0.3px;
    }
</style>
