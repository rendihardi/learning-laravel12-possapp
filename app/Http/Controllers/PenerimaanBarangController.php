<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenerimaanBarangController extends Controller
{
    public function index()
    {
        // Logic to display the list of received goods
        return view('penerimaan-barang.index');
    }
}
