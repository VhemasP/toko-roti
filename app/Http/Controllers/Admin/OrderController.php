<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produksi;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Produksi::orderBy('tanggal', 'desc')->get();

        return view('admin.orders.index', compact('orders'));
    }
}