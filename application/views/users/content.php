<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Data Users</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <button class="btn btn-success" onclick="add_users()"><i class="glyphicon glyphicon-plus"></i> Add New User</button>
      <a href="<?=base_url().'import_users/'?>"><button style="float:right;" class="btn btn-warning"><i class="glyphicon glyphicon-plus"></i>Import users</button><a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="table_users" width="100%" cellspacing="0">
          <thead>
            <tr>
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
          <form action="javascript:void(0)" id="form" class="form-horizontal">
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
                    <option>-- Select Jabatan --</option>
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
                     <option>-- Select Grade --</option>
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
          <form action="javascript:void(0)" id="form" class="form-horizontal">
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
              <div class="form-group">
                <label class="control-label col-md-3">Bidang</label>
                <div class="col-md-9">
                  <input readonly name="field" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Level</label>
                <div class="col-md-9">
                  <input readonly name="division" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Jabatan</label>
                <div class="col-md-9">
                  <input readonly name="position" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Grade</label>
                <div class="col-md-9">
                  <select readonly name="grade" id="grade_id" class="form-control">
                    <?php foreach($grade as $g){ ?>
                      <option value="<?=$g['id']?>"><?=$g['grade']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- End Bootstrap modal -->