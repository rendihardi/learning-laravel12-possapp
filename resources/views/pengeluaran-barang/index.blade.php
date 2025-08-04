@extends('layouts.app')

@section('content_title', 'Pengeluaran Barang')

@section('content')
    <div class="card">
        <x-alert :errors="$errors" />
        <form action="{{ route('pengeluaran-barang.store') }}" method="POST" id="formPengeluaranBarang">
            @csrf
            <div id="inputHiden"></div>
            <div class="d-flex justify-content-between align-items-center p-3">
                <h3 class="card-title">List of Pengeluaran Barang</h3>

            </div class="w-50">
            <div class="card-body">

                <div class="d-flex ">
                    <div class="w-100">
                        <label for="select2">Select Product</label>
                        <select name="select2" id="select2" class="form-control">
                        </select>
                    </div>
                    <div>
                        <label for="current_stock">Current Stock</label>
                        <input type="number" id="current_stock" class="form-control mx-2" style="width: 100px;" readonly>
                    </div>
                    <div>
                        <label for="qty">Qty</label>
                        <input type="number" id="qty" class="form-control" min="1"></label>
                    </div>
                    <div>
                        <label for="harga_jual">Harga Jual</label>
                        <input type="number" id="harga_jual" class="form-control" min="0" style="width: 300px"
                            readonly>
                    </div>
                    <div style="padding-top: 32px;" class="ml-2">
                        <button type="button" class="btn btn-dark" id="tambah">Tambah</button>
                    </div>
                </div>
            </div>

    </div>

    <div class="card-header">
        <h3 class="card-title">List of Pengeluaran Barang</h3>
    </div>
    <div class="row">
        <div class="col-8">
            <fiv class="card">
                <div class="card-body">
                    <table id="tableProduct" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Harga Jual</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- This section will be dynamically filled with JavaScript -->
                        </tbody>
                    </table>
                </div>
            </fiv>
        </div>
        <div class="card">
            <div class="card-body">
                <div>
                    <label for="totalBayar">Total Bayar</label>
                    <input type="number" id="totalBayar" class="form-control" readonly>
                </div>
                <div>
                    <label for="kembalian">Kembalian</label>
                    <input type="number" id="kembalian" class="form-control" readonly></label>
                </div>
                <div>
                    <label for="Bayar">Bayar</label>
                    <input type="number" id="bayar" name="bayar" class="form-control"></label>
                </div>
                <div class="">
                    <button type="submit" class="btn btn-primary w-100 mt-2"> Simpan Tranasaksi</button>
                </div>

            </div>

        </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2 for any select elements if needed
            let selectedProduct = {};

            function hitungTotalBayar() {
                let total = 0;
                $('#tableProduct tbody tr').each(function() {
                    const subTotalBayar = parseInt($(this).find('td:eq(4)').text()) || 0;
                    total += subTotalBayar;
                });
                $('#totalBayar').val(total);
            }


            $('#select2').select2({
                theme: 'bootstrap',
                placeholder: 'Select an product',
                ajax: {
                    url: '{{ route('get-data.products') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term // search term
                        };
                    },
                    processResults: function(data) {
                        data.forEach(item => {
                            selectedProduct[item.id] = item;
                        });
                        return {
                            results: data.map(item => ({
                                id: item.id,
                                text: item.name_product
                            }))
                        };
                    },
                    cache: true
                },
                minimumInputLength: 3,
            });
            $('#select2').on('change', function(e) {
                let id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('get-data.cek-stok') }}",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#current_stock').val(response);
                    }
                });
                $.ajax({
                    type: "GET",
                    url: "{{ route('get-data.cek-harga') }}",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#harga_jual').val(response);
                    }
                });
            });

            $('#tambah').on('click', function(e) {
                const selectedId = $('#select2').val();
                const qty = parseInt($('#qty').val());
                const currentStock = parseInt($('#current_stock').val());
                const hargaJual = parseInt($('#harga_jual').val());
                const subtotal = qty * hargaJual;
                if (!selectedId || !qty || !hargaJual) {
                    alert('harap isi semua field');
                    return;
                }
                // Hitung total qty produk yang sudah ada di tabel
                let totalQtySementara = qty;
                $('#tableProduct tbody tr').each(function() {
                    const rowProductId = $(this).data('id');
                    if (rowProductId == selectedId) {
                        const existingQty = parseInt($(this).find('td:eq(2)').text());
                        totalQtySementara += existingQty;
                    }
                });

                // Bandingkan total qty sementara dengan stok
                if (totalQtySementara > currentStock) {
                    alert('Jumlah pengeluaran barang melebihi stok yang tersedia');
                    return;
                }


                let exist = false;
                const products = selectedProduct[selectedId];

                $('#tableProduct tbody tr').each(function() {
                    const rowProductName = $(this).find('td:eq(1)').text();

                    if (rowProductName === products.name_product) {
                        const currentQty = parseInt($(this).find('td:eq(2)').text()); // kolom Qty
                        const newQty = currentQty + parseInt(qty);
                        const newSubtotal = newQty * hargaJual;

                        $(this).find('td:eq(2)').text(newQty); // update qty
                        $(this).find('td:eq(4)').parseInt(newSubtotal)
                        exist = true;
                        return false; // Break the loop
                    }
                });
                if (!exist) {
                    const row = `
                    <tr data-id="${products.id}">
                        <td>${$('#tableProduct tbody tr').length + 1}</td>
                        <td>${products.name_product}</td>
                        <td>${qty}</td>
                        <td>${hargaJual}</td>
                        <td>${subtotal}</td>
                        <td>
                            <button class="btn btn-danger btn-sm btn-remove" id="btn-remove">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                    $('#tableProduct tbody').append(row);
                }
                $('#select2').val(null).trigger('change');
                $('#qty').val('');
                $('#current_stock').val('');
                $('#harga_jual').val('');
                hitungTotalBayar();
            });
            $('#tableProduct').on('click', '.btn-remove', function() {
                $(this).closest('tr').remove();
                hitungTotalBayar();
            });

            $('#formPengeluaranBarang').on('submit', function() {
                $('#inputHiden').html("");
                $('#tableProduct tbody tr').each(function(index, row) {
                    const productName = $(row).find('td:eq(1)').text(); // Nama Produk
                    const qty = $(row).find('td:eq(2)').text(); // Qty
                    const hargaJual = $(row).find('td:eq(3)').text(); // Harga Jual
                    const subtotal = $(row).find('td:eq(4)').text(); // Subtotal
                    const productId = $(row).data('id'); // ambil id produk dari atribut data-id
                    const inputProduct =
                        `<input type="hidden" name="products[${index}][name_product]" value="${productName}">`;
                    const inputQty =
                        `<input type="hidden" name="products[${index}][qty]" value="${qty}">`;
                    const inputProductId =
                        `<input type="hidden" name="products[${index}][product_id]" value="${productId}">`;
                    const inputHargaJual =
                        `<input type="hidden" name="products[${index}][harga_jual]" value="${hargaJual}">`;
                    const inputSubtotal =
                        `<input type="hidden" name="products[${index}][subtotal]" value="${subtotal}">`;
                    $('#inputHiden').append(inputProduct + inputQty + inputProductId +
                        inputHargaJual + inputSubtotal);
                });
            });
            $("#bayar").on("input", function() {
                const total = parseInt($("#totalBayar").val()) || 0;
                const bayar = parseInt($("#bayar").val());
                const kembalian = bayar - total;
                $("#kembalian").val(kembalian);
            });
        });
    </script>
@endpush
