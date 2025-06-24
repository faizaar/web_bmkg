<?php

namespace App\Controllers;

use App\Models\Model_TekananUdara;
use App\Models\Model_temperatur;
use App\Models\ModelBeritaKegiatan;
use App\Models\ModelGambarHilal;
use App\Models\ModelGempa;
use App\Models\ModelLogin;
use App\Models\ModelPengamatanHilal;
use App\Models\ModelPetir;
use App\Models\ModelTerbitTenggelam;
use App\Models\PengamatanModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $modelGempa = new ModelGempa();

    // Ambil data gempa terbaru
    $latestGempa = $modelGempa
        ->orderBy('tanggal', 'DESC')
        ->orderBy('jam', 'DESC')
        ->findAll(1);

    // Ambil tanggal terakhir dari data gempa
    $lastUpdateGempa = !empty($latestGempa) ? $latestGempa[0]['tanggal'] : null;

        $data = [
            'jml_tekananudara'      => (new Model_TekananUdara())->countAll(),
            'jml_temperatur'        => (new Model_temperatur())->countAll(),
            'jml_berita'            => (new ModelBeritaKegiatan())->countAll(),
            'jml_gambarhilal'       => (new ModelGambarHilal())->countAll(),
            'jml_gempa'             => (new ModelGempa())->countAll(),
            'jml_login'             => (new ModelLogin())->countAll(),
            'jml_pengamatanhilal'   => (new ModelPengamatanHilal())->countAll(),
            'jml_petir'             => (new ModelPetir())->countAll(),
            'jml_terbit'            => (new ModelTerbitTenggelam())->countAll(),
            'jml_pengamatan'        => (new PengamatanModel())->countAll(),
         // Ini tambahan:
        'dataGempa'             => $latestGempa,
        'lastUpdateGempa'       => $lastUpdateGempa,
        ];
        
        echo view('admin/admin_header', $data);
        echo view('admin/admin_nav');
        echo view('admin/dashboard/admin_dashboard', $data);
        echo view('admin/admin_footer');
        
    }
}
