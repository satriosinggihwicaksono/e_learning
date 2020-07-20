<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Pendapatan Materi</h1>

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
              <th>Harga</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
          <?php 
            $x = 1; 
            $full = array();
            foreach($question as $q){ 
            $harga = $q['discount'] * (10/100);
            $total = $harga * $q['total'];
            $full[] = $total;
          ?>
            <tr>
              <td><?=$x++?></td>
              <td><?=$q['question']?></td>
              <td><?=$q['total']?></td>
              <td><?=$harga?></td>
              <td><?=$total?></td>
            </tr>
          <?php } ?>
            <tr>
              <td colspan="4">Total</td>
              <td><?=array_sum($full)?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>