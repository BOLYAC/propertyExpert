<header class="main-nav">
    <nav>
        <div class="main-navbar">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-right"><span>{{ __('Back') }}</span><i
                                class="fa fa-angle-right pl-2"
                                aria-hidden="true"></i></div>
                    </li>

                    <li class="dropdown">
                        <a class="nav-link menu-title {{ Route::currentRouteName() === 'home' ? 'active' : '' }}"
                           href="{{route('home')}}"><i data-feather="home"></i><span>{{ __('Dashboard') }}</span>
                        </a>
                    </li>
                    @can('client-list')
                        <li class="dropdown">
                            <a class="nav-link menu-title {{ Route::currentRouteName() === 'clients.index' ? 'active' : '' }}"
                               href="{{route('clients.index')}}"><i
                                    data-feather="users"></i><span>{{ __('Leads') }}
                                </span>
                            </a>
                        </li>
                    @endcan
                    @can('lead-list')
                        <li class="dropdown">
                            <a class="nav-link menu-title  {{ Route::currentRouteName() === 'leads.index' ? 'active' : '' }}"
                               href="{{route('leads.index')}}">
                                <i class="icon-layout-cta-right"></i>
                                <span>{{ __('Deals') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('invoice-list')
                        <li class="dropdown">
                            <a href="{{ route('invoices.index') }}"
                               class="nav-link menu-title {{ Route::currentRouteName() === 'invoices.index' ? 'active' : '' }}">
                                <i class="icon-layout-cta-right"></i>
                                <span> {{ __('Invoices') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('task-list')
                        <li class="dropdown">
                            <a href="{{ route('tasks.index') }}"
                               class="nav-link menu-title {{ Route::currentRouteName() === 'tasks.index' ? 'active' : '' }}">
                                <i class="fa fa-tasks"></i>
                                <span> {{ __('Tasks') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('event-list')
                        <li class="dropdown">
                            <a href="{{ route('events.index') }}"
                               class="nav-link menu-title {{ Route::currentRouteName() === 'events.index' ? 'active' : '' }}">
                                <i class="fa fa-calendar"></i>
                                <span> {{ __('Appointments') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('calender-show')
                        <li class="dropdown">
                            <a href="{{ route('calender.index') }}"
                               class="nav-link menu-title {{ Route::currentRouteName() === 'calender.index' ? 'active' : '' }}">
                                <i class="fa fa-calendar"></i>
                                <span> {{ __('Calender') }}</span>
                            </a>
                        </li>
                    @endcan
                    <li class="dropdown">
                        <a href="{{ route('projects.index') }}"
                           class="nav-link menu-title {{ Route::currentRouteName() === 'projects.index' ? 'active' : '' }}">
                            <i class="fa fa-product-hunt"></i>
                            <span> {{ __('Projects') }}</span>
                        </a>
                    </li>
                    @can('source-list')
                        <li class="dropdown">
                            <a href="{{ route('sources.index') }}"
                               class="nav-link menu-title {{ Route::currentRouteName() === 'sources.index' ? 'active' : '' }}">
                                <i class="icon-direction"></i>
                                <span> {{ __('Sources') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('agency-list')
                        <li class="dropdown">
                            <a href="{{ route('agencies.index') }}"
                               class="nav-link menu-title {{ Route::currentRouteName() === 'agencies.index' ? 'active' : '' }}">
                                <i class="icon-magnet"></i>
                                <span> {{ __('Agencies') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('stats-list')
                        @if(auth()->user()->hasRole('Admin'))
                            <li class="dropdown">
                                <a class="nav-link menu-title" href="#"><i
                                        data-feather="home"></i><span>{{ __('Reporting') }}</span></a>
                                <ul class="nav-submenu menu-content">
                                    <li><a href="{{ route('static.index') }}">{{ __('Users Status') }}</a></li>
                                    <li><a href="{{ route('calls.index') }}">{{ __('Calls reporting') }}</a></li>
                                </ul>
                            </li>
                        @else
                            @if(auth()->user()->department_id === 2)
                                <li class="dropdown">
                                    <a href="{{ route('calls.index') }}"
                                       class="nav-link menu-title {{ Route::currentRouteName() === 'calls.index' ? 'active' : '' }}">
                                        <i class="icon-bar-chart"></i>
                                        <span> {{ __('Reporting') }}</span>
                                    </a>
                                </li>
                            @else
                                <li class="dropdown">
                                    <a href="{{ route('static.index') }}"
                                       class="nav-link menu-title {{ Route::currentRouteName() === 'static.index' ? 'active' : '' }}">
                                        <i class="icon-bar-chart"></i>
                                        <span> {{ __('Reporting') }}</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endcan
                    <li class="dropdown">
                        <a href="{{ route('contact.index') }}"
                           class="nav-link menu-title {{ Route::currentRouteName() === 'contact.index' ? 'active' : '' }}">
                            <i class="icon-user"></i>
                            <span> {{ __('Contacts') }}</span>
                        </a>
                    </li>
                    @can('user-list')
                        <li class="dropdown">
                            <a href="{{ route('users.index') }}"
                               class="nav-link menu-title {{ Route::currentRouteName() === 'users.index' ? 'active' : '' }}">
                                <i class="fa fa-users"></i>
                                <span> {{ __('Users') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('team-list')
                        <li class="dropdown">
                            <a href="{{ route('teams.index') }}"
                               class="nav-link menu-title {{ Route::currentRouteName() === 'teams.index' ? 'active' : '' }}">
                                <i class="icon-link"></i>
                                <span> {{ __('Teams') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('department-list')
                        <li class="dropdown">
                            <a href="{{ route('departments.index') }}"
                               class="nav-link menu-title {{ Route::currentRouteName() === 'departments.index' ? 'active' : '' }}">
                                <i class="fa fa-building"></i>
                                <span> {{ __('Departments') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('role-list')
                        <li class="dropdown">
                            <a href="{{ route('roles.index') }}"
                               class="nav-link menu-title {{ Route::currentRouteName() === 'roles.index' ? 'active' : '' }}">
                                <i class="fa fa-chain"></i>
                                <span> {{ __('Roles') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('settings')
                        <li class="dropdown">
                            <a href="{{ route('settings.index') }}"
                               class="nav-link menu-title {{ Route::currentRouteName() === 'settings.index' ? 'active' : '' }}">
                                <i class="fa fa-gears"></i>
                                <span> {{ __('Settings') }}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
