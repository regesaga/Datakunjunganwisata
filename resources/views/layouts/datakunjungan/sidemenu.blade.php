
@role('admin')
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    <li class="nav-item">
      <a href="{{ route('admin.datakunjungan.index') }}" class="nav-link ? 'active' : '' ">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Dashboard
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
    
    </li>
    <li class="nav-item">
      <a href="{{ route('admin.kunjunganwisata.createwisnu') }}" class="nav-link ? 'active' : '' ">
          <i class="fas fa-edit nav-icon"></i>

          </i>
         Tambah Data
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('admin.kunjunganevent.create') }}" class="nav-link ? 'active' : '' ">
          <i class="fas fa-edit nav-icon"></i>
          <p>
         Tambah Kunjungan Event
          </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('admin.kunjunganevent.indexkunjunganeventpertahun') }}" class="nav-link ? 'active' : '' ">
        <i class="nav-icon fas fa-th"></i>

        <p>
          Index Event
          
        </p>
      </a>
    
    </li>
   
    <li class="nav-item">
        <a href="{{ route('admin.kelompokkunjungan.index') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-edit nav-icon"></i>

            </i>
          Kelompok Data Kunjungan
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.wismannegara.index') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-edit nav-icon"></i>

            </i>
          Negara Data Kunjungan
        </a>
    </li>
    <li class="nav-header">WISATA</li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
          Wisata
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">6</span>
        </p>
      </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('admin.kunjunganwisata.index') }}" class="nav-link ? 'active' : '' ">
            <i class="nav-icon fas fa-th"></i>

            <p>
              Index bulanan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.kunjunganwisata.indexkunjunganwisatapertahun') }}" class="nav-link ? 'active' : '' ">
            <i class="nav-icon fas fa-th"></i>

            <p>
              Index tahunan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        
        </li>
      
    </ul>
    </li>
    <li class="nav-header">KULINER</li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
          Kuliner
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">6</span>
        </p>
      </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('admin.kunjungankuliner.index') }}" class="nav-link ? 'active' : '' ">
            <i class="nav-icon fas fa-th"></i>

            <p>
              Index bulanan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.kunjungankuliner.indexkunjungankulinerpertahun') }}" class="nav-link ? 'active' : '' ">
            <i class="nav-icon fas fa-th"></i>

            <p>
              Index tahunan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        
        </li>
      
    </ul>
    </li>

    <li class="nav-header">AKOMODASI</li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
          Akomodasi
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">6</span>
        </p>
      </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('admin.kunjunganakomodasi.index') }}" class="nav-link ? 'active' : '' ">
            <i class="nav-icon fas fa-th"></i>

            <p>
              Index bulanan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.kunjunganakomodasi.indexkunjunganakomodasipertahun') }}" class="nav-link ? 'active' : '' ">
            <i class="nav-icon fas fa-th"></i>

            <p>
              Index tahunan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        
        </li>
       
       
    </ul>
    </li>
    <li class="nav-header">REKAPAN</li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
          REKAPITULASI
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">6</span>
        </p>
      </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('admin.datakunjungan.semua') }}" class="nav-link ? 'active' : '' ">
            <i class="nav-icon fas fa-th"></i>

            <p>
              Index Tahun
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.datakunjungan.semuabulan') }}" class="nav-link ? 'active' : '' ">
            <i class="nav-icon fas fa-th"></i>

            <p>
              Index Bulan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        
        </li>
      
    </ul>
    </li>
  
  </ul>
</nav>
@endrole
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
            
          </p>
        </a>
      
      </li>

      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganwisata.realtime') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Realtime
            
          </p>
        </a>
      
      </li>
      
      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganwisata.indexkunjunganwisatapertahun') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>

          <p>
            Index tahunan
            
          </p>
        </a>
      
      </li>
     
      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganwisata.filterwisnubulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Wisnuperbulan
            
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganwisata.filterwismanbulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Wismanperbulan
            
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganwisata.createwisnu') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-edit nav-icon"></i>
            <p>
           Tambah Data
            </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganevent.create') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-edit nav-icon"></i>
            <p>
           Tambah Kunjungan Event
            </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganevent.indexkunjunganeventpertahun') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>

          <p>
            Index Event
            
          </p>
        </a>
      
      </li>
     
      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganwisata.index') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>

          <p>
            Index Ubah Data
            <i class="fas fa-edit nav-icon"></i>
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
        <a href="{{ route('account.kuliner.kunjungankuliner.realtime') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Realtime
            
          </p>
        </a>
      
      </li>
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.index') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>

          <p>
            Index Ubah Data
            <i class="fas fa-edit nav-icon"></i>
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
        <a href="{{ route('account.kuliner.kunjungankuliner.filterwisnubulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Wisnuperbulan
            
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.filterwismanbulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Wismanperbulan
            
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.createwisnu') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-edit nav-icon"></i>
            <p>
           Tambah Data
            </p>
        </a>
      </li>
      
  
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjunganevent.create') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-edit nav-icon"></i>
           Tambah Kunjungan Event
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjunganevent.indexkunjunganeventpertahun') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>

          <p>
            Index Event
            <i class="right fas fa-angle-left"></i>
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
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.realtime') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Realtime
            
          </p>
        </a>
      
      </li>
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.index') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>

          <p>
            Index Ubah Data
            <i class="fas fa-edit nav-icon"></i>
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
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.filterwisnubulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Wisnuperbulan
            
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.filterwismanbulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Wismanperbulan
            
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
        <a href="{{ route('account.akomodasi.kunjunganevent.create') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-edit nav-icon"></i>

            </i>
           Tambah Kunjungan Event
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganevent.indexkunjunganeventpertahun') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>

          <p>
            Index Event
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
      
      </li>
     

    </ul>
  </nav>
@endrole