<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Http\RedirectResponse; // Tambahkan ini untuk tipografi modern Laravel
use Illuminate\View\View; // Tambahkan ini untuk tipografi modern Laravel

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data = Product::all();
        // Pastikan path view konsisten: Master-Data
        return view("Master-Data.Product-Master.index-product", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // KESALAHAN DITEMUKAN & DIPERBAIKI: Mengubah 'Master-data' menjadi 'Master-Data'
        return view("Master-Data.Product-Master.create-product");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input data dari form
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'information' => 'nullable|string',
            'qty' => 'required|integer',
            'producer' => 'required|string|max:255',
        ]);

        // Proses simpan data ke database
        Product::create($validatedData);

        // Redirect kembali ke halaman index produk dengan pesan sukses
        return redirect()->route('product.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('Master-Data.Product-Master.edit-product', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input dari form
        $request->validate([
            'product_name' => 'required|string|max:255',
            'unit'         => 'required|string|max:255',
            'type'         => 'required|string|max:255',
            'information'  => 'nullable|string',
            'qty'          => 'required|integer|min:1',
            'producer'     => 'required|string|max:255',
        ]);

        // Cari produk berdasarkan ID, jika tidak ditemukan akan error 404
        $product = Product::findOrFail($id);

        // Update data produk dengan data baru
        $product->update([
            'product_name' => $request->product_name,
            'unit'         => $request->unit,
            'type'         => $request->type,
            'information'  => $request->information,
            'qty'          => $request->qty,
            'producer'     => $request->producer,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
}
