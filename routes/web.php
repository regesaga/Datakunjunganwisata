<?php
use App\Http\Controllers\CallbackPaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\PesantiketController;
use App\Http\Controllers\ReservController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PesanantiketController;
use App\Http\Controllers\PesankulinerController;
use App\Http\Controllers\PesanankulinerController;
use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Author\AkomodasiAuthorController;
use App\Http\Controllers\Author\GuideAuthorController;
use App\Http\Controllers\Author\WisataAuthorController;
use App\Http\Controllers\Author\KulinerAuthorController;
use App\Http\Controllers\Author\EkrafAuthorController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\KelompokKunjunganController;
use App\Http\Controllers\Admin\WismanNegaraController;
use App\Http\Controllers\Admin\KunjunganWisataController;
use App\Http\Controllers\Admin\BanerPromoController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\BanerController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\WisataController;
use App\Http\Controllers\Admin\RoomsController;
use App\Http\Controllers\Admin\PaketWisataController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\EvencalenderController;
use App\Http\Controllers\Admin\CategoryWisataController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\KulinerController;
use App\Http\Controllers\Admin\KulinerProdukController;
use App\Http\Controllers\Admin\EkrafController;
use App\Http\Controllers\Admin\AkomodasiController;
use App\Http\Controllers\Admin\CategoryAkomodasiController;
use App\Http\Controllers\Admin\CategoryRoomsController;
use App\Http\Controllers\Admin\CategoryKulinerController;
use App\Http\Controllers\Admin\SektorEkrafController;
use App\Http\Controllers\Admin\DataWisatawanController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Wisatawan\DashboardController;
use App\Http\Controllers\Wisatawan\WisatawanController;
use App\Models\Weather;
use App\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialiteController;

//public routes
Route::post('/log-location', [LocationController::class, 'logLocation']);
//youtube
Route::get('/wth/logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/Partnership', [HomeController::class, 'partnership'])->name('kemitraan');

Route::middleware('throttle:10,1')->group(function () {
  Route::get('/destinasi', [HomeController::class, 'destinasi'])->name('website.destinasi');
  Route::get('/event', [HomeController::class, 'event'])->name('website.event');
  Route::get('/articel', [HomeController::class, 'articel'])->name('website.articel');
  Route::get('/kuliner', [HomeController::class, 'kuliner'])->name('website.kuliner');
  Route::get('/datakuliner', [HomeController::class, 'dataKuliner'])->name('website.ajax.kuliner');
  Route::get('/akomodasi', [HomeController::class, 'akomodasi'])->name('website.akomodasi');
  Route::get('/petawisata', [HomeController::class, 'petawisata'])->name('website.petawisata');
  Route::get('/detailwisata/{wisata}', [HomeController::class, 'showdetailwisata'])->name('website.webdetailwisata');
  Route::get('/detailkuliner/{kuliner}', [HomeController::class, 'showdetailkuliner'])->name('website.webdetailkuliner');
  Route::get('/detailkulinerproduk/{kulinerproduk}', [HomeController::class, 'showdetailkulinerproduk'])->name('website.webdetailkulinerproduk');
  Route::get('/detailakomodasi/{akomodasi}', [HomeController::class, 'showdetailakomodasi'])->name('website.webdetailakomodasi');
  Route::get('/detailevencalender/{evencalender}', [HomeController::class, 'showdetailevencalender'])->name('website.webdetailevencalender');
  Route::get('/detailpaketwisata/{paketwisata}', [HomeController::class, 'showdetailpaketwisata'])->name('website.webdetailpaketwisata');
  Route::get('/detailarticel/{articel}', [HomeController::class, 'showdetailarticel'])->name('website.webdetailarticel');
  Route::get('/webdetailpetawisata/{encodedId}', [HomeController::class, 'showdetailpetawisata'])->name('website.webdetailpetawisata');
  Route::get('/webdetailpetakuliner/{encodedId}', [HomeController::class, 'showdetailpetakuliner'])->name('website.webdetailpetakuliner');
  Route::get('/webdetailpetaakomodasi/{encodedId}', [HomeController::class, 'showdetailpetaakomodasi'])->name('website.webdetailpetaakomodasi');
});

Route::post('/detailpaketwisata/{paketwisata}/review-storepaketwisata', [HomeController::class, 'reviewstorepaketwisata'])->name('website.review.storepaketwisata');
Route::put('/detailpaketwisata/{paketwisata}/review/{id}', [HomeController::class, 'reviewupdatepaketwisata'])->name('website.review.updatepaketwisata');


Route::post('/detailwisata/{wisata}/review-store', [HomeController::class, 'reviewstore'])->name('website.review.store');
Route::put('/detailwisata/{wisata}/review/{id}', [HomeController::class, 'reviewupdate'])->name('website.review.update');

Route::post('/detailkuliner/{kuliner}/review-storekuliner', [HomeController::class, 'reviewstorekuliner'])->name('website.review.storekuliner');
Route::put('/detailkuliner/{kuliner}/reviewkuliner/{id}', [HomeController::class, 'reviewupdatekuliner'])->name('website.review.updatekuliner');

Route::post('/detailakomodasi/{akomodasi}/review-storeakomodasi', [HomeController::class, 'reviewstoreakomodasi'])->name('website.review.storeakomodasi');
Route::put('/detailakomodasi/{akomodasi}/reviewakomodasi/{id}', [HomeController::class, 'reviewupdateakomodasi'])->name('website.review.updateakomodasi');


   Route::get('/pesantiket/{wisata_id}', [PesantiketController::class, 'index'])->name('website.pesantiket');
   Route::get('updatetiket/updateExpiredStatus', [PesantiketController::class, 'updateExpiredStatus'])->name('account.wisata.updateExpiredStatus');
    Route::post('/pesantiket', [PesantiketController::class, 'store'])->name('pesantiket.store')->middleware('auth:wisatawans');
    Route::get('/cetaktiket/{pesantiket:kodetiket}', [PesantiketController::class, 'checkoutFinish'])->name('website.pesantiket.checkout_finish');

    Route::post('payments/midtrans-notification', [CallbackPaymentController::class, 'receive']);


    Route::get('/pesankuliner/{kuliner_id}', [PesankulinerController::class, 'index'])->name('website.pesankuliner');
    Route::get('updatekuliner/updateExpiredStatus', [PesankulinerController::class, 'updateExpiredStatus'])->name('account.kuliner.updateExpiredStatus');
     Route::post('/pesankuliner', [PesankulinerController::class, 'store'])->name('pesankuliner.store')->middleware('auth:wisatawans');
     Route::get('/cetakkuliner/{pesankuliner:kodepesanan}', [PesankulinerController::class, 'checkoutFinish'])->name('website.pesankuliner.checkout_finish');


     Route::get('/reserv/{akomodasi_id}', [ReservController::class, 'index'])->name('website.reserv');
     Route::get('updatetiket/updateExpiredStatus', [ReservController::class, 'updateExpiredStatus'])->name('account.reserv.updateExpiredStatus');
      Route::post('/reserv', [ReservController::class, 'store'])->name('reserv.store')->middleware('auth:wisatawans');
      Route::get('/cetakbooking/{reserv:kodeboking}', [ReservController::class, 'checkoutFinish'])->name('website.reserv.checkout_finish');
    
    

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);

Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Route::get('/export-permissions', [UsersController::class, 'exportPermissions']);

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
  // tambahkan rute lain untuk admin di sini0

  Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
  Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.index');
  Route::get('change-password', [AdminController::class, 'changePasswordView'])->name('admin.changePassword');
  Route::delete('delete', [AdminController::class, 'deleteAccount'])->name('admin.delete');
  Route::put('change-password', [AdminController::class, 'changePassword'])->name('admin.changePassword');

  Route::get('getAllPesananTiket', [PesanantiketController::class, 'index'])->name('admin.pesanantiket.index');
  Route::get('pesanan/{wisata_id}', [PesanantiketController::class, 'pesananwisata'])->name('admin.pesanantiket.bywisata');
  Route::get('detailtiketwisata/{id}', [PesanantiketController::class, 'detailtiketwisata'])->name('admin.pesanantiket.detail');
  Route::get('showpesanantiket/show/{pesanantiket}', [PesanantiketController::class, 'show'])->name('admin.pesanantiket.show');
  Route::get('editpesanantiket/edit/{pesanantiket}', [PesanantiketController::class, 'edit'])->name('admin.pesanantiket.edit');
  Route::put('pesanantiketupdate/{pesanantiket}', [PesanantiketController::class, 'update'])->name('admin.pesanantiket.update');
  Route::get('create_pesanantiket', [PesanantiketController::class, 'create'])->name('admin.pesanantiket.create');
  Route::post('pesanantikettore', [PesanantiketController::class, 'store'])->name('admin.pesanantiket.store');
  Route::delete('pesanantiket/destroy', [PesanantiketController::class, 'massDestroy'])->name('admin.pesanantiket.massDestroy');


  Route::get('getAllPesananKuliner', [PesanankulinerController::class, 'index'])->name('admin.pesanankuliner.index');
  Route::get('pesanankuliner/{kuliner_id}', [PesanankulinerController::class, 'pesanankuliner'])->name('admin.pesanankuliner.bykuliner');
  Route::get('detailpesanankuliner/{id}', [PesanankulinerController::class, 'detailpesanankuliner'])->name('admin.pesanankuliner.detail');
  Route::get('showpesanankuliner/show/{pesanankuliner}', [PesanankulinerController::class, 'show'])->name('admin.pesanankuliner.show');
  Route::get('editpesanankuliner/edit/{pesanankuliner}', [PesanankulinerController::class, 'edit'])->name('admin.pesanankuliner.edit');
  Route::put('pesanankulinerupdate/{pesanankuliner}', [PesanankulinerController::class, 'update'])->name('admin.pesanankuliner.update');
  Route::get('create_pesanankuliner', [PesanankulinerController::class, 'create'])->name('admin.pesanankuliner.create');
  Route::post('pesanankulinertore', [PesanankulinerController::class, 'store'])->name('admin.pesanankuliner.store');
  Route::delete('pesanankuliner/destroy', [PesanankulinerController::class, 'massDestroy'])->name('admin.pesanankuliner.massDestroy');


  Route::get('getAllReservation', [ReservationController::class, 'index'])->name('admin.reserv.index');
  Route::get('reserv/{akomodasi_id}', [ReservationController::class, 'reservakomodasi'])->name('admin.reserv.byakomodasi');
  Route::get('reservation/{id}', [ReservationController::class, 'reservationdetail'])->name('admin.reserv.detail');
  Route::get('showreserv/show/{reserv}', [ReservationController::class, 'show'])->name('admin.reserv.show');
  Route::get('editreserv/edit/{reserv}', [ReservationController::class, 'edit'])->name('admin.reserv.edit');
  Route::put('reservupdate/{reserv}', [ReservationController::class, 'update'])->name('admin.reserv.update');
  Route::get('create_reserv', [ReservationController::class, 'create'])->name('admin.reserv.create');
  Route::post('reservtore', [ReservationController::class, 'store'])->name('admin.reserv.store');
  Route::delete('reserv/destroy', [ReservationController::class, 'massDestroy'])->name('admin.reserv.massDestroy');


  Route::get('getAllBaners', [BanerController::class, 'index'])->name('admin.baners.index');
  Route::get('showbaner/show/{baners}', [BanerController::class, 'show'])->name('admin.baners.show');
  Route::get('editbaners/edit/{baners}', [BanerController::class, 'edit'])->name('admin.baners.edit');
  Route::put('banersupdate/{baners}', [BanerController::class, 'update'])->name('admin.baners.update');
  Route::get('create_baners', [BanerController::class, 'create'])->name('admin.baners.create');
  Route::post('banerstore', [BanerController::class, 'store'])->name('admin.baners.store');
  Route::delete('baner/destroy', [BanerController::class, 'massDestroy'])->name('admin.baners.massDestroy');

  Route::delete('baners/{baners}', [BanerController::class, 'destroy'])->name('admin.baners.destroy');

  Route::get('getAllSupports', [SupportController::class, 'index'])->name('admin.support.index');
  Route::get('showbaner/show/{support}', [SupportController::class, 'show'])->name('admin.support.show');
  Route::get('editsupport/edit/{support}', [SupportController::class, 'edit'])->name('admin.support.edit');
  Route::put('supportupdate/{support}', [SupportController::class, 'update'])->name('admin.support.update');
  Route::get('create_support', [SupportController::class, 'create'])->name('admin.support.create');
  Route::post('supporttore', [SupportController::class, 'store'])->name('admin.support.store');
  Route::delete('support/{support}', [SupportController::class, 'destroy'])->name('admin.support.destroy');
  Route::delete('support/destroy', [SupportController::class, 'massDestroy'])->name('admin.support.massDestroy');


  Route::get('getAllBanerPromo', [BanerPromoController::class, 'index'])->name('admin.banerpromo.index');
  Route::get('showbanerpromo/show/{banerpromo}', [BanerPromoController::class, 'show'])->name('admin.banerpromo.show');
  Route::get('editbanerpromo/edit/{banerpromo}', [BanerPromoController::class, 'edit'])->name('admin.banerpromo.edit');
  Route::put('banerpromoupdate/{banerpromo}', [BanerPromoController::class, 'update'])->name('admin.banerpromo.update');
  Route::get('create_banerpromo', [BanerPromoController::class, 'create'])->name('admin.banerpromo.create');
  Route::post('banerpromotore', [BanerPromoController::class, 'store'])->name('admin.banerpromo.store');
  Route::delete('banerpromo/destroy', [BanerPromoController::class, 'massDestroy'])->name('admin.banerpromo.massDestroy');
  Route::delete('banerpromo/{banerpromo}', [BanerPromoController::class, 'destroy'])->name('admin.banerpromo.destroy');

  Route::get('getAllTags', [TagController::class, 'index'])->name('admin.tag.index');
  Route::get('showtag/show/{tag}', [TagController::class, 'show'])->name('admin.tag.show');
  Route::get('edittag/edit/{tag}', [TagController::class, 'edit'])->name('admin.tag.edit');
  Route::put('tagupdate/{tag}', [TagController::class, 'update'])->name('admin.tag.update');
  Route::get('create_tag', [TagController::class, 'create'])->name('admin.tag.create');
  Route::post('tagstore', [TagController::class, 'store'])->name('admin.tag.store');
  Route::delete('tag/destroy', [TagController::class, 'massDestroy'])->name('admin.tag.massDestroy');
  Route::delete('tag/{tag}', [TagController::class, 'destroy'])->name('admin.tag.destroy');


  Route::get('getAllArticle', [ArticleController::class, 'index'])->name('admin.article.index');
  Route::get('showarticle/show/{article}', [ArticleController::class, 'showarticle'])->name('admin.article.show');
  Route::get('editarticle/edit/{article}', [ArticleController::class, 'edit'])->name('admin.article.edit');
  Route::put('articleupdate/{article}', [ArticleController::class, 'update'])->name('admin.article.update');
  Route::get('create_article', [ArticleController::class, 'create'])->name('admin.article.create');
  Route::post('articlestore', [ArticleController::class, 'store'])->name('admin.article.store');
  Route::delete('article/destroy', [ArticleController::class, 'massDestroy'])->name('admin.article.massDestroy');
  Route::delete('article/{article}', [ArticleController::class, 'destroy'])->name('admin.article.destroy');



  Route::get('getAllUsers', [UsersController::class, 'index'])->name('admin.users.index');
  Route::get('showuser/show/{users}', [UsersController::class, 'show'])->name('admin.users.show');
  Route::get('editusers/edit/{user}', [UsersController::class, 'edit'])->name('admin.users.edit');
  Route::put('usersupdate/{users}', [UsersController::class, 'update'])->name('admin.users.update');
  Route::get('create_users', [UsersController::class, 'create'])->name('admin.users.create');
  Route::post('userstore', [UsersController::class, 'store'])->name('admin.users.store');
  Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('admin.users.massDestroy');
  Route::delete('users/{users}', [UsersController::class, 'destroy'])->name('admin.users.destroy');

  Route::get('getAllCompany', [CompanyController::class, 'getAllCompany'])->name('admin.company.index');
  Route::get('showcompany/show/{company}', [CompanyController::class, 'show'])->name('admin.company.show');
  Route::get('editcompany/edit/{company}', [CompanyController::class, 'edit'])->name('admin.company.edit');
  Route::put('companyupdate/{company}', [CompanyController::class, 'update'])->name('admin.company.update');
  Route::get('create_company', [CompanyController::class, 'create'])->name('admin.company.create');
  Route::post('companystore', [CompanyController::class, 'store'])->name('admin.company.store');
  Route::delete('company/destroy', [CompanyController::class, 'massDestroy'])->name('admin.company.massDestroy');
  Route::delete('company/{company}', [CompanyController::class, 'destroy'])->name('admin.company.destroy');



  Route::get('getAllRoles', [RoleController::class, 'index'])->name('admin.roles.index');
  Route::get('showrole/show/{role}', [RoleController::class, 'show'])->name('admin.roles.show');
  Route::get('editroles/edit/{role}', [RoleController::class, 'edit'])->name('admin.roles.edit');
  Route::put('rolesupdate/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
  Route::get('createss_roles', [RoleController::class, 'createrole'])->name('admin.roles.create');
  Route::post('rolestore', [RoleController::class, 'store'])->name('admin.roles.store');
  Route::delete('roles/destroy', [RoleController::class, 'massDestroy'])->name('admin.roles.massDestroy');
  Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');

  Route::get('getAllPermissions', [PermissionsController::class, 'index'])->name('admin.permissions.index');
  Route::get('showpermission/show/{permission}', [PermissionsController::class, 'show'])->name('admin.permissions.show');
  Route::get('editpermissions/edit/{permission}', [PermissionsController::class, 'edit'])->name('admin.permissions.edit');
  Route::put('permissionsupdate/{permission}', [PermissionsController::class, 'update'])->name('admin.permissions.update');
  Route::get('create_permissions', [PermissionsController::class, 'create'])->name('admin.permissions.create');
  Route::post('permissionstore', [PermissionsController::class, 'store'])->name('admin.permissions.store');
  Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('admin.permissions.massDestroy');
  Route::delete('permissions/{permission}', [PermissionsController::class, 'destroy'])->name('admin.permissions.destroy');


  Route::get('sektorekraf/{sektorekraf}/edit', [SektorEkrafController::class, 'edit'])->name('admin.sektorekraf.edit');
  Route::post('sektorekraf', [SektorEkrafController::class, 'store'])->name('admin.sektorekraf.store');
  Route::put('sektorekraf/{id}', [SektorEkrafController::class, 'update'])->name('admin.sektorekraf.update');
  Route::delete('sektorekraf/{id}', [SektorEkrafController::class, 'destroy'])->name('admin.sektorekraf.destroy');

  Route::get('get_allWisata', [WisataController::class, 'getAllWisatas'])->name('admin.wisata.index');
  Route::get('create_wisata', [WisataController::class, 'createWisata'])->name('admin.wisata.create');
  Route::post('storeWisata', [WisataController::class, 'storeWisata'])->name('admin.wisata.storeWisata');
  Route::get('showwisata/show/{wisata}', [WisataController::class, 'showwisata'])->name('admin.wisata.show');
  Route::get('editwisata/edit/{wisata}', [WisataController::class, 'editwisata'])->name('admin.wisata.edit');
  Route::put('wisataupdate/{wisata}', [WisataController::class, 'wisataupdate'])->name('admin.wisata.update');
  Route::post('wisata/media', [WisataController::class, 'storeMedia'])->name('admin.wisata.storeMedia');
  Route::delete('wisata/destroy', [WisataController::class, 'massDestroy'])->name('admin.wisata.massDestroy');
  Route::delete('wisata/{wisata}', [WisataController::class, 'destroy'])->name('admin.wisata.destroy');
  Route::get('showdeatilwisata/show/{id}', [WisataController::class, 'showdetailwisata'])->name('admin.detailwisata');
  Route::get('wisata/{id}/rekomendasiwisata', [WisataController::class, 'rekomendasiwisata']);



  Route::get('get_allEkraf', [EkrafController::class, 'getAllEkrafs'])->name('admin.ekraf.index');
  Route::get('create_ekraf', [EkrafController::class, 'createEkraf'])->name('admin.ekraf.create');
  Route::post('storeEkraf', [EkrafController::class, 'storeEkraf'])->name('admin.ekraf.storeEkraf');
  Route::get('showekraf/show/{ekraf}', [EkrafController::class, 'showekraf'])->name('admin.ekraf.show');
  Route::get('editekraf/edit/{ekraf}', [EkrafController::class, 'editekraf'])->name('admin.ekraf.edit');
  Route::put('ekrafupdate/{ekraf}', [EkrafController::class, 'ekrafupdate'])->name('admin.ekraf.update');
  Route::post('ekraf/media', [EkrafController::class, 'storeMedia'])->name('admin.ekraf.storeMedia');
  Route::delete('ekraf/destroy', [EkrafController::class, 'massDestroy'])->name('admin.ekraf.massDestroy');
  Route::delete('ekraf/{ekraf}', [EkrafController::class, 'destroy'])->name('admin.ekraf.destroy');
  Route::get('ekraf/{ekraf}', [AdminController::class, 'show'])->name('ekraf');




  Route::get('get_allKuliner', [KulinerController::class, 'getAllKuliners'])->name('admin.kuliner.index');
  Route::get('create_kuliner', [KulinerController::class, 'createKuliner'])->name('admin.kuliner.create');
  Route::post('storeKuliner', [KulinerController::class, 'storeKuliner'])->name('admin.kuliner.storeKuliner');
  Route::get('showkuliner/show/{kuliner}', [KulinerController::class, 'showkuliner'])->name('admin.kuliner.show');
  Route::get('editkuliner/edit/{kuliner}', [KulinerController::class, 'editkuliner'])->name('admin.kuliner.edit');
  Route::put('kulinerupdate/{kuliner}', [KulinerController::class, 'kulinerupdate'])->name('admin.kuliner.update');
  Route::post('kuliner/media', [KulinerController::class, 'storeMedia'])->name('admin.kuliner.storeMedia');
  Route::delete('kuliner/destroy', [KulinerController::class, 'massDestroy'])->name('admin.kuliner.massDestroy');
  Route::delete('kuliner/{kuliner}', [KulinerController::class, 'destroy'])->name('admin.kuliner.destroy');
  Route::get('showdeatilkuliner/show/{id}', [KulinerController::class, 'showdetailkuliner'])->name('admin.detailkuliner');
  Route::get('kuliner/{id}/rekomendasikuliner', [KulinerController::class, 'rekomendasikuliner']);


  Route::get('get_allEvencalender', [EvencalenderController::class, 'getAllEvencalenders'])->name('admin.evencalender.index');
  Route::get('create_evencalender', [EvencalenderController::class, 'createEvencalender'])->name('admin.evencalender.create');
  Route::post('storeEvencalender', [EvencalenderController::class, 'storeEvencalender'])->name('admin.evencalender.storeEvencalender');
  Route::get('showevencalender/show/{evencalender}', [EvencalenderController::class, 'showevencalender'])->name('admin.evencalender.show');
  Route::get('editevencalender/edit/{evencalender}', [EvencalenderController::class, 'editevencalender'])->name('admin.evencalender.edit');
  Route::put('evencalenderupdate/{evencalender}', [EvencalenderController::class, 'evencalenderupdate'])->name('admin.evencalender.update');
  Route::post('evencalender/media', [EvencalenderController::class, 'storeMedia'])->name('admin.evencalender.storeMedia');
  Route::delete('evencalender/destroy', [EvencalenderController::class, 'massDestroy'])->name('admin.evencalender.massDestroy');
  Route::delete('evencalender/{evencalender}', [EvencalenderController::class, 'destroy'])->name('admin.evencalender.destroy');

  Route::get('get_allcategorywisata', [CategoryWisataController::class, 'getAllcategorywisatas'])->name('admin.categorywisata.index');
  Route::get('create_categorywisata', [CategoryWisataController::class, 'createcategorywisata'])->name('admin.categorywisata.create');
  Route::post('storecategorywisata', [CategoryWisataController::class, 'storecategorywisata'])->name('admin.categorywisata.storecategorywisata');
  Route::get('showcategorywisata/show/{categorywisata}', [CategoryWisataController::class, 'showcategorywisata'])->name('admin.categorywisata.show');
  Route::get('editcategorywisata/edit/{categorywisata}', [CategoryWisataController::class, 'editcategorywisata'])->name('admin.categorywisata.edit');
  Route::put('categorywisataupdate/{categorywisata}', [CategoryWisataController::class, 'categorywisataupdate'])->name('admin.categorywisata.update');
  Route::post('categorywisata/media', [CategoryWisataController::class, 'storeMedia'])->name('admin.categorywisata.storeMedia');
  Route::delete('categorywisata/destroy', [CategoryWisataController::class, 'massDestroy'])->name('admin.categorywisata.massDestroy');
  Route::delete('categorywisata/{categorywisata}', [CategoryWisataController::class, 'destroy'])->name('admin.categorywisata.destroy');


  Route::get('get_allcategorykuliner', [CategoryKulinerController::class, 'getAllcategorykuliners'])->name('admin.categorykuliner.index');
  Route::get('create_categorykuliner', [CategoryKulinerController::class, 'createcategorykuliner'])->name('admin.categorykuliner.create');
  Route::post('storecategorykuliner', [CategoryKulinerController::class, 'storecategorykuliner'])->name('admin.categorykuliner.storecategorykuliner');
  Route::get('showcategorykuliner/show/{categorykuliner}', [CategoryKulinerController::class, 'showcategorykuliner'])->name('admin.categorykuliner.show');
  Route::get('editcategorykuliner/edit/{categorykuliner}', [CategoryKulinerController::class, 'editcategorykuliner'])->name('admin.categorykuliner.edit');
  Route::put('categorykulinerupdate/{categorykuliner}', [CategoryKulinerController::class, 'categorykulinerupdate'])->name('admin.categorykuliner.update');
  Route::post('categorykuliner/media', [CategoryKulinerController::class, 'storeMedia'])->name('admin.categorykuliner.storeMedia');
  Route::delete('categorykuliner/destroy', [CategoryKulinerController::class, 'massDestroy'])->name('admin.categorykuliner.massDestroy');
  Route::delete('categorykuliner/{categorykuliner}', [CategoryKulinerController::class, 'destroy'])->name('admin.categorykuliner.destroy');


  Route::get('get_allfasilitas', [FasilitasController::class, 'getAllfasilitas'])->name('admin.fasilitas.index');
  Route::get('create_fasilitas', [FasilitasController::class, 'createfasilitas'])->name('admin.fasilitas.create');
  Route::post('storefasilitas', [FasilitasController::class, 'storefasilitas'])->name('admin.fasilitas.storefasilitas');
  Route::get('showfasilitas/show/{fasilitas}', [FasilitasController::class, 'showfasilitas'])->name('admin.fasilitas.show');
  Route::get('editfasilitas/edit/{fasilitas}', [FasilitasController::class, 'editfasilitas'])->name('admin.fasilitas.edit');
  Route::put('fasilitasupdate/{fasilitas}', [FasilitasController::class, 'fasilitasupdate'])->name('admin.fasilitas.update');
  Route::post('fasilitas/media', [FasilitasController::class, 'storeMedia'])->name('admin.fasilitas.storeMedia');
  Route::delete('fasilitas/destroy', [FasilitasController::class, 'massDestroy'])->name('admin.fasilitas.massDestroy');
  Route::delete('fasilitas/{fasilitas}', [FasilitasController::class, 'destroy'])->name('admin.fasilitas.destroy');

  Route::get('get_allcategoryakomodasi', [CategoryAkomodasiController::class, 'getAllcategoryakomodasi'])->name('admin.categoryakomodasi.index');
  Route::get('create_categoryakomodasi', [CategoryAkomodasiController::class, 'createcategoryakomodasi'])->name('admin.categoryakomodasi.create');
  Route::post('storecategoryakomodasi', [CategoryAkomodasiController::class, 'storecategoryakomodasi'])->name('admin.categoryakomodasi.storecategoryakomodasi');
  Route::get('showcategoryakomodasi/show/{categoryakomodasi}', [CategoryAkomodasiController::class, 'showcategoryakomodasi'])->name('admin.categoryakomodasi.show');
  Route::get('editcategoryakomodasi/edit/{categoryakomodasi}', [CategoryAkomodasiController::class, 'editcategoryakomodasi'])->name('admin.categoryakomodasi.edit');
  Route::put('categoryakomodasiupdate/{categoryakomodasi}', [CategoryAkomodasiController::class, 'categoryakomodasiupdate'])->name('admin.categoryakomodasi.update');
  Route::post('categoryakomodasi/media', [CategoryAkomodasiController::class, 'storeMedia'])->name('admin.categoryakomodasi.storeMedia');
  Route::delete('categoryakomodasi/destroy', [CategoryAkomodasiController::class, 'massDestroy'])->name('admin.categoryakomodasi.massDestroy');
  Route::delete('categoryakomodasi/{categoryakomodasi}', [CategoryAkomodasiController::class, 'destroy'])->name('admin.categoryakomodasi.destroy');


  Route::get('get_allcategoryroom', [CategoryRoomsController::class, 'getAllcategoryroom'])->name('admin.categoryroom.index');
  Route::get('create_categoryroom', [CategoryRoomsController::class, 'createcategoryroom'])->name('admin.categoryroom.create');
  Route::post('storecategoryroom', [CategoryRoomsController::class, 'storecategoryroom'])->name('admin.categoryroom.storecategoryroom');
  Route::get('showcategoryroom/show/{categoryroom}', [CategoryRoomsController::class, 'showcategoryroom'])->name('admin.categoryroom.show');
  Route::get('editcategoryroom/edit/{categoryroom}', [CategoryRoomsController::class, 'editcategoryroom'])->name('admin.categoryroom.edit');
  Route::put('categoryroomupdate/{categoryroom}', [CategoryRoomsController::class, 'categoryroomupdate'])->name('admin.categoryroom.update');
  Route::post('categoryroom/media', [CategoryRoomsController::class, 'storeMedia'])->name('admin.categoryroom.storeMedia');
  Route::delete('categoryroom/destroy', [CategoryRoomsController::class, 'massDestroy'])->name('admin.categoryroom.massDestroy');
  Route::delete('categoryroom/{categoryroom}', [CategoryRoomsController::class, 'destroy'])->name('admin.categoryroom.destroy');

  Route::get('get_allAkomodasi', [AkomodasiController::class, 'getAllAkomodasi'])->name('admin.akomodasi.index');
  Route::get('create_akomodasi', [AkomodasiController::class, 'createAkomodasi'])->name('admin.akomodasi.create');
  Route::post('storeAkomodasi', [AkomodasiController::class, 'storeAkomodasi'])->name('admin.akomodasi.storeAkomodasi');
  Route::get('showakomodasi/show/{akomodasi}', [AkomodasiController::class, 'showakomodasi'])->name('admin.akomodasi.show');
  Route::get('editakomodasi/edit/{akomodasi}', [AkomodasiController::class, 'editakomodasi'])->name('admin.akomodasi.edit');
  Route::put('akomodasiupdate/{akomodasi}', [AkomodasiController::class, 'akomodasiupdate'])->name('admin.akomodasi.update');
  Route::post('akomodasi/media', [AkomodasiController::class, 'storeMedia'])->name('admin.akomodasi.storeMedia');
  Route::delete('akomodasi/destroy', [AkomodasiController::class, 'massDestroy'])->name('admin.akomodasi.massDestroy');
  Route::delete('akomodasi/{akomodasi}', [AkomodasiController::class, 'destroy'])->name('admin.akomodasi.destroy');
  Route::get('showdeatilakomodasi/show/{id}', [AkomodasiController::class, 'showdetailakomodasi'])->name('admin.detailakomodasi');
  Route::get('akomodasi/{id}/rekomendasiakomodasi', [AkomodasiController::class, 'rekomendasiakomodasi']);

  Route::get('get_allRoom', [RoomsController::class, 'getAllRoom'])->name('admin.room.index');
  Route::get('create_room', [RoomsController::class, 'createRoom'])->name('admin.room.create');
  Route::post('storeRoom', [RoomsController::class, 'storeRoom'])->name('admin.room.storeRoom');
  Route::get('showroom/show/{room}', [RoomsController::class, 'showroom'])->name('admin.room.show');
  Route::get('editroom/edit/{room}', [RoomsController::class, 'editroom'])->name('admin.room.edit');
  Route::put('roomupdate/{room}', [RoomsController::class, 'roomupdate'])->name('admin.room.update');
  Route::post('room/media', [RoomsController::class, 'storeMedia'])->name('admin.room.storeMedia');
  Route::delete('room/destroy', [RoomsController::class, 'massDestroy'])->name('admin.room.massDestroy');
  Route::delete('room/{room}', [RoomsController::class, 'destroy'])->name('admin.room.destroy');
  Route::get('showdeatilroom/show/{id}', [RoomsController::class, 'showdetailroom'])->name('admin.detailroom');


  Route::get('get_allKulinerproduk', [KulinerProdukController::class, 'getAllKulinerproduk'])->name('admin.kulinerproduk.index');
  Route::get('create_kulinerproduk', [KulinerProdukController::class, 'createKulinerproduk'])->name('admin.kulinerproduk.create');
  Route::post('storeKulinerproduk', [KulinerProdukController::class, 'storeKulinerproduk'])->name('admin.kulinerproduk.storeKulinerproduk');
  Route::get('showkulinerproduk/show/{kulinerproduk}', [KulinerProdukController::class, 'showkulinerproduk'])->name('admin.kulinerproduk.show');
  Route::get('editkulinerproduk/edit/{kulinerproduk}', [KulinerProdukController::class, 'editkulinerproduk'])->name('admin.kulinerproduk.edit');
  Route::put('kulinerprodukupdate/{kulinerproduk}', [KulinerProdukController::class, 'kulinerprodukupdate'])->name('admin.kulinerproduk.update');
  Route::post('kulinerproduk/media', [KulinerProdukController::class, 'storeMedia'])->name('admin.kulinerproduk.storeMedia');
  Route::delete('kulinerproduk/destroy', [KulinerProdukController::class, 'massDestroy'])->name('admin.kulinerproduk.massDestroy');
  Route::delete('kulinerproduk/{kulinerproduk}', [KulinerProdukController::class, 'destroy'])->name('admin.kulinerproduk.destroy');
  Route::get('showdeatilkulinerproduk/show/{id}', [KulinerProdukController::class, 'showdetailkulinerproduk'])->name('admin.detailkulinerproduk');




  Route::get('get_allPaketWisata', [PaketWisataController::class, 'getAllPaketWisata'])->name('admin.paketwisata.index');
  Route::get('create_paketwisata', [PaketWisataController::class, 'createPaketWisata'])->name('admin.paketwisata.create');
  Route::post('storePaketWisata', [PaketWisataController::class, 'storePaketWisata'])->name('admin.paketwisata.storePaketWisata');
  Route::get('showpaketwisata/show/{paketwisata}', [PaketWisataController::class, 'showpaketwisata'])->name('admin.paketwisata.show');
  Route::get('editpaketwisata/edit/{paketwisata}', [PaketWisataController::class, 'editpaketwisata'])->name('admin.paketwisata.edit');
  Route::put('paketwisataupdate/{paketwisata}', [PaketWisataController::class, 'paketwisataupdate'])->name('admin.paketwisata.update');
  Route::post('paketwisata/media', [PaketWisataController::class, 'storeMedia'])->name('admin.paketwisata.storeMedia');
  Route::delete('paketwisata/destroy', [PaketWisataController::class, 'massDestroy'])->name('admin.paketwisata.massDestroy');
  Route::delete('paketwisata/{paketwisata}', [PaketWisataController::class, 'destroy'])->name('admin.paketwisata.destroy');


  Route::group(['controller' => DataWisatawanController::class, 'prefix' => 'wisatawans', 'as' => 'admin.wisatawans.'], function () {
    Route::get('index', 'index')->name('index');
    Route::get('show/{wisatawanId}', 'show')->name('show');
    Route::get('edit/{wisatawanId}', 'edit')->name('edit');
    Route::delete('destroy/{wisatawanId}', 'destroy')->name('destroy');
    Route::put('update/{wisatawanId}', 'update')->name('update');
});

});


Route::middleware(['auth', 'wisata'])->prefix('wisata')->group(function () {
  // tambahkan rute lain untuk admin di sini0
// --- data kunjungan wisata ------
Route::get('indexkunjunganwisata', [KunjunganWisataController::class, 'indexkunjunganwisata'])->name('account.wisata.datakunjunganwisata.index');
Route::get('dashboard', [KunjunganWisataController::class, 'dashboard'])->name('account.wisata.datakunjunganwisata.dashboard');
Route::get('wisata/perbulan', [KunjunganWisataController::class, 'filterbulan'])->name('account.wisata.kunjunganwisata.filterbulan');
Route::get('wisata/wisnuperbulan', [KunjunganWisataController::class, 'filterwisnubulan'])->name('account.wisata.kunjunganwisata.filterwisnubulan');
Route::get('wisata/wismanperbulan', [KunjunganWisataController::class, 'filterwismanbulan'])->name('account.wisata.kunjunganwisata.filterwismanbulan');
Route::get('wisata/pertahun', [KunjunganWisataController::class, 'filtertahun'])->name('account.wisata.kunjunganwisata.filtertahun');
Route::get('wisata/byinput', [KunjunganWisataController::class, 'filterbyinput'])->name('account.wisata.kunjunganwisata.filterbyinput');
Route::get('/wisata/kunjungan', [KunjunganWisataController::class, 'indexkunjunganwisata'])->name('account.wisata.kunjunganwisata.index');
Route::get('/wisata/create', [KunjunganWisataController::class, 'createwisnu'])->name('account.wisata.kunjunganwisata.createwisnu');
Route::get('/wisata/confirm/{wisata_id}/{tanggal_kunjungan}',  [KunjunganWisataController::class, 'confirm'])->name('account.wisata.kunjunganwisata.confirm');
Route::post('/wisata/storekunjunganwisata', [KunjunganWisataController::class, 'storewisnu'])->name('account.wisata.kunjunganwisata.storewisnu');
Route::get('wisata/kunjungan/{wisata_id}/{tanggal_kunjungan}/edit', [KunjunganWisataController::class, 'editwisnu'])->name('account.wisata.kunjunganwisata.edit');
Route::put('/wisata/update/{tanggal_kunjungan}', [KunjunganWisataController::class, 'updatewisnu'])->name('account.wisata.kunjunganwisata.update');
Route::delete('/kunjunganwisata/{wisata_id}/{tanggal_kunjungan}', [KunjunganWisataController::class, 'deletewisnu'])->name('account.wisata.kunjunganwisata.delete');



  Route::get('get_allkelompokkunjungan', [KelompokKunjunganController::class, 'getAllkelompokKunjungan'])->name('account.wisata.kelompokkunjungan.index');
  Route::get('create_kelompokkunjungan', [KelompokKunjunganController::class, 'createkelompokKunjungan'])->name('account.wisata.kelompokkunjungan.create');
  Route::post('storekelompokkunjungan', [KelompokKunjunganController::class, 'storekelompokKunjungan'])->name('account.wisata.kelompokkunjungan.storekelompokkunjungan');
  Route::get('showkelompokkunjungan/show/{kelompokkunjungan}', [KelompokKunjunganController::class, 'showkelompokkunjungan'])->name('account.wisata.kelompokkunjungan.show');
  Route::get('editkelompokKunjungan/edit/{kelompokkunjungan}', [KelompokKunjunganController::class, 'editkelompokKunjungan'])->name('account.wisata.kelompokkunjungan.edit');
  Route::put('kelompokKunjunganupdate/{kelompokkunjungan}', [KelompokKunjunganController::class, 'kelompokKunjunganupdate'])->name('account.wisata.kelompokkunjungan.update');
  Route::delete('kelompokkunjungan/destroy', [KelompokKunjunganController::class, 'massDestroy'])->name('account.wisata.kelompokkunjungan.massDestroy');
  Route::delete('kelompokkunjungan/{kelompokkunjungan}', [KelompokKunjunganController::class, 'destroykelompokkunjungan'])->name('account.wisata.kelompokkunjungan.destroy');



  Route::get('get_allwismannegara', [WismanNegaraController::class, 'getAllwismannegara'])->name('account.wisata.wismannegara.index');
  Route::get('create_wismannegara', [WismanNegaraController::class, 'createwismannegara'])->name('account.wisata.wismannegara.create');
  Route::post('storewismannegara', [WismanNegaraController::class, 'storewismannegara'])->name('account.wisata.wismannegara.storewismannegara');
  Route::get('showwismannegara/show/{wismannegara}', [WismanNegaraController::class, 'showwismannegara'])->name('account.wisata.wismannegara.show');
  Route::get('editwismannegara/edit/{wismannegara}', [WismanNegaraController::class, 'editwismannegara'])->name('account.wisata.wismannegara.edit');
  Route::put('wismannegaraupdate/{wismannegara}', [WismanNegaraController::class, 'wismannegaraupdate'])->name('account.wisata.wismannegara.update');
  Route::post('wismannegara/media', [WismanNegaraController::class, 'storeMedia'])->name('account.wisata.wismannegara.storeMedia');
  Route::delete('wismannegara/destroy', [WismanNegaraController::class, 'massDestroy'])->name('account.wisata.wismannegara.massDestroy');
  Route::delete('wismannegara/{wismannegara}', [WismanNegaraController::class, 'destroywismannegara'])->name('account.wisata.wismannegara.destroy');



// --- data kunjungan wisata ------

  Route::get('getwisatawan', [WisataAuthorController::class, 'getwisatawan'])->name('account.wisata.getwisatawan');;
  Route::get('logout', [WisataAuthorController::class, 'logout'])->name('account.wisata.logout');
  Route::get('/dashboard', [WisataAuthorController::class, 'index'])->name('account.wisata.user-wisata');
  Route::get('/wisataguide', [WisataAuthorController::class, 'wisataguide'])->name('account.wisata.guide.index');
  Route::get('/wisatakuliner', [WisataAuthorController::class, 'wisatakuliner'])->name('account.wisata.user-wisatakuliner');
  Route::get('/wisataakomodasi', [WisataAuthorController::class, 'wisataakomodasi'])->name('account.wisata.user-wisataakomodasi');
  Route::get('ganti-password', [WisataAuthorController::class, 'changePasswordView'])->name('account.wisata.changePassword');
  Route::delete('delete', [WisataAuthorController::class, 'deleteAccount'])->name('account.wisata.delete');
  Route::put('ganti-password', [WisataAuthorController::class, 'changePassword'])->name('account.wisata.changePassword');

  Route::get('detailtiket/{id}', [WisataAuthorController::class, 'detailtiket'])->name('account.wisata.detailtiket');
  Route::get('/cek', [WisataAuthorController::class, 'cek'])->name('account.wisata.tiketwisata');
  Route::get('/tiket/{pesantiket:kodetiket}', [WisataAuthorController::class, 'show']);
  Route::post('/tiket/{pesantiket:kodetiket}', [WisataAuthorController::class, 'checkin_checkin']);
  Route::post('/tikettunai/{pesantiket:kodetiket}', [WisataAuthorController::class, 'checkin_tunai']);


  Route::get('detailkuliner/{id}', [WisataAuthorController::class, 'detailkuliner'])->name('account.wisata.detailpesanan');
  Route::get('/cekpesanan', [WisataAuthorController::class, 'cekpesanan'])->name('account.wisata.pesankuliner');
  Route::get('/pesanan/{pesankuliner:kodepesanan}', [WisataAuthorController::class, 'showpesanan']);
  Route::post('/pesanan/{pesankuliner:kodepesanan}', [WisataAuthorController::class, 'checkin_pesanan']);


  Route::get('reservation/{id}', [WisataAuthorController::class, 'reservation'])->name('account.wisata.reservation');
  Route::get('/cekreserv', [WisataAuthorController::class, 'cekreserv'])->name('account.wisata.reserv');
  Route::get('/reserv/{reserv:kodeboking}', [WisataAuthorController::class, 'showreserv']);
  Route::post('/reserv/{reserv:kodeboking}', [WisataAuthorController::class, 'checkin_reserv']);




  Route::get('company/create', [WisataAuthorController::class, 'create'])->name('account.wisata.company.create');
  Route::put('company/{id}', [WisataAuthorController::class, 'update'])->name('account.wisata.company.update');
  Route::post('company', [WisataAuthorController::class, 'store'])->name('account.wisata.company.store');
  Route::get('company/edit', [WisataAuthorController::class, 'edit'])->name('account.wisata.company.edit');
  Route::delete('company', [WisataAuthorController::class, 'destroy'])->name('account.wisata.company.destroy');


  Route::get('create_wisata', [WisataAuthorController::class, 'createWisata'])->name('account.wisata.wisata.create');
  Route::post('storeWisata', [WisataAuthorController::class, 'storeWisata'])->name('account.wisata.wisata.storeWisata');
  Route::get('showwisata/show/{wisata}', [WisataAuthorController::class, 'showwisata'])->name('account.wisata.wisata.show');
  Route::get('editwisata/edit', [WisataAuthorController::class, 'editwisata'])->name('account.wisata.wisata.edit');
  Route::put('wisataupdate/{id}', [WisataAuthorController::class, 'wisataupdate'])->name('account.wisata.wisata.update');
  Route::post('wisata/media', [WisataAuthorController::class, 'storeMedia'])->name('account.wisata.wisata.storeMedia');


  Route::get('get_allfasilitas', [WisataAuthorController::class, 'getAllfasilitas'])->name('account.wisata.fasilitas.index');
  Route::get('create_fasilitas', [WisataAuthorController::class, 'createfasilitas'])->name('account.wisata.fasilitas.create');
  Route::post('storefasilitas', [WisataAuthorController::class, 'storefasilitas'])->name('account.wisata.fasilitas.storefasilitas');
  Route::get('showfasilitas/show/{fasilitas}', [WisataAuthorController::class, 'showfasilitas'])->name('account.wisata.fasilitas.show');
  Route::get('editfasilitas/edit/{fasilitas}', [WisataAuthorController::class, 'editfasilitas'])->name('account.wisata.fasilitas.edit');
  Route::put('fasilitasupdate/{fasilitas}', [WisataAuthorController::class, 'fasilitasupdate'])->name('account.wisata.fasilitas.update');
  Route::post('fasilitas/media', [WisataAuthorController::class, 'storeMedia'])->name('account.wisata.fasilitas.storeMedia');
  Route::delete('fasilitas/destroy', [WisataAuthorController::class, 'massDestroy'])->name('account.wisata.fasilitas.massDestroy');
  Route::delete('fasilitas/{fasilitas}', [WisataAuthorController::class, 'destroyfasilitas'])->name('account.wisata.fasilitas.destroy');

  Route::get('create_kuliner', [WisataAuthorController::class, 'createKuliner'])->name('account.wisata.wisatakuliner.create');
  Route::post('storeKuliner', [WisataAuthorController::class, 'storeKuliner'])->name('account.wisata.wisatakuliner.storeKuliner');
  Route::get('showkuliner/show/{kuliner}', [WisataAuthorController::class, 'showkuliner'])->name('account.wisata.wisatakuliner.show');
  Route::get('editkuliner/edit', [WisataAuthorController::class, 'editkuliner'])->name('account.wisata.wisatakuliner.edit');
  Route::put('kulinerupdate/{id}', [WisataAuthorController::class, 'kulinerupdate'])->name('account.wisata.wisatakuliner.update');
  Route::post('kuliner/media', [WisataAuthorController::class, 'storeMedia'])->name('account.wisata.wisatakuliner.storeMedia');

  Route::get('getKulinerproduk', [WisataAuthorController::class, 'getKulinerproduk'])->name('account.wisata.kulinerproduk.index');
  Route::get('create_kulinerproduk', [WisataAuthorController::class, 'createKulinerproduk'])->name('account.wisata.kulinerproduk.create');
  Route::post('storeKulinerproduk', [WisataAuthorController::class, 'storeKulinerproduk'])->name('account.wisata.kulinerproduk.storeKulinerproduk');
  Route::get('showkulinerproduk/show/{kulinerproduk}', [WisataAuthorController::class, 'showkulinerproduk'])->name('account.wisata.kulinerproduk.show');
  Route::get('editkulinerproduk/edit/{kulinerproduk}', [WisataAuthorController::class, 'editkulinerproduk'])->name('account.wisata.kulinerproduk.edit');
  Route::put('kulinerprodukupdate/{kulinerproduk}', [WisataAuthorController::class, 'kulinerprodukupdate'])->name('account.wisata.kulinerproduk.update');
  Route::post('kulinerproduk/media', [WisataAuthorController::class, 'storeMedia'])->name('account.wisata.kulinerproduk.storeMedia');
  Route::delete('kulinerproduk/destroy', [WisataAuthorController::class, 'massDestroy'])->name('account.wisata.kulinerproduk.massDestroy');
  Route::delete('kulinerproduk/{kulinerproduk}', [WisataAuthorController::class, 'destroykulinerproduk'])->name('account.wisata.kulinerproduk.destroy');
  Route::get('showdeatilkulinerproduk/show/{id}', [WisataAuthorController::class, 'showdetailkulinerproduk'])->name('account.detailkulinerproduk');

  Route::get('create_akomodasi', [WisataAuthorController::class, 'createAkomodasi'])->name('account.wisata.akomodasi.create');
  Route::post('storeAkomodasi', [WisataAuthorController::class, 'storeAkomodasi'])->name('account.wisata.akomodasi.storeAkomodasi');
  Route::get('showakomodasi/show/{akomodasi}', [WisataAuthorController::class, 'showakomodasi'])->name('account.wisata.akomodasi.show');
  Route::get('editakomodasi/edit', [WisataAuthorController::class, 'editakomodasi'])->name('account.wisata.akomodasi.edit');
  Route::put('akomodasiupdate/{id}', [WisataAuthorController::class, 'akomodasiupdate'])->name('account.wisata.akomodasi.update');
  Route::post('akomodasi/media', [WisataAuthorController::class, 'storeMedia'])->name('account.wisata.akomodasi.storeMedia');

  
  Route::get('getRoom', [WisataAuthorController::class, 'getRoom'])->name('account.wisata.room.index');
  Route::get('create_room', [WisataAuthorController::class, 'createRoom'])->name('account.wisata.room.create');
  Route::post('storeRoom', [WisataAuthorController::class, 'storeRoom'])->name('account.wisata.room.storeRoom');
  Route::get('showroom/show/{room}', [WisataAuthorController::class, 'showroom'])->name('account.wisata.room.show');
  Route::get('editroom/edit/{room}', [WisataAuthorController::class, 'editroom'])->name('account.wisata.room.edit');
  Route::put('roomupdate/{room}', [WisataAuthorController::class, 'roomupdate'])->name('account.wisata.room.update');
  Route::post('room/media', [WisataAuthorController::class, 'storeMedia'])->name('account.wisata.room.storeMedia');
  Route::delete('room/destroy', [WisataAuthorController::class, 'massDestroy'])->name('account.wisata.room.massDestroy');
  Route::delete('room/{room}', [WisataAuthorController::class, 'destroyRoom'])->name('account.wisata.room.destroy');
  Route::get('showdeatilroom/show/{id}', [WisataAuthorController::class, 'showdetailroom'])->name('account.wisata.detailroom');


  Route::get('create_guide', [WisataAuthorController::class, 'createGuide'])->name('account.wisata.guide.create');
  Route::post('storeGuide', [WisataAuthorController::class, 'storeGuide'])->name('account.wisata.guide.storeGuide');
  Route::get('showguide/show/{guide}', [WisataAuthorController::class, 'showguide'])->name('account.wisata.guide.show');
  Route::get('editguide/edit', [WisataAuthorController::class, 'editguide'])->name('account.wisata.guide.edit');
  Route::put('guideupdate/{id}', [WisataAuthorController::class, 'guideupdate'])->name('account.wisata.guide.update');
  Route::post('guide/media', [WisataAuthorController::class, 'storeMedia'])->name('account.wisata.guide.storeMedia');
  Route::delete('guide/destroy', [WisataAuthorController::class, 'massDestroyGuide'])->name('account.wisata.guide.massDestroyGuide');
  Route::delete('wisataguide/{wisataguide}', [WisataAuthorController::class, 'destroyguide'])->name('account.wisata.guide.destroyguide');


  Route::get('get_allEven', [WisataAuthorController::class, 'getAllEven'])->name('account.wisata.even.index');
  Route::get('create_even', [WisataAuthorController::class, 'createEven'])->name('account.wisata.even.create');
  Route::post('storeEven', [WisataAuthorController::class, 'storeEven'])->name('account.wisata.even.storeEven');
  Route::get('showeven/show/{even}', [WisataAuthorController::class, 'showeven'])->name('account.wisata.even.show');
  Route::get('editeven/edit/{even}', [WisataAuthorController::class, 'editeven'])->name('account.wisata.even.edit');
  Route::put('evenupdate/{even}', [WisataAuthorController::class, 'evenupdate'])->name('account.wisata.even.update');
  Route::post('even/media', [WisataAuthorController::class, 'storeMedia'])->name('account.wisata.even.storeMedia');
  Route::delete('even/destroy', [WisataAuthorController::class, 'massDestroyeven'])->name('account.wisata.even.massDestroy');
  Route::delete('even/{even}', [WisataAuthorController::class, 'destroyeven'])->name('account.wisata.even.destroy');


  Route::get('getAllBanerPromo', [WisataAuthorController::class, 'GetBanerpromo'])->name('account.wisata.banerpromo.index');
  Route::get('showbanerpromo/show/{banerpromo}', [WisataAuthorController::class, 'showBanerpromo'])->name('account.wisata.banerpromo.show');
  Route::get('editbanerpromo/edit/{banerpromo}', [WisataAuthorController::class, 'editBanerpromo'])->name('account.wisata.banerpromo.edit');
  Route::put('banerpromoupdate/{banerpromo}', [WisataAuthorController::class, 'updateBanerpromo'])->name('account.wisata.banerpromo.update');
  Route::get('create_banerpromo', [WisataAuthorController::class, 'createBanerpromo'])->name('account.wisata.banerpromo.create');
  Route::post('banerpromotore', [WisataAuthorController::class, 'storeBanerpromo'])->name('account.wisata.banerpromo.store');
  Route::delete('banerpromo/{banerpromo}', [WisataAuthorController::class, 'destroyBanerpromo'])->name('account.wisata.banerpromo.destroy');
  Route::delete('banerpromo/destroy', [WisataAuthorController::class, 'massDestroyBanerpromo'])->name('account.wisata.banerpromo.massDestroyBanerpromo');
});

Route::middleware(['auth', 'kuliner'])->prefix('kuliner')->group(function () {
  // tambahkan rute lain untuk admin di sini0
  Route::get('getwisatawan', [KulinerAuthorController::class, 'getwisatawan'])->name('account.kuliner.getwisatawan');;

  Route::get('logout', [KulinerAuthorController::class, 'logout'])->name('account.kuliner.logout');
  Route::get('/dashboard', [KulinerAuthorController::class, 'index'])->name('account.kuliner.user-kuliner');
  Route::get('ganti-password', [KulinerAuthorController::class, 'changePasswordView'])->name('account.kuliner.changePassword');
  Route::delete('delete', [KulinerAuthorController::class, 'deleteAccount'])->name('account.kuliner.delete');
  Route::put('ganti-password', [KulinerAuthorController::class, 'changePassword'])->name('account.kuliner.changePassword');

  Route::get('company/create', [KulinerAuthorController::class, 'create'])->name('account.kuliner.company.create');
  Route::put('company/{id}', [KulinerAuthorController::class, 'update'])->name('account.kuliner.company.update');
  Route::post('company', [KulinerAuthorController::class, 'store'])->name('account.kuliner.company.store');
  Route::get('company/edit', [KulinerAuthorController::class, 'edit'])->name('account.kuliner.company.edit');
  Route::delete('company', [KulinerAuthorController::class, 'destroy'])->name('account.kuliner.company.destroy');

  Route::get('detailkuliner/{id}', [KulinerAuthorController::class, 'detailkuliner'])->name('account.kuliner.detailpesanan');
  Route::get('/cekpesanan', [KulinerAuthorController::class, 'cekpesanan'])->name('account.kuliner.pesankuliner');
  Route::get('/pesanan/{pesankuliner:kodepesanan}', [KulinerAuthorController::class, 'showpesanan']);
  Route::post('/pesanan/{pesankuliner:kodepesanan}', [KulinerAuthorController::class, 'checkin_pesanan']);

  Route::get('create_kuliner', [KulinerAuthorController::class, 'createKuliner'])->name('account.kuliner.kuliner.create');
  Route::post('storeKuliner', [KulinerAuthorController::class, 'storeKuliner'])->name('account.kuliner.kuliner.storeKuliner');
  Route::get('showkuliner/show/{kuliner}', [KulinerAuthorController::class, 'showkuliner'])->name('account.kuliner.kuliner.show');
  Route::get('editkuliner/edit', [KulinerAuthorController::class, 'editkuliner'])->name('account.kuliner.kuliner.edit');
  Route::put('kulinerupdate/{id}', [KulinerAuthorController::class, 'kulinerupdate'])->name('account.kuliner.kuliner.update');
  Route::post('kuliner/media', [KulinerAuthorController::class, 'storeMedia'])->name('account.kuliner.kuliner.storeMedia');

  Route::get('getKulinerproduk', [KulinerAuthorController::class, 'getKulinerproduk'])->name('account.kuliner.kulinerproduk.index');
  Route::get('create_kulinerproduk', [KulinerAuthorController::class, 'createKulinerproduk'])->name('account.kuliner.kulinerproduk.create');
  Route::post('storeKulinerproduk', [KulinerAuthorController::class, 'storeKulinerproduk'])->name('account.kuliner.kulinerproduk.storeKulinerproduk');
  Route::get('showkulinerproduk/show/{kulinerproduk}', [KulinerAuthorController::class, 'showkulinerproduk'])->name('account.kuliner.kulinerproduk.show');
  Route::get('editkulinerproduk/edit/{kulinerproduk}', [KulinerAuthorController::class, 'editkulinerproduk'])->name('account.kuliner.kulinerproduk.edit');
  Route::put('kulinerprodukupdate/{kulinerproduk}', [KulinerAuthorController::class, 'kulinerprodukupdate'])->name('account.kuliner.kulinerproduk.update');
  Route::post('kulinerproduk/media', [KulinerAuthorController::class, 'storeMedia'])->name('account.kuliner.kulinerproduk.storeMedia');
  Route::delete('kulinerproduk/destroy', [KulinerAuthorController::class, 'massDestroy'])->name('account.kuliner.kulinerproduk.massDestroy');
  Route::delete('kulinerproduk/{kulinerproduk}', [KulinerAuthorController::class, 'destroy'])->name('account.kuliner.kulinerproduk.destroy');
  Route::get('showdeatilkulinerproduk/show/{id}', [KulinerAuthorController::class, 'showdetailkulinerproduk'])->name('account.detailkulinerproduk');

  Route::get('get_allEven', [KulinerAuthorController::class, 'getAllEven'])->name('account.kuliner.even.index');
  Route::get('create_even', [KulinerAuthorController::class, 'createEven'])->name('account.kuliner.even.create');
  Route::post('storeEven', [KulinerAuthorController::class, 'storeEven'])->name('account.kuliner.even.storeEven');
  Route::get('showeven/show/{even}', [KulinerAuthorController::class, 'showeven'])->name('account.kuliner.even.show');
  Route::get('editeven/edit/{even}', [KulinerAuthorController::class, 'editeven'])->name('account.kuliner.even.edit');
  Route::put('evenupdate/{even}', [KulinerAuthorController::class, 'evenupdate'])->name('account.kuliner.even.update');
  Route::post('even/media', [KulinerAuthorController::class, 'storeMedia'])->name('account.kuliner.even.storeMedia');
  Route::delete('even/destroy', [KulinerAuthorController::class, 'massDestroyeven'])->name('account.kuliner.even.massDestroy');
  Route::delete('even/{even}', [KulinerAuthorController::class, 'destroyEven'])->name('account.kuliner.even.destroy');


  Route::get('get_allfasilitas', [KulinerAuthorController::class, 'getAllfasilitas'])->name('account.kuliner.fasilitas.index');
  Route::get('create_fasilitas', [KulinerAuthorController::class, 'createfasilitas'])->name('account.kuliner.fasilitas.create');
  Route::post('storefasilitas', [KulinerAuthorController::class, 'storefasilitas'])->name('account.kuliner.fasilitas.storefasilitas');
  Route::get('showfasilitas/show/{fasilitas}', [KulinerAuthorController::class, 'showfasilitas'])->name('account.kuliner.fasilitas.show');
  Route::get('editfasilitas/edit/{fasilitas}', [KulinerAuthorController::class, 'editfasilitas'])->name('account.kuliner.fasilitas.edit');
  Route::put('fasilitasupdate/{fasilitas}', [KulinerAuthorController::class, 'fasilitasupdate'])->name('account.kuliner.fasilitas.update');
  Route::post('fasilitas/media', [KulinerAuthorController::class, 'storeMedia'])->name('account.kuliner.fasilitas.storeMedia');
  Route::delete('fasilitas/destroy', [KulinerAuthorController::class, 'massDestroy'])->name('account.kuliner.fasilitas.massDestroy');
  Route::delete('fasilitas/{fasilitas}', [KulinerAuthorController::class, 'destroyfasilitas'])->name('account.kuliner.fasilitas.destroy');

  Route::get('getAllBanerPromo', [KulinerAuthorController::class, 'GetBanerpromo'])->name('account.kuliner.banerpromo.index');
  Route::get('showbanerpromo/show/{banerpromo}', [KulinerAuthorController::class, 'showBanerpromo'])->name('account.kuliner.banerpromo.show');
  Route::get('editbanerpromo/edit/{banerpromo}', [KulinerAuthorController::class, 'editBanerpromo'])->name('account.kuliner.banerpromo.edit');
  Route::put('banerpromoupdate/{banerpromo}', [KulinerAuthorController::class, 'updateBanerpromo'])->name('account.kuliner.banerpromo.update');
  Route::get('create_banerpromo', [KulinerAuthorController::class, 'createBanerpromo'])->name('account.kuliner.banerpromo.create');
  Route::post('banerpromotore', [KulinerAuthorController::class, 'storeBanerpromo'])->name('account.kuliner.banerpromo.store');
  Route::delete('banerpromo/{banerpromo}', [KulinerAuthorController::class, 'destroyBanerpromo'])->name('account.kuliner.banerpromo.destroy');
  Route::delete('banerpromo/destroy', [KulinerAuthorController::class, 'massDestroyBanerpromo'])->name('account.kuliner.banerpromo.massDestroyBanerpromo');
});

Route::middleware(['auth', 'akomodasi'])->prefix('akomodasi')->group(function () {
  // tambahkan rute lain untuk admin di sini0
  Route::get('getwisatawan', [AkomodasiAuthorController::class, 'getwisatawan'])->name('account.akomodasi.getwisatawan');;

  Route::get('logout', [AkomodasiAuthorController::class, 'logout'])->name('account.akomodasi.logout');
  Route::get('/dashboard', [AkomodasiAuthorController::class, 'index'])->name('account.akomodasi.user-akomodasi');
  Route::get('ganti-password', [AkomodasiAuthorController::class, 'changePasswordView'])->name('account.akomodasi.changePassword');
  Route::delete('delete', [AkomodasiAuthorController::class, 'deleteAccount'])->name('account.akomodasi.delete');
  Route::put('ganti-password', [AkomodasiAuthorController::class, 'changePassword'])->name('account.akomodasi.changePassword');

  Route::get('company/create', [AkomodasiAuthorController::class, 'create'])->name('account.akomodasi.company.create');
  Route::put('company/{id}', [AkomodasiAuthorController::class, 'update'])->name('account.akomodasi.company.update');
  Route::post('company', [AkomodasiAuthorController::class, 'store'])->name('account.akomodasi.company.store');
  Route::get('company/edit', [AkomodasiAuthorController::class, 'edit'])->name('account.akomodasi.company.edit');
  Route::delete('company', [AkomodasiAuthorController::class, 'destroy'])->name('account.akomodasi.company.destroy');

  Route::get('create_akomodasi', [AkomodasiAuthorController::class, 'createAkomodasi'])->name('account.akomodasi.akomodasi.create');
  Route::post('storeAkomodasi', [AkomodasiAuthorController::class, 'storeAkomodasi'])->name('account.akomodasi.akomodasi.storeAkomodasi');
  Route::get('showakomodasi/show/{akomodasi}', [AkomodasiAuthorController::class, 'showakomodasi'])->name('account.akomodasi.akomodasi.show');
  Route::get('editakomodasi/edit', [AkomodasiAuthorController::class, 'editakomodasi'])->name('account.akomodasi.akomodasi.edit');
  Route::put('akomodasiupdate/{id}', [AkomodasiAuthorController::class, 'akomodasiupdate'])->name('account.akomodasi.akomodasi.update');
  Route::post('akomodasi/media', [AkomodasiAuthorController::class, 'storeMedia'])->name('account.akomodasi.akomodasi.storeMedia');


  Route::get('reservation/{id}', [AkomodasiAuthorController::class, 'reservation'])->name('account.akomodasi.reservation');
  Route::get('/cekreserv', [AkomodasiAuthorController::class, 'cekreserv'])->name('account.akomodasi.reserv');
  Route::get('/reserv/{reserv:kodeboking}', [AkomodasiAuthorController::class, 'showreserv']);
  Route::post('/reserv/{reserv:kodeboking}', [AkomodasiAuthorController::class, 'checkin_reserv']);
  
  Route::get('get_allEven', [AkomodasiAuthorController::class, 'getAllEven'])->name('account.akomodasi.even.index');
  Route::get('create_even', [AkomodasiAuthorController::class, 'createEven'])->name('account.akomodasi.even.create');
  Route::post('storeEven', [AkomodasiAuthorController::class, 'storeEven'])->name('account.akomodasi.even.storeEven');
  Route::get('showeven/show/{even}', [AkomodasiAuthorController::class, 'showeven'])->name('account.akomodasi.even.show');
  Route::get('editeven/edit/{even}', [AkomodasiAuthorController::class, 'editeven'])->name('account.akomodasi.even.edit');
  Route::put('evenupdate/{even}', [AkomodasiAuthorController::class, 'evenupdate'])->name('account.akomodasi.even.update');
  Route::post('even/media', [AkomodasiAuthorController::class, 'storeMedia'])->name('account.akomodasi.even.storeMedia');
  Route::delete('even/destroy', [AkomodasiAuthorController::class, 'massDestroyeven'])->name('account.akomodasi.even.massDestroy');
  Route::delete('even/{even}', [AkomodasiAuthorController::class, 'destroyEven'])->name('account.akomodasi.even.destroy');

  Route::get('get_allfasilitas', [AkomodasiAuthorController::class, 'getAllfasilitas'])->name('account.akomodasi.fasilitas.index');
  Route::get('create_fasilitas', [AkomodasiAuthorController::class, 'createfasilitas'])->name('account.akomodasi.fasilitas.create');
  Route::post('storefasilitas', [AkomodasiAuthorController::class, 'storefasilitas'])->name('account.akomodasi.fasilitas.storefasilitas');
  Route::get('showfasilitas/show/{fasilitas}', [AkomodasiAuthorController::class, 'showfasilitas'])->name('account.akomodasi.fasilitas.show');
  Route::get('editfasilitas/edit/{fasilitas}', [AkomodasiAuthorController::class, 'editfasilitas'])->name('account.akomodasi.fasilitas.edit');
  Route::put('fasilitasupdate/{fasilitas}', [AkomodasiAuthorController::class, 'fasilitasupdate'])->name('account.akomodasi.fasilitas.update');
  Route::post('fasilitas/media', [AkomodasiAuthorController::class, 'storeMedia'])->name('account.akomodasi.fasilitas.storeMedia');
  Route::delete('fasilitas/destroy', [AkomodasiAuthorController::class, 'massDestroy'])->name('account.akomodasi.fasilitas.massDestroy');
  Route::delete('fasilitas/{fasilitas}', [AkomodasiAuthorController::class, 'destroyfasilitas'])->name('account.akomodasi.fasilitas.destroy');


  Route::get('getRoom', [AkomodasiAuthorController::class, 'getRoom'])->name('account.akomodasi.room.index');
  Route::get('create_room', [AkomodasiAuthorController::class, 'createRoom'])->name('account.akomodasi.room.create');
  Route::post('storeRoom', [AkomodasiAuthorController::class, 'storeRoom'])->name('account.akomodasi.room.storeRoom');
  Route::get('showroom/show/{room}', [AkomodasiAuthorController::class, 'showroom'])->name('account.akomodasi.room.show');
  Route::get('editroom/edit/{room}', [AkomodasiAuthorController::class, 'editroom'])->name('account.akomodasi.room.edit');
  Route::put('roomupdate/{room}', [AkomodasiAuthorController::class, 'roomupdate'])->name('account.akomodasi.room.update');
  Route::post('room/media', [AkomodasiAuthorController::class, 'storeMedia'])->name('account.akomodasi.room.storeMedia');
  Route::delete('room/destroy', [AkomodasiAuthorController::class, 'massDestroy'])->name('account.akomodasi.room.massDestroy');
  Route::delete('room/{room}', [AkomodasiAuthorController::class, 'destroyRoom'])->name('account.akomodasi.room.destroy');
  Route::get('showdeatilroom/show/{id}', [AkomodasiAuthorController::class, 'showdetailroom'])->name('account.akomodasi.detailroom');


  

  Route::get('getAllBanerPromo', [AkomodasiAuthorController::class, 'GetBanerpromo'])->name('account.akomodasi.banerpromo.index');
  Route::get('showbanerpromo/show/{banerpromo}', [AkomodasiAuthorController::class, 'showBanerpromo'])->name('account.akomodasi.banerpromo.show');
  Route::get('editbanerpromo/edit/{banerpromo}', [AkomodasiAuthorController::class, 'editBanerpromo'])->name('account.akomodasi.banerpromo.edit');
  Route::put('banerpromoupdate/{banerpromo}', [AkomodasiAuthorController::class, 'updateBanerpromo'])->name('account.akomodasi.banerpromo.update');
  Route::get('create_banerpromo', [AkomodasiAuthorController::class, 'createBanerpromo'])->name('account.akomodasi.banerpromo.create');
  Route::post('banerpromotore', [AkomodasiAuthorController::class, 'storeBanerpromo'])->name('account.akomodasi.banerpromo.store');
  Route::delete('banerpromo/{banerpromo}', [AkomodasiAuthorController::class, 'destroyBanerpromo'])->name('account.akomodasi.banerpromo.destroy');
  Route::delete('banerpromo/destroy', [AkomodasiAuthorController::class, 'massDestroyBanerpromo'])->name('account.akomodasi.banerpromo.massDestroyBanerpromo');
});




// Route::get('wisatawan/login', function () {
//   dd('asd');
// });
// Route::post('/language-switch', 'LanguageController@switch')->name('language.switch');
Route::post('language-switch', [LanguageController::class, 'switch'])->name('language.switch');


Route::group(['controller' => WisatawanController::class, 'prefix' => 'wisatawan', 'as' => 'wisatawan.'], function () {
  Route::get('login', 'login')->name('login');
  Route::post('authenticate', 'authenticate')->name('auth-authenticate');
  Route::get('registration', 'registration')->name('registration');
  Route::get('forgotPassword', 'forgotPassword')->name('forgot-password');
  Route::get('resetPassword', 'resetPassword')->name('reset-password');
  Route::post('register', 'register')->name('register');
  Route::get('resetPasswordIndex', 'resetPasswordIndex')->name('reset-password-index');
  Route::post('createResetPassword', 'createResetPassword')->name('create-reset-password');


});


Route::group(['middleware' => 'wisatawan.auth'], function () {
  Route::get('/wisatawan', [DashboardController::class, 'index'])->name('wisatawan.home');;
  
  Route::group(['controller' => WisatawanController::class, 'prefix' => 'wisatawan', 'as' => 'wisatawan.'], function () {
    Route::get('logout', 'logout')->name('logout');
    Route::post('changePassword', 'changePassword')->name('change-password');
    Route::get('indexChangePassword', 'indexChangePassword')->name('index-change-password');

    Route::get('changeprofile', 'edit')->name('changeprofile');
    Route::put('update/{id}', 'update')->name('update');

  });

  Route::get('pesanantiket', [PesanantiketController::class, 'pesanantiketwisatawan'])->name('wisatawan.pesanan');
  Route::get('detailpesanan/{id}', [PesanantiketController::class, 'detailpesanan'])->name('wisatawan.detailpesanan');

  Route::get('pesanankuliner', [PesanankulinerController::class, 'pesanankulinerwisatawan'])->name('wisatawan.pesanankuliner');
  Route::get('detailpesanan/{id}', [PesanankulinerController::class, 'detailpesanan'])->name('wisatawan.detailpesanankuliner');

  Route::get('pesanantiket', [PesanantiketController::class, 'pesanantiketwisatawan'])->name('wisatawan.pesanan');
  Route::get('detailpesanan/{id}', [PesanantiketController::class, 'detailpesanan'])->name('wisatawan.detailpesanan');


 
});

Route::get('/change-locale', function (\Illuminate\Http\Request $request) {
  $request->validate([
      'locale' => 'required|in:en,id',
  ]);
  App::setLocale($request->locale);
  session()->put('locale', $request->locale);
  return back();
})->name('change_locale');

// Untuk redirect ke Google
Route::get('login/google/redirect', [SocialiteController::class, 'redirect'])
    ->name('redirect');

// Untuk callback dari Google
Route::get('login/google/callback', [SocialiteController::class, 'callback'])
    ->name('callback');


