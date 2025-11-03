<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query();
        $search = $request->input('search');

        // Logika Pencarian (sudah ada)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%')
                  ->orWhere('information', 'like', '%' . $search . '%')
                  // Tambahkan kolom lain jika perlu dicari juga
                  ->orWhere('unit', 'like', '%' . $search . '%')
                  ->orWhere('type', 'like', '%' . $search . '%')
                  ->orWhere('qty', 'like', '%' . $search . '%')
                  ->orWhere('producer', 'like', '%' . $search . '%');
            });
        }

        // --- [ BARU ] Logika Sorting ---
        $sortBy = $request->input('sort_by', 'id'); // Default sort by id
        $sortDir = $request->input('sort_dir', 'asc'); // Default sort direction ascending

        // Daftar kolom yang valid untuk sorting (keamanan)
        $validSortColumns = ['id', 'product_name', 'unit', 'type', 'information', 'qty', 'producer'];

        if (in_array($sortBy, $validSortColumns) && in_array($sortDir, ['asc', 'desc'])) {
            $query->orderBy($sortBy, $sortDir);
        }
        // --- Akhir [ BARU ] Logika Sorting ---

        // Pagination (sudah ada, tapi pastikan $search, $sortBy, $sortDir ditambahkan ke appends)
        $data = $query->paginate(5)->appends([
            'search' => $search,
            'sort_by' => $sortBy, // Tambahkan ini
            'sort_dir' => $sortDir   // Tambahkan ini
        ]);

        // Kirim data ke view (sertakan $sortBy dan $sortDir untuk menandai header aktif)
        return view('master-data.product-master.index-product', compact('data', 'sortBy', 'sortDir'));
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

        // // Simpan data (pastikan $fillable di model Product sudah diset)
        // Product::create($validatedData);

        // // Redirect kembali ke halaman index produk dengan pesan sukses
        // return redirect()->route('product-index')->with('success', 'Data produk berhasil ditambahkan.');

        try {
            Product::create($validatedData);
            // Jika berhasil, redirect ke index dengan pesan sukses
            return redirect()->route('product-index')->with('success', 'Produk baru berhasil ditambahkan!'); // 
    
        } catch (\Exception $e) {
            // Jika gagal, kembali ke form sebelumnya dengan pesan error dan input lama
            return redirect()->back()->with('error', 'Gagal menambahkan produk: ' . $e->getMessage())->withInput(); // 
        }
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

        // // Cari produk berdasarkan ID, jika tidak ditemukan akan error 404
        // $product = Product::findOrFail($id);

        // // Update data produk
        // $product->update($validatedData);

        // // Redirect kembali dengan pesan sukses
        // return redirect()->back()->with('success', 'Data produk berhasil diupdate.');

        try {
            $product = Product::findOrFail($id);
            $product->update($validatedData);
    
            return redirect()->route('product-index')->with('success', 'Data produk berhasil diupdate.'); // [cite: 15, 33]
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('product-index')->with('error', 'Produk tidak ditemukan.');
    
        } catch (\Exception $e) {
            // Jika gagal update karena alasan lain
            return redirect()->back()->with('error', 'Gagal mengupdate produk: ' . $e->getMessage())->withInput(); // 
        }
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

    public function exportExcel () {
        return Excel::download(new ProductsExport, 'daftar-produk.xlsx');
    }
}
