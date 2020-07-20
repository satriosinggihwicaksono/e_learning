<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">User Nilai</h1>
  <div class="card-header py-3">
    <select id="level" class="form-control" name="level" onChange="window.location.href=this.value">
      <option value='<?=base_url('rekap/materi/')?>'>-- Pilih --</option>
      <?php foreach($materi as $m){ ?>
      <option <?php if($m['id'] == $this->uri->segment(3)){ echo 'selected="selected"';} ?> value='<?=base_url('rekap/nilai_user/').$m['id']?>'><?=$m['question']?></option>
      <?php } ?>
    </select>
  </div>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="table_materi" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No.</th>
              <th>User</th>
              <th>Status Pengerjaan</th>
              <th>Nilai</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $x = 1;
            $this->db->select('users.id,users.name');
            $this->db->join('uji','uji.id_invoice = history.id_invoice','left');
            $this->db->join('invoice','invoice.id = history.id_invoice','left');
            $this->db->join('users','users.id = history.id_user','left');
            $this->db->where('uji.id_question',$this->uri->segment(3));
            $this->db->where('history.id_admin',$this->session->userdata('id'));
            $users = $this->db->get('history')->result_array();
    
            foreach($users as $s){
            ?>
            <tr>
              <td><?=$x++?></td>
              <td>
                <?=$s['name']?>
              </td>
              <td>
                <?php 
                  $this->db->where('kondisi','selesai');
                  $this->db->where('id_question',$this->uri->segment(3));
                  $this->db->where('id_user',$s['id']);
                  $this->db->order_by('id','desc');
                  $ujian = $this->db->get('mulai')->row_array();
                  if(empty($ujian)){
                    echo 'Belum';
                  } else {
                    echo 'Sudah';
                  }
                ?>
              </td>
              <td>
                 <?php 
                  if(!empty($ujian)) echo $ujian['nilai'];
                 ?>
              </td>
            </tr>
             <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>