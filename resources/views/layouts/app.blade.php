<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KFVQC7V');</script>
    <!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name')?? 'KuninganBeu' }}</title>


    <!-- Scripts -->

    <link rel="shortcut icon" type="image/png" href="{{asset('icon/KuninganBeu_Kuning.png')}}" />
    <!-- Fonts -->

    <!-- Styles -->


    <link href="{{ asset('dinas/css/font-awesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/all.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/buttons.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/select.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/dropzone.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
  	<link rel="stylesheet" type="text/css" href="/admin/dist/bootstrap-clockpicker.min.css">

</head>
<body>
  <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KFVQC7V"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->  
    <div id="app">
       @yield('layout-holder')
    </div>
    @include('sweetalert::alert')
    <script src="{{ asset('dinas/js/jquery.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/bootstrap.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/popper.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/coreui.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/jquery.dataTables.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/dataTables.bootstrap4.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/dataTables.buttons.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/buttons.flash.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/buttons.html5.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/buttons.print.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/buttons.colVis.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/pdfmake.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/vfs_fonts.js') }}"></script> 
    <script src="{{ asset('dinas/js/jszip.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/dataTables.select.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/ckeditor.js') }}"></script> 
    <script src="{{ asset('dinas/js/moment.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/bootstrap-datetimepicker.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/select2.full.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/dropzone.min.js') }}"></script> 
 
    @yield('scripts')
</body>
</html>
