@extends('layouts.author.account')
@section('content')
<div class="container">
       
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <a class="btn btn-info" href="{{ route("account.kuliner.pesankuliner") }}">
                    {{ trans('Kemabali Cek') }} 
                </a>
                <div class="card">
                    <div class="card-header">
                        Pesanan Ditemukan
                    </div>
            
                    <div class="card-body">
                        <table class="mt-3 table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Kode Pesanan</th>
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
                                    <td>{{ $pesankuliner->kodepesanan }}</td>
                                    <td>{{ $pesankuliner->wisatawan->name }}</td>
                                    <td>{{ date('d-m-Y', strtotime($pesankuliner->tanggalkunjungan)) }}</td>
                                    <td>{{ $pesankuliner->metodepembayaran }}</td>
                                    @if ($pesankuliner->payment_status == 00)
                                    <td><span class="badge badge-info ">Menunggu Pembayaran</span></td>
                                @elseif ($pesankuliner->payment_status == 11)
                                    <td><span class="badge badge-success">Sudah di Bayar</span></td>
                                @elseif ($pesankuliner->payment_status == 22)
                                    <td><span class="badge badge-warning">Kadaluarsa</span></td>
                                @elseif ($pesankuliner->payment_status == 33)
                                    <td><span class="badge badge-danger">Batal</span></td>
                                @endif
                                    @if ($pesankuliner->statuspesanan == 00)
                                        <td><span class="badge badge-info ">Belum Terpakai</span></td>
                                    @elseif ($pesankuliner->statuspesanan == 11)
                                        <td><span class="badge badge-success">Sudah Terpakai</span></td>
                                    @elseif ($pesankuliner->statuspesanan == 22)
                                        <td><span class="badge badge-danger">Batal</span></td>
                                    @endif
                                    @if ($pesankuliner->statuspesanan == 00)
                                        <td>
                                            <form action="/kuliner/pesanan/{{ $pesankuliner->kodepesanan }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Check-In</button>
                                            </form>
                                        </td>
                                    @elseif ($pesankuliner->statuspesanan == 22)
                                        <td>
                                            <span class="badge badge-danger ">Pesanan Tidak Dapat Digunakan</span>
                                        </td>
                                    @else
                                        <td>
                                            <span class="badge badge-success ">Sudah Checkin</span>
                                        </td>
                                    @endif

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <div class="card">
                <div class="card-header">
                    Detail Pesanan Rombongan
                </div>
        
                <div class="card-body">
                    @if($detailkuliner->isNotEmpty())
                        <table class="table table-bordered table-striped table-hover datatable datatable-kuliner">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detailkuliner as $detail)
                                    <tr>
                                        <td>{{ $detail->nama }}</td>
                                        <td>Rp. {{ number_format($detail->harga, 0, ".", ".") }},-</td>
                                        <td>{{ $detail->jumlah }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Data detail kuliner tidak ditemukan.</p>
                    @endif
                </div>
            </div>
</div>
    
@endsection