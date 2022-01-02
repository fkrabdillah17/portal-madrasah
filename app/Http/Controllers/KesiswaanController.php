<?php

namespace App\Http\Controllers;

use App\Models\Kesiswaan;
use App\Models\ContentCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KesiswaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kesiswaan = Kesiswaan::all();
        return view('admin.kesiswaan.index', [
            'category' => ContentCategory::where('category', 'Kesiswaan')->orderBy('name')->get(),
            'kesiswaan' => $kesiswaan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kesiswaan.create', [
            'category' => ContentCategory::where('category', 'Kesiswaan')->orderBy('name')->get()
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
        // Start validasi
        $rules = [
            'tag' => 'required',
            'editor' => 'required',
            'title' => 'required|unique:kesiswaans,title|max:150',
            // 'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
        $message = [
            'tag.required' => 'Pilih Kategori !',
            'editor.required' => 'Kolom wajib diisi!',
            'title.required' => 'Kolom wajib diisi!',
            'title.unique' => 'Judul telah ada',
            'title.max' => 'Judul maksimal 150 karakter',
            // 'file.image' => 'File Harus Gambar!',
            // 'file.mimes' => 'Format File jpeg,jpg atau png!',
            // 'file.max' => 'Ukuran File Maksimum 2 Mb!',
        ];
        $validate = $this->validate($request, $rules, $message);
        // End validasi

        if ($validate) {
            // Generate Slug
            $slug = Str::of($request->title)->slug('-');

            // Start Save Data
            Kesiswaan::create([
                'tag' => $request->tag,
                'slug' => $slug,
                'title' => $request->title,
                'description' => $request->editor,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]);
            // End Save Data
            return redirect()->route('kesiswaan.index')->with('status', 'Data Kesiswaan berhasil ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kesiswaan  $kesiswaan
     * @return \Illuminate\Http\Response
     */
    public function show(Kesiswaan $kesiswaan)
    {
        return view('admin.kesiswaan.show', [

            'kesiswaan' => $kesiswaan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kesiswaan  $kesiswaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Kesiswaan $kesiswaan)
    {
        return view('admin.kesiswaan.edit', [
            'kesiswaan' => $kesiswaan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kesiswaan  $kesiswaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kesiswaan $kesiswaan)
    {
        if ($request->title != $request->oldTitle) {
            $rulesTitle = 'required|unique:kesiswaans,title';
        } else {
            $rulesTitle = 'required';
        }

        // Start validasi
        $rules = [
            'editor' => 'required',
            'title' => $rulesTitle,
        ];
        $message = [
            'editor.required' => 'Kolom wajib diisi!',
            'title.required' => 'Kolom wajib diisi!',
            'title.unique' => 'Judul telah ada',
            'title.max' => 'Judul maksimal 255 karakter',
        ];
        $validate = $this->validate($request, $rules, $message);
        // End validasi

        if ($validate) {
            // Generate Slug
            $slug = Str::of($request->title)->slug('-');

            // Start Save Data
            $kesiswaan->update([
                'title' => $request->title,
                'slug' => $slug,
                'description' => $request->editor,
                'updated_by' => Auth::user()->id,
            ]);
            return redirect()->route('kesiswaan.index')->with('status', 'Data Kesiswaan berhasil diubah!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kesiswaan  $kesiswaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kesiswaan $kesiswaan)
    {
        $kesiswaan->delete();
        return redirect()->route('kesiswaan.index')->with('status', 'Data Berhasil Dihapus');
    }

    public function category_store(Request $request)
    {
        // Start validasi
        $rules = [
            'name' => 'required|unique:content_categories,name|max:30',
        ];
        $message = [
            'name.required' => 'Kolom Wajib diisi!',
            'name.max' => 'Maksimal 30 Karakter',
            'name.unique' => 'Kategori Sudah Ada',
        ];
        $validate = $this->validate($request, $rules, $message);
        // End validasi

        if ($validate) {
            // Generate Slug
            $slug = Str::of($request->name)->slug('-');

            // Start Save Data
            ContentCategory::create([
                'category' => "Kesiswaan",
                'name' => $request->name,
                'slug' => $slug
            ]);
            // End Save Data
            return redirect()->route('kesiswaan.create')->with('status', 'Tambah Kategori Berhasil!');
        }
    }

    public function category_destroy(ContentCategory $category)
    {
        $kesiswaan = Kesiswaan::where('tag', $category->id)->get();
        // dd($kesiswaan);
        foreach ($kesiswaan as $file) {
            Kesiswaan::destroy($file->id);
        }
        $category->delete();
        return redirect()->route('kesiswaan.index')->with('status', 'Semua Data' . $category->name . ' Berhasil Dihapus');
    }
}
