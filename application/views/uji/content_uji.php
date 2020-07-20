<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><?=$question['question']?></h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
        <?php
          $x = 1; 
          foreach($sub_question as $sq){
        ?>
            <hr>
            <?=$x++?>.<?=$sq['sub_question']?> <br>
                A. <?=$sq['a']?> <br>
                B. <?=$sq['b']?> <br>
                C. <?=$sq['c']?> <br>
                D. <?=$sq['d']?> <br>
                E. <?=$sq['e']?>
        <?php
          } 
        ?>
      
    </div>
  </div>
</div>