<?php
$context = $ctx ?? 'dashboard';
switch ($context) {
   case 'absen-siswa':
   case 'siswa':
   case 'kelas':
      $sidebarColor = 'purple';
      break;
   case 'absen-guru':
   case 'guru':
      $sidebarColor = 'green';
      break;

   case 'qr':
      $sidebarColor = 'danger';
      break;

   default:
      $sidebarColor = 'azure';
      break;
}
?>
<div class="sidebar" data-color="orange" data-background-color="green">
   <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
   <div class="logo">
      <a class="simple-text logo-normal">
         <b>Sistem Presensi Siswa<br>SMAN 1 Kandangan</b>
      </a>
   </div>
   <div class="sidebar-wrapper">
      <ul class="nav">
         <li class="nav-item <?= $context == 'dashboard' ? 'active' : ''; ?>">
            <a class="nav-link" style="background-color: <?= $context == 'dashboard' ? '' : '#1E2998'?>;" href="<?= base_url('admin/dashboard'); ?>">
               <i class="material-icons">dashboard</i>
               <p>Dashboard</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'absen-siswa' ? 'active' : ''; ?>">
            <a class="nav-link" style="background-color: <?= $context == 'absen-siswa' ? '' : '#1E2998'?>;" href="<?= base_url('admin/absen-siswa'); ?>">
               <i class="material-icons">checklist</i>
               <p>Absensi Siswa</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'siswa' ? 'active' : ''; ?>">
            <a class="nav-link" style="background-color: <?= $context == 'siswa' ? '' : '#1E2998'?>;" href="<?= base_url('admin/siswa'); ?>">
               <i class="material-icons">person</i>
               <p>Data Siswa</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'kelas' ? 'active' : ''; ?>">
            <a class="nav-link" style="background-color: <?= $context == 'kelas' ? '' : '#1E2998'?>;" href="<?= base_url('admin/kelas'); ?>">
               <i class="material-icons">school</i>
               <p>Data Kelas & Jurusan</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'qr' ? 'active' : ''; ?>">
            <a class="nav-link" style="background-color: <?= $context == 'qr' ? '' : '#1E2998'?>;" href="<?= base_url('admin/generate'); ?>">
               <i class="material-icons">qr_code</i>
               <p>Generate QR Code</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'laporan' ? 'active' : ''; ?>">
            <a class="nav-link" style="background-color: <?= $context == 'laporan' ? '' : '#1E2998'?>;" href="<?= base_url('admin/laporan'); ?>">
               <i class="material-icons">print</i>
               <p>Generate Laporan</p>
            </a>
         </li>
         <?php if (user()->toArray()['is_superadmin'] ?? '0' == '1') : ?>
            <li class="nav-item <?= $context == 'petugas' ? 'active' : ''; ?>">
               <a class="nav-link" style="background-color: <?= $context == 'petugas' ? '' : '#1E2998'?>;" href="<?= base_url('admin/petugas'); ?>">
                  <i class="material-icons">computer</i>
                  <p>Data Petugas</p>
               </a>
            </li>
            <li class="nav-item <?= $context == 'general_settings' ? 'active' : ''; ?>">
               <a class="nav-link" style="background-color: <?= $context == 'general_settings' ? '' : '#1E2998'?>;" href="<?= base_url('admin/general-settings'); ?>">
                  <i class="material-icons">settings</i>
                  <p>Pengaturan</p>
               </a>
            </li>

         <?php endif; ?>
         <!-- <li class="nav-item active-pro mb-3">
            <a class="nav-link" href="./upgrade.html">
               <i class="material-icons">unarchive</i>
               <p>Bottom sidebar</p>
            </a>
         </li> -->
      </ul>
   </div>
</div>