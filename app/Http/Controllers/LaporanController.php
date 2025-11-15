<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->query('start');
        $end   = $request->query('end');   

        $assets = Asset::with(['barangMasuk', 'barangKeluar'])->get();

        $assets->transform(function ($asset) use ($start, $end) {
            $totalMasuk = $asset->barangMasuk()
                ->when($start && $end, fn($q) => $q->whereBetween('tanggal', [$start, $end]))
                ->sum('jumlah');

            $totalKeluar = $asset->barangKeluar()
                ->when($start && $end, fn($q) => $q->whereBetween('tanggal', [$start, $end]))
                ->sum('jumlah');

            $asset->total_masuk = $totalMasuk;
            $asset->total_keluar = $totalKeluar;
            $asset->stok_akhir = $asset->stock_awal + $totalMasuk - $totalKeluar;

            return $asset;
        });

        return response()->json($assets);
    }
}
