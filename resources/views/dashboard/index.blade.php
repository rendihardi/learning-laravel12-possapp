@extends('layouts.app')
@section('content_title', 'Dashboard')
@section('content')
    <div class="row">
        <x-dashboard-card type="bg-info" icon="fas fa-users" label="Users" value="{{ $totalUser }}" />
        <x-dashboard-card type="bg-success" icon="fas fa-box" label="Products" value="{{ $totalProducts }}" />
        <x-dashboard-card type="bg-warning" icon="fas fa-shopping-basket" label="Transactions" value="{{ $totalOrder }}" />
        <x-dashboard-card type="bg-danger" icon="fas fa-money-check" label="Profits" value="{{ $totalPendapatan }}" />
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Transaksi Terakhir</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>No Transaksi</th>
                            <th>Jumlah Item</th>
                            <th>Subtotal</th>
                        </tr>
                        @foreach ($latestOrders as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->tanggal_transaksi }}</td>
                                <td>{{ $item->no_pengeluaran }}</td>
                                <td>{{ $item->items->count() }} <small>item</small></td>
                                <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Produk Terlaris</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Product</th>
                            <th>Qty</th>
                        </tr>
                        @foreach ($bestProducts as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->name_product }}</td>
                                <td>{{ $item->qty }} <small>pcs</small></td>
                            </tr>
                        @endforeach
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
      
    </div> --}}
@endsection
