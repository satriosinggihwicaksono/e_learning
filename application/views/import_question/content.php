<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-500" style="font-size:20px;"><?php echo $question['question'].' -> '.$question['field'].' -> '.$question['division'].' -> '.$question['position'].' -> '.$question['grade']?></h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="row">
        <div class="col-md-5">
          <form action="<?=base_url().'import_question/import_temp/'.$this->uri->segment(3)?>" method="post" enctype="multipart/form-data">
              <input type="file" name="file" id="fileToUpload">
              <input class="btn btn-sm btn-success" type="submit" value="Import Excel" name="submit">
          </form>
          <br>
          <button class="btn btn-success" onclick="add_import_question()"><i class="glyphicon glyphicon-plus"></i> Tambah Sub Soal</button>
        </div>
        <div class="col-md-7">
          <a href="<?=base_url().'import_question/import/'.$this->uri->segment(3)?>"><input class="btn btn-sm btn-info" style="float:right;" type="submit" value="Submit" name="submit"></a>
          <a href="<?=base_url().'import_question/clear/'.$this->uri->segment(3)?>"><input class="btn btn-sm btn-danger" style="float:right;" type="submit" value="Clear Import" name="submit"></a>
          <a href="<?=base_url().'assets/files/import_question.xlsx'?>"><input class="btn btn-sm btn-warning" style="float:right;" type="submit" value="Template" name="submit"></a>
        </div>   
      </div>
    </div>
    <div id="notifications"><?php echo $this->session->flashdata('msg'); ?></div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="table_import_question" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Pertanyaan</th>
              <th>Jawaban</th>
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
                <textarea id="import_question" class="texteditor" name="import_question"></textarea>
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
                <textarea readonly id="import_question" class="texteditor" name="import_question"></textarea>
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