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
               <div class="card-header card-header-tabs card-header-info" style="background: #141C6E !important;">
                  <h4 class="card-title"><b>Kirim Laporan Presensi ke WhatsApp</b></h4>
                  <p class="card-category">Laporan absen</p>
               </div>

               <div class="card-body">
                  <form action="<?= base_url('admin/wa-laporan') ?>" method="get">
                     <h4 class="text-dark"><b>Laporan Absen Siswa</b></h4>

                     <div class="row mb-3">
                        <div class="col-md-3">
                           <label for="bulan"><b>Bulan :</b></label>
                           <input type="month" name="bulan" id="bulan" class="form-control"
                              value="<?= $selected_bulan ?? date('Y-m'); ?>" required>
                        </div>
                        <div class="col-md-5">
                           <label for="kelas"><b>Kelas :</b></label>
                           <select name="kelas" id="kelas" class="custom-select" required>
                              <option value="">Pilih Kelas</option>
                              <?php foreach ($kelas as $k): ?>
                                 <option value="<?= $k['id_kelas'] ?>" <?= $selected_kelas == $k['id_kelas'] ? 'selected' : '' ?>>
                                    <?= $k['kelas'] ?> - <?= $k['jurusan'] ?>
                                 </option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                           <button type="submit" class="btn btn-success btn-block" style="background: #1E2998 !important;" >
                              <b>Lihat Laporan</b>
                           </button>
                        </div>
                     </div>
                  </form>

                  <?php if ($data_kosong): ?>
                     <div class="alert alert-warning mt-3">
                        File PDF belum tersedia untuk bulan dan kelas yang dipilih.
                     </div>
                  <?php endif; ?>

                  <?php if ($selected_bulan && $selected_kelas && $preview): ?>
                     <div class="alert alert-success mt-3">
                        File PDF untuk bulan dan kelas tersebut tersedia dan siap dikirim.
                     </div>

                     <form action="<?= base_url('admin/wa-laporan/kirim') ?>" method="post">
                        <input type="hidden" name="bulan" value="<?= $selected_bulan ?>">
                        <input type="hidden" name="kelas" value="<?= $selected_kelas ?>">
                        <button type="submit" class="btn btn-primary mt-2" style="background: #1E2998 !important;">
                           <b>Kirim Laporan via WhatsApp</b>
                        </button>
                     </form>
                  <?php endif; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?= $this->endSection() ?>
