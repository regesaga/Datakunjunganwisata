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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/main.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
{{-- @include('javascript.swal') --}}
@stack('javascript-bottom')
@include('sweetalert::alert')
