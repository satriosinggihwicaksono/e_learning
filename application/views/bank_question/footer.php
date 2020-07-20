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
  table = $('#table_bank_question').DataTable({ 
    
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    
    // Load data for the table's content from an Ajax source
    "ajax": {
      "url": "<?php echo site_url('bank_question/ajax_bank_question')?>",
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


function view_bank_question(id)
{
  $('#form_data')[0].reset(); // reset form on modals

  //Ajax Load data from ajax
  $.ajax({
    url : "<?php echo site_url('bank_question/view_bank_soal/')?>" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
      if(data.cover != null){
        var image = '<?=base_url('assets/files/question/');?>'+data.cover;
      } else {
        var image = '<?=base_url('assets/files/users/nophoto.png');?>';
      }
      $('[name="question"]').val(data.question);
      $('[name="field"]').val(data.field);
      $('[name="division"]').val(data.division);
      $('[name="position"]').val(data.position);
      $('[name="grade"]').val(data.grade);
      $('[name="ringkasan"]').val(data.ringkasan);
      $('#image').html('<img src="'+image+'" width="100%"/>');

        $('#modal_view').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Detail Soal'); // Set title to Bootstrap modal title
        
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


</script>