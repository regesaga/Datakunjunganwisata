<!DOCTYPE html>
<html lang="en">

@include('layouts.website.head')

<body>
    @include('layouts.website.navbar')
    @yield('content')
    
    @include('layouts.website.script')
    

</body>

</html>
