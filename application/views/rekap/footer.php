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


<script src="<?php echo base_url('assets/vendor/ckeditor/ckeditor.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/vendor/ckeditor/adapters/jquery.js'); ?>"></script>
<script type="text/javascript">
    $('textarea.texteditor').ckeditor();
</script>

<script type="text/javascript">
var save_method; //for save method string
var table;

$(document).ready(function() {
  $('#table_materi').DataTable();
  table = $('#table_rekap').DataTable({ 
    
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    
    // Load data for the table's content from an Ajax source
    "ajax": {
      "url": "<?php echo site_url('rekap/ajax_rekap')?>",
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

  $(document).ready(function() {
    table = $('#table_keranjang').DataTable({ 
      
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      
      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('rekap/ajax_table_keranjang/')?>",
        "type": "POST",
        "data": function(data) {
        }
      },
    });

    $('#table_invoice').DataTable();
  });
});


function add_shop(id)
{
  $('#form')[0].reset();
  $.ajax({
    url : "<?php echo site_url('rekap/question/')?>/" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
      $('[name="id"]').val(data['id']);
      $('[name="id_question"]').val(data['id']);
      $('[name="question"]').val(data['question']);
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Tambah Jadwal'); // Set Title to Bootstrap modal title  
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error get data from ajax');
      }
    });

 
}

function save()
{
  var url;
    url = "<?php echo site_url('rekap/ajax_add')?>";
   // ajax adding data to database
   $.ajax({
    url : url,
    type: "POST",
    data: $('#form').serialize(),
    dataType: "JSON",
    success: function(data)
    {
          $('#modal_form').modal('hide');
          $('#table_keranjang').DataTable().ajax.reload();
          $('#keranjang').load('<?=base_url()?>rekap/loadkeranjang').fadeIn("slow");
          $('#total').load('<?=base_url()?>rekap/loadtotal').fadeIn("slow");

         },
         error: function (jqXHR, textStatus, errorThrown)
         {
          alert('Data Sudah Ditambahkan');
        }
      });
 }

function delete_keranjang(id)
{
  var url;
    url = "<?php echo site_url('rekap/delete_keranjang/')?>"+id;
   // ajax adding data to database
   $.ajax({
    url : url,
    type: "POST",
    dataType: "JSON",
    success: function(data)
    {
          $('#table_keranjang').DataTable().ajax.reload();
          $('#keranjang').load('<?=base_url()?>rekap/loadkeranjang').fadeIn("slow");
          $('#total').load('<?=base_url()?>rekap/loadtotal').fadeIn("slow");
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
          alert('Data Sudah Ditambahkan');
        }
      });
 }

 function view_materi(id)
{
  save_method = 'view';
  $('#form')[0].reset(); // reset form on modals

  //Ajax Load data from ajax
  $.ajax({
    url : "<?php echo site_url('bank_question/view_bank_soal/')?>/" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
      if(data.cover){
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
      $('#image').html('<img src="'+image+'" width="600px"/>');
      $('#article').html('<a href="<?=base_url('rekap/article/')?>'+id+'" target="_blank" style="margin-bottom:4px" class="btn btn-sm btn-warning">Article</a>');
      $('#soal').html('<a href="<?=base_url('rekap/soal/')?>'+id+'" target="_blank" style="margin-bottom:4px" class="btn btn-sm btn-primary">Soal</a>');
      $('#video').html('<a href="<?=base_url('rekap/video/')?>'+id+'" target="_blank" style="margin-bottom:4px" class="btn btn-sm btn-success">Video</a>');

      
        $('#modal_view').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Detail Materi'); // Set title to Bootstrap modal title
        
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error get data from ajax');
      }
    });
}

$('.drop-down-show-hide').hide();

  $('.tgl_uji').change(function () {
      var val = this.value;
      if(val=='1'){
        $('.drop-down-show-hide').show();
      } else {
        $('.drop-down-show-hide').hide();
      }

  });
</script>

