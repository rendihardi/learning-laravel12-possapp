<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenerimaanBarang extends Model
{
    protected $guarded = ['id'];

    public static function nomorPenerimaan(): string
    {
      $maxId = self::max('id');
      $prefix = 'PBR-';
      $date = date('dmy');
     $noPenerimaan = $prefix . $date . str_pad($maxId + 1, 4, '0', STR_PAD_LEFT) ; // Padding the number to 5 digits
    return $noPenerimaan;
    }

    public function items()
    {
        return $this->hasMany(ItemPenerimaanBarang::class, 'no_penerimaan', 'no_penerimaan');
    }
}
