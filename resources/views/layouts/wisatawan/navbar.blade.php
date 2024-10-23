{{-- <header class="app-header navbar">
    <div class="container-fluid">
        <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            <li class="nav-item dropdown hidden-caret">
                <a class="nav-link dropdown-toggle profile-pic" href="#" id="notifDropdown" role="button"
                    data-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="fa fa-user"></i>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="profile-lg">
                                    <div class="nav-link dropdown-toggle profile-pic">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                <div class="user-detail" style="margin-top: auto; margin-bottom: auto;">
                                    <h4>{{ Auth::guard('wisatawans')->user()->name }}</h4>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i>
                                Logout</a>
                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div> --}}
{{-- </header> --}}
<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-sm-none mr-auto" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{route('admin.index')}}">
      <img src="{{asset('images/logo/kuningankab.png')}}"   alt="logo" class="img-shadow" width="50">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        
        <li class="nav-item dropdown hidden-caret">
            <a class="nav-link dropdown-toggle profile-pic" href="#" id="notifDropdown" role="button"
                data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="fa fa-user"></i>
            </a>
            <ul class="dropdown-menu dropdown-user animated fadeIn dropdown-menu-right" aria-labelledby="notifDropdown">                <div class="dropdown-user-scroll scrollbar-outer">
                    <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('wisatawan.logout') }}"><i class="fas fa-sign-out-alt"></i>
                            Logout</a>
                    </li>
                </div>
            </ul>
        </li>

      </ul>
    <!-- /.navbar -->
  
  </header>
  
  
  
  
  
  
  
  
  
  