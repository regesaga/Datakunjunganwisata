<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Requests\MassDestroyArticleRequest;
use Illuminate\Support\Str;
use App\Models\Rekomendasi;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Hashids\Hashids;

class ArticleController extends Controller
{
       public function index()
    {
        $hash=new Hashids();
        $article = Article::all();
        $tag = Tag::all();
        return view('admin.article.index', compact('article','hash','tag'))->with([
            'hash' => $hash,
            'tag' => $tag
        ]);
    }


    public function create()
    {
        $hash=new Hashids();
        $tag = Tag::all();
        return view('admin.article.create', compact( 'tag', 'hash'))->with([
            'tag' => $tag,
            'hash' => $hash
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'sampul' => 'required|mimes:jpg,jpeg,png',
            'konten' => 'required',
            'tag' => 'required',
        ]);
       
        $sampul = time() .'-' .$request->sampul->getClientOriginalName();
        $request->sampul->move('upload/article', $sampul);

        Article::create([
            'sampul' => $sampul,
            'judul' => $request->judul,
            'konten' => $request->konten,
            'active' => $request->active,
            'slug' => Str::slug($request->judul, '-'),
            'created_by_id' => Auth::user()->id
        ])->tag()->attach($request->tag);

        Alert::success('Sukses', 'Data berhasil ditambahkan');
        return redirect()->route('admin.article.index');
    }



    public function showarticle($article)
    {
                    $hash=new Hashids();
                    $article = Article::find($hash->decodeHex($article));
                    return view('admin.article.show', compact('article','hash'));
    }
 


    public function edit($article)
    {
        $hash=new Hashids();
        $tag = Tag::select('id', 'nama')->get();
        $article = Article::find($hash->decodeHex($article));
        return view('admin.article.edit', compact('article', 'tag','hash'));

       
    }


    public function update(Request $request, $id)
    {
        if(!$request->active){
            $request->merge([
                'active' => 0
            ]);
        }
        $hash = new Hashids();
        
    
        $article = Article::findOrFail($hash->decodeHex($id));
    
        $data = $request->all();
    
        if ($request->hasFile('sampul')) {
            $request->validate([
                'sampul' => 'mimes:jpg,jpeg,png',
            ]);
    
            $sampul = time() . '-' . $request->sampul->getClientOriginalName();
            $request->sampul->move('upload/article', $sampul);
    
            File::delete('upload/article/' . $article->sampul);
            $data['sampul'] = $sampul;
        }
    
        $article->update($data);
        $article->tag()->sync($request->tag);
    
        Alert::success('Sukses', 'Data berhasil diubah');
        return redirect()->route('admin.article.index');
    }
    

    public function destroy(Request $request,$article)
    {
        $hash=new Hashids();
        $article = Article::find($hash->decodeHex($article));
        File::delete('upload/article/' . $article->sampul);
        $article->delete();


        return back();
    }

    public function konfirmasi($id)
    {
        alert()->question('Peringatan !', 'Anda yakin akan menghapus data ?')
        ->showConfirmButton('<a href="/article/' . $id . '/delete" class="text-white" style="text-decoration: none"> Hapus</a>', '#3085d6')->toHtml()
        ->showCancelButton('Batal', '#aaa')->reverseButtons();

        return redirect()->route('admin.article.index');
    }

    public function delete($id)
    {
        $article = Article::select('sampul', 'id')->whereId($id)->where('created_by_id', Auth::user()->id)->firstOrFail();
        File::delete('upload/article/' . $article->sampul);
        $article->delete();

        Alert::success('Sukses', 'Data berhasil dihapus');
        return redirect()->route('admin.article.index');
    }

    public function rekomendasi($id)
    {
        $article = DB::table('article')
            ->join('rekomendasi', 'article.id', '=', 'rekomendasi.id_article')
            ->where('rekomendasi.id_article', $id)
            ->get();

        if ($article->isEmpty()) {
            Rekomendasi::create([
                'id_article' => $id
            ]);

            Alert::success('Sukses', 'Article berhasil direkomendasikan');
           return redirect()->route('admin.article.index');
        } else {
            Rekomendasi::where('id_article', $id)->delete();
            Alert::success('Sukses', 'Article batal direkomendasikan');
           return redirect()->route('admin.article.index');
        }
        
    }

    public function massDestroy(MassDestroyArticleRequest $request)
    {
        Article::whereIn('id', request('ids'))->delete();

        return back();
    }
}
