<?php

namespace App\Controllers;

use App\Models\ModelBeritaKegiatan;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;

class Berita_Kegiatan extends BaseController
{
    public function view_beritakegiatan()
    {
        $model = new ModelBeritaKegiatan();
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $data['dataMb'] = $model
                ->like('judul', $keyword)
                ->orLike('kategori', $keyword)
                ->paginate(30, 'berita'); // 10 item per halaman
        } else {
            $data['dataMb'] = $model->tampilberitakegiatan();
        }

        $data['pager'] = $model->pager;
        $data['keyword'] = $keyword;

        echo view('admin/admin_header');
        echo view('admin/admin_nav');
        echo view('admin/berita_kegiatan/admin_beritakegiatan', $data);
        echo view('admin/admin_footer');
    }


    public function form_beritakegiatan()
    {
        // $mb = new ModelTerbitTenggelam();
        // $data['terbit_tenggelam'] = $mb->getById($id);  // Ambil data berdasarkan ID
        echo view('admin/admin_header');
        echo view('admin/admin_nav');
        echo view('admin/berita_kegiatan/admin_form_beritakegiatan');
        echo view('admin/admin_footer');
    }

    public function form_update_beritakegiatan($id)
    {
        $mb = new ModelBeritaKegiatan();
        $data['berita_kegiatan'] = $mb->getById($id);
        echo view('admin/admin_header');
        echo view('admin/admin_nav');
        echo view('admin/berita_kegiatan/admin_update_beritakegiatan', $data);
        echo view('admin/admin_footer');
    }

    public function save_beritakegiatan()
    {
        // Isi tanggal otomatis (hari ini)
        $tanggal = date('Y-m-d'); // tidak ambil dari input form
        // Ambil input lainnya
        $judul = $this->request->getPost('judul');
        $kategori = $this->request->getPost('kategori');
        $isi = $this->request->getPost('isi');
        $gambar = $this->request->getFile('gambar');

        // Validasi
        if (empty($judul) || empty($isi) || empty($kategori)) {
            return redirect()->back()->with('error', 'Judul dan isi wajib diisi!');
        }
        // Default null
        $namaGambar = null;

        // Validasi upload file
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaGambar = $gambar->getClientName();
            if (!$gambar->move('uploads/berita', $namaGambar)) {
                echo $gambar->getErrorString(); // debug error upload
                return;
            }
        } else {
            echo "Upload gagal: tidak valid atau sudah dipindah.";
            return;
        }


        // Data untuk disimpan
        $data = [
            'tanggal' => $tanggal,
            'gambar' => $namaGambar,
            'judul' => $judul,
            'kategori' => $kategori,
            'isi' => $isi,
        ];

        // Simpan data
        $model = new ModelBeritaKegiatan();
        $simpan = $model->simpanberitakegiatan('berita_kegiatan', $data);

        if (!$simpan) {
            echo '<pre>';
            print_r($data);
            echo '</pre>';
            echo 'Gagal simpan. Cek struktur tabel dan data input.';
            return;
        }

        // Berhasil
        return redirect()->to('beritakegiatan')->with('success', 'Data berhasil disimpan');
    }


    public function delete_beritakegiatan($id)
    {
        $mb = new ModelBeritaKegiatan();
        $mb->hapus($id);  // Panggil fungsi hapus
        return redirect()->to(site_url('beritakegiatan'));
    }

    // Metode untuk update data berdasarkan ID
    public function update_beritakegiatan($id)
    {
        $tanggal = date('Y-m-d');
        $judul = $this->request->getPost('judul');
        $kategori = $this->request->getPost('kategori');
        $isi = $this->request->getPost('isi');
        $gambar = $this->request->getFile('gambar');

        $mb = new ModelBeritaKegiatan();
        $tabel = "berita_kegiatan";

        // Ambil data lama dari DB
        $dataLama = $mb->getById($id); // pastikan kamu punya method getById() di model
        $namaGambar = $dataLama->gambar; // default pakai nama lama

        // Jika upload file baru
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaBaru = $gambar->getRandomName();
            $gambar->move('uploads/berita', $namaBaru);

            // (Opsional) Hapus gambar lama
            if ($namaGambar && file_exists('uploads/berita/' . $namaGambar)) {
                unlink('uploads/berita/' . $namaGambar);
            }

            $namaGambar = $namaBaru;
        }

        // Data untuk disimpan
        $data = [
            'tanggal' => $tanggal,
            'judul' => $judul,
            'kategori' => $kategori,
            'isi' => $isi,
            'gambar' => $namaGambar,
        ];

        $where = ['id_berita' => $id];
        $simpan = $mb->updateberitakegiatan($tabel, $data, $where);

        if ($simpan) {
            return redirect()->to(base_url('beritakegiatan'))->with('success', 'Data berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui data.');
        }
    }

    public function user_beritakegiatan()
    {
        helper(['text', 'url']);
        $model = new ModelBeritaKegiatan();

        $keyword = $this->request->getGet('q'); // Ambil keyword dari query string

        if ($keyword) {
            $data['berita'] = $model
                ->like('judul', $keyword)
                ->orLike('isi', $keyword)
                ->orderBy('tanggal', 'DESC')
                ->findAll();
        } else {
            $data['berita'] = $model->orderBy('tanggal', 'DESC')->findAll();
        }

        $data['keyword'] = $keyword; // kirim juga ke view agar input tetap muncul

        echo view('user/user_header');
        echo view('user/berita_kegiatan/user_beritakegiatan', $data);
        echo view('user/user_footer');
    }


    public function detail_berita($id)
    {
        $model = new ModelBeritaKegiatan();
        $berita = $model->find($id);

        if (!$berita) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Berita tidak ditemukan");
        }
        echo view('user/user_header');
        echo view('user/berita_kegiatan/user_detailberita', ['berita' => $berita]); // kirim data ke view
        echo view('user/user_footer');
    }




}