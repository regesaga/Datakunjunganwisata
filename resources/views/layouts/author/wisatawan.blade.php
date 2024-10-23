<html>
<head>
 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Informasi Pariwisata KuninganBeu</title>


    <!-- Scripts -->
    <link href="{{ asset('images/logo/KuninganBeu.png')}}" rel="icon">
    <link href="{{ asset('images/logo/KuninganBeu_Kuning.png')}}" rel="apple-touch-icon">
    <!-- Fonts -->

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  
    <link href="{{ asset('dinas/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/font-awesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/all.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/buttons.dataTables.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('dinas/css/select.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dinas/css/dropzone.min.css') }}" rel="stylesheet" />
  
    <link href="{{ asset('css/costum2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
  	<link rel="stylesheet" type="text/css" href="/admin/dist/bootstrap-clockpicker.min.css">

</head>

<body>
    @include('inc.navbar-wisatawan')
    <div class="container my-4">
        <div class="account-layout">
            @yield('content')
        </div>
    </div>
    @include('sweetalert::alert')
  
    <script src="{{ asset('dinas/js/jquery.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/pdfmake.min.js') }}"></script> 
    <script src="{{ asset('dinas/js/vfs_fonts.js') }}"></script> 
    <script src="{{ asset('dinas/js/jszip.min.js') }}"></script> 
<script src="{{ asset('dinas/js/jquery.dataTables.min.js') }}"></script> 
<script src="{{ asset('dinas/js/dataTables.bootstrap4.min.js') }}"></script> 
<script src="{{ asset('dinas/js/bootstrap.min.js') }}"></script> 
<script src="{{ asset('dinas/js/popper.min.js') }}"></script> 
<script src="{{ asset('dinas/js/coreui.min.js') }}"></script> 
<script src="{{ asset('dinas/js/moment.min.js') }}"></script> 
<script src="{{ asset('dinas/js/bootstrap-datetimepicker.min.js') }}"></script> 
<script src="{{ asset('dinas/js/select2.full.min.js') }}"></script> 
<script src="{{ asset('dinas/js/dropzone.min.js') }}"></script> 
<script src="{{ asset('js/main.js') }}"></script>
<script>
  $(function() {
let copyButtonTrans = '{{ trans('copy') }}'
let csvButtonTrans = '{{ trans('Simpan csv') }}'
let excelButtonTrans = '{{ trans('Simpan excel') }}'
let pdfButtonTrans = '{{ trans('Simpan pdf') }}'
let printButtonTrans = '{{ trans('Simpan print') }}'
let colvisButtonTrans = '{{ trans('Baris Tabel') }}'

let languages = {
'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json'
};

$.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
$.extend(true, $.fn.dataTable.defaults, {
language: {
url: languages['{{ app()->getLocale() }}']
},
columnDefs: [{
  orderable: false,
  className: 'select-checkbox',
  targets: 0
}, {
  orderable: false,
  searchable: false,
  targets: -1
}],
select: {
style:    'multi+shift',
selector: 'td:first-child'
},
order: [],
scrollX: true,
pageLength: 100,
dom: 'lBfrtip<"actions">',
buttons: [
{
  extend: 'copy',
  className: 'btn-default',
  text: copyButtonTrans,
  exportOptions: {
    columns: ':visible'
  }
},
{
  extend: 'csv',
  className: 'btn-default',
  text: csvButtonTrans,
  exportOptions: {
    columns: ':visible'
  }
},
{
  extend: 'excel',
  className: 'btn-default',
  text: excelButtonTrans,
  exportOptions: {
    columns: ':visible'
  }
},
{
  extend: 'pdf',
  className: 'btn-default',
  text: pdfButtonTrans,
  exportOptions: {
    columns: ':visible'
  }
},
{
  extend: 'print',
  className: 'btn-default',
  text: printButtonTrans,
  exportOptions: {
    columns: ':visible'
  }
},
{
  extend: 'colvis',
  className: 'btn-default',
  text: colvisButtonTrans,
  exportOptions: {
    columns: ':visible'
  }
}
]
});

$.fn.dataTable.ext.classes.sPageButton = '';
});

</script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<!-- G Tag -->

<script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-llVsMblt2xJQsyz1"></script>
<script>
  $(document).ready(function() {
    $('#item-details').empty();
    $('#voucher-message').hide();
    $("#payButton").on('click', function(e) {
      // disabled button, prevent double click
      $("#payButton").attr("disabled", true);
      startPay($(this).data('token'))
    });


    $("[id$='_showDetail']").on('click', function(e) {
      $('#dtOrder').modal('toggle');
      $('#qrcode').empty();
      var order = $(this).data('order');
      $('#orderId').html('#' + order.order_id);
      $('#datePurchased').html(order.date_purchased);
      $('#nettAmount').html(order.paid_amount);
      $('#typePayment').html(order.type_payment_pg);
      $('#orderStatus').html(order.status).css('textTransform', 'capitalize');
      $('#payButton').data('token', order.snap_token);
      if (order.status === 'paid' || order.status === 'cancel') {
        $('#dtOrder').find('.modal-footer').css('display', 'none');
      } else {
        $('#dtOrder').find('.modal-footer').css('display', 'block');
      }

      var qrcode = new QRCode(
        "qrcode", {
          text: order.booking_code,
          width: 100,
          height: 100,
          colorDark: "#000000",
          colorLight: "#FFFFFF",
          correctLevel: QRCode.CorrectLevel.M
        }
      );

      let attrItems = '';
      order.products.forEach((element, i) => {
        attrItems +=
          `<div class="row">
            <div class="col-6">
              <div class="ticket-category text-grey">` + element.product.name + `</div>
              <div class="ticket-category-qty">Rp` + element.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.") + ` x ` + element.qty + `</div>
            </div>
            <div class="col-6">
              <h6 class="float-end">Rp` + element.gross.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.") + `</h6>
            </div>
          </div>
          <hr class="hr mt-1 mb-2" />`;
      });
      attrItems +=
        `<div class="row">
            <div class="col-6">
              <div class="ticket-category-qty">Platform Fee</div>
            </div>
            <div class="col-6">
              <h6 class="float-end">Rp` + order.platform_fee.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.") + `</h6>
            </div>
          </div>
          <hr class="hr mt-1 mb-2" />`;
      attrItems +=
        `<div class="row">
            <div class="col-6">
              <div class="ticket-category-qty">Tax</div>
            </div>
            <div class="col-6">
              <h6 class="float-end">Rp` + order.tax.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.") + `</h6>
            </div>
          </div>
          <hr class="hr mt-1 mb-2" />`;
      attrItems +=
        `<div class="row">
            <div class="col-6">
            <div class="ticket-category-qty">Discount</div>
            </div>
            <div class="col-6">
              <h6 class="float-end">Rp` + order.discount.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.") + `</h6>
            </div>
          </div>
          <hr class="hr mt-1 mb-2" />`;
      attrItems +=
        `<div class="row">
            <div class="col-6">
              <div class="ticket-category-qty fs-5">Total Amount</div>
            </div>
            <div class="col-6">
              <h5 class="float-end">Rp` + order.nett.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.") + `</h5>` +
        (order.discount > 0 ?
          `<h5 class="float-end text-decoration-line-through text-secondary me-2">Rp` + (order.gross + order.tax + order.platform_fee).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.") + `</h5>` : ``) +
        `</div>
          </div>`;

      $('#detailProducts').html(attrItems);
    })

    if ("1" !== '1') {
      Swal.fire({
        title: "Login",
        showCancelButton: true,
        confirmButtonText: "Login",
        cancelButtonText: "Register",
        showLoaderOnConfirm: true,
        customClass: {
          confirmButton: 'btn btn-primary'
        },
        html: '<div class="form-group row mb-2">\
                <label for="inputEmail" class="col-4 col-form-label text-start">Email/Phone</label>\
                <div class="col-8">\
                  <input type="text" class="form-control" id="inputEmail" placeholder="Email/Phone">\
                </div>\
              </div>\
              <div class="form-group row mb-2">\
                <label for="inputPassword" class="col-4 col-form-label text-start">Password</label>\
                <div class="col-8">\
                  <input type="password" class="form-control" id="inputPassword" placeholder="Password">\
                </div>\
              </div>',
        preConfirm: async () => {
          const retVal = [
            document.getElementById("inputEmail").value,
            document.getElementById("inputPassword").value
          ];

          const [username, password] = retVal;

          if (!username.trim())
            Swal.showValidationMessage("Invalid Email/Phone");
          else if (!password.trim())
            Swal.showValidationMessage("Invalid Email/Phone");

          var reqLogin = {
            username: username,
            password: password,
          };
          const response = await fetch("https://sunset.kebunraya.id/login", {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify(reqLogin)
          });
          const data = await response.json();
          if (!response.ok) {
            return Swal.showValidationMessage(data['message']);
          }
          return data;
        },
        allowOutsideClick: () => false
      }).then(async (result) => {
        if (result.isConfirmed) {
          location.reload();
        }
      });
    }
  });

  function startPay(snapToken) {
    window.snap.pay(snapToken, {
      uiMode: "qr",
      gopayMode: "qr",
      skipOrderSummary: true,
      onSuccess: function(result) {
        console.log('success');
        // redirect
        window.location.reload();
      },
      onPending: function(result) {
        console.log('pending');
        // redirect
        window.location.reload();
      },
      onError: function(result) {
        console.log('error');
        // redirect
      },
      onClose: function() {
        console.log('customer closed the popup without finishing the payment');
        // redirect
        window.location.reload();
      }
    });
  }
@stack('scripts')

</body>
</html>
