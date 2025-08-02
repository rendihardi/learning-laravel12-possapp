@extends('layouts.app')

@section('content_title', 'Penerimaan Barang')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List of Penerimaan Barang</h3>
        </div>
        <div class="card-body">
            <div class="d-flex ">
                <div class="w-100">
                    <label for="select2">Select Product</label>
                    <select name="select2" id="select2" class="form-control">
                    </select>
                </div>
                <div>
                    <label for="current_stock">Current Stock</label>
                    <input type="number" name="current_stock" id="current_stock" class="form-control mx-2"
                        style="width: 100px;" readonly>
                </div>
                <div>
                    <label for="qty">Qty</label>
                    <input type="number" name="qty" id="qty" class="form-control" min="1"></label>
                </div>
                <div style="padding-top: 32px;" class="ml-2">
                    <button class="btn btn-dark" id="tambah">Tambah</button>
                </div>
            </div>
        </div>
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
                if (!selectedId || !qty) {
                    alert('harap isi semua field');
                    return;
                }
                if (qty > currentStock) {
                    alert('Jumlah penerimaan barang melebihi stok yang tersedia');
                    return;
                }
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
                    <tr>
                        <td>${$('#tableProduct tbody tr').length + 1}</td>
                        <td>${products.name_product}</td>
                        <td>${qty}</td>
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
            });
            $('#tableProduct').on('click', '.btn-remove', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
@endpush
