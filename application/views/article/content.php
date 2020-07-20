<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-500" style="font-size:20px;"><?php echo $question['question'].' -> '.$question['field'].' -> '.$question['division'].' -> '.$question['position'].' -> '.$question['grade']?></h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <button class="btn btn-success" onclick="add_article()"><i class="glyphicon glyphicon-plus"></i> Tambah Artikel</button>
      <a href="javascript:void(0)" class="btn btn-sm btn-primary" style="float:right; margin:3px;" data-target="#article_modal" data-toggle="modal" id="revisi_article">Revisi Artikel</a>
      <a href="javascript:void(0)" class="btn btn-sm btn-secondary" style="float:right; margin:3px;" data-target="#video_modal" data-toggle="modal"  id="revisi_video">Revisi Video</a>
    </div>
    <div class="card-body">
      <div class="row">
          <div class="col-md-6">
              <div class="form-group row">
                  <label for="txtFirstNameBilling" class="col-lg-2 col-form-label">Fillter</label>
                  <div class="col-lg-9">
                      <select id="category_2" class="form-control fill-category" name="category">
                          <option value='0'>Semua</option>
                          <option value='article'>Artikel</option>
                          <option value='video'>Video</option>
                      </select>
                  </div>
              </div>
          </div>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered" id="table_article" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul</th>
              <th>Kategori</th>
              <th>Video/Image</th>
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
  <div class="modal fade" id="modal_form2" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form method="post" action="<?=base_url().'article/add_article/'.$this->uri->segment(3)?>" enctype="multipart/form-data" id="form_article2" class="form-horizontal">
        <div class="modal-body">
            <input type="hidden" value="" name="id"/> 
            <div class="form-group">
              <label class="control-label col-md-3">Kategori</label>
              <div class="col-md-9">
                <select name="category" class="form-control category">
                 <option value="">-- Select artike / video --</option>
                  <option value="article">Artikel</option>
                  <option value="video">Video</option>
                </select>
              </div>
            </div>
            
            <div class="form-body drop-down-show-hide" id="title_article">
              <div class="form-group">
                <label class="control-label col-md-3 ">Judul</label>
                <div class="col-md-9">
                 <input class="form-control" name="title" value="" />
                </div>
              </div>
            </div>
           
            <div class="form-body drop-down-show-hide" id="des_article">
              <div class="form-group">
                <label class="control-label col-md-3">Artikel</label>
                <div class="col-md-12">
                 <textarea id="article" class="texteditor" name="article"></textarea>
                </div>
              </div>
            </div>

            <div class="form-body drop-down-show-hide video-show">
              <div class="form-group">
                <label class="control-label col-md-3">Upload Video</label>
                <div class="col-md-9">
                  <input type="file" class="form-control" name="video" id="upload_video" value="" required/>
                </div>
              </div>
            </div>
           
            <div class="drop-down-show-hide article-show">
              <div class="form-body">
                <div class="form-group">
                  <label class="control-label col-md-3" id="title-upload2">Upload Image</label>
                  <div class="col-md-9">
                    <input name="photo" type="file" class="form-control" id="upload_image">
                  </div>
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
        </div>

        <div class="modal-footer">
          <input type="submit" class="btn btn-primary" value="Save">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

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
        <form href="javascript:void(0)" id="form_view" class="form-horizontal" enctype="multipart/form-data">
            <input type="hidden" value="" name="id"/> 
            <input type="hidden" value="" name="category"/> 
            <div class="form-body">
              <div class="form-group">
                <div class="col-md-12" style="text-align:center;">
                  <div id="image"></div>
                </div>
              </div>
            </div>
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Judul</label>
                <div class="col-md-9">
                <input disabled class="form-control" name="title" value="" />
                </div>
              </div>
            </div>
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Artikel</label>
                <div class="col-md-12">
                <textarea disabled id="article" class="texteditor" name="article"></textarea>
                </div>
              </div>
            </div>
            
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <!-- Bootstrap modal -->
<div class="modal fade" id="article_modal" role="dialog">
    <div class="modal-dialog modal-lg" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Revisi Article</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body form">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="table_article_view" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
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
          <form href="javascript:void(0)" id="form_article" class="form-horizontal">
            <input type="hidden" value="<?=$this->uri->segment(3)?>" name="id"/> 
            <input type="hidden" value="article" name="type"/> 
              <div class="form-group">
                <label class="control-label col-md-3">Status</label>
                <div class="col-md-12">
                  <select name="status" class="form-control">
                    <option value="back">Sudah Direvisi</option>
                    <option value="revision">Revisi</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Keterangan</label>
                <div class="col-md-12">
                  <textarea class="form-control" name="description"></textarea>
                </div>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save_article_revisi()" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>  
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <!-- Bootstrap modal -->
<div class="modal fade" id="video_modal" role="dialog">
    <div class="modal-dialog modal-lg" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Revisi Video</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body form">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="table_video_view" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
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
          <form href="javascript:void(0)" id="form_video" class="form-horizontal">
            <input type="hidden" value="<?=$this->uri->segment(3)?>" name="id"/> 
            <input type="hidden" value="video" name="type"/> 
              <div class="form-group">
                <label class="control-label col-md-3">Status</label>
                <div class="col-md-12">
                  <select name="status" class="form-control">
                    <option value="back">Sudah Direvisi</option>
                    <option value="revision">Revisi</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Keterangan</label>
                <div class="col-md-12">
                  <textarea class="form-control" name="description"></textarea>
                </div>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save_video_revisi()" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


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