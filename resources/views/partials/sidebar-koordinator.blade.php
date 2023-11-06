<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
      <div class="brand-logo d-flex align-items-center justify-content-center">
        <a href="/dashboard" class="text-nowrap logo-img d-flex justify-content-center align-items-center">
          <img src="{{ asset('images/logos/sipraga-logo.jpg') }}" width="166px" height="45px" alt="sipraga-logo" />
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
          <i class="ti ti-x fs-8"></i>
        </div>
      </div>
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">PENCATATAN</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="/koordinator/jadwal-pengecekan-kelas" aria-expanded="false">
              <span>
                <img src="{{ asset('images/icons/calendar-time.svg') }}" width="25px" height="25px">
              </span>
              <span class="hide-menu">Jadwal Cek Kelas</span>
            </a>
          </li>
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">PENGADUAN</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="#2" aria-expanded="false">
              <span>
                <img src="{{ asset('images/icons/message-cog.svg') }}" width="25px" height="25px">
              </span>
              <span class="hide-menu">Daftar Pengaduan</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="#3" aria-expanded="false">
              <span>
                <img src="{{ asset('images/icons/settings-up.svg') }}" width="25px" height="25px">
              </span>
              <span class="hide-menu">Perbaikan</span>
            </a>
          </li>
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">EKSTRA</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="#4" aria-expanded="false">
              <span>
                <img src="{{ asset('images/icons/user-circle.svg') }}" width="25px" height="25px">
              </span>
              <span class="hide-menu">Profil</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="#5" aria-expanded="false">
              <span>
                <img src="{{ asset('images/icons/logout.svg') }}" width="25px" height="25px">
              </span>
              <span class="hide-menu">Logout</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
  </aside>