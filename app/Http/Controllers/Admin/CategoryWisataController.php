<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWisataRequest;
use App\Http\Requests\StoreWisataRequest;
use App\Http\Requests\UpdateWisataRequest;
use App\Models\CategoryWisata;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\MassDestroyCategoryWisataRequest;
use Hashids\Hashids;
class CategoryWisataController extends Controller
{


public function getAllcategorywisatas()
    {
        $hash=new Hashids();
        $categories = CategoryWisata::all();

        return view('admin.categorywisata.index', compact('categories','hash'));
    }



    public function storecategorywisata(Request $request)
    {
        $request->validate([
            'category_name' => 'required|min:5'
        ]);
        CategoryWisata::create([
            'category_name' => $request->category_name
        ]);
        Alert::toast('Category Created!', 'success');
        return redirect()->route('admin.categorywisata.index');
    }


    public function createcategorywisata()
    {

        return view('admin.categorywisata.create');
    }

    public function editcategorywisata($category)
    {
        $hash=new Hashids();
        $category = CategoryWisata::find($hash->decodeHex($category));
        return view('admin.categorywisata.edit', compact('category','hash'));
    }

    public function categorywisataupdate(Request $request, $category)
    {
        $hash=new Hashids();

        $request->validate([
            'category_name' => 'required|min:5'
        ]);
        $category = CategoryWisata::find($hash->decodeHex($category));
        $category->update([
            'category_name' => $request->category_name
        ]);
        Alert::toast('Category Updated!', 'success');
        return redirect()->route('admin.categorywisata.index');
    }

    public function destroy($id)
    {
        $category = CategoryWisata::find($id);
        $category->delete();
        Alert::toast('Category Delete!', 'success');
        return redirect()->route('admin.categorywisata.index');
    }
    public function massDestroy(MassDestroyCategoryWisataRequest $request)
    {
        CategoryWisata::whereIn('id', request('ids'))->delete();
        if (count($category->photos) > 0) {
            foreach ($category->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        return back();

    }
}
