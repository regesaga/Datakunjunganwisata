<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a href="{{ route('account.wisata.kunjunganwisata.index') }}" class="nav-link ? 'active' : '' ">
                    <i class="fa-fw fas fa-users nav-icon">

                    </i>
                   DashBoard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('account.wisata.kunjunganwisata.index') }}" class="nav-link ? 'active' : '' ">
                    <i class="fa-fw fas fa-users nav-icon">

                    </i>
                   Data Kunjungan
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

          

            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users nav-icon">

                    </i>
                    Laporan
                </a>
                <ul class="nav-dropdown-items">
                        {{-- <li class="nav-item">
                            
                            <a href="" class="nav-link ? 'active' : '' ">
                                <i class="fa-fw fas fa-unlock-alt nav-icon">

                                </i>
                               Permision
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}" class="nav-link ? ' active' : '' }}">
                                <img src="{{ asset('icon/role.svg') }}" class="nav-icon" alt="Role Icon">
                                Role
                            </a>
                        </li>
                         --}}
                        
                        <li class="nav-item">
                            <a href="" class="nav-link ? 'active' : '' ">
                                <i class="fa-fw fas fa-user nav-icon">

                                </i>
                               User
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="" class="nav-link ? 'active' : '' ">
                                <i class="fas fa-restroom nav-icon">

                                </i>
                               Profil Wisatawan
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="" class="nav-link ? 'active' : '' ">
                                <i class="fas fa-user-friends nav-icon">

                                </i>
                               Profile Pengusaha
                            </a>
                        </li>
                </ul>
            </li>
            {{-- <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-list nav-icon"></i>

                    Atribut
                </a>
                <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            
                            <a href="" class="nav-link ? 'active' : '' ">
                                <i class="fa-fw fas fa-list nav-icon"></i>

                               Jenis Wisata
                            </a>
                        </li>
                        <li class="nav-item">
                            
                            <a href="" class="nav-link ? 'active' : '' ">
                                <i class="fa-fw fas fa-list nav-icon"></i>

                               Jenis Kuliner
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="" class="nav-link ? 'active' : '' ">
                                <i class="fa-fw fas fa-list nav-icon"></i>

                                Jenis Akomodasi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link ? 'active' : '' ">
                                <i class="fa-fw fas fa-list nav-icon"></i>

                                Tipe Kamar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link ? 'active' : '' ">
                                <i class="fa-fw fas fa-list nav-icon"></i>

                               Fasilitas
                            </a>
                        </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="far fa-newspaper nav-icon"></i>

                    Article
                </a>
                <ul class="nav-dropdown-items">
                        
                        <li class="nav-item">
                            
                            <a href="" class="nav-link ? 'active' : '' ">
                                <i class="fa-fw fas fa-list nav-icon"></i>

                               Tag
                            </a>
                        </li>
                       
                        <li class="nav-item">
                            <a href="" class="nav-link ? 'active' : '' ">
                                <i class="fas fa-edit nav-icon"></i>

                               Article/Berita
                            </a>
                        </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link ? 'active' : '' ">
                    <i class="fas fa-umbrella-beach nav-icon"></i>
                    Wisata
                </a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link ? 'active' : '' ">
                    <i class="far fa-address-card nav-icon"></i>
                    Tiket Wisata
                </a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link ? 'active' : '' ">
                    <i class="fa-fw fas fa-tags nav-icon"></i>
                    Paket Wisata
                </a>
            </li>
         
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fas fa-utensils nav-icon"></i>

                    Kuliner
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="" class="nav-link ? 'active' : '' ">
                            <i class="fas fa-store nav-icon"></i>
                            Kuliner
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link ? 'active' : '' ">
                            <i class="fas fa-utensils nav-icon"></i>
                            Produk Kuliner
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link ? 'active' : '' ">
                            <i class="far fa-address-card nav-icon"></i>
                            Pesanan Kuliner
                        </a>
                    </li>
                </ul>
            </li>
            
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-hotel nav-icon"></i>

                    Akomodasi
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="" class="nav-link ? 'active' : '' ">
                            <i class="far fa-building nav-icon"></i>
                            Penginapan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link ? 'active' : '' ">
                            <i class="fas fa-bed nav-icon"></i>
                            Kamar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link ? 'active' : '' ">
                            <i class="far fa-address-card nav-icon"></i>
                            Reservasi
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link ? 'active' : '' ">
                    <i class="fa-fw fas fa-sitemap nav-icon"></i>
                    Ekraf
                </a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link ? 'active' : '' ">
                    <i class="fa-fw fas fa-calendar nav-icon"></i>
                    Even Calender 
                </a>
            </li>
           
            <li class="nav-item">
                            
                <a href="" class="nav-link ? 'active' : '' ">
                    <i class="fas fa-images nav-icon"></i>

                   Baner
                </a>
            </li>
            
            <li class="nav-item">
                            
                <a href="" class="nav-link ? 'active' : '' ">
                    <i class="far fa-images nav-icon"></i>

                   Baner Promo
                </a>
            </li>
            <li class="nav-item">
                            
                <a href="" class="nav-link ? 'active' : '' ">
                    <i class="far fa-image nav-icon"></i>

                   Support By
                </a>
            </li> --}}
           
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
