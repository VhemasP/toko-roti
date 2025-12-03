<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // 1. Tampilkan Halaman Profil
    public function index()
    {
        $kode_cs = Session::get('kode_customer');
        
        $customer = Customer::where('kode_customer', $kode_cs)->firstOrFail();

        return view('profile.index', compact('customer'));
    }

    // 2. Proses Update Profil
    public function update(Request $request)
    {
        $kode_cs = Session::get('kode_customer');
        $customer = Customer::where('kode_customer', $kode_cs)->firstOrFail();

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'telp' => 'required',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $dataUpdate = [
            'nama' => $request->nama,
            'email' => $request->email,
            'telp' => $request->telp,
        ];

        if ($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->password);
        }

        $customer->update($dataUpdate);

        Session::put('nama', $request->nama);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}