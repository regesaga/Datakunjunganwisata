<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistem Informasi Pariwisata</title>
    <link href="{{ asset('images/logo/KuninganBeu.png') }}" rel="icon">
    <link href="{{ asset('images/logo/KuninganBeu_Kuning.png') }}" rel="apple-touch-icon">
    <link href="{{ asset('dinas/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/font-awesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/all.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/buttons.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/select.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/dropzone.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <style>
        .cuaca-box {
        flex-grow: 1;
        margin: 4px;
        background-color: #ffffff;
        border: 2px solid black;
        padding: 2px;
        border-radius: 10px;
        text-align: center;
    }
    </style>
    @yield('styles')

    <link rel="stylesheet" type="text/css" href="/admin/dist/bootstrap-clockpicker.min.css">


</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    @include('layouts.admin.header')

    <div class="app-body" id="dw">
        @include('layouts.admin.menu')
        @yield('content')

    </div>

    @include('sweetalert::alert')

    {{--  jequery selectc --}}
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

    <script src="{{ asset('dinas/js/moment.min.js') }}"></script>
    <script src="{{ asset('dinas/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('dinas/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('dinas/js/dropzone.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>

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

            $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {
                className: 'btn'
            })
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
                    style: 'multi+shift',
                    selector: 'td:first-child'
                },
                order: [],
                scrollX: true,
                pageLength: 100,
                dom: 'lBfrtip<"actions">',
                buttons: [{
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
    @yield('scripts')
</body>

</html>
