<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Pengajuan Materi</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="table_price_question" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul</th>
              <th>Bidang</th>
              <th>Level</th>
              <th>Jabatan</th>
              <th>Grade</th>
              <th>Status</th>
              <th>Harga Coret</th>
              <th>Harga Asli</th>
              <th>Waktu Pengerjaan</th>
              <th>Nilai</th>
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
                <label class="control-label col-md-3">Judul</label>
                <div class="col-md-9">
                  <input disabled name="judul" class="form-control" type="text" value="">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Pembuat</label>
                <div class="col-md-9">
                  <input disabled name="pembuat" class="form-control" type="text" value="">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Harga Coret</label>
                <div class="col-md-9">
                  <input name="harga" class="form-control" type="text" value="">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Harga</label>
                <div class="col-md-9">
                  <input name="diskon" class="form-control" type="text" value="">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-6">Waktu Pengerjaan (Menit)</label>
                <div class="col-md-9">
                  <input name="time" class="form-control" type="text" value="">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-6">Nilai Minimal</label>
                <div class="col-md-9">
                  <input name="nilai" class="form-control" type="text" value="">
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