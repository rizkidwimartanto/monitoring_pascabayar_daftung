<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="{{ asset('public/img/Logo_PLN.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Input Pascabayar UP3 Grobogan Tahun 2025</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg" style="background: #08B1F0">
        <div class="container">
            <a class="navbar-brand text-light" href="/monitoring_pascabayar_daftung/">SARPP UP3 Grobogan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="/monitoring_pascabayar_daftung/administrator"
                            id="up3">UP3</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="/monitoring_pascabayar_daftung/" id="ulp">ULP</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <form action="{{ route('rekap-pascadaftung.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="container mx-auto mt-5">
            <h2 class="text-center font-bold">Input Pascabayar UP3 Grobogan Tahun 2025</h2>
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
                <input type="text" class="form-control" id="target_bulanan" name="target_bulanan" disabled>
            </div>
            <div class="mb-3">
                <label for="target_mingguan" class="form-label">Target Mingguan</label>
                <input type="text" class="form-control" id="target_mingguan" name="target_mingguan" disabled>
            </div>
            <div class="mb-3">
                <label for="target_harian" class="form-label">Target Harian</label>
                <input type="text" class="form-control" id="target_harian" name="target_harian" disabled>
            </div>
            <div class="mb-3">
                <label for="realisasi" class="form-label">Realisasi</label>
                <input type="text" class="form-control" id="realisasi" name="realisasi">
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-success mb-4" type="submit">Submit</button>
            </div>
        </div>
    </form>
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
    <script>
        const dataTarget = @json($targets);

        const unitPascabayarSelect = document.getElementById('unit_ulp_pascabayar');
        const unitDaftungSelect = document.getElementById('unit_ulp_daftung');
        const targetBulanan = document.getElementById('target_bulanan');
        const targetMingguan = document.getElementById('target_mingguan');
        const targetHarian = document.getElementById('target_harian');

        unitPascabayarSelect.addEventListener('change', function() {
            const selectedUnit = this.value;

            if (dataTarget[selectedUnit]) {
                targetBulanan.value = dataTarget[selectedUnit].bulanan;
                targetMingguan.value = dataTarget[selectedUnit].mingguan;
                targetHarian.value = dataTarget[selectedUnit].harian;
            } else {
                targetBulanan.value = '';
                targetMingguan.value = '';
                targetHarian.value = '';
            }

            unitDaftungSelect.value = selectedUnit;
        });
    </script>
    <script src="{{ asset('public/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
</body>

</html>
