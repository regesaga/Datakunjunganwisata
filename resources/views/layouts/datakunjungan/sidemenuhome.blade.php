
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <a href="{{ route('HomeDataKunjungan') }}" class="nav-link ? 'active' : '' ">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Dashboard
        </p>
      </a>
    
    </li>
    <li class="nav-item">
      <a href="{{ route('realtimes') }}" class="nav-link ? 'active' : '' ">
        <i class="nav-icon fas fa-clock"></i>
        <p>
          Realtime
          
        </p>
      </a>
    
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
          <a href="{{ route('rekapsemua') }}" class="nav-link ? 'active' : '' ">
            <i class="nav-icon fas fa-th"></i>

            <p>
              Index Tahun
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        
        </li>
        <li class="nav-item">
          <a href="{{ route('rekapsemuabulan') }}" class="nav-link ? 'active' : '' ">
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