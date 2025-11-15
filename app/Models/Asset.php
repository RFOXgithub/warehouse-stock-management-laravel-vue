<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'assets';
    protected $primaryKey = 'id';
    protected $fillable = ['kode', 'nama', 'satuan', 'stock_awal'];

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'asset_id');
    }
    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'asset_id');
    }
}
