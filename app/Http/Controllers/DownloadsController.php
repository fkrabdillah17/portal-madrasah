<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class DownloadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $downloads = Download::all();
        return view('admin.download.index', [
            'title' => "Download",
            'downloads' => $downloads
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.download.create', [
            'title' => "Download"
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
        // Start validasi
        $rules = [
            'title' => 'required|unique:downloads,title|max:255',
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
            //SLug
            $slug = Str::of($request->title)->slug('-');

            // Start Upload File
            $item = $request->file;
            $fileName = time() . rand(100, 999) . "." . $item->getClientOriginalExtension();
            $item->move(public_path() . '/assets/files', $fileName);
            //End Upload Data

            // Start Save Data
            Download::create([
                'title' => $request->title,
                'slug' => $slug,
                'file' => $fileName,
                'created_by' => Auth::user()->id,
            ]);
            // End Save Data
            return redirect()->route('download.index')->with('status', 'Data unduhan berhasil ditambahkan!');
        }

        // $request->validate([
        //     'title' => 'required|unique:downloads',
        //     'file' => 'required|unique:downloads,file|file|mimes:pdf|max:3072',
        // ]);
        // $download = new Download;
        // $download->title = $request->title;
        // $item = $request->file;
        // $fileName = time() . rand(100, 999) . "." . $item->getClientOriginalExtension();
        // $download->file = $fileName;
        // $item->move(public_path() . '/file', $fileName);
        // $download->save();

        // return redirect('/admin/download')->with('status', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Download  $download
     * @return \Illuminate\Http\Response
     */
    public function show(Download $download)
    {
        // $files = asset('file/' . $download->file);
        // return $files;
        return view('admin.download.show', [
            'title' => "Download",
            'download' => $download
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Download  $download
     * @return \Illuminate\Http\Response
     */
    public function edit(Download $download)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Download  $download
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Download $download)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Download  $download
     * @return \Illuminate\Http\Response
     */
    public function destroy(Download $download)
    {
        if (File::exists(public_path('assets/files/' . $download->file))) {
            File::delete(public_path('assets/files/' . $download->file));
            Download::destroy($download->id);
        } else {
            dd('File does not exists.');
        }
        return redirect('/admin/download')->with('status', 'Data Berhasil Dihapus');
    }
}
