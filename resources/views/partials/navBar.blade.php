<nav class="navbar header-navbar">
  <div class="navbar-wrapper">
    <div class="navbar-logo">
      <a class="mobile-menu" id="mobile-collapse" href="#!">
        <i class="ti-menu"></i>
      </a>
      <a class="mobile-search morphsearch-search" href="#">
        <i class="ti-search"></i>
      </a>
      <a href="{{ route('home') }}">
        <img class="img-fluid" src="{{ asset('assets/images/logo.png') }}" alt="Theme-Logo" />
      </a>
      <a class="mobile-options">
        <i class="ti-more"></i>
      </a>
    </div>
    <div class="navbar-container container-fluid">
      <div>
        <ul class="nav-left">
          <li>
            <a id="collapse-menu" href="#">
              <i class="ti-menu"></i>
            </a>
          </li>
          <li>
            <a class="main-search morphsearch-search" href="#">
              <!-- themify icon -->
              <i class="ti-search"></i>
            </a>
          </li>
        </ul>
        <ul class="nav-right">
          <li class="header-notification">
            <a href="#!">
              <i class="ti-plus"></i>
            </a>
            <ul class="show-notification" style="width: 200px!important;">
              <li>
                <h6>Create new</h6>
                <label class="label label-danger">New</label>
              </li>
              <li class="p-1">
                <a class="btn-success btn-outline-success btn-block text-lg p-3" href="{{ route('clients.create') }}">
                  <i class="fa fa-user-plus"></i> New client
                </a>
              </li>
              <li class="p-1">
                <a class="btn-success btn-outline-success btn-block text-lg p-3" href="{{ route('leads.create') }}">
                  <i class="fa fa-dot-circle-o"></i> New lead
                </a>
              </li>
            </ul>
          </li>
          <li class="user-profile header-notification">
            <a href="#!">
              <img src="{{ asset('assets/images/user.png') }}" alt="User-Profile-Image">
              <span>{{ auth()->user()->name }}</span>
              <i class="ti-angle-down"></i>
            </a>
            <ul class="show-notification profile-notification">
              <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                  <i class="ti-layout-sidebar-left"></i>
                  {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </li>
            </ul>
          </li>
        </ul>
        <!-- search -->
        <div id="morphsearch" class="morphsearch">
          <form class="morphsearch-form">
            <input class="morphsearch-input" name="client_search" type="search" placeholder="Search..." />
            <button class="morphsearch-submit" type="submit">Search</button>
          </form>
          <div class="morphsearch-content">
            <div class="dummy-column row" style="width: 100% !important;">

            </div>
          </div>
          <!-- /morphsearch-content -->
          <span class="morphsearch-close"><i class="icofont icofont-search-alt-1"></i></span>
        </div>
        <!-- search end -->
      </div>
    </div>
  </div>
</nav>