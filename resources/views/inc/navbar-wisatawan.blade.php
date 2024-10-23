<nav class="navbar navbar-expand-md navbar-white bg-white border-bottom sticky-top" id="navbar">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
        <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="account-nav-link">
                <i class=" 	fas fa-globe-asia"></i> Kuninganbeu
            </a>
        </li>
        <li class="list-group-item list-group-item-action {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
            <a href="{{ route('wisatawan.home') }}" class="account-nav-link">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        {{-- <li
            class="list-group-item list-group-item-action {{ request()->segment(2) == 'pesanantiketwisatawan' ? 'active' : '' }}">
            <a href="{{ route('wisatawan.pesanan') }}" class="account-nav-link">
                <i class=" 	fas fa-receipt"></i> Pesanan Saya
            </a>
        </li> --}}
        <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown dropdown-left">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="img-profile rounded-circle" src="{{ asset('images/logo/KuninganBeu.png') }}"
                            width="40px">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        {{-- <a class="dropdown-item" href="{{ route('wisatawan.index-change-password') }}"> <i
                                class="fas fa-key fa-sm "></i> Ganti Password </a> --}}
                                <a class="dropdown-item" href="{{ route('wisatawan.changeprofile') }}"> <i
                                    class="fas fa-user fa-sm "></i> Profile </a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('wisatawan.logout') }}">
                            <i class="fas fa-sign-out-alt"></i>
                            Keluar
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
