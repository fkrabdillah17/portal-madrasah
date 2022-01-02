<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\News;
use App\Models\Category;
use App\Models\ContentCategory;
use App\Models\Profile;
use App\Models\Information;
use App\Models\Download;
use App\Models\Academic;
use App\Models\Staff;
use App\Models\Kesiswaan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class VisitorController extends Controller
{
    public function __construct()
    {
        //its just a dummy data object.
        $academics = Academic::all()->unique('tag');
        $news = News::latest()->take(4)->get();
        $news_category = Category::all();
        $kesiswaan = ContentCategory::where('category', 'Kesiswaan')->get();
        $staff = ContentCategory::where('category', 'Staff')->get();
        $layanan = Service::where('opsi', 'Deskripsi')->orderBy('title')->get();
        $link = Service::where('opsi', 'Link')->orderBy('title')->get();
        $data_profile = Profile::all();
        $profile = $data_profile->unique('tag');

        // Sharing is caring
        View::share('profile', $profile);
        View::share('academics', $academics);
        View::share('news', $news);
        View::share('news_category', $news_category);
        View::share('kesiswaan', $kesiswaan);
        View::share('staff', $staff);
        View::share('link', $link);
        View::share('layanan', $layanan);
    }

    public function home()
    {
        $slider = Information::all();
        $count = Information::all()->count();
        $news = News::all()->sortDesc()->take(3);
        $foto = Gallery::where('tag', 'Foto')->orderBy('created_at', 'desc')->get();
        $dataVideo = Gallery::where('tag', 'Video')->orderBy('created_at', 'desc')->get();
        $dataFoto = $foto->unique('title')->take(3);
        $video = $dataVideo->unique('title')->take(3);
        // dd($dataFoto);
        return view('user.index', [
            'slider' => $slider,
            'count' => $count,
            'news' => $news,
            'dataFoto' => $dataFoto,
            'video' => $video,
            'cekFoto' => $dataFoto->count(),
            'cekVideo' => $video->count()
        ]);
    }
    public function profile($slug)
    {
        $data_id = DB::table('content_categories')->where('slug', $slug)->value('id');
        $data = Profile::where('tag', $data_id)->get();
        return view('user.profile', [
            'data' => $data,
        ]);
    }
    public function visi_misi()
    {
        $data = Profile::where('tag', 'visimisi')->get();
        return view('user.visimisi', [
            'data' => $data,
        ]);
    }
    public function sejarah()
    {
        $data = Profile::where('tag', 'sejarah')->get();
        return view('user.sejarah', [
            'data' => $data,
        ]);
    }
    public function struktur_organisasi()
    {
        $data = Profile::where('tag', 'struktur')->get();
        return view('user.struktur', [
            'data' => $data,
        ]);
    }
    public function berita()
    {
        $data = News::latest()->paginate(5);
        return view('user.berita', [
            'data' => $data,
        ]);
    }
    public function show_berita(news $data)
    {
        return view('user.show_berita', [
            'data' => $data,
        ]);
    }
    public function kategori_berita(Category $category)
    {
        $data = News::where('category_id', $category->id)->paginate(5);
        $count = count($data);
        return view('user.kategori_berita', [
            'data' => $data,
            'count' => $count,
            'title' => $category->category
        ]);
    }
    public function galeri_foto()
    {
        $foto = Gallery::where('tag', 'Foto')->orderBy('created_at', 'asc')->get();
        $data = $foto->unique('title')->sortByDesc('created_at');
        // dd($data);
        return view('user.foto', [
            'data' => $data,
        ]);
    }
    public function show_foto(Gallery $data)
    {
        $foto = Gallery::where('title', $data->title)->orderBy('created_at', 'desc')->get();
        // dd($data);
        return view('user.show_foto', [
            'data' => $foto,
            'album' => $data->title,
            'content' => $data->content,
        ]);
    }
    public function galeri_video()
    {
        $data = Gallery::where('tag', 'Video')->latest()->paginate(6);
        return view('user.video', [
            'data' => $data,
        ]);
    }
    public function layanan($slug)
    {
        $data = [
            'content' => Service::where('slug', $slug)->get()
        ];
        return view('user.service', $data);
    }
    public function unduh()
    {
        $data = [
            'data' => Download::latest()->paginate(5),
        ];
        return view('user.list_unduh', $data);
    }
    public function show_unduh(Download $data)
    {
        $content = [
            'data' => $data,
        ];
        return view('user.show_unduh', $content);
    }

    public function akademik($year, $mounth, $tag, $name)
    {
        $data = Academic::where('tag', $tag)->get();
        $content = [
            'data' => $data,
        ];
        return view('user.show_akademik', $content);
    }
    public function staff($category)
    {
        $data_id = DB::table('content_categories')->where('slug', $category)->value('id');
        $data = Staff::where('category', $data_id)->paginate(10);
        // dd($data_id);
        $content = [
            'data' => $data,
        ];
        return view('user.show_staff', $content);
    }

    public function kesiswaan($tag)
    {
        $data_id = DB::table('content_categories')->where('slug', $tag)->value('id');
        $data = Kesiswaan::where('tag', $data_id)->get();
        $content = [
            'data' => $data,
        ];
        return view('user.show_kesiswaan', $content);
    }

    public function search(Request $request)
    {
        $rules = [
            'keyword' => 'required',
        ];
        $message = [
            'keyword.required' => 'Kolom Wajib Di isi !',
        ];
        $validate = $this->validate($request, $rules, $message);
        if ($validate) {
            $key = trim($request->keyword);

            $data = News::query()
                ->where('title', 'like', "%{$key}%")
                ->orWhere('content', 'like', "%{$key}%")
                ->orderBy('created_at', 'desc')
                ->get();
            $countdata = $data->count();

            return view('user.search', [
                'key' => $key,
                'data' => $data,
                'countdata' => $countdata
            ]);
        }
    }
}
