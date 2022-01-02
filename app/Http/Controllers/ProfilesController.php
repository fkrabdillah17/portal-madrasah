<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\ContentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = profile::all();
        return view('admin.profile.index', [
            'profiles' => $profiles,
            'category' => ContentCategory::where('category', 'Profile')->orderBy('name')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.profile.create', [
            'category' => ContentCategory::where('category', 'Profile')->orderBy('name')->get()
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
        // Validation

        if ($request->opsi != "File") {
            // Start validasi
            $rules = [
                'tag' => 'required',
                'editor' => 'required',
                'title' => 'required|unique:profiles,title|max:255',
            ];
            $message = [
                'tag.required' => 'Pilih Kategori !',
                'editor.required' => 'Kolom wajib diisi!',
                'title.required' => 'Kolom wajib diisi!',
                'title.unique' => 'Judul telah ada',
                'title.max' => 'Judul maksimal 255 karakter',
            ];
            $validate = $this->validate($request, $rules, $message);
            // End validasi

            if ($validate) {

                // Start Save Data
                Profile::create([
                    'title' => $request->title,
                    'tag' => $request->tag,
                    'content' => $request->editor,
                    'opsi' => $request->opsi,
                    'updatedBy' => Auth::user()->id,
                    'createdBy' => Auth::user()->id,
                ]);
                return redirect()->route('profile.index')->with('status', 'Data slide berhasil ditambahkan!');
            }
        } else {
            // Start validasi
            $rules = [
                'tag' => 'required',
                'title' => 'required|unique:profiles,title|max:255',
                'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ];
            $message = [
                'tag.required' => 'Pilih Kategori !',
                'title.required' => 'Kolom wajib diisi!',
                'title.unique' => 'Judul telah ada',
                'title.max' => 'Judul maksimal 255 karakter',
                'file.required' => 'Pilih File !',
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
                $item->move(public_path() . '/assets/img/profile', $imageName);
                //End Upload Data

                // Start Save Data
                Profile::create([
                    'title' => $request->title,
                    'tag' => $request->tag,
                    'content' => $imageName,
                    'opsi' => $request->opsi,
                    'updatedBy' => Auth::user()->id,
                    'createdBy' => Auth::user()->id,
                ]);
                return redirect()->route('profile.index')->with('status', 'Data slide berhasil ditambahkan!');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        // dd($profile);
        return view('admin.profile.show', [
            'profile' => $profile
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        return view('admin.profile.edit', [
            'profile' => $profile
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        // Cek Judul
        if ($request->title == $request->oldTitle) {
            $rulesTitle = 'required|max:255';
        } else {
            $rulesTitle = 'required|unique:profiles,title|max:255';
        }

        if ($request->opsi == "Deskripsi") {
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
                $profile->update([
                    'title' => $request->title,
                    'content' => $request->editor,
                    'updatedBy' => Auth::user()->id,
                ]);
                return redirect()->route('profile.index')->with('status', 'Data profil ' . $request->oldTitle . '  berhasil diubah!');
            }
        } else {
            if ($request->hasFile('file')) {
                // Start validasi
                $rules = [
                    'title' => $rulesTitle,
                    'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                ];
                $message = [
                    'title.required' => 'Kolom wajib diisi!',
                    'title.unique' => 'Judul telah ada',
                    'title.max' => 'Judul maksimal 255 karakter',
                    'file.required' => 'Pilih File !',
                    'file.image' => 'File Harus Gambar!',
                    'file.mimes' => 'Format File jpeg,jpg atau png!',
                    'file.max' => 'Ukuran File Maksimum 2 Mb!',
                ];
                $validate = $this->validate($request, $rules, $message);
                // End validasi

                if ($validate) {
                    // Start Upload Gambar
                    $ubah = profile::findorfail($profile->id);
                    $awal = $ubah->content;
                    // dd($awal);
                    $request->file->move(public_path() . '/assets/img/profile', $awal);
                    //End Upload Data

                    // Start Save Data
                    $profile->update([
                        'title' => $request->title,
                        'content' => $awal,
                        'updatedBy' => Auth::user()->id,
                    ]);
                    return redirect()->route('profile.index')->with('status', 'Data profil ' . $request->oldTitle . '  berhasil diubah!');
                }
            } else {
                // Start validasi
                $rules = [
                    'title' => $rulesTitle,
                ];
                $message = [
                    'title.required' => 'Kolom wajib diisi!',
                    'title.unique' => 'Judul telah ada',
                    'title.max' => 'Judul maksimal 255 karakter',
                ];
                $validate = $this->validate($request, $rules, $message);
                // End validasi

                if ($validate) {
                    // Start Save Data
                    $profile->update([
                        'title' => $request->title,
                        'updatedBy' => Auth::user()->id,
                    ]);
                    return redirect()->route('profile.index')->with('status', 'Data profil ' . $request->oldTitle . '  berhasil diubah!');
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        if ($profile->opsi != "File") {
            Profile::destroy($profile->id);
        } else {
            if (File::exists(public_path('assets/img/profile/' . $profile->content))) {
                File::delete(public_path('assets/img/profile/' . $profile->content));
                Profile::destroy($profile->id);
            } else {
                dd('File does not exists.');
            }
        }

        return redirect('/admin/profile')->with('status', 'Data Berhasil Dihapus');
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
                'category' => "Profile",
                'name' => $request->name,
                'slug' => $slug
            ]);
            // End Save Data
            return redirect()->route('profile.create')->with('status', 'Tambah Kategori Berhasil!');
        }
    }

    public function category_destroy(ContentCategory $category)
    {
        $profile = Profile::where('tag', $category->id)->get();
        // dd($profile);
        foreach ($profile as $file) {
            if ($file->opsi == "File") {
                if (File::exists(public_path('assets/img/profile/' . $file->content))) {
                    File::delete(public_path('assets/img/profile/' . $file->content));
                    Profile::destroy($file->id);
                } else {
                    dd('File does not exists.');
                }
            } else {
                Profile::destroy($file->id);
            }
        }
        $category->delete();
        return redirect()->route('profile.index')->with('status', 'Semua Data' . $category->name . ' Berhasil Dihapus');
    }
}
