<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBeritaKegiatan extends Model
{
    protected $table = 'berita_kegiatan'; // nama tabel di database
    protected $primaryKey = 'id_berita'; // sesuaikan dengan primary key yang kamu pakai

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['tanggal', 'gambar', 'judul', 'isi', 'kategori'];

    protected $useTimestamps = false; // atau true kalau pakai created_at, updated_at

    // Menampilkan semua data
    public function tampilberitakegiatan()
    {
        return $this->orderBy('tanggal', 'DESC')->paginate(30, 'berita');
    }


    // Mengambil data berdasarkan ID
    public function getById($id)
    {
        return $this->db->table($this->table)
            ->where($this->primaryKey, $id)
            ->get()
            ->getRow();
    }


    // Menyimpan data baru
    public function simpanberitakegiatan($table, $data)
    {
        // Validasi data
        if (empty($data['tanggal']) || empty($data['judul']) || empty($data['isi'])) {
            return false;
        }

        return $this->db->table($table)->insert($data);
    }

    // Menghapus data berdasarkan ID
    public function hapus($id)
    {
        return $this->db->table($this->table)
            ->where($this->primaryKey, $id)
            ->delete();
    }

    // Mengedit data
    public function updateberitakegiatan($table, $data, $where)
    {
        return $this->db->table($table)->update($data, $where);
    }
}