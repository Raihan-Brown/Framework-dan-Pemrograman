<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductsExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Contracts\View\View
    */
    public function view(): View
    {
        $products = Product::all();

        return view('exports.products', [
            'products' => $products
        ]);
    }
}