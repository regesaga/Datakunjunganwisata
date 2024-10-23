<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users nav-icon">

                    </i>
                    Pengguna
                </a>
                <ul class="nav-dropdown-items">
                        {{-- <li class="nav-item">
                            
                            <a href="{{route('admin.permissions.index')}}" class="nav-link ? 'active' : '' ">
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
                            <a href="{{route('admin.users.index')}}" class="nav-link ? 'active' : '' ">
                                <i class="fa-fw fas fa-user nav-icon">

                                </i>
                               User
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.wisatawans.index')}}" class="nav-link ? 'active' : '' ">
                                <i class="fas fa-restroom nav-icon">

                                </i>
                               Profil Wisatawan
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.company.index')}}" class="nav-link ? 'active' : '' ">
                                <i class="fas fa-user-friends nav-icon">

                                </i>
                               Profile Pengusaha
                            </a>
                        </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-list nav-icon"></i>

                    Atribut
                </a>
                <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            
                            <a href="{{route('admin.categorywisata.index')}}" class="nav-link ? 'active' : '' ">
                                <i class="fa-fw fas fa-list nav-icon"></i>

                               Jenis Wisata
                            </a>
                        </li>
                        <li class="nav-item">
                            
                            <a href="{{route('admin.categorykuliner.index')}}" class="nav-link ? 'active' : '' ">
                                <i class="fa-fw fas fa-list nav-icon"></i>

                               Jenis Kuliner
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{route('admin.categoryakomodasi.index')}}" class="nav-link ? 'active' : '' ">
                                <i class="fa-fw fas fa-list nav-icon"></i>

                                Jenis Akomodasi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.categoryroom.index')}}" class="nav-link ? 'active' : '' ">
                                <i class="fa-fw fas fa-list nav-icon"></i>

                                Tipe Kamar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.fasilitas.index')}}" class="nav-link ? 'active' : '' ">
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
                            
                            <a href="{{route('admin.tag.index')}}" class="nav-link ? 'active' : '' ">
                                <i class="fa-fw fas fa-list nav-icon"></i>

                               Tag
                            </a>
                        </li>
                       
                        <li class="nav-item">
                            <a href="{{route('admin.article.index')}}" class="nav-link ? 'active' : '' ">
                                <i class="fas fa-edit nav-icon"></i>

                               Article/Berita
                            </a>
                        </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.wisata.index')}}" class="nav-link ? 'active' : '' ">
                    <i class="fas fa-umbrella-beach nav-icon"></i>
                    Wisata
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.pesanantiket.index')}}" class="nav-link ? 'active' : '' ">
                    <i class="far fa-address-card nav-icon"></i>
                    Tiket Wisata
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.paketwisata.index')}}" class="nav-link ? 'active' : '' ">
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
                        <a href="{{route('admin.kuliner.index')}}" class="nav-link ? 'active' : '' ">
                            <i class="fas fa-store nav-icon"></i>
                            Kuliner
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('admin.kulinerproduk.index')}}" class="nav-link ? 'active' : '' ">
                            <i class="fas fa-utensils nav-icon"></i>
                            Produk Kuliner
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('admin.pesanankuliner.index')}}" class="nav-link ? 'active' : '' ">
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
                        <a href="{{route('admin.akomodasi.index')}}" class="nav-link ? 'active' : '' ">
                            <i class="far fa-building nav-icon"></i>
                            Penginapan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('admin.room.index')}}" class="nav-link ? 'active' : '' ">
                            <i class="fas fa-bed nav-icon"></i>
                            Kamar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('admin.reserv.index')}}" class="nav-link ? 'active' : '' ">
                            <i class="far fa-address-card nav-icon"></i>
                            Reservasi
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.ekraf.index')}}" class="nav-link ? 'active' : '' ">
                    <i class="fa-fw fas fa-sitemap nav-icon"></i>
                    Ekraf
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.evencalender.index')}}" class="nav-link ? 'active' : '' ">
                    <i class="fa-fw fas fa-calendar nav-icon"></i>
                    Even Calender 
                </a>
            </li>
            {{-- <li class="nav-item">
                <a href="{{ route("calendar.calendar") }}" class="nav-link ? 'active' : '' ">
                    <i class="nav-icon fa-fw fas fa-calendar">

                    </i>
                    calender
                </a>
            </li> --}}
            <li class="nav-item">
                            
                <a href="{{route('admin.baners.index')}}" class="nav-link ? 'active' : '' ">
                    <i class="fas fa-images nav-icon"></i>

                   Baner
                </a>
            </li>
            
            <li class="nav-item">
                            
                <a href="{{route('admin.banerpromo.index')}}" class="nav-link ? 'active' : '' ">
                    <i class="far fa-images nav-icon"></i>

                   Baner Promo
                </a>
            </li>
            <li class="nav-item">
                            
                <a href="{{route('admin.support.index')}}" class="nav-link ? 'active' : '' ">
                    <i class="far fa-image nav-icon"></i>

                   Support By
                </a>
            </li>
           
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
