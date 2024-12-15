
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
        </p>
      </a>
    
    </li>
    <li class="nav-item">
      <a href="{{ route('admin.datakunjungan.realtime') }}" class="nav-link ? 'active' : '' ">
        <i class="nav-icon fas fa-clock"></i>
        <p>
          Realtime
          
        </p>
      </a>
    
    </li>
    <li class="nav-item">
      <a href="{{ route('admin.targetkunjungan.index') }}" class="nav-link ? 'active' : '' ">
          <i class="far fa-newspaper nav-icon"></i>

          </i>
         Tambah Target
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('admin.targetkunjungan.perbandingan') }}" class="nav-link ? 'active' : '' ">
          <i class="fas fa-chart-bar nav-icon"></i>

         Realisasi
      </a>
    </li>
    
   
    <li class="nav-item">
        <a href="{{ route('admin.kelompokkunjungan.index') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-users nav-icon"></i>

            </i>
          Kelompok Kunjungan
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.wismannegara.index') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-globe nav-icon"></i>

            </i>
          Negara
        </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('admin.kunjunganevent.create') }}" class="nav-link ? 'active' : '' ">
          <i class="fas fa-edit nav-icon"></i>
          <p>
         Event
          </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('admin.kunjunganevent.indexkunjunganeventpertahun') }}" class="nav-link ? 'active' : '' ">
        <i class="nav-icon fas fa-bullhorn"></i>

        <p>
          Event
          
        </p>
      </a>
    
    </li>
    <li class="nav-header">WISATA</li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-image"></i>
        <p>
          Wisata
          <i class="fas fa-angle-left right"></i>
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
        <i class="nav-icon  	fas fa-cocktail"></i>
        <p>
          Kuliner
          <i class="fas fa-angle-left right"></i>
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
        <i class="nav-icon  	fas fa-hotel"></i>
        <p>
          Akomodasi
          <i class="fas fa-angle-left right"></i>
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
          <i class="nav-icon fas fa-clock"></i>
          <p>
            Realtime
            
          </p>
        </a>
      
      </li>
     

      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganwisata.createwisnu') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-edit nav-icon"></i>
            <p>
           Kunjungan
            </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.wisata.kunjunganevent.create') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-edit nav-icon"></i>
            <p>
           Event
            </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon far fa-newspaper"></i>
          <p>
            INDEX
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('account.wisata.kunjunganwisata.indexkunjunganwisatapertahun') }}" class="nav-link ? 'active' : '' ">
                <i class="nav-icon far fa-calendar-alt"></i>

                <p>
                  Tahunan
                </p>
              </a>
          </li>
        <li class="nav-item">
          <a href="{{ route('account.wisata.kunjunganwisata.filterwisnubulan') }}" class="nav-link ? 'active' : '' ">
            <i class="nav-icon fa fa-users"></i>
            <p>
              Nusantara
              
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('account.wisata.kunjunganwisata.filterwismanbulan') }}" class="nav-link ? 'active' : '' ">
            <i class="nav-icon fa fa-globe"></i>
            <p>
              Mancanegara
              
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('account.wisata.kunjunganevent.indexkunjunganeventpertahun') }}" class="nav-link ? 'active' : '' ">
            <i class="nav-icon fas fa-bullhorn"></i>

            <p>
            Event
              
            </p>
          </a>
        
        </li>
      
        <li class="nav-item">
          <a href="{{ route('account.wisata.kunjunganwisata.index') }}" class="nav-link ? 'active' : '' ">
            <i class="nav-icon fas fa-th"></i>

            <p>
              Ubah Data
              <i class="far fa-newspaper nav-icon"></i>
            </p>
          </a>
        
        </li>
        
      </li>  
      </ul>

      
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
          </p>
        </a>
      
      </li>
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.realtime') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-clock"></i>
          <p>
            Realtime
            
          </p>
        </a>
      </li>
      
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.createwisnu') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-edit nav-icon"></i>
            <p>
           Kunjungan
            </p>
        </a>
      </li>
      
  
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjunganevent.create') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-edit nav-icon"></i>
           Event
        </a>
      </li>

     
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon far fa-newspaper"></i>
          <p>
            INDEX
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.indexkunjungankulinerpertahun') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon far fa-calendar-alt"></i>

          <p>
            tahunan
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.filterwisnubulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fa fa-users"></i>
          <p>
            Nusantara
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.filterwismanbulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fa fa-globe"></i>
          <p>
            Mancanegara
            
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjunganevent.indexkunjunganeventpertahun') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-bullhorn"></i>


          <p>
            Event
          </p>
        </a>
      
      </li>
      <li class="nav-item">
        <a href="{{ route('account.kuliner.kunjungankuliner.index') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>

          <p>
            Ubah Data
            <i class="far fa-newspaper nav-icon"></i>
          </p>
        </a>
      
      </li>
    </li>
    </ul>
    
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
          </p>
        </a>
      
      </li>
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.realtime') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-clock"></i>
          <p>
            Realtime
            
          </p>
        </a>
      </li>
      
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.createwisnu') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-edit nav-icon"></i>
            <p>
           Kunjungan
            </p>
        </a>
      </li>
      
  
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganevent.create') }}" class="nav-link ? 'active' : '' ">
            <i class="fas fa-edit nav-icon"></i>
           Event
        </a>
      </li>

     
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon far fa-newspaper"></i>
          <p>
            INDEX
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.indexkunjunganakomodasipertahun') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon far fa-calendar-alt"></i>

          <p>
            tahunan
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.filterwisnubulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fa fa-users"></i>
          <p>
            Nusantara
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.filterwismanbulan') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fa fa-globe"></i>
          <p>
            Mancanegara
            
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganevent.indexkunjunganeventpertahun') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-bullhorn"></i>


          <p>
            Event
          </p>
        </a>
      
      </li>
      <li class="nav-item">
        <a href="{{ route('account.akomodasi.kunjunganakomodasi.index') }}" class="nav-link ? 'active' : '' ">
          <i class="nav-icon fas fa-th"></i>

          <p>
            Ubah Data
            <i class="far fa-newspaper nav-icon"></i>
          </p>
        </a>
      
      </li>
    </li>
    </ul>
    
    </ul>
  </nav>
@endrole

