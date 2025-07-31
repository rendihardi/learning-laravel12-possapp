<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name_product',
        'kategori_id',
        'sku',
        'harga_jual',
        'harga_beli',
        'stok',
        'stok_minimal',
        'is_active',
    ];

    public static function nomorSKU()
    {
        $prefix = 'SKU-';
        $maxId = self::max('id') ?? 0;
        $sku = $prefix . str_pad($maxId + 1, 5, '0', STR_PAD_LEFT); // Padding the SKU to 5 digits
        return $sku;
    }  
}
