<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Traits\MediaUploadingTrait;
class CompanyController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->company) {
            Alert::toast('Anda Sudah Memiliki Perusahaan!', 'info');
            return $this->edit();
        }
        $categories = CompanyCategory::all();
        return view('company.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateCompany($request);

        $company = new Company();
        if ($this->companySave($company, $request)) {
            Alert::toast('Perusahaan dibuat! Sekarang Anda dapat menambahkan posting', 'success');
            return redirect()->route('account.authorSection');
        }
        Alert::toast('Failed!', 'error');
        return redirect()->route('account.authorSection');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $company = auth()->user()->company;
        $categories = CompanyCategory::all();
        return view('company.edit', compact('company', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $this->validateCompanyUpdate($request);

        $company = auth()->user()->company;
        if ($this->companyUpdate($company, $request)) {
            Alert::toast('Company created!', 'success');
            return redirect()->route('account.authorSection');
        }
        Alert::toast('Failed!', 'error');
        return redirect()->route('account.authorSection');
    }

    protected function validateCompany(Request $request)
    {
        return $request->validate([
            'title' => 'required|min:5',
            'description' => 'required|min:5',
            'logo' => 'required|image|max:2999',
            'category' => 'required',
            'phone' => 'required',
        ]);
    }
    protected function validateCompanyUpdate(Request $request)
    {
        return $request->validate([
            'title' => 'required|min:5',
            'description' => 'required|min:5',
            'category' => 'required',
            'phone' => 'required',
        ]);
    }
    protected function companySave(Company $company, Request $request)
    {
        $company->user_id = auth()->user()->id;
        $company->title = $request->title;
        $company->slug = SlugService::createSlug(Company::class, 'slug', $company->title);
        $company->description = $request->description;
        $company->company_category_id = $request->category;
        $company->alamat = $request->alamat;
        $company->phone = $request->phone;

        //logo
        $fileNameToStore = $this->getFileName($request->file('logo'));
        $logoPath = $request->file('logo')->storeAs('public/companies/logos', $fileNameToStore);
        if ($company->logo) {
            Storage::delete('public/companies/logos/' . basename($company->logo));
        }
        $company->logo = 'storage/companies/logos/' . $fileNameToStore;

   

        if ($company->save()) {
            return true;
        }
        return false;
    }


    protected function companyUpdate(Company $company, Request $request)
    {
        $company->user_id = auth()->user()->id;
        $company->title = $request->title;
        $company->slug = SlugService::createSlug(Company::class, 'slug', $company->title);
        $company->description = $request->description;
        $company->company_category_id = $request->category;
        $company->alamat = $request->alamat;
        $company->phone = $request->phone;

        //logo should exist but still checking for the name
        if ($request->hasFile('logo')) {
            $fileNameToStore = $this->getFileName($request->file('logo'));
            $logoPath = $request->file('logo')->storeAs('public/companies/logos', $fileNameToStore);
            if ($company->logo) {
                Storage::delete('public/companies/logos/' . basename($company->logo));
            }
            $company->logo = 'storage/companies/logos/' . $fileNameToStore;
        }

       
        if ($company->save()) {
            return true;
        }
        return false;
    }
    protected function getFileName($file)
    {
        $fileName = $file->getClientOriginalName();
        $actualFileName = pathinfo($fileName, PATHINFO_FILENAME);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        return $actualFileName . time() . '.' . $fileExtension;
    }

    public function destroy()
    {
        Storage::delete('public/companies/logos/' . basename(auth()->user()->company->logo));
        if (auth()->user()->company->delete()) {
            return redirect()->route('account.authorSection');
        }
        return redirect()->route('account.authorSection');
    }
}
