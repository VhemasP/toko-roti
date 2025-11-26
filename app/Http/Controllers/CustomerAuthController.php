<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    // Tampilkan Form Login (user_login.php)
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses Login (proses/login.php)
public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $inputType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $customer = Customer::where($inputType, $request->username)->first();

        if ($customer && Hash::check($request->password, $customer->password)) {
            session(['kode_customer' => $customer->kode_customer]);
            session(['nama' => $customer->nama]);
            
            return redirect()->route('home');
        }

        return back()->withErrors(['msg' => 'Username/Email atau Password salah']);
    }

    // Tampilkan Form Register (register.php)
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses Register (proses/register.php)
public function register(Request $request)
    {
        // Validasi
        $request->validate([
            'nama' => 'required',
            // Perbaikan: Ubah 'customers' jadi 'customer'
            'email' => 'required|email|unique:customer,email',
            'username' => 'required|unique:customer,username',
            'password' => 'required|confirmed', 
            'telp' => 'required',
        ]);

        // Generate Kode Customer (C000X)
        $lastCustomer = Customer::orderBy('kode_customer', 'desc')->first();
        $urutan = $lastCustomer ? (int)substr($lastCustomer->kode_customer, 1) + 1 : 1;
        $kode_baru = 'C' . sprintf("%04s", $urutan);

        Customer::create([
            'kode_customer' => $kode_baru,
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'telp' => $request->telp,
        ]);

        return redirect()->route('login.form')->with('success', 'Registrasi berhasil, silakan login');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('home');
    }
}