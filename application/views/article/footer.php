<!-- Bootstrap core JavaScript-->
<script src="<?=base_url().'assets/';?>vendor/jquery/jquery.min.js"></script>
<script src="<?=base_url().'assets/';?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?=base_url().'assets/';?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?=base_url().'assets/';?>js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?=base_url().'assets/';?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url().'assets/';?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?=base_url().'assets/';?>js/demo/datatables-demo.js"></script>

<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url('assets/vendor/ckeditor/ckeditor.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/vendor/ckeditor/adapters/jquery.js'); ?>"></script>

<script src="<?=base_url().'assets/';?>js/croppie.js"></script>

<script type="text/javascript">
    $('textarea.texteditor').ckeditor();
</script>

<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function() {
  table = $('#table_article').DataTable({ 
    
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    
    // Load data for the table's content from an Ajax source
    "ajax": {
      "url": "<?php echo site_url('article/ajax_article/'.$this->uri->segment(3))?>",
      "type": "POST",
      "data": function(data) {
          data.category = $('.fill-category').val();
      }
    },

    //Set column definition initialisation properties.
    "columnDefs": [
    { 
      "targets": [ -1 ], //last column
      "orderable": false, //set not orderable
    },
    ],

  });

  $('#category_2').change(function() { //button filter event click
    var hidden = $('.fill-category').val();
    if(hidden == 'article'){
      $('#revisi_video').hide();
      $('#revisi_article').show();
    } else if(hidden == 'video') {
      $('#revisi_article').hide();
      $('#revisi_video').show();
    } else {
      $('#revisi_article').show();
      $('#revisi_video').show();
    }
    $('#table_article').DataTable().ajax.reload();
  });

});

$(document).ready(function() {
  table = $('#table_article_view').DataTable({ 
    
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    
    // Load data for the table's content from an Ajax source
    "ajax": {
      "url": "<?php echo site_url('article/ajax_table_article/'.$this->uri->segment(3))?>",
      "type": "POST",
      "data": function(data) {
      }
    },
  });
});

$(document).ready(function() {
  table = $('#table_video_view').DataTable({ 
    
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    
    // Load data for the table's content from an Ajax source
    "ajax": {
      "url": "<?php echo site_url('article/ajax_table_video/'.$this->uri->segment(3))?>",
      "type": "POST",
      "data": function(data) {
      }
    },
  });
});

function add_article()
{
  save_method = 'add';
  $('#form_article2')[0].reset(); // reset form on modals
  $('#modal_form2').modal('show'); // show bootstrap modal
  $('[name="article"]').val('');
  $('.modal-title').text('Tambah Artikel'); // Set Title to Bootstrap modal title
}

function edit_article(id)
{
  save_method = 'update';
  $('#form_article2')[0].reset(); // reset form on modals

  //Ajax Load data from ajax
  $.ajax({
    url : "<?php echo site_url('article/ajax_edit/')?>/" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
     
      $('[name="id"]').val(data.id);
      $('[name="article"]').val(data.article);
      $('[name="title"]').val(data.title);
      $('[name="category"]').val(data.category);
      $('.category').val(data.category).change();
      
        $('#modal_form2').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit '+data.category); // Set title to Bootstrap modal title
        $('#upload_video').prop('required',false);
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error get data from ajax');
      }
    });
}

function view_article(id)
{
  save_method = 'view';
  $('#form_view')[0].reset(); // reset form on modals

  //Ajax Load data from ajax
  $.ajax({
    url : "<?php echo site_url('article/ajax_edit/')?>/" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
      if(data.category == 'article'){
        var image = '<?=base_url('assets/files/videos/');?>'+data.video;
      } else {
        var image = '<?=base_url('assets/files/videos/');?>'+data.thumbnail;
      }

      $('[name="id"]').val(data.id);
      $('[name="article"]').val(data.article);
      $('[name="title"]').val(data.title);
      $('#image').html('<img src="'+image+'" width="400px"/>');
      
        $('#modal_view').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Detail Article'); // Set title to Bootstrap modal title​​​​
        
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error get data from ajax');
      }
    });
}

function reload_table()
{
  table.ajax.reload(null,false); //reload datatable ajax 
}

function save_article_revisi()
{
  url = "<?php echo site_url('article/ajax_add_article/')?>";
   $.ajax({
    url : url,
    type: "POST",
    data: $('#form_article').serialize(),
    dataType: "JSON",
    success: function(data)
    {
           //if success close modal and reload ajax table
           $('#article_modal').modal('hide');
           $('#table_article_view').DataTable().ajax.reload();
           
           swal(
            'Sukses',
            'Data telah tersimpan',
            'success'
            )
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
          alert('Error adding / update data');
        }
      });
 }

  document.getElementById("form_article").onkeypress = function(event){
  if (event.keyCode == 13 || event.which == 13){
  url = "<?php echo site_url('article/ajax_add_article/')?>";
   $.ajax({
    url : url,
    type: "POST",
    data: $('#form_article').serialize(),
    dataType: "JSON",
    success: function(data)
    {
           //if success close modal and reload ajax table
           $('#article_modal').modal('hide');
           $('#table_article_view').DataTable().ajax.reload();
           
           swal(
            'Sukses',
            'Data telah tersimpan',
            'success'
            )
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
          alert('Error adding / update data');
        }
      });
    }
 }

 function save_video_revisi()
{
  url = "<?php echo site_url('article/ajax_add_article/')?>";
   $.ajax({
    url : url,
    type: "POST",
    data: $('#form_video').serialize(),
    dataType: "JSON",
    success: function(data)
    {
           //if success close modal and reload ajax table
           $('#video_modal').modal('hide');
           $('#table_video_view').DataTable().ajax.reload();
           
           swal(
            'Sukses',
            'Data telah tersimpan',
            'success'
            )
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
          alert('Error adding / update data');
        }
      });
 }

 document.getElementById("form_video").onkeypress = function(event){
 if (event.keyCode == 13 || event.which == 13){
  url = "<?php echo site_url('article/ajax_add_article/')?>";
   $.ajax({
    url : url,
    type: "POST",
    data: $('#form_video').serialize(),
    dataType: "JSON",
    success: function(data)
    {
           //if success close modal and reload ajax table
           $('#video_modal').modal('hide');
           $('#table_article').DataTable().ajax.reload();
           
           swal(
            'Sukses',
            'Data telah tersimpan',
            'success'
            )
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
          alert('Error adding / update data');
        }
      });
  }
 }

 function delete_article(id)
 {

  swal({
    title: 'Apa kamu yakin?',
    text: "Untuk Menghapus data ini!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
    closeOnConfirm: false
  }).then(function(isConfirm) {
    if (isConfirm) {

 // ajax delete data to database
 $.ajax({
  url : "<?php echo site_url('article/ajax_delete')?>/"+id,
  type: "POST",
  dataType: "JSON",
  success: function(data)
  {
           //if success reload ajax table
           $('#modal_form').modal('hide');
           $('#table_article').DataTable().ajax.reload();

           swal(
            'Deleted!',
            'Your file has been deleted.',
            'success'
            );
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
          alert('Error adding / update data');
        }
      });
}
})
  
}
</script>

<script>
  $('.drop-down-show-hide').hide();
  $("#title-upload").empty();
  $('.category').change(function () {
      $('.drop-down-show-hide').hide();
      var val = this.value;
      if(val == 'article'){
        $('#title_article').show();
        $('.article-show').show();
        $('#des_article').show();
        $('#upload_video').prop('required',false);
      } else if(val == 'video') {
        $('.video-show').show();
        $('.article-show').show();
        $('#title_article').show();
        $('#des_article').show();
      } else {
        $('.drop-down-show-hide').hide();
      }

  });
</script>


<script>

$(document).ready(function(){

	$image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:400,
      height:300,
      type:'square' //circle
    },
    boundary:{
      width:600,
      height:600
    }
  });

  $('#upload_image').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
  });

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:"<?=base_url('article/crop')?>",
        type: "POST",
        data:{"image": response},
        success:function(data)
        {
          $('#uploadimageModal').modal('hide');
          $('#uploaded_image').show();
          $('#uploaded_image').html(data);
          $('#modal_form2').modal('hide'); // show bootstrap modal
          setTimeout(function()
          {
            $('#modal_form2').modal('show'); // show bootstrap modal
          },800);
        }
      });
    })
  });
});
</script>