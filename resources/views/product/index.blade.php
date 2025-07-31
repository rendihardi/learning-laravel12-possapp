@extends('layouts.app')
@section('content_title', 'Data Products')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List of Products</h3>
            <div class="card-body">
                <div class="d-flex justify-content-end mb-2">
                    <x-product.form-product />
                </div>
                <x-alert :errors="$errors" />
                <table class="table table-sm" id="table2">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>SKU</th>
                            <th>Nama Produk</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stock</th>
                            <th>Aktif</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->name_product }}</td>
                                <td>Rp. {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($product->harga_beli, 0, ',', '.') }}</td>
                                <td>{{ number_format($product->stok, 0, ',', '.') }}</td>

                                <td>
                                    <p class="{{ $product->is_active ? 'badge bg-success' : 'badge bg-danger' }}">
                                        {{ $product->is_active ? 'Yes' : 'No' }}</p>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <x-product.form-product :id="$product->id" />
                                        <a href="{{ route('master-data.product.destroy', $product->id) }}"
                                            data-confirm-delete="true" class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
