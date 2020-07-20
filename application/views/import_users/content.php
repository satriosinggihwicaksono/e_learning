<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Data Import Users</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="row">
          <div class="col-md-5">
            <form action="<?=base_url().'import_users/import_temp/'.$this->uri->segment(3)?>" method="post" enctype="multipart/form-data">
                <input type="file" name="file" id="fileToUpload">
                <input class="btn btn-sm btn-success" type="submit" value="Import Excel" name="submit">
            </form>
            <br>
            <button class="btn btn-success" onclick="add_import_users()"><i class="glyphicon glyphicon-plus"></i> Tambah User</button>
          </div>
          <div class="col-md-7">
            <div class="row">
              <div class="col-md-12">
                <a href="<?=base_url().'import_users/import/'.$this->uri->segment(3)?>"><input class="btn btn-sm btn-info" style="float:right; margin:3px;" type="submit" value="Tambahkan" name="submit"></a>
                <a href="<?=base_url().'import_users/clear/'.$this->uri->segment(3)?>"><input class="btn btn-sm btn-danger" style="float:right; margin:3px;" type="submit" value="Bersihkan Data" name="submit"></a>
                <a href="<?=base_url().'assets/files/import_users.xlsx'?>"><input class="btn btn-sm btn-warning" style="float:right; margin:3px;" type="submit" value="Template" name="submit"></a>
              </div>
            </div>
            <div class="row" style="margin-top:3px;">
              <div class="col-md-12">
                <a href="" class="btn btn-sm btn-primary" style="float:right; margin:3px;" data-target="#grade_modal" data-toggle="modal">Grade</a>
                <a href="" class="btn btn-sm btn-secondary" style="float:right; margin:3px;" data-target="#position_modal" data-toggle="modal">Jabatan</a>
                <a href="" class="btn btn-sm btn-primary" style="float:right; margin:3px;" data-target="#division_modal" data-toggle="modal">Level</a>
                <a href="" class="btn btn-sm btn-success" style="float:right; margin:3px;" data-target="#field_modal" data-toggle="modal">Bidang</a>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div id="notifications"><?php echo $this->session->flashdata('msg'); ?></div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="table_import_users" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Name</th>
              <th>Email</th>
              <th>Bidang</th>
              <th>Level</th>
              <th>Jabatan</th>
              <th>Grade</th>
              <th>Status</th>
              <th style="width:189px;">Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
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
          <form href="javascript:void(0)" id="form" class="form-horizontal">
            <input type="hidden" value="" name="id"/> 
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Name</label>
                <div class="col-md-9">
                  <input name="name" placeholder="Name" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Email</label>
                <div class="col-md-9">
                  <input name="email" placeholder="contoh@gmail.com" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Status</label>
                <div class="col-md-9">
                  <select class="form-control" name="status">
                      <option value="A">Active</option>
                      <option value="N">Non Active</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Level</label>
                <div class="col-md-9">
                  <select name="division" id="division_id" class="form-control">
                    <option>-- Select Level --</option>
                    <?php foreach($division as $d){ ?>
                    <option data-id="<?=$d['id_division']?>" value="<?=$d['id']?>"><?=$d['division']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Jabatan</label>
                <div class="col-md-9">
                  <select name="position" id="position_id" class="form-control">
                    <option>-- Select Level --</option>
                    <?php foreach($position as $p){ ?>
                      <option value="<?=$p['id']?>"><?=$p['position']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Grade</label>
                <div class="col-md-9">
                  <select name="grade" id="grade_id" class="form-control">
                     <option>-- Select Level --</option>
                    <?php foreach($grade as $g){ ?>
                      <option value="<?=$g['id']?>"><?=$g['grade']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>  
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- End Bootstrap modal -->

  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_view" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body form">
          <form href="javascript:void(0)" id="form" class="form-horizontal">
            <input type="hidden" value="" name="id"/> 
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Name</label>
                <div class="col-md-9">
                  <input readonly name="name" placeholder="Name" class="form-control" type="text">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3">Email</label>
                <div class="col-md-9">
                  <input readonly name="email" placeholder="contoh@gmail.com" class="form-control" type="text">
                </div>
              </div>
            </div>
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <!-- Bootstrap modal -->
  <div class="modal fade" id="field_modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Daftar Bidang</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body form">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="table_field" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Bidang</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                      <td><?=$field['id']?></td>
                      <td><?=$field['field']?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>  
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <!-- Bootstrap modal -->
  <div class="modal fade" id="division_modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Daftar Bidang</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body form">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="table_division" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Bidang</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($division as $d){ ?>
                  <tr>
                      <td><?=$d['id']?></td>
                      <td><?=$d['division']?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>  
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <!-- Bootstrap modal -->
  <div class="modal fade" id="position_modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Daftar Bidang</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body form">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="table_position" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Bidang</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($position as $p){ ?>
                  <tr>
                      <td><?=$p['id']?></td>
                      <td><?=$p['position']?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>  
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <!-- Bootstrap modal -->
  <div class="modal fade" id="grade_modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Daftar Grade</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body form">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="table_position" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Grade</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($grade as $g){ ?>
                  <tr>
                      <td><?=$g['id']?></td>
                      <td><?=$g['grade']?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>  
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- End Bootstrap modal -->