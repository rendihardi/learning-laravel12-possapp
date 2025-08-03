@extends('layouts.app')

@section('content_title', 'Penerimaan Barang')

@section('content')
    <div class="card">
        <form action="{{ route('penerimaan-barang.store') }}" method="POST" id="formPenerimaanBarang">
            @csrf
            <div id="inputHiden"></div>
            <div class="d-flex justify-content-between align-items-center p-3">
                <h3 class="card-title">List of Penerimaan Barang</h3>
                <div class="">
                    <button type="submit" class="btn btn-primary"> Simpan Penerimaan Barang</button>
                </div>
            </div class="w-50">
            <div class="card-body">
                <div class="w-50">
                    <div class="form-group">
                        <label for="distributor">Distributor</label>
                        <input type="text" name="distributor" id="distributor" class="form-control"
                            placeholder="Masukkan nama distributor" value="{{ old('distributor') }}">
                        @error('distributor')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nomorFakur">Nomor Faktur</label>
                        <input type="text" name="nomorFaktur" id="nomorFaktur" class="form-control"
                            placeholder="Masukkan nomor faktur" value="{{ old('nomorFaktur') }}">
                        @error('nomorFaktur')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
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
                        <label for="harga_beli">Harga Beli</label>
                        <input type="number" id="harga_beli" class="form-control" min="0" style="width: 300px">
                    </div>
                    <div style="padding-top: 32px;" class="ml-2">
                        <button type="button" class="btn btn-dark" id="tambah">Tambah</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List of Penerimaan Barang</h3>
        </div>
        <div class="card-body">
            <table id="tableProduct" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Harga Beli</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- This section will be dynamically filled with JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2 for any select elements if needed
            let selectedProduct = {};
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
            });

            $('#tambah').on('click', function(e) {
                const selectedId = $('#select2').val();
                const qty = parseInt($('#qty').val());
                const currentStock = parseInt($('#current_stock').val());
                const hargaBeli = parseInt($('#harga_beli').val());
                const subtotal = qty * hargaBeli;
                if (!selectedId || !qty || !hargaBeli) {
                    alert('harap isi semua field');
                    return;
                }
                // if (qty > currentStock) {
                //     alert('Jumlah penerimaan barang melebihi stok yang tersedia');
                //     return;
                // }

                let exist = false;
                const products = selectedProduct[selectedId];
                $('#tableProduct tbody tr').each(function() {
                    const rowProduct = $(this).find('td:first').text();

                    if (rowProduct === products.name_product) {
                        const currentQty = parseInt($(this).find('td:eq(1)').text());
                        const newQty = currentQty + parseInt(qty);
                        $(this).find('td:eq(1)').text(newQty);
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
                        <td>${hargaBeli}</td>
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
                $('#harga_beli').val('');
            });
            $('#tableProduct').on('click', '.btn-remove', function() {
                $(this).closest('tr').remove();
            });

            $('#formPenerimaanBarang').on('submit', function() {
                $('#inputHiden').html("");
                $('#tableProduct tbody tr').each(function(index, row) {
                    const productName = $(row).find('td:eq(1)').text(); // Nama Produk
                    const qty = $(row).find('td:eq(2)').text(); // Qty
                    const hargaBeli = $(row).find('td:eq(3)').text(); // Harga Beli
                    const subtotal = $(row).find('td:eq(4)').text(); // Subtotal
                    const productId = $(row).data('id'); // ambil id produk dari atribut data-id
                    const inputProduct =
                        `<input type="hidden" name="products[${index}][name_product]" value="${productName}">`;
                    const inputQty =
                        `<input type="hidden" name="products[${index}][qty]" value="${qty}">`;
                    const inputProductId =
                        `<input type="hidden" name="products[${index}][product_id]" value="${productId}">`;
                    const inputHargaBeli =
                        `<input type="hidden" name="products[${index}][harga_beli]" value="${hargaBeli}">`;
                    const inputSubtotal =
                        `<input type="hidden" name="products[${index}][subtotal]" value="${subtotal}">`;
                    $('#inputHiden').append(inputProduct + inputQty + inputProductId +
                        inputHargaBeli + inputSubtotal);
                });
            });
        });
    </script>
@endpush
