<header class="main-nav">
   <nav>
      <div class="main-navbar">
         <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
         <div id="mainnav">
            <ul class="nav-menu custom-scrollbar">
               <li class="back-btn">
                  <div class="mobile-back text-right"><span>Back</span><i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
               </li>
               <li class="dropdown">
                  <a class="nav-link menu-title" href="{{route('home')}}"><i data-feather="home"></i><span>Dashboard</span>
                  </a>
               </li>
               <li class="dropdown">
                  <a class="nav-link menu-title" href="#"><i data-feather="anchor"></i><span>Sarter Kit</span>
                     <div class="according-menu"><i class="fa fa-angle-double-{{request()->route()->getPrefix() == '/starter-kit' ? 'down' : 'right' }}"></i></div>
                  </a>
                  <ul class="nav-submenu menu-content" style="display: {{request()->route()->getPrefix() == '/starter-kit' ? 'block;' : 'none' }}">
                  </ul>
               </li>
            </ul>
         </div>
         <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
      </div>
   </nav>
</header>
