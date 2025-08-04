<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengeluaranBarang extends Model
{
    protected $guarded = ['id'];

    public static function noPengeluaran(){
     $maxId = self::max('id');
      $prefix = 'TRX-';
      $date = date('dmy');
     $noPengeluaran = $prefix . $date . str_pad($maxId + 1, 4, '0', STR_PAD_LEFT) ; // Padding the number to 5 digits
    return $noPengeluaran;
    }

     public function items()
    {
        return $this->hasMany(ItemPengeluaranBarang::class, 'no_pengeluaran', 'no_pengeluaran');
    }
}
