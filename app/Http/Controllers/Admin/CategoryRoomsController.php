<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryRooms;
use RealRashid\SweetAlert\Facades\Alert;
use Hashids\Hashids;
class CategoryRoomsController extends Controller
{
    //
    public function getAllcategoryroom()
    {
        $hash=new Hashids();
        $categories = CategoryRooms::all();

        return view('admin.categoryroom.index', compact('categories','hash'));
    }

    public function storecategoryroom(Request $request)
    {
        $request->validate([
            'category_name' => 'required|min:5'
        ]);
        CategoryRooms::create([
            'category_name' => $request->category_name
        ]);
        Alert::toast('Category Created!', 'success');
        return redirect()->route('admin.categoryroom.index');
    }

    public function createcategoryroom()
    {

        return view('admin.categoryroom.create');
    }

    public function editcategoryroom($category)
    {
        $hash=new Hashids();
        $category = CategoryRooms::find($hash->decodeHex($category));
        return view('admin.categoryroom.edit', compact('category','hash'));
    }

    public function categoryroomupdate(Request $request, $category)
    {
        $hash=new Hashids();

        $request->validate([
            'category_name' => 'required|min:5'
        ]);
        $category = CategoryRooms::find($hash->decodeHex($category));
        $category->update([
            'category_name' => $request->category_name
        ]);
        Alert::toast('Category Updated!', 'success');
        return redirect()->route('admin.categoryroom.index');
    }

    public function destroy($id)
    {
        $category = CategoryRooms::find($id);
        $category->delete();
        Alert::toast('Category Delete!', 'success');
        return redirect()->route('admin.categoryroom.index');
    }

}
