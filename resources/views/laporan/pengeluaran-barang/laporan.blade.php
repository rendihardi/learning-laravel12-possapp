@extends('layouts.app')
@section('content_title', 'Laporan Penjualan Barang')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">Laporan Penjualan</div>
        </div>
        <div class="card-body">
            <table class="table table-sm" id="table2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Transaksi</th>
                        <th>Tanggal Transaksi</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                        <th>Nama Petugas</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengeluaranBarang as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->no_pengeluaran }}</td>
                            <td>{{ $item->tanggal_pengeluaran }}</td>
                            <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                            <td>Rp. {{ number_format($item->bayar, 0, ',', '.') }}</td>
                            <td>Rp. {{ number_format($item->kembalian, 0, ',', '.') }}</td>
                            <td>{{ $item->nama_petugas }}</td>
                            <td>
                                <a href="{{ route('laporan.pengeluaran-barang.detail-laporan', $item->no_pengeluaran) }}"
                                    class="btn btn-primary "><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
