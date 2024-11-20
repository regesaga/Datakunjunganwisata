function onlyNumberKey(evt) {
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}

function numberWithPeriodKey(evt) {
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        if (ASCIICode != 46) return false;
    return true;
}

document.addEventListener("DOMContentLoaded", function() {
    getDateTime();
    getSelamat();
});

function getDateTime() {

    const dateTime = document.getElementById('dateTime');

    if (dateTime) {
        const hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
        const bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
            "Oktober", "November", "Desember"
        ];
        const today = new Date();
        let D = today.getDay();
        let M = today.getMonth();
        let Y = today.getFullYear();
        let d = today.getDate();
        let h = ('0' + today.getHours()).substr(-2);
        let m = today.getMinutes();
        let s = today.getSeconds();
        m = m < 10 ? m = "0" + m : m;
        s = s < 10 ? s = "0" + s : s;
        dateTime.innerHTML = hari[D] + ", " + d + " " + bulan[M] + " " + Y + " " + h +
            ":" + m + ":" + s + " WIB";
        setTimeout(getDateTime, 1000);
    }

}

function getSelamat() {

    const selamat = document.getElementById("selamat");

    if (selamat) {
        var dt = new Date().getHours();
        if (dt >= 5 && dt <= 9) {
            document.getElementById("selamat").innerHTML =
                "Pagi";
        } else if (dt >= 10 && dt <= 14) {
            document.getElementById("selamat").innerHTML =
                "Siang";
        } else if (dt >= 15 && dt <= 17) {
            document.getElementById("selamat").innerHTML =
                "Sore";
        } else {
            document.getElementById("selamat").innerHTML =
                "Malam";
        }
        setTimeout(getSelamat, 1000);
    }


}

$(document).ready(function() {
    $(document).on("keydown keyup", function(e) {
        if (e.keyCode == 27) {
            e.stopImmediatePropagation();
            e.preventDefault();
            return;
        }
    });
});