<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Data Administrator</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <button class="btn btn-success" onclick="add_admin()"><i class="glyphicon glyphicon-plus"></i> Tambah Administrator</button>
    </div>
    <div class="card-body">
    <div class="row">
          <div class="col-md-6">
              <div class="form-group row">
                  <label for="txtFirstNameBilling" class="col-lg-2 col-form-label">Fillter</label>
                  <div class="col-lg-9">
                      <select id="level" class="form-control fill-level" name="level">
                        <option value=''>Semua</option>
                          <option value='corporyte'>Perusahaan</option>
                          <option value='content'>Content</option>
                      </select>
                  </div>
              </div>
          </div>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered" id="table_admin" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No.</th>
              <th>Email</th>
              <th>Name</th>
              <th>Level</th>
              <th>Kategori</th>
              <th>Presentase</th>
              <th>Photo</th>
              <th>Tanggal Pembuatan</th>
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
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body form">
          <form href="javascript:void(0)" id="form" class="form-horizontal" enctype="multipart/form-data">
            <input type="hidden" value="" name="id"/> 
            <div class="form-body">
              <div class="form-group">
                <div class="row">  
                  <div class="col-md-6">
                    <label class="control-label col-md-6">Name</label>
                    <input name="name" class="form-control" type="text">
                  </div>  
                  <div class="col-md-6">
                    <label class="control-label col-md-6">Email</label>
                    <input name="email" class="form-control" type="text">
                  </div>
                </div>  
              </div>
              <div class="form-group">
                <div class="row">  
                  <div class="col-md-6">
                    <label class="control-label col-md-6">Status</label>
                    <select name="status" class="form-control">
                      <option value="A">Aktif</option>
                      <option value="N">Non Aktif</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="control-label col-md-6">Kategori</label>
                    <select name="paket" class="form-control">
                      <?php foreach($paket as $p){ ?>
                      <option value="<?=$p['id']?>"><?=$p['paket']?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>  
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label class="control-label col-md-6">Jenis Akun</label>
                    <select name="level" class="form-control showhide">
                      <option></option>
                      <option value="corporyte">Perusahaan</option>
                      <option value="content">Content</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="control-label col-md-3">Foto</label>
                    <input name="photo" type="file" id="upload_image" required>
                  </div>
                </div>  
              </div>
              <div class="form-group content drop-down-show-hide">
                <label class="control-label col-md-3">Persentase</label>
                <div class="col-md-9">
                  <input name="presentase" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <div class="control-group form-group">
                    <div class="controls">
                        <div id="uploaded_image"></div>
                    </div>
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
              <div class="form-body">
                <div class="form-group">
                  <label class="control-label col-md-3">Name</label>
                    <div class="col-md-9">
                      <input readonly name="name" class="form-control" type="text">
                    </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Email</label>
                <div class="col-md-9">
                  <input readonly name="email" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Status</label>
                <div class="col-md-9">
                  <select readonly name="status" class="form-control">
                      <option value="A">Aktif</option>
                      <option value="N">Non Aktif</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Jenis Akun</label>
                <div class="col-md-9">
                    <select name="level" class="form-control showhide">
                      <option></option>
                      <option value="corporyte">Perusahaan</option>
                      <option value="content">Content</option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Bidang</label>
                <div class="col-md-9">
                   <input readonly name="paket" class="form-control" type="text">
                </div>
              </div>
            </div>
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- End Bootstrap modal -->

  <div id="uploadimageModal" class="modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
      		<div class="modal-body">
        		<div class="row">
  					<div class="col-md-8 text-center">
						  <div id="image_demo" style="width:350px; margin-top:30px"></div>
  					</div>
  					<div class="col-md-4" style="padding-top:30px;">
					</div>
				</div>
      		</div>
          <div class="modal-footer">
            <button class="btn btn-success crop_image">Crop Foto</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
    	</div>
    </div>
  </div>