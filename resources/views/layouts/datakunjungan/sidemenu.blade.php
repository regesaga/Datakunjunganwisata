
  <nav class="mt-2">

    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganwisata.dashboard') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
      
      </li>
      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganwisata.index') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>

          <p>
            Index
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
      
      </li>
      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganwisata.filterbyinput') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            By Input
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganwisata.filterbulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            perbulan
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganwisata.filtertahun') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            pertahun
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganwisata.filterwisnubulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Wisnuperbulan
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganwisata.filterwismanbulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Wismanperbulan
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganwisata.createwisnu') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-edit nav-icon"></i>

            </i>
           Tambah Data
        </a>
      </li>
      <li class="nav-item">
          <a href="{{ route('account.wisata.kelompokkunjungan.index') }}" class="nav-link ? 'active' : '' ">
              <i class="fas fa-edit nav-icon"></i>

              </i>
            Kelompok Data Kunjungan
          </a>
      </li>
      <li class="nav-item">
          <a href="{{ route('account.wisata.wismannegara.index') }}" class="nav-link ? 'active' : '' ">
              <i class="fas fa-edit nav-icon"></i>

              </i>
            Negara Data Kunjungan
          </a>
      </li>

  
      <li class="nav-header">EXAMPLES</li>
      <li class="nav-item">
        <a href="calendar.html" class="nav-link ? 'active' : '' ">
          <i class="nav-icon far fa-calendar-alt"></i>
          <p>
            Calendar
            <span class="badge badge-info right">2</span>
          </p>
        </a>
      </li>
    
    </ul>
  </nav>
