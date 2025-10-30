<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk; // Import Model Produk
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk mengelola file/gambar

class ProductController extends Controller
{
    /**
     * READ: Menampilkan semua produk
     */
    public function index()
    {
        $products = Produk::all(); // Ambil semua data dari tabel produk
        return view('admin.products.index', compact('products')); // Kirim data ke view
    }

    /**
     * CREATE: Menampilkan form untuk membuat produk baru
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * STORE: Menyimpan produk baru ke database
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'kode_produk' => 'required|string|max:100|unique:produk,kode_produk',
            'nama' => 'required|string|max:100',
            'harga' => 'required|integer',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar opsional
        ]);

        $data = $request->all();

        // Cek jika ada file gambar diupload
        if ($image = $request->file('image')) {
            // Simpan gambar ke folder 'public/images'
            // Nama file akan unik berdasarkan waktu upload
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $data['image'] = $imageName; // Simpan nama file ke database
        }

        Produk::create($data); // Simpan data ke tabel

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * EDIT: Menampilkan form untuk mengedit produk
     */
    public function edit(Produk $product) // Laravel akan otomatis mencari produk berdasarkan primary key
    {
        // Karena primary key kita 'kode_produk', kita perlu manual find
        // Tapi karena kita sudah bind di Route, $product sudah berisi data
        return view('admin.products.edit', compact('product'));
    }

    /**
     * UPDATE: Mengupdate produk di database
     */
    public function update(Request $request, Produk $product)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'harga' => 'required|integer',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($image = $request->file('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && Storage::exists('public/images/' . $product->image)) {
                Storage::delete('public/images/' . $product->image);
            }

            // Upload gambar baru
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $data['image'] = $imageName;
        } else {
            // Jika tidak ada gambar baru, jangan ubah data gambar lama
            unset($data['image']);
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * DELETE: Menghapus produk dari database
     */
    public function destroy(Produk $product)
    {
        // Hapus gambar dari storage
        if ($product->image && Storage::exists('public/images/' . $product->image)) {
            Storage::delete('public/images/' . $product->image);
        }

        $product->delete(); // Hapus data dari database

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil dihapus.');
    }
}