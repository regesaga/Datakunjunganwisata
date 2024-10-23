<div class="container-scroll">
    <div class="menu-scroll active">
        <ul class="menu-scroll-child">
            <li class="menu-scroll-gchild">
                <a href="{{ route('website.articel') }}">
                    <img class="menu-scroll-image" src="{{asset('images/logo/artikel.png')}}" alt="">
                    <p class="menu-scroll-text"><b style="font-family:'roboto bold',sans-serif !important">{{ __('messages.articel') }}</b></p>
                </a>
            </li>
            <li class="menu-scroll-gchild">
                <a href="{{ route('website.destinasi') }}">
                    <img class="menu-scroll-image" src="{{asset('images/logo/wisata.png')}}" alt="">
                    <p class="menu-scroll-text"><b style="font-family:'roboto bold',sans-serif !important">{{ __('messages.tour') }}</b></p>
                </a>
            </li>
            <li class="menu-scroll-gchild">
                <a href="{{ route('website.kuliner') }}">
                    <img class="menu-scroll-image" src="{{asset('images/logo/culiner.png')}}" alt="">
                    <p class="menu-scroll-text"><b style="font-family:'roboto bold',sans-serif !important">{{ __('messages.culinary') }}</b></p>
                </a>
            </li>
            <li class="menu-scroll-gchild">
                <a href="{{ route('website.akomodasi') }}">
                    <img class="menu-scroll-image" src="{{asset('images/logo/akomodasi.png')}}" alt="">
                    <p class="menu-scroll-text"><b style="font-family:'roboto bold',sans-serif !important">{{ __('messages.accommodation') }}</b></p>
                </a>
            </li>
            <li class="menu-scroll-gchild">
                <a href="{{ route('website.event') }}">
                    <img class="menu-scroll-image" src="{{asset('images/logo/eventt.png')}}" alt="">
                    <p class="menu-scroll-text"><b style="font-family:'roboto bold',sans-serif !important">{{ __('messages.event') }}</b></p>
                </a>
            </li>

        </ul>
    </div>
</div>