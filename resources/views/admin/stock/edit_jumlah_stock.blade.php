@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Form Edit Data Beras</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <form action="{{ Route('admin.jumlahstock.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="nama_beras" class="form-label">Beras :</label>
                                    <input type="text" name="nama_beras" value="{{ $merk }}"
                                        class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="berat" class="form-label">Berat
                                        :</label>
                                    <input type="number" name="berat" value="{{ $ukuran }}" class="form-control " readonly>

                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="jenis_beras" class="form-label">Jenis Beras :</label>
                                    <select class="form-select" id="jenis_beras"
                                        name="jenis_beras" aria-label="Default select example" required>
                                        <option>Pilih Jenis</option>
                                        @php
                                            $jenisBerasArray = [];
                                        @endphp

                                        @foreach ($total as $item)
                                            @if (!in_array($item->jenis_beras, $jenisBerasArray))
                                                <option value="{{ $item->jenis_beras }}">{{ $item->jenis_beras }}</option>
                                                @php
                                                    $jenisBerasArray[] = $item->jenis_beras;
                                                @endphp
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="grade_beras" class="form-label">Grade Beras :</label>
                                    <select class="form-select" id="grade_beras"
                                        name="grade_beras" aria-label="Default select example" required>
                                        <!-- menampilkan grade beras sesuai dengan jenis -->
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="harga" class="form-label">Harga :</label>
                                    <input type="number" name="harga" id="harga" 
                                        class="form-control @error('harga') is-invalid @enderror"
                                        placeholder="Harga beras..">
                                    <div class="text-danger">
                                        @error('harga')
                                            Harga tidak boleh kosong.
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="stock" class="form-label">JumlahTotal stock
                                        :</label>
                                        <input type="text" name="jumlah_stock" value="{{ $nilai }}"
                                        class="form-control @error('stock') is-invalid @enderror"
                                        placeholder="Jumlah stock.."disabled>
                                    <div class="text-danger">
                                        @error('stock')
                                            Jumlah stock tidak boleh kosong.
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="{{ route('admin.stockberas') }}" type="button" class="btn btn-warning"><i
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
        $(document).ready(function() {
            // Ketika jenis_beras berubah
            $('#jenis_beras').change(function() {
                var selectedJenis = $(this).val();

                // Hapus semua opsi grade_beras
                $('#grade_beras').empty();
                $('#grade_beras').append('<option>Pilih Grade</option>');

                // Tambahkan opsi grade_beras yang sesuai dengan jenis_beras yang dipilih
                @foreach ($total as $item)
                    @if ($item->jenis_beras)
                        if ("{{ $item->jenis_beras }}" === selectedJenis) {
                            $('#grade_beras').append('<option value="{{ $item->grade_beras }}" data-harga="{{ $item->harga }}" data-jenis="{{ $item->jenis_beras }}">{{ $item->grade_beras }}</option>');
                        }
                    @endif
                @endforeach
            });

            const selectgrade = document.getElementById('grade_beras');
            const inputHarga = document.getElementById('harga');

            selectgrade.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const price = selectedOption.getAttribute('data-harga');
                inputHarga.value = price;
            });
        });
    </script>
@endsection
