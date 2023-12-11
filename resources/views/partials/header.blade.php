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
          <p class="fluid-text m-0 text-dark text-sm">Selamat {{ $userInfo['timeOfDay'] }}, {{ $userInfo['name'] }}!</p>
        </ul>
        <div class="navbar-collapse justify-content-end mx-2 px-0 d-flex align-items-center justify-content-between"
            id="navbarNav">
            <ul class="navbar-nav d-flex align-items-center justify-content-end">
                <p class="fluid-text m-0 text-dark">Selamat {{ $userInfo['timeOfDay'] }}, {{ $userInfo['name'] }}!</p>
            </ul>
            <ul class="navbar-nav flex-row align-items-center justify-content-end">
                <p class="fluid-text-display m-0 text-dark" id="roleParagraph"></p>
                <a href="#" class="ms-3">
                    <img src="{{ asset('../images/profile/user-1.jpg') }}" alt="" width="35" height="35"
                        class="rounded-circle">
                </a>
            </ul>
        </div>
    </nav>
    <script>
      // Ambil nilai 'role' dari path URL
      var role = window.location.pathname.split('/')[1]; // Menggunakan asumsi bahwa 'role' berada pada posisi pertama dalam path URL
  
      // Ubah 'role' jika bernilai "pemakaibhp"
      if (role.toLowerCase() === 'pemakaibhp') {
          role = 'Pemakai BHP';
      }
  
      // Konversi string 'role' agar diawali dengan huruf kapital
      var formattedRole = role.charAt(0).toUpperCase() + role.slice(1);
  
      // Setel nilai 'formattedRole' ke dalam elemen HTML <p>
      document.getElementById('roleParagraph').innerText = formattedRole;
  </script>
</header>
