<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Penggunaan Materi</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="table_question_pengajuan" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul</th>
              <th>Perserta</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
          <?php 
            $x = 1;
            $all = array();
            $presentase = $presentase['presentase'];
            foreach($question as $q){ 
            $total = ($q['discount'] * $q['peserta']) * ($presentase/100); 
            $all[] = $total;
          ?>
            <tr>
              <td><?=$x++?></td>
              <td><?=$q['question']?></td>
              <td><?=$q['peserta']?></td>
              <td><?=$total?></td>
            </tr>
          <?php } ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3">Total</td>
              <td><?=array_sum($all)?></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>