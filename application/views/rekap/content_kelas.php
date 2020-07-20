<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Data Kelas</h1>
        <!-- Earnings (Monthly) Card Example -->
        <div class="row">
          <?php 
            foreach($data as $d){ 
            $id_field = $d['id_field'];
            $id_position = $d['id_position'];
            $id_division = $d['id_division'];
            $id_admin = $d['id_admin'];
            $id_grade = $d['id_grade'];
            
            $this->db->where('id_field',$id_field);
            $this->db->where('id_position',$id_position);
            $this->db->where('id_division',$id_division);
            $this->db->where('id_admin',$id_admin);
            $this->db->where('id_grade',$id_grade);
            $count = $this->db->get('history')->num_rows();

            $total = $d['total'] - $count;
            
          ?>
          <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2 text-center">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-2"><?=$d['field']?></div>
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-2"><?=$d['division']?></div>
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-2"><?=$d['position']?></div>
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-2"><?=$d['grade']?></div>
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-2"><?=$total?></div>
                    </div>
                  </div>
                  
                  <div class="text-center">
                      <a href="<?=base_url('rekap/shop/'.$d["id_field"].'/'.$d["id_division"].'/'.$d["id_position"].'/'.$d["id_grade"])?>"><button class="btn btn-success">Detail</button></a>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>    
</div>