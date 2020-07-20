<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Data Administrator</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <form method="post" action="<?=base_url().'admin/add_rekening/';?>" class="form-horizontal">
        <div class="form-group">
          <label class="control-label col-md-3">Nama</label>
          <div class="col-md-6">
            <input name="nama" class="form-control" type="text">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3">No. Rekening</label>
          <div class="col-md-6">
            <input name="norek" class="form-control" type="text">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3">Bank</label>
          <div class="col-md-6">
            <select name="bank" class="form-control">
              <?php foreach($bank as $b){ ?>
              <option value="<?=$b['id']?>"><?=$b['bank']?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-6">
            <input class="btn btn-sm btn-success" type="submit">
          <div>
        </div>
      </form>  
    </div>
    <div class="card-body">
    <div id="notifications"><?php echo $this->session->flashdata('msg'); ?></div>
      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No.</th>
              <th>Nama</th>
              <th>No Rekening</th>
              <th>Bank</th>
              <th style="width:189px;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $x = 1;
            $this->db->select('*,bank.bank as namabank,rekening.id as id_rekening');
            $this->db->join('bank','bank.id = rekening.bank','left');
            $rekening = $this->db->get('rekening')->result_array(); 
             foreach($rekening as $r){ 
            ?>
            <tr>
              <td><?=$x++?></td>
              <td><?=$r['nama']?></td>
              <td><?=$r['norek']?></td>
              <td><?=$r['namabank']?></td>
              <td>
                <a class="btn btn-sm btn-danger" href="<?=base_url('admin/delete_rekening/'.$r['id_rekening']);?>">Delete</button>
              </td>
            </tr>
            <?php } ?>
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
          <form href="javascript:void(0)" id="form" class="form-horizontal" enctype="multipart/form-data">
            <input type="hidden" value="" name="id"/> 
            <div class="form-body">
              <div class="form-group">
                <div class="row">  
                  <div class="col-md-6">
                    <label class="control-label col-md-6">Name</label>
                    <input name="name" class="form-control" type="text">
                  </div>  
                  <div class="col-md-6">
                    <label class="control-label col-md-6">Email</label>
                    <input name="email" class="form-control" type="text">
                  </div>
                </div>  
              </div>
              <div class="form-group">
                <div class="row">  
                  <div class="col-md-6">
                    <label class="control-label col-md-6">Status</label>
                    <select name="status" class="form-control">
                      <option value="A">Aktif</option>
                      <option value="N">Non Aktif</option>
                    </select>
                  </div>
                </div>  
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label class="control-label col-md-6">Jenis Akun</label>
                    <select name="level" class="form-control showhide">
                      <option></option>
                      <option value="corporyte">Perusahaan</option>
                      <option value="content">Content</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="control-label col-md-3">Foto</label>
                    <input name="photo" type="file" id="upload_image" required>
                  </div>
                </div>  
              </div>
              <div class="form-group content drop-down-show-hide">
                <label class="control-label col-md-3">Persentase</label>
                <div class="col-md-9">
                  <input name="presentase" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <div class="control-group form-group">
                    <div class="controls">
                        <div id="uploaded_image"></div>
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