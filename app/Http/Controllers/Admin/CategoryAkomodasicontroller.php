<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryAkomodasi;
use RealRashid\SweetAlert\Facades\Alert;
use Hashids\Hashids;
class CategoryAkomodasiController extends Controller
{
    //
    public function getAllcategoryakomodasi()
    {
        $hash=new Hashids();
        $categories = CategoryAkomodasi::all();

        return view('admin.categoryakomodasi.index', compact('categories','hash'));
    }

    public function storecategoryakomodasi(Request $request)
    {
        $request->validate([
            'category_name' => 'required|min:5'
        ]);
        CategoryAkomodasi::create([
            'category_name' => $request->category_name
        ]);
        Alert::toast('Category Created!', 'success');
        return redirect()->route('admin.categoryakomodasi.index');
    }

    public function createcategoryakomodasi()
    {

        return view('admin.categoryakomodasi.create');
    }

    public function editcategoryakomodasi($category)
    {
        $hash=new Hashids();
        $category = CategoryAkomodasi::find($hash->decodeHex($category));
        return view('admin.categoryakomodasi.edit', compact('category','hash'));
    }

    public function categoryakomodasiupdate(Request $request, $category)
    {
        $hash=new Hashids();

        $request->validate([
            'category_name' => 'required|min:5'
        ]);
        $category = CategoryAkomodasi::find($hash->decodeHex($category));
        $category->update([
            'category_name' => $request->category_name
        ]);
        Alert::toast('Category Updated!', 'success');
        return redirect()->route('admin.categoryakomodasi.index');
    }

    public function destroy($id)
    {
        $category = CategoryAkomodasi::find($id);
        $category->delete();
        Alert::toast('Category Delete!', 'success');
        return redirect()->route('admin.categoryakomodasi.index');
    }

}
