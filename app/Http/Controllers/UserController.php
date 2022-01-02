<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        return view('admin.account.index', [
            'title' => "Account",
            'user' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.account.create', [
            'title' => "Account"
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
        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email|string|unique',
        //     'password' => 'required|confirmed|min:8',
        // ]);

        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users,email|string|email',
            'password' => 'required|confirmed|min:8',
        ];
        $message = [
            'name.required' => 'Isi Nama Anda',
            'email.required' => 'Isi Email Anda',
            'email.unique' => 'Email Telah Terdaftar',
            'password.required' => 'Isi Password Anda',
            'password.min' => 'Password Minimal 8 Karakter',
            'password.confirmed' => 'Password Tidak Sama',
        ];
        $validate = $this->validate($request, $rules, $message);
        // End validasi

        if ($validate) {
            // Start Save Data
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 1,
                'remember_token' => Str::random(60),
            ]);

            event(new Registered($user));

            return redirect()->route('account.index')->with('status', 'Pengguna berhasil ditambahkan!');
        }

        // $account = new user;
        // $account->role = $request->role;
        // $account->name = $request->name;
        // $account->username = $request->username;
        // $account->password = Hash::make($request->password);
        // $account->remember_token = Str::random(60);
        // $account->save();
        // return redirect('/admin/account/')->with('status', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verified()
    {
        return view('login.verified');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.account.edit', [
            'title' => "Account",
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $ubah = User::findorfail($user->id);
        // dd($ubah->id);
        if ($request->password == null) {
            $dt = [
                'role' => $request->role,
                'name' => $request->name,
                'username' => $request->username,
            ];
        } else {
            $dt = [
                'role' => $request->role,
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ];
        }
        $ubah->update($dt);
        if (Auth::user()->role == '0') {
            return redirect('/admin/account')->with('status', 'Data Berhasil Diubah');
        } else {
            return redirect()->route('edit-profile', Auth::user()->id)->with('status', 'Data Berhasil Diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect('/admin/account')->with('status', 'Data Berhasil Dihapus');
    }

    public function account_profile(User $user)
    {
        // dd($user);
        if ($user->id == Auth::id()) {
            return view('admin.account.admin_index', [
                'title' => "Admin",
                'user' => $user
            ]);
        } else {
            return redirect()->back();
        }
    }
    public function account_profile_update(Request $request, User $user)
    {
        // dd($user);
        // dd($request->all());
        if ($user->id == Auth::id()) {
            $rules = [
                'old_password' => 'required',
                'password' => 'required|confirmed|min:8',
            ];
            $message = [
                'old_password.required' => 'Isi Password Anda',
                'password.required' => 'Isi Password Baru Anda',
                'password.min' => 'Password Baru Minimal 8 Karakter',
                'password.confirmed' => 'Password Baru Tidak Sama',
            ];
            $validate = $this->validate($request, $rules, $message);
            // End validasi
            //Check Password
            if (Hash::check($request->old_password, $user->password)) {
                if ($validate) {
                    // Start Save Data
                    $user->update([
                        'password' => Hash::make($request->password)
                    ]);

                    return redirect()->back()->with('status', 'Password berhasil diubah!');
                }
            } else {
                return redirect()->back()->with('warning', 'Password Lama Anda Salah');
            }
        } else {
            return redirect()->back();
        }
    }
}
