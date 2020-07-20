<style>
.carousel-caption {
  position: absolute;
  right: 15%;
  top: 10px;
  left: 15%;
  z-index: 10;
  padding-top: 20px;
  padding-bottom: 20px;
  color: black;
  text-align: left;
}
.carousel-item {
  position: relative;
  display: none;
  float: left;
  width: 100%;
  height: 100%;
  margin-right: -100%;
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  transition: transform 0.6s ease-in-out;
}

</style>
<?php 
  if(!empty($audit_question)){
    $revision = $audit_question[0]['revision'];
    $description = $audit_question[0]['description'];
    $status = $audit_question[0]['status'];  
    $arr_revision = explode(',',$revision);
  } else {
    $revision = '';
    $description = '';
    $status = '';
    $arr_revision = array();
  }
?>

<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Materi Revisi</h1>
  <h5><?php echo $question['question'].' -> '.$question['field'].' -> '.$question['division'].' -> '.$question['position'].' -> '.$question['grade']?></h5>
  <!-- DataTales Example -->
  <a href="javascript:void(0)" class="btn btn-success" style="margin-bottom:10px;" data-target="#status_modal" data-toggle="modal">History Audit</a>
  <div class="card shadow mb-4">
    <div class="card-body">  
      <form action="<?= base_url('audit_question/revision'); ?>" method="post">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <?php 
            $total = count($sub_question);
            for($x=0;$x<$total;$x++){
          ?>
          <li data-target="#carouselExampleIndicators" <?php if(in_array($sub_question[$x]['id'],$arr_revision)){ echo 'class="active"';}?> data-slide-to="<?=$x?>"></li>
          <?php 
            } 
          ?>
        </ol>
          <div class="carousel-inner">
            <?php 
              $x = 1;
              foreach($sub_question as $sb){
            ?>
            <div class="carousel-item <?php if($sub_question[0]['id'] == $sb['id']){echo 'active';} ?>">
              <img class="d-block w-100" src="<?=base_url('assets/img/bg.jpg')?>" alt="First slide"style="height:450px;">
                <div class="carousel-caption d-none d-md-block" style="text-align:left;">
                  <?='Soal No.'.$x++;?> 
                  <div style="float:right;">
                      <b>Revisi</b> <input type="checkbox" name="revision[]" <?php if(in_array($sb['id'],$arr_revision)){ echo 'checked';} ?> value="<?=$sb['id']?>">
                  </div>   
                  <hr>
                  <div style="color:black;">
                    <?=$sb['sub_question']?>
                  </div>                
                  <h5 style="font-size:12px; color:black;">A. <?=$sb['a']?></h5>
                  <h5 style="font-size:12px; color:black;">B. <?=$sb['b']?></h5>
                  <h5 style="font-size:12px; color:black;">C. <?=$sb['c']?></h5>
                  <h5 style="font-size:12px; color:black;">D. <?=$sb['d']?></h5>
                  <h5 style="font-size:12px; color:black;">E. <?=$sb['e']?></h5>
                </div>
            </div>
            <?php } ?>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
        <br>
        <?php 
          $st = array();
          $st[0]['rev'] = 'send';
          $st[0]['status'] = 'kirim';
          $st[1]['rev'] = 'revision';
          $st[1]['status'] = 'revisi';
          $st[2]['rev'] = 'apply';
          $st[2]['status'] = 'diterima';
        ?>
        <label class="control-label col-md-3">Status : </label>
        <select class="control-label" name="status">
          <?php foreach($st as $s){?>
            <option <?php if($s['rev'] == $status){echo 'selected="selected"';}?> value="<?=$s['rev']?>"><?=strtoupper($s['status'])?></option>
          <?php } ?>
        </select>
        <br>
        <label class="control-label col-md-3">Catatan</label>
        <input type="hidden" name="id_question" value="<?=$this->uri->segment(3);?>"/>
        <input type="hidden" name="type" value="question"/>
        <textarea id="sub_question" class="texteditor" name="description"><?=$description?></textarea>
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
                    <th>Revisi</th>
                    <th>Status</th>
                    <th>Deskripsi</th>
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
                      <td><?=$aq['revision']?></td>
                      <td><?=$aq['status']?></td>
                      <td><?=$aq['description']?></td>
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