<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Pengajuan Materi</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="table_revisi" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul</th>
              <th>Bidang</th>
              <th>Level</th>
              <th>Jabatan</th>
              <th>Grade</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
          <?php
            $x = 1; 
            foreach($question as $q){ 
          ?>
            <tr>
              <td><?=$x++?></td>
              <td><?=$q['question']?></td>
              <td><?=$q['field']?></td>
              <td><?=$q['division']?></td>
              <td><?=$q['position']?></td>
              <td><?=$q['grade']?></td>
              <td><span class="btn btn-warning">Diajukan</span></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>