<?php 
$url = $this->uri->segment(1);
$this->db->where('id',1);
$config = $this->db->get('setting')->row_array();
if(empty($url)){
  $url = 'admin';
}

if($this->session->userdata('level') == 'users'){
  $this->db->where('id',$this->session->userdata('id'));
  $session = $this->db->get('users')->row_array();
} else {
  $this->db->where('id',$this->session->userdata('id'));
  $session = $this->db->get('admin')->row_array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?=$config['name']?></title>

  <?php $this->load->view($url.'/'.$header,array('config' => $config));?>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php $this->load->view('admin/'.$sidebar,array('config' => $config));?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php $this->load->view('admin/'.$menu,array('config' => $config,'session' => $session));?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <?php $this->load->view($url.'/'.$content,array('config' => $config));?>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <?php $this->load->view($url.'/'.$footer,array('config' => $config));?>
  <script>
    var baseUrl = '<?=base_url();?>';
  </script>
</body>

</html>
