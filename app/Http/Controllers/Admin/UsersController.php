<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Company;
use Hashids\Hashids;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
class UsersController extends Controller
{

//     public function exportPermissions()
// {
//     $permissions = Permission::all();

//     $exportData = $permissions->map(function ($permission) {
//         return [
//             'name' => $permission->name,
//             // Tambahkan field lain jika diperlukan
//         ];
//     });

//     $exportData = $exportData->toJson(JSON_PRETTY_PRINT);

//     file_put_contents('permissions.json', $exportData);

//     return "Izin berhasil diekspor ke permissions.json";
// }

    public function index()
    {

        $hash=new Hashids();
        $users = User::all();
        return view('admin.users.index', compact('users','hash'));
    }

    public function create()
    {

        $roles = Role::all()->pluck('name', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }


 

    public function edit($user)
    {
        $hash = new Hashids();
        $user = User::find($hash->decodeHex($user));
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('admin.users.edit', compact('user', 'hash',
    'roles','userRole'));
    }
    
    

    public function update(Request $request, $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }
    
        $hash = new Hashids();
        $user = User::find($hash->decodeHex($user));
        DB::table('role_user')->where('user_id', $user->id)->delete();
    
        $user->update($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }
    




    public function show($user)
{
    $hash = new Hashids();
    $roles = Role::all()->pluck('name', 'id');
    $userId = $hash->decodeHex($user);
    $user = User::find($userId);
    $company = Company::where('user_id', $userId)->first();
    return view('admin.users.show', compact('user', 'hash', 'roles', 'company'));
}


    public function destroy(Request $request,$user)
    {
        $hash=new Hashids();
        $user = User::find($hash->decodeHex($user));
        $user->delete();

        return back();
    }


    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return back();
    }
}
