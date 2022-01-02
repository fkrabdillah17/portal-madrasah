<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = Gallery::all()->unique('title');
        return view('admin.gallery.index', [
            'title' => "Gallery",
            'galleries' => $galleries
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gallery.create', [
            'title' => "Gallery",
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
        $validation = $request->tag;
        if ($validation == "Foto") {
            $request->validate([
                'tag' => 'required',
                'title' => 'required|unique:galleries,title',
                'editor' => 'required',
                'images' => 'required',
            ]);
        } else {
            $request->validate([
                'tag' => 'required',
                'title' => 'required|unique:galleries,title',
                'editor' => 'required',
                'video' => 'required',
            ]);
        }
        $slug = Str::of($request->title)->slug('-');
        if ($request->tag == "Video") {
            function getEmbedUrl($url)
            {
                // function for generating an embed link
                $finalUrl = '';

                if (strpos($url, 'facebook.com/') !== false) {
                    // Facebook Video
                    $finalUrl .= 'https://www.facebook.com/plugins/video.php?href=' . rawurlencode($url) . '&show_text=1&width=200';
                } else if (strpos($url, 'vimeo.com/') !== false) {
                    // Vimeo video
                    $videoId = isset(explode("vimeo.com/", $url)[1]) ? explode("vimeo.com/", $url)[1] : null;
                    if (strpos($videoId, '&') !== false) {
                        $videoId = explode("&", $videoId)[0];
                    }
                    $finalUrl .= 'https://player.vimeo.com/video/' . $videoId;
                } else if (strpos($url, 'youtube.com/') !== false) {
                    // Youtube video
                    $videoId = isset(explode("v=", $url)[1]) ? explode("v=", $url)[1] : null;
                    if (strpos($videoId, '&') !== false) {
                        $videoId = explode("&", $videoId)[0];
                    }
                    $finalUrl .= 'https://www.youtube.com/embed/' . $videoId;
                } else if (strpos($url, 'youtu.be/') !== false) {
                    // Youtube  video
                    $videoId = isset(explode("youtu.be/", $url)[1]) ? explode("youtu.be/", $url)[1] : null;
                    if (strpos($videoId, '&') !== false) {
                        $videoId = explode("&", $videoId)[0];
                    }
                    $finalUrl .= 'https://www.youtube.com/embed/' . $videoId;
                } else if (strpos($url, 'dailymotion.com/') !== false) {
                    // Dailymotion Video
                    $videoId = isset(explode("dailymotion.com/", $url)[1]) ? explode("dailymotion.com/", $url)[1] : null;
                    if (strpos($videoId, '&') !== false) {
                        $videoId = explode("&", $videoId)[0];
                    }
                    $finalUrl .= 'https://www.dailymotion.com/embed/' . $videoId;
                } else {
                    $finalUrl .= $url;
                }

                return $finalUrl;
            }
            $link = getEmbedUrl($request->video);
            // Save
            $gallery = new gallery;
            $gallery->slug = $slug;
            $gallery->tag = $request->tag;
            $gallery->title = $request->title;
            $gallery->content = $request->editor;
            $gallery->file = $link;
            $gallery->save();
            return redirect('/admin/gallery')->with('status', 'Data Berhasil Ditambahkan');
        } else {
            if ($request->hasfile('images')) {
                $images = $request->file('images');
                $slugs = Str::of($request->title)->slug('-');
                // dd($request->file('images'));
                $iteration = 0;
                foreach ($images as $image) {
                    if ($iteration == 0) {
                        $iteration = "";
                    }
                    // dd($image);
                    $name = time() . rand(100, 999) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('/assets/img/gallery'), $name);
                    Gallery::create([
                        'tag' => $request->tag,
                        'title' => $request->title,
                        'slug' => $slugs . $iteration,
                        'content' => $request->editor,
                        'file' => $name,
                    ]);
                    $iteration++;
                }
            }
            return redirect('/admin/gallery')->with('status', 'Data Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        $data = Gallery::where('title', $gallery->title)->get();
        // dd($data);
        return view('admin.gallery.show', [
            'title' => "Gallery",
            'data' => $data,
            'gallery' => $gallery
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', [
            'title' => "Gallery",
            'gallery' => $gallery
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        // dd($request->all());
        // Cek Judul
        if ($request->title != $request->oldTitle) {
            $title = 'required|unique:galleries,title';
        } else {
            $title = 'required';
        }
        $slug = Str::of($request->title)->slug('-');
        if ($request->tag == "Foto") {
            if ($request->hasFile('file')) {
                $request->validate([
                    'title' => $title,
                    'editor' => 'required',
                    'file' => 'required|image|mimes:jpeg,png,jpg|max:2020',
                ]);
                $ubah = Gallery::findorfail($gallery->id);
                $awal = $ubah->file;
                $dt = [
                    'file' => $awal,
                    'tag' => $request->tag,
                    'slug' => $slug,
                    'title' => $request->title,
                    'content' => $request->editor,
                ];
                $request->file->move(public_path() . '/assets/img/gallery', $awal);
                $ubah->update($dt);
            } else {
                $request->validate([
                    'title' => $title,
                    'editor' => 'required'
                ]);
                $ubah = Gallery::findorfail($gallery->id);
                $dt = [
                    'tag' => $request->tag,
                    'slug' => $slug,
                    'title' => $request->title,
                    'content' => $request->editor,
                ];
                $ubah->update($dt);
            }
        } else {
            $request->validate([
                'title' => $title,
                'editor' => 'required'
            ]);
            $ubah = Gallery::findorfail($gallery->id);
            $dt = [
                'tag' => $request->tag,
                'slug' => $slug,
                'file' => $request->video,
                'title' => $request->title,
                'content' => $request->editor,
            ];
            $ubah->update($dt);
        }
        return redirect('/admin/gallery')->with('status', 'Data Berhasil DiUbah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        if ($gallery->tag == "Foto") {
            // dd($gallery->title);
            $images = Gallery::where('title', $gallery->title)->get();
            // dd($images);
            foreach ($images as $file) {
                // dd($file);
                if (File::exists(public_path('assets/img/gallery/' . $file->file))) {
                    File::delete(public_path('assets/img/gallery/' . $file->file));
                    Gallery::destroy($file->id);
                } else {
                    return redirect('/admin/gallery')->with('status', 'Data Gagal Dihapus, File Tidak Ada');
                }
            }
        } else {
            Gallery::destroy($gallery->id);
        }


        return redirect('/admin/gallery')->with('status', 'Data Berhasil Dihapus');
    }
}
