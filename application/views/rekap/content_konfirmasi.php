<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Data Konfirmasi</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="table_invoice" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No.</th>
              <th>Tanggal</th>
              <th>Invoice</th>
              <th>Perusahaan</th>
              <th>Total</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
          <?php 
            $x = 1;
            $this->db->select('*,invoice.status,invoice.id');
            if($this->session->userdata('level') != 'superadmin'){
              $this->db->where('invoice.id_admin',$this->session->userdata('id'));
            }
            $this->db->where('invoice.status',1);
            $this->db->join('admin','invoice.id_admin = admin.id','left');
            $invoice = $this->db->get('invoice')->result_array();
            foreach($invoice as $i){
            if($i['status'] == 0){
              $status = '<span class="btn btn-danger">Belum Dibayar</span>';
            } else {
              $status = '<span class="btn btn-success">Sudah Bayar</span>';
            }
          ?>
            <tr>
              <td><?=$x++?></td>
              <td><?=longdate_indo(date('Y-m-d',strtotime($i['tanggal'])))?></td>
              <td><?=$i['invoice']?></td>
              <td><?=$i['name']?></td>
              <td><?=$i['total']?></td>
              <td><a style="margin-right:5px;" href="<?=base_url().'rekap/detail_invoice/'.$i['id']?>" class="btn btn-primary" target="_blank"> Detail</a><?=$status?></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>