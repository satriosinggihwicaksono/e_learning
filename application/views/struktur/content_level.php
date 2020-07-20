<div class="container-fluid">
  <!-- Page Heading -->
  <?php 
  $this->db->join('field','paket.id_field = field.id','left');
  $this->db->where('paket.id',$this->uri->segment(3));
  $perusahaan = $this->db->get('paket')->row_array();
  ?>
  <h2 class="h3 mb-2 text-gray-800">Kategori : <?=$perusahaan['paket']?></h2>
  <h2 class="h3 mb-2 text-gray-800">Bidang : <?=$perusahaan['field']?></h2>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <button class="btn btn-success" data-toggle="modal" data-target="#tambah"><i class="glyphicon glyphicon-plus"></i> Tambah Level</button>
      <a href="<?=base_url().'struktur'?>" style="float:right;"><button class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Back</button></a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="table" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Level</th>
              <th>Jabatan</th>
              <th style="width:189px;">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php 
            $x = 1;
            $this->db->select('*,division_p.id as id_division');
            $this->db->join('division','division.id = division_p.id_division','left');
            $this->db->where('division_p.id_paket',$this->uri->segment(3));
            $data = $this->db->get('division_p')->result_array();
            foreach($data as $d){
          ?>
            <tr>
              <td><?=$x++;?></td>
              <td><?=$d['division']?></td>
              <td>
                <?php 
                  $position = '';
                  $this->db->select('position.position');
                  $this->db->join('position','position_p.id_position = position.id','left');
                  $this->db->where('position_p.id_division',$d['id_division']);
                  $jabatan = $this->db->get('position_p')->result_array();
                  $count = count($jabatan);
                  $x = 1;
                  foreach($jabatan as $j){
                    $total =  $count - $x++;
                    if($count == 1 || $total == 0){
                      $position .= $j['position'];  
                    } else {
                      $position .= $j['position'].', ';
                    }
                  }
                  echo $position;
                ?>
              </td>
              <td>
                  <a href="<?=base_url('struktur/position/'.$d['id_division'].'/'.$this->uri->segment(3));?>"><button class="btn btn-warning">tambah</button></a>
                  <a href="<?=base_url('struktur/deletelevel/'.$d['id_division'].'/'.$this->uri->segment(3));?>"><button class="btn btn-danger">Delete</button></a>
              </td>
              
            </tr>
          <?php 
            }
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

  <!-- Bootstrap modal -->
  <div class="modal fade" id="tambah" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Level</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="<?=base_url().'struktur/addlevel/'.$this->uri->segment(3)?>" method="post" id="form" class="form-horizontal">
        <div class="modal-body form">
           <input type="hidden" value="" name="id"/> 
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Level</label>
                <div class="col-md-9">
                  <?php
                    $this->db->where('deleted_at',null); 
                    $division = $this->db->get('division')->result_array(); 
                  ?>
                  <select name="id_division" id="division" style="width:100%;">
                    <?php foreach($division as $d){ ?>
                    <option value="<?=$d['id']?>"><?=$d['division']?></option>
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