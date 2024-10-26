<header class="app-header navbar">
  <button class="navbar-toggler sidebar-toggler d-sm-none mr-auto" type="button" data-toggle="sidebar-lg-show">
      <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="{{route('account.wisata.user-wisata')}}">
    <img src="{{asset('images/logo/kuningankab.png')}}"   alt="logo" class="img-shadow" width="50">
  </a>
  <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
      <span class="navbar-toggler-icon"></span>
  </button>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      
      <li class="hidden-xs">
        <div class="font-medium text-right" style="margin:0;height:25px;">
        </div>
      </li>
      <li class="dropdown">
        <ul class="dropdown-menu dropdown-user scale-up">
            <li><a class="dropdown-item" href="{{route('account.wisata.changePassword')}}"><i class="fas fa-key fa-sm "></i>Ubah Password </a></li>
            <li> <a class="dropdown-item" href="{{route('account.wisata.logout')}}"><i class="fas fa-sign-out-alt"></i>Keluar</a></li>
          </ul>
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="padding-right: 45px;"><img class="img-profile rounded-circle" src="{{asset('images/logo/KuninganBeu.png')}}" width="40px"> </a>
          
      </li>
    </ul>
  <!-- /.navbar -->

</header>









