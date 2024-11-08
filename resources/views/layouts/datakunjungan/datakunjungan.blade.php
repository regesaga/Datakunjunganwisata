<!-- Font Awesome -->
<link href="{{ asset('datakunjungan/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />

<!-- fullCalendar -->
<link href="{{ asset('datakunjungan/plugins/fullcalendar/main.css') }}" rel="stylesheet" />
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('datakunjungan/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('datakunjungan/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('datakunjungan/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<!-- Theme style -->
<link href="{{ asset('datakunjungan/dist/css/adminlte.min.css') }}" rel="stylesheet" />
</head>
<body class="hold-transition sidebar-mini">
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
    <!-- Sidebar user panel (optional) -->
    
    <!-- Sidebar Menu -->
    @include('layouts.datakunjungan.sidemenu')
    <!-- /.sidebar-menu -->
  <!-- /.sidebar -->
</aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        @yield('content')
    </div>

 <!-- /.content-wrapper -->


    
  <!-- ./wrapper -->
    
  <!-- jQuery -->
  <script src="{{ asset('datakunjungan/plugins/jquery/jquery.min.js') }}"></script>
  
  <!-- Bootstrap -->
  <script src="{{ asset('datakunjungan/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  
  <!-- jQuery UI -->
  <script src="{{ asset('datakunjungan/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  
  <!-- AdminLTE App -->
  <script src="{{ asset('datakunjungan/dist/js/adminlte.min.js') }}"></script>
  
  <!-- fullCalendar 2.2.5 -->
  <script src="{{ asset('datakunjungan/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('datakunjungan/plugins/fullcalendar/main.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('datakunjungan/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('datakunjungan/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
  <script src="../dist/js/demo.js"></script>
  <!-- Page specific script -->
 
    @yield('scripts')

  </body>
  </html>
  
