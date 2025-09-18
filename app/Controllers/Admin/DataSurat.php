<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PresensiSiswaModel;
use App\Models\SuratModel;

class DataSurat extends BaseController
{
protected $suratModel;

    public function __construct()
    {
        $this->suratModel = new SuratModel();
    }

    public function index()
    {
        $dataSurat = $this->suratModel->getDataSurat();

        $data = [
            'title' => 'Data Surat Sakit / Izin',
            'surat' => $dataSurat
        ];

        return view('admin/data_surat/index', $data);
    }
}
