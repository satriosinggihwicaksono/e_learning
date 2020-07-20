<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Daftar Ujian</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <button class="btn btn-success" onclick="add_rekap_detail()"><i class="glyphicon glyphicon-plus"></i> Tambah Jadwal Uji</button>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="table_rekap_detail" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Judul Soal</th>
              <th>Tanggal Ujian</th>
              <th>Artikel</th>
              <th>Video</th>
              <th>Soal</th>
              <th>Peserta</th>
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
                <label class="control-label col-md-3">Judul Soal</label>
                <div class="col-md-9">
                 <select name="id_question" id="id_question" style="width:100%;">
                    <option></option>
                    <?php foreach($question as $q){ ?>
                      <option value="<?=$q['id']?>"><?=$q['question']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Tanggal Uji</label>
                <div class="col-md-9">
                      <input type="date" class="form-control" id="time" name="time" />
                      <input type="hidden" class="form-control" name="id_field" value="<?=$id_field?>"/>
                      <input type="hidden" class="form-control" name="id_position" value="<?=$id_position?>"/>
                      <input type="hidden" class="form-control" name="id_division" value="<?=$id_division?>"/>
                      <input type="hidden" class="form-control" name="grade" value="<?=$grade?>"/>
                      
                </div>
              </div>
              <div class="form-group">
                  <div class="col-md-12">
                    <div class="row" style="text-align:center;">
                      <div class="col-md-4">
                        <label class="control-label">Artikel</label>
                        <input type="checkbox" class="form-control" id="article" name="article" value="1"/>
                      </div>
                      <div class="col-md-4">
                        <label class="control-label">Video</label>
                        <input type="checkbox" class="form-control" id="video" name="video" value="1"/>
                      </div>
                      <div class="col-md-4">
                        <label class="control-label">Soal</label>
                        <input type="checkbox" class="form-control" id="question" name="question" value="1"/>
                      </div>
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
              <div class="form-body">
                <div class="form-group">
                  <label class="control-label col-md-3">Name</label>
                  <div class="col-md-9">
                    <input readonly name="name" class="form-control" type="text">
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- End Bootstrap modal -->