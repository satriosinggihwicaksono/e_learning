<?php 
$url = $this->uri->segment(1);
$this->db->where('id',1);
$config = $this->db->get('setting')->row_array();
if(empty($url)){
  $url = 'admin';
}

$this->db->where('id',$this->session->userdata('id'));
$session = $this->db->get('admin')->row_array();
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?=$config['name']?></title>
  <style>
    body {
          width: 100%;
          height: 100%;
          margin: 0;
          padding: 0;
          background-color: #FAFAFA;
          font: 12pt "Tahoma";
      }
      * {
          box-sizing: border-box;
          -moz-box-sizing: border-box;
      }
      .page {
          width: 210mm;
          min-height: 297mm;
          padding: 10mm;
          margin: 10mm auto;
          border: 1px #D3D3D3 solid;
          border-radius: 5px;
          background: white;
          box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      }
      .subpage {
          padding: 1cm;
          border: 5px red solid;
          height: 257mm;
          outline: 2cm #FFEAEA solid;
      }
      
      @page {
          size: A4;
          margin: 0;
      }
      @media print {
          html, body {
              width: 210mm;
              height: 297mm;        
          }
          .page {
              margin: 0;
              border: initial;
              border-radius: initial;
              width: initial;
              min-height: initial;
              box-shadow: initial;
              background: initial;
              page-break-after: always;
          }
      }
  </style>

<?php $this->load->view($url.'/'.$header,array('config' => $config));?>
</head>

<body onload="window.print()">
  <div class="book">
      <div class="page">
        <!-- Content Wrapper -->
            <div class="row">
                <img src="<?=base_url('assets/img/logo.png')?>" width="50px"> 
                <h2 style="margin-left:10px;"><?=$setting['name']?></h2>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12" style="background-color:#d1d1e0; padding:40px">
                <strong>INVOICE <?=$invoice[0]['invoice']?></strong>
                <table>
                  <tr>
                    <td>Jatuh Tempo Invoice</td>
                    <td> : </td>
                    <td><?=longdate_indo(date('Y-m-d',strtotime($invoice[0]['tanggal'])))?></td>
                  </tr>
                  <tr>
                    <td>Tanggal Invoice</td>
                    <td> : </td>
                    <td><?=longdate_indo(date('Y-m-d',strtotime($invoice[0]['tgl_kadarluasa'])))?></td> 
                  </tr>
                </table>
                 
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-6">
              Kepada Yth.
                <div style="margin-left:10px;">  
                  <table>
                    <tr>
                      <td><?=$invoice[0]['name']?></td>
                    </tr>
                    <tr>
                      <td><?=$invoice[0]['alamat']?></td>
                    </tr>
                    <tr>
                      <td><?=$invoice[0]['telepone']?></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>    
            <hr>
          
            <div class="row">
              <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                  <tr style="background-color:#d1d1e0;">
                    <th>No.</th>
                    <th>Judul Materi</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                  <?php
                    $x = 1; 
                    foreach($invoice as $i){
                    $total = $i['peserta'] * $i['discount']; 
                  ?>
                    <td><?=$x++?></td>
                    <td><?=$i['question']?></td>
                    <td><?=$i['peserta']?></td>
                    <td><?=$i['discount']?></td>
                    <td><?=$total?></td>
                  </tr>
                  <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                      <td colspan="4">Total</td>
                      <td><?=$i['total']?></td>
                    </tr>
                </tfoot>
              </table>
            </div>
            <div style="position: absolute; bottom: 70px; margin-left:5px;">
                <b>Pembayaran dapat melalui :</b> <br>
                <?php 
                $this->db->select('*,bank.bank as namabank,rekening.id as id_rekening');
                $this->db->join('bank','bank.id = rekening.bank','left');
                $rekening = $this->db->get('rekening')->result_array(); 
                  foreach($rekening as $r){
                    echo $r['namabank'].' / '.$r['norek'].' / An. '.$r['nama'].'</br>';
                  } 
                ?>
            </div>

            <footer style="position: absolute; bottom: 20px; margin-left:240px;">
                      Generate by Litera Mobile
            </footer>
      </div>  
  </div>
  <?php $this->load->view($url.'/'.$footer,array('config' => $config));?>
</body>

</html>
