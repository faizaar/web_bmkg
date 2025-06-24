<!-- <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Selamat Datang di Dashboard BMKG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" /> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f4f6f9;
        color: #333;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f4f6f9;
        color: #333;
    }

    .section-header {
        background: linear-gradient(135deg, #003973, #E5E5BE);
        /* kalem dan modern */
        color: white;
        padding: 80px 0;
        border-bottom-left-radius: 25px;
        border-bottom-right-radius: 25px;
    }

    .section-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
    }

    .section-header p {
        font-size: 1rem;
        color: #f8f8f8;
    }

    .icon-circle {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-light-orange {
        background-color: #fff3e0;
    }

    .text-orange {
        color: #ff9800;
    }

    .bg-light-red {
        background-color: #ffebee;
    }

    .bg-light-blue {
        background-color: #e3f2fd;
    }

    .bg-light-yellow {
        background-color: #fffde7;
    }

    .berita-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .btn-outline-primary {
        border-color: #003973;
        color: #003973;
    }

    .btn-outline-primary:hover {
        background-color: #003973;
        color: #fff;
    }

    footer {
        background-color: #003973;
        color: #fff;
        padding: 30px 0;
        text-align: center;
    }

    footer a {
        color: #ffffff;
        text-decoration: underline;
    }

    @media (max-width: 767.98px) {
        .section-header h1 {
            font-size: 1.8rem;
        }
    }
    .card p{
        white-space: normal !important;
        word-break: break-word;
    }
</style>
</head>

<body>
    <!-- Hero -->
    <section class="section-header text-center">
        <div class="container">
            <h1 class="fw-bold">Selamat Datang!</h1>
            <p class="lead">Pantau data cuaca, suhu, gempa, dan layanan publik secara real-time wilayah Malang.</p>
        </div>
    </section>
    <section class="statistik-harian py-5 mb-5">
        <div class="container">
            <h3 class="fw-bold text-dark mb-4 text-center">Statistik Harian</h3>
            <div id="statistikCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <div class="row justify-content-center g-4">
                            <!-- Kartu 1: Sambaran Petir -->
                            <div class="col-6 col-md-3 col-lg-2">
                                <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                                    <div class="icon-circle bg-light-orange mb-3 mx-auto">
                                        <i class="fas fa-bolt fa-lg text-orange"></i> <!-- Ikon petir -->
                                    </div>
                                    <h5 class="fw-bold mb-1">1.827</h5>
                                    <p class="text-secondary small mb-0">Total Sambaran Petir</p>
                                </div>
                            </div>
                            <!-- Kartu 2: Tekanan Udara -->
                            <div class="col-6 col-md-3 col-lg-2">
                                <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                                    <div class="icon-circle bg-light-blue mb-3 mx-auto">
                                        <i class="fas fa-tachometer-alt fa-lg text-info"></i>
                                        <!-- Ikon tekanan udara -->
                                    </div>
                                    <h5 class="fw-bold mb-1"><?= esc($tekanan) ?> hPa</h5>
                                    <p class="text-secondary small mb-0">Tekanan Udara</p>

                                    <?php if (!empty($lastUpdateTekanan)): ?>
                                    <p class="text-secondary small mb-0" style="font-style: italic;">
                                    <?= date('d M Y', strtotime($lastUpdateTekanan)) ?>
                                    </p>
                                    <?php endif; ?>

                                </div>

                            <!-- Kartu 3: Curah Hujan -->
                            </div>
                            <div class="col-6 col-md-3 col-lg-2">
                                <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                                    <div class="icon-circle bg-light-blue mb-3 mx-auto">
                                        <i class="fas fa-cloud-rain fa-lg text-primary"></i>
                                    </div>
                                    <h5 class="fw-bold mb-1"><?= esc($curah_hujan) ?> mm</h5>
                                    <p class="text-secondary small mb-0">Curah Hujan</p>
                                    <?php if (!empty($lastUpdateHujan)): ?>
                                    <p class="text-secondary small mb-0" style="font-style: italic;">
                                     <?= date('d M Y', strtotime($lastUpdateHujan)) ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                           
                 <!-- KARTU GEMPA (3) -->
                 <div class="col-6 col-md-3 col-lg-2 d-flex align-items-stretch">
                 <?php foreach ($dataGempa as $item): ?>
                    <div class="card shadow-sm border-0 rounded-4 text-center p-3 h-100 w-100" style="max-width: 250px; margin: 0 auto;">
                     <div class="icon-circle bg-light-red mb-3 mx-auto">
                      <i class="fas fa-wave-square fa-lg text-danger"></i>
                 </div>
            <h5 class="fw-bold mb-1"><?= esc($item['Magnitudo']) ?> SR</h5>
            <!-- <p class="text-secondary small mb-0">Gempa</p> -->
            <p class="text-secondary small mb-0 text-wrap" style="font-size: 12px; white-space: normal;">
                <?= esc($item['Keterangan']) ?>
            </p>
            <?php if (!empty($lastUpdateGempa)): ?>
                <p class="text-secondary small mb-0 mt-1" style="font-style: italic;">
                    <?= date('d M Y', strtotime($lastUpdateGempa)) ?>
                     </p>
                <?php endif; ?>
                 </div>
            <?php endforeach; ?>
         </div>

         
                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-12 col-lg-8">
                                    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                                        <div class="d-flex align-items-center mb-3">
                                            <!-- <div class="bg-warning-subtle rounded-circle d-flex justify-content-center align-items-center me-3"
                                                style="width: 40px; height: 40px;">
                                                <i class="fas fa-sun text-warning fa-lg"></i>
                                            </div> -->
                                            <h5 class="mb-0 fw-semibold text-dark">Terbit & Tenggelam — Beberapa Wilayah
                                            </h5>
                                        </div>
                                        <?php if (!empty($lastUpdate)): ?>
                                            <p class="text-muted" style="font-style: italic;">
                                                Data terbit & tenggelam terakhir:
                                                <?= date('d M Y', strtotime($lastUpdate)) ?>
                                            </p>
                                        <?php endif; ?>
                                        <div class="row row-cols-2 row-cols-md-4 g-3 text-dark"
                                            style="font-size: 14px;">
                                            <?php foreach ($dataTerbit as $item): ?>
                                                <div class="col">
                                                    <div class="bg-light rounded-3 px-2 py-2 d-flex align-items-center">
                                                        <i class="fas fa-sun text-warning me-2"></i>
                                                        <div>
                                                            <strong><?= esc($item['kecamatan']) ?></strong><br>
                                                            <small class="text-muted">
                                                                <?= date('H:i', strtotime($item['waktu_terbit'])) ?> –
                                                                <?= date('H:i', strtotime($item['waktu_tenggelam'])) ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Berita Kegiatan -->
    <section class="py-5 mt-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark">Berita Kegiatan & Pengumuman</h2>
                <p class="text-muted" style="color:rgb(0, 43, 86) !important;">Informasi terbaru dari kegiatan dan
                    pengamatan yang dilakukan oleh BMKG.</p>
            </div>
            <div>
                <!-- Tab Berita & Pengumuman -->
                <div class="mb-4 d-flex justify-content-center">
                    <ul class="nav nav-pills gap-2" id="beritaTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="btn btn-outline-birutua rounded-pill px-4 py-2 active" id="berita-tab"
                                data-bs-toggle="pill" href="#berita" role="tab" aria-controls="berita"
                                aria-selected="true">
                                Berita Baru
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="btn btn-outline-birutua rounded-pill px-4 py-2" id="pengumuman-tab"
                                data-bs-toggle="pill" href="#pengumuman" role="tab" aria-controls="pengumuman"
                                aria-selected="false">
                                Pengumuman
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content" id="beritaTabContent">
                <div class="tab-pane fade show active" id="berita" role="tabpanel" aria-labelledby="berita-tab">
                    <div class="row">
                        <?php
                        $ada_pengumuman = false;
                        foreach ($berita as $item):
                            if ($item['kategori'] == 'Berita Kegiatan'):
                                $ada_pengumuman = true;
                                ?>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <a href="<?= base_url('user/berita/' . $item['id_berita']) ?>"
                                        class="text-decoration-none text-dark">
                                        <div class="card h-100 shadow border-0 rounded-4 overflow-hidden">
                                            <img src="<?= base_url('/uploads/berita/' . $item['gambar']) ?>" class="berita-img"
                                                alt="Gambar Berita">
                                            <div class="card-body">
                                                <h5 class="card-title fw-semibold"><?= esc($item['judul']) ?></h5>
                                                <p class="text-muted small">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    <?= date('d M Y', strtotime($item['tanggal'])) ?>
                                                </p>
                                                <p class="card-text">
                                                    <?= esc(substr(strip_tags($item['isi']), 0, 90)) ?>...
                                                </p>
                                                <a href="<?= base_url('user/berita/' . $item['id_berita']) ?>"
                                                    class="btn btn-outline-primary rounded-pill btn-sm mt-3 mb-3">
                                                    Baca Selengkapnya <i class="fas fa-chevron-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; endforeach; ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="pengumuman" role="tabpanel" aria-labelledby="pengumuman-tab">
                    <!-- Isi pengumuman di sini -->
                    <div class="row">
                        <?php
                        $ada_pengumuman = false;
                        foreach ($berita as $item):
                            if ($item['kategori'] == 'Pengumuman'):
                                $ada_pengumuman = true;
                                ?>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <a href="<?= base_url('user/berita/' . $item['id_berita']) ?>"
                                        class="text-decoration-none text-dark">
                                        <div class="card h-100 shadow border-0 rounded-4 overflow-hidden">
                                            <img src="<?= base_url('/uploads/berita/' . $item['gambar']) ?>" class="berita-img"
                                                alt="Gambar Berita">
                                            <div class="card-body">
                                                <h5 class="card-title fw-semibold"><?= esc($item['judul']) ?></h5>
                                                <p class="text-muted small">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    <?= date('d M Y', strtotime($item['tanggal'])) ?>
                                                </p>
                                                <p class="card-text">
                                                    <?= esc(substr(strip_tags($item['isi']), 0, 90)) ?>...
                                                </p>
                                                <a href="<?= base_url('user/berita/' . $item['id_berita']) ?>"
                                                    class="btn btn-outline-primary rounded-pill btn-sm mt-3 mb-3">
                                                    Baca Selengkapnya <i class="fas fa-chevron-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; endforeach; ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- HijriJS Library -->
    <script src="https://cdn.jsdelivr.net/gh/xsoh/Hijri.js/hijri.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>