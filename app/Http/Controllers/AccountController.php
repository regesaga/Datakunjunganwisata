<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use App\Models\Kuliner;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Hashids\Hashids;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AccountController extends Controller
{
        
    public function index()
    {   
        $hash = new Hashids(env('HASHIDS_SALT'), env('HASHIDS_MIN_LENGTH'));
        $wisatas = Wisata::all();   
        $kuliners = Kuliner::all();            
        $users = User::all();            
        $authors = User::role('author')->with('company')->paginate(30);
        $roles = Role::all()->pluck('name');
        $permissions = Permission::all()->pluck('name');
        $rolesHavePermissions = Role::with('permissions')->get();


        $mapWisatas = $wisatas->makeHidden(['created_at', 'updated_at', 'company_id', 'photos', 'media']);
        $latitude = $wisatas->count() && (request()->filled('namawisata') || request()->filled('search')) ? $wisatas->average('latitude') : -7.013805;
        $longitude = $wisatas->count() && (request()->filled('namawisata') || request()->filled('search')) ? $wisatas->average('longitude') : 108.570064;

        $mapKuliners = $kuliners->makeHidden(['created_at', 'updated_at', 'company_id', 'photos', 'media']);
        $latitudekuliner = $kuliners->count() && (request()->filled('namakuliner') || request()->filled('search')) ? $kuliners->average('latitude') : -7.013805;
        $longtitudekuliner = $kuliners->count() && (request()->filled('namakuliner') || request()->filled('search')) ? $kuliners->average('longitude') : 108.570064;


        return view('account.user-account', compact('hash','wisatas','kuliners','users', 'mapWisatas','mapKuliners', 'latitude', 'longitude','latitudekuliner', 'longtitudekuliner'));
    }

    public function show(Wisata $wisata)
    {

        return view('wisata', compact('wisata'));
    }

    public function showUser(User $user)
    {

        return view('user', compact('user'));
    }

    public function showkuliner(Kuliner $kuliner)
    {

        return view('kuliner', compact('kuliner'));
    }
    


    

    public function changePasswordView()
    {
        return view('account.change-password');
    }

    public function changePassword(Request $request)
    {
        if (!auth()->user()) {
            Alert::toast('Not authenticated!', 'success');
            return redirect()->back();
        }

        //check if the password is valid
        $request->validate([
            'current_password' => 'required|min:8',
            'new_password' => 'required|min:8'
        ]);

        $authUser = auth()->user();
        $currentP = $request->current_password;
        $newP = $request->new_password;
        $confirmP = $request->confirm_password;

        if (Hash::check($currentP, $authUser->password)) {
            if (Str::of($newP)->exactly($confirmP)) {
                $user = User::find($authUser->id);
                $user->password = Hash::make($newP);
                if ($user->save()) {
                    Alert::toast('Password Changed!', 'success');
                    return redirect()->route('account.index');
                } else {
                    Alert::toast('Something went wrong!', 'warning');
                }
            } else {
                Alert::toast('Passwords do not match!', 'info');
            }
        } else {
            Alert::toast('Incorrect Password!', 'info');
        }
        return redirect()->back();
    }

    public function deactivateView()
    {
        return view('account.deactivate');
    }

    public function deleteAccount()
    {
        $user = User::find(auth()->user()->id);
        Auth::logout($user->id);
        if ($user->delete()) {
            Alert::toast('Your account was deleted successfully!', 'info');
            return redirect(route('post.index'));
        } else {
            return view('account.deactivate');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

 
}
