<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    // Tampilkan Form Login Admin
    public function showLogin()
    {
        return view('admin.login');
    }

    // Proses Login Admin
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cek username di tabel admin
        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            // Set Session Admin
            Session::put('admin_logged_in', true);
            Session::put('admin_id', $admin->id);
            Session::put('admin_username', $admin->username);

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['msg' => 'Username atau Password Admin salah']);
    }

    // Logout Admin
    public function logout()
    {
        Session::forget(['admin_logged_in', 'admin_id', 'admin_username']);
        return redirect()->route('admin.login');
    }
}