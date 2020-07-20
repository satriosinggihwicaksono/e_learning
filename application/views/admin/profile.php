<div class="container-fluid">
<div id="notifications"><?php echo $this->session->flashdata('msg'); ?></div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card shadow mb-4">
        <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
          <h6 class="m-0 font-weight-bold text-primary">Edit Profile</h6>
        </a>
        <form action="<?=base_url().'admin/update/'?>"class="form-horizontal" enctype="multipart/form-data" method="post">
        <div class="collapse show" id="collapseCardExample">
          <div class="row">
            <div class="col-md-4" style="padding:20px;">
              <div style="text-align:center;">
                <img class="img-profile rounded-circle" src="<?=base_url().'assets/files/users/'.$profile['photo'];?>" width=200px;>
              </div>
              <label class="control-label">Upload Photo</label>
              <input type="file" name="photo" id="upload_image"  class="form-control"  />
              <div id="uploaded_image"></div>
            </div>
            <div class="col-md-8">  
            <div class="card-body">
                <label class="control-label col-md-3">Email</label>
                  <input disabled name="email" class="form-control" type="text" value="<?=$profile['email']?>">
                  <input name="id" type="hidden" value="<?=$profile['id']?>">
              </div>
              <div class="card-body">
                <label class="control-label col-md-3">Name</label>
                  <input name="name" class="form-control" type="text" value="<?=$profile['name']?>">
              </div>
              <div class="card-body">
                <label class="control-label col-md-3">Telepone</label>
                  <input name="telepone" class="form-control" type="text" value="<?=$profile['telepone']?>">
              </div>
              <div class="card-body">
                <label class="control-label col-md-3">Alamat</label>
                <textarea id="article" class="form-control"   name="alamat"><?=$profile['alamat']?></textarea>
              </div>
              <?php if($this->session->userdata('level') == 'content'){ ?>
              <div class="card-body">
                <label class="control-label col-md-3">Bank</label>
                  <select name="id_bank" class="form-control" id="m_select2">
                    <?php foreach($bank as $b){ ?>
                    <option <?php if($profile['id_bank'] == $b['id']){ echo 'selected="selected"';} ?> value="<?=$b['id']?>"><?=$b['bank']?></option>
                    <?php } ?>
                  </select>
              </div>
              <div class="card-body">
                <label class="control-label col-md-3">Atas Nama</label>
                  <input name="an_bank" class="form-control" type="text" value="<?=$profile['an_bank']?>">
              </div>
              <div class="card-body">
                <label class="control-label col-md-3">No Rekening</label>
                  <input name="no_rek" class="form-control" type="text" value="<?=$profile['no_rek']?>">
              </div>
              <?php } ?>
            </div>  
          </div>  
          <div class="modal-footer">
            <input type="submit" value="Save" class="btn btn-primary" />
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="uploadimageModal" class="modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
      		<div class="modal-body">
        		<div class="row">
  					<div class="col-md-8 text-center">
						  <div id="image_demo" style="width:350px; margin-top:30px"></div>
  					</div>
  					<div class="col-md-4" style="padding-top:30px;">
					</div>
				</div>
      		</div>
          <div class="modal-footer">
            <button class="btn btn-success crop_image">Crop Foto</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
    	</div>
    </div>
  </div>