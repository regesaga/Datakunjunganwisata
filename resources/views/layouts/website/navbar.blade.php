<header id="header" class="fixed-top">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="logo me-auto">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo/KuninganBeu_Putih.png') }}" alt=""
                    style="height: 100px; width: auto; margin-right: 3px;">
            </a>
        </h1>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class=" scrollto" href="{{ route('website.articel') }}">{{ __('messages.articel') }}</a></li>
                <li><a class=" scrollto" href="{{ route('website.destinasi') }}">{{ __('messages.tour') }}</a>
                </li>
                <li><a class=" scrollto" href="{{ route('website.kuliner') }}">{{ __('messages.culinary') }}</a></li>
                <li><a class=" scrollto" href="{{ route('website.akomodasi') }}">{{ __('messages.accommodation') }}</a></li>
                <li><a class=" scrollto" href="{{ route('website.event') }}">{{ __('messages.event') }}</a></li>
                <li><a class=" scrollto" href="{{ route('website.petawisata') }}">{{ __('messages.touristMap') }}</a>
                </li>
                <li><a class=" scrollto"
                    href="{{ route('kemitraan') }}">{{ __('messages.partner') }}</a>
                </li>
                @if (auth()->guard('wisatawans')->check())
    <li><a class="btn-sign" href="{{ route('wisatawan.home') }}"><i class="fa fa-sign-in"></i> Dashboard</a></li>
@else
    <li><a class="btn-sign" href="{{ route('wisatawan.login') }}"><i class="fa fa-sign-in"></i> {{ __('messages.login') }}</a></li>
@endif
                <li class="language-dropdown">
                    <a class="scrollto" href="#bahasa">
                        {{ app()->getLocale() == 'id' ? 'ID' : 'EN' }} &nbsp;<i class="fas fa-sort-down"></i>
                        <!-- Ikon drop-down dari Font Awesome -->
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('change_locale', ['locale' => 'id']) }}">Indonesia</a></li>
                        <li><a href="{{ route('change_locale', ['locale' => 'en']) }}">English</a></li>
                    </ul>
                </li>

            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
    </div>
</header>
