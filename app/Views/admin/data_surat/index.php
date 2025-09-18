<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">

                <?php if (session()->getFlashdata('msg')) : ?>
                    <div class="pb-2 px-3">
                        <div class="alert alert-<?= session()->getFlashdata('error') == true ? 'danger' : 'success' ?>">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                            </button>
                            <?= session()->getFlashdata('msg') ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header card-header-info" style="background: #141C6E !important;">
                        <div class="nav-tabs-navigation">
                            <div class="row">
                                <div class="col">
                                    <h4 class="card-title"><b>Data Surat Sakit / Izin</b></h4>
                                    <p class="card-category">Lihat data surat izin/sakit yang telah diupload</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <?php if (empty($surat)) : ?>
                                <p class="text-center">Gagal memuat data</p>
                            <?php else : ?>
                                <table class="table table-striped">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                            <th>File Surat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($surat as $s) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= esc($s['nama_siswa']) ?></td>
                                                <td><?= esc($s['kelas']) ?></td>
                                                <td><?= date('d-m-Y', strtotime($s['tanggal'])) ?></td>
                                                <td>
                                                    <span class="badge <?= $s['id_kehadiran'] == 2 ? 'badge-warning' : 'badge-danger' ?>">
                                                        <?= $s['id_kehadiran'] == 2 ? 'Izin' : 'Sakit' ?>
                                                    </span>
                                                </td>
                                                <td><?= esc($s['keterangan']) ?></td>
<td>
    <?php if (!empty($s['file_surat'])): ?>
        <a href="<?= base_url('uploads/' . $s['file_surat']) ?>" target="_blank" class="btn btn-sm btn-info">
            Lihat File
        </a>
    <?php else: ?>
        <span class="text-muted">Tidak ada file</span>
    <?php endif; ?>
</td>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>