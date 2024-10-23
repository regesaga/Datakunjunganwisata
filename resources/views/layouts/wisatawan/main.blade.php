<!DOCTYPE html>
<html lang="en">

@include('layouts.wisatawan.head')

<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    @include('layouts.wisatawan.navbar')

    {{-- <div class="app-body" id="dw"> --}}
    {{-- @include('layouts.wisatawan.menu') --}}
    {{-- @yield('content') --}}

    {{-- </div> --}}
    <div class="container my-4">
        <div class="account-layout">


            @yield('content')
        </div>
    </div>

    @include('layouts.wisatawan.script')

</body>

</html>
