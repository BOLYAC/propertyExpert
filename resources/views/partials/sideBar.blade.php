<div class="main-menu-content">
    <ul class="main-navigation">
        <li class="nav-item single-item {{ Request::is('/') ? 'active' : ''}}">
            <a href="{{ route('home') }}">
                <i class="icon-home"></i>
                <span> {{ __('Dashboard') }}</span>
            </a>
        </li>
        @can('client-list')
            <li class="nav-item single-item {{ Request::is('clients') ? 'active' : ''}}">
                <a href="{{ route('clients.index') }}">
                    <i class="icon-user"></i>
                    <span> {{ __('Leads') }}</span>
                </a>
            </li>
        @endcan
        @can('lead-list')
            <li class="nav-item single-item {{ Request::is('leads') ? 'active' : ''}}">
                <a href="{{ route('leads.index') }}">
                    <i class="icon-layout-cta-right"></i>
                    <span> {{ __('Deals') }}</span>
                </a>
            </li>
        @endcan
        @can('invoice-list')
            <li class="nav-item single-item {{ Request::is('invoices') ? 'active' : ''}}">
                <a href="{{ route('invoices.index') }}">
                    <i class="icon-layout-cta-right"></i>
                    <span> {{ __('Invoices') }}</span>
                </a>
            </li>
        @endcan

        @can('task-list')
            <li class="nav-item single-item {{ Request::is('tasks') ? 'active' : ''}}">
                <a href="{{ route('tasks.index') }}">
                    <i class="fa fa-tasks"></i>
                    <span> {{ __('Tasks') }}</span>
                </a>
            </li>
        @endcan
        @can('event-list')
            <li class="nav-item single-item {{ Request::is('events') ? 'active' : ''}}">
                <a href="{{ route('events.index') }}">
                    <i class="fa fa-calendar"></i>
                    <span> {{ __('Events') }}</span>
                </a>
            </li>
        @endcan
        @can('calender-show')
            <li class="nav-item single-item {{ Request::is('calender') ? 'active' : ''}}">
                <a href="{{ route('calender.index') }}">
                    <i class="fa fa-calendar"></i>
                    <span> {{ __('Calender') }}</span>
                </a>
            </li>
        @endcan
        <li class="nav-item single-item {{ Request::is('projects') ? 'active' : ''}}">
            <a href="{{ route('projects.index') }}">
                <i class="fa fa-product-hunt"></i>
                <span> {{ __('Projects') }}</span>
            </a>
        </li>
        @can('source-list')
            <li class="nav-item single-item {{ Request::is('sources') ? 'active' : ''}}">
                <a href="{{ route('sources.index') }}">
                    <i class="icon-direction"></i>
                    <span> {{ __('Sources') }}</span>
                </a>
            </li>
        @endcan
        @can('agency-list')
            <li class="nav-item single-item {{ Request::is('agencies') ? 'active' : ''}}">
                <a href="{{ route('agencies.index') }}">
                    <i class="icon-magnet"></i>
                    <span> {{ __('Agencies') }}</span>
                </a>
            </li>
        @endcan
        @can('stats-list')
            <li class="dropdown"><a class="nav-link menu-title" href="#"><i
                        data-feather="home"></i><span>{{ __('Reporting') }}</span></a>
                <ul class="nav-submenu menu-content">
                    <li><a href="{{ route('static.index') }}">{{ __('Users Status') }}</a></li>
                    <li><a href="{{ route('calls.filter') }}">{{ __('Calls reporting') }}</a></li>
                </ul>
            </li>
        @endcan
        @can('user-list')
            <li class="nav-item single-item {{ Request::is('users') ? 'active' : ''}}">
                <a href="{{ route('users.index') }}">
                    <i class="fa fa-users"></i>
                    <span> {{ __('Users') }}</span>
                </a>
            </li>
        @endcan
        @can('team-list')
            <li class="nav-item single-item {{ Request::is('teams') ? 'active' : ''}}">
                <a href="{{ route('teams.index') }}">
                    <i class="icon-link"></i>
                    <span> {{ __('Teams') }}</span>
                </a>
            </li>
        @endcan
        @can('role-list')
            <li class="nav-item single-item {{ Request::is('roles') ? 'active' : ''}}">
                <a href="{{ route('roles.index') }}">
                    <i class="fa fa-chain"></i>
                    <span> {{ __('Roles') }}</span>
                </a>
            </li>
        @endcan
        @can('settings')
            <li class="nav-item single-item {{ Request::is('settings') ? 'active' : ''}}">
                <a href="{{ route('settings.index') }}">
                    <i class="fa fa-gears"></i>
                    <span> {{ __('Settings') }}</span>
                </a>
            </li>
        @endcan
    </ul>
</div>
