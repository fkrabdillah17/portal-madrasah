<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ContentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();
        return view('admin.service.index', [
            'services' => $services,
            'category' => ContentCategory::where('category', 'Service')->orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service.create', [
            'category' => ContentCategory::where('category', 'Service')->orderBy('name')->get()
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
        // Start Validasi
        $rules = [
            'tag' => 'required',
            'editor' => 'required',
            'title' => 'required|unique:services,title|max:255',
        ];
        $message = [
            'tag.required' => 'Wajib Pilih Kategori!',
            'editor.required' => 'Kolom wajib diisi!',
            'title.required' => 'Kolom wajib diisi!',
            'title.unique' => 'Judul telah ada',
            'title.max' => 'Judul maksimal 255 karakter',
        ];
        $validate = $this->validate($request, $rules, $message);
        // End validasi

        //Start slug
        $slug = Str::of($request->title)->slug('-');
        //End slug

        if ($validate) {
            // Start Save Data
            service::create([
                'title' => $request->title,
                'slug' => $slug,
                'opsi' => $request->opsi,
                'category' => $request->tag,
                'content' => $request->editor,
                'updated_by' => Auth::user()->id,
                'created_by' => Auth::user()->id,
            ]);
            return redirect()->route('service.index')->with('status', 'Data layanan berhasil ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('admin.service.show', [
            'title' => 'Service',
            'service' => $service
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('admin.service.edit', [
            'title' => 'Service',
            'service' => $service
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        if ($request->title != $request->oldTitle) {
            $rulesTitle = 'required|unique:news,title';
        } else {
            $rulesTitle = 'required';
        }
        $slug = Str::of($request->title)->slug('-');

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
            // Start Save Data
            $service->update([
                'title' => $request->title,
                'slug' => $slug,
                'content' => $request->editor,
                'updated_by' => Auth::user()->id,
            ]);
            return redirect()->route('service.index')->with('status', 'Data layanan berhasil diubah!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect('/admin/service')->with('status', 'Data Berhasil Dihapus');
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
                'category' => "Service",
                'name' => $request->name,
                'slug' => $slug
            ]);
            // End Save Data
            return redirect()->route('service.create')->with('status', 'Tambah Kategori Berhasil!');
        }
    }

    public function category_destroy(ContentCategory $category)
    {
        $service = Service::where('category', $category->id)->get();
        // dd($service);
        foreach ($service as $file) {
            Service::destroy($file->id);
        }
        $category->delete();
        return redirect()->route('service.index')->with('status', 'Semua Data' . $category->name . ' Berhasil Dihapus');
    }
}
