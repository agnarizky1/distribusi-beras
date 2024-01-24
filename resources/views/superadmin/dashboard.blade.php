@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon purple mb-2">
                                            <i class="fa-solid fa-wheat-awn"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Merk Beras</h6>
                                        <h6 class="font-extrabold mb-0">{{$merk->count()}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon blue mb-2">
                                        <i class="fa-solid fa-store"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Toko</h6>
                                        <h6 class="font-extrabold mb-0">{{$toko->count()}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-2">
                                            <i class="fa-solid fa-truck"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Distribusi</h6>
                                        <h6 class="font-extrabold mb-0">{{$distribusi->count()}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldUser"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">User</h6>
                                        <h6 class="font-extrabold mb-0">{{$user->count()}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body py-4 px-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl">
                                <img src="{{ asset('/src/assets/compiled/jpg/1.jpg') }}" alt="Face 1">
                            </div>
                            <div class="ms-3 name">
                                <h5 class="font-bold">{{ Auth::user()->name }}</h5>
                                <h6 class="text-muted mb-0">{{ Auth::user()->role }}</h6>
                                <ul class="nav nav-pills">
                                <a href="{{ route('logout') }}" type="button" class='sidebar-link btn btn-primary'>
                                    <span>Logout</span>
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </a>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Penjualan</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="berasChart"></canvas>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            var dataPenjualan = {!! json_encode($penjualan) !!};

            // Inisialisasi data untuk chart
            var labels = dataPenjualan.map(function(item) {
                return item.nama_beras;
            });

            var dataset = {
                label: 'Jumlah Terjual',
                data: dataPenjualan.map(function(item) {
                    return item.jumlah_beras;
                }),
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna latar belakang bar
                borderColor: 'rgba(75, 192, 192, 1)', // Warna garis batas bar
                borderWidth: 1 // Lebar garis batas bar
            };

            var maxDataValue = Math.max(...dataset.data);

            var config = {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [dataset]
                },
                options: {
                    scales: {
                        y: {
                            min: 11,
                            max: maxDataValue
                        }
                    }
                }
            };

            // Menggambar chart
            var ctx = document.getElementById('berasChart').getContext('2d');
            new Chart(ctx, config);
        });
    </script>

@endsection
