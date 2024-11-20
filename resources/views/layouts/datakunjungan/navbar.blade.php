@role('admin')
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
     
    </ul>
       <div class="navbar-nav-right d-flex align-items-center justify-content-between" id="navbar-collapse">
        <div class="navbar-nav">
            <div class="nav-item mb-0">
                <span class="fw-semibold fs-7">Hai, Selamat <span id="selamat"></span></span>
            </div>
        </div>
    </div>
    
   
     
    
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <div class="nav-item">
        <span class="badge badge-warning "id="dateTime" ></span>
      </div>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="padding-right: 45px;"><img class="img-profile rounded-circle" src="{{asset('images/logo/KuninganBeu.png')}}" width="40px"> </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="{{route('admin.changePassword')}}" class="dropdown-item ">
            <i class="fas fa-key mr-2"></i>Ubah Password
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{route('admin.logout')}}" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i>Keluar
          </a>
        </div>
      </li>
     
      
      
    </ul>
  </nav>
  @endrole
@role('wisata')
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
     
    </ul>
   
    <div class="navbar-nav-right d-flex align-items-center justify-content-between" id="navbar-collapse">
      <div class="navbar-nav">
          <div class="nav-item mb-0">
              <span class="fw-semibold fs-7">Hai, Selamat <span id="selamat"></span></span>
          </div>
      </div>
  </div>
  
 
   
  
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Notifications Dropdown Menu -->
    <div class="nav-item">
      <span class="badge badge-warning "id="dateTime" ></span>
    </div>
     
    
    
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="padding-right: 45px;"><img class="img-profile rounded-circle" src="{{asset('images/logo/KuninganBeu.png')}}" width="40px"> </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="{{route('account.wisata.changePassword')}}" class="dropdown-item ">
            <i class="fas fa-key mr-2"></i>Ubah Password
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{route('account.wisata.logout')}}" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i>Keluar
          </a>
        </div>
      </li>
     
      
      
    </ul>
  </nav>
  @endrole
@role('kuliner')
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    
    </ul>
  
    <div class="navbar-nav-right d-flex align-items-center justify-content-between" id="navbar-collapse">
      <div class="navbar-nav">
          <div class="nav-item mb-0">
              <span class="fw-semibold fs-7">Hai, Selamat <span id="selamat"></span></span>
          </div>
      </div>
  </div>


  

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Notifications Dropdown Menu -->
    <div class="nav-item">
      <span class="badge badge-warning "id="dateTime" ></span>
    </div>
  
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">15 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> 8 friend requests
          <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
    <li class="nav-item dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="padding-right: 45px;"><img class="img-profile rounded-circle" src="{{asset('images/logo/KuninganBeu.png')}}" width="40px"> </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <div class="dropdown-divider"></div>
        <a href="{{route('account.kuliner.changePassword')}}" class="dropdown-item ">
          <i class="fas fa-key mr-2"></i>Ubah Password
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{route('account.kuliner.logout')}}" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i>Keluar
        </a>
      </div>
    </li>
  </ul>
</nav>
@endrole
@role('akomodasi')
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
   
  </ul>
 
  <div class="navbar-nav-right d-flex align-items-center justify-content-between" id="navbar-collapse">
    <div class="navbar-nav">
        <div class="nav-item mb-0">
            <span class="fw-semibold fs-7">Hai, Selamat <span id="selamat"></span></span>
        </div>
    </div>
</div>


 

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
  <!-- Notifications Dropdown Menu -->
  <div class="nav-item">
    <span class="badge badge-warning "id="dateTime" ></span>
  </div>
 
  
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">15 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> 8 friend requests
          <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
    <li class="nav-item dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="padding-right: 45px;"><img class="img-profile rounded-circle" src="{{asset('images/logo/KuninganBeu.png')}}" width="40px"> </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <div class="dropdown-divider"></div>
        <a href="{{route('account.akomodasi.changePassword')}}" class="dropdown-item ">
          <i class="fas fa-key mr-2"></i>Ubah Password
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{route('account.akomodasi.logout')}}" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i>Keluar
        </a>
      </div>
    </li>
  </ul>
</nav>
@endrole
