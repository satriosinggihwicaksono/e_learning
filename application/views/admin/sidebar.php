<?php $level = $this->session->userdata('level'); ?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=base_url('admin/dashboard')?>">
    <div class="sidebar-brand-icon">
      <img src="<?=base_url().'assets/img/logo.png'?>" width="50px">
    </div>
    <div class="sidebar-brand-text mx-3"><?=$config['name'];?></div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="<?=base_url('admin/dashboard')?>">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Menu
  </div>
  <?php if($level == 'superadmin' || $level == 'corporyte'){ ?>
  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-fw fa-user"></i>
      <span>Data Akun</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <?php if($level == 'superadmin'){ ?>
        <a class="collapse-item" href="<?=base_url().'admin/'?>">Administrator</a>
        <a class="collapse-item" href="<?=base_url().'struktur/'?>">Kategori</a>
        <?php } ?>
        <?php if($level == 'superadmin' || $level == 'corporyte'){ ?>
        <a class="collapse-item" href="<?=base_url().'users/'?>">Users</a>
        <a class="collapse-item" href="<?=base_url().'import_users/'?>">Import Users</a>
        <a class="collapse-item" href="<?=base_url().'rekap'?>">Kelas</a>
        <?php } ?>
      </div>
    </div>
  </li>
  <?php } ?>

  <?php if($level == 'corporyte'){ ?>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSoal" aria-expanded="true" aria-controls="collapseSoal">
      <i class="fas fa-fw fa-university"></i>
      <span>Bank Soal</span>
    </a>
    <div id="collapseSoal" class="collapse" aria-labelledby="headingSoal" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <?php if($level == 'corporyte'){ ?>
        <a class="collapse-item" href="<?=base_url().'rekap/kelas'?>">Pilih Materi</a>
        <a class="collapse-item" href="<?=base_url().'rekap/mymateri'?>">Materi Saya</a>
        <?php } ?>
      </div>
    </div>
  </li>
  <?php } ?>

  <?php if($level == 'corporyte'){ ?>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBayar" aria-expanded="true" aria-controls="collapseBayar">
      <i class="fas fa-fw fa-dollar-sign"></i>
      <span>Pembayaran</span>
    </a>
    <div id="collapseBayar" class="collapse" aria-labelledby="headingBayar" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <?php if($level == 'superadmin' || $level == 'corporyte'){ ?>
        <a class="collapse-item" href="<?=base_url().'rekap/invoice'?>">Invoice</a>
        <a class="collapse-item" href="<?=base_url().'rekap/konfirmasi'?>">Konfirmasi Pembayaran</a>
        <?php } ?>
      </div>
    </div>
  </li>
  <?php } ?>

  <!-- Nav Item - Utilities Collapse Menu -->
  <?php if($level == 'superadmin'){ ?>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
      <i class="fas fa-fw fa-wrench"></i>
      <span>Master Data</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="<?=base_url().'field'?>">Bidang</a>
        <a class="collapse-item" href="<?=base_url().'division'?>">Level</a>
        <a class="collapse-item" href="<?=base_url().'position'?>">Jabatan</a>
        <a class="collapse-item" href="<?=base_url().'grade'?>">Grade</a>
        <a class="collapse-item" href="<?=base_url().'bank'?>">Bank</a>
      </div>
    </div>
  </li>
  <?php } ?>

  <?php if($level == 'superadmin'){ ?>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInvoice" aria-expanded="true" aria-controls="collapseInvoice">
      <i class="fas fa-fw fa-flag"></i>
      <span>Invoice</span>
    </a>
    <div id="collapseInvoice" class="collapse" aria-labelledby="headingInvoice" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="<?=base_url().'rekap/invoice'?>">Invoice</a>
        <a class="collapse-item" href="<?=base_url().'rekap/konfirmasi'?>">Konfirmasi</a>
        </div>
    </div>
  </li>
  <?php } ?>
  
  <?php if($level == 'content'){ ?>
  <li class="nav-item">
    <a href="<?=base_url().'question'?>" class="nav-link collapsed">
      <i class="fas fa-fw fa-file-alt"></i>
      <span>Pembuatan Materi</span>
    </a>
  </li>
  <?php } ?>

  <?php if($level == 'content' || $level == 'superadmin'){ ?>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBank" aria-expanded="true" aria-controls="collapseBank">
      <i class="fas fa-fw fa-university"></i>
      <span>Bank Soal</span>
    </a>
    <div id="collapseBank" class="collapse" aria-labelledby="headingBank" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <?php if($level == 'content'){ ?>
        <a class="collapse-item" href="<?=base_url().'question/pengajuan'?>">Pengajuan</a>
        <?php } ?>
        <?php if($level == 'superadmin'){ ?>
        <a class="collapse-item" href="<?=base_url().'question/pengajuan'?>">Pengajuan Revisi</a>
        <?php } ?>
        <?php if($level == 'superadmin'){ ?>
        <a class="collapse-item" href="<?=base_url().'audit_question'?>">Materi Revisi</a>
        <?php } ?>
        <?php if($level == 'superadmin'){ ?>
        <a class="collapse-item" href="<?=base_url().'price_question'?>">Harga Soal</a>
        <?php } ?>
        <?php if($level == 'content'){ ?>
        <a class="collapse-item" href="<?=base_url().'question/revisi_soal'?>">Materi Revisi</a>
        <?php } ?>
        <?php if($level == 'content' || $level == 'superadmin'){ ?>
        <a class="collapse-item" href="<?=base_url().'bank_question'?>">Materi Jadi</a>
        <?php } ?>
      </div>
    </div>
  </li>
  <?php } ?>
  
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
      <i class="fas fa-fw fa-cogs"></i>
      <span>Konfigurasi</span>
    </a>
    <div id="collapseSetting" class="collapse" aria-labelledby="headingMaster" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="<?=base_url().'admin/setting'?>">Setting</a>
        <a class="collapse-item" href="<?=base_url().'admin/profile'?>">Profile</a>
        <?php if($level == 'superadmin'){ ?>
        <a class="collapse-item" href="<?=base_url().'admin/konfigurasi'?>">Konfigurasi</a>
        <?php } ?>
      </div>
    </div>
  </li>
  
  <?php if($level == 'content'){ ?>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan" aria-expanded="true" aria-controls="collapseLaporan">
      <i class="fas fa-fw fa-money-bill"></i>
      <span>Laporan</span>
    </a>
    <div id="collapseLaporan" class="collapse" aria-labelledby="headingLaporan" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="<?=base_url().'question/pengajuan_materi'?>">Pengguna</a>
        <a class="collapse-item" href="<?=base_url().'question/pendapatan_materi'?>">Pendapatan</a>
      </div>
    </div>
  </li>
  <?php } ?>

  <!-- Users -->
  <?php if($level == 'users'){ ?>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMaster" aria-expanded="true" aria-controls="collapseMaster">
      <i class="fas fa-fw fa-file-alt"></i>
      <span>Master</span>
    </a>
    <div id="collapseMaster" class="collapse" aria-labelledby="headingMaster" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="<?=base_url().'uji'?>">Ujian</a>
        <a class="collapse-item" href="<?=base_url().'d_user/history'?>">History</a>
        <a class="collapse-item" href="<?=base_url().'d_user/profile'?>">Profile</a>
      </div>
    </div>
  </li>
  <?php } ?>

  <?php if($level == 'corporyte'){ ?>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan" aria-expanded="true" aria-controls="collapseLaporan">
      <i class="fas fa-fw fa-file-alt"></i>
      <span>Laporan</span>
    </a>
    <div id="collapseLaporan" class="collapse" aria-labelledby="headingLaporan" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <?php if($level == 'superadmin' || $level == 'corporyte'){ ?>
        <a class="collapse-item" href="<?=base_url().'rekap/materi'?>">Materi</a>
        <a class="collapse-item" href="<?=base_url().'rekap/nilai_user'?>">Nilai User</a>
        <?php } ?>
      </div>
    </div>
  </li>
  <?php } ?>

  <hr class="sidebar-divider">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>