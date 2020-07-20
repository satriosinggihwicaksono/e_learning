<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Pembuatan Materi</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <button class="btn btn-success" onclick="add_question()"><i class="glyphicon glyphicon-plus"></i> Tambah Materi</button>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="table_question" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul</th>
              <th>Bidang</th>
              <th>Level</th>
              <th>Jabatan</th>
              <th>Grade</th>
              <th>Status</th>
              <th>Total Soal</th>
              <th>Materi</th>
              <th>Sub Soal</th>
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
          <form action="javascript:void(0)" id="form" class="form-horizontal" enctype="multipart/form-data">
            <input type="hidden" value="" name="id"/> 
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Judul</label>
                <div class="col-md-9">
                  <input name="question" class="form-control" type="text" value="">
                </div>
              </div>
              <?php if($this->session->userdata('level') != 'content'){ ?>
              <div class="form-group">
                <label class="control-label col-md-3">Bidang</label>
                <div class="col-md-9">
                  <select name="field" class="form-control">
                    <?php foreach($field as $f){ ?>
                    <option value="<?=$f['id']?>"><?=$f['field']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <?php } ?>
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
              <div class="form-group">
                <div class="control-group form-group">
                    <div class="controls">
                        <label class="control-label col-md-3">Cover</label>
                        <input name="photo" type="file" id="upload_image" required>
                        <div id="uploaded_image"></div>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="control-group form-group">
                    <div class="controls">
                    <hr>
                      <div class="row">
                        <div class="col-md-4">
                          <label class="control-label col-md-3">Article</label>
                          <input type="checkbox" id="article" name="article" value="1">
                        </div>
                        <div class="col-md-4">
                          <label class="control-label col-md-3">Video</label>
                          <input type="checkbox" id="video" name="video" value="1">
                        </div>
                        <div class="col-md-4">
                          <label class="control-label col-md-3">Soal</label>
                          <input type="checkbox" id="soal" name="soal" value="1">
                        </div>
                      </div>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="control-group form-group">
                    <div class="controls">
                        <label class="control-label col-md-3">Ringkasan</label>
                        <textarea id="ringkasan" class="texteditor" name="ringkasan"></textarea>
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
          <form action="javascript:void(0)" id="form" class="form-horizontal">
            <input type="hidden" value="" name="id"/> 
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Judul</label>
                <div class="col-md-9">
                  <input readonly name="question" class="form-control" type="text" value="">
                </div>
              </div>
              <?php if($this->session->userdata('level') != 'content'){ ?>
              <div class="form-group">
                <label class="control-label col-md-3">Bidang</label>
                <div class="col-md-9">
                  <select readonly name="field" class="form-control">
                    <?php foreach($field as $f){ ?>
                    <option value="<?=$f['id']?>"><?=$f['field']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <?php } ?>
              <div class="form-group">
                <label class="control-label col-md-3">Level</label>
                <div class="col-md-9">
                  <select readonly name="division" class="form-control">
                    <?php foreach($division as $d){ ?>
                    <option value="<?=$d['id']?>"><?=$d['division']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Jabatan</label>
                <div class="col-md-9">
                  <select readonly name="position" class="form-control">
                    <?php foreach($position as $p){ ?>
                    <option value="<?=$p['id']?>"><?=$p['position']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label readonly class="control-label col-md-3">Grade</label>
                <div class="col-md-9">
                  <select readonly name="grade" class="form-control">
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