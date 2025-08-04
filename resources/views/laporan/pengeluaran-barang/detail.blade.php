@extends('layouts.app')
@section('content_title', 'Laporan pengeluaran Barang')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>TransaksiID : <span class="text-bold">{{ $data->no_pengeluaran }}</span></div>
                <div>Tanggal : <span class="text-bold">{{ $data->tanggal_pengeluaran }}</span></div>
            </div>
        </div>
        <div class="card-body">
            <div>
                <p>Petugas : <span class="text-bold">{{ $data->nama_petugas }}</span></p>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Harga Jual</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->items as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detail->name_product }}</td>
                                <td>{{ number_format($detail->qty) }} <small>pcs</small></td>
                                <td>Rp. {{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}</td>

                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-bold text-right">Total Pembelian</td>
                            <td class="text-bold">Rp. {{ number_format($data->total, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-bold text-right">Tunai</td>
                            <td class="text-bold">Rp. {{ number_format($data->bayar, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-bold text-right"> Kembalian</td>
                            <td class="text-bold">Rp. {{ number_format($data->kembalian, 0, ',', '.') }}</td>
                        </tr>
            </div>
        </div>
    </div>
    </tbody>
    </table>
    </div>
    </div>
@endsection
