<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratModel extends Model
{
    protected $table = 'tb_presensi_siswa';
    protected $primaryKey = 'id_presensi';
    protected $allowedFields = [
        'id_siswa', 'id_kelas', 'tanggal', 'jam_masuk', 'jam_keluar', 'id_kehadiran', 'keterangan', 'file_surat'
    ];

public function getDataSurat()
{
    return $this->select('tb_presensi_siswa.*, tb_siswa.nama_siswa, tb_kelas.kelas')
        ->join('tb_siswa', 'tb_siswa.id_siswa = tb_presensi_siswa.id_siswa')
        ->join('tb_kelas', 'tb_kelas.id_kelas = tb_siswa.id_kelas')
        ->whereIn('tb_presensi_siswa.id_kehadiran', [2, 3]) // 2 = izin, 3 = sakit
        ->orderBy('tb_presensi_siswa.tanggal', 'DESC')
        ->findAll();
}

}
