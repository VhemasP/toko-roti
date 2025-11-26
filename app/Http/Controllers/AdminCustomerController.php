<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class AdminCustomerController extends Controller
{
    // 1. Tampilkan Daftar Customer
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customer.index', compact('customers'));
    }

    // 2. Hapus Customer
    public function destroy($kode_customer)
    {
        $customer = Customer::where('kode_customer', $kode_customer)->firstOrFail();
        $customer->delete();

        return redirect()->route('admin.customer')->with('success', 'Data customer berhasil dihapus!');
    }
}