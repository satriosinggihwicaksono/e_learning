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

<script src="<?=base_url().'assets/js/';?>select2.min.js"></script>

<script src="<?php echo base_url('assets/vendor/ckeditor/ckeditor.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/vendor/ckeditor/adapters/jquery.js'); ?>"></script>


<script type="text/javascript">
    $('textarea.texteditor').ckeditor();
</script>

<script type="text/javascript">

$(document).ready(function() {
    $('#m_select2').select2();
    $('#paket').select2();
    $('#content-paket').select2();
    $('#bankselect').select2();
});

var save_method; //for save method string
var table;

$(document).ready(function() {
  table = $('#table_admin').DataTable({ 
    
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    
    // Load data for the table's content from an Ajax source
    "ajax": {
      "url": "<?php echo site_url('admin/ajax_admin2')?>",
      "type": "POST",
      "data": function(data) {
          data.level = $('.fill-level').val();
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
  
  $('#level').change(function() { //button filter event click
    reload_table(); //just reload table
  });
});

function add_admin()
{
  save_method = 'add';
  //$('#form')[0].reset(); // reset form on modals
  $('.drop-down-show-hide').hide();
  $('#modal_form').modal('show'); // show bootstrap modal
  $('.modal-title').text('Tambah admin'); // Set Title to Bootstrap modal title
  $('#uploaded_image').hide();
}

function edit_admin(id)
{
  save_method = 'update';
  $('#form')[0].reset(); // reset form on modals
  //Ajax Load data from ajax
  $.ajax({
    url : "<?php echo site_url('admin/ajax_edit/')?>/" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
     
     if(data.level == 'corporyte'){
      $('.drop-down-show-hide').hide();
     } else {
      $('.drop-down-show-hide').show();
     }

      $('[name="id"]').val(data.id);
      $('[name="name"]').val(data.name);
      $('[name="email"]').val(data.email);
      $('[name="level"]').val(data.level);
      $('[name="status"]').val(data.status);
      $('[name="presentase"]').val(data.presentase);
      $('[name="paket"]').val(data.id_paket).change();
      $('.img-thumbnail').hide();
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit admin'); // Set title to Bootstrap modal title
        
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error get data from ajax');
      }
    });
}

function view_admin(id)
{
  save_method = 'view';
  $('#form')[0].reset(); // reset form on modals

  //Ajax Load data from ajax
  $.ajax({
    url : "<?php echo site_url('admin/ajax_edit/')?>/" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
     console.log(data);
      $('[name="id"]').val(data.id);
      $('[name="name"]').val(data.name);
      $('[name="email"]').val(data.email);
      $('[name="level"]').val(data.level);
      $('[name="status"]').val(data.status).change();
      $('[name="paket"]').val(data.paket);
      
        $('#modal_view').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Detail admin'); // Set title to Bootstrap modal title
        
      },
      error: function ()
      {
        alert('Email telah digunakan!! ');
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
    url = "<?php echo site_url('admin/ajax_add')?>";
  }
  else
  {
    url = "<?php echo site_url('admin/ajax_update')?>";
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
           $('#form')[0].reset();
           $('#level').val("").change();
           swal(
            'Sukses',
            'Data telah tersimpan',
            'success'
            )
         },
         error: function ()
         {
          alert('email telah digunakan!!');
        }
      });
 }

 document.getElementById("form").onkeypress = function(event){
    if (event.keyCode == 13 || event.which == 13){
  var url;
  if(save_method == 'add') 
  {
    url = "<?php echo site_url('admin/ajax_add')?>";
  }
  else
  {
    url = "<?php echo site_url('admin/ajax_update')?>";
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
           $('#form')[0].reset();
           $('#level').val("").change();
           swal(
            'Sukses',
            'Data telah tersimpan',
            'success'
            )
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
          alert('Email telah digunakan!!');
        }
      });
    }
 }

 function delete_admin(id)
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
  url : "<?php echo site_url('admin/ajax_delete')?>/"+id,
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

<script>
  $('.drop-down-show-hide').hide();

  $('.showhide').change(function () {
      $('.drop-down-show-hide').hide()
      var val = this.value;
      if(val=='content'){
        $('.content').show();
      }

  });
  </script>

<script type="text/javascript">
     function validate() {
            var url = "<?php echo site_url('user/update_setting')?>";
            var password1 = document.getElementById('password').value;
            var password2 = document.getElementById('repassword').value;
            if (password1 != password2) {
                alert("Password Tidak Sama!!");
            } else {
              $.ajax({
                url : url,
                type: "POST",
                data: $('#form_setting').serialize(),
                dataType: "JSON",
                success: function(data)
                {
                    //if success close modal and reload ajax table
                    swal(
                      'Sukses',
                      'Data telah tersimpan',
                      'success'
                      )
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                    alert('Password is wrong');
                  }
                });
            }
        }
</script>

<script>  
$(document).ready(function(){

	$image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:400,
      height:400,
      type:'square' //circle
    },
    boundary:{
      width:500,
      height:500
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
        url:"<?=base_url('admin/crop')?>",
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

<?php 
  if($this->uri->segment(2) == 'dashboard' && $this->session->userdata('level') == 'corporyte'){ 
?>
<!-- Page level plugins -->
<script src="<?=base_url().'assets/';?>vendor/chart.js/Chart.min.js"></script>

<?php 
  $this->db->join('division','division.id = division_p.id_division','left');
  $this->db->where('id_paket',$this->session->userdata('id_paket'));
  $division = $this->db->get('division_p')->result_array();

?>

<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';
var division = [];
var total = [];
<?php 
  foreach($division as  $d){
  $this->db->where('id_admin',$this->session->userdata('id'));
  $this->db->where('id_division',$d['id_division']);
  $this->db->where('deleted_at',null);
  $count = $this->db->get('users')->num_rows();
?>
  division.push("<?=$d['division']?>");
  total.push("<?=(int)$count?>");
<?php    
  }
?>
// Pie Chart Example
var ctx = document.getElementById("myPieChart");

var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: division,
    datasets: [{
      data: total,
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
      label: "Earnings",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 7,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return '$' + number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
        }
      }
    }
  }
});

</script>

<?php 
  } 
?>
