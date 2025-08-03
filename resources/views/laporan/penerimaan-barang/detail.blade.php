@extends('layouts.app')
@section('content_title', 'Laporan Penerimaan Barang')
@section('content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center p-3">
            <div>
                <div class="h4">PT. POS APP</div>
                <div class="h6">Detail Penerimaan Barang</div>
            </div>
            <div>
                <small>{{ $data->tanggal_penerimaan }}</small>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="d-flex align-content-center">
                        <h6 class="text-bold" style="width: 35%">Distributor</h6>
                        <p>{{ $data->distributor }}</p>
                    </div>
                    <div class="d-flex align-content-center">
                        <h6 class="text-bold " style="width: 35%">No Faktur</h6>
                        <p>{{ $data->no_faktur }}</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex align-content-center">
                        <h6 class="text-bold w-50">Petugas Penerima</h6>
                        <p>{{ $data->petugas_penerima }}</p>
                    </div>
                </div>

            </div>
            <div class="row">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Harga Beli</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->items as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detail->name_product }}</td>
                                <td>{{ number_format($detail->qty) }} <small>pcs</small></td>
                                <td>Rp. {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}</td>

                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-bold text-right">Total Pembelian</td>
                            <td class="text-bold">Rp. {{ number_format($data->total, 0, ',', '.') }}</td>
                        </tr>
            </div>
            </tbody>
            </table>
        </div>
    </div>
@endsection
