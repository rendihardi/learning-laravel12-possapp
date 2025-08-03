@extends('layouts.app')
@section('content_title', 'Laporan Penerimaan Barang')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Laporan Penerimaan Barang</h3>
            <div class="card-body">
                <table class="table table-sm" id="table2">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Penerimaan</th>
                            <th>Nomor Faktur</th>
                            <th>Distributor</th>
                            <th>Petugas Penerima</th>
                            <th>Tanggal Penerimaan</th>
                            <th>opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penerimanBarang as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->no_penerimaan }}</td>
                                <td>{{ $item->no_faktur }}</td>
                                <td>{{ $item->distributor }}</td>
                                <td>{{ $item->petugas_penerima }}</td>
                                <td>{{ $item->tanggal_penerimaan }}</td>
                                <td>
                                    <a href="{{ route('laporan.penerimaan-barang.detail-laporan', $item->no_penerimaan) }}"
                                        class="btn btn-primary "><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
