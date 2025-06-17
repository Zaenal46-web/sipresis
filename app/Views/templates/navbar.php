<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-absolute fixed-top text-white" style="background-color: #EC8305 !important;">
   <div class="container-fluid">
      <div class="navbar-wrapper">
         <p class="navbar-brand font-weight-bold" style="font-size: 25px;"><b><?= $title; ?></b></p>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
         <span class="sr-only">Toggle navigation</span>
         <span class="navbar-toggler-icon icon-bar"></span>
         <span class="navbar-toggler-icon icon-bar"></span>
         <span class="navbar-toggler-icon icon-bar"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end">
         <ul class="navbar-nav">

            <li class="nav-item">
               <a class="nav-link" href="<?= base_url('admin/dashboard'); ?>">
                  <i class="material-icons">dashboard</i>
                  <p class="d-lg-none d-md-block">Dashboard</p>
               </a>
            </li>

            <li class="nav-item dropdown">
               <a class="nav-link" href="javascript:;" id="navbarDropdownScan" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">qr_code</i>
                  <p class="d-lg-none d-md-block">Scan</p>
               </a>
               <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownScan">
                  <a class="dropdown-item" href="<?= base_url('scan/masuk'); ?>">Absen masuk</a>
                  <a class="dropdown-item" href="<?= base_url('scan/pulang'); ?>">Absen pulang</a>
               </div>
            </li>

            <li class="nav-item dropdown">
               <a class="nav-link text-white font-weight-bold" style="background-color: #123810 !important;letter-spacing: 2px !important;" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">Account</p>
                  <span>User : <?= user()->toArray()['username']; ?></span>
               </a>
               <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="<?= base_url('/logout'); ?>">Log out</a>
               </div>
            </li>
            <!-- Logo Sekolah sebelum User Profile (Kanan) -->
            <li class="nav-item d-flex align-items-center mx-2">
            <img src="<?= base_url('assets/img/logo-sekolah.png'); ?>" alt="Logo Sekolah" style="height: 40px; width: auto;">
            </li>
         </ul>
      </div>
   </div>
</nav>
<!-- End Navbar -->
