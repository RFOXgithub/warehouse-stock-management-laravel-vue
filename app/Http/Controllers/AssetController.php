<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::all();
        return response()->json($assets);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:assets,kode',
            'nama' => 'required',
            'satuan' => 'required',
            'stock_awal' => 'required|numeric|min:0',
        ]);


        $asset = Asset::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'satuan' => $request->satuan,
            'stock_awal' => $request->stock_awal,
        ]);

        return response()->json($asset, 201);
    }

    public function destroy($id)
    {
        $asset = Asset::find($id);
        if (!$asset) {
            return response()->json(['message' => 'Asset tidak ditemukan'], 404);
        }
        $asset->delete();
        return response()->json(['message' => 'Asset berhasil dihapus']);
    }
}
