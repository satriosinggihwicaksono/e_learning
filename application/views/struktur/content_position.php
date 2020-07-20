<div class="container-fluid">
  <!-- Page Heading -->
  <?php 
  $this->db->join('field','paket.id_field = field.id','left');
  $this->db->where('paket.id',$this->uri->segment(4));
  $perusahaan = $this->db->get('paket')->row_array();

  $this->db->join('division','division_p.id_division = division.id','left');
  $this->db->where('division_p.id',$this->uri->segment(3));
  $level = $this->db->get('division_p')->row_array();
  ?>
  <h5>Nama : <?=$perusahaan['paket']?></h5>
  <h5>Bidang : <?=$perusahaan['field']?></h5>
  <h5>Jabatan : <?=$level['division']?></h5>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <button class="btn btn-success" data-toggle="modal" data-target="#tambah"><i class="glyphicon glyphicon-plus"></i> Tambah Jabatan</button>
      <a href="<?=base_url().'struktur/level/'.$this->uri->segment(4)?>" style="float:right;"><button class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Back</button></a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="table" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Jabatan</th>
              <th>Grade</th>
              <th style="width:189px;">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php 
            $x = 1;
            foreach($data as $d){
          ?>
            <tr>
              <td><?=$x++;?></td>
              <td><?=$d['position']?></td>
              <td><a data-toggle="modal" data-target="#deletegrade<?=$d['id_position']?>">
                  <?php 
                    $this->db->join('grade','grade.id = grade_p.id_grade','left');
                    $this->db->where('id_paket',$this->uri->segment(4));
                    $this->db->where('id_position',$d['id_position']);
                    $this->db->where('id_division',$this->uri->segment(3));
                    $grade = $this->db->get('grade_p')->result_array();
                    $count = count($grade);
                    $x = 1;
                    foreach($grade as $g){
                      $total =  $count - $x++;
                      if($count == 1 || $total == 0){
                        echo $g['grade'];
                      } else {
                        echo $g['grade'].', ';
                        
                      }
                    }
                  ?>
              </a>    
              </td>
              <td>
                  <button class="btn btn-success" data-toggle="modal" data-target="#tambahgrade<?=$d['id_position']?>"><i class="glyphicon glyphicon-plus"></i> Tambah Grade</button>
                  <a href="<?=base_url('struktur/deleteposition/'.$d['id_position'].'/'.$this->uri->segment(3).'/'.$this->uri->segment(4));?>"><button class="btn btn-danger">Delete</button></a>
              </td>            
            </tr>

                <div class="modal fade" id="tambahgrade<?=$d['id_position']?>" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Grade</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <form action="<?=base_url().'struktur/addgrade/'.$this->uri->segment(4).'/'.$this->uri->segment(3);?>" method="post" id="form" class="form-horizontal">
                      <div class="modal-body form">
                        <input type="hidden" value="<?=$d['id_position']?>" name="id_position"/> 
                          <div class="form-body">
                            <div class="form-group">
                              <label class="control-label col-md-3">Grade</label>
                              <div class="col-md-9">
                                <?php
                                  $this->db->where('deleted_at',null); 
                                  $grade = $this->db->get('grade')->result_array(); 
                                ?>
                                <select name="id_grade[]" id="grade<?=$d['id_position']?>" style="width:100%;" multiple="multiple">
                                  <?php foreach($grade as $g){ ?>
                                  <option value="<?=$g['id']?>"><?=$g['grade']?></option>
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

                <div class="modal fade" id="deletegrade<?=$d['id_position']?>" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Grade</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body form">
                        <input type="hidden" value="<?=$d['id_position']?>" name="id_position"/> 
                          <div class="form-body">
                            <div class="form-group">
                              <div class="col-md-12">
                              <?php 
                                  $this->db->select('*,grade_p.id as grade_id');
                                  $this->db->join('grade','grade.id = grade_p.id_grade','left');
                                  $this->db->where('id_paket',$this->uri->segment(4));
                                  $this->db->where('id_position',$d['id_position']);
                                  $this->db->where('id_division',$this->uri->segment(3));
                                  $grade = $this->db->get('grade_p')->result_array();
                                  foreach($grade as $g){
                                    echo '<br>
                                          <div class="row">
                                            <div class="col-md-6">'
                                            .$g['grade'].
                                            '</div>
                                            <div class="col-md-6">
                                              <a href="'.base_url("struktur/deletegrade/".$g['grade_id']."/".$this->uri->segment(4)."/".$this->uri->segment(3)).'"><button class="btn btn-danger">Delete</button></a>
                                            </div>
                                          </div>';  
                                  }
                              ?>
                              </div>
                            </div>
                          </div>
                      </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
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
          <h5 class="modal-title" id="exampleModalLabel">Tambah Grade</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="<?=base_url().'struktur/addposition/'.$this->uri->segment(4).'/'.$this->uri->segment(3);?>" method="post" id="form" class="form-horizontal">
        <div class="modal-body form">
           <input type="hidden" value="" name="id"/> 
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Position</label>
                <div class="col-md-9">
                  <?php
                    $this->db->where('deleted_at',null); 
                    $position = $this->db->get('position')->result_array(); 
                  ?>
                  <select name="id_position" id="division" style="width:100%;">
                    <?php foreach($position as $d){ ?>
                    <option value="<?=$d['id']?>"><?=$d['position']?></option>
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