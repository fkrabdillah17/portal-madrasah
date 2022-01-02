<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\ContentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff = Staff::all();
        return view('admin.staff.index', [
            'staff' => $staff,
            'category' => ContentCategory::where('category', 'Staff')->orderBy('name')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.staff.create', [
            'category' => ContentCategory::where('category', 'Staff')->orderBy('name')->get()
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
        $rules = [
            'name' => 'required|unique:staff,name|max:150',
            'nip' => 'required',
            'tag' => 'required',
            'gtk' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
        ];
        $message = [
            'tag.required' => 'Wajib Pilih Kategori!',
            'nip.required' => 'NIP wajib diisi!',
            'gtk.required' => 'Jenis GTK wajib diisi!',
            'name.required' => 'Nama wajib diisi!',
            'name.unique' => 'Nama telah ada',
            'name.max' => 'Nama maksimal 150 karakter',
            'photo.image' => 'File Harus Gambar!',
            'photo.mimes' => 'Format File jpeg,jpg atau png!',
            'photo.max' => 'Ukuran File Maksimum 2 Mb!',
        ];
        $validate = $this->validate($request, $rules, $message);
        // End validasi
        if ($validate) {
            if ($request->hasFile('photo')) {

                // Start Upload Gambar
                $item = $request->photo;
                $imageName = time() . rand(100, 999) . "." . $item->getClientOriginalExtension();
                $item->move(public_path() . '/assets/img/staff', $imageName);
                //End Upload Data

                // Start Save Data
                Staff::create([
                    'name' => $request->name,
                    'nip' => $request->nip,
                    'jabatan' => $request->gtk,
                    'category' => $request->tag,
                    'photo' => $imageName,
                    'updated_by' => Auth::user()->id,
                    'created_by' => Auth::user()->id,
                ]);
            } else {
                // Start Save Data
                Staff::create([
                    'name' => $request->name,
                    'nip' => $request->nip,
                    'category' => $request->tag,
                    'jabatan' => $request->gtk,
                    'updated_by' => Auth::user()->id,
                    'created_by' => Auth::user()->id,
                ]);
                // End Save Data
            }

            return redirect()->route('staff.index')->with('status', 'Data Staff berhasil ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        return view('admin.staff.show', [
            'staff' => $staff
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', [
            'staff' => $staff
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staff $staff)
    {
        // Cek Nama
        if ($request->name != $request->oldName) {
            $rulesTitle = 'required|unique:staff,name';
        } else {
            $rulesTitle = 'required';
        }

        // Cek Foto
        if ($request->hasFile('photo')) {
            // Start validasi
            $rules = [
                'name' => $rulesTitle,
                'nip' => 'required',
                'gtk' => 'required',
                'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
            ];
            $message = [
                'nip.required' => 'NIP wajib diisi!',
                'gtk.required' => 'Jenis GTK wajib diisi!',
                'name.required' => 'Nama wajib diisi!',
                'name.unique' => 'Nama telah ada',
                'name.max' => 'Nama maksimal 150 karakter',
                'photo.image' => 'File Harus Gambar!',
                'photo.mimes' => 'Format File jpeg,jpg atau png!',
                'photo.max' => 'Ukuran File Maksimum 2 Mb!',
            ];
            $validate = $this->validate($request, $rules, $message);
            // End validasi
            // dd($request->oldPhoto);
            if ($validate) {
                if ($request->oldPhoto != null) {
                    // Start Upload Gambar
                    $awal = $staff->photo;
                    $request->photo->move(public_path() . '/assets/img/staff', $awal);
                    //End Upload Data

                    // Start Save Data
                    $staff->update([
                        'name' => $request->name,
                        'nip' => $request->nip,
                        'jabatan' => $request->gtk,
                        'photo' => $awal,
                        'updated_by' => Auth::user()->id,
                    ]);
                } else {
                    // Start Upload Gambar
                    $item = $request->photo;
                    $imageName = time() . rand(100, 999) . "." . $item->getClientOriginalExtension();
                    $item->move(public_path() . '/assets/img/staff', $imageName);
                    //End Upload Data

                    // Start Save Data
                    $staff->update([
                        'name' => $request->name,
                        'nip' => $request->nip,
                        'jabatan' => $request->gtk,
                        'photo' => $imageName,
                        'updated_by' => Auth::user()->id,
                    ]);
                }
                return redirect()->route('staff.index')->with('status', 'Data Staff berhasil diubah!');
            }
        } else {
            // Start validasi
            $rules = [
                'name' => $rulesTitle,
                'nip' => 'required',
                'gtk' => 'required',
            ];
            $message = [
                'nip.required' => 'NIP wajib diisi!',
                'gtk.required' => 'Jenis GTK wajib diisi!',
                'name.required' => 'Nama wajib diisi!',
                'name.unique' => 'Nama telah ada',
                'name.max' => 'Nama maksimal 150 karakter',
            ];
            $validate = $this->validate($request, $rules, $message);
            // End validasi

            if ($validate) {
                // Start Save Data
                $staff->update([
                    'name' => $request->name,
                    'nip' => $request->nip,
                    'jabatan' => $request->gtk,
                    'updated_by' => Auth::user()->id,
                ]);
                return redirect()->route('staff.index')->with('status', 'Data tenaga kepedidikan berhasil diubah!');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        if (File::exists(public_path('assets/img/staff/' . $staff->photo))) {
            File::delete(public_path('assets/img/staff/' . $staff->photo));
            Staff::destroy($staff->id);
        } else {
            dd('File does not exists.');
        }
        return redirect()->route('staff.index')->with('status', 'Data Berhasil Dihapus');
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
                'category' => "Staff",
                'name' => $request->name,
                'slug' => $slug
            ]);
            // End Save Data
            return redirect()->route('staff.create')->with('status', 'Tambah Kategori Berhasil!');
        }
    }

    public function category_destroy(ContentCategory $category)
    {
        $staff = Staff::where('category', $category->id)->get();
        // dd($staff);
        foreach ($staff as $file) {
            if (File::exists(public_path('assets/img/staff/' . $file->photo))) {
                File::delete(public_path('assets/img/staff/' . $file->photo));
                Staff::destroy($file->id);
            } else {
                dd('File does not exists.');
            }
        }
        $category->delete();
        return redirect()->route('staff.index')->with('status', 'Semua Data' . $category->name . ' Berhasil Dihapus');
    }
}
