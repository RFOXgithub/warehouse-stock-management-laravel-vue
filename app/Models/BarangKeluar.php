<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar';
    protected $fillable = ['asset_id', 'tanggal', 'jumlah', 'keterangan'];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
    
}
