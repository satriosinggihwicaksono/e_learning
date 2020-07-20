<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Data Video</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No.</th>
              <th>Judul</th>
              <th>Video</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
            $x = 1; 
            foreach($data as $d){ 
          ?>
            <tr>
              <td><?=$x++?></td>
              <td><?=$d['title']?></td>
              <td><?php echo '<a rel="noopener" target="_blank" href="'.base_url('article/play/'.$d['id']).'">'.$d['video'].'</a>'; ?></td>
              <td>
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modaldetail<?=$d['id']?>">Detail</button>
              </td>
            </tr>
            <!-- Bootstrap modal -->
            <div class="modal fade" id="modaldetail<?=$d['id']?>" role="dialog">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Artikel</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <div class="modal-body form">
                      <div class="form-body">
                        <div class="form-group">
                            <img scr="<?=base_url().'assets/files/article/'.$d['video']?>" width="200px">
                        </div>
                      </div>
                      <div class="form-body">
                        <div class="form-group">
                          <label class="control-label col-md-3">Judul</label>
                            <input name="position" class="form-control" value="<?=$d['title']?>" disabled>
                        </div>
                      </div>
                      <div class="form-body">
                        <div class="form-group">
                          <label class="control-label col-md-3">Artikel</label>
                          <?=$d['article']?>
                        </div> 
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Bootstrap modal -->
          <?php } ?>  
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>