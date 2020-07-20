<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Materi User</h1>
  <div class="card-header py-3">
    <select id="level" class="form-control" name="level" onChange="window.location.href=this.value">
      <option value='<?=base_url('rekap/materi/')?>'>-- Pilih --</option>
      <?php foreach($users as $u){ ?>
      <option <?php if($u['id'] == $this->uri->segment(3)){ echo 'selected="selected"';} ?> value='<?=base_url('rekap/materi/').$u['id']?>'><?=$u['name']?></option>
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
              <th>Materi</th>
              <th>Nilai</th>
              <th>Rata-rata</th>
              <th>Nilai Minimal</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $x = 1;
            $this->db->join('history','history.id_invoice = uji.id_invoice','left');
            $this->db->join('invoice','invoice.id = uji.id_invoice','left');
            $this->db->where('history.id_user',$this->uri->segment(3));
            $this->db->where('status',1);
            $data = $this->db->get('uji')->result_array();
            foreach($data as $d){
            ?>
            <tr>
              <td><?=$x++?></td>
              <td>
                <?php 
                  $this->db->where('id',$d['id_question']);
                  $question = $this->db->get('question')->row_array();
                  if(!empty($question)) echo $question['question'];
                ?>
              </td>
              <td>
                  <?php 
                  $this->db->where('kondisi','selesai');
                  $this->db->where('id_user',$this->uri->segment(3));
                  $this->db->where('id_question',$d['id_question']);
                  $this->db->order_by('id','desc');
                  $mulai = $this->db->get('mulai')->result_array();
                  if(!empty($mulai)) echo  $mulai[0]['nilai'];
                  ?>
              </td>
              <td>
                <?php
                 $this->db->select('AVG(nilai) as rata2');
                 $this->db->where('kondisi','selesai');
                 $this->db->where('id_user',$this->uri->segment(3));
                 $this->db->where('id_question',$d['id_question']);
                 $rata2 = $this->db->get('mulai')->result_array();
                 if(!empty($rata2)) echo $rata2[0]['rata2'];
                ?>
              </td>
              <td>
                <?php if(!empty($question)) echo $question['nilai'];?>
              </td>
            </tr>
             <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>