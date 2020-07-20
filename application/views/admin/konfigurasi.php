<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Konfigurasi</h1>

  <div id="notifications"><?php echo $this->session->flashdata('msg'); ?></div>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
    <form action="<?=base_url().'admin/addkonfigurasi';?>" class="form-horizontal" method="POST">
        <div class="collapse show" id="collapseCardExample">
          <div class="row">
            <div class="col-md-12">  
             <div class="card-body">
                <label class="control-label col-md-3">Nama Aplikasi</label>
                  <input name="name" class="form-control" type="text" value="<?=$config['name']?>">
              </div>
            </div>  
          </div>  
          <div class="modal-footer">
          <input class="btn btn-sm btn-info" type="Submit" value="Submit" />
          </div>
        </div>
    </form>   
    </div>
  </div>
</div>