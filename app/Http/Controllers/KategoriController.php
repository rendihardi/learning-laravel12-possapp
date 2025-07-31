<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = kategori::all();
        confirmDelete('Hapus Data','Apakah anda yakin ingin menghapus kategori ini?', ' Hapus', 'Batal');
        return view('kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $id = $request->id;

        $request->validate([
            'nama_kategori' => 'required|unique:kategoris,nama_kategori,' . $id,
            'deskripsi' => 'required|max:255|min:10',
        ], [
            'nama_kategori.required' => 'Nama Kategori tidak boleh kosong',
            'nama_kategori.unique' => 'Nama Kategori sudah ada',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong',
            'deskripsi.max' => 'Deskripsi maksimal 100 karakter',
            'deskripsi.min' => 'Deskripsi minimal 10 karakter',
        ]);

        kategori::updateOrCreate(
            ['id' => $id],
            [
                'nama_kategori' => $request->nama_kategori,
                'slug' => Str::slug($request->nama_kategori),
                'deskripsi' => $request->deskripsi,
            ]
        );

        toast()->success('Kategori berhasil disimpan');

        return redirect()->route('master-data.kategori.index');
    }

    public function destroy(String $id)
    {
        $kategori = kategori::findOrFail($id);
        $kategori->delete();

        toast()->success('Kategori berhasil dihapus');

        return redirect()->route('master-data.kategori.index');
    }
}
