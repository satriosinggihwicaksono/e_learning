<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Materi Revisi / Disetujui</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="table_revisi" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul</th>
              <th>Status Soal</th>
              <th>Status Artikel</th>
              <th>Status Video</th>
            </tr>
          </thead>
          <tbody>
          <?php
            $x = 1; 
            foreach($question as $q){
            
            if($q['status'] == 'apply'){
              $color = 'success';
            } elseif($q['status'] == 'send'){
              $color = 'info';
            }else {
              $color = 'warning';
            }

            if($q['status_article'] == 'apply'){
              $color_a = 'success';
            } elseif($q['status_article'] == 'send'){
              $color_a = 'info';
            } else {
              $color_a = 'warning';
            }

            if($q['status_video'] == 'apply'){
              $color_v = 'success';
            } elseif($q['status_video'] == 'send'){
              $color_v = 'info';
            } else {
              $color_v = 'warning';
            }
            
            $status = '<a href="'.base_url().'sub_question/index/'.$q['id'].'"><button class="btn btn-'.$color.'" type="button">'.$q["status"].'</button></a>'; 
            $status_article = '<a href="'.base_url().'article/index/'.$q['id'].'"><button class="btn btn-'.$color_a.'" type="button">'.$q["status_article"].'</button></a>'; 
            $status_video = '<a href="'.base_url().'article/index/'.$q['id'].'"><button class="btn btn-'.$color_v.'" type="button">'.$q["status_video"].'</button></a>'; 
            
          ?>
            <tr>
              <td><?=$x++;?></td>
              <td><?=$q['question']?></td>
              <td><?=$status?></td>
              <td><?=$status_article?></td>
              <td><?=$status_video?></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>