<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Inisialisasi query builder untuk model Product
        $query = Product::query();

        // Cek apakah ada input pencarian dari pengguna
        if ($request->filled('search')) {
            $search = $request->input('search');

            // Filter produk berdasarkan nama atau informasi produk
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%')
                  ->orWhere('information', 'like', '%' . $search . '%');
            });
        }

        // Ambil data produk dengan paginasi dan pertahankan query search saat pagination
        $data = $query->paginate(5)->appends(['search' => $request->input('search')]);

        // Kirim data ke view (nama view disesuaikan agar konsisten)
        return view('master-data.product-master.index-product', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('master-data.product-master.create-product');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input data dari form
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'unit'         => 'required|string|max:50',
            'type'         => 'required|string|max:50',
            'information'  => 'nullable|string',
            'qty'          => 'required|integer|min:0',
            'producer'     => 'required|string|max:255',
        ]);

        // Simpan data (pastikan $fillable di model Product sudah diset)
        Product::create($validatedData);

        // Redirect kembali ke halaman index produk dengan pesan sukses
        return redirect()->route('product-index')->with('success', 'Data produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $product = Product::findOrFail($id);
        return view('master-data.product-master.detail-product', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $product = Product::findOrFail($id);
        return view('master-data.product-master.edit-product', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'unit'         => 'required|string|max:255',
            'type'         => 'required|string|max:255',
            'information'  => 'nullable|string',
            'qty'          => 'required|integer|min:1',
            'producer'     => 'required|string|max:255',
        ]);

        // Cari produk berdasarkan ID, jika tidak ditemukan akan error 404
        $product = Product::findOrFail($id);

        // Update data produk
        $product->update($validatedData);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data produk berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return redirect()->route('product-index')->with('success', 'Data produk berhasil dihapus.');
        }

        return redirect()->route('product-index')->with('error', 'Produk tidak ditemukan.');
    }
}
