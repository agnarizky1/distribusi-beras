@extends('layouts.app')
@section('content')

<div class="col-md-6">
    <label for="nama_toko">Nama Toko</label>
    <select class="form-select select2-hidden-accessible" id="nama_toko" name="nama_toko" required data-live-search="true">
        <option value="">Pilih Nama Toko</option>
        @foreach ($tokos as $toko)
        <option value="{{ $toko->id_toko }}" data-pemilik="{{ $toko->pemilik }}" data-alamat="{{ $toko->alamat }}">
            {{ $toko->nama_toko }}
        </option>
        @endforeach
    </select>
</div>

<div class="col-md-6">
    <label for="nama_toko">Nama Toko</label>
    <select class="form-select" id="inisial" name="nama_toko" required data-live-search="true">
        <option value="">Pilih Nama Toko</option>
        @foreach ($tokos as $toko)
        <option value="{{ $toko->id_toko }}" data-pemilik="{{ $toko->pemilik }}" data-alamat="{{ $toko->alamat }}">
            {{ $toko->nama_toko }}
        </option>
        @endforeach
    </select>
</div>

<script>
$(document).ready(function() {
    $('.select2').select2();

    $("#inisial").click(function(){


    })
});
</script>

@endsection