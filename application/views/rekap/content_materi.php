<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Materi Saya</h1>

  <div class="row">
      <?php 
        foreach($data as $d){
      ?>
      <div class="col-xl-3 col-md-6 mb-4">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><?=$d['question']?></h6>
            </div>
            <div class="card-body">
              <div class="text-center">
                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="<?=base_url().'assets/files/question/'.$d['cover']?>" alt="">
              </div>
              <div>
              <table>
                <tr style="color:red;">
                  <td>Bidang</td>
                  <td> : </td>
                  <td><?=$d['field']?></td>
                </tr>
                <tr style="color:purpple;">
                  <td>Level</td>
                  <td> : </td>
                  <td><?=$d['division']?></td>
                </tr>
                <tr style="color:blue;">
                  <td>Jabatan</td>
                  <td> : </td>
                  <td><?=$d['position']?></td>
                </tr>
                <tr style="color:green;">
                  <td>Grade</td>
                  <td> : </td>
                  <td><?=$d['grade']?></td>
                </tr>
              </table>
              </div>
              <div class="text-right">
                <button onclick="view_materi('<?=$d['id']?>')" class="btn btn-sm btn-success">Detail</button>
              </div>  
            </div>
          </div>  
      </div>
      <?php } ?>
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
        <form id="form" class="form-horizontal" onSubmit="save_e(); return false;" action="javascript:void(0)">
          <input type="hidden" value="" name="id"/> 
          <div class="form-body">
            <div class="form-group">
             <div class="row"> 
                <div class="col-md-12" style="text-align:center">
                    <div id="image"></div>
                </div>
             </div>
            </div>
          </div>
          <div class="form-body">
            <div class="form-group">  
              <div class="col-md-12" style="text-align:center">
                  <span id="article"></span>
                  <span id="soal"></span>
                  <span id="video"></span>
              </div>
            </div>
          </div>    
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Judul</label>
              <div class="col-md-12">
                <input name="question" class="form-control" disabled>
              </div>
            </div>
          </div>
          <div class="row" style="margin-left:1px">
              <div class="col-md-5">
                <div class="form-body">
                  <div class="form-group">
                      <label class="control-label col-md-3">Bidang</label>
                      <input name="field" class="form-control" disabled>
                  </div>
                </div>  
              </div>
              <div class="col-md-5">
                <div class="form-body">
                    <div class="form-group">
                      <label class="control-label col-md-3">Level</label>
                      <input name="division" class="form-control" disabled>
                    </div>
                </div>   
              </div>
          </div>  

          <div class="row" style="margin-left:1px">
            <div class="col-md-5">
              <div class="form-body">
                <div class="form-group">
                  <label class="control-label col-md-3">Jabatan</label>
                    <input name="position" class="form-control" disabled>
                </div>
              </div>
            </div>  
            <div class="col-md-5">
              <div class="form-body">
                <div class="form-group">
                  <label class="control-label col-md-3">Grade</label>
                    <input name="grade" class="form-control" disabled>
                </div>
              </div>
            </div>  
          </div>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Ringkasan</label>
              <div class="col-md-12">
                <textarea name="ringkasan" class="texteditor" disabled></textarea>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
