<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Information::all();
        return view('admin.slider.index', [
            'title' => "Slider",
            'sliders' => $sliders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.create');
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
        // dd(Auth::user()->id);

        if ($request->title == "Welcome Slide") {
            // Start validasi
            $rules = [
                'title' => 'required|unique:information,title',
                'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ];
            $message = [
                'title.required' => 'Pilih Kategori !',
                'file.required' => 'Pilih File !',
                'title.unique' => 'Kategori Hanya Boleh Satu',
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
                $item->move(public_path() . '/assets/img/slider', $imageName);
                //End Upload Data

                // Start Save Data
                Information::create([
                    'title' => $request->title,
                    'file' => $imageName,
                    'user_id' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);
                return redirect()->route('slide.index')->with('status', 'Data slide berhasil ditambahkan!');
            }
        } else {
            $titles = $request->title;
            // Start validasi
            $rules = [
                'title' => 'required',
                'titles' => 'required|unique:information,title',
                'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ];
            $message = [
                'title.required' => 'Pilih Kategori !',
                'titles.required' => 'Isi Kolom Judul!',
                'file.required' => 'Pilih File !',
                'titles.unique' => 'Judul Sudah Ada',
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
                $item->move(public_path() . '/assets/img/slider', $imageName);
                //End Upload Data

                // Start Save Data
                Information::create([
                    'title' => $titles,
                    'file' => $imageName,
                    'user_id' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);
                return redirect()->route('slide.index')->with('status', 'Data slide berhasil ditambahkan!');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function show(Information $information)
    {
        return view('admin.slider.show', [
            'information' => $information
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function edit(Information $information)
    {
        return view('admin.slider.edit', [
            'information' => $information
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Information $information)
    {
        $rules = [
            'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
        $message = [
            'file.required' => 'Pilih File !',
            'file.image' => 'File Harus Gambar!',
            'file.mimes' => 'Format File jpeg,jpg atau png!',
            'file.max' => 'Ukuran File Maksimum 2 Mb!',
        ];
        $validate = $this->validate($request, $rules, $message);
        // End validasi

        if ($validate) {
            // Start Upload Gambar
            $ubah = Information::findorfail($information->id);
            $awal = $ubah->file;
            $request->file->move(public_path() . '/assets/img/slider', $awal);
            //End Upload Data

            // Start Save Data
            $information->update([
                'file' => $awal,
                'updated_by' => Auth::user()->id,
            ]);
            return redirect()->route('slide.index')->with('status', 'Data slide berhasil diubah!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function destroy(Information $information)
    {
        if (File::exists(public_path('assets/img/slider/' . $information->file))) {
            File::delete(public_path('assets/img/slider/' . $information->file));
            Information::destroy($information->id);
        } else {
            dd('File does not exists.');
        }
        return redirect()->route('slide.index')->with('status', 'Data Berhasil Dihapus');
    }
}
