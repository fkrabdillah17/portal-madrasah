<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;




class AuthController extends Controller
{
    public function index()
    {
        if (Auth::user() != null) {
            return redirect()->route('beranda');
        } else {
            return view('login.index');
        }
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|string|email|exists:users',
            'password' => 'required|string'
        ];

        $message = [
            'email.required' => 'Email harus diisi!',
            'email.exists' => 'Email tidak terdaftar!',
            'password.required' => 'Password harus diisi!',
        ];

        $validate = $this->validate($request, $rules, $message);
        // dd($request->all());
        if ($validate) {
            $check = User::where('email', $request->email)->value('role');
            // dd($check);
            if (Auth::attempt($request->only('email', 'password'))) {
                if ($check == 0 || $check == 1) {
                    return redirect()->route('beranda')->with('sukses', 'Selamat datang di Menu Admin');
                }
            } else {
                return redirect()->route('login')->with('status', 'Periksa kembali email atau password anda!');
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    public function register()
    {
        return view('login.register');
    }
    public function store_register(Request $request)
    {

        $check = DB::table('users')->where('role', 0)->count();
        // dd($check);
        if ($check == 0) {
            // $request->validate([
            //     'name' => 'required',
            //     'username' => 'required|unique:users,username|min:8',
            //     'password' => 'required|confirmed|min:8',
            // ]);
            // $slug = Str::of($request->name . ' ' . $request->username)->slug('-');
            // // dd($slug);
            // $account = new user;
            // $account->role = $request->role;
            // $account->name = $request->name;
            // $account->slug = $slug;
            // $account->username = $request->username;
            // $account->password = Hash::make($request->password);
            // $account->remember_token = Str::random(60);
            // $account->save();
            // return redirect('/register')->with('status', 'Akun Berhasil di Buat');

            $rules = [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
            ];

            $message = [
                'name.required' => 'Nama lengkap harus diisi!',
                'email.required' => 'Email address harus diisi!',
                'email.unique' => 'Email sudah terdaftar!',
                'password.required' => 'Password harus diisi!',
                'password.min' => 'Password minimal 8 karakter!',
                'password.confirmed' => 'Password tidak sama dengan konfirmasi password!'
            ];

            $validate = $this->validate($request, $rules, $message);

            if ($validate) {
                //Save data
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                    'role' => 0,
                ]);
                //End Save
                event(new Registered($user));

                Auth::login($user);

                return redirect()->route('verification.notice')->with('status', 'Pengguna berhasil didaftarkan!');
            }
        } else {
            return redirect()->route('register.index')->with('gagal', 'Register Akun Hanya bisa Dilakukan satu Kali');
        }
    }
}
