<?php

namespace App\Http\Controllers;

use App\Models\Academic;
use App\Models\ContentCategory;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AcademicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $academic = Academic::all();
        return view('admin.academic.index', [
            'academic' => $academic,
            'category' => ContentCategory::where('category', 'Akademik')->orderBy('name')->get()

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.academic.create', [
            'category' => ContentCategory::where('category', 'Akademik')->orderBy('name')->get()
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
            'title' => 'required|unique:academics,title|max:150',
            'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
        $message = [
            'tag.required' => 'Pilih Kategori !',
            'editor.required' => 'Kolom wajib diisi!',
            'title.required' => 'Kolom wajib diisi!',
            'title.unique' => 'Judul telah ada',
            'title.max' => 'Judul maksimal 150 karakter',
            'file.image' => 'File Harus Gambar!',
            'file.mimes' => 'Format File jpeg,jpg atau png!',
            'file.max' => 'Ukuran File Maksimum 2 Mb!',
        ];
        $validate = $this->validate($request, $rules, $message);
        // End validasi

        if ($validate) {

            // Start Upload Gambar
            $item = $request->file;
            $imageName = time() . rand(100, 999) . "." . $item->getClientOriginalExtension();
            $item->move(public_path() . '/assets/img/academic', $imageName);
            //End Upload Data

            // Start Save Data
            Academic::create([
                'tag' => $request->tag,
                'title' => $request->title,
                'description' => $request->editor,
                'file' => $imageName,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]);
            // End Save Data
            return redirect()->route('academic.index')->with('status', 'Data akademik berhasil ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Academic  $academic
     * @return \Illuminate\Http\Response
     */
    public function show(Academic $academic)
    {
        return view('admin.academic.show', [
            'title' => "Akademik",
            'academic' => $academic
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Academic  $academic
     * @return \Illuminate\Http\Response
     */
    public function edit(Academic $academic)
    {
        return view('admin.academic.edit', [
            'title' => "Akademik",
            'academic' => $academic
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Academic  $academic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Academic $academic)
    {
        // Cek Judul
        if ($request->title != $request->oldTitle) {
            $rulesTitle = 'required|unique:news,title';
        } else {
            $rulesTitle = 'required';
        }
        $slug = Str::of($request->title)->slug('-');

        // Cek Gambar
        if ($request->hasFile('file')) {
            // Start validasi
            $rules = [
                'title' => $rulesTitle,
                'editor' => 'required',
                'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ];
            $message = [
                'editor.required' => 'Kolom wajib diisi',
                'title.required' => 'Kolom wajib diisi!',
                'title.unique' => 'Judul telah ada',
                'title.max' => 'Judul maksimal 150 karakter',
                'file.required' => 'Pilih File !',
                'file.image' => 'File Harus Gambar!',
                'file.mimes' => 'Format File jpeg,jpg atau png!',
                'file.max' => 'Ukuran File Maksimum 2 Mb!',
            ];
            $validate = $this->validate($request, $rules, $message);
            // End validasi

            if ($validate) {
                // Start Upload Gambar
                $awal = $academic->file;
                $request->file->move(public_path() . '/assets/img/academic', $awal);
                //End Upload Data

                // Start Save Data
                $academic->update([
                    'title' => $request->title,
                    'description' => $request->editor,
                    'slug' => $slug,
                    'file' => $awal,
                    'updated_by' => Auth::user()->id,
                ]);
                return redirect()->route('academic.index')->with('status', 'Data akademik berhasil diubah!');
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
                'title.max' => 'Judul maksimal 150 karakter',
            ];
            $validate = $this->validate($request, $rules, $message);
            // End validasi

            if ($validate) {
                // Start Save Data
                $academic->update([
                    'title' => $request->title,
                    'slug' => $slug,
                    'description' => $request->editor,
                    'updated_by' => Auth::user()->id,
                ]);
                return redirect()->route('academic.index')->with('status', 'Data akademik berhasil diubah!');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Academic  $academic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Academic $academic)
    {
        if (File::exists(public_path('assets/img/academic/' . $academic->file))) {
            File::delete(public_path('assets/img/academic/' . $academic->file));
            Academic::destroy($academic->id);
        } else {
            dd('File does not exists.');
        }
        return redirect()->route('academic.index')->with('status', 'Data Berhasil Dihapus');
    }


    //File Upload

    public function upload_index()
    {
        $academic = FileUpload::all();
        return view('admin.academic.upload_index', [
            'title' => "Akademik",
            'academic' => $academic
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload_create()
    {
        return view('admin.academic.upload_create', [
            'title' => "Akademik"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload_store(Request $request)
    {
        // Start validasi
        $rules = [
            'title' => 'required|unique:file_uploads,title|max:200',
            'file' => 'required|file|mimes:pdf|max:3072',
        ];
        $message = [
            'title.required' => 'Kolom wajib diisi!',
            'title.unique' => 'Judul telah ada',
            'title.max' => 'Judul maksimal 255 karakter',
            'file.required' => 'Wajib Pilih File!',
            'file.file' => 'Pilih sebuah file!',
            'file.mimes' => 'Format File pdf!',
            'file.max' => 'Ukuran File Maksimum 3 Mb!',
        ];
        $validate = $this->validate($request, $rules, $message);
        // End validasi

        if ($validate) {
            // Generate Slug
            $slug = Str::of($request->title)->slug('-');

            // Start Upload File
            $item = $request->file;
            $fileName = time() . rand(100, 999) . "." . $item->getClientOriginalExtension();
            $item->move(public_path() . '/assets/files/academic', $fileName);
            //End Upload File

            // Start Save Data
            FileUpload::create([
                'title' => $request->title,
                'slug' => $slug,
                'file' => $fileName,
                'created_by' => Auth::user()->id
            ]);
            // End Save Data
            return redirect()->route('academic.upload.index')->with('status', 'Unggah File Berhasil!');
        }
    }

    public function upload_show(FileUpload $FileUpload)
    {
        // $data = FileUpload::where('id', $id)->get();
        // dd($FileUpload);
        return view('admin.academic.upload_show', [
            'title' => "File",
            'data' => $FileUpload
        ]);
    }

    public function upload_destroy(FileUpload $FileUpload)
    {
        // dd($FileUpload->file);
        if (File::exists(public_path('assets/files/academic/' . $FileUpload->file))) {
            File::delete(public_path('assets/files/academic/' . $FileUpload->file));
            FileUpload::destroy($FileUpload->id);
        } else {
            dd('File does not exists.');
        }
        return redirect()->route('academic.upload.index')->with('status', 'File Berhasil Dihapus');
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
                'category' => "Akademik",
                'name' => $request->name,
                'slug' => $slug
            ]);
            // End Save Data
            return redirect()->route('academic.create')->with('status', 'Tambah Kategori Berhasil!');
        }
    }

    public function category_destroy(ContentCategory $category)
    {
        $academic = Academic::where('tag', $category->id)->get();
        // dd($academic);
        foreach ($academic as $file) {
            if (File::exists(public_path('assets/img/academic/' . $file->file))) {
                File::delete(public_path('assets/img/academic/' . $file->file));
                Academic::destroy($file->id);
            } else {
                dd('File does not exists.');
            }
        }
        $category->delete();
        return redirect()->route('academic.index')->with('status', 'Semua Data' . $category->name . ' Berhasil Dihapus');
    }
}
