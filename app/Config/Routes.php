<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::user_dashboard');
$routes->get('admin/login', 'Login::index');
$routes->post('admin/loginauth', 'Login::auth');
$routes->get('admin/logout', 'Login::logout');

// Grup untuk Admin Dasboard
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
});

// Grup untuk admin - Administrasi harus login
$routes->group('administrasi', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Administrasi::index');
    $routes->get('form', 'Administrasi::form_administrasi');
    $routes->get('edit/(:num)', 'Administrasi::form_update_administrasi/$1');
    $routes->post('save', 'Administrasi::save_administrasi');
    $routes->post('update/(:num)', 'Administrasi::update_administrasi/$1');
    $routes->get('delete/(:num)', 'Administrasi::delete_administrasi/$1');
    $routes->get('export', 'Administrasi::export_excel');
    $routes->post('upload', 'Administrasi::process_upload');
});

// Grup untuk admin - Buku Tamu harus login
$routes->group('buku_tamu',  function ($routes) {
    $routes->get('/', 'BukuTamu::index');                        // Tampilkan data buku tamu (admin/user tergantung view)
    $routes->get('export', 'BukuTamu::export_excel');           // Ekspor data ke Excel
    $routes->post('simpan', 'BukuTamu::simpan');                // Simpan data dari form buku tamu
});

// Grup untuk admin - Pengajuan Surat harus login
$routes->group('admin/pengajuan_surat', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'PengajuanSurat::index'); // Halaman utama pengajuan surat
    $routes->get('export', 'PengajuanSurat::export_excel'); // Ekspor data
    $routes->get('ubah_status/(:num)/(:segment)', 'PengajuanSurat::ubah_status/$1/$2'); // Ubah status surat
});

$routes->get('pengajuan_surat', 'PengajuanSurat::form');
$routes->post('admin/pengajuan_surat/ubah_status_ajax', 'PengajuanSurat::ubah_status_ajax');

// Grup untuk admin - Gempa harus login
$routes->group('Gempa', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Gempa::view_gempa');                      // Tampilkan semua data gempa
    $routes->get('gempa', 'Gempa::form');                         // Form tambah data gempa
    $routes->get('edit/(:num)', 'Gempa::form_update/$1');       // Form update data
    $routes->post('save', 'Gempa::save');                        // Simpan data baru
    $routes->post('update/(:num)', 'Gempa::update/$1');          // Update data
    $routes->get('delete/(:num)', 'Gempa::delete/$1');           // Hapus data
    $routes->post('upload', 'Gempa::upload');                    // Upload data dari file
    $routes->get('sync_from_api', 'Gempa::sync_from_api'); // ✅ route baru
});

// Grup untuk admin - Hilal harus login
$routes->group('hilal', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Home::hilal');                                  // Tampilan utama data hilal
    $routes->post('simpan', 'HilalController::simpan_hilal');          // Simpan data baru
    $routes->post('update/(:num)', 'HilalController::update_hilal/$1'); // Update data
    $routes->get('delete/(:num)', 'HilalController::delete_hilal/$1'); // Hapus data
    $routes->get('download', 'HilalController::downloadExcel');        // Ekspor Excel
    $routes->post('upload', 'HilalController::uploadExcel');           // Import Excel

    // Gambar hilal
    $routes->get('gambar', 'GambarHilalController::index');
    $routes->post('upload_gambar', 'GambarHilalController::upload_gambar');
    $routes->post('update_gambar/(:num)', 'GambarHilalController::update_gambar/$1');
    $routes->get('delete_gambar/(:num)', 'GambarHilalController::delete_gambar/$1');
});

// Grup untuk admin - Tekanan Udara harus login
$routes->group('tekananudara', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'TekananUdara::view');                             // Tampilkan tabel tekanan udara
    $routes->get('form', 'TekananUdara::form');                          // Form tambah data
    $routes->post('save', 'TekananUdara::save');                         // Simpan data
    $routes->get('form_update/(:num)', 'TekananUdara::form_update/$1'); // Form edit data
    $routes->post('update/(:num)', 'TekananUdara::update/$1');          // Proses update
    $routes->get('delete/(:num)', 'TekananUdara::delete/$1');           // Hapus data
    $routes->post('upload_excel', 'TekananUdara::upload_excel');        // Upload data Excel
});

// Grup untuk admin - Temperatur harus login
$routes->group('Temperatur', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Temperatur::view_temperatur'); // Tampilkan semua data
    $routes->get('form_temperatur', 'Temperatur::form_temperatur'); // Form tambah
    $routes->post('save_temperatur', 'Temperatur::save_temperatur'); // Simpan data
    $routes->get('form_update_temperatur/(:num)', 'Temperatur::form_update_temperatur/$1'); // Form edit
    $routes->post('update_temperatur/(:num)', 'Temperatur::update_temperatur/$1'); // Simpan update
    $routes->get('delete_temperatur/(:num)', 'Temperatur::delete_temperatur/$1'); // Hapus data
    $routes->post('upload_excel', 'Temperatur::upload_excel'); // Upload Excel
});

$routes->group('Petir', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Petir::view_petir');                            // Tabel utama data petir
    $routes->get('form', 'Petir::form');                               // Form tambah data
    $routes->get('form_update/(:num)', 'Petir::form_update/$1');       // Form edit data
    $routes->post('save', 'Petir::save');                              // Simpan data baru
    $routes->post('update/(:num)', 'Petir::update/$1');                // Update data
    $routes->get('delete/(:num)', 'Petir::delete/$1');                 // Hapus data
    $routes->post('upload', 'Petir::upload');                          // Upload file Excel
});

// Grup untuk Admin - Terbit tenggelam harus login
$routes->group('admin/terbit-tenggelam', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Terbit_Tenggelam::view_terbit_tenggelam');
    $routes->get('form', 'Terbit_Tenggelam::form_terbit_tenggelam');
    $routes->post('save', 'Terbit_Tenggelam::save_terbit_tenggelam');
    $routes->get('edit/(:num)', 'Terbit_Tenggelam::form_update_terbit_tenggelam/$1');
    $routes->post('update/(:num)', 'Terbit_Tenggelam::update_terbit_tenggelam/$1');
    $routes->get('delete/(:num)', 'Terbit_Tenggelam::delete_terbit_tenggelam/$1');
    $routes->post('upload', 'Terbit_Tenggelam::process_upload');
});

// Routes untuk Mahasiswa
$routes->group('mahasiswa', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'Admin\Mahasiswa::index');
    $routes->get('tambah', 'Admin\Mahasiswa::tambah');
    $routes->post('simpan', 'Admin\Mahasiswa::simpan');
    $routes->get('edit/(:num)', 'Admin\Mahasiswa::edit/$1');
    $routes->post('update/(:num)', 'Admin\Mahasiswa::update/$1');
    $routes->get('hapus/(:num)', 'Admin\Mahasiswa::hapus/$1');
});

// Grup untuk admin - berita kegiatan harus login
$routes->group('beritakegiatan', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Berita_Kegiatan::view_beritakegiatan');                   // Tampilkan semua berita
    $routes->get('form', 'Berita_Kegiatan::form_beritakegiatan');               // Form tambah berita
    $routes->post('add', 'Berita_Kegiatan::save_beritakegiatan');               // Simpan berita
    $routes->get('delete/(:num)', 'Berita_Kegiatan::delete_beritakegiatan/$1'); // Hapus berita
    $routes->get('edit/(:num)', 'Berita_Kegiatan::form_update_beritakegiatan/$1'); // Form update
    $routes->post('update/(:num)', 'Berita_Kegiatan::update_beritakegiatan/$1');   // Proses update
});

$routes->group('user', function ($routes) {
    $routes->get('beritakegiatan', 'Berita_Kegiatan::user_beritakegiatan');
    $routes->get('berita/(:num)', 'Berita_Kegiatan::detail_berita/$1');
    $routes->get('tentangbmkg', 'Home::tentang_bmkg');
    $routes->get('terbit-tenggelam', 'Terbit_Tenggelam::user_terbittenggelam');
    $routes->get('hilal', 'UserController::hilal');
    $routes->get('hilal/detail/(:segment)', 'UserController::detail/$1');
    $routes->get('hilal/detail/(:num)', 'UserHilalController::detail/$1');
    $routes->get('petir', 'Petir::view_petir_user');
    $routes->get('petir/detail/(:num)', 'Petir::detail_petir/$1');

});
$routes->get('buku-tamu', 'BukuTamu::form'); // route untuk halaman form buku tamu user
$routes->post('pengajuan_surat/simpan', 'PengajuanSurat::simpan');
$routes->get('cek_status_surat', 'PengajuanSurat::cek_status'); // Ekspor data