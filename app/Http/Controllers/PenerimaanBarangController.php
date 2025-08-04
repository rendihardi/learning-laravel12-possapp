<?php

namespace App\Http\Controllers;

use App\Models\PenerimaanBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ItemPenerimaanBarang;
use App\Models\Product;
use Carbon\Carbon;

class PenerimaanBarangController extends Controller
{
    public function index()
    {
        // Logic to display the list of received goods
        return view('penerimaan-barang.index');
    }
    public function store(Request $request)
    {
     
        $request->validate([
           'distributor' => 'required|string|max:255',
            'nomorFaktur' => 'required|unique:penerimaan_barangs,no_faktur|string|max:255',
            'products' => 'required',
       ],
            [
                'distributor.required' => 'Distributor is required.',
                'nomorFaktur.required' => 'Nomor Faktur is required.',
                'nomorFaktur.unique' => 'Nomor Faktur must be unique.',
                'products.required' => 'At least one product must be selected.',
            ]
        );

        $newDataPenerimaanBarang = PenerimaanBarang::create([
            'no_penerimaan' => PenerimaanBarang::nomorPenerimaan(), // Assuming you have a method to generate the SKU
            'no_faktur' => $request->nomorFaktur,
            'distributor' => $request->distributor,
            'petugas_penerima' => Auth::user()->name, // Assuming the user is authenticated
        ]);

        $products = $request->products;
        foreach ($products as $item) {
            ItemPenerimaanBarang::create([
                'no_penerimaan' => $newDataPenerimaanBarang->no_penerimaan,
                'name_product' => $item['name_product'],
                'qty' => $item['qty'],
                'harga_beli' => $item['harga_beli'],
                'subtotal' => $item['subtotal'],
            ]);

            Product::where('id', $item['product_id'])->increment('stok', $item['qty']);
        }
        toast()->success('Penerimaan Barang berhasil disimpan.');

        return redirect()->route('laporan.penerimaan-barang.detail-laporan', $newDataPenerimaanBarang->no_penerimaan);
    }

    public function laporan()
    {
        $penerimanBarang= PenerimaanBarang::orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item->tanggal_penerimaan = Carbon::parse($item->created_at)->locale('id')->translatedFormat('l, d F Y');            return $item;
        });
        // Logic to generate the report for received goods
        return view('laporan.penerimaan-barang.laporan',compact('penerimanBarang'));
    }

    public function detailLaporan($no_penerimaan)
    {
        $data = PenerimaanBarang::with('items')->where('no_penerimaan', $no_penerimaan)->first();
        $data->tanggal_penerimaan = Carbon::parse($data->created_at)->locale('id')->translatedFormat('l, d F Y');
        $data->total=$data->items->sum('subtotal');
        return view('laporan.penerimaan-barang.detail', compact('data'));
    }
    
}
