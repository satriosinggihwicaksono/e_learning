<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-500" style="font-size:20px;"><?php echo $question['question'].' -> '.$question['field'].' -> '.$question['division'].' -> '.$question['position'].' -> '.$question['grade']?></h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <button class="btn btn-success" onclick="add_sub_question()"><i class="glyphicon glyphicon-plus"></i> Tambah Sub Soal</button>
      
      <button href="javascript:void(0)" data-target="#status_modal" data-toggle="modal" style="float:right; margin-left:3px" class="btn btn-sm btn-info" ><i class="glyphicon glyphicon-plus"></i>History Audit</button>
      <button style="float:right; margin-left:3px" class="btn btn-sm btn-primary" onclick="audit_question()"><i class="glyphicon glyphicon-plus"></i> Status</button>
      <a href="<?=base_url().'import_question/index/'.$this->uri->segment(3);?>"><button style="float:right;" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-plus"></i>Import Soal</button><a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="table_sub_question" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Pertanyaan</th>
              <th>Jawaban</th>
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
    <div class="modal-dialog modal-lg">
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
                <label class="control-label col-md-3">Soal</label>
                <div class="col-md-12">
                <textarea id="sub_question" class="texteditor" name="sub_question"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                    <label class="control-label">Jawab A.</label>
                    <input name="a" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="control-label">Jawab B.</label>
                    <input name="b" class="form-control">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                    <label class="control-label">Jawab C.</label>
                    <input name="c" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="control-label">Jawab D.</label>
                    <input name="d" class="form-control">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                    <label class="control-label">Jawab E.</label>
                    <input name="e" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="control-label">Jawaban Benar</label>
                    <select name="answer" class="form-control">
                      <option value="a">A</option>
                      <option value="b">B</option>
                      <option value="c">C</option>
                      <option value="d">D</option>
                      <option value="e">E</option>
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
    <div class="modal-dialog modal-lg">
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
                <label class="control-label col-md-3">Soal</label>
                <div class="col-md-12">
                <textarea readonly id="sub_question" class="texteditor" name="sub_question"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                    <label class="control-label">Jawab A.</label>
                    <input readonly name="a" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="control-label">Jawab B.</label>
                    <input readonly name="b" class="form-control">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                    <label class="control-label">Jawab C.</label>
                    <input readonly name="c" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="control-label">Jawab D.</label>
                    <input readonly name="d" class="form-control">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                    <label class="control-label">Jawab E.</label>
                    <input readonly name="e" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="control-label">Jawaban Benar</label>
                    <select readonly name="answer" class="form-control">
                      <option value="a">A</option>
                      <option value="b">B</option>
                      <option value="c">C</option>
                      <option value="d">D</option>
                      <option value="e">E</option>
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


  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_audit" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Status Audit</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body form">
          <form href="javascript:void(0)" id="form_audit" class="form-horizontal">
            <input type="hidden" value="" name="id"/> 
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Revision</label>
                <div class="col-md-12">
                <input id="title" class="form-control" name="revision">
                </div>
              </div>
            </div>
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Artikel</label>
                <div class="col-md-12">
                <textarea id="sub_question" class="texteditor" name="description"></textarea>
                </div>
              </div>
            </div>
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Status</label>
                <div class="col-md-12">
                  <select name="status" class="form-control">
                    <option value="send">Kirim</option>
                    <option value="revision">Revisi</option>
                    <option value="apply">Diterima</option>
                  </select>
                </div>
              </div>
            </div> 
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save_audit()" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

<!-- Bootstrap modal -->
<div class="modal fade" id="status_modal" role="dialog">
    <div class="modal-dialog modal-lg" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">History Status</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body form">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="table_audit_history" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Revisi</th>
                    <th>Status</th>
                    <th>Deskripsi</th>
                    <th>Waktu</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>  
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->