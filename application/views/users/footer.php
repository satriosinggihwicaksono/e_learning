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

<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function() {
  table = $('#table_users').DataTable({ 
    
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    
    // Load data for the table's content from an Ajax source
    "ajax": {
      "url": "<?php echo site_url('users/ajax_user')?>",
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

function add_users()
{
  save_method = 'add';
  $('#form')[0].reset(); // reset form on modals
  $('#modal_form').modal('show'); // show bootstrap modal
  $('.modal-title').text('Tambah User'); // Set Title to Bootstrap modal title
}

function edit_users(id)
{
  save_method = 'update';
  $('#form')[0].reset(); // reset form on modals

  //Ajax Load data from ajax
  $.ajax({
    url : "<?php echo site_url('users/ajax_edit/')?>/" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
      $('[name="id"]').val(data.id);
      $('[name="name"]').val(data.name);
      $('[name="email"]').val(data.email);
      $('[name="status"]').val(data.status);
      $('[name="division"]').val(data.id_division);
      $('[name="field"]').val(data.id_field);
      $('[name="position"]').val(data.id_position);
      $('[name="grade"]').val(data.grade);
      
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Users'); // Set title to Bootstrap modal title
        
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Email sudah terdaftar!');
      }
    });
}

function view_users(id)
{
  save_method = 'view';
  $('#form')[0].reset(); // reset form on modals

  //Ajax Load data from ajax
  $.ajax({
    url : "<?php echo site_url('users/ajax_edit/')?>/" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
     
      $('[name="id"]').val(data.id);
      $('[name="name"]').val(data.name);
      $('[name="email"]').val(data.email);
      $('[name="status"]').val(data.status);
      $('[name="division"]').val(data.division);
      $('[name="field"]').val(data.field);
      $('[name="position"]').val(data.position);
      
        $('#modal_view').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Detail Users'); // Set title to Bootstrap modal title
        
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
    url = "<?php echo site_url('users/ajax_add')?>";
  }
  else
  {
    url = "<?php echo site_url('users/ajax_update')?>";
  }

   // ajax adding data to database
   $.ajax({
    url : url,
    type: "POST",
    data: $('#form').serialize(),
    dataType: "JSON",
    success: function(data)
    {
           //if success close modal and reload ajax table
           $('#modal_form').modal('hide');
           reload_table();
           swal(
            'Sukses',
            'Data telah tersimpan',
            'success'
            )
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
          alert('Email sudah terdaftar!');
        }
      });
 }

 document.getElementById("form").onkeypress = function(event){
  if (event.keyCode == 13 || event.which == 13){
  var url;
  if(save_method == 'add') 
  {
    url = "<?php echo site_url('users/ajax_add')?>";
  }
  else
  {
    url = "<?php echo site_url('users/ajax_update')?>";
  }

   // ajax adding data to database
   $.ajax({
    url : url,
    type: "POST",
    data: $('#form').serialize(),
    dataType: "JSON",
    success: function(data)
    {
           //if success close modal and reload ajax table
           $('#modal_form').modal('hide');
           reload_table();
           swal(
            'Sukses',
            'Data telah tersimpan',
            'success'
            )
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
          alert('Email sudah terdaftar!');
        }
      });
    }
 }

 function delete_users(id)
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
  url : "<?php echo site_url('users/ajax_delete')?>/"+id,
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

<script src="<?=base_url()?>assets/js/select2.min.js"></script>

<script type="text/javascript">

$(document).ready(function() {
    $('#field').select2();
    $('#division').select2();
    $('#position').select2();
});
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
</script>