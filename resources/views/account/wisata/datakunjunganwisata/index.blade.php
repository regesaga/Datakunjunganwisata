@extends('layouts.datakunjungan.datakunjungan')

@section('content')
    <!-- Main content -->
    <style>
        #map {
            height: 900px;
            width: 100%;
            position: relative;
            overflow: auto;
        }

        .text-container {
            width: 150px;
            /* Atur lebar elemen sesuai kebutuhan */
            /* Menampilkan tanda elipsis (...) jika teks melebihi lebar */
        }
    </style>
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <section class="content">
                    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

                    <!-- Content Row -->
                 


                    <!-- Content Row -->

                </section>
            </div>
        </div>
    </main>
@endsection
<link href="{{ asset('map-icons-master/dist/css/map-icons.css') }}" rel="stylesheet" />

<script type="text/javascript" src="{{ asset('map-icons-master/dist/js/map-icons.js') }}"></script>

</script>
@section('scripts')
 
@endsection
