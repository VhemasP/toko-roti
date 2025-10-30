<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;

class AuthController extends Controller
{
    // --- Menampilkan Halaman ---

    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    public function showRegisterForm()
    {
        return view('auth.register'); 
    }

    // --- Proses Register Customer ---

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:customer,email',
            'username' => 'required|string|max:100|unique:customer,username',
            'password' => 'required|string|min:6|confirmed',
            'telp' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $lastCustomer = Customer::orderBy('kode_customer', 'desc')->first();
        $newKode = 'C0001';
        if ($lastCustomer) {
            $lastKode = $lastCustomer->kode_customer;
            $newKode = 'C' . str_pad((int)substr($lastKode, 1) + 1, 4, '0', STR_PAD_LEFT);
        }

        $customer = Customer::create([
            'kode_customer' => $newKode,
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'telp' => $request->telp,
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.dashboard');
    }

    // --- Proses Login (Bisa Admin / Customer) ---

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        // Coba login sebagai ADMIN dulu
        // Penting: Di tabel admin, nama kolomnya 'username'
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        // Jika GAGAL, coba login sebagai CUSTOMER
        // Penting: Di tabel customer, nama kolomnya juga 'username'
        if (Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('customer.dashboard'));
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    // --- Proses Logout ---

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('customer')->check()) {
            Auth::guard('customer')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}