<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyKulinerRequest;
use App\Http\Requests\StoreKulinerRequest;
use App\Http\Requests\UpdateKulinerRequest;
use App\Models\CategoryKuliner;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Hashids\Hashids;
class CategoryKulinerController extends Controller
{


public function getAllcategorykuliners()
    {
        $hash=new Hashids();
        $categories = CategoryKuliner::all();

        return view('admin.categorykuliner.index', compact('categories','hash'));
    }



    public function storecategorykuliner(Request $request)
    {
        $request->validate([
            'category_name' => 'required|min:5'
        ]);
        CategoryKuliner::create([
            'category_name' => $request->category_name
        ]);
        Alert::toast('Category Created!', 'success');
        return redirect()->route('admin.categorykuliner.index');
    }


    public function createcategorykuliner()
    {

        return view('admin.categorykuliner.create');
    }

    public function editcategorykuliner($category)
    {
        $hash=new Hashids();
        $category = CategoryKuliner::find($hash->decodeHex($category));
        return view('admin.categorykuliner.edit', compact('category','hash'));
    }

    public function categorykulinerupdate(Request $request, $category)
    {
        $hash=new Hashids();

        $request->validate([
            'category_name' => 'required|min:5'
        ]);
        $category = CategoryKuliner::find($hash->decodeHex($category));
        $category->update([
            'category_name' => $request->category_name
        ]);
        Alert::toast('Category Updated!', 'success');
        return redirect()->route('admin.categorykuliner.index');
    }

    public function destroy($id)
    {
        $category = CategoryKuliner::find($id);
        $category->delete();
        Alert::toast('Category Delete!', 'success');
        return redirect()->route('admin.categorykuliner.index');
    }
}
