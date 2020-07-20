<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Data Bank Soal</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="table_bank_question" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul</th>
              <th>Cover</th>
              <th>Bidang</th>
              <th>Level</th>
              <th>Jabatan</th>
              <th>Grade</th>
              <th>Pembuat</th>
              <th>Action</th>
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
<div class="modal fade" id="modal_view" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body form">
        <form href="javascript:void(0)" id="form_data" class="form-horizontal">
            <input type="hidden" value="" name="id"/> 
            <div class="row">
              <div class ="col-md-4">
                <div id="image"></div>
              </div>
              <div class="col-md-8">
                <div class="form-body">
                  <div class="form-group">
                    <label class="control-label col-md-3">Judul</label>
                    <div class="col-md-9">
                      <input readonly name="question" class="form-control" type="text" value="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3">Bidang</label>
                    <div class="col-md-9">
                      <input readonly name="field" class="form-control" type="text" value="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3">Level</label>
                    <div class="col-md-9">
                      <input readonly name="division" class="form-control" type="text" value="">
                    </div>
                  </div>
                </div>
              </div>
            </div>  
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Jabatan</label>
                    <input readonly name="position" class="form-control" type="text" value="">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label readonly class="control-label col-md-3">Grade</label>
                    <input readonly name="grade" class="form-control" type="text" value="">
                  </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label col-md-3">Ringkasan</label>
                    <input readonly name="ringkasan" class="form-control" type="text" value="">
                </div>
              </div>
            </div>  
        </div>
      </form>  
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->