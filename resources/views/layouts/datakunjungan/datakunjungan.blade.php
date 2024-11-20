<!-- Font Awesome -->
<link href="{{ asset('datakunjungan/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />

<!-- fullCalendar -->
<link href="{{ asset('datakunjungan/plugins/fullcalendar/main.css') }}" rel="stylesheet" />
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('datakunjungan/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('datakunjungan/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('datakunjungan/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('datakunjungan/plugins/plugins/jqvmap/jqvmap.min.css')}}">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

<!-- Theme style -->
<link href="{{ asset('datakunjungan/dist/css/adminlte.min.css') }}" rel="stylesheet" />
</head>
<body class="hold-transition sidebar-mini layout-fixed">


<div class="wrapper">
<!-- Navbar -->
    @include('layouts.datakunjungan.navbar')

<!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="../index3.html" class="brand-link">
        <img src="{{ asset('images/logo/KuninganBeu_Kuning.png') }}" alt="Kuninganbeu" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Kuninganbeu</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        
        <!-- Sidebar Menu -->
        @include('layouts.datakunjungan.sidemenu')
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
            @yield('content')
      </div>

 <!-- /.content-wrapper -->


</div>
  <!-- ./wrapper -->
    
  <!-- jQuery -->
  <script src="{{ asset('datakunjungan/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('datakunjungan/datetimecostume.js') }}"></script>
  
  <!-- Bootstrap -->
  <script src="{{ asset('datakunjungan/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  
  <!-- jQuery UI -->
  <script src="{{ asset('datakunjungan/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  
  <!-- AdminLTE App -->
  <script src="{{ asset('datakunjungan/dist/js/adminlte.min.js') }}"></script>
  
  <!-- fullCalendar 2.2.5 -->
  <script src="{{ asset('datakunjungan/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('datakunjungan/plugins/fullcalendar/main.js') }}"></script>

  <!-- Page specific script -->
 
    @yield('scripts')

  </body>
  </html>
  
