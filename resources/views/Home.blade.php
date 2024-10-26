
<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0">
            <title>Data Kunjungan Wisata Online</title>
        <!-- FAVICON -->
        <link href="{{ asset('images/logo/KuninganBeu_Kuning.png') }}" rel="apple-touch-icon"  sizes="180x180">
    <link rel="icon" type="image/png" sizes="32x32" ref="{{ asset('images/logo/KuninganBeu_Kuning.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" ref="{{ asset('images/logo/KuninganBeu_Kuning.png') }}">
    <link rel="manifest" href="https://dakuwison.gresikkab.go.id/assets/favicon/site.webmanifest">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" type="text/css" href="https://dakuwison.gresikkab.go.id/assets/admin/vendor/libs/font-awesome/css/all.min.css">
    <script src="https://dakuwison.gresikkab.go.id/assets/admin/vendor/libs/font-awesome/js/all.min.js" data-auto-add-css="false" data-auto-replace-svg="false"></script>
            <link rel="stylesheet" href="https://dakuwison.gresikkab.go.id/assets/admin/vendor/css/pages/page-auth.css">
        <link rel="stylesheet" href="https://dakuwison.gresikkab.go.id/assets/admin/vendor/css/rtl/core.css" class="template-customizer-core-css">
    <link rel="stylesheet" href="https://dakuwison.gresikkab.go.id/assets/admin/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css">
    <link rel="stylesheet" href="https://dakuwison.gresikkab.go.id/assets/admin/css/demo.css">
    <link rel="stylesheet" href="https://dakuwison.gresikkab.go.id/assets/admin/css/custom.css">
    <script src="https://dakuwison.gresikkab.go.id/assets/admin/vendor/js/helpers.js"></script>
    <script src="https://dakuwison.gresikkab.go.id/assets/admin/js/config.js"></script>
        <style>
        g.apexcharts-xaxis.apexcharts-yaxis-inversed g text {
            fill: black !important;
        }
    </style>
<!-- Livewire Styles --><style >[wire\:loading][wire\:loading], [wire\:loading\.delay][wire\:loading\.delay], [wire\:loading\.inline-block][wire\:loading\.inline-block], [wire\:loading\.inline][wire\:loading\.inline], [wire\:loading\.block][wire\:loading\.block], [wire\:loading\.flex][wire\:loading\.flex], [wire\:loading\.table][wire\:loading\.table], [wire\:loading\.grid][wire\:loading\.grid], [wire\:loading\.inline-flex][wire\:loading\.inline-flex] {display: none;}[wire\:loading\.delay\.none][wire\:loading\.delay\.none], [wire\:loading\.delay\.shortest][wire\:loading\.delay\.shortest], [wire\:loading\.delay\.shorter][wire\:loading\.delay\.shorter], [wire\:loading\.delay\.short][wire\:loading\.delay\.short], [wire\:loading\.delay\.default][wire\:loading\.delay\.default], [wire\:loading\.delay\.long][wire\:loading\.delay\.long], [wire\:loading\.delay\.longer][wire\:loading\.delay\.longer], [wire\:loading\.delay\.longest][wire\:loading\.delay\.longest] {display: none;}[wire\:offline][wire\:offline] {display: none;}[wire\:dirty]:not(textarea):not(input):not(select) {display: none;}:root {--livewire-progress-bar-color: #2299dd;}[x-cloak] {display: none !important;}</style>
</head>

<body>
            <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('images/logo/KuninganBeu.png') }}" alt="Kuninganbeu" class="w-100" style="height: 24px;object-fit: contain;" loading="lazy">
            </span>
            <span class="app-brand-text menu-text fw-semibold text-dark" style="font-size: 1.1rem;margin-left: 0.3rem !important;">DAKUWISON</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="d-none d-xl-block fa-regular fa-scrubber fa-fw fs-6 align-middle"></i>
            <i class="fa-regular fa-scrubber fa-fw fs-6 d-block d-xl-none align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1" style="overflow-x: hidden !important">
                            <li class="menu-item active">
    <a href="/" class="menu-link">
        <i class="menu-icon fa-regular fa-home-alt fa-fw fs-5"></i>
        <div>Dashboard</div>
    </a>
</li>
<li class="menu-header small text-uppercase">
    <span class="menu-header-text">Master Data</span>
</li>
<li class="menu-item ">
    <a href="/rekapitulasi" class="menu-link">
        <i class="menu-icon fa-regular fa-files fa-fw fs-5"></i>
        <div>Rekapitulasi</div>
    </a>
</li>
            </ul>
</aside>
                <div class="layout-page">
                    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="fa-regular fa-bars fa-fw fs-6"></i>
        </a>
    </div>
    <div class="navbar-nav-right d-flex align-items-center justify-content-between" id="navbar-collapse">
        <div class="navbar-nav">
            <div class="nav-item mb-0">
                <span class="fw-semibold fs-7">Hai, Selamat <span id="selamat"></span></span>
            </div>
        </div>
        <div class="navbar-nav">
            <div class="nav-item mb-0">
                <span class="d-lg-block d-none" id="dateTime"></span>
            </div>
        </div>
        <ul class="navbar-nav align-items-center flew-row">
                            <li class="nav-item">
                    <a href="/login" class="nav-link">
                        <i class="fa-solid fa-arrow-right-to-arc fa-fw text-danger"></i>
                    </a>
                </li>
                    </ul>
    </div>
</nav>
                    <div class="content-wrapper">
                        <div class="container-xxl flex-grow-1 container-p-y">
                                    <div wire:snapshot="{&quot;data&quot;:{&quot;queryString&quot;:[[&quot;year&quot;],{&quot;s&quot;:&quot;arr&quot;}],&quot;year&quot;:2024,&quot;years&quot;:[[2024,2023,2022,2021,2020,2019,2018,2017,2016,2015,2014,2013,2012,2011,2010,2009,2008,2007,2006,2005,2004,2003,2002,2001,2000,1999,1998,1997,1996],{&quot;s&quot;:&quot;arr&quot;}],&quot;groups&quot;:[null,{&quot;keys&quot;:[1,2,3],&quot;class&quot;:&quot;Illuminate\\Database\\Eloquent\\Collection&quot;,&quot;modelClass&quot;:&quot;App\\Models\\Group&quot;,&quot;s&quot;:&quot;elcln&quot;}],&quot;countries&quot;:[null,{&quot;keys&quot;:[25,14,6,20,19,1,15,7,17,10,24,16,9,21,18,23,2,8,11,12,22,3,13],&quot;class&quot;:&quot;Illuminate\\Database\\Eloquent\\Collection&quot;,&quot;modelClass&quot;:&quot;App\\Models\\Country&quot;,&quot;s&quot;:&quot;elcln&quot;}],&quot;another_country&quot;:[null,{&quot;class&quot;:&quot;App\\Models\\Country&quot;,&quot;key&quot;:26,&quot;s&quot;:&quot;mdl&quot;}],&quot;operators&quot;:91,&quot;places&quot;:78},&quot;memo&quot;:{&quot;id&quot;:&quot;YkHO6oe2HSCOImFTozSD&quot;,&quot;name&quot;:&quot;super-admin.dashboard.dashboard-index&quot;,&quot;path&quot;:&quot;\/&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;id&quot;},&quot;checksum&quot;:&quot;aad1c6503f3cb051eb0b5a702243a71dfe0e2723c5fd42ec358dbad5ae437ab0&quot;}" wire:effects="{&quot;url&quot;:{&quot;year&quot;:{&quot;as&quot;:&quot;year&quot;,&quot;use&quot;:&quot;push&quot;,&quot;alwaysShow&quot;:false,&quot;except&quot;:null}}}" wire:id="YkHO6oe2HSCOImFTozSD">
    <div wire:loading wire:target="year">
        <div class="loading-screen">
    <div>
        <i class="fa-solid fa-circle-notch fa-spin fa-3x mb-3"></i>
        <h3 class="text-center text-dark fw-semibold">Loading..</h3>
    </div>
</div>
    </div>
    <div class="row g-3">
        
        <div class="col-12">
            <div class="d-flex">
                <div>
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="ms-auto">
                    <select class="form-select" wire:model.live="year">
                                                    <option value="2024">2024</option>
                                                    <option value="2023">2023</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2020">2020</option>
                                                    <option value="2019">2019</option>
                                                    <option value="2018">2018</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2013">2013</option>
                                                    <option value="2012">2012</option>
                                                    <option value="2011">2011</option>
                                                    <option value="2010">2010</option>
                                                    <option value="2009">2009</option>
                                                    <option value="2008">2008</option>
                                                    <option value="2007">2007</option>
                                                    <option value="2006">2006</option>
                                                    <option value="2005">2005</option>
                                                    <option value="2004">2004</option>
                                                    <option value="2003">2003</option>
                                                    <option value="2002">2002</option>
                                                    <option value="2001">2001</option>
                                                    <option value="2000">2000</option>
                                                    <option value="1999">1999</option>
                                                    <option value="1998">1998</option>
                                                    <option value="1997">1997</option>
                                                    <option value="1996">1996</option>
                                            </select>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <div>
                                <small class="text-muted">Total Wisata</small>
                            </div>
                            <h2 class="mb-0">{{ $jumlah_wisata }}</h2>
                        </div>
                        <div class="ms-auto">
                            <div class="badge p-2 bg-label-success rounded">
                                <i class="fa-regular fa-island-tropical fa-4x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <div>
                                <small class="text-muted">Total Operator</small>
                            </div>
                            <h2 class="mb-0">91</h2>
                        </div>
                        <div class="ms-auto">
                            <div class="badge p-2 bg-label-warning rounded">
                                <i class="fa-regular fa-user-headset fa-4x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <small class="text-muted">Jumlah Pengunjung Pria Tahun 2024</small>
                            <h1 class="mb-0">1.217.183</h1>
                        </div>
                        <div class="ms-auto">
                            <i class="fa-regular fa-mars fa-fw fa-4x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <small class="text-muted">Jumlah Pengunjung Perempuan Tahun 2024</small>
                            <h1 class="mb-0">1.451.288</h1>
                        </div>
                        <div class="ms-auto">
                            <i class="fa-regular fa-venus fa-fw fa-4x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card border-top border-success" style="border-top-width: 3px !important;">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <div>
                                <small class="text-muted">Total Kunjungan Wisatawan Nusantara (WISNU) Tahun 2024</small>
                            </div>
                            <h4 class="mb-0">2.668.186</h4>
                        </div>
                        <div class="ms-auto">
                            <div class="badge p-2 bg-label-success rounded">
                                <i class="fa-regular fa-earth-asia fa-3x"></i>
                            </div>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="mb-1">
                        <small class="text-muted">Jumlah Kunjungan Wisatawan Nusantara Per Kelompok Tahun 2024</small>
                    </div>
                    <div class="row g-2">
                                                    <div class="col-12">
                                <div class="d-flex">
                                    <div>Umum</div>
                                    <div class="ms-auto text-end">40.129.586</div>
                                </div>
                            </div>
                                                    <div class="col-12">
                                <div class="d-flex">
                                    <div>Pelajar (6-18) Tahun</div>
                                    <div class="ms-auto text-end">1.727.128</div>
                                </div>
                            </div>
                                                    <div class="col-12">
                                <div class="d-flex">
                                    <div>Instansi</div>
                                    <div class="ms-auto text-end">34.438</div>
                                </div>
                            </div>
                                            </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card border-top border-info" style="border-top-width: 3px !important;">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <div>
                                <small class="text-muted">Total Kunjungan Wisatawan Mancanegara (WISMAN) Tahun 2024</small>
                            </div>
                            <h4 class="mb-0">285</h4>
                        </div>
                        <div class="ms-auto">
                            <div class="badge p-2 bg-label-info rounded">
                                <i class="fa-regular fa-globe fa-3x"></i>
                            </div>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="mb-1">
                        <small class="text-muted">Jumlah Kunjungan Wisatawan Mancanegara Per Negara Tahun 2024</small>
                    </div>
                    <div class="row g-2">
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Amerika</div>
                                    <div class="ms-auto text-end">31</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Arab</div>
                                    <div class="ms-auto text-end">50</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Australia</div>
                                    <div class="ms-auto text-end">1.001</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Belanda</div>
                                    <div class="ms-auto text-end">46</div>
                                </div>
                            </div>
                                                                                                            <div class="col-12">
                                <div class="d-flex">
                                    <div>Brunei Darussalam</div>
                                    <div class="ms-auto text-end">83</div>
                                </div>
                            </div>
                                                                                                            <div class="col-12">
                                <div class="d-flex">
                                    <div>Cina</div>
                                    <div class="ms-auto text-end">786</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>India</div>
                                    <div class="ms-auto text-end">135</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Inggris</div>
                                    <div class="ms-auto text-end">53</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Irlandia</div>
                                    <div class="ms-auto text-end">2</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Italia</div>
                                    <div class="ms-auto text-end">53</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Jepang</div>
                                    <div class="ms-auto text-end">436</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Jerman</div>
                                    <div class="ms-auto text-end">65</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Korea Selatan</div>
                                    <div class="ms-auto text-end">41</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Korea Utara</div>
                                    <div class="ms-auto text-end">2</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Malaysia</div>
                                    <div class="ms-auto text-end">21.608</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Perancis</div>
                                    <div class="ms-auto text-end">129</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Rusia</div>
                                    <div class="ms-auto text-end">141</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Singapura</div>
                                    <div class="ms-auto text-end">3.009</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Taiwan</div>
                                    <div class="ms-auto text-end">8</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Thailand</div>
                                    <div class="ms-auto text-end">70</div>
                                </div>
                            </div>
                                                                                <div class="col-12">
                                <div class="d-flex">
                                    <div>Vietnam</div>
                                    <div class="ms-auto text-end">92</div>
                                </div>
                            </div>
                                                                                                    <div class="col-12">
                                <div class="d-flex">
                                    <div>Lainnya</div>
                                    <div class="ms-auto text-end">99.832</div>
                                </div>
                            </div>
                                            </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h6 class="mb-0 text-black">Wisata Terpopuler</h6>
                        <small class="text-muted">10 Wisata Terpopuler di 2024</small>
                    </div>
                </div>
                <div class="card-body">
                    <div id="requested_services"></div>
                </div>
            </div>
        </div>
    </div>
</div>

                            </div>
                        <footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
            <div>
                © 2024 DAKUWISON
            </div>
            <div>
                made with ❤️ by <a href="https://burningroom.co.id" target="_blank" class="fw-semibold">Burningroom Technology</a>
            </div>
        </div>
    </div>
</footer>
<div class="content-backdrop fade"></div>
                    </div>
                </div>
            </div>
            <div class="layout-overlay layout-menu-toggle"></div>
            <div class="drag-target"></div>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://dakuwison.gresikkab.go.id/assets/admin/vendor/libs/popper/popper.js"></script>
    <script src="https://dakuwison.gresikkab.go.id/assets/admin/vendor/js/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    /**** Livewire Alert Scripts ****/
    (()=>{var __webpack_modules__={757:(e,t,r)=>{e.exports=r(666)},666:e=>{var t=function(e){"use strict";var t,r=Object.prototype,n=r.hasOwnProperty,o="function"==typeof Symbol?Symbol:{},i=o.iterator||"@@iterator",a=o.asyncIterator||"@@asyncIterator",c=o.toStringTag||"@@toStringTag";function s(e,t,r){return Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}),e[t]}try{s({},"")}catch(e){s=function(e,t,r){return e[t]=r}}function l(e,t,r,n){var o=t&&t.prototype instanceof y?t:y,i=Object.create(o.prototype),a=new x(n||[]);return i._invoke=function(e,t,r){var n=f;return function(o,i){if(n===_)throw new Error("Generator is already running");if(n===d){if("throw"===o)throw i;return S()}for(r.method=o,r.arg=i;;){var a=r.delegate;if(a){var c=L(a,r);if(c){if(c===h)continue;return c}}if("next"===r.method)r.sent=r._sent=r.arg;else if("throw"===r.method){if(n===f)throw n=d,r.arg;r.dispatchException(r.arg)}else"return"===r.method&&r.abrupt("return",r.arg);n=_;var s=u(e,t,r);if("normal"===s.type){if(n=r.done?d:p,s.arg===h)continue;return{value:s.arg,done:r.done}}"throw"===s.type&&(n=d,r.method="throw",r.arg=s.arg)}}}(e,r,a),i}function u(e,t,r){try{return{type:"normal",arg:e.call(t,r)}}catch(e){return{type:"throw",arg:e}}}e.wrap=l;var f="suspendedStart",p="suspendedYield",_="executing",d="completed",h={};function y(){}function v(){}function b(){}var m={};s(m,i,(function(){return this}));var w=Object.getPrototypeOf,g=w&&w(w(D([])));g&&g!==r&&n.call(g,i)&&(m=g);var O=b.prototype=y.prototype=Object.create(m);function E(e){["next","throw","return"].forEach((function(t){s(e,t,(function(e){return this._invoke(t,e)}))}))}function k(e,t){function r(o,i,a,c){var s=u(e[o],e,i);if("throw"!==s.type){var l=s.arg,f=l.value;return f&&"object"==typeof f&&n.call(f,"__await")?t.resolve(f.__await).then((function(e){r("next",e,a,c)}),(function(e){r("throw",e,a,c)})):t.resolve(f).then((function(e){l.value=e,a(l)}),(function(e){return r("throw",e,a,c)}))}c(s.arg)}var o;this._invoke=function(e,n){function i(){return new t((function(t,o){r(e,n,t,o)}))}return o=o?o.then(i,i):i()}}function L(e,r){var n=e.iterator[r.method];if(n===t){if(r.delegate=null,"throw"===r.method){if(e.iterator.return&&(r.method="return",r.arg=t,L(e,r),"throw"===r.method))return h;r.method="throw",r.arg=new TypeError("The iterator does not provide a 'throw' method")}return h}var o=u(n,e.iterator,r.arg);if("throw"===o.type)return r.method="throw",r.arg=o.arg,r.delegate=null,h;var i=o.arg;return i?i.done?(r[e.resultName]=i.value,r.next=e.nextLoc,"return"!==r.method&&(r.method="next",r.arg=t),r.delegate=null,h):i:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,h)}function j(e){var t={tryLoc:e[0]};1 in e&&(t.catchLoc=e[1]),2 in e&&(t.finallyLoc=e[2],t.afterLoc=e[3]),this.tryEntries.push(t)}function P(e){var t=e.completion||{};t.type="normal",delete t.arg,e.completion=t}function x(e){this.tryEntries=[{tryLoc:"root"}],e.forEach(j,this),this.reset(!0)}function D(e){if(e){var r=e[i];if(r)return r.call(e);if("function"==typeof e.next)return e;if(!isNaN(e.length)){var o=-1,a=function r(){for(;++o<e.length;)if(n.call(e,o))return r.value=e[o],r.done=!1,r;return r.value=t,r.done=!0,r};return a.next=a}}return{next:S}}function S(){return{value:t,done:!0}}return v.prototype=b,s(O,"constructor",b),s(b,"constructor",v),v.displayName=s(b,c,"GeneratorFunction"),e.isGeneratorFunction=function(e){var t="function"==typeof e&&e.constructor;return!!t&&(t===v||"GeneratorFunction"===(t.displayName||t.name))},e.mark=function(e){return Object.setPrototypeOf?Object.setPrototypeOf(e,b):(e.__proto__=b,s(e,c,"GeneratorFunction")),e.prototype=Object.create(O),e},e.awrap=function(e){return{__await:e}},E(k.prototype),s(k.prototype,a,(function(){return this})),e.AsyncIterator=k,e.async=function(t,r,n,o,i){void 0===i&&(i=Promise);var a=new k(l(t,r,n,o),i);return e.isGeneratorFunction(r)?a:a.next().then((function(e){return e.done?e.value:a.next()}))},E(O),s(O,c,"Generator"),s(O,i,(function(){return this})),s(O,"toString",(function(){return"[object Generator]"})),e.keys=function(e){var t=[];for(var r in e)t.push(r);return t.reverse(),function r(){for(;t.length;){var n=t.pop();if(n in e)return r.value=n,r.done=!1,r}return r.done=!0,r}},e.values=D,x.prototype={constructor:x,reset:function(e){if(this.prev=0,this.next=0,this.sent=this._sent=t,this.done=!1,this.delegate=null,this.method="next",this.arg=t,this.tryEntries.forEach(P),!e)for(var r in this)"t"===r.charAt(0)&&n.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=t)},stop:function(){this.done=!0;var e=this.tryEntries[0].completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(e){if(this.done)throw e;var r=this;function o(n,o){return c.type="throw",c.arg=e,r.next=n,o&&(r.method="next",r.arg=t),!!o}for(var i=this.tryEntries.length-1;i>=0;--i){var a=this.tryEntries[i],c=a.completion;if("root"===a.tryLoc)return o("end");if(a.tryLoc<=this.prev){var s=n.call(a,"catchLoc"),l=n.call(a,"finallyLoc");if(s&&l){if(this.prev<a.catchLoc)return o(a.catchLoc,!0);if(this.prev<a.finallyLoc)return o(a.finallyLoc)}else if(s){if(this.prev<a.catchLoc)return o(a.catchLoc,!0)}else{if(!l)throw new Error("try statement without catch or finally");if(this.prev<a.finallyLoc)return o(a.finallyLoc)}}}},abrupt:function(e,t){for(var r=this.tryEntries.length-1;r>=0;--r){var o=this.tryEntries[r];if(o.tryLoc<=this.prev&&n.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var i=o;break}}i&&("break"===e||"continue"===e)&&i.tryLoc<=t&&t<=i.finallyLoc&&(i=null);var a=i?i.completion:{};return a.type=e,a.arg=t,i?(this.method="next",this.next=i.finallyLoc,h):this.complete(a)},complete:function(e,t){if("throw"===e.type)throw e.arg;return"break"===e.type||"continue"===e.type?this.next=e.arg:"return"===e.type?(this.rval=this.arg=e.arg,this.method="return",this.next="end"):"normal"===e.type&&t&&(this.next=t),h},finish:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var r=this.tryEntries[t];if(r.finallyLoc===e)return this.complete(r.completion,r.afterLoc),P(r),h}},catch:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var r=this.tryEntries[t];if(r.tryLoc===e){var n=r.completion;if("throw"===n.type){var o=n.arg;P(r)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(e,r,n){return this.delegate={iterator:D(e),resultName:r,nextLoc:n},"next"===this.method&&(this.arg=t),h}},e}(e.exports);try{regeneratorRuntime=t}catch(e){"object"==typeof globalThis?globalThis.regeneratorRuntime=t:Function("r","regeneratorRuntime = r")(t)}}},__webpack_module_cache__={};function __webpack_require__(e){var t=__webpack_module_cache__[e];if(void 0!==t)return t.exports;var r=__webpack_module_cache__[e]={exports:{}};return __webpack_modules__[e](r,r.exports,__webpack_require__),r.exports}__webpack_require__.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return __webpack_require__.d(t,{a:t}),t},__webpack_require__.d=(e,t)=>{for(var r in t)__webpack_require__.o(t,r)&&!__webpack_require__.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:t[r]})},__webpack_require__.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t);var __webpack_exports__={};(()=>{"use strict";var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__=__webpack_require__(757),_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default=__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);function ownKeys(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function _objectSpread(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?ownKeys(Object(r),!0).forEach((function(t){_defineProperty(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):ownKeys(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function _defineProperty(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}function asyncGeneratorStep(e,t,r,n,o,i,a){try{var c=e[i](a),s=c.value}catch(e){return void r(e)}c.done?t(s):Promise.resolve(s).then(n,o)}function _asyncToGenerator(e){return function(){var t=this,r=arguments;return new Promise((function(n,o){var i=e.apply(t,r);function a(e){asyncGeneratorStep(i,n,o,a,c,"next",e)}function c(e){asyncGeneratorStep(i,n,o,a,c,"throw",e)}a(void 0)}))}}function evalCallbacksOptions(options){for(var callbacksKeysAllowed=["allowOutsideClick","allowEscapeKey","allowEnterKey","loaderHtml","inputOptions","inputValidator","preConfirm","preDeny","didClose","didDestroy","didOpen","didRender","willClose","willOpen"],_i=0,_callbacksKeysAllowed=callbacksKeysAllowed;_i<_callbacksKeysAllowed.length;_i++){var callbackKey=_callbacksKeysAllowed[_i];options.hasOwnProperty(callbackKey)&&("string"==typeof options[callbackKey]||options[callbackKey]instanceof String)&&options[callbackKey]&&""!=options[callbackKey].trim()&&(options[callbackKey]=eval(options[callbackKey]))}}function afterAlertInteraction(e){if(e.confirmed)return"self"===e.onConfirmed.component?void Livewire.find(e.onConfirmed.id).dispatchSelf(e.onConfirmed.listener,e.result):void Livewire.dispatchTo(e.onConfirmed.component,e.onConfirmed.listener,e.result);if(e.isDenied)return"self"===e.onDenied.component?void Livewire.find(e.onDenied.id).dispatchSelf(e.onDenied.listener,e.result):void Livewire.dispatchTo(e.onDenied.component,e.onDenied.listener,e.result);if(e.onProgressFinished&&e.dismiss===Swal.DismissReason.timer)return"self"===e.onProgressFinished.component?void Livewire.find(e.onProgressFinished.id).dispatchSelf(e.onProgressFinished.listener,e.result):void Livewire.dispatchTo(e.onProgressFinished.component,e.onProgressFinished.listener,e.result);if(e.onDismissed){if("self"===e.onDismissed.component)return void Livewire.find(e.onDismissed.id).dispatch(e.onDismissed.listener,e.result);Livewire.dispatchTo(e.onDismissed.component,e.onDismissed.listener,e.result)}}window.addEventListener("alert",function(){var e=_asyncToGenerator(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark((function e(t){var r,n,o,i,a,c,s,l;return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return o=t.detail.message,i=null!==(r=t.detail.type)&&void 0!==r?r:null,a=t.detail.data,c=t.detail.events,evalCallbacksOptions(s=t.detail.options),e.next=8,Swal.fire(_objectSpread({title:o,icon:i},s));case 8:afterAlertInteraction(_objectSpread(_objectSpread(_objectSpread({confirmed:(l=e.sent).isConfirmed,denied:l.isDenied,dismiss:l.dismiss,result:_objectSpread(_objectSpread({},l),{},{data:_objectSpread(_objectSpread({},a),{},{inputAttributes:null!==(n=s.inputAttributes)&&void 0!==n?n:null})})},c),l),s));case 10:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}()),window.flashAlert=function(){var e=_asyncToGenerator(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark((function e(t){var r,n,o,i,a,c,s;return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return i=t.events,a=t.events.data,evalCallbacksOptions(c=t.options),e.next=6,Swal.fire(_objectSpread({title:null!==(r=t.message)&&void 0!==r?r:"",icon:null!==(n=t.type)&&void 0!==n?n:null},c));case 6:afterAlertInteraction(_objectSpread(_objectSpread({confirmed:(s=e.sent).isConfirmed,denied:s.isDenied,dismiss:s.dismiss,result:_objectSpread(_objectSpread({},s),{},{data:_objectSpread(_objectSpread({},a),{},{inputAttributes:null!==(o=c.inputAttributes)&&void 0!==o?o:null})})},i),t.options));case 8:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}()})()})();
</script>

        <script src="https://dakuwison.gresikkab.go.id/assets/admin/vendor/js/menu.js"></script>
    <script src="https://dakuwison.gresikkab.go.id/assets/admin/js/main.js"></script>
    <script src="https://huangyifu.github.io/Pikaday-datetimepicker/pikaday.js"></script>
    <script src="https://dakuwison.gresikkab.go.id/assets/admin/js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Service
        var options = {
            series: [{
                name: 'Total',
                data: JSON.parse("[772907,56022,30595,25410,18254,11296,9249,6741,0,0]")
            }],
            chart: {
                type: 'bar',
                height: 450,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    columnWidth: '55%',
                    endingShape: 'rounded',
                    borderRadius: 6,
                    distributed: true,
                },
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: JSON.parse('["MAKAM MALIK IBRAHIM","KUBURAN PANJANG","WISATA TELAGA PELEMWATU","KAMPUNG KEMASAN","PULAU NOKO GILI","DANAU KASTOBA","MUSEUM SUNAN GIRI","MANGROVE KALIMIRENG","MAKAM SUNAN GIRI","MAKAM NYAI AGENG PINATIH"]'),
                labels: {
                    style: {
                        colors: JSON.parse('["#6f859d","#326227","#7acc27","#703996","#62501c","#26114c","#0603fe","#aedf22","#ec21e1","#faa381"]'),
                    },
                    formatter: function(val) {
                        return Math.floor(val)
                    }
                },
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return Math.floor(val)
                    }
                }
            },
            colors: JSON.parse('["#6f859d","#326227","#7acc27","#703996","#62501c","#26114c","#0603fe","#aedf22","#ec21e1","#faa381"]')
        };

        var chart = new ApexCharts(document.querySelector("#requested_services"), options);
        chart.render();
    </script>
<script src="/livewire/livewire.min.js?id=07f22875"   data-csrf="wIf4v3ZCZuyf1stQR9lrmdqs4PbfBgMb7XU2KNkJ" data-update-uri="/livewire/update" data-navigate-once="true"></script>
</body>

</html>
