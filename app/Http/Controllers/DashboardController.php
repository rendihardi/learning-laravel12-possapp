<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ItemPengeluaranBarang;
use App\Models\PengeluaranBarang;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $totalUser = User::count();
        $totalProducts = Product::count();

        $totalOrder = PengeluaranBarang::whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();

        $totalPendapatan = PengeluaranBarang::whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->sum('total');

        $totalPendapatan = "Rp. " . number_format($totalPendapatan, 0, ',', '.');

        $latestOrders = PengeluaranBarang::latest()->take(5)->get()->map(function ($item) {
            $item->tanggal_transaksi = Carbon::parse($item->created_at)->locale('id')->translatedFormat('l, d F Y');
            return $item;
        });

        $bestProducts = ItemPengeluaranBarang::select('name_product')
        ->selectRaw('SUM(qty) as qty')
        ->whereMonth('created_at', $bulanIni)
        ->whereYear('created_at', $tahunIni)
        ->groupBy('name_product')
        ->orderBy('qty', 'desc')
        ->take(5)->get();

        return view('dashboard.index', compact(
            'totalUser',
            'totalProducts',
            'totalOrder',
            'totalPendapatan',
            'latestOrders',
            'bestProducts'
        ));
    }
}
