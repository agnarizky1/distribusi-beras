@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h3>Pengembalian</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Form pengembalian: </h4>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('distribution') }}" class="btn btn-primary">
                                    Kembali
                                </a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p>Dari toko: </p>
                                <p>Tanggal pengembalian : </p>
                            </div>
                            {{-- <div class="col-md-6">
                                <p>Tanggal pengembalian : {{ $distribusi->tanggal_distribusi }}</p>
                                <p>Jumlah Keseluruhan Distribusi: {{ $distribusi->jumlah_distribusi }} KG</p>
                                <p>Total Harga: {{ $distribusi->total_harga }}</p>
                            </div> --}}
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">

                            </div>
                            <div class="text-end">
                                <a href="#" class="btn btn-primary btn-sm">Simpan</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
