<!DOCTYPE html>
<html lang="en">

<body>
    
    <link href="{{ asset('css/tiketakomodasi.css') }}" rel="stylesheet">

<!--================Home Banner Area =================-->

        <div class="container">
            <div class="row--center">
                <a href="{{ route('home') }}"><button id="back" class="back-button">Kembali</button></a>
                <button id="downloadButton" class="download-button">Download Invoice</button>
            </div>
            <div class="ticket kuninganbeu">

                <div class="top">
                    <h1>Reservasi Akomodasi Kuninganbeu</h1>
                    <div class="image">
                    <img src="{{ asset('images/logo/KuninganBeu_Putih.png') }}" style="max-height: 50px; width: auto;" >
                    </div>
                    {{-- <div class="image1">
                        <img src="{{ asset('images/logo/disporapar.png') }}" style="max-height: 30px; width: auto;" >
                        </div> --}}
                    <div class="big">
                        <h2>
                        {{ $reserv->akomodasi->namaakomodasi }} </h2>

                        <br>
                <div class="row--center"><p>{{ $reserv->kodeboking }}</p></div>

                    </div>

                    <div class="top--side">
                        <p>Scan QR Code</p>
                       <p> {!! QrCode::size(150)->generate($reserv->kodeboking) !!}</p>
                    </div>

                </div>
                
                <div class="bottom">
                    <div class="column">
                        <div class="row row-1">
                            <p><span>Nama Pemesan</span>{{ $reserv->wisatawan->name }}</p>
                            <p class="row--right"><span>Metode Pembayaran</span>{{ $reserv->metodepembayaran }}</p>
                        </div>
                        <br>
                        <div class="row row-1">
                            <p>Rombongan</p>
                        </div>
                        @foreach($reservation as $key => $reservation)
                        <div class="row row-2">
                            
                            <p><span>Jenis Kamar</span>{{ $reservation->nama}}</p>
                            <p class="row--center"><span>Harga</span>Rp. {{ number_format($reservation->harga, 0, ".", ".") }},-</p>
                            <p class="row--right"><span>Jumlah</span>{{$reservation->jumlah}}</p>
                        </div>
                        @endforeach
                        <div class="row row-3">
                            <p><span>Tanggal Cetak</span>{{ date('d-m-Y', strtotime($reserv->created_at)) }}</p>
                            <p class="row--right"><span>Tanggal Kunjungan</span>{{ date('d-m-Y', strtotime($reserv->tanggalkunjungan)) }}</p>
                        </div>
                    </div>
                    <div class="row--center"><p>Datang Sesuai tanggal Pesanan !</p></div>
                    <div class="row--center"><p>Mohon Untuk Konfirmasi terlebih dahulu ke nomer</p></div>
                    <div class="row--center"><p>{{ $reserv->akomodasi->telpon }} {{ $reserv->akomodasi->namaakomodasi }} </p></div>
                    <div class="row--center"><p>Simpan dan Scan Pesanan ini di Loket</p></div>
                    <div class="row--center"><h2>Rp {{ number_format($reserv->totalHarga) }}</h2></div>
                </div>
                
            </div>
            
        
        
        </div>

        <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
        <script>
            document.getElementById('downloadButton').addEventListener('click', function() {
                html2canvas(document.querySelector('.ticket')).then(function(canvas) {
                    var link = document.createElement('a');
                    link.download = 'Reservasi.png';
                    link.href = canvas.toDataURL();
                    link.click();
                });
            });
        </script>
        


</body>

</html>
