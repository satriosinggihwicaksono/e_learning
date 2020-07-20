<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Data Soal</h1>
        <!-- Earnings (Monthly) Card Example -->
        <div class="row">
          <?php 
            foreach($data as $d){
          ?>
          <div class="col-xl-3 col-md-6 mb-5">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary"><?=$d['question']?></h6>
                </div>
                <div class="card-body">
                  <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="<?=base_url().'assets/files/question/'.$d['cover']?>" alt="">
                  </div>
                  <?php
                   $ringkasan = strip_tags($d['ringkasan'],'<p><a><b><div>'); 
                   if (strlen($ringkasan) > 200)
                   $ringkasan = substr($ringkasan, 0, 196) . '...';
                  echo $ringkasan;
                  ?>
                  <div>
                  <s><h5>Rp. <?=$d['price']?></h5></s>
                  <h5>Rp. <?=$d['discount']?></h5>
                  </div>
                  <div class="text-right">
                    <button onclick="add_shop('<?=$d['id']?>')" class="btn btn-sm btn-danger">Pilih</button>
                  </div>  
                </div>
              </div>  
          </div>
          <?php } ?>
        </div>    
</div>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body form">
          <form action="javascript:void(0)" id="form" class="form-horizontal">
            <input type="hidden" value="" name="id"/> 
            <input type="hidden" value="" name="id_question"/> 
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Judul Soal</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="question" disabled>
                  <input type="hidden" class="form-control" name="id_field" value="<?=$id_field?>"/>
                  <input type="hidden" class="form-control" name="id_position" value="<?=$id_position?>"/>
                  <input type="hidden" class="form-control" name="id_division" value="<?=$id_division?>"/>
                  <input type="hidden" class="form-control" name="grade" value="<?=$grade?>"/>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Jadwal Ujian</label>
                <div class="col-md-9">
                  <select  class="form-control showhide tgl_uji" id="tgl_uji" name="tgl_uji">
                    <option value="0">Tanpa Jadwal Ujian</option>
                    <option value="1">Menggunakan Jadwal Ujian</option>
                  </select>
                </div>
              </div>
              <div class="form-group drop-down-show-hide showtgl">
                <label class="control-label col-md-3">Tanggal Uji</label>
                <div class="col-md-9">
                      <input type="date" class="form-control" id="time" name="time" />
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Beli</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- End Bootstrap modal -->


   <!-- Bootstrap modal -->
   <div class="modal fade" id="keranjang_modal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Keranjang Pembelian</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <?php 
        $total = array();
        $this->db->join('question','uji.id_question = question.id','left');
        $this->db->where('uji.id_invoice',0);
        $this->db->where('uji.id_admin',$this->session->userdata('id'));
        $uji = $this->db->get('uji')->result_array();
        foreach($uji as $u){
          $total[] = $u['peserta'] * $u['discount'];
        }
        $total = array_sum($total);
        ?>
        <div class="modal-body form">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="table_keranjang" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Judul</th>
                    <th>cover</th>
                    <th>Jadwal</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="6">Total</td>
                    <td>
                    <div id="total">
                      <?=(int)$total?>
                    </div>
                    </td>
                  </tr>
                </tfoot>  

              </table>
            </div>
          </div>
        </div>  
        <div class="modal-footer">
          <a href="<?=base_url('rekap/beli/')?>">
          <button type="button" id="btnSave" class="btn btn-primary">Beli</button>
          </a>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- End Bootstrap modal -->