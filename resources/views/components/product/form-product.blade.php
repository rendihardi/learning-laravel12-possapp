<div>
    <button type="button" class="btn {{ $id ? 'btn-default' : 'btn-primary' }}" data-toggle="modal"
        data-target="#formProduct{{ $id ?? '' }}">
        {!! $id ? '<i class="fa fa-edit" style="color: blue;"></i>' : 'Tambah Produk' !!}
    </button>
</div>

<div class="modal fade" id="formProduct{{ $id ?? '' }}">
    <form action="{{ route('master-data.product.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $id ?? '' }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ $id ? 'Edit Produk' : 'Tambah Produk' }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group my-1">
                        <label for="">Nama Produk</label>
                        <input type="text" id="name_product" class="form-control" name="name_product"
                            value="{{ $id ? $name_product : old('name_product') ?? '' }}" required>
                    </div>
                    <div class="form-group my-1">
                        <label for="">Kategori Produk</label>
                        <select name="kategori_id" id='kategori_id' class="form-control">
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $kategoriItem)
                                <option value="{{ $kategoriItem->id }}"
                                    {{ old('kategori_id', $kategori_id ?? '') == $kategoriItem->id ? 'selected' : '' }}>
                                    {{ $kategoriItem->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="form-group my-1">
                        <label for="">SKU</label>
                        <input type="text" id="sku" class="form-control" name="sku"
                            value="{{ $id ? $sku : old('sku') ?? '' }}" required>
                    </div> --}}
                    <div class="form-group my-1">
                        <label for="">Harga Jual</label>
                        <input type="number" id="harga_jual" class="form-control" name="harga_jual"
                            value="{{ old('harga_jual', $harga_jual ?? '') }}" required>
                    </div>
                    <div class="form-group my-1">
                        <label for="">Harga Beli</label>
                        <input type="number" id="harga_beli" class="form-control" name="harga_beli"
                            value="{{ old('harga_beli', $harga_beli ?? '') }}" required>
                    </div>
                    <div class="form-group my-1">
                        <label for="">Stok</label>
                        <input type="number" id="stok" class="form-control" name="stok"
                            value="{{ old('stok', $stok ?? '') }}" required>
                    </div>
                    <div class="form-group my-1">
                        <label for="">Stok Minimal</label>
                        <input type="number" id="stok_minimal" class="form-control" name="stok_minimal"
                            value="{{ old('stok_minimal', $stok_minimal ?? '') }}" required>
                    </div>
                    <div class="form-group d-flex flex-column my-1 g-3">
                        <div class="d-flex align-items-center">
                            <label for="" class="mr-2">Produk Aktif ?</label>
                            <input type="checkbox" id="is_active" name="is_active"
                                {{ old('is_active', $is_active ?? false) ? 'checked' : '' }}>
                            Ya
                        </div>
                        <small class="text-secondary">jika produk aktif maka produk dapat dijual</small>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </form>
</div>
<!-- /.modal -->
