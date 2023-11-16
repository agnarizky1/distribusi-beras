@extends('layouts.app')
@section('content')
<style>
    .select2-container {
        border: 1px solid #dce7f1;
        padding: 0.275rem 0.75rem;
        border-radius: 0.25rem;
    }

    .select2-container--default .select2-selection--single {
        border: 1px solid #fff;
    }

</style>

<div class="page-heading">
    <h3>Input Data Toko</h3>
</div>
<div class="page-content">


    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <form action="{{ Route('admin.toko.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="sales">Nama sales :</label>
                                <br>
                                <select class="form-select" id="sales" name="sales" required data-live-search="true">
                                    <option value="">Pilih Nama Sales</option>
                                    @foreach ($sales as $s)
                                    <option value="{{ $s->id_sales }}">
                                        {{ $s->nama_sales }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="text-danger">
                                    @error('sales')
                                    Nama sales tidak boleh kosong.
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="nama_toko" class="form-label">Nama toko :</label>
                                <input type="text" name="nama_toko" value="{{ old('nama_toko') }}"
                                    class="form-control @error('nama_toko') is-invalid @enderror"
                                    placeholder="Nama toko..">
                                <div class="text-danger">
                                    @error('nama_toko')
                                    Nama toko tidak boleh kosong.
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="pemilik">Nama pemilik :</label>
                                <input type="text" name="pemilik"
                                    class="form-control @error('pemilik') is-invalid @enderror"
                                    placeholder="Nama pemilik..">
                                <div class="text-danger">
                                    @error('pemilik')
                                    Nama pemilik tidak boleh kosong.
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="alamat">Alamat toko:</label>
                                <input type="text" name="alamat"
                                    class="form-control @error('alamat') is-invalid @enderror"
                                    placeholder="Nama alamat..">
                                <div class="text-danger">
                                    @error('alamat')
                                    Alamat tidak boleh kosong.
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="nomor_tlp">Nomor Telepon:</label>
                                <input type="text" name="nomor_tlp"
                                    class="form-control @error('nomor_tlp') is-invalid @enderror"
                                    placeholder="Nomor telepon..">
                                <div class="text-danger">
                                    @error('nomor_tlp')
                                    Nomor telepon tidak boleh kosong.
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="foto_ktp">Foto KTP:</label>
                                <input type="file" name="foto_ktp" accept="image/*"
                                    class="form-control @error('foto_ktp') is-invalid @enderror">
                                <div class="text-danger">
                                    @error('foto_ktp')
                                    Foto KTP tidak boleh kosong.
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="foto_toko">Foto Toko:</label>
                                <input type="file" name="foto_toko" accept="image/*"
                                    class="form-control @error('foto_toko') is-invalid @enderror">
                                <div class="text-danger">
                                    @error('foto_toko')
                                    Foto toko tidak boleh kosong.
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="modal-footer">
                            <a href="{{ route('admin.toko') }}" type="button" class="btn btn-warning"><i
                                    class='nav-icon fas fa-arrow-left'></i>
                                &nbsp;
                                Kembali</a>
                            <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i>
                                &nbsp;
                                Simpan</button>
                        </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
    const selecttoko = $('#sales');
    selecttoko.on('change', function () {
        const selectedOption = $(this).find('option:selected');

    });

</script>
@endsection
