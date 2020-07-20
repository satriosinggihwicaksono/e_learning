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
<script src="<?=base_url().'assets/';?>js/croppie.js"></script>

<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>

<script src="<?php echo base_url('assets/vendor/ckeditor/ckeditor.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/vendor/ckeditor/adapters/jquery.js'); ?>"></script>

<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function() {
  table = $('#table_question').DataTable({ 
    
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    
    // Load data for the table's content from an Ajax source
    "ajax": {
      "url": "<?php echo site_url('question/ajax_question')?>",
      "type": "POST"
    },

    //Set column definition initialisation properties.
    "columnDefs": [
    { 
      "targets": [ -1 ], //last column
      "orderable": false, //set not orderable
    },
    ],

  });
});

function add_question()
{
  save_method = 'add';
  $('#form')[0].reset(); // reset form on modals
  $('#modal_form').modal('show'); // show bootstrap modal
  $('[name="ringkasan"]').val('');
  $('.modal-title').text('Tambah Soal'); // Set Title to Bootstrap modal title
}

function edit_question(id)
{
  save_method = 'update';
  $('#form')[0].reset(); // reset form on modals

  //Ajax Load data from ajax
  $.ajax({
    url : "<?php echo site_url('question/ajax_edit/')?>/" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
      console.log(data);
      $('[name="id"]').val(data.id);
      $('[name="question"]').val(data.question);
      $('[name="field"]').val(data.id_field);
      $('[name="division"]').val(data.id_division);
      $('[name="position"]').val(data.id_position);
      $('[name="grade"]').val(data.id_grade);
      $('[name="status"]').val(data.status);
      $('#ringkasan').val(data.ringkasan);
      if(data.soal == 1){
        document.getElementById("soal").checked = true
      }
      if(data.article == 1){
        document.getElementById("article").checked = true
      }
      if(data.video == 1){
        document.getElementById("video").checked = true
      }
        $('.img-thumbnail').hide();
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Soal'); // Set title to Bootstrap modal title
        
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error get data from ajax');
      }
    });
}

function view_question(id)
{
  save_method = 'view';
  $('#form')[0].reset(); // reset form on modals

  //Ajax Load data from ajax
  $.ajax({
    url : "<?php echo site_url('question/ajax_edit/')?>/" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
     
      $('[name="id"]').val(data.id);
      $('[name="question"]').val(data.question);
      $('[name="field"]').val(data.id_field);
      $('[name="division"]').val(data.id_division);
      $('[name="position"]').val(data.id_position);
      $('[name="grade"]').val(data.id_grade);
      $('[name="status"]').val(data.status);
      if(data.soal == 1){
        document.getElementById("soal").checked = true
      }
      if(data.article == 1){
        document.getElementById("article").checked = true
      }
      if(data.video == 1){
        document.getElementById("video").checked = true
      }
      
        $('#modal_view').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Detail question'); // Set title to Bootstrap modal title
        
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

function save()
{
  var url;
  if(save_method == 'add') 
  {
    url = "<?php echo site_url('question/ajax_add')?>";
  }
  else
  {
    url = "<?php echo site_url('question/ajax_update')?>";
  }
  var ringkasan = CKEDITOR.instances['ringkasan'].getData();
  var myForm = $("#form")[0]
  var fromdata = new FormData(myForm);
  fromdata.append("ringkasan",ringkasan);
   // ajax adding data to database
   $.ajax({
    url : url,
    type: "POST",
    data: fromdata,
    processData:false,
    contentType:false,
    cache:false,
    async:false,
    success: function(data)
    {
           //if success close modal and reload ajax table
           $('#modal_form').modal('hide');
           $('#form')[0].reset();
           reload_table();
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

 document.getElementById("form").onkeypress = function(event){
  if (event.keyCode == 13 || event.which == 13){
  var url;
  if(save_method == 'add') 
  {
    url = "<?php echo site_url('question/ajax_add')?>";
  }
  else
  {
    url = "<?php echo site_url('question/ajax_update')?>";
  }
  var ringkasan = CKEDITOR.instances['ringkasan'].getData();
  var myForm = $("#form")[0]
  var fromdata = new FormData(myForm);
  fromdata.append("ringkasan",ringkasan);
   // ajax adding data to database
   $.ajax({
    url : url,
    type: "POST",
    data: fromdata,
    processData:false,
    contentType:false,
    cache:false,
    async:false,
    success: function(data)
    {
           //if success close modal and reload ajax table
           $('#modal_form').modal('hide');
           $('#form')[0].reset();
           reload_table();
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

 function delete_question(id)
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
  url : "<?php echo site_url('question/ajax_delete')?>/"+id,
  type: "POST",
  dataType: "JSON",
  success: function(data)
  {
           //if success reload ajax table
           $('#modal_form').modal('hide');
           reload_table();
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

<script type="text/javascript">
	$(document).ready(function(){
      	$("#division_id").change(function(){
          var division = $(this).find(':selected').data('id');
          	$.ajax({
          		type: 'POST',
              	url: "<?php echo site_url('question/get_position')?>",
              	data: {division: division},
              	cache: false,
              	success: function(msg){
                  $("#position_id").html(msg);
                }
            });
        });
 
        $("#position_id").change(function(){
        var grade = $(this).find(':selected').data('id');
          	$.ajax({
          		type: 'POST',
              	url: "<?php echo site_url('question/get_grade')?>",
              	data: {grade: grade},
              	cache: false,
              	success: function(msg){
                  $("#grade_id").html(msg);
                }
            });
        });
     });

$(document).ready( function () {
    $('#table_revisi').DataTable();
});
$('textarea.texteditor').ckeditor();
</script>

<script>  
$(document).ready(function(){

	$image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:500,
      height:250,
      type:'square' //circle
    },
    boundary:{
      width:450,
      height:300,
    }
  });

  $('#upload_image').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
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
        url:"<?=base_url('question/crop')?>",
        type: "POST",
        data:{"image": response},
        success:function(data)
        {
          $('#uploadimageModal').modal('hide');
          $('#uploaded_image').show();
          $('#uploaded_image').html(data);
          $('#modal_form').modal('hide'); // show bootstrap modal
          setTimeout(function()
          {
            $('#modal_form').modal('show'); // show bootstrap modal
          },500);
        }
      });
    })
  });

});  
</script>