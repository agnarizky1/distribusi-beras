@extends('layouts.app')
@section('link')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="page-heading">
        <h3>Data Distribusi</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('distribution.add') }}" type="button" class="btn btn-primary">
                                <i class="fa-solid fa-folder-plus"></i> Tambah Data
                                Distribusi</a>
                        </div>
                        {{-- <div class="col-md-3">
                            <form action="/post">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="search" placeholder="search.."
                                        value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div> --}}
                        <div class="card-body">
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @elseif(session('hapus'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('hapus') }}
                                    </div>
                                @endif
                                <table id="tabel-distribusi" class="table table-bordered table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Kode Distribusi</th>
                                            <th>Nama Toko</th>
                                            <th>Nama Sopir</th>
                                            <th>Plat No.</th>
                                            <th>tgl Distribusi</th>
                                            <th>Total Berat(Kg)</th>
                                            <th>Total Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($distri as $d)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $d->kode_distribusi }}</td>
                                                <td>{{ $d->nama_toko }}</td>
                                                <td>{{ $d->nama_sopir }}</td>
                                                <td>{{ $d->plat_no }}</td>
                                                <td>{{ \Carbon\Carbon::parse($d->tanggal_distribusi)->format('d F Y') }}
                                                </td>
                                                <td class="text-center">{{ $d->jumlah_distribusi }} Kg</td>
                                                <td>
                                                    {{ $d->total_harga }}
                                                    <br>
                                                    @if ($pembayaranTotals[$d->id_distribusi] >= $d->total_harga)
                                                        <span class="text-success">Lunas</span>
                                                    @else
                                                        <span class="text-danger">Sisa Bayar:
                                                            {{ $d->total_harga - $pembayaranTotals[$d->id_distribusi] }}</span>
                                                    @endif
                                                </td>
                                                @if (Auth::user()->role == 'superadmin')
                                                    <td>
                                                        <a href="{{ route('distribution.show', $d->id_distribusi) }}"
                                                            class="btn btn-warning btn-sm">
                                                            <i class="fa fa-regular fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('distribution.destroy', $d->id_distribusi) }}"
                                                            class="btn btn-danger btn-sm"><i class="fa fa-trash-can"></i>
                                                        </a>
                                                        <a href="{{ route('distribution.destroy', $d->id_distribusi) }}"
                                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
                                                        </a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    {{-- <script type="text/javascript">
        $(document).ready(function() {
            $('#tabel-distribusi').DataTable();
        });
    </script> --}}
    <script type="text/javascript">
        $(function() {
            $("#tabel-distribusi").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
