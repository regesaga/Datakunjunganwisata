<!doctype html>
<html>
<head>
 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Informasi Pariwisata KuninganBeu</title>


    <!-- Scripts -->
    <link href="{{ asset('images/logo/KuninganBeu.png')}}" rel="icon">
    <link href="{{ asset('images/logo/KuninganBeu_Kuning.png')}}" rel="apple-touch-icon">
    <!-- Fonts -->

    <!-- Styles -->

    <link href="{{ asset('dinas/css/bootstrap.min.css') }}" rel="stylesheet" />
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
  @include('inc.navbar')
  <div class="container my-4">
    <div class="account-layout">
      
        
                    @yield('content')
                </div>
            </div>

    @include('sweetalert::alert')
  
        <script src="{{ asset('dinas/js/jquery.min.js') }}"></script> 
        <script src="{{ asset('dinas/js/pdfmake.min.js') }}"></script> 
        <script src="{{ asset('dinas/js/vfs_fonts.js') }}"></script> 
        <script src="{{ asset('dinas/js/jszip.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/jquery.dataTables.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/dataTables.bootstrap4.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/bootstrap.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/popper.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/coreui.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/moment.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/bootstrap-datetimepicker.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/select2.full.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/dropzone.min.js') }}"></script> 
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
      $(function() {
let copyButtonTrans = '{{ trans('copy') }}'
let csvButtonTrans = '{{ trans('Simpan csv') }}'
let excelButtonTrans = '{{ trans('Simpan excel') }}'
let pdfButtonTrans = '{{ trans('Simpan pdf') }}'
let printButtonTrans = '{{ trans('Simpan print') }}'
let colvisButtonTrans = '{{ trans('Baris Tabel') }}'

let languages = {
  'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json'
};

$.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
$.extend(true, $.fn.dataTable.defaults, {
  language: {
    url: languages['{{ app()->getLocale() }}']
  },
  columnDefs: [{
      orderable: false,
      className: 'select-checkbox',
      targets: 0
  }, {
      orderable: false,
      searchable: false,
      targets: -1
  }],
  select: {
    style:    'multi+shift',
    selector: 'td:first-child'
  },
  order: [],
  scrollX: true,
  pageLength: 100,
  dom: 'lBfrtip<"actions">',
  buttons: [
    {
      extend: 'copy',
      className: 'btn-default',
      text: copyButtonTrans,
      exportOptions: {
        columns: ':visible'
      }
    },
    {
      extend: 'csv',
      className: 'btn-default',
      text: csvButtonTrans,
      exportOptions: {
        columns: ':visible'
      }
    },
    {
      extend: 'excel',
      className: 'btn-default',
      text: excelButtonTrans,
      exportOptions: {
        columns: ':visible'
      }
    },
    {
      extend: 'pdf',
      className: 'btn-default',
      text: pdfButtonTrans,
      exportOptions: {
        columns: ':visible'
      }
    },
    {
      extend: 'print',
      className: 'btn-default',
      text: printButtonTrans,
      exportOptions: {
        columns: ':visible'
      }
    },
    {
      extend: 'colvis',
      className: 'btn-default',
      text: colvisButtonTrans,
      exportOptions: {
        columns: ':visible'
      }
    }
  ]
});

$.fn.dataTable.ext.classes.sPageButton = '';
});

  </script>
    @stack('scripts')
    
</body>
</html>
