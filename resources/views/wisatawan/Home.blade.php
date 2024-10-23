@extends('layouts.author.wisatawan')

@section('content')
    <div class="account-bdy p-3">
        <section class="author-company-info">
            <div class="row">
                @php
                                // Create a DateTime object with the desired timezone
                                $timezone = new DateTimeZone('Asia/Jakarta'); // Adjust this to your desired timezone
                                $datetime = new DateTime('now', $timezone);
                            
                                // Get the current hour
                                $hour = $datetime->format('H');
                            
                                // Determine the greeting
                                $greetings = $hour >= 18 ? 'Malam' : ($hour >= 15 ? 'Sore' : ($hour >= 12 ? 'Siang' : 'Pagi'));
                            @endphp
                            
                            <div class="col-lg-12 col-sm-12">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 mt-3 d-none d-sm-block">
                                              <h4 class="mb-3">Selamat {{ $greetings }},
                                                  <b>{{ Auth::guard('wisatawans')->user()->name }}</b>
                                              </h4>
                                      </div>
                                      <div class="col-lg-8 col-sm-8">
                                            <ul class="nav nav-pills justify-content-end"  role="tablist">
                                                <li class="nav-item"  role="presentation">
                                                <a class="nav-link active" id="acvite-tiket"  data-bs-toggle="tab" href="#acvite-tabtiket" role="tab" aria-controls="acvite-tabtiket" aria-selected="false"> Wisata </a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="canceled-kuliner" data-bs-toggle="tab" href="#canceled-tabkuliner" role="tab" aria-controls="canceled-tabkuliner" aria-selected="true"> Kuliner </a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="canceled-akomodasi" data-bs-toggle="tab" href="#canceled-tabakomodasi" role="tab" aria-controls="canceled-tabakomodasi" aria-selected="true"> Akomodasi </a>
                                                    </li>
                                            </ul>
                                      </div>
                                </div>
                            <div class="tab-content pt-4" id="pills-tabContent">
                                <div class="tab-pane active" id="acvite-tabtiket" role="tabpanel" aria-labelledby="acvite-tiket">
                                    <div class="card">
                                        <a href="{{ route('wisatawan.pesanan') }}">
                
                                        <div class="card-body">
                                                    <h4>Riwayat Tiket Wisata</h4>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="card text-center">
                                                                        <div class="card-body">
                                                                            <h3>Belum Dibayar</h3>
                                                                            <hr>
                                                                            <p>{{ $jumlah_belumdibayar }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="card text-center">
                                                                        <div class="card-body">
                                                                            <h3>Selesai</h3>
                                                                            <hr>
                                                                            <p>{{ $jumlah_dipakai }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="card text-center">
                                                                        <div class="card-body">
                                                                            <h3>Belum Dipakai</h3>
                                                                            <hr>
                                                                            <p>{{ $jumlah_belumdipakai }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="card text-center">
                                                                        <div class="card-body">
                                                                            <h3>Kadaluarsa</h3>
                                                                            <hr>
                                                                            <p>{{ $jumlah_kadaluarsa }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                    
                                        </div>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 mt-3">
                                          <div class="row">
                                                      <div class="col-lg-12">
                                                            <ul class="nav nav-pills justify-content-end" role="tablist">
                                                                <li class="nav-item" role="presentation">
                                                                <a class="nav-link active" id="acvite-tab" data-bs-toggle="tab" href="#acvite-tabpanel" role="tab" aria-controls="acvite-tabpanel" aria-selected="false"> Active </a>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                <a class="nav-link" id="canceled-tab" data-bs-toggle="tab" href="#canceled-tabpanel" role="tab" aria-controls="canceled-tabpanel" aria-selected="true"> Canceled </a>
                                                                </li>
                                                            </ul>
                                                            <div class="tab-content pt-4" id="pills-tabContent">
                                                                    <div class="tab-pane active" id="acvite-tabpanel" role="tabpanel" aria-labelledby="acvite-tab">
                                                                        <div class="row">
                                                                            @foreach($pesantiket as $key => $pesantiket)
                                                                                            <div class="col-md-12 mb-4">
                                                                                                <div class="card float-right pb-0">
                                                                                                    <div class="row">
                                                                                                    <div class="col-sm-5 order-status">
                                                                                                        <img class="d-block w-100" src="{{ $pesantiket->wisata->getFirstMediaUrl('photos') }}" width="400" height="200" alt="Thumbnail">
                                                                                                    </div>
                                                                                                    <div class="col-sm-7">
                                                                                                        <div class="card-block-ticket h-100 order-cta">
                                                                                                            <h4 class="card-title" style="text-transform: uppercase;">{{ $pesantiket->wisata->namawisata ?? '' }}</h4>
        
                                                                                                        <div class="order-info mb-3">
                                                                                                            <ul class="list-unstyled mt-1">
                                                                                                            <li><i class="bi-receipt w-100"></i> <b>{{ $pesantiket->kodetiket ?? '' }}</b></li>
                                                                                                            <li><i class="bi-file-person w-100"></i> <b>{{ Auth::guard('wisatawans')->user()->name }}</b></li>
                                                                                                            <li><i class="bi-ticket w-100"></i>
                                                                                                                                                <b>Status Pembayaran</b>@if ($pesantiket->payment_status == 00)
                                                                                                                                                <span class="badge badge-info ">Menunggu Pembayaran</span>
                                                                                                                                            @elseif ($pesantiket->payment_status == 11)
                                                                                                                                                <span class="badge badge-success">Sudah di Bayar</span>
                                                                                                                                            @elseif ($pesantiket->payment_status == 22)
                                                                                                                                                <span class="badge badge-warning">Kadaluarsa</span>
                                                                                                                                            @elseif ($pesantiket->payment_status == 33)
                                                                                                                                                <span class="badge badge-danger">Batal</span>
                                                                                                                                            @endif
                                                                                                                                                
                                                                                                                                                                                </li>
                                                                                                            <li><i class="bi-cash-stack w-100"></i> <b>Rp. {{ number_format($pesantiket->totalHarga, 0, ".", ".") }},-</b>@if ($pesantiket->metodepembayaran == "Online")
                                                                                                                <span class="badge rounded-pill bg-primary ">Online</span>
                                                                                                            @elseif ($pesantiket->metodepembayaran == "Tunai")
                                                                                                                <span class="badge rounded-pill bg-success">Tunai</span>
                                                                                                                @endif</li>
                                                                                                                <li><i class="bi-calendar2-check w-100"></i> Tanggal Order: <b>{{ date('d-m-Y', strtotime($pesantiket->created_at)) }}</b></li>
                                                                                                                <li><i class="bi-calendar3-event w-100"></i> Tanggal Kunjungan <b>{{ date('d-m-Y', strtotime($pesantiket->tanggalkunjungan)) }}</b></li>
                                                                                                            </ul>
                                                                                                        </div>
                                                                                                        <a href="{{ route('website.pesantiket.checkout_finish', ['pesantiket' => $pesantiket->kodetiket]) }}">
                                                                                                            <span class="badge badge-danger">Cetak</span>
                                                                                                        </a>
                                                                                                        <div class="btn-group-card align-self-end mb-2">
                                                                                                            <a id="23453_showDetail" class="btn btn-primary btn-sm float-right me-0">Detail Order</a>
                                                                                                        </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    @endforeach
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal fade" id="dtOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                            <div class="container">
                                                                                <!-- Stack the columns on mobile by making one full-width and the other half-width -->
                                                                                <div class="row">
                                                                                <h4>Order ID <small class="text-secondary" id="orderId">#SNST78128937198273</small></h4>
                                                                                <div class="col-md-4 col-sm-12">
                                                                                    <div class="row justify-content-center">
                                                                                    <div class="col-12 text-center">
                                                                                        <div id="qrcode" style="padding:20px;height:auto;width:140px;margin:auto;"></div>
                                                                                    </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-8 col-sm-12 py-3">
                                                                                    <ul class="list-unstyled mt-1">
                                                                                    <li><i class="bi-calendar2-check me-2"></i> Order Date: <b id="datePurchased"></b></li>
                                                                                    <li><i class="bi-cash-stack me-2"></i> Amount: <b id="nettAmount"></b></li>
                                                                                    <li><i class="bi-chat-right-dots me-2"></i> Status Payment: <b id="orderStatus"></b> | <small id="typePayment"></small></li>
                                                                                    </ul>
                                                                                </div>
                                                                                <hr class="hr" />
                                                                                <div class="col-12" id="detailProducts"></div>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                            <div class="modal-footer justify-content-center">
                                                                            <div class="d-grid gap-2 col-6 mx-auto">
                                                                                <button type="button" class="btn btn-primary" id="payButton" data-token="">Pay Now</button>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                    </div>
        
                                                                    <div class="tab-pane" id="canceled-tabpanel" role="tabpanel" aria-labelledby="canceled-tab">
                                                                        <div class="row">
                                                                            @foreach($canceled as $key => $canceled)
                                                                                            <div class="col-md-12 mb-4">
                                                                                                <div class="card float-right pb-0">
                                                                                                    <div class="row">
                                                                                                    <div class="col-sm-5 order-status">
                                                                                                        <img class="d-block w-100" src="{{ $canceled->wisata->getFirstMediaUrl('photos') }}" width="400" height="200" alt="Thumbnail">
                                                                                                    </div>
                                                                                                    <div class="col-sm-7">
                                                                                                        <div class="card-block-ticket h-100 order-cta">
                                                                                                            <h4 class="card-title" style="text-transform: uppercase;">{{ $canceled->wisata->namawisata ?? '' }}</h4>
        
                                                                                                        <div class="order-info mb-3">
                                                                                                            <ul class="list-unstyled mt-1">
                                                                                                            <li><i class="bi-receipt w-100"></i> <b>{{ $canceled->kodetiket ?? '' }}</b></li>
                                                                                                            <li><i class="bi-file-person w-100"></i> <b>{{ Auth::guard('wisatawans')->user()->name }}</b></li>
                                                                                                            <li><i class="bi-ticket w-100"></i>
                                                                                                                                                <b>Status Pembayaran</b>@if ($canceled->payment_status == 00)
                                                                                                                                                <span class="badge badge-info ">Menunggu Pembayaran</span>
                                                                                                                                            @elseif ($canceled->payment_status == 11)
                                                                                                                                                <span class="badge badge-success">Sudah di Bayar</span>
                                                                                                                                            @elseif ($canceled->payment_status == 22)
                                                                                                                                                <span class="badge badge-warning">Kadaluarsa</span>
                                                                                                                                            @elseif ($canceled->payment_status == 33)
                                                                                                                                                <span class="badge badge-danger">Batal</span>
                                                                                                                                            @endif
                                                                                                                                                
                                                                                                                                                                                </li>
                                                                                                            <li><i class="bi-cash-stack w-100"></i> <b>Rp. {{ number_format($canceled->totalHarga, 0, ".", ".") }},-</b>@if ($canceled->metodepembayaran == "Online")
                                                                                                                <span class="badge rounded-pill bg-primary ">Online</span>
                                                                                                            @elseif ($canceled->metodepembayaran == "Tunai")
                                                                                                                <span class="badge rounded-pill bg-success">Tunai</span>
                                                                                                                @endif</li>
                                                                                                                <li><i class="bi-calendar2-check w-100"></i> Tanggal Order: <b>{{ date('d-m-Y', strtotime($canceled->created_at)) }}</b></li>
                                                                                                                <li><i class="bi-calendar3-event w-100"></i> Tanggal Kunjungan <b>{{ date('d-m-Y', strtotime($canceled->tanggalkunjungan)) }}</b></li>
                                                                                                            </ul>
                                                                                                        </div>
                                                                                                        <div class="btn-group-card align-self-end mb-2">
                                                                                                            <a id="23453_showDetail" class="btn btn-primary btn-sm float-right me-0" data-order="{&quot;id&quot;:23453,&quot;ms_event_id&quot;:1,&quot;customer_id&quot;:21773,&quot;staff_id&quot;:null,&quot;date_purchased&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;type&quot;:&quot;online&quot;,&quot;gross&quot;:300000,&quot;tax&quot;:24900,&quot;discount&quot;:0,&quot;platform_fee&quot;:7000,&quot;voucher_code&quot;:null,&quot;voucher_disc&quot;:0,&quot;voucher_total_product&quot;:0,&quot;voucher_amount&quot;:0,&quot;nett&quot;:331900,&quot;money_paid&quot;:0,&quot;change&quot;:0,&quot;status&quot;:&quot;cancel&quot;,&quot;reason&quot;:&quot;expire&quot;,&quot;ref_order_id&quot;:&quot;9582f6e6-ec22-47fe-b2c2-4eb13ba08e9b&quot;,&quot;type_payment&quot;:&quot;qris&quot;,&quot;booking_code&quot;:&quot;9374AB&quot;,&quot;reschedule_token&quot;:null,&quot;reschedule_expired&quot;:null,&quot;snap_token&quot;:&quot;809440af-14ea-4a0f-a5f8-473b7352a7a9&quot;,&quot;type_payment_pg&quot;:&quot;QRIS&quot;,&quot;created_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-12T11:59:48.000000Z&quot;,&quot;order_id&quot;:&quot;SNST66698669374AB&quot;,&quot;trx_event_detail_id&quot;:5,&quot;date_purchased_format&quot;:&quot;12-06-2024&quot;,&quot;time_purchased_format&quot;:&quot;06:28:41&quot;,&quot;gross_format&quot;:&quot;Rp. 300,000.00&quot;,&quot;tax_format&quot;:&quot;Rp. 24,900.00&quot;,&quot;discount_format&quot;:&quot;&quot;,&quot;platform_fee_format&quot;:&quot;Rp. 7,000.00&quot;,&quot;voucher_disc_format&quot;:&quot;&quot;,&quot;voucher_amount_format&quot;:&quot;&quot;,&quot;nett_format&quot;:&quot;Rp. 331,900.00&quot;,&quot;event_detail&quot;:{&quot;id&quot;:5,&quot;ms_event_id&quot;:4,&quot;location_id&quot;:3,&quot;time_start&quot;:&quot;2024-11-01T17:00:00.000000Z&quot;,&quot;time_end&quot;:&quot;2024-11-02T17:00:00.000000Z&quot;,&quot;status&quot;:&quot;active&quot;,&quot;created_at&quot;:&quot;2024-03-09T06:03:42.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-08-02T06:40:12.000000Z&quot;,&quot;card_file&quot;:null,&quot;card_history&quot;:&quot;sunset-di-kebun-raya-purwodadi-2024-phase-2.jpg&quot;,&quot;card_eticket&quot;:null,&quot;ticket_properties&quot;:{&quot;eticket_tnc&quot;:&quot;\u003Cp\u003E\u003Cstrong\u003EKetentuan Umum:\u003C\/strong\u003E\u003C\/p\u003E\r\n\r\n\u003Col\u003E\r\n\t\u003Cli\u003EPenukaran tiket dimulai pukul 09.30 - 15.30 WIB, pengunjung tidak diperkenankan melakukan penukaran tiket diluar jam yang telah ditentukan.\u003C\/li\u003E\r\n\t\u003Cli\u003EOpen gate pukul 10.00 WIB dan close gate pukul 15.30 WIB, pengunjung tidak diperkenankan memasuki area Sunset di Kebun di luar jam yang telah ditentukan.\u003C\/li\u003E\r\n\t\u003Cli\u003ETiket Early Bird dan Presale tidak dapat dipindah tangankan.\u003C\/li\u003E\r\n\t\u003Cli\u003ETiket ini menggunakan sistem QR dan berlaku untuk 1 (satu) orang.\u003C\/li\u003E\r\n\t\u003Cli\u003ETiket hanya dapat digunakan sesuai dengan hari yang tercantum pada tiket.\u003C\/li\u003E\r\n\t\u003Cli\u003EUntuk informas terkait syarat dan ketentuan yang berlaku silakan kunjungi \u003Cstrong\u003E\u003Ca href=\&quot;https:\/\/sunset.kebunraya.id\/information\&quot;\u003Esunset.kebunraya.id\/information\u003C\/a\u003E\u003C\/strong\u003E\u003C\/li\u003E\r\n\u003C\/ol\u003E&quot;,&quot;evoucher_tnc&quot;:null,&quot;eticket_merch&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/eticket\/eticket_merch_1721467837.jpg&quot;,&quot;compliment_tnc&quot;:null,&quot;eticket_default&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/eticket\/eticket_default_1721467837.jpg&quot;,&quot;eticket_voucher&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/eticket\/eticket_voucher_1721467837.jpg&quot;,&quot;merchandise_tnc&quot;:null,&quot;eticket_compliment&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/eticket\/eticket_compliment_1721467837.jpg&quot;},&quot;identity_properties&quot;:{&quot;card_image&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/identity\/card_image_1722580235.png&quot;,&quot;card_phase&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/identity\/card_phase_1722580812.png&quot;,&quot;card_history&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/identity\/card_history_1721467837.jpg&quot;},&quot;location&quot;:{&quot;id&quot;:3,&quot;name&quot;:&quot;Kebun Raya Purwodadi&quot;,&quot;slug&quot;:&quot;kebun-raya-purwodadi&quot;,&quot;address&quot;:&quot;Phase 1&quot;,&quot;created_at&quot;:null,&quot;updated_at&quot;:&quot;2024-03-09T04:57:26.000000Z&quot;},&quot;event&quot;:{&quot;id&quot;:4,&quot;name&quot;:&quot;Sunset di Kebun&quot;,&quot;slug&quot;:&quot;sunset-di-kebun&quot;,&quot;poster&quot;:&quot;&quot;,&quot;description&quot;:&quot;Sunset di Kebun Phase 2&quot;,&quot;status&quot;:&quot;published&quot;,&quot;created_at&quot;:&quot;2024-04-27T02:29:10.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-27T22:09:08.000000Z&quot;,&quot;prefix&quot;:&quot;SNSTP2&quot;}},&quot;customer&quot;:{&quot;id&quot;:21773,&quot;name&quot;:&quot;galihramadhan&quot;,&quot;role&quot;:null,&quot;nik&quot;:&quot;3222132804950006&quot;,&quot;phone&quot;:&quot;089509888111&quot;,&quot;email&quot;:&quot;regesaga2@gmail.com&quot;,&quot;email_verified_at&quot;:null,&quot;password&quot;:&quot;$2y$10$fDa1tVAN93wW72323cVkrun8g5\/l2Bp7sX0c6X4omLoekAYxWboGS&quot;,&quot;remember_token&quot;:null,&quot;forgot_token&quot;:null,&quot;date_exp_token&quot;:null,&quot;created_at&quot;:&quot;2024-06-12T11:23:24.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-12T11:23:24.000000Z&quot;,&quot;gender&quot;:&quot;male&quot;,&quot;date_of_birth&quot;:&quot;2024-05-27&quot;,&quot;regional&quot;:&quot;Depok&quot;},&quot;products&quot;:[{&quot;id&quot;:34149,&quot;trx_order_id&quot;:23453,&quot;ms_product_id&quot;:600,&quot;qty&quot;:1,&quot;price&quot;:300000,&quot;dpp&quot;:249000,&quot;tax&quot;:24900,&quot;gross&quot;:300000,&quot;nett&quot;:324900,&quot;created_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;trx_product_detail_id&quot;:692,&quot;product&quot;:{&quot;id&quot;:600,&quot;name&quot;:&quot;Regular - 2 Days Pass&quot;,&quot;slug&quot;:&quot;regular-2-days-pass&quot;,&quot;photo_cover&quot;:null,&quot;description&quot;:&quot;\u003Cp\u003ERegular 2 Days Pass Phase 2 KRP\u003C\/p\u003E&quot;,&quot;status&quot;:1,&quot;is_bundle&quot;:null,&quot;created_at&quot;:null,&quot;updated_at&quot;:null,&quot;ms_category_id&quot;:1,&quot;ms_tax_template_id&quot;:2,&quot;location_id&quot;:3,&quot;photo_cover_url&quot;:&quot;&quot;}}],&quot;tickets&quot;:[{&quot;ticket_id&quot;:&quot;666986695D92B&quot;,&quot;order_id&quot;:&quot;SNST66698669374AB&quot;,&quot;qr_id&quot;:&quot;95D9B0&quot;,&quot;category_id&quot;:600,&quot;price&quot;:150000,&quot;discount&quot;:0,&quot;full_name&quot;:&quot;galihramadhan&quot;,&quot;id_number&quot;:null,&quot;phone&quot;:&quot;089509888111&quot;,&quot;email&quot;:&quot;regesaga2@gmail.com&quot;,&quot;date_start&quot;:&quot;2024-11-02 00:00:00&quot;,&quot;date_expired&quot;:&quot;2024-11-02 00:00:00&quot;,&quot;is_orderer&quot;:1,&quot;timezone&quot;:&quot;00:00:00&quot;,&quot;batch_id&quot;:&quot;01&quot;,&quot;start_time&quot;:&quot;00:00:00&quot;,&quot;status&quot;:0,&quot;checkin_at&quot;:null,&quot;checkout_at&quot;:null,&quot;created_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;pic_email&quot;:null,&quot;pic_name&quot;:null,&quot;pic_phone&quot;:null,&quot;checkin_gate&quot;:null,&quot;checkout_gate&quot;:null,&quot;ms_product_id&quot;:600,&quot;product&quot;:{&quot;id&quot;:600,&quot;name&quot;:&quot;Regular - 2 Days Pass&quot;,&quot;slug&quot;:&quot;regular-2-days-pass&quot;,&quot;photo_cover&quot;:null,&quot;description&quot;:&quot;\u003Cp\u003ERegular 2 Days Pass Phase 2 KRP\u003C\/p\u003E&quot;,&quot;status&quot;:1,&quot;is_bundle&quot;:null,&quot;created_at&quot;:null,&quot;updated_at&quot;:null,&quot;ms_category_id&quot;:1,&quot;ms_tax_template_id&quot;:2,&quot;location_id&quot;:3,&quot;photo_cover_url&quot;:&quot;&quot;}},{&quot;ticket_id&quot;:&quot;66698669587EF&quot;,&quot;order_id&quot;:&quot;SNST66698669374AB&quot;,&quot;qr_id&quot;:&quot;958865&quot;,&quot;category_id&quot;:600,&quot;price&quot;:150000,&quot;discount&quot;:0,&quot;full_name&quot;:&quot;galihramadhan&quot;,&quot;id_number&quot;:null,&quot;phone&quot;:&quot;089509888111&quot;,&quot;email&quot;:&quot;regesaga2@gmail.com&quot;,&quot;date_start&quot;:&quot;2024-11-03 00:00:00&quot;,&quot;date_expired&quot;:&quot;2024-11-03 00:00:00&quot;,&quot;is_orderer&quot;:0,&quot;timezone&quot;:&quot;00:00:00&quot;,&quot;batch_id&quot;:&quot;01&quot;,&quot;start_time&quot;:&quot;00:00:00&quot;,&quot;status&quot;:0,&quot;checkin_at&quot;:null,&quot;checkout_at&quot;:null,&quot;created_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;pic_email&quot;:null,&quot;pic_name&quot;:null,&quot;pic_phone&quot;:null,&quot;checkin_gate&quot;:null,&quot;checkout_gate&quot;:null,&quot;ms_product_id&quot;:600,&quot;product&quot;:{&quot;id&quot;:600,&quot;name&quot;:&quot;Regular - 2 Days Pass&quot;,&quot;slug&quot;:&quot;regular-2-days-pass&quot;,&quot;photo_cover&quot;:null,&quot;description&quot;:&quot;\u003Cp\u003ERegular 2 Days Pass Phase 2 KRP\u003C\/p\u003E&quot;,&quot;status&quot;:1,&quot;is_bundle&quot;:null,&quot;created_at&quot;:null,&quot;updated_at&quot;:null,&quot;ms_category_id&quot;:1,&quot;ms_tax_template_id&quot;:2,&quot;location_id&quot;:3,&quot;photo_cover_url&quot;:&quot;&quot;}}],&quot;paid_amount&quot;:&quot;Rp331.900&quot;}">Detail Order</a>
                                                                                                        </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    @endforeach
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </div>
                                            </div>
                                      </div>
                                     </div>
                                    
                                </div>

                                <div class="tab-pane" id="canceled-tabkuliner" role="tabpanel" aria-labelledby="canceled-kuliner">
                                    <div class="card">
                                        <a href="{{ route('wisatawan.pesanankuliner') }}">
                
                                        <div class="card-body">
                                                     <h4>Riwayat Pesanan Kuliner</h4>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="card text-center">
                                                                        <div class="card-body">
                                                                            <h3>Belum Dibayar</h3>
                                                                            <hr>
                                                                            <p>{{ $jumlah_kulinerbelumdibayar }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="card text-center">
                                                                        <div class="card-body">
                                                                            <h3>Selesai</h3>
                                                                            <hr>
                                                                            <p>{{ $jumlah_selesai }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="card text-center">
                                                                        <div class="card-body">
                                                                            <h3>Kadaluarsa</h3>
                                                                            <hr>
                                                                            <p>{{ $jumlah_kulinerkadaluarsa }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                       
                                        </div>
                                        </a>
                                    </div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 mt-3">
                                                <div class="row">
                                                          <div class="col-lg-12">
                                                                <ul class="nav nav-pills justify-content-end" role="tablist">
                                                                    <li class="nav-item" role="presentation">
                                                                    <a class="nav-link active" id="acvite-tabkuliner" data-bs-toggle="tab" href="#acvite-tabpanelkuliner" role="tab" aria-controls="acvite-tabpanelkuliner" aria-selected="false"> Active </a>
                                                                    </li>
                                                                    <li class="nav-item" role="presentation">
                                                                    <a class="nav-link" id="canceled-tabkuliner" data-bs-toggle="tab" href="#canceled-tabpanelkuliner" role="tab" aria-controls="canceled-tabpanelkuliner" aria-selected="true"> Canceled </a>
                                                                    </li>
                                                                </ul>
                                                                <div class="tab-content pt-4" id="pills-tabContent">
                                                                        <div class="tab-pane active" id="acvite-tabpanelkuliner" role="tabpanelkuliner" aria-labelledby="acvite-tabkuliner">
                                                                            <div class="row">
                                                                                @foreach($pesankuliner as $key => $pesankuliner)
                                                                                                <div class="col-md-12 mb-4">
                                                                                                    <div class="card float-right pb-0">
                                                                                                        <div class="row">
                                                                                                        <div class="col-sm-5 order-status">
                                                                                                            <img class="d-block w-100" src="{{ $pesankuliner->kuliner->getFirstMediaUrl('photos') }}" width="400" height="200" alt="Thumbnail">
                                                                                                        </div>
                                                                                                        <div class="col-sm-7">
                                                                                                            <div class="card-block-ticket h-100 order-cta">
                                                                                                                <h4 class="card-title" style="text-transform: uppercase;">{{ $pesankuliner->kuliner->namakuliner ?? '' }}</h4>
            
                                                                                                            <div class="order-info mb-3">
                                                                                                                <ul class="list-unstyled mt-1">
                                                                                                                <li><i class="bi-receipt w-100"></i> <b>{{ $pesankuliner->kodepesanan ?? '' }}</b></li>
                                                                                                                <li><i class="bi-file-person w-100"></i> <b>{{ Auth::guard('wisatawans')->user()->name }}</b></li>
                                                                                                                <li><i class="bi-ticket w-100"></i>
                                                                                                                                                    <b>Status Pembayaran</b>@if ($pesankuliner->payment_status == 00)
                                                                                                                                                    <span class="badge badge-info ">Menunggu Pembayaran</span>
                                                                                                                                                @elseif ($pesankuliner->payment_status == 11)
                                                                                                                                                    <span class="badge badge-success">Sudah di Bayar</span>
                                                                                                                                                @elseif ($pesankuliner->payment_status == 22)
                                                                                                                                                    <span class="badge badge-warning">Kadaluarsa</span>
                                                                                                                                                @elseif ($pesankuliner->payment_status == 33)
                                                                                                                                                    <span class="badge badge-danger">Batal</span>
                                                                                                                                                @endif
                                                                                                                                                    
                                                                                                                                                                                    </li>
                                                                                                                <li><i class="bi-cash-stack w-100"></i> <b>Rp. {{ number_format($pesankuliner->totalHarga, 0, ".", ".") }},-</b>@if ($pesankuliner->metodepembayaran == "Online")
                                                                                                                    <span class="badge rounded-pill bg-primary ">Online</span>
                                                                                                                @elseif ($pesankuliner->metodepembayaran == "Tunai")
                                                                                                                    <span class="badge rounded-pill bg-success">Tunai</span>
                                                                                                                    @endif</li>
                                                                                                                    <li><i class="bi-calendar2-check w-100"></i> Tanggal Order: <b>{{ date('d-m-Y', strtotime($pesankuliner->created_at)) }}</b></li>
                                                                                                                    <li><i class="bi-calendar3-event w-100"></i> Tanggal Kunjungan <b>{{ date('d-m-Y', strtotime($pesankuliner->tanggalkunjungan)) }}</b></li>
                                                                                                                </ul>
                                                                                                            </div>
                                                                                                            <a href="{{ route('website.pesankuliner.checkout_finish', ['pesankuliner' => $pesankuliner->kodepesanan]) }}">
                                                                                                                <span class="badge badge-danger">Cetak</span>
                                                                                                            </a>
                                                                                                            <div class="btn-group-card align-self-end mb-2">
                                                                                                                <a id="23453_showDetail" class="btn btn-primary btn-sm float-right me-0">Detail Order</a>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        @endforeach
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal fade" id="dtOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-lg">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                <div class="container">
                                                                                    <!-- Stack the columns on mobile by making one full-width and the other half-width -->
                                                                                    <div class="row">
                                                                                    <h4>Order ID <small class="text-secondary" id="orderId">#SNST78128937198273</small></h4>
                                                                                    <div class="col-md-4 col-sm-12">
                                                                                        <div class="row justify-content-center">
                                                                                        <div class="col-12 text-center">
                                                                                            <div id="qrcode" style="padding:20px;height:auto;width:140px;margin:auto;"></div>
                                                                                        </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-8 col-sm-12 py-3">
                                                                                        <ul class="list-unstyled mt-1">
                                                                                        <li><i class="bi-calendar2-check me-2"></i> Order Date: <b id="datePurchased"></b></li>
                                                                                        <li><i class="bi-cash-stack me-2"></i> Amount: <b id="nettAmount"></b></li>
                                                                                        <li><i class="bi-chat-right-dots me-2"></i> Status Payment: <b id="orderStatus"></b> | <small id="typePayment"></small></li>
                                                                                        </ul>
                                                                                    </div>
                                                                                    <hr class="hr" />
                                                                                    <div class="col-12" id="detailProducts"></div>
                                                                                    </div>
                                                                                </div>
                                                                                </div>
                                                                                <div class="modal-footer justify-content-center">
                                                                                <div class="d-grid gap-2 col-6 mx-auto">
                                                                                    <button type="button" class="btn btn-primary" id="payButton" data-token="">Pay Now</button>
                                                                                </div>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
            
                                                                        <div class="tab-pane" id="canceled-tabpanelkuliner" role="tabpanelkuliner" aria-labelledby="canceled-tabkuliner">
                                                                            <div class="row">
                                                                                @foreach($canceledkuliner as $key => $canceledkuliner)
                                                                                                <div class="col-md-12 mb-4">
                                                                                                    <div class="card float-right pb-0">
                                                                                                        <div class="row">
                                                                                                        <div class="col-sm-5 order-status">
                                                                                                            <img class="d-block w-100" src="{{ $canceledkuliner->kuliner->getFirstMediaUrl('photos') }}" width="400" height="200" alt="Thumbnail">
                                                                                                        </div>
                                                                                                        <div class="col-sm-7">
                                                                                                            <div class="card-block-ticket h-100 order-cta">
                                                                                                                <h4 class="card-title" style="text-transform: uppercase;">{{ $canceledkuliner->kuliner->namakuliner ?? '' }}</h4>
            
                                                                                                            <div class="order-info mb-3">
                                                                                                                <ul class="list-unstyled mt-1">
                                                                                                                <li><i class="bi-receipt w-100"></i> <b>{{ $canceledkuliner->kodetiket ?? '' }}</b></li>
                                                                                                                <li><i class="bi-file-person w-100"></i> <b>{{ Auth::guard('wisatawans')->user()->name }}</b></li>
                                                                                                                <li><i class="bi-ticket w-100"></i>
                                                                                                                                                    <b>Status Pembayaran</b>@if ($canceledkuliner->payment_status == 00)
                                                                                                                                                    <span class="badge badge-info ">Menunggu Pembayaran</span>
                                                                                                                                                @elseif ($canceledkuliner->payment_status == 11)
                                                                                                                                                    <span class="badge badge-success">Sudah di Bayar</span>
                                                                                                                                                @elseif ($canceledkuliner->payment_status == 22)
                                                                                                                                                    <span class="badge badge-warning">Kadaluarsa</span>
                                                                                                                                                @elseif ($canceledkuliner->payment_status == 33)
                                                                                                                                                    <span class="badge badge-danger">Batal</span>
                                                                                                                                                @endif
                                                                                                                                                    
                                                                                                                                                                                    </li>
                                                                                                                <li><i class="bi-cash-stack w-100"></i> <b>Rp. {{ number_format($canceledkuliner->totalHarga, 0, ".", ".") }},-</b>@if ($canceledkuliner->metodepembayaran == "Online")
                                                                                                                    <span class="badge rounded-pill bg-primary ">Online</span>
                                                                                                                @elseif ($canceledkuliner->metodepembayaran == "Tunai")
                                                                                                                    <span class="badge rounded-pill bg-success">Tunai</span>
                                                                                                                    @endif</li>
                                                                                                                    <li><i class="bi-calendar2-check w-100"></i> Tanggal Order: <b>{{ date('d-m-Y', strtotime($canceledkuliner->created_at)) }}</b></li>
                                                                                                                    <li><i class="bi-calendar3-event w-100"></i> Tanggal Kunjungan <b>{{ date('d-m-Y', strtotime($canceledkuliner->tanggalkunjungan)) }}</b></li>
                                                                                                                </ul>
                                                                                                            </div>
                                                                                                            <div class="btn-group-card align-self-end mb-2">
                                                                                                                <a id="23453_showDetail" class="btn btn-primary btn-sm float-right me-0" data-order="{&quot;id&quot;:23453,&quot;ms_event_id&quot;:1,&quot;customer_id&quot;:21773,&quot;staff_id&quot;:null,&quot;date_purchased&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;type&quot;:&quot;online&quot;,&quot;gross&quot;:300000,&quot;tax&quot;:24900,&quot;discount&quot;:0,&quot;platform_fee&quot;:7000,&quot;voucher_code&quot;:null,&quot;voucher_disc&quot;:0,&quot;voucher_total_product&quot;:0,&quot;voucher_amount&quot;:0,&quot;nett&quot;:331900,&quot;money_paid&quot;:0,&quot;change&quot;:0,&quot;status&quot;:&quot;cancel&quot;,&quot;reason&quot;:&quot;expire&quot;,&quot;ref_order_id&quot;:&quot;9582f6e6-ec22-47fe-b2c2-4eb13ba08e9b&quot;,&quot;type_payment&quot;:&quot;qris&quot;,&quot;booking_code&quot;:&quot;9374AB&quot;,&quot;reschedule_token&quot;:null,&quot;reschedule_expired&quot;:null,&quot;snap_token&quot;:&quot;809440af-14ea-4a0f-a5f8-473b7352a7a9&quot;,&quot;type_payment_pg&quot;:&quot;QRIS&quot;,&quot;created_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-12T11:59:48.000000Z&quot;,&quot;order_id&quot;:&quot;SNST66698669374AB&quot;,&quot;trx_event_detail_id&quot;:5,&quot;date_purchased_format&quot;:&quot;12-06-2024&quot;,&quot;time_purchased_format&quot;:&quot;06:28:41&quot;,&quot;gross_format&quot;:&quot;Rp. 300,000.00&quot;,&quot;tax_format&quot;:&quot;Rp. 24,900.00&quot;,&quot;discount_format&quot;:&quot;&quot;,&quot;platform_fee_format&quot;:&quot;Rp. 7,000.00&quot;,&quot;voucher_disc_format&quot;:&quot;&quot;,&quot;voucher_amount_format&quot;:&quot;&quot;,&quot;nett_format&quot;:&quot;Rp. 331,900.00&quot;,&quot;event_detail&quot;:{&quot;id&quot;:5,&quot;ms_event_id&quot;:4,&quot;location_id&quot;:3,&quot;time_start&quot;:&quot;2024-11-01T17:00:00.000000Z&quot;,&quot;time_end&quot;:&quot;2024-11-02T17:00:00.000000Z&quot;,&quot;status&quot;:&quot;active&quot;,&quot;created_at&quot;:&quot;2024-03-09T06:03:42.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-08-02T06:40:12.000000Z&quot;,&quot;card_file&quot;:null,&quot;card_history&quot;:&quot;sunset-di-kebun-raya-purwodadi-2024-phase-2.jpg&quot;,&quot;card_eticket&quot;:null,&quot;ticket_properties&quot;:{&quot;eticket_tnc&quot;:&quot;\u003Cp\u003E\u003Cstrong\u003EKetentuan Umum:\u003C\/strong\u003E\u003C\/p\u003E\r\n\r\n\u003Col\u003E\r\n\t\u003Cli\u003EPenukaran tiket dimulai pukul 09.30 - 15.30 WIB, pengunjung tidak diperkenankan melakukan penukaran tiket diluar jam yang telah ditentukan.\u003C\/li\u003E\r\n\t\u003Cli\u003EOpen gate pukul 10.00 WIB dan close gate pukul 15.30 WIB, pengunjung tidak diperkenankan memasuki area Sunset di Kebun di luar jam yang telah ditentukan.\u003C\/li\u003E\r\n\t\u003Cli\u003ETiket Early Bird dan Presale tidak dapat dipindah tangankan.\u003C\/li\u003E\r\n\t\u003Cli\u003ETiket ini menggunakan sistem QR dan berlaku untuk 1 (satu) orang.\u003C\/li\u003E\r\n\t\u003Cli\u003ETiket hanya dapat digunakan sesuai dengan hari yang tercantum pada tiket.\u003C\/li\u003E\r\n\t\u003Cli\u003EUntuk informas terkait syarat dan ketentuan yang berlaku silakan kunjungi \u003Cstrong\u003E\u003Ca href=\&quot;https:\/\/sunset.kebunraya.id\/information\&quot;\u003Esunset.kebunraya.id\/information\u003C\/a\u003E\u003C\/strong\u003E\u003C\/li\u003E\r\n\u003C\/ol\u003E&quot;,&quot;evoucher_tnc&quot;:null,&quot;eticket_merch&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/eticket\/eticket_merch_1721467837.jpg&quot;,&quot;compliment_tnc&quot;:null,&quot;eticket_default&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/eticket\/eticket_default_1721467837.jpg&quot;,&quot;eticket_voucher&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/eticket\/eticket_voucher_1721467837.jpg&quot;,&quot;merchandise_tnc&quot;:null,&quot;eticket_compliment&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/eticket\/eticket_compliment_1721467837.jpg&quot;},&quot;identity_properties&quot;:{&quot;card_image&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/identity\/card_image_1722580235.png&quot;,&quot;card_phase&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/identity\/card_phase_1722580812.png&quot;,&quot;card_history&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/identity\/card_history_1721467837.jpg&quot;},&quot;location&quot;:{&quot;id&quot;:3,&quot;name&quot;:&quot;Kebun Raya Purwodadi&quot;,&quot;slug&quot;:&quot;kebun-raya-purwodadi&quot;,&quot;address&quot;:&quot;Phase 1&quot;,&quot;created_at&quot;:null,&quot;updated_at&quot;:&quot;2024-03-09T04:57:26.000000Z&quot;},&quot;event&quot;:{&quot;id&quot;:4,&quot;name&quot;:&quot;Sunset di Kebun&quot;,&quot;slug&quot;:&quot;sunset-di-kebun&quot;,&quot;poster&quot;:&quot;&quot;,&quot;description&quot;:&quot;Sunset di Kebun Phase 2&quot;,&quot;status&quot;:&quot;published&quot;,&quot;created_at&quot;:&quot;2024-04-27T02:29:10.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-27T22:09:08.000000Z&quot;,&quot;prefix&quot;:&quot;SNSTP2&quot;}},&quot;customer&quot;:{&quot;id&quot;:21773,&quot;name&quot;:&quot;galihramadhan&quot;,&quot;role&quot;:null,&quot;nik&quot;:&quot;3222132804950006&quot;,&quot;phone&quot;:&quot;089509888111&quot;,&quot;email&quot;:&quot;regesaga2@gmail.com&quot;,&quot;email_verified_at&quot;:null,&quot;password&quot;:&quot;$2y$10$fDa1tVAN93wW72323cVkrun8g5\/l2Bp7sX0c6X4omLoekAYxWboGS&quot;,&quot;remember_token&quot;:null,&quot;forgot_token&quot;:null,&quot;date_exp_token&quot;:null,&quot;created_at&quot;:&quot;2024-06-12T11:23:24.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-12T11:23:24.000000Z&quot;,&quot;gender&quot;:&quot;male&quot;,&quot;date_of_birth&quot;:&quot;2024-05-27&quot;,&quot;regional&quot;:&quot;Depok&quot;},&quot;products&quot;:[{&quot;id&quot;:34149,&quot;trx_order_id&quot;:23453,&quot;ms_product_id&quot;:600,&quot;qty&quot;:1,&quot;price&quot;:300000,&quot;dpp&quot;:249000,&quot;tax&quot;:24900,&quot;gross&quot;:300000,&quot;nett&quot;:324900,&quot;created_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;trx_product_detail_id&quot;:692,&quot;product&quot;:{&quot;id&quot;:600,&quot;name&quot;:&quot;Regular - 2 Days Pass&quot;,&quot;slug&quot;:&quot;regular-2-days-pass&quot;,&quot;photo_cover&quot;:null,&quot;description&quot;:&quot;\u003Cp\u003ERegular 2 Days Pass Phase 2 KRP\u003C\/p\u003E&quot;,&quot;status&quot;:1,&quot;is_bundle&quot;:null,&quot;created_at&quot;:null,&quot;updated_at&quot;:null,&quot;ms_category_id&quot;:1,&quot;ms_tax_template_id&quot;:2,&quot;location_id&quot;:3,&quot;photo_cover_url&quot;:&quot;&quot;}}],&quot;tickets&quot;:[{&quot;ticket_id&quot;:&quot;666986695D92B&quot;,&quot;order_id&quot;:&quot;SNST66698669374AB&quot;,&quot;qr_id&quot;:&quot;95D9B0&quot;,&quot;category_id&quot;:600,&quot;price&quot;:150000,&quot;discount&quot;:0,&quot;full_name&quot;:&quot;galihramadhan&quot;,&quot;id_number&quot;:null,&quot;phone&quot;:&quot;089509888111&quot;,&quot;email&quot;:&quot;regesaga2@gmail.com&quot;,&quot;date_start&quot;:&quot;2024-11-02 00:00:00&quot;,&quot;date_expired&quot;:&quot;2024-11-02 00:00:00&quot;,&quot;is_orderer&quot;:1,&quot;timezone&quot;:&quot;00:00:00&quot;,&quot;batch_id&quot;:&quot;01&quot;,&quot;start_time&quot;:&quot;00:00:00&quot;,&quot;status&quot;:0,&quot;checkin_at&quot;:null,&quot;checkout_at&quot;:null,&quot;created_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;pic_email&quot;:null,&quot;pic_name&quot;:null,&quot;pic_phone&quot;:null,&quot;checkin_gate&quot;:null,&quot;checkout_gate&quot;:null,&quot;ms_product_id&quot;:600,&quot;product&quot;:{&quot;id&quot;:600,&quot;name&quot;:&quot;Regular - 2 Days Pass&quot;,&quot;slug&quot;:&quot;regular-2-days-pass&quot;,&quot;photo_cover&quot;:null,&quot;description&quot;:&quot;\u003Cp\u003ERegular 2 Days Pass Phase 2 KRP\u003C\/p\u003E&quot;,&quot;status&quot;:1,&quot;is_bundle&quot;:null,&quot;created_at&quot;:null,&quot;updated_at&quot;:null,&quot;ms_category_id&quot;:1,&quot;ms_tax_template_id&quot;:2,&quot;location_id&quot;:3,&quot;photo_cover_url&quot;:&quot;&quot;}},{&quot;ticket_id&quot;:&quot;66698669587EF&quot;,&quot;order_id&quot;:&quot;SNST66698669374AB&quot;,&quot;qr_id&quot;:&quot;958865&quot;,&quot;category_id&quot;:600,&quot;price&quot;:150000,&quot;discount&quot;:0,&quot;full_name&quot;:&quot;galihramadhan&quot;,&quot;id_number&quot;:null,&quot;phone&quot;:&quot;089509888111&quot;,&quot;email&quot;:&quot;regesaga2@gmail.com&quot;,&quot;date_start&quot;:&quot;2024-11-03 00:00:00&quot;,&quot;date_expired&quot;:&quot;2024-11-03 00:00:00&quot;,&quot;is_orderer&quot;:0,&quot;timezone&quot;:&quot;00:00:00&quot;,&quot;batch_id&quot;:&quot;01&quot;,&quot;start_time&quot;:&quot;00:00:00&quot;,&quot;status&quot;:0,&quot;checkin_at&quot;:null,&quot;checkout_at&quot;:null,&quot;created_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;pic_email&quot;:null,&quot;pic_name&quot;:null,&quot;pic_phone&quot;:null,&quot;checkin_gate&quot;:null,&quot;checkout_gate&quot;:null,&quot;ms_product_id&quot;:600,&quot;product&quot;:{&quot;id&quot;:600,&quot;name&quot;:&quot;Regular - 2 Days Pass&quot;,&quot;slug&quot;:&quot;regular-2-days-pass&quot;,&quot;photo_cover&quot;:null,&quot;description&quot;:&quot;\u003Cp\u003ERegular 2 Days Pass Phase 2 KRP\u003C\/p\u003E&quot;,&quot;status&quot;:1,&quot;is_bundle&quot;:null,&quot;created_at&quot;:null,&quot;updated_at&quot;:null,&quot;ms_category_id&quot;:1,&quot;ms_tax_template_id&quot;:2,&quot;location_id&quot;:3,&quot;photo_cover_url&quot;:&quot;&quot;}}],&quot;paid_amount&quot;:&quot;Rp331.900&quot;}">Detail Order</a>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        @endforeach
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                </div>
                                            </div>
                                         </div>

                                </div>


                                <div class="tab-pane" id="canceled-tabakomodasi" role="tabpanel" aria-labelledby="canceled-akomodasi">
                                    <div class="card">
                                        <a href="">
                
                                        <div class="card-body">
                                                     <h4>Riwayat reservasi Akomodasi</h4>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="card text-center">
                                                                        <div class="card-body">
                                                                            <h3>Belum Dibayar</h3>
                                                                            <hr>
                                                                            <p>{{ $jumlah_akomodasibelumdibayar }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="card text-center">
                                                                        <div class="card-body">
                                                                            <h3>Selesai</h3>
                                                                            <hr>
                                                                            <p>{{ $jumlah_selesaiakomodasi }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="card text-center">
                                                                        <div class="card-body">
                                                                            <h3>Kadaluarsa</h3>
                                                                            <hr>
                                                                            <p>{{ $jumlah_akomodasikadaluarsa }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                       
                                        </div>
                                        </a>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 mt-3">
                                            <div class="row">
                                                      <div class="col-lg-12">
                                                            <ul class="nav nav-pills justify-content-end" role="tablist">
                                                                <li class="nav-item" role="presentation">
                                                                <a class="nav-link active" id="acvite-tabakomodasi" data-bs-toggle="tab" href="#acvite-tabpanelakomodasi" role="tab" aria-controls="acvite-tabpanelakomodasi" aria-selected="false"> Active </a>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                <a class="nav-link" id="canceled-tabakomodasi" data-bs-toggle="tab" href="#canceled-tabpanelakomodasi" role="tab" aria-controls="canceled-tabpanelakomodasi" aria-selected="true"> Canceled </a>
                                                                </li>
                                                            </ul>
                                                            <div class="tab-content pt-4" id="pills-tabContent">
                                                                    <div class="tab-pane active" id="acvite-tabpanelakomodasi" role="tabpanelakomodasi" aria-labelledby="acvite-tabakomodasi">
                                                                        <div class="row">
                                                                            @foreach($pesanakomodasi as $key => $pesanakomodasi)
                                                                                            <div class="col-md-12 mb-4">
                                                                                                <div class="card float-right pb-0">
                                                                                                    <div class="row">
                                                                                                    <div class="col-sm-5 order-status">
                                                                                                        <img class="d-block w-100" src="{{ $pesanakomodasi->akomodasi->getFirstMediaUrl('photos') }}" width="400" height="200" alt="Thumbnail">
                                                                                                    </div>
                                                                                                    <div class="col-sm-7">
                                                                                                        <div class="card-block-ticket h-100 order-cta">
                                                                                                            <h4 class="card-title" style="text-transform: uppercase;">{{ $pesanakomodasi->akomodasi->namaakomodasi ?? '' }}</h4>
        
                                                                                                        <div class="order-info mb-3">
                                                                                                            <ul class="list-unstyled mt-1">
                                                                                                            <li><i class="bi-receipt w-100"></i> <b>{{ $pesanakomodasi->kodeboking ?? '' }}</b></li>
                                                                                                            <li><i class="bi-file-person w-100"></i> <b>{{ Auth::guard('wisatawans')->user()->name }}</b></li>
                                                                                                            <li><i class="bi-ticket w-100"></i>
                                                                                                                                                <b>Status Pembayaran</b>@if ($pesanakomodasi->payment_status == 00)
                                                                                                                                                <span class="badge badge-info ">Menunggu Pembayaran</span>
                                                                                                                                            @elseif ($pesanakomodasi->payment_status == 11)
                                                                                                                                                <span class="badge badge-success">Sudah di Bayar</span>
                                                                                                                                            @elseif ($pesanakomodasi->payment_status == 22)
                                                                                                                                                <span class="badge badge-warning">Kadaluarsa</span>
                                                                                                                                            @elseif ($pesanakomodasi->payment_status == 33)
                                                                                                                                                <span class="badge badge-danger">Batal</span>
                                                                                                                                            @endif
                                                                                                                                                
                                                                                                                                                                                </li>
                                                                                                            <li><i class="bi-cash-stack w-100"></i> <b>Rp. {{ number_format($pesanakomodasi->totalHarga, 0, ".", ".") }},-</b>@if ($pesanakomodasi->metodepembayaran == "Online")
                                                                                                                <span class="badge rounded-pill bg-primary ">Online</span>
                                                                                                            @elseif ($pesanakomodasi->metodepembayaran == "Tunai")
                                                                                                                <span class="badge rounded-pill bg-success">Tunai</span>
                                                                                                                @endif</li>
                                                                                                                <li><i class="bi-calendar2-check w-100"></i> Tanggal Order: <b>{{ date('d-m-Y', strtotime($pesanakomodasi->created_at)) }}</b></li>
                                                                                                                <li><i class="bi-calendar3-event w-100"></i> Tanggal Kunjungan <b>{{ date('d-m-Y', strtotime($pesanakomodasi->tanggalkunjungan)) }}</b></li>
                                                                                                            </ul>
                                                                                                        </div>
                                                                                                        <a href="{{ route('website.reserv.checkout_finish', ['reserv' => $pesanakomodasi->kodeboking]) }}">
                                                                                                            <span class="badge badge-danger">Cetak</span>
                                                                                                        </a>
                                                                                                        <div class="btn-group-card align-self-end mb-2">
                                                                                                            <a id="23453_showDetail" class="btn btn-primary btn-sm float-right me-0">Detail Order</a>
                                                                                                        </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    @endforeach
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal fade" id="dtOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                            <div class="container">
                                                                                <!-- Stack the columns on mobile by making one full-width and the other half-width -->
                                                                                <div class="row">
                                                                                <h4>Order ID <small class="text-secondary" id="orderId">#SNST78128937198273</small></h4>
                                                                                <div class="col-md-4 col-sm-12">
                                                                                    <div class="row justify-content-center">
                                                                                    <div class="col-12 text-center">
                                                                                        <div id="qrcode" style="padding:20px;height:auto;width:140px;margin:auto;"></div>
                                                                                    </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-8 col-sm-12 py-3">
                                                                                    <ul class="list-unstyled mt-1">
                                                                                    <li><i class="bi-calendar2-check me-2"></i> Order Date: <b id="datePurchased"></b></li>
                                                                                    <li><i class="bi-cash-stack me-2"></i> Amount: <b id="nettAmount"></b></li>
                                                                                    <li><i class="bi-chat-right-dots me-2"></i> Status Payment: <b id="orderStatus"></b> | <small id="typePayment"></small></li>
                                                                                    </ul>
                                                                                </div>
                                                                                <hr class="hr" />
                                                                                <div class="col-12" id="detailProducts"></div>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                            <div class="modal-footer justify-content-center">
                                                                            <div class="d-grid gap-2 col-6 mx-auto">
                                                                                <button type="button" class="btn btn-primary" id="payButton" data-token="">Pay Now</button>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                    </div>
        
                                                                    <div class="tab-pane" id="canceled-tabpanelakomodasi" role="tabpanelakomodasi" aria-labelledby="canceled-tabakomodasi">
                                                                        <div class="row">
                                                                            @foreach($canceledakomodasi as $key => $canceledakomodasi)
                                                                                            <div class="col-md-12 mb-4">
                                                                                                <div class="card float-right pb-0">
                                                                                                    <div class="row">
                                                                                                    <div class="col-sm-5 order-status">
                                                                                                        <img class="d-block w-100" src="{{ $canceledakomodasi->akomodasi->getFirstMediaUrl('photos') }}" width="400" height="200" alt="Thumbnail">
                                                                                                    </div>
                                                                                                    <div class="col-sm-7">
                                                                                                        <div class="card-block-ticket h-100 order-cta">
                                                                                                            <h4 class="card-title" style="text-transform: uppercase;">{{ $canceledakomodasi->akomodasi->namaakomodasi ?? '' }}</h4>
        
                                                                                                        <div class="order-info mb-3">
                                                                                                            <ul class="list-unstyled mt-1">
                                                                                                            <li><i class="bi-receipt w-100"></i> <b>{{ $canceledakomodasi->kodetiket ?? '' }}</b></li>
                                                                                                            <li><i class="bi-file-person w-100"></i> <b>{{ Auth::guard('wisatawans')->user()->name }}</b></li>
                                                                                                            <li><i class="bi-ticket w-100"></i>
                                                                                                                                                <b>Status Pembayaran</b>@if ($canceledakomodasi->payment_status == 00)
                                                                                                                                                <span class="badge badge-info ">Menunggu Pembayaran</span>
                                                                                                                                            @elseif ($canceledakomodasi->payment_status == 11)
                                                                                                                                                <span class="badge badge-success">Sudah di Bayar</span>
                                                                                                                                            @elseif ($canceledakomodasi->payment_status == 22)
                                                                                                                                                <span class="badge badge-warning">Kadaluarsa</span>
                                                                                                                                            @elseif ($canceledakomodasi->payment_status == 33)
                                                                                                                                                <span class="badge badge-danger">Batal</span>
                                                                                                                                            @endif
                                                                                                                                                
                                                                                                                                                                                </li>
                                                                                                            <li><i class="bi-cash-stack w-100"></i> <b>Rp. {{ number_format($canceledakomodasi->totalHarga, 0, ".", ".") }},-</b>@if ($canceledakomodasi->metodepembayaran == "Online")
                                                                                                                <span class="badge rounded-pill bg-primary ">Online</span>
                                                                                                            @elseif ($canceledakomodasi->metodepembayaran == "Tunai")
                                                                                                                <span class="badge rounded-pill bg-success">Tunai</span>
                                                                                                                @endif</li>
                                                                                                                <li><i class="bi-calendar2-check w-100"></i> Tanggal Order: <b>{{ date('d-m-Y', strtotime($canceledakomodasi->created_at)) }}</b></li>
                                                                                                                <li><i class="bi-calendar3-event w-100"></i> Tanggal Kunjungan <b>{{ date('d-m-Y', strtotime($canceledakomodasi->tanggalkunjungan)) }}</b></li>
                                                                                                            </ul>
                                                                                                        </div>
                                                                                                        <div class="btn-group-card align-self-end mb-2">
                                                                                                            <a id="23453_showDetail" class="btn btn-primary btn-sm float-right me-0" data-order="{&quot;id&quot;:23453,&quot;ms_event_id&quot;:1,&quot;customer_id&quot;:21773,&quot;staff_id&quot;:null,&quot;date_purchased&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;type&quot;:&quot;online&quot;,&quot;gross&quot;:300000,&quot;tax&quot;:24900,&quot;discount&quot;:0,&quot;platform_fee&quot;:7000,&quot;voucher_code&quot;:null,&quot;voucher_disc&quot;:0,&quot;voucher_total_product&quot;:0,&quot;voucher_amount&quot;:0,&quot;nett&quot;:331900,&quot;money_paid&quot;:0,&quot;change&quot;:0,&quot;status&quot;:&quot;cancel&quot;,&quot;reason&quot;:&quot;expire&quot;,&quot;ref_order_id&quot;:&quot;9582f6e6-ec22-47fe-b2c2-4eb13ba08e9b&quot;,&quot;type_payment&quot;:&quot;qris&quot;,&quot;booking_code&quot;:&quot;9374AB&quot;,&quot;reschedule_token&quot;:null,&quot;reschedule_expired&quot;:null,&quot;snap_token&quot;:&quot;809440af-14ea-4a0f-a5f8-473b7352a7a9&quot;,&quot;type_payment_pg&quot;:&quot;QRIS&quot;,&quot;created_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-12T11:59:48.000000Z&quot;,&quot;order_id&quot;:&quot;SNST66698669374AB&quot;,&quot;trx_event_detail_id&quot;:5,&quot;date_purchased_format&quot;:&quot;12-06-2024&quot;,&quot;time_purchased_format&quot;:&quot;06:28:41&quot;,&quot;gross_format&quot;:&quot;Rp. 300,000.00&quot;,&quot;tax_format&quot;:&quot;Rp. 24,900.00&quot;,&quot;discount_format&quot;:&quot;&quot;,&quot;platform_fee_format&quot;:&quot;Rp. 7,000.00&quot;,&quot;voucher_disc_format&quot;:&quot;&quot;,&quot;voucher_amount_format&quot;:&quot;&quot;,&quot;nett_format&quot;:&quot;Rp. 331,900.00&quot;,&quot;event_detail&quot;:{&quot;id&quot;:5,&quot;ms_event_id&quot;:4,&quot;location_id&quot;:3,&quot;time_start&quot;:&quot;2024-11-01T17:00:00.000000Z&quot;,&quot;time_end&quot;:&quot;2024-11-02T17:00:00.000000Z&quot;,&quot;status&quot;:&quot;active&quot;,&quot;created_at&quot;:&quot;2024-03-09T06:03:42.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-08-02T06:40:12.000000Z&quot;,&quot;card_file&quot;:null,&quot;card_history&quot;:&quot;sunset-di-kebun-raya-purwodadi-2024-phase-2.jpg&quot;,&quot;card_eticket&quot;:null,&quot;ticket_properties&quot;:{&quot;eticket_tnc&quot;:&quot;\u003Cp\u003E\u003Cstrong\u003EKetentuan Umum:\u003C\/strong\u003E\u003C\/p\u003E\r\n\r\n\u003Col\u003E\r\n\t\u003Cli\u003EPenukaran tiket dimulai pukul 09.30 - 15.30 WIB, pengunjung tidak diperkenankan melakukan penukaran tiket diluar jam yang telah ditentukan.\u003C\/li\u003E\r\n\t\u003Cli\u003EOpen gate pukul 10.00 WIB dan close gate pukul 15.30 WIB, pengunjung tidak diperkenankan memasuki area Sunset di Kebun di luar jam yang telah ditentukan.\u003C\/li\u003E\r\n\t\u003Cli\u003ETiket Early Bird dan Presale tidak dapat dipindah tangankan.\u003C\/li\u003E\r\n\t\u003Cli\u003ETiket ini menggunakan sistem QR dan berlaku untuk 1 (satu) orang.\u003C\/li\u003E\r\n\t\u003Cli\u003ETiket hanya dapat digunakan sesuai dengan hari yang tercantum pada tiket.\u003C\/li\u003E\r\n\t\u003Cli\u003EUntuk informas terkait syarat dan ketentuan yang berlaku silakan kunjungi \u003Cstrong\u003E\u003Ca href=\&quot;https:\/\/sunset.kebunraya.id\/information\&quot;\u003Esunset.kebunraya.id\/information\u003C\/a\u003E\u003C\/strong\u003E\u003C\/li\u003E\r\n\u003C\/ol\u003E&quot;,&quot;evoucher_tnc&quot;:null,&quot;eticket_merch&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/eticket\/eticket_merch_1721467837.jpg&quot;,&quot;compliment_tnc&quot;:null,&quot;eticket_default&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/eticket\/eticket_default_1721467837.jpg&quot;,&quot;eticket_voucher&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/eticket\/eticket_voucher_1721467837.jpg&quot;,&quot;merchandise_tnc&quot;:null,&quot;eticket_compliment&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/eticket\/eticket_compliment_1721467837.jpg&quot;},&quot;identity_properties&quot;:{&quot;card_image&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/identity\/card_image_1722580235.png&quot;,&quot;card_phase&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/identity\/card_phase_1722580812.png&quot;,&quot;card_history&quot;:&quot;https:\/\/tms.sunset.kebunraya.id\/files\/event\/identity\/card_history_1721467837.jpg&quot;},&quot;location&quot;:{&quot;id&quot;:3,&quot;name&quot;:&quot;Kebun Raya Purwodadi&quot;,&quot;slug&quot;:&quot;kebun-raya-purwodadi&quot;,&quot;address&quot;:&quot;Phase 1&quot;,&quot;created_at&quot;:null,&quot;updated_at&quot;:&quot;2024-03-09T04:57:26.000000Z&quot;},&quot;event&quot;:{&quot;id&quot;:4,&quot;name&quot;:&quot;Sunset di Kebun&quot;,&quot;slug&quot;:&quot;sunset-di-kebun&quot;,&quot;poster&quot;:&quot;&quot;,&quot;description&quot;:&quot;Sunset di Kebun Phase 2&quot;,&quot;status&quot;:&quot;published&quot;,&quot;created_at&quot;:&quot;2024-04-27T02:29:10.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-27T22:09:08.000000Z&quot;,&quot;prefix&quot;:&quot;SNSTP2&quot;}},&quot;customer&quot;:{&quot;id&quot;:21773,&quot;name&quot;:&quot;galihramadhan&quot;,&quot;role&quot;:null,&quot;nik&quot;:&quot;3222132804950006&quot;,&quot;phone&quot;:&quot;089509888111&quot;,&quot;email&quot;:&quot;regesaga2@gmail.com&quot;,&quot;email_verified_at&quot;:null,&quot;password&quot;:&quot;$2y$10$fDa1tVAN93wW72323cVkrun8g5\/l2Bp7sX0c6X4omLoekAYxWboGS&quot;,&quot;remember_token&quot;:null,&quot;forgot_token&quot;:null,&quot;date_exp_token&quot;:null,&quot;created_at&quot;:&quot;2024-06-12T11:23:24.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-12T11:23:24.000000Z&quot;,&quot;gender&quot;:&quot;male&quot;,&quot;date_of_birth&quot;:&quot;2024-05-27&quot;,&quot;regional&quot;:&quot;Depok&quot;},&quot;products&quot;:[{&quot;id&quot;:34149,&quot;trx_order_id&quot;:23453,&quot;ms_product_id&quot;:600,&quot;qty&quot;:1,&quot;price&quot;:300000,&quot;dpp&quot;:249000,&quot;tax&quot;:24900,&quot;gross&quot;:300000,&quot;nett&quot;:324900,&quot;created_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;trx_product_detail_id&quot;:692,&quot;product&quot;:{&quot;id&quot;:600,&quot;name&quot;:&quot;Regular - 2 Days Pass&quot;,&quot;slug&quot;:&quot;regular-2-days-pass&quot;,&quot;photo_cover&quot;:null,&quot;description&quot;:&quot;\u003Cp\u003ERegular 2 Days Pass Phase 2 KRP\u003C\/p\u003E&quot;,&quot;status&quot;:1,&quot;is_bundle&quot;:null,&quot;created_at&quot;:null,&quot;updated_at&quot;:null,&quot;ms_category_id&quot;:1,&quot;ms_tax_template_id&quot;:2,&quot;location_id&quot;:3,&quot;photo_cover_url&quot;:&quot;&quot;}}],&quot;tickets&quot;:[{&quot;ticket_id&quot;:&quot;666986695D92B&quot;,&quot;order_id&quot;:&quot;SNST66698669374AB&quot;,&quot;qr_id&quot;:&quot;95D9B0&quot;,&quot;category_id&quot;:600,&quot;price&quot;:150000,&quot;discount&quot;:0,&quot;full_name&quot;:&quot;galihramadhan&quot;,&quot;id_number&quot;:null,&quot;phone&quot;:&quot;089509888111&quot;,&quot;email&quot;:&quot;regesaga2@gmail.com&quot;,&quot;date_start&quot;:&quot;2024-11-02 00:00:00&quot;,&quot;date_expired&quot;:&quot;2024-11-02 00:00:00&quot;,&quot;is_orderer&quot;:1,&quot;timezone&quot;:&quot;00:00:00&quot;,&quot;batch_id&quot;:&quot;01&quot;,&quot;start_time&quot;:&quot;00:00:00&quot;,&quot;status&quot;:0,&quot;checkin_at&quot;:null,&quot;checkout_at&quot;:null,&quot;created_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;pic_email&quot;:null,&quot;pic_name&quot;:null,&quot;pic_phone&quot;:null,&quot;checkin_gate&quot;:null,&quot;checkout_gate&quot;:null,&quot;ms_product_id&quot;:600,&quot;product&quot;:{&quot;id&quot;:600,&quot;name&quot;:&quot;Regular - 2 Days Pass&quot;,&quot;slug&quot;:&quot;regular-2-days-pass&quot;,&quot;photo_cover&quot;:null,&quot;description&quot;:&quot;\u003Cp\u003ERegular 2 Days Pass Phase 2 KRP\u003C\/p\u003E&quot;,&quot;status&quot;:1,&quot;is_bundle&quot;:null,&quot;created_at&quot;:null,&quot;updated_at&quot;:null,&quot;ms_category_id&quot;:1,&quot;ms_tax_template_id&quot;:2,&quot;location_id&quot;:3,&quot;photo_cover_url&quot;:&quot;&quot;}},{&quot;ticket_id&quot;:&quot;66698669587EF&quot;,&quot;order_id&quot;:&quot;SNST66698669374AB&quot;,&quot;qr_id&quot;:&quot;958865&quot;,&quot;category_id&quot;:600,&quot;price&quot;:150000,&quot;discount&quot;:0,&quot;full_name&quot;:&quot;galihramadhan&quot;,&quot;id_number&quot;:null,&quot;phone&quot;:&quot;089509888111&quot;,&quot;email&quot;:&quot;regesaga2@gmail.com&quot;,&quot;date_start&quot;:&quot;2024-11-03 00:00:00&quot;,&quot;date_expired&quot;:&quot;2024-11-03 00:00:00&quot;,&quot;is_orderer&quot;:0,&quot;timezone&quot;:&quot;00:00:00&quot;,&quot;batch_id&quot;:&quot;01&quot;,&quot;start_time&quot;:&quot;00:00:00&quot;,&quot;status&quot;:0,&quot;checkin_at&quot;:null,&quot;checkout_at&quot;:null,&quot;created_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;updated_at&quot;:&quot;2024-06-12T11:28:41.000000Z&quot;,&quot;pic_email&quot;:null,&quot;pic_name&quot;:null,&quot;pic_phone&quot;:null,&quot;checkin_gate&quot;:null,&quot;checkout_gate&quot;:null,&quot;ms_product_id&quot;:600,&quot;product&quot;:{&quot;id&quot;:600,&quot;name&quot;:&quot;Regular - 2 Days Pass&quot;,&quot;slug&quot;:&quot;regular-2-days-pass&quot;,&quot;photo_cover&quot;:null,&quot;description&quot;:&quot;\u003Cp\u003ERegular 2 Days Pass Phase 2 KRP\u003C\/p\u003E&quot;,&quot;status&quot;:1,&quot;is_bundle&quot;:null,&quot;created_at&quot;:null,&quot;updated_at&quot;:null,&quot;ms_category_id&quot;:1,&quot;ms_tax_template_id&quot;:2,&quot;location_id&quot;:3,&quot;photo_cover_url&quot;:&quot;&quot;}}],&quot;paid_amount&quot;:&quot;Rp331.900&quot;}">Detail Order</a>
                                                                                                        </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    @endforeach
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </div>
                                            </div>
                                        </div>
                                     </div>

                                    </div>

                            </div>
                            
                
              
               
                
            </div>
        </section>
    </div>
@endSection
