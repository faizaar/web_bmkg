<?php

namespace App\Controllers;

use App\Models\ModelGempa;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;

class Gempa extends BaseController{
public function sync_from_api()
{
    $json = file_get_contents('https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json');
    $data = json_decode($json, true);

    if (!$data || !isset($data['Infogempa']['gempa'])) {
        return $this->response->setStatusCode(500)->setBody("Gagal mengambil data dari BMKG.");
    }

    $gempa = $data['Infogempa']['gempa'];
    $tanggal = date('Y-m-d', strtotime($gempa['Tanggal']));
    $jam     = date('H:i:s', strtotime(substr($gempa['Jam'], 0, 8)));

    $model = new ModelGempa();

    // Cek apakah data dengan tanggal & jam yang sama sudah ada
    $existing = $model->where('tanggal', $tanggal)
                      ->where('jam', $jam)
                      ->first();

    if ($existing) {
        return $this->response->setBody("✅ Data gempa sudah ada, tidak disimpan ulang.");
    }

    // Konversi lintang dan bujur
    $lintang = strpos($gempa['Lintang'], 'LS') !== false ? -floatval($gempa['Lintang']) : floatval($gempa['Lintang']);
    $bujur   = strpos($gempa['Bujur'], 'BT') !== false ? floatval($gempa['Bujur']) : -floatval($gempa['Bujur']);

    $insertData = [
        'tanggal'    => $tanggal,
        'jam'        => $jam,
        'lintang'    => $lintang,
        'bujur'      => $bujur,
        'depth'      => intval(str_replace(' km', '', $gempa['Kedalaman'])),
        'magnitudo'  => floatval($gempa['Magnitude']),
        'keterangan' => $gempa['Wilayah'],
        'dirasakan'  => $gempa['Dirasakan'] ?? 'Tidak Dirasakan'
    ];

    $model->insert($insertData);
    return $this->response->setBody("✅ Data gempa berhasil disimpan.");
}
}

