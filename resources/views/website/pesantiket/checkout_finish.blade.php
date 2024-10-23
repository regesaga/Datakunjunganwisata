<!DOCTYPE html>
<html lang="en">

<body>
    
    <link href="{{ asset('css/tiketwisata.css') }}" rel="stylesheet">

<!--================Home Banner Area =================-->

        <div class="container">
            <div class="row--center">
                <a href="{{ route('home') }}"><button id="back" class="back-button">Kembali</button></a>
                <button id="downloadButton" class="download-button">Download Tiket</button>
            </div>
            <div class="ticket kuninganbeu">

                <div class="top">
                    <h1>Tiket Wisata Kuninganbeu</h1>
                    <div class="image">
                    <img src="{{ asset('images/logo/KuninganBeu_Putih.png') }}" style="max-height: 50px; width: auto;" >
                    </div>
                    {{-- <div class="image1">
                        <img src="{{ asset('images/logo/disporapar.png') }}" style="max-height: 30px; width: auto;" >
                        </div> --}}
                    <div class="big">
                        <h2>
                        {{ $pesantiket->wisata->namawisata }} </h2>

                        <br>
                <div class="row--center"><p>{{ $pesantiket->kodetiket }}</p></div>

                    </div>

                    <div class="top--side">
                        <p>Scan QR Code</p>
                       <p> {!! QrCode::size(150)->generate($pesantiket->kodetiket) !!}</p>
                    </div>

                </div>
                
                <div class="bottom">
                    <div class="column">
                        <div class="row row-1">
                            <p><span>Nama Pemesan</span>{{ $pesantiket->wisatawan->name }}</p>
                            <p class="row--right"><span>Metode Pembayaran</span>{{ $pesantiket->metodepembayaran }}</p>
                        </div>
                        <br>
                        <div class="row row-1">
                            <p>Rombongan</p>
                        </div>
                        @foreach($pesantiketDetails as $key => $pesantiketDetails)
                        <div class="row row-2">
                            
                            <p><span>Jenis Tiket</span>{{ $pesantiketDetails->kategori}}</p>
                            <p class="row--center"><span>Harga</span>Rp. {{ number_format($pesantiketDetails->harga, 0, ".", ".") }},-</p>
                            <p class="row--right"><span>Jumlah</span>{{$pesantiketDetails->jumlah}}</p>
                        </div>
                        @endforeach
                        <div class="row row-3">
                            <p><span>Tanggal Cetak</span>{{ date('d-m-Y', strtotime($pesantiket->created_at)) }}</p>
                            <p class="row--right"><span>Tanggal Kunjungan</span>{{ date('d-m-Y', strtotime($pesantiket->tanggalkunjungan)) }}</p>
                        </div>
                    </div>
                    <div class="row--center"><p>Datang Sesuai tanggal Tiket !</p></div>
                    <div class="row--center"><p>Mohon Untuk Konfirmasi terlebih dahulu ke nomer</p></div>
                    <div class="row--center"><p>{{ $pesantiket->wisata->telpon }} {{ $pesantiket->wisata->namawisata }} </p></div>
                    <div class="row--center"><p>Simpan dan Scan Tiket ini di Loket</p></div>
                    <div class="row--center"><h2>Rp {{ number_format($pesantiket->totalHarga) }}</h2></div>
                </div>
                
            </div>
            
        
        
        </div>

        <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
        <script>
            document.getElementById('downloadButton').addEventListener('click', function() {
                html2canvas(document.querySelector('.ticket')).then(function(canvas) {
                    var link = document.createElement('a');
                    link.download = 'tiket.png';
                    link.href = canvas.toDataURL();
                    link.click();
                });
            });
        </script>
        


</body>

</html>
