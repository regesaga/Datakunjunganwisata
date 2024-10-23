@extends('layouts.author.wisatawan')

@section('content')
    <div class="account-bdy p-3">
        <section class="author-company-info">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Detail Pesanan</h4>
                                    </div>
                                    <div class="card-body">
                                        @if($detailtiket->isNotEmpty())
                                            <table class="table table-bordered table-striped table-hover datatable datatable-wisata">
                                                <thead>
                                                    <tr>
                                                        <th>Nama</th>
                                                        <th>Harga</th>
                                                        <th>Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($detailtiket as $detail)
                                                        <tr>
                                                            <td>{{ $detail->kategori }}</td>
                                                            <td>Rp. {{ number_format($detail->harga, 0, ".", ".") }},-</td>
                                                            <td>{{ $detail->jumlah }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p>Data detail tiket tidak ditemukan.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
            </div>
        </section>
    </div>
    @endSection
    @push('css')
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @endpush
    @push('js')
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatables-demo.js') }}"></script>
    
    @endpush