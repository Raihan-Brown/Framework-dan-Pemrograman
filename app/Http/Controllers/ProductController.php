<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Model produkmu
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel; // Untuk Excel
use App\Exports\ProductsExport; // Untuk Excel

// Impor facade PDF
use Barryvdh\DomPDF\Facade\Pdf; 
// Impor Carbon untuk tanggal
use Carbon\Carbon;

class ProductController extends Controller
{

    /**
     * Menampilkan semua data produk
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'id');
        $sortDir = $request->input('sort_dir', 'asc');

        $data = Product::query()
            ->with('supplier')
            ->when($search, function ($query, $search) {
                return $query->where('product_name', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('producer', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDir)
            ->paginate(10);

            return view('Master-Data.Product-Master.index-product', compact('data', 'search', 'sortBy', 'sortDir'));
    }

    /**
     * Menampilkan form untuk membuat produk baru
     */
    public function create(): View
    {
        return view('Master-Data.Product-Master.create-product');
    }

    /**
     * Menyimpan produk baru ke database
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'information' => 'nullable|string',
            'qty' => 'required|integer',
            'producer' => 'nullable|string|max:255',
        ]);

        Product::create($request->all());

        return redirect()->route('product-index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail produk
     */
    public function show(string $id): View
    {
        $product = Product::findOrFail($id);
        return view('Master-Data.Product-Master.detail-product', ['product' => $product]);
    }

    /**
     * Menampilkan form untuk edit produk
     */
    public function edit(string $id): View
    {
        $product = Product::findOrFail($id);
        return view('Master-Data.Product-Master.edit-product', ['product' => $product]);
    }

    /**
     * Update produk di database
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'information' => 'nullable|string',
            'qty' => 'required|integer',
            'producer' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('product-index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk dari database
     */
    public function destroy(string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product-index')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Handle export to Excel.
     */
    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'daftar-produk.xlsx');
    }

    /**
     * Handle export Laporan Mutasi Stok ke PDF.
     */
    public function exportStockPdf()
    {
        // 1. Ambil SEMUA data produk dari database
        $products = Product::all();

        // 2. Siapkan data yang mau dikirim ke 'cetakan' PDF
        $data = [
            'startDate' => Carbon::parse('2021-10-01')->format('d/m/Y'),
            'endDate'   => Carbon::parse('2021-11-22')->format('d/m/Y'),
            'products'  => $products  // Kirim data object $products
        ];
        
        // 3. Panggil "cetakan" PDF (stock_mutation.blade.php) dan kirim datanya
        $pdf = Pdf::loadView('reports.stock_mutation', $data);

        // 4. Atur ukuran kertas & orientasi
        $pdf->setPaper('a4', 'landscape');

        // 5. Kirim sebagai file download ke browser
        return $pdf->download('rekap-mutasi-stock.pdf');
    }

} 