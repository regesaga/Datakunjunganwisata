<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY_UNRESTRICTED') }}">
</script>
<script>
    var markers = [];

    function filterMarkers() {
        var jenis = document.getElementById('jenis').value;
        for (var i = 0; i < markers.length; i++) {
            var marker = markers[i];
            if (jenis === 'all') {
                $('.wisata').attr('hidden', false)
                $('.kuliner').attr('hidden', false)
                $('.akomodasi').attr('hidden', false)
            } else if (jenis === 'wisata') {
                $('.wisata').attr('hidden', false)
                $('.kuliner').attr('hidden', true)
                $('.akomodasi').attr('hidden', true)
            } else if (jenis === 'kuliner') {
                $('.kuliner').attr('hidden', false)
                $('.wisata').attr('hidden', true)
                $('.akomodasi').attr('hidden', true)
            } else if (jenis === 'akomodasi') {
                $('.akomodasi').attr('hidden', false)
                $('.wisata').attr('hidden', true)
                $('.kuliner').attr('hidden', true)
            }
        }
    }

    function CustomMarker(latlng, map, imageSrc, jenis) {
        this.latlng_ = latlng;
        this.imageSrc = imageSrc;

        this.setMap(map);
    }
    CustomMarker.prototype = new google.maps.OverlayView();
    CustomMarker.prototype.draw = function() {
        // Check if the div has been created.
        var div = this.div_;
        if (!div) {
            // Create a overlay text DIV
            div = this.div_ = document.createElement('div');
            // Create the DIV representing our CustomMarker
            div.className = "customMarker " + this.jenis;

            var img = document.createElement("img");
            img.src = this.imageSrc;
            div.appendChild(img);
            var me = this;
            google.maps.event.addDomListener(div, "click", function(event) {
                google.maps.event.trigger(me, "click");
            });

            // Then add the overlay to the DOM
            var panes = this.getPanes();
            panes.overlayImage.appendChild(div);
        }
        // Position the overlay 
        var point = this.getProjection().fromLatLngToDivPixel(this.latlng_);
        if (point) {
            div.style.left = point.x + 'px';
            div.style.top = point.y + 'px';
        }
    };

    CustomMarker.prototype.remove = function() {
        // Check if the overlay was on the map and needs to be removed.
        if (this.div_) {
            this.div_.parentNode.removeChild(this.div_);
            this.div_ = null;
        }
    };

    CustomMarker.prototype.getPosition = function() {
        return this.latlng_;
    };

    var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng({{ $latitude }}, {{ $longitude }}),
        zoom: 11,
        minZoom: 6,
        maxZoom: 17,
        zoomControl: true,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.DEFAULT
        },
    });
    map.data.loadGeoJson('/js/Kuninganbatas.geojson');

    // addMarkers(map);
    var wisataData = @json($mapWisatas);
    var kulinerData = @json($mapKuliners);
    var akomodasiData = @json($mapAkomodasis);

for (var i = 0; i < wisataData.length; i++) {
    var wisatas = wisataData[i];
    var encodedId = wisatas.id; // Menggunakan wisatas.id bukan wisata.id
    var photoUrl = wisatas.thumbnail;
    var jenis = 'wisata';

    var marker = new CustomMarker(new google.maps.LatLng(wisatas.latitude, wisatas.longitude), map, photoUrl)
    marker.jenis = jenis;

    var infowindow = new google.maps.InfoWindow();
    google.maps.event.addListener(marker, 'click', (function(marker, wisatas) {
        return function() {
            infowindow.setContent(generateContentwisata(wisatas))
            infowindow.open(map, marker);
        }
    })(marker, wisatas));
    markers.push(marker);
}


for (var i = 0; i < kulinerData.length; i++) {
    var kuliners = kulinerData[i];
    var encodedId = kuliners.id; // Menggunakan kuliners.id bukan kuliner.id
    var photoUrl = kuliners.thumbnail;
    var jenis = 'kuliner';

    var marker = new CustomMarker(new google.maps.LatLng(kuliners.latitude, kuliners.longitude), map, photoUrl)
    marker.jenis = jenis;

    var infowindow = new google.maps.InfoWindow();
    google.maps.event.addListener(marker, 'click', (function(marker, kuliners) {
        return function() {
            infowindow.setContent(generateContentkuliner(kuliners))
            infowindow.open(map, marker);
        }
    })(marker, kuliners));
    markers.push(marker);
}


for (var i = 0; i < akomodasiData.length; i++) {
    var akomodasis = akomodasiData[i];
    var encodedId = akomodasis.id; // Menggunakan akomodasis.id bukan akomodasi.id
    var photoUrl = akomodasis.thumbnail;
    var jenis = 'akomodasi';

    var marker = new CustomMarker(new google.maps.LatLng(akomodasis.latitude, akomodasis.longitude), map, photoUrl)
    marker.jenis = jenis;


    var infowindow = new google.maps.InfoWindow();
    google.maps.event.addListener(marker, 'click', (function(marker, akomodasis) {
        return function() {
            infowindow.setContent(generateContentakomodasi(akomodasis))
            infowindow.open(map, marker);
        }
    })(marker, akomodasis));
    markers.push(marker);
}

    function generateContentwisata(wisatas) {
        
    console.log('encodedId:', encodedId); // Tambahkan console.log untuk memeriksa nilai encodedId
    console.log('wisatas:', wisatas); // Tambahkan console.log untuk memeriksa nilai objek wisatas

    var content = `
    <div>
              <a href="{{ route('website.webdetailpetawisata', '') }}/` + wisatas.encodedId + `" title="View: ` + wisatas
            .namawisata + `">` + wisatas.namawisata + `</a>
          </div>
              <a href="{{ route('website.webdetailpetawisata', '') }}/` + wisatas.encodedId + `"><img src="` + wisatas
            .thumbnail + `" alt="` + wisatas.namawisata + `" class="align size-medium_large" width="140" height="93"></a>
                <div class="text-container">` + wisatas.alamat + `</div>
                <a href="https://www.google.com/maps/dir/?api=1&destination=` + wisatas.latitude + `,` +
            wisatas.longitude + `">Arahkan saya</a>
            `;
        return content;
}




function generateContentkuliner(kuliners) {
        
        console.log('encodedId:', encodedId); // Tambahkan console.log untuk memeriksa nilai encodedId
        console.log('kuliners:', kuliners); // Tambahkan console.log untuk memeriksa nilai objek kuliners
    
        var content = `
        <div>
                  <a href="{{ route('website.webdetailpetakuliner', '') }}/` + kuliners.encodedId + `" title="View: ` + kuliners
                .namakuliner + `">` + kuliners.namakuliner + `</a>
              </div>
                  <a href="{{ route('website.webdetailpetakuliner', '') }}/` + kuliners.encodedId + `"><img src="` + kuliners
                .thumbnail + `" alt="` + kuliners.namakuliner + `" class="align size-medium_large" width="140" height="93"></a>
                    <div class="text-container">` + kuliners.alamat + `</div>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=` + kuliners.latitude + `,` +
                kuliners.longitude + `">Arahkan saya</a>
                `;
            return content;
    }

    function generateContentakomodasi(akomodasis) {
        
        console.log('encodedId:', encodedId); // Tambahkan console.log untuk memeriksa nilai encodedId
        console.log('akomodasis:', akomodasis); // Tambahkan console.log untuk memeriksa nilai objek akomodasis
    
        var content = `

        <div>
                  <a href="{{ route('website.webdetailpetaakomodasi', '') }}/` + akomodasis.encodedId + `" title="View: ` + akomodasis
                .namaakomodasi + `">` + akomodasis.namaakomodasi + `</a>
              </div>
                  <a href="{{ route('website.webdetailpetaakomodasi', '') }}/` + akomodasis.encodedId + `"><img src="` + akomodasis
                .thumbnail + `" alt="` + akomodasis.namaakomodasi + `" class="align size-medium_large" width="140" height="93"></a>
                    <div class="text-container">` + akomodasis.alamat + `</div>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=` + akomodasis.latitude + `,` +
                akomodasis.longitude + `">Arahkan saya</a>
                `;
            return content;
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/hashids@2.2.0/dist/hashids.min.js"></script>

