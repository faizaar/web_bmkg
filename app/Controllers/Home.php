<?php

namespace App\Controllers;
use App\Models\Model_TekananUdara;
use App\Models\Model_temperatur;
use App\Models\ModelGempa;
use App\Models\ModelPetir;
use App\Models\ModelTerbitTenggelam;
use App\Models\ModelPengamatanHilal;
use App\Models\ModelGambarHilal;
use App\Models\ModelBeritaKegiatan;

class Home extends BaseController
{
    public function dashboard()
    {
        echo view('admin/admin_header');
        echo view('admin/admin_nav');
        echo view('admin/admin_dashboard');
        echo view('admin/admin_footer');
    }
    public function index()
    {
        $data = [
            'title' => 'Dashboard Admin'
        ];
        echo view('admin/admin_header', $data);
        echo view('admin/admin_nav');
        echo view('admin/admin_dashboard');
        echo view('admin/admin_footer');
    }

    // ==================== TERBIT TENGGELAM ====================

    public function terbit_tenggelam()
    {
        $mb = new ModelTerbitTenggelam();
        $data = [
            'title' => 'Data Terbit Tenggelam',
            'dataMb' => $mb->tampilterbitenggelam()
        ];

        echo view('admin/admin_header', $data);
        echo view('admin/admin_nav');
        echo view('admin/admin_terbit_tenggelam', $data);
        echo view('admin/admin_footer');
    }

    // ==================== GEMPA ====================

    public function gempa()
    {
        $data = [
            'title' => 'Data Gempa'
        ];
        echo view('admin/admin_header', $data);
        echo view('admin/admin_nav');
        echo view('admin/admin_gempa');
        echo view('admin/admin_footer');
    }

    // ==================== HILAL FUNCTIONALITY ====================

    public function hilal()
    {
        $model = new ModelPengamatanHilal();
        $data = [
            'title' => 'Pengamatan Hilal',
            'pengamatan' => $model->where('dipublikasikan', 1)
                //->orderBy('tanggal_observasi', 'DESC')//
                ->orderBy('id_pengamatan_hilal', 'ASC')
                ->findAll()
        ];

        echo view('admin/admin_header', $data);
        echo view('admin/admin_nav');
        echo view('admin/hilal/admin_hilal', $data);
        echo view('admin/admin_footer');
    }

    // ==================== Statistik Harian ====================
    public function user_dashboard()
    {
        $tekananModel = new Model_TekananUdara();
        $today = $tekananModel->getTodayPressure();
        $data['tekanan'] = $today['tekanan_udara'] ?? '-';
        $data['kelembaban_07'] = $today['kelembaban_07'] ?? '-';
        $data['kecepatan_rata2'] = $today['kecepatan_rata2'] ?? '-';
        $data['arah_terbanyak'] = $today['arah_terbanyak'] ?? '-';
        $data['lastUpdateTekanan'] = $today['tanggal'] ?? null;

        // Tambahkan ini:
        $temperaturModel = new model_temperatur();
        $temperaturToday = $temperaturModel->getTodaytemperature();
        $data['temperatur'] = $temperaturToday['temperatur_07'] ?? '-';
        $data['curah_hujan'] = $temperaturToday['curah_hujan_07'] ?? '-';
        $data['lastUpdateTemperatur'] = $temperaturToday['tgl'] ?? null;
        $data['lastUpdateHujan'] = $temperaturToday['tanggal'] ?? null;


        //Terbit Tenggelam
        $modelTerbit = new ModelTerbitTenggelam();
        $data['dataTerbit'] = $modelTerbit->getLatestDataFiltered();
        // Ambil tanggal terbaru untuk ditampilkan
        $latest = $modelTerbit->select('tanggal')->orderBy('tanggal', 'DESC')->first();
        $data['lastUpdate'] = $latest['tanggal'] ?? null;

        //Gempa
        // helper('text');
        $modelGempa = new ModelGempa();
        $data['dataGempa'] = $modelGempa->getLatestGempaFiltered();
        // Ambil tanggal terbaru untuk ditampilkan
        $latest = $modelGempa->select('tanggal')->orderBy('tanggal', 'DESC')->first();
        $data['lastUpdateGempa'] = $latest['tanggal'] ?? null;

        // Petir
        $petirModel = new ModelPetir();
        $latestPetir = $petirModel->select('tanggal')->orderBy('tanggal', 'DESC')->first();
        $data['lastUpdatePetir'] = $latestPetir['tanggal'] ?? null;

        helper('text');
        $model = new ModelBeritaKegiatan();
        $data['berita'] = $model->orderBy('tanggal', 'DESC')->findAll(10);

        echo view('user/user_header', $data);
        echo view('user/user_dashboard', $data);
        echo view('user/user_footer');
    }



    public function tentang_bmkg()
    {
        echo view('user/user_header');
        echo view('user/tentang_bmkg/user_tentangbmkg'); // kirim data ke view
        echo view('user/user_footer');
    }


}
