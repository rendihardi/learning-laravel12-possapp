<?php

namespace App\Http\Controllers;

use App\Models\PengeluaranBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ItemPengeluaranBarang;
use App\Models\Product;
use Carbon\Carbon;

class PengeluaranBarangController extends Controller
{
    public function index()
    {
        return view('pengeluaran-barang.index');
    }

    public function  store(Request $request){
        if(empty($request->products)){
            toast()->error('Tidak ada produk yang dipilih');
            return redirect()->back();
        }
        $request->validate([
            'products'=>'required',
            'bayar'=>'required|numeric|min:1',

        ],[
            'products.required'=>'Produk tidak boleh kosong',
            'bayar.required'=>'Bayar tidak boleh kosong',
        ]);

        $products = collect($request->products);
        $bayar = $request->bayar;
        $total = $products->sum('subtotal');
        $kembalian = intval($bayar) - $total;
        if($bayar < $total){
            toast()->error('Uang tidak cukup');
            return redirect()->back()->withInput([
                'products' => $request->products,
                'bayar'=>$request->bayar,
                'total'=>$total,
                'kembalian'=>$kembalian,
            ]);
        }

       $PengeluaranBarang = PengeluaranBarang::create([
            'no_pengeluaran'=>PengeluaranBarang::noPengeluaran(),
            'nama_petugas'=>Auth::user()->name,
            'total'=>$total,
            'bayar'=>$bayar,
            'kembalian'=>$kembalian
        ]);
         
        foreach($products as $item){
            ItemPengeluaranBarang::create([
                'no_pengeluaran'=>$PengeluaranBarang->no_pengeluaran,
                'name_product'=>$item['name_product'],
                'qty'=>$item['qty'],
                'harga_jual'=>$item['harga_jual'],
                'subtotal'=>$item['subtotal'],
            ]);

            Product::where('id', $item['product_id'])->decrement('stok', $item['qty']);
        }
        toast()->success('Transaksi berhasil disimpan');
        return redirect()->route('laporan.pengeluaran-barang.detail-laporan', $PengeluaranBarang->no_pengeluaran);
    }

    public function laporan(){
        $pengeluaranBarang = PengeluaranBarang::orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item->tanggal_pengeluaran = Carbon::parse($item->created_at)->locale('id')->translatedFormat('l, d F Y');
            return $item;
        });
        
        return view('laporan.pengeluaran-barang.laporan',compact('pengeluaranBarang'));

    }

    public function detailLaporan($no_pengeluaran){
        $data = PengeluaranBarang::with('items')->where('no_pengeluaran', $no_pengeluaran)->first();
        $data->tanggal_pengeluaran = Carbon::parse($data->created_at)->locale('id')->translatedFormat('l, d F Y');
        $data->total=$data->items->sum('subtotal');
        return view('laporan.pengeluaran-barang.detail', compact('data'));
    }


}
