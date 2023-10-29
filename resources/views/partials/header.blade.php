<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item d-block d-xl-none">
          <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
            <i class="ti ti-menu-2"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-icon-hover" href="javascript:void(0)">
            <i class="ti ti-bell-ringing"></i>
            <div class="notification bg-primary rounded-circle"></div>
          </a>
        </li>
      </ul>
      <div class="navbar-collapse justify-content-end mx-2 px-0 d-flex align-items-center justify-content-between" id="navbarNav">
        <ul class="navbar-nav d-flex align-items-center justify-content-end">
          <p class="m-0 text-dark" style="font-family: 'Inter', sans-serif; font-size: 20px; font-weight: 500;">Selamat @yield('time'), @yield('first-name')!</p>
        </ul>
        <ul class="navbar-nav flex-row align-items-center justify-content-end">
          <p class="m-0 text-dark" style="font-family: 'Inter', sans-serif; font-size: 20px; font-weight: 500;">@yield('role')</p>
          <a href="#" class="ms-3">
            <img src="{{ asset('../images/profile/user-1.jpg') }}" alt="" width="35" height="35" class="rounded-circle">
          </a>
        </ul>
      </div>
    </nav>
  </header>