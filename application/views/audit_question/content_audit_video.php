
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Materi Revisi</h1>
  <h5><?php echo $question['question'].' -> '.$question['field'].' -> '.$question['division'].' -> '.$question['position'].' -> '.$question['grade']?></h5>
  <!-- DataTales Example -->
  <a href="javascript:void(0)" class="btn btn-success" style="margin-bottom:10px;" data-target="#status_modal" data-toggle="modal">History Audit</a>
  <div class="card shadow mb-4">
    <div class="card-body">  
      <form action="<?= base_url('audit_question/revision'); ?>" method="post">
        <div class="table-responsive">
          <table class="table table-bordered" id="table_article" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Judul</th>
                <th style="width:189px;">video</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $x = 1; 
                foreach($video_question as $aq){
              ?>
              <tr>
                <td><?=$x++?></td>
                <td><?=$aq['title']?></td>
                <td><a rel="noopener" target="_blank" href="<?=base_url('article/play/'.$aq['id'])?>"><?=$aq['video']?></a></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <hr>
        <?php 
          $st = array();
          $st[0]['rev'] = 'revision';
          $st[0]['status'] = 'revisi';
          $st[1]['rev'] = 'apply';
          $st[1]['status'] = 'diterima';
        ?>
        <label class="control-label col-md-3">Status : </label>
        <select class="control-label" name="status">
          <?php foreach($st as $s){?>
            <option value="<?=$s['rev']?>"><?=strtoupper($s['status'])?></option>
          <?php } ?>
        </select>
        <br>
        <label class="control-label col-md-3">Catatan</label>
        <input type="hidden" name="id_question" value="<?=$this->uri->segment(3);?>"/>
        <input type="hidden" name="type" value="video"/>
        <textarea id="sub_question" class="texteditor" name="description"></textarea>
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="Save" />
        <a href="<?=base_url('audit_question');?>"><button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></a>
      </div>
    </form>
  </div>
</div>

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
              <table class="table table-bordered" id="table_position" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Status</th>
                    <th>Deskripsi</th>
                    <th>Waktu</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $x = 1; 
                    foreach($audit_question as $aq){ 
                  ?>
                  <tr>
                      <td><?=$x++?></td>
                      <td><?=$aq['status']?></td>
                      <td><?=$aq['description']?></td>
                      <td><?=$aq['time']?></td>
                      <td>
                          <a href="<?=base_url('audit_question/hapus_audit/'.$aq['id'])?>" class="btn btn-danger">Hapus</a>
                      </td>
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