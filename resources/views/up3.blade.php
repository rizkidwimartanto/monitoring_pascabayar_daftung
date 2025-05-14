<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Monitoring Pascabayar UP3 Grobogan Tahun 2025</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="/monitoring_pascabayar_daftung/">SARPP UP3 Grobogan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/monitoring_pascabayar_daftung/administrator" id="up3">UP3</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/monitoring_pascabayar_daftung/" id="ulp">ULP</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <form action="{{ route('rekap-pascadaftung.store') }}" method="POST" class="mt-5">
        <div class="container mx-auto mt-5">
            <h2 class="text-center font-bold">Input Pascabayar UP3 Grobogan Tahun 2025</h2>
            @csrf
            <div class="mb-3">
                <label for="unit_ulp_pascabayar" class="form-label">Unit ULP</label>
                <select class="form-select" aria-label="Unit ULP" name="unit_ulp_pascabayar" id="unit_ulp_pascabayar">
                    <option selected disabled>Pilih Unit ULP</option>
                    <option value="ULP Demak">ULP Demak</option>
                    <option value="ULP Tegowanu">ULP Tegowanu</option>
                    <option value="ULP Purwodadi">ULP Purwodadi</option>
                    <option value="ULP Wirosari">ULP Wirosari</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="target_bulanan" class="form-label">Target Bulanan</label>
                <input type="text" class="form-control" id="target_bulanan" name="target_bulanan">
            </div>
            <div class="mb-3">
                <label for="target_mingguan" class="form-label">Target Mingguan</label>
                <input type="text" class="form-control" id="target_mingguan" name="target_mingguan">
            </div>
            <div class="mb-3">
                <label for="target_harian" class="form-label">Target Harian</label>
                <input type="text" class="form-control" id="target_harian" name="target_harian">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
    <div class="container">
        <h2 class="text-center font-bold mt-5">Monitoring Pascabayar UP3 Grobogan Tahun 2025</h2>
        <form method="GET" action="{{ route('rekap-pascadaftung.administrator') }}">
            <div class="row">
                <div class="col-6">
                    <label for="start_date" class="form-label">Filter Tanggal Data Awal</label>
                    <input type="date" name="start_date" id="start_date" class="form-control mb-3"
                        value="{{ request('start_date') }}">
                </div>
                <div class="col-6">
                    <label for="end_date" class="form-label">Filter Tanggal Data Akhir</label>
                    <input type="date" name="end_date" id="end_date" class="form-control mb-3"
                        value="{{ request('end_date') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-3" id="filter">Filter</button>
        </form>

        <table class="table table-hover table-bordered table-info mt-4">
            <tr>
                <th>Unit ULP Pascabayar</th>
                <th>Target Bulanan</th>
                <th>Target Mingguan</th>
                <th>Target Harian</th>
                <th>Realisasi</th>
                <th>Pencapaian</th>
                {{-- <th>Aksi</th> --}}
            </tr>
            @foreach ($data as $monitoring)
                <tr>
                    <td>{{ $monitoring->unit_ulp_pascabayar }}</td>
                    <td>{{ $monitoring->target_bulanan }}</td>
                    <td>{{ $monitoring->target_mingguan }}</td>
                    <td>{{ $monitoring->target_harian }}</td>
                    <td>
                        {{ $useGroup ? $monitoring->total_realisasi : $monitoring->realisasi }}
                    </td>
                    <td>
                        @php
                            $realisasi = $useGroup ? $monitoring->total_realisasi : $monitoring->realisasi;
                            $targetHarian = $monitoring->target_harian;
                        @endphp
                        {{ $targetHarian > 0 ? number_format(($realisasi / $targetHarian) * 100, 2, ',', '.') . '%' : '0%' }}
                    </td>

                    {{-- <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#{{ $monitoring->id }}">
                            Edit
                        </button>

                        <div class="modal fade" id="{{ $monitoring->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('rekap-pascadaftung.edit', $monitoring->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="target_bulanan" class="form-label">Target Carry
                                                    Over</label>
                                                <input type="text" class="form-control" id="target_bulanan"
                                                    name="target_bulanan" value="{{ $monitoring->target_bulanan }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="target_harian" class="form-label">Target Harian</label>
                                                <input type="text" class="form-control" id="target_harian"
                                                    name="target_harian" value="{{ $monitoring->target_harian }}">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td> --}}
                </tr>
            @endforeach
        </table>
    </div>
    {{-- <div class="container">
        <h2 class="text-center font-bold mt-5">Monitoring Daftung UP3 Grobogan Tahun 2025</h2>
        <table class="table table-hover table-bordered table-primary mt-4">
            <tr>
                <th>Unit ULP Daftung</th>
                <th>Daftung Pukul 08.00</th>
                <th>Daftung Pukul 13.00</th>
                <th>Jumlah Peremajaan</th>
            </tr>
            @foreach ($data as $monitoring)
                <tr>
                    <td>{{ $monitoring->unit_ulp_pascabayar }}</td>
                    <td>{{ $monitoring->cetak_pk_pagi }}</td>
                    <td>{{ $monitoring->cetak_pk_siang }}</td>
                    <td>{{ $monitoring->jumlah_peremajaan }}</td>
                </tr>
            @endforeach
        </table>
    </div> --}}
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'Oke'
            });
        </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
</body>

</html>
