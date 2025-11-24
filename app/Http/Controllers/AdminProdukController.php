<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\File;

class AdminProdukController extends Controller
{
    // 1. TAMPILKAN DAFTAR (Read)
    public function index()
    {
        $products = Produk::orderBy('kode_produk', 'desc')->get();
        return view('admin.produk.index', compact('products'));
    }

    // 2. TAMPILKAN FORM TAMBAH (Create)
    public function create()
    {
        // Generate Kode Produk Otomatis (P0001, P0002, dst)
        $lastProduk = Produk::orderBy('kode_produk', 'desc')->first();
        $urutan = $lastProduk ? (int)substr($lastProduk->kode_produk, 1) + 1 : 1;
        $kode_otomatis = 'P' . sprintf("%04s", $urutan);

        return view('admin.produk.create', compact('kode_otomatis'));
    }

    // 3. PROSES SIMPAN DATA (Store)
        public function store(Request $request)
        {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // A. Proses Ubah Gambar jadi Teks (Base64)
        $gambar_base64 = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            // Baca file dan ubah jadi base64 string
            $path = $file->getRealPath();
            $type = $file->getClientOriginalExtension();
            $data = file_get_contents($path);
            
            // Format: data:image/jpg;base64,.....kode_panjang....
            $gambar_base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        // B. Simpan ke Database (Langsung string gambarnya)
        Produk::create([
            'kode_produk' => $request->kode_produk,
            'nama' => $request->nama,
            'image' => $gambar_base64, // Simpan teks panjang ini
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil ditambahkan ke Database!');
    

        // B. Simpan ke Database
        Produk::create([
            'kode_produk' => $request->kode_produk,
            'nama' => $request->nama,
            'image' => $nama_gambar,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil ditambahkan!');
    }
    // 4. TAMPILKAN FORM EDIT
    public function edit($kode_produk)
    {
        // Cari produk berdasarkan kode
        $produk = Produk::where('kode_produk', $kode_produk)->firstOrFail();
        return view('admin.produk.edit', compact('produk'));
    }

    // 5. PROSES UPDATE DATA
    public function update(Request $request, $kode_produk)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Nullable: tidak wajib ganti gambar
        ]);

        $produk = Produk::where('kode_produk', $kode_produk)->firstOrFail();

        // Data yang akan diupdate
        $dataUpdate = [
            'nama' => $request->nama,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('image')) {
            
            $file = $request->file('image');
            $path = $file->getRealPath();
            $type = $file->getClientOriginalExtension();
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            
            $dataUpdate['image'] = $base64;
            
        }

        $produk->update($dataUpdate);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil diperbarui!');
    }
    // 6. PROSES HAPUS DATA
    public function destroy($kode_produk)
    {
        $produk = Produk::where('kode_produk', $kode_produk)->firstOrFail();

        // Cek apakah gambar produk ini berupa file biasa (bukan Base64)?
        // Jika iya, kita hapus filenya dari folder agar hemat penyimpanan.
        if (!str_contains($produk->image, 'base64')) {
            
            // Definisikan path gambar hanya jika bukan base64
            $pathGambar = public_path('image/produk/' . $produk->image);

            // Cek apakah file fisik ada di folder?
            if (file_exists($pathGambar)) {
                unlink($pathGambar); // Hapus file
            }
        }

        // Hapus data dari database
        $produk->delete();

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil dihapus!');
    }
}