<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\PassportServiceProvider;
use Laravel\Passport\Passport;
use Spatie\Permission\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //  'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerPolicies();    
        // Passport::routes();    
        // Passport::tokensExpireIn(now()->addDays(15));    
        // Passport::refreshTokensExpireIn(now()->addDays(30));

        // $this->registerPolicies();

    //     $controllers = [
    //         'App\Http\Controllers\Admin\UsersController',
    //         'App\Http\Controllers\Author\AkomodasiAuthorController',
    //         'App\Http\Controllers\Author\GuideAuthorController',
    //         'App\Http\Controllers\Author\WisataAuthorController',
    //         'App\Http\Controllers\Author\KulinerAuthorController',
    //         'App\Http\Controllers\Author\EkrafAuthorController',
    //         'App\Http\Controllers\Admin\AdminController',
    //         'App\Http\Controllers\Admin\TagController',
    //         'App\Http\Controllers\Admin\BanerController',
    //         'App\Http\Controllers\Admin\UsersController',
    //         'App\Http\Controllers\Admin\PermissionsController',
    //         'App\Http\Controllers\Admin\RoleController',
    //         'App\Http\Controllers\Admin\WisataController',
    //         'App\Http\Controllers\Admin\RoomsController',
    //         'App\Http\Controllers\Admin\PaketWisataController',
    //         'App\Http\Controllers\Admin\ArticleController',
    //         'App\Http\Controllers\Admin\FasilitasController',
    //         'App\Http\Controllers\Admin\EvencalenderController',
    //         'App\Http\Controllers\Admin\CategoryWisataController',
    //         'App\Http\Controllers\Admin\CompanyController',
    //         'App\Http\Controllers\Admin\KulinerController',
    //         'App\Http\Controllers\Admin\KulinerProdukController',
    //         'App\Http\Controllers\Admin\EkrafController',
    //         'App\Http\Controllers\Admin\AkomodasiController',
    //         'App\Http\Controllers\Admin\CategoryAkomodasiController',
    //         'App\Http\Controllers\Admin\CategoryRoomsController',
    //         'App\Http\Controllers\Admin\CategoryKulinerController',
    //         'App\Http\Controllers\Admin\SektorEkrafController',
    //         // Tambahkan controller lain yang ingin Anda tambahkan izinnya
    //     ];
        
    //     foreach ($controllers as $controller) {
    //         $reflection = new \ReflectionClass($controller);
    //         $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        
    //         foreach ($methods as $method) {
    //             $permissionName = $reflection->getShortName() . '@' . $method->getName();
    //             Permission::firstOrCreate(['name' => $permissionName]);
    //         }
    //     }
    // }
}
}
