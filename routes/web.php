<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\DownloadsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AcademicController;
use App\Http\Controllers\KesiswaanController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\VerificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route Visitor
Route::get('/', [VisitorController::class, 'home'])->name('home');
Route::get('/pencarian/', [VisitorController::class, 'search'])->name('search');
// Profile
Route::get('/profil/{slug}', [VisitorController::class, 'profile'])->name('profile');
// Route::get('/profil/visi-misi', [VisitorController::class, 'visi_misi'])->name('visi-misi');
// Route::get('/profil/sejarah', [VisitorController::class, 'sejarah'])->name('sejarah');
// Route::get('/profil/struktur-organisasi', [VisitorController::class, 'struktur_organisasi'])->name('struktur-organisasi');

//Berita
Route::get('/berita', [VisitorController::class, 'berita'])->name('News');
Route::get('/berita/{data:slug}', [VisitorController::class, 'show_berita'])->name('show-berita');
Route::get('/berita/kategori/{category:category}', [VisitorController::class, 'kategori_berita'])->name('kategori-berita');
// Route::get('/monografi', [VisitorController::class, 'monografi'])->name('Service');

//Galeri
Route::get('/galeri-foto', [VisitorController::class, 'galeri_foto'])->name('GalleryPhoto');
Route::get('/galeri-foto/{data:slug}', [VisitorController::class, 'show_foto'])->name('show-foto');
Route::get('/galeri-video', [VisitorController::class, 'galeri_video'])->name('GalleryVideo');

// Service
Route::get('/layanan/{slug}', [VisitorController::class, 'layanan'])->name('Service');

// Download
Route::get('/unduh/', [VisitorController::class, 'unduh'])->name('unduh');
Route::get('/unduh/{data:slug}', [VisitorController::class, 'show_unduh'])->name('show-unduh');

// Akademik
Route::get('/content/academic/upload/{FileUpload}/{mounth}/{year}/{slug}', [AcademicController::class, 'upload_show'])->name('academic.upload.show');
Route::get('/akademik/{year}/{mounth}/{tag}/{name}', [VisitorController::class, 'akademik'])->name('akademik');

// Kesiswaan
Route::get('/kesiswaan/{tag}', [VisitorController::class, 'kesiswaan'])->name('kesiswaan');
// Staff
Route::get('/staff/{category}', [VisitorController::class, 'staff'])->name('staff');

// End Route Visitor


// Register Route
Route::get('/register', [AuthController::class, 'register'])->name('register.index');
Route::post('/register-store', [AuthController::class, 'store_register'])->name('register.store');
// End Register Route

//Email Verification
/**
 * Verification Routes
 */
Route::get('/email/verify', function () {
    return view('login.notification');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/verified');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'Email verifikasi telah dikirim!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');


//End Email Verification

// Start Forget Password
Route::get('/forgot-password', function () {
    return view('login.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('login.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');
// End Forget Password

// Login Route
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/store-login', [AuthController::class, 'login'])->name('store-login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
// End Login Route


// Routes Admin
Route::middleware(['auth', 'checkRole:0,1', 'verified'])->group(function () {
    // Admin Home
    Route::get('/admin', [HomeController::class, 'index'])->name('beranda');

    Route::get('/verified', [UserController::class, 'verified']);

    // Admin Slider
    Route::get('/admin/slide', [InformationController::class, 'index'])->name('slide.index');
    Route::get('/admin/slide/create', [InformationController::class, 'create'])->name('slide.create');
    Route::post('/admin/slide', [InformationController::class, 'store'])->name('slide.store');
    Route::get('/admin/slide/{information}', [InformationController::class, 'show'])->name('slide.show');
    Route::get('/admin/slide/{information}/edit', [InformationController::class, 'edit'])->name('slide.edit');
    Route::patch('/admin/slide/{information}', [InformationController::class, 'update'])->name('slide.update');
    Route::delete('/admin/slide/{information}', [InformationController::class, 'destroy'])->name('slide.destroy');

    // Admin Profile
    Route::post('/admin/profile/categories', [ProfilesController::class, 'category_store'])->name('profile.categories.store');
    Route::delete('/admin/profile/categories/{category}', [ProfilesController::class, 'category_destroy'])->name('profile.categories.destroy');

    Route::get('/admin/profile', [ProfilesController::class, 'index'])->name('profile.index');
    Route::get('/admin/profile/create', [ProfilesController::class, 'create'])->name('profile.create');
    Route::post('/admin/profile', [ProfilesController::class, 'store'])->name('profile.store');
    Route::get('/admin/profile/{profile}', [ProfilesController::class, 'show'])->name('profile.show');
    Route::get('/admin/profile/{profile}/edit', [ProfilesController::class, 'edit'])->name('profile.edit');
    Route::patch('/admin/profile/{profile}', [ProfilesController::class, 'update'])->name('profile.update');
    Route::delete('/admin/profile/{profile}', [ProfilesController::class, 'destroy'])->name('profile.destroy');

    // News Category
    Route::get('/admin/news/category', [NewsController::class, 'category_index'])->name('category.index');
    Route::get('/admin/news/category/create', [NewsController::class, 'categoryCreate'])->name('category.create');
    Route::post('/admin/news/category', [NewsController::class, 'categoryStore'])->name('category.store');
    Route::delete('/admin/news/category/{category:id}', [NewsController::class, 'categoryDestroy'])->name('category.destroy');

    // Admin News
    Route::get('/admin/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/admin/news/publish/{news:slug}', [NewsController::class, 'publish'])->name('news.publish');
    Route::get('/admin/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/admin/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/admin/news/{news:slug}', [NewsController::class, 'show'])->name('news.edit');
    Route::get('/admin/news/{news:slug}/edit', [NewsController::class, 'edit'])->name('news.update');
    Route::patch('/admin/news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/admin/news/{news:slug}', [NewsController::class, 'destroy'])->name('news.destroy');


    // Admin Gallery
    Route::get('/admin/gallery', [GalleryController::class, 'index']);
    Route::get('/admin/gallery/create', [GalleryController::class, 'create']);
    Route::post('/admin/gallery', [GalleryController::class, 'store']);
    Route::get('/admin/gallery/{gallery:title}', [GalleryController::class, 'show']);
    // Route::get('/admin/gallery/{gallery:title}/edit', [GalleryController::class, 'edit']);
    // Route::patch('/admin/gallery/{gallery}', [GalleryController::class, 'update']);
    Route::delete('/admin/gallery/{gallery:title}', [GalleryController::class, 'destroy']);

    // Admin Service
    Route::post('/admin/service/categories', [ServicesController::class, 'category_store'])->name('service.categories.store');
    Route::delete('/admin/service/categories/{category}', [ServicesController::class, 'category_destroy'])->name('service.categories.destroy');

    Route::get('/admin/service', [ServicesController::class, 'index'])->name('service.index');
    Route::get('/admin/service/create', [ServicesController::class, 'create'])->name('service.create');
    Route::get('/admin/service/{service:slug}', [ServicesController::class, 'show'])->name('service.show');
    Route::post('/admin/service', [ServicesController::class, 'store'])->name('service.store');
    Route::get('/admin/service/{service:slug}/edit', [ServicesController::class, 'edit'])->name('service.edit');
    Route::patch('/admin/service/{service:slug}', [ServicesController::class, 'update'])->name('service.update');
    Route::delete('/admin/service/{service:slug}', [ServicesController::class, 'destroy'])->name('service.destroy');

    // Admin Download
    Route::get('/admin/download', [DownloadsController::class, 'index'])->name('download.index');
    Route::get('/admin/download/create', [DownloadsController::class, 'create']);
    Route::post('/admin/download', [DownloadsController::class, 'store']);
    Route::get('/admin/download/{download}', [DownloadsController::class, 'show']);
    Route::delete('/admin/download/{download}', [DownloadsController::class, 'destroy']);

    //Akademik
    Route::post('/admin/academic/categories', [AcademicController::class, 'category_store'])->name('academic.categories.store');
    Route::delete('/admin/academic/categories/{category}', [AcademicController::class, 'category_destroy'])->name('academic.categories.destroy');

    Route::get('/admin/academic/upload', [AcademicController::class, 'upload_index'])->name('academic.upload.index');
    Route::get('/admin/academic/upload/create', [AcademicController::class, 'upload_create'])->name('academic.upload.create');
    Route::post('/admin/academic/upload', [AcademicController::class, 'upload_store'])->name('academic.upload.store');
    Route::delete('/admin/academic/upload/{FileUpload}', [AcademicController::class, 'upload_destroy'])->name('academic.upload.destroy');

    Route::get('/admin/academic', [AcademicController::class, 'index'])->name('academic.index');
    Route::get('/admin/academic/create', [AcademicController::class, 'create'])->name('academic.create');
    Route::post('/admin/academic', [AcademicController::class, 'store'])->name('academic.store');
    Route::get('/admin/academic/{academic}', [AcademicController::class, 'show'])->name('academic.show');
    Route::get('/admin/academic/{academic}/edit', [AcademicController::class, 'edit'])->name('academic.edit');
    Route::patch('/admin/academic/{academic}', [AcademicController::class, 'update'])->name('academic.update');
    Route::delete('/admin/academic/{academic}', [AcademicController::class, 'destroy'])->name('academic.destroy');

    // Kesiswaan
    Route::post('/admin/kesiswaan/categories', [KesiswaanController::class, 'category_store'])->name('kesiswaan.categories.store');
    Route::delete('/admin/kesiswaan/categories/{category}', [KesiswaanController::class, 'category_destroy'])->name('kesiswaan.categories.destroy');

    Route::get('/admin/kesiswaan', [KesiswaanController::class, 'index'])->name('kesiswaan.index');
    Route::get('/admin/kesiswaan/create', [KesiswaanController::class, 'create'])->name('kesiswaan.create');
    Route::post('/admin/kesiswaan', [KesiswaanController::class, 'store'])->name('kesiswaan.store');
    Route::get('/admin/kesiswaan/{kesiswaan}', [KesiswaanController::class, 'show'])->name('kesiswaan.show');
    Route::get('/admin/kesiswaan/{kesiswaan}/edit', [KesiswaanController::class, 'edit'])->name('kesiswaan.edit');
    Route::patch('/admin/kesiswaan/{kesiswaan}', [KesiswaanController::class, 'update'])->name('kesiswaan.update');
    Route::delete('/admin/kesiswaan/{kesiswaan}', [KesiswaanController::class, 'destroy'])->name('kesiswaan.destroy');

    //Tenaga Pendidik
    Route::post('/admin/staff/categories', [StaffController::class, 'category_store'])->name('staff.categories.store');
    Route::delete('/admin/staff/categories/{category}', [StaffController::class, 'category_destroy'])->name('staff.categories.destroy');


    Route::get('/admin/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/admin/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/admin/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/admin/staff/{staff}', [StaffController::class, 'show'])->name('staff.show');
    Route::get('/admin/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::patch('/admin/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/admin/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');

    // Account Profile

    Route::get('/admin/user-profile/{user}', [UserController::class, 'account_profile'])->name('account.profile');
    Route::patch('/admin/user-profile/{user}', [UserController::class, 'account_profile_update'])->name('password.profile');
});
// End Route Admin

// Super Admin Route
Route::middleware(['auth', 'checkRole:0'])->group(function () {
    // Admin Account
    Route::get('/admin/account', [UserController::class, 'index'])->name('account.index');
    Route::get('/admin/account/create', [UserController::class, 'create'])->name('account.create');
    Route::post('/admin/account', [UserController::class, 'store'])->name('account.store');
    Route::delete('/admin/account/{user}', [UserController::class, 'destroy'])->name('account.destroy');
});
// End Super Admin Route
