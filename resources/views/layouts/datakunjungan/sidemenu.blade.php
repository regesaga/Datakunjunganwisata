
@role('wisata')
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
            Index bulanan
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
      
      </li>
      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganwisata.indexkunjunganwisatapertahun') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>

          <p>
            Index tahunan
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
@endrole
@role('kuliner')
  <nav class="mt-2">

    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.dashboard') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
      
      </li>
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.index') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>

          <p>
            Index bulanan
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
      
      </li>
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.indexkunjungankulinerpertahun') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>

          <p>
            Index tahunan
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
      
      </li>
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.filterbyinput') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            By Input
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.filterbulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            perbulan
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.filtertahun') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            pertahun
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.filterwisnubulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Wisnuperbulan
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.filterwismanbulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Wismanperbulan
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.createwisnu') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-edit nav-icon"></i>

            </i>
           Tambah Data
        </a>
      </li>
      <li class="nav-item">
          <a href="{{ route('account.kuliner.kelompokkunjungan.index') }}" class="nav-link ? 'active' : '' ">
              <i class="fas fa-edit nav-icon"></i>

              </i>
            Kelompok Data Kunjungan
          </a>
      </li>
      <li class="nav-item">
          <a href="{{ route('account.kuliner.wismannegara.index') }}" class="nav-link ? 'active' : '' ">
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
@endrole
@role('akomodasi')
  <nav class="mt-2">

    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.dashboard') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
      
      </li>
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.index') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>

          <p>
            Index bulanan
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
      
      </li>
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.indexkunjunganakomodasipertahun') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>

          <p>
            Index tahunan
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
      
      </li>
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.filterbyinput') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            By Input
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.filterbulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            perbulan
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.filtertahun') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            pertahun
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.filterwisnubulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Wisnuperbulan
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.filterwismanbulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Wismanperbulan
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.createwisnu') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-edit nav-icon"></i>

            </i>
           Tambah Data
        </a>
      </li>
      <li class="nav-item">
          <a href="{{ route('account.akomodasi.kelompokkunjungan.index') }}" class="nav-link ? 'active' : '' ">
              <i class="fas fa-edit nav-icon"></i>

              </i>
            Kelompok Data Kunjungan
          </a>
      </li>
      <li class="nav-item">
          <a href="{{ route('account.akomodasi.wismannegara.index') }}" class="nav-link ? 'active' : '' ">
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
@endrole