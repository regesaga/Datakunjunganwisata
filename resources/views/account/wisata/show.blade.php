@extends('layouts.author.account')
@section('content')
<div class="container">
       
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <a class="btn btn-info" href="{{ route("account.wisata.tiketwisata") }}">
                    {{ trans('Kemabali Cek') }} 
                </a>
                <div class="card">
                    <div class="card-header">
                        Tiket Ditemukan
                    </div>
            
                    <div class="card-body">
                        <table class="mt-3 table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Kode Tiket</th>
                                    <th scope="col">Wisatawan</th>
                                    <th scope="col">Tanggal Kunjungan</th>
                                    <th scope="col">Metode Pembayaran</th>
                                    <th scope="col">Status Pembayaran</th>
                                    <th scope="col">Status Pakai</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $pesantiket->kodetiket }}</td>
                                    <td>{{ $pesantiket->wisatawan->name }}</td>
                                    <td>{{ date('d-m-Y', strtotime($pesantiket->tanggalkunjungan)) }}</td>
                                    <td>{{ $pesantiket->metodepembayaran }}</td>
                                    @if ($pesantiket->payment_status == 00)
                                    <td><span class="badge badge-info ">Menunggu Pembayaran</span></td>
                                @elseif ($pesantiket->payment_status == 11)
                                    <td><span class="badge badge-success">Sudah di Bayar</span></td>
                                @elseif ($pesantiket->payment_status == 22)
                                    <td><span class="badge badge-warning">Kadaluarsa</span></td>
                                @elseif ($pesantiket->payment_status == 33)
                                    <td><span class="badge badge-danger">Batal</span></td>
                                @endif
                                    @if ($pesantiket->statuspemakaian == 00)
                                        <td><span class="badge badge-info ">Belum Terpakai</span></td>
                                    @elseif ($pesantiket->statuspemakaian == 11)
                                        <td><span class="badge badge-success">Sudah Terpakai</span></td>
                                    @elseif ($pesantiket->statuspemakaian == 22)
                                        <td><span class="badge badge-danger">Batal</span></td>
                                    @endif
                                    @if ($pesantiket->statuspemakaian == 00)
                                    <td>
                                        @if ($pesantiket->metodepembayaran == 'Online' && ($pesantiket->payment_status == 00 || $pesantiket->payment_status == 22 || $pesantiket->payment_status == 33))
                                            <span class="badge badge-danger">Lakukan Pembayaran terlebih dahulu</span>
                                            <form action="/wisata/tikettunai/{{ $pesantiket->kodetiket }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success btn-sm btn-sm">Checkin dengan Bayar Tunai</button>
                                            </form>
                                        @else
                                        <form action="/wisata/tiket/{{ $pesantiket->kodetiket }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Check-In</button>
                                        </form>
                                        @endif
                                    </td>
                                    
                                @elseif ($pesantiket->statuspemakaian == 2)
                                    <td>
                                        <span class="badge badge-danger">Pesanan Tidak Dapat Digunakan</span>
                                    </td>
                                @else
                                    <td>
                                        <span class="badge badge-success">Sudah Checkin</span>
                                    </td>
                                @endif

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <div class="card">
                <div class="card-header">
                    Detail Tiket Rombongan
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
    
@endsection