
             
    
       

          @role('wisata')
            <nav class="navbar navbar-expand-md navbar-white bg-white border-bottom sticky-top" id="navbar">
              <div class="container">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                    </button>
                  <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'dashboard' ? 'active': ''}}">
                    <a href="{{ route('account.wisata.user-wisata') }}" class="account-nav-link">
                      <i class="fa fa-id-card"></i> Dashboard
                    </a>
                  </li>
                      {{-- <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'postadmin' && request()->segment(3) == 'create' ? 'active': ''}}">
                        <a href="" class="account-nav-link">
                          <i class="fas fa-plus-square"></i> Buat Loker
                      </li> --}}
                  {{-- <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'getwisatawan' ? 'active': ''}}">
                    <a href="{{ route('account.wisata.getwisatawan') }}" class="account-nav-link">
                      <i class="fas fa-users"></i> Wisatawan
                    </a>
                  </li> --}}
                  <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'get_allfasilitas' ? 'active': ''}}">
                    <a href="{{ route('account.wisata.fasilitas.index') }}" class="account-nav-link">
                      <i class="fas fa-receipt"></i> Fasilitas
                    </a>
                  </li>
                  {{-- <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'cek' ? 'active': ''}}">
                    <a href="{{ route('account.wisata.validasitiket.index') }}" class="account-nav-link">
                      <i class="fas fa-search"></i> Validasi Tiket
                    </a>
                  </li> --}}
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                      <li class="nav-item dropdown dropdown-left">
                      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                        <img class="img-profile rounded-circle" src="{{asset('images/logo/KuninganBeu.png')}}" width="40px"> 
                      </a>
                      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">  
                      <a class="dropdown-item" href="{{route('account.wisata.changePassword')}}"> <i class="fas fa-key fa-sm "></i> Ganti Password </a> 
                    
                        <div class="dropdown-divider"></div> 
                        <a class="dropdown-item" href="{{route('account.wisata.logout')}}"> 
                          <i class="fas fa-sign-out-alt"></i> 
                          Keluar 
                        </a>
                      </div>
                    </li> 
                  </ul>
                    </div>
              </div>
            </nav>
          @endrole
          @role('kuliner')
          <nav class="navbar navbar-expand-md navbar-white bg-white border-bottom sticky-top" id="navbar">
              <div class="container">
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <i class="fas fa-bars"></i>
                  </button>
            <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'dashboard' ? 'active': ''}}">
              <a href="{{ route('account.kuliner.user-kuliner') }}" class="account-nav-link">
                <i class="fa fa-id-card"></i> Dashboard
              </a>
            </li>
                
            {{-- <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'getwisatawan' ? 'active': ''}}">
              <a href="{{ route('account.kuliner.getwisatawan') }}" class="account-nav-link">
                <i class="fas fa-users"></i> Wisatawan
              </a>
            </li> --}}
            <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'get_allfasilitas' ? 'active': ''}}">
              <a href="{{ route('account.kuliner.fasilitas.index') }}" class="account-nav-link">
                <i class="fas fa-receipt"></i> Fasilitas
              </a>
            </li>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown dropdown-left">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                  <img class="img-profile rounded-circle" src="{{asset('images/logo/KuninganBeu.png')}}" width="40px"> 
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">  
                <a class="dropdown-item" href="{{route('account.kuliner.changePassword')}}"> <i class="fas fa-key fa-sm "></i> Ganti Password </a> 
              
                  <div class="dropdown-divider"></div> 
                  <a class="dropdown-item" href="{{route('account.kuliner.logout')}}"> 
                    <i class="fas fa-sign-out-alt"></i> 
                    Keluar 
                  </a>
                </div>
              </li> 
            </ul>
      
                    
              </div>
            </div>
          </nav>
          @endrole
          @role('akomodasi')
          <nav class="navbar navbar-expand-md navbar-white bg-white border-bottom sticky-top" id="navbar">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
                </button>
                <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'dashboard' ? 'active': ''}}">
                  <a href="{{ route('account.akomodasi.user-akomodasi') }}" class="account-nav-link">
                    <i class="fa fa-id-card"></i> Dashboard
                  </a>
                  
                </li>
                    
                {{-- <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'getwisatawan' ? 'active': ''}}">
                  <a href="{{ route('account.akomodasi.getwisatawan') }}" class="account-nav-link">
                    <i class="fas fa-users"></i> Wisatawan
                  </a>
                </li> --}}
                <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'get_allfasilitas' ? 'active': ''}}">
                  <a href="{{ route('account.akomodasi.fasilitas.index') }}" class="account-nav-link">
                    <i class="fas fa-receipt"></i> Fasilitas
                  </a>
                </li>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown dropdown-left">
                      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                        <img class="img-profile rounded-circle" src="{{asset('images/logo/KuninganBeu.png')}}" width="40px"> 
                      </a>
                      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">  
                        <a class="dropdown-item" href="{{route('account.akomodasi.changePassword')}}"> <i class="fas fa-key fa-sm "></i> Ganti Password </a> 
                    
                        <div class="dropdown-divider"></div> 
                        <a class="dropdown-item" href="{{route('account.akomodasi.logout')}}"> 
                          <i class="fas fa-sign-out-alt"></i> 
                          Keluar 
                        </a>
                      </div>
                    </li> 
                  </ul>
          
                        
                </div>
            </div>
          </nav>
            
          @endrole
          @role('ekraf')
          <nav class="navbar navbar-expand-md navbar-white bg-white border-bottom sticky-top" id="navbar">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                    </button>
              <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'dashboard' ? 'active': ''}}">
                <a href="{{ route('account.ekraf.user-ekraf') }}" class="account-nav-link">
                  <i class="fa fa-id-card"></i> Dashboard
                </a>
              </li>
                
              {{-- <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'getwisatawan' ? 'active': ''}}">
                <a href="{{ route('account.ekraf.getwisatawan') }}" class="account-nav-link">
                  <i class="fas fa-users"></i> Wisatawan
                </a>
              </li> --}}
              <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'view-all-pencaris' ? 'active': ''}}">
                <a href="" class="account-nav-link">
                  <i class="fas fa-receipt"></i> Pesanan
                </a>
              </li>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                  <li class="nav-item dropdown dropdown-left">
                  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                    <img class="img-profile rounded-circle" src="{{asset('images/logo/KuninganBeu.png')}}" width="40px"> 
                  </a>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">  
                  <a class="dropdown-item" href="{{route('account.ekraf.changePassword')}}"> <i class="fas fa-key fa-sm "></i> Ganti Password </a> 
                
                    <div class="dropdown-divider"></div> 
                    <a class="dropdown-item" href="{{route('account.ekraf.logout')}}"> 
                      <i class="fas fa-sign-out-alt"></i> 
                      Keluar 
                    </a>
                  </div>
                </li> 
              </ul>
        
                      
                </div>
              </div>
          </nav>
          @endrole
          @role('guide')
          <nav class="navbar navbar-expand-md navbar-white bg-white border-bottom sticky-top" id="navbar">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
                </button>
          <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'dashboard' ? 'active': ''}}">
            <a href="{{ route('account.guide.user-guide') }}" class="account-nav-link">
              <i class="fa fa-id-card"></i> Dashboard
            </a>
          </li>
             
          {{-- <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'getwisatawan' ? 'active': ''}}">
            <a href="{{ route('account.guide.getwisatawan') }}" class="account-nav-link">
              <i class="fas fa-users"></i> Wisatawan
            </a>
          </li> --}}
          <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'view-all-pencaris' ? 'active': ''}}">
            <a href="" class="account-nav-link">
              <i class="fas fa-receipt"></i> Pesanan
            </a>
          </li>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item dropdown dropdown-left">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                <img class="img-profile rounded-circle" src="{{asset('images/logo/KuninganBeu.png')}}" width="40px"> 
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">  
              <a class="dropdown-item" href="{{route('account.guide.changePassword')}}"> <i class="fas fa-key fa-sm "></i> Ganti Password </a> 
             
                <div class="dropdown-divider"></div> 
                <a class="dropdown-item" href="{{route('account.guide.logout')}}"> 
                  <i class="fas fa-sign-out-alt"></i> 
                  Keluar 
                </a>
              </div>
            </li> 
          </ul>
    
                   
            </div>
          </div>
        </nav>
          @endrole
         
     
  


  

 