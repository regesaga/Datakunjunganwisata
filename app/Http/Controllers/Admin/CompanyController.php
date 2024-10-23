<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\MassDestroyCompanyRequest;
use App\Models\Company;
use App\Models\User;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;
use RealRashid\SweetAlert\Facades\Alert;

class CompanyController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getAllCompany()
    {
        $hash=new Hashids();
        $company = Company::all();
        
        
        return view('admin.company.index', compact('company','hash'));
    }
    public function create()
    {
        $user = User::all();

        return view('admin.company.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $userId = $request->input('user_id');

    // Validasi input
    $validatedData = $request->validate([
        'user_id' => 'required',
        'nama' => 'required',
        'title' => 'required',
        'ijin' => 'required',
        'phone' => 'required|max:13', // Panjang karakter maksimum yang diizinkan adalah 13
    ]);

    // Cek apakah user ID sudah ada dalam database
    $existingUser = Company::where('user_id', $userId)->first();
    if ($existingUser) {
        // Jika user ID sudah ada, berikan pesan error atau lakukan tindakan lain sesuai kebutuhan Anda
        return redirect()->back()->withErrors('User ID Sudah Digunakan');
    }

    // Jika user ID belum ada dan data valid, lanjutkan untuk menyimpan data
    $company = Company::create($validatedData);
    return redirect()->route('admin.company.index');
}



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($company)
    {
        $hash=new Hashids();
        $user = User::all();
        $company = Company::find($hash->decodeHex($company));
        return view('admin.company.edit', compact( 'user','hash','company'))->with([
            'user' => $user,
            'company' => $company,
            'hash' => $hash
        ]);
    }

    public function update(Request $request, $company)
{
    $hash = new Hashids();
    $companyId = $hash->decodeHex($company);

    $validatedData = $request->validate([
        'user_id' => 'required',
        'nama' => 'required',
        'title' => 'required',
        'ijin' => 'required',
        'phone' => 'required|max:13', // Panjang karakter maksimum yang diizinkan adalah 13
    ]);


    

    // Perbarui data perusahaan jika ID ditemukan
    $companyData = Company::find($companyId);
    if ($companyData) {
        $companyData->update($request->all());
    }

    return redirect()->route('admin.company.index');
}

public function massDestroy(MassDestroyCompanyRequest $request)
    {
        Company::whereIn('id', request('ids'))->delete();

        return back();
    }

   
   

     public function destroy(Request $request,$company)
                {
                    $hash=new Hashids();
                    $company = Company::find($hash->decodeHex($company));
                    $company->delete();
                   
            
                    return back();
                }



}
