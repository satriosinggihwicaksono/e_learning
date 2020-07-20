<div class="container-fluid">
<div id="notifications"><?php echo $this->session->flashdata('msg'); ?></div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card shadow mb-4">
        <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
          <h6 class="m-0 font-weight-bold text-primary">Edit Password</h6>
        </a>
        <form action="javascript:void(0)" id="form_setting" class="form-horizontal">
        <div class="collapse show" id="collapseCardExample">
          <div class="row">
            <div class="col-md-12">  
            <div class="card-body">
              <label class="control-label col-md-3">Email</label>
                  <input disabled name="email" class="form-control" type="text" value="<?=$this->session->userdata('email')?>">
                  <input name="id" class="form-control" type="hidden" value="<?=$this->session->userdata('id')?>">
              </div>
              <div class="card-body">
                <label class="control-label col-md-3">Password Lama</label>
                  <input name="password_lama" class="form-control" type="password" value="">
              </div>
              <div class="card-body">
                <label class="control-label col-md-3">Password Baru</label>
                  <input name="password_baru" id="password" class="form-control" type="password" value="">
              </div>
              <div class="card-body">
                <label class="control-label col-md-3">Konfirmasi Password Baru</label>
                  <input name="repassword" id="repassword" class="form-control" type="password" value="">
              </div>
            </div>  
          </div>  
          <div class="modal-footer">
          <input class="btn btn-success" type="Submit" onClick="validate();" value="Ubah" />
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>