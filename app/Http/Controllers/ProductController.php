<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Kategori;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        confirmDelete('Hapus Data','Apakah anda yakin ingin menghapus produk ini?');
        return view('product.index', compact('products'));
    }
    // public function edit($id){
    //   $product = Product::findOrFail($id);
    // $kategori = Kategori::all();
    // return view('product.edit', compact('product', 'kategori'));
    // }
    public function store(Request $request){
         $id = $request->id;
        $request->validate([
           'name_product' => 'required|unique:products,name_product,' . $id,
            'harga_jual' => 'required|numeric|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'stok_minimal' => 'required|integer|min:0',
         
            'kategori_id' => 'required|exists:kategoris,id',
        ],[
            'name_product.required' => 'Nama Produk tidak boleh kosong',
            'harga_jual.required' => 'Harga Jual tidak boleh kosong',
            'harga_beli.required' => 'Harga Beli tidak boleh kosong',
            'stok.required' => 'Stok tidak boleh kosong',
            'stok_minimal.required' => 'Stok Minimal tidak boleh kosong',
            'is_active.required' => 'Status Aktif harus dipilih',
            'kategori_id.required' => 'Kategori harus dipilih',
            'kategori_id.exists' => 'Kategori tidak ditemukan',
        ]);

        $newRequest = [
            'id' => $id,
            'name_product' => $request->name_product,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $request->harga_beli,
            'stok' => $request->stok,
            'stok_minimal' => $request->stok_minimal,
            'is_active' => $request->is_active ? true : false,
            'kategori_id' => $request->kategori_id,
        ];
        if (!$id) {
            $newRequest['sku'] = Product::nomorSKU();
        }
        Product::updateOrCreate(['id'=>$id], $newRequest);            
        toast()->success('Produk berhasil disimpan');
        return redirect()->route('master-data.product.index');
    }
    public function destroy($id){
        $product = Product::findOrFail($id);
        $product->delete();
        toast()->success('Produk berhasil dihapus');
        return redirect()->route('master-data.product.index');
    }
}
