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
        <h3>Form Edit Data Toko</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <form action="{{ Route('admin.toko.update', $toko->id_toko) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="sales" class="form-label">Sales:</label>
                                <br>
                                <select class="form-select" id="sales" name="sales" required
                                    data-live-search="true">
                                    <option value="{{ $toko->sales }}">{{ $toko->sales }}</option>
                                    @foreach ($sales as $s)
                                    <option value="{{ $s->nama_sales }}">
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
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="foto_toko" class="form-label">Foto Toko:</label>
                                    <input type="file" name="foto_toko"
                                        class="form-control @error('foto_toko') is-invalid @enderror">
                                    <div class="text-danger">
                                        @error('foto_toko')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                    @if ($toko->foto_toko)
                                        <img src="{{ asset('uploads/toko/' . $toko->foto_toko) }}" alt="Foto Toko" style="height: auto; max-width: 400px;"
                                            class="img-fluid mt-2">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="foto_ktp" class="form-label">Foto KTP:</label>
                                    <input type="file" name="foto_ktp"
                                        class="form-control @error('foto_ktp') is-invalid @enderror">
                                    <div class="text-danger">
                                        @error('foto_ktp')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                    @if ($toko->foto_ktp)
                                        <img src="{{ asset('uploads/ktp/' . $toko->foto_ktp) }}" alt="Foto KTP" style="height: auto; max-width: 400px;"
                                            class="img-fluid mt-2">
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="nama_toko" class="form-label">Nama toko :</label>
                                    <input type="text" name="nama_toko" value="{{ $toko->nama_toko }}"
                                        class="form-control @error('nama_toko') is-invalid @enderror"
                                        placeholder="Nama toko.." disabled>
                                    <div class="text-danger">
                                        @error('nama_toko')
                                            Nama toko tidak boleh kosong.
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="pemilik" class="form-label">Nama Pemilik :</label>
                                    <input type="text" name="pemilik" value="{{ $toko->pemilik }}"
                                        class="form-control @error('pemilik') is-invalid @enderror"
                                        placeholder="Nama pemilik.." disabled>
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
                                    <input type="text" name="alamat" value="{{ $toko->alamat }}"
                                        class="form-control @error('alamat') is-invalid @enderror"
                                        placeholder="Nama alamat.." disabled>
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
                                    <input type="text" name="nomor_tlp" value="{{ $toko->nomor_tlp }}"
                                        class="form-control @error('nomor_tlp') is-invalid @enderror"
                                        placeholder="Nomor telepon..">
                                    <div class="text-danger">
                                        @error('nomor_tlp')
                                            Nomor telepon tidak boleh kosong.
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-end">
                                <a href="{{ route('admin.toko') }}" type="button" class="btn btn-warning"><i
                                        class='nav-icon fas fa-arrow-left'></i> &nbsp;
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
            $(document).ready(function () {
                 $('#sales').select2({
                });
            });
    </script>
@endsection
