<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    /**
     * Get the products for the supplier.
     */
    public function products()
    {
        // Relasi One-to-Many: Supplier (1) memiliki banyak Product (N)
        return $this->hasMany(Product::class);
    }
}