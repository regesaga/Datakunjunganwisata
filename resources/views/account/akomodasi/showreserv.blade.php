@extends('layouts.author.account')
@section('content')
<div class="container">
       
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <a class="btn btn-info" href="{{ route("account.akomodasi.reserv") }}">
                    {{ trans('Kemabali Cek') }} 
                </a>
                <div class="card">
                    <div class="card-header">
                        Reservasi Ditemukan
                    </div>
            
                    <div class="card-body">
                        <table class="mt-3 table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Kode Booking</th>
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
                                    <td>{{ $reserv->kodeboking }}</td>
                                    <td>{{ $reserv->wisatawan->name }}</td>
                                    <td>{{ date('d-m-Y', strtotime($reserv->tanggalkunjungan)) }}</td>
                                    <td>{{ $reserv->metodepembayaran }}</td>
                                    @if ($reserv->payment_status == 00)
                                    <td><span class="badge badge-info ">Menunggu Pembayaran</span></td>
                                @elseif ($reserv->payment_status == 11)
                                    <td><span class="badge badge-success">Sudah di Bayar</span></td>
                                @elseif ($reserv->payment_status == 22)
                                    <td><span class="badge badge-warning">Kadaluarsa</span></td>
                                @elseif ($reserv->payment_status == 33)
                                    <td><span class="badge badge-danger">Batal</span></td>
                                @endif
                                    @if ($reserv->statuspemakaian == 00)
                                        <td><span class="badge badge-info ">Belum Terpakai</span></td>
                                    @elseif ($reserv->statuspemakaian == 11)
                                        <td><span class="badge badge-success">Sudah Terpakai</span></td>
                                    @elseif ($reserv->statuspemakaian == 22)
                                        <td><span class="badge badge-danger">Batal</span></td>
                                    @endif
                                    @if ($reserv->statuspemakaian == 00)
                                        <td>
                                            <form action="/akomodasi/reserv/{{ $reserv->kodeboking }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Check-In</button>
                                            </form>
                                        </td>
                                    @elseif ($reserv->statuspemakaian == 22)
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
                    Detail Reservasi Rombongan
                </div>
        
                <div class="card-body">
                    @if($reservation->isNotEmpty())
                        <table class="table table-bordered table-striped table-hover datatable datatable-akomodasi">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservation as $detail)
                                    <tr>
                                        <td>{{ $detail->nama }}</td>
                                        <td>Rp. {{ number_format($detail->harga, 0, ".", ".") }},-</td>
                                        <td>{{ $detail->jumlah }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Data detail Reservasi tidak ditemukan.</p>
                    @endif
                </div>
            </div>
</div>
    
@endsection