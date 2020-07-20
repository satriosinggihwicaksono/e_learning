<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Data Invoice</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
    <div id="notifications"><?php echo $this->session->flashdata('msg'); ?></div>
      <div class="table-responsive">
        <table class="table table-bordered" id="table_invoice" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No.</th>
              <th>Tanggal</th>
              <th>Tanggal Berakhir</th>
              <th>Invoice</th>
              <th>Perusahaan</th>
              <th>Total</th>
              <th>Action</th>
              <th>Status</th>
              <?php 
                if($this->session->userdata('level') == 'superadmin'){
              ?>
              <th>Action</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
          <?php 
            $x = 1;
            $this->db->select('*,invoice.status,invoice.id');
            if($this->session->userdata('level') != 'superadmin'){
              $this->db->where('invoice.id_admin',$this->session->userdata('id'));
            }
            $this->db->where('invoice.status',0);
            $this->db->join('admin','invoice.id_admin = admin.id','left');
            $invoice = $this->db->get('invoice')->result_array();
            foreach($invoice as $i){
            $this->db->where('id_invoice',$i['id']);
            $konfirmasi = $this->db->get('konfirmasi')->row_array();
            if($i['status'] == 0 && empty($konfirmasi)){
              $status = '<span class="btn btn-success">Belum Dibayar</span>';
            } elseif($i['tgl_kadarluasa'] != date('Y-m-d') && $i['status'] == 0 && empty($konfirmasi)){
              $status = '<span class="btn btn-sm btn-danger">Kadarluasa</span>'; 
            } elseif(!empty($konfirmasi)) {
              $status = '<span class="btn btn-sm btn-warning">Menunggu</span>';
            }

          ?>
            <tr>
              <td><?=$x++?></td>
              <td><?=longdate_indo(date('Y-m-d',strtotime($i['tanggal'])))?></td>
              <td><?=longdate_indo(date('Y-m-d',strtotime($i['tgl_kadarluasa'])))?></td>
              <td><?=$i['invoice']?></td>
              <td><?=$i['name']?></td>
              <td><?=$i['total']?></td>
              <td>
                 <a href="<?=base_url().'rekap/detail_invoice/'.$i['id']?>" class="btn btn-sm btn-primary" target="_blank"> Detail</a>
                 <a href="javascript:void(0)" data-toggle="modal" data-target="#tambah" class="btn btn-sm btn-info"> Konfirmasi</a>
              </td>
              <td><?=$status?></td>
              <?php 
                if($this->session->userdata('level') == 'superadmin'){
              ?>
              <td>
                <?php 
                  if($i['tgl_kadarluasa'] != date('Y-m-d H:i:s')){ 
                ?>
                <a class="btn btn-sm btn-success" href="<?=base_url().'rekap/ckonfirmasi/'.$i['id']?>">Konfirmasi</a>
                <?php } ?>
              </td>
              <?php } ?>
            </tr>
            <?php 
             
            ?> 
             <!-- Bootstrap modal -->
              <div class="modal fade" id="tambah" role="dialog">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pembayaran</h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <form action="<?=base_url().'rekap/konfirmasi_invoice/'.$i['id']?>" method="post" id="form" class="form-horizontal">
                    <div class="modal-body form">
                      <input type="hidden" value="" name="id"/> 
                        <div class="form-body">
                          <div class="form-group">
                            <label class="control-label col-md-3">Nomor Invoice</label>
                            <div class="col-md-9">
                              <input name="id" class="form-control" type="hidden" value="<?php if(!empty($konfirmasi)){ echo $konfirmasi['id']; } ?>">
                              <input name="invoice" class="form-control" type="text" value="<?=$i['invoice']?>" disabled>
                            </div>
                          </div>
                        </div>
                        <div class="form-body">
                          <div class="form-group">
                            <label class="control-label col-md-3">Tanggal Transfer</label>
                            <div class="col-md-9">
                              <input name="tanggal" class="form-control" type="date" value="<?php if(!empty($konfirmasi)){ echo date('Y-m-d',strtotime($konfirmasi['tanggal'])); } ?>">
                            </div>
                          </div>
                        </div>
                        <div class="form-body">
                          <div class="form-group">
                            <label class="control-label col-md-3">Jumlah</label>
                            <div class="col-md-9">
                              <input name="jumlah" class="form-control" type="text" value="<?=$i['total']?>" readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-body">
                          <div class="form-group">
                            <label class="control-label col-md-3">Nama Pemilik Rekening</label>
                            <div class="col-md-9">
                              <input name="nama" class="form-control" type="text" value="<?php if(!empty($konfirmasi)){ echo $konfirmasi['nama']; } ?>">
                            </div>
                          </div>
                        </div>
                        <div class="form-body">
                          <div class="form-group">
                            <label class="control-label col-md-3">Nama Bank Asal</label>
                            <div class="col-md-9">
                             <input name="rekening" class="form-control" type="text" value="<?php if(!empty($konfirmasi)){ echo $konfirmasi['rekening']; } ?>">
                            </div>
                          </div>
                        </div>
                        <div class="form-body">
                          <div class="form-group">
                            <label class="control-label col-md-3">Bank Tujuan</label>
                            <div class="col-md-9">
                              <select name="bank" class="form-control" >
                              <?php 
                              $this->db->select('*,bank.bank as namabank,rekening.id as id_rekening');
                              $this->db->join('bank','bank.id = rekening.bank','left');
                              $rekening = $this->db->get('rekening')->result_array(); 
                              foreach($rekening as $r){ 
                              ?>
                              <option <?php if($r['id'] == !empty($konfirmasi['bank'])){ echo 'selected="selected"';} ?> value="<?=$r['id']?>"><?=$r['namabank'].' / '.$r['norek'].' / An. '.$r['nama'];?></option>
                              <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <input id="btnSave" type="submit"  class="btn btn-primary" value="Save"/>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                  </div><!-- /.modal-content -->
                  </form>
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->
              <!-- End Bootstrap modal -->
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>