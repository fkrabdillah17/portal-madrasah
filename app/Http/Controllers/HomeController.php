<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Download;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        return view('admin.home.index', [
            'title' => 'Beranda',
            'user' => User::all()->count(),
            'news' => News::all()->count(),
            'gallery' => Gallery::all()->count(),
            'download' => Download::all()->count(),
        ]);
    }
}
