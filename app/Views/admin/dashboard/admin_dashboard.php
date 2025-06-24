<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <!-- Bootstrap & Volt Admin CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://themesberg.github.io/volt-bootstrap-5-dashboard/assets/css/volt.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

</head>

<body>
    <main class="content">
        <!-- Navbar -->
        <nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
            <div class="container-fluid px-0">
                <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
                    <div class="d-flex align-items-center">
                        <!-- Search form -->
                        <form class="navbar-search form-inline" id="navbar-search-main">
                            <div class="input-group input-group-merge search-bar">
                                <span class="input-group-text" id="topbar-addon">
                                    <i class="fa fa-search"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Search"
                                    aria-label="Search" aria-describedby="topbar-addon">
                            </div>
                        </form>
                    </div>
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="media d-flex align-items-center">
                                    <img class="avatar rounded-circle" alt="BMKG"
                                        src="<?= base_url('assets/img/team/bmkg.jpg') ?>">
                                    <div class="media-body ms-2 text-dark align-items-center d-none d-lg-block">
                                        <span class="mb-0 font-small fw-bold text-gray-900">Admin</span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <svg class="dropdown-icon text-danger me-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Content -->
<div class="container-fluid py-4">
    <div class="row">
        <?php
        $cards = [
            ['label' => 'Tekanan Udara', 'jumlah' => $jml_tekananudara, 'color' => 'primary', 'icon' => 'fa-tachometer-alt'],
            ['label' => 'Temperatur', 'jumlah' => $jml_temperatur, 'color' => 'danger', 'icon' => 'fa-temperature-high'],
            ['label' => 'Berita', 'jumlah' => $jml_berita, 'color' => 'info', 'icon' => 'fa-newspaper'],
            ['label' => 'Gambar Hilal', 'jumlah' => $jml_gambarhilal, 'color' => 'warning', 'icon' => 'fa-moon'],
            // ['label' => 'Gempa', 'jumlah' => $jml_gempa, 'color' => 'secondary', 'icon' => 'fa-wave-square'],
            ['label' => 'Login', 'jumlah' => $jml_login, 'color' => 'success', 'icon' => 'fa-user-lock'],
            ['label' => 'Pengamatan Hilal', 'jumlah' => $jml_pengamatanhilal, 'color' => 'dark', 'icon' => 'fa-binoculars'],
            ['label' => 'Petir', 'jumlah' => $jml_petir, 'color' => 'orange', 'icon' => 'fa-bolt'],
            ['label' => 'Terbit/Tenggelam', 'jumlah' => $jml_terbit, 'color' => 'teal', 'icon' => 'fa-sun'],
            ['label' => 'Pengamatan', 'jumlah' => $jml_pengamatan, 'color' => 'purple', 'icon' => 'fa-eye']
        ];
        ?>

        <?php foreach ($cards as $card): ?>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <i class="fa <?= $card['icon'] ?> fa-2x text-<?= $card['color'] ?>"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1"><?= $card['label'] ?></h6>
                            <h4 class="mb-0"><?= $card['jumlah'] ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Chart -->
    <div class="row mt-4">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">Diagram Jumlah Data per Tabel</h5>
                    <canvas id="dashboardChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('dashboardChart').getContext('2d');
    const dashboardChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                'Tekanan Udara', 'Temperatur', 'Berita', 'Gambar Hilal', 'Gempa',
                'Login', 'Pengamatan Hilal', 'Petir', 'Terbit/Tenggelam', 'Pengamatan'
            ],
            datasets: [{
                label: 'Jumlah Data',
                data: [
                    <?= $jml_tekananudara ?>,
                    <?= $jml_temperatur ?>,
                    <?= $jml_berita ?>,
                    <?= $jml_gambarhilal ?>,
                    <?= $jml_gempa ?>,
                    <?= $jml_login ?>,
                    <?= $jml_pengamatanhilal ?>,
                    <?= $jml_petir ?>,
                    <?= $jml_terbit ?>,
                    <?= $jml_pengamatan ?>
                ],
                backgroundColor: [
                    '#0d6efd', '#dc3545', '#0dcaf0', '#ffc107', '#6c757d',
                    '#198754', '#212529', '#fd7e14', '#20c997', '#6f42c1'
                ],
                borderColor: [
                    '#0a58ca', '#bb2d3b', '#31d2f2', '#ffca2c', '#5c636a',
                    '#157347', '#1c1f23', '#e8590c', '#198754', '#5f3690'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
</script>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
