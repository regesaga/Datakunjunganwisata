<!DOCTYPE html>
<html lang="en">

<body>
    
    <link href="{{ asset('css/tiketkuliner.css') }}" rel="stylesheet">

<!--================Home Banner Area =================-->

        <div class="container">
            <div class="row--center">
                <a href="{{ route('home') }}"><button id="back" class="back-button">Kembali</button></a>
                <button id="downloadButton" class="download-button">Download Pesanan</button>
            </div>
            <div class="ticket kuninganbeu">

                <div class="top">
                    <h1>Order Kuliner Kuninganbeu</h1>
                    <div class="image">
                    <img src="{{ asset('images/logo/KuninganBeu_Putih.png') }}" style="max-height: 50px; width: auto;" >
                    </div>
                    {{-- <div class="image1">
                        <img src="{{ asset('images/logo/disporapar.png') }}" style="max-height: 30px; width: auto;" >
                        </div> --}}
                    <div class="big">
                        <h2>
                        {{ $pesankuliner->kuliner->namakuliner }} </h2>

                        <br>
                <div class="row--center"><p>{{ $pesankuliner->kodepesanan }}</p></div>

                    </div>

                    <div class="top--side">
                        <p>Scan QR Code</p>
                       <p> {!! QrCode::size(150)->generate($pesankuliner->kodepesanan) !!}</p>
                    </div>

                </div>
                
                <div class="bottom">
                    <div class="column">
                        <div class="row row-1">
                            <p><span>Nama Pemesan</span>{{ $pesankuliner->wisatawan->name }}</p>
                            <p class="row--right"><span>Metode Pembayaran</span>{{ $pesankuliner->metodepembayaran }}</p>
                        </div>
                        <br>
                        <div class="row row-1">
                            <p>Detail Pesanan</p>
                        </div>
                        @foreach($pesankulinerDetails as $key => $pesankulinerDetails)
                        <div class="row row-2">
                            
                            <p><span>Nama</span>{{ $pesankulinerDetails->nama}}</p>
                            <p class="row--center"><span>Harga</span>Rp. {{ number_format($pesankulinerDetails->harga, 0, ".", ".") }},-</p>
                            <p class="row--right"><span>Jumlah</span>{{$pesankulinerDetails->jumlah}} </p>
                        </div>
                        @endforeach
                        <div class="row row-3">
                            <p><span>Tanggal Cetak</span>{{ date('d-m-Y', strtotime($pesankuliner->created_at)) }}</p>
                            <p class="row--right"><span>Tanggal Kunjungan</span>{{ date('d-m-Y', strtotime($pesankuliner->tanggalkunjungan)) }}</p>
                        </div>
                    </div>
                    <div class="row--center"><p>Datang Sesuai tanggal Pesanan !</p></div>
                    <div class="row--center"><p>Mohon Untuk Konfirmasi terlebih dahulu ke nomer</p></div>
                    <div class="row--center"><p>{{ $pesankuliner->kuliner->telpon }} {{ $pesankuliner->kuliner->namakuliner }} </p></div>
                    <div class="row--center"><p>Simpan dan Scan Pesanan ini di Loket</p></div>
                    <div class="row--center"><h2>Rp {{ number_format($pesankuliner->totalHarga) }}</h2></div>
                </div>
                
            </div>
            
        
        
        </div>

        <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
        <script>
            document.getElementById('downloadButton').addEventListener('click', function() {
                html2canvas(document.querySelector('.ticket')).then(function(canvas) {
                    var link = document.createElement('a');
                    link.download = 'PesanKuliner.png';
                    link.href = canvas.toDataURL();
                    link.click();
                });
            });
        </script>
        


</body>

</html>
