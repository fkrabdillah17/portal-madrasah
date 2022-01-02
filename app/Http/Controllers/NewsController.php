<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = news::all();
        return view('admin.news.index', [
            'title' => "News",
            'news' => $news
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.create', [
            'title' => "News",
            'category' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // dd(auth::user()->name);
        // Validation
        // $request->validate([
        //     'tag' => 'required',
        //     'title' => 'required|unique:news,title',
        //     'editor' => 'required',
        //     'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        // ]);
        // $slug = Str::of($request->title)->slug('-');
        // // Save
        // $news = new news;
        // $news->slug = $slug;
        // $news->tag = $request->tag;
        // $news->title = $request->title;
        // $news->author = Auth::user()->name;
        // $news->content = $request->editor;
        // $item = $request->thumbnail;
        // $imageName = time() . rand(100, 999) . "." . $item->getClientOriginalExtension();
        // $news->thumbnail = $imageName;
        // $item->move(public_path() . '/assets/img/news', $imageName);
        // $news->save();
        // return redirect('/admin/news')->with('status', 'Data Berhasil Ditambahkan');


        // Start validasi
        $rules = [
            'tag' => 'required',
            'editor' => 'required',
            'title' => 'required|unique:news,title|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
        $message = [
            'tag.required' => 'Pilih Kategori !',
            'editor.required' => 'Kolom wajib diisi!',
            'title.required' => 'Kolom wajib diisi!',
            'title.unique' => 'Judul telah ada',
            'title.max' => 'Judul maksimal 255 karakter',
            'thumbnail.image' => 'File Harus Gambar!',
            'thumbnail.mimes' => 'Format File jpeg,jpg atau png!',
            'thumbnail.max' => 'Ukuran File Maksimum 2 Mb!',
        ];
        $validate = $this->validate($request, $rules, $message);
        // End validasi
        if ($request->status == "Published") {
            $time = now();
        } else {
            $time = null;
        }
        if ($validate) {
            //SLug
            $slug = Str::of($request->title)->slug('-');

            // Start Upload Gambar
            $item = $request->thumbnail;
            $imageName = time() . rand(100, 999) . "." . $item->getClientOriginalExtension();
            $item->move(public_path() . '/assets/img/news', $imageName);
            //End Upload Data

            // Start Save Data
            News::create([
                'status' => $request->status,
                'category_id' => $request->tag,
                'title' => $request->title,
                'slug' => $slug,
                'content' => $request->editor,
                'thumbnail' => $imageName,
                'published_at' => $time,
                'updatedBy' => Auth::user()->id,
                'createdBy' => Auth::user()->id,
            ]);
            // End Save Data
            return redirect()->route('news.index')->with('status', 'Data berita berhasil ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        return view('admin.news.show', [
            'title' => "News",
            'news' => $news
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', [
            'title' => "News",
            'category' => Category::all(),
            'news' => $news
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        // dd($request->all());
        // Cek Judul
        if ($request->title != $request->oldTitle) {
            $rulesTitle = 'required|unique:news,title';
        } else {
            $rulesTitle = 'required';
        }
        $slug = Str::of($request->title)->slug('-');
        // if ($request->hasFile('thumbnail')) {
        //     $request->validate([
        //         'title' => $title,
        //         'editor' => 'required',
        //         'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        //     ]);
        //     $ubah = News::findorfail($news->id);
        //     $awal = $ubah->thumbnail;

        //     $dt = [
        //         'slug' => $slug,
        //         'thumbnail' => $awal,
        //         'title' => $request->title,
        //         'content' => $request->editor,
        //         'author' => Auth::user()->name,
        //     ];
        //     $request->thumbnail->move(public_path() . '/img', $awal);
        //     $ubah->update($dt);
        // } else {
        //     $request->validate([
        //         'title' => $title,
        //         'editor' => 'required'
        //     ]);
        //     $ubah = News::findorfail($news->id);
        //     $dt = [
        //         'slug' => $slug,
        //         'title' => $request->title,
        //         'content' => $request->editor,
        //         'author' => Auth::user()->name,
        //     ];
        //     $ubah->update($dt);
        // }
        // return redirect('/admin/news')->with('status', 'Data Berhasil DiUbah');

        if ($request->hasFile('thumbnail')) {
            // Start validasi
            $rules = [
                'title' => $rulesTitle,
                'editor' => 'required',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ];
            $message = [
                'editor.required' => 'Kolom wajib diisi',
                'title.required' => 'Kolom wajib diisi!',
                'title.unique' => 'Judul telah ada',
                'title.max' => 'Judul maksimal 255 karakter',
                'thumbnail.required' => 'Pilih File !',
                'thumbnail.image' => 'File Harus Gambar!',
                'thumbnail.mimes' => 'Format File jpeg,jpg atau png!',
                'thumbnail.max' => 'Ukuran File Maksimum 2 Mb!',
            ];
            $validate = $this->validate($request, $rules, $message);
            // End validasi

            if ($validate) {
                // Start Upload Gambar
                $awal = $news->thumbnail;
                $request->thumbnail->move(public_path() . '/assets/img/news', $awal);
                //End Upload Data

                // Start Save Data
                $news->update([
                    'title' => $request->title,
                    'content' => $request->editor,
                    'slug' => $slug,
                    'thumbnail' => $awal,
                    'updatedBy' => Auth::user()->id,
                ]);
                return redirect()->route('news.index')->with('status', 'Data berita berhasil diubah!');
            }
        } else {
            // Start validasi
            $rules = [
                'editor' => 'required',
                'title' => $rulesTitle,
            ];
            $message = [
                'editor.required' => 'Kolom wajib diisi',
                'title.required' => 'Kolom wajib diisi!',
                'title.unique' => 'Judul telah ada',
                'title.max' => 'Judul maksimal 255 karakter',
            ];
            $validate = $this->validate($request, $rules, $message);
            // End validasi

            if ($validate) {
                // Start Save Data
                $news->update([
                    'title' => $request->title,
                    'slug' => $slug,
                    'content' => $request->editor,
                    'updatedBy' => Auth::user()->id,
                ]);
                return redirect()->route('news.index')->with('status', 'Data berita berhasil diubah!');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        if (File::exists(public_path('assets/img/news/' . $news->thumbnail))) {
            File::delete(public_path('assets/img/news/' . $news->thumbnail));
            News::destroy($news->id);
        } else {
            dd('File does not exists.');
        }
        return redirect('/admin/news')->with('status', 'Data Berhasil Dihapus');
    }

    public function publish(News $news)
    {
        $news->update([
            'status' => "Published",
            'published_at' => now(),
        ]);
        return redirect()->route('news.index')->with('status', 'Berita Berhasil Di Terbitkan');
    }

    public function category_index()
    {
        $category = Category::all();
        return view('admin.news.category_index', [
            'title' => "News",
            'news' => $category
        ]);
    }
    public function categoryCreate()
    {
        return view('admin.news.category_create', [
            'title' => "News"
        ]);
    }
    public function categoryStore(Request $request)
    {
        // Start validasi
        $rules = [
            'category' => 'required|unique:profiles,title|max:255',
        ];
        $message = [
            'category.required' => 'Kolom wajib diisi!',
            'category.unique' => 'Judul telah ada',
            'category.max' => 'Judul maksimal 255 karakter',
        ];
        $validate = $this->validate($request, $rules, $message);
        // End validasi

        if ($validate) {
            $slug = Str::of($request->category)->slug('-');
            // Start Save Data
            Category::create([
                'category' => $request->category,
                'slug' => $slug,
            ]);
            return redirect()->route('category.index')->with('status', 'Data Kategori berhasil ditambahkan!');
        }
    }

    public function categoryDestroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('status', 'Data Kategori Berhasil Dihapus');
    }
}
