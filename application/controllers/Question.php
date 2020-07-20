<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('user_agent');
		$this->load->helper('url');
    	$this->load->library('form_validation');
		if(!$this->session->logged_in){
			redirect('auth');
		}

		$this->load->model('question_model','question');
	}

	public function index()
	{
        $this->db->select('division.id,division.division,division_p.id as id_division');
        $this->db->join('division','division.id = division_p.id_division','left');
        $this->db->where('division_p.id_paket',$this->session->userdata('id_paket'));
        $this->db->where('division.deleted_at',null);
        $division = $this->db->get('division_p')->result_array();

        $this->db->select('position.id,position.position,position_p.id as id_position');
        $this->db->join('position','position.id = position_p.id_position','left');
        $this->db->where('position_p.id_paket',$this->session->userdata('id_paket'));
        $this->db->where('position.deleted_at',null);
        $position = $this->db->get('position_p')->result_array();

        $this->db->select('grade.id,grade.grade,grade_p.id as id_grede');
        $this->db->join('grade','grade.id = grade_p.id_grade','left');
        $this->db->where('grade_p.id_paket',$this->session->userdata('id_paket'));
        $this->db->where('grade.deleted_at',null);
        $grade = $this->db->get('grade_p')->result_array();

        $data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content',
            'footer' => 'footer',
            'division' => $division,
            'position' => $position,
            'grade' => $grade,
		];
		$this->load->view('admin/template',$data);
	}

    public function pengajuan()
	{
        $this->db->select('question.ringkasan,question.status_article,question.status_video,question.id,question.created_at,question.updated_at,question.deleted_at,question.question,field.field,division.division,position.position,question.status,grade.grade');
        $this->db->join('grade', 'grade.id = question.grade','left');
        $this->db->join('field', 'field.id = question.field','left');
		$this->db->join('division', 'division.id = question.division','left');
		$this->db->join('position', 'position.id = question.position','left');
        $this->db->where('question.status','send');
        if($this->session->userdata('level') != 'superadmin'){
			$this->db->where('question.id_admin', $this->session->userdata('id'));
		}
        $question = $this->db->get('question')->result_array();
        
        $data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'pengajuan',
            'footer' => 'footer',
            'question' => $question,
		];
		$this->load->view('admin/template',$data);
    }
    
    public function pengajuan_materi()
	{
        $this->db->select('question.question,SUM(uji.peserta) as peserta,question.discount');
        $this->db->join('uji','uji.id_question = question.id','left');
        $this->db->join('invoice','uji.id_invoice = invoice.id','left');
        $this->db->where('invoice.status',1);
        $this->db->where('question.id_admin',$this->session->userdata('id'));
        $this->db->group_by('question.id');
        $question = $this->db->get('question')->result_array();
        //var_dump($question); die;
        
        $this->db->select('presentase');
        $this->db->where('id',$this->session->userdata('id'));
        $admin = $this->db->get('admin')->row_array();

        $data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_materi',
            'footer' => 'footer',
            'question' => $question,
            'presentase' => $admin,
		];
		$this->load->view('admin/template',$data);
    }
    
    public function pendapatan_materi()
	{
        $this->db->select('*,COUNT(id_question) as total');
        $this->db->join('question','question.id = log.id_question');
        $this->db->where('question.id_admin',$this->session->userdata('id'));
		$this->db->group_by(array('log.id_question'));
        $question = $this->db->get('log')->result_array();
        $data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_pengajuan',
            'footer' => 'footer',
            'question' => $question,
		];
		$this->load->view('admin/template',$data);
    }

    public function ajax_question()
    {
        $list = $this->question->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $question) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $question->question;
            $row[] = $question->field;
            $row[] = $question->division;
            $row[] = $question->position;
            $row[] = $question->grade;
            $row[] = $question->status;
            $row[] = $question->total;
            $row[] = '<a class="btn btn-sm btn-warning" href="'.base_url().'article/index/'.$question->id.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Tambah</a>';
            $row[] = '<a class="btn btn-sm btn-success" href="'.base_url().'sub_question/index/'.$question->id.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Tambah</a>';
            //add html for action
        $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_question('."'".$question->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_question('."'".$question->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
            <a class="btn btn-sm btn-info" href="javascript:void(0)" title="View" onclick="view_question('."'".$question->id."'".')"><i class="glyphicon glyphicon-file"></i> View</a>';

            $data[] = $row;
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->question->count_all(),
                "recordsFiltered" => $this->question->count_filtered(),
                "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->question->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $data = array(
            'question' => $this->input->post('question'),
            'division' => $this->input->post('division'),
            'position' => $this->input->post('position'),
            'ringkasan' => $this->input->post('ringkasan'),
            'grade' => $this->input->post('grade'),
            'status' => 'send',
            'created_at' => date('Y-m-d'),
            'id_admin' => $this->session->userdata('id'),
            'article' => $this->input->post('article'),
            'video' => $this->input->post('video'),
            'soal' => $this->input->post('soal'),
        );

        if($this->session->userdata('level') == 'content'){
            $data['field'] = $this->session->userdata('id_field');
        } else {
            $data['field'] = $this->input->post('field');
        }

        if(!empty($this->input->post('img'))){
            $data['cover'] = $this->input->post('img');
        }
        
        $insert = $this->question->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $data = array(
            'question' => $this->input->post('question'),
            'division' => $this->input->post('division'),
            'position' => $this->input->post('position'),
            'ringkasan' => $this->input->post('ringkasan'),
            'grade' => $this->input->post('grade'),
            'status' => 'send',
            'updated_at' => date('Y-m-d'),
            'article' => $this->input->post('article'),
            'video' => $this->input->post('video'),
            'soal' => $this->input->post('soal'),
        );

        if(!empty($this->input->post('img'))){
            $data['cover'] = $this->input->post('img');
        }

        if($this->session->userdata('level') == 'content'){
            $data['field'] = $this->session->userdata('id_field');
        } else {
            $data['field'] = $this->input->post('field');
        }

        $this->question->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->question->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function get_position(){
        $division = $_POST['division'];
        $this->db->select('position.id,position.position,position_p.id as id_position');
        $this->db->join('position','position.id = position_p.id_position');
        $this->db->where('position_p.id_paket',$this->session->userdata('id_paket'));
        $this->db->where('position_p.id_division',$division);
        $position = $this->db->get('position_p')->result_array();
        echo "<option> -- Select Position -- </option>";
        foreach($position as $p){
            echo '<option data-id="'.$p['id_position'].'" value="'.$p['id'].'">'.$p['position'].'</option>';
        }
    }

    public function get_grade(){
        $grade = $_POST['grade'];
        $this->db->select('grade.id,grade.grade');
        $this->db->join('grade','grade.id = grade_p.id_grade');
        $this->db->where('grade_p.id_paket',$this->session->userdata('id_paket'));
        $this->db->where('grade_p.id_position',$grade);
        $grade = $this->db->get('grade_p')->result_array();
        echo "<option> -- Select Grade -- </option>";
        foreach($grade as $g){
            echo "<option value='" . $g['id'] . "'>" . $g['grade'] . "</option>";
        }
    }


    public function revisi_soal(){
        $status = array('revision','apply','back','send');
        $this->db->where_in('status', $status);
        $this->db->where_in('status_article', $status);
        $this->db->where_in('status_video', $status);
        if($this->session->userdata('level') != 'superadmin'){
            $this->db->where('id_admin',$this->session->userdata('id'));
        }
        $question = $this->db->get('question')->result_array();
        $data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_revisi',
            'footer' => 'footer',
            'question' => $question,
		];
		$this->load->view('admin/template',$data);
    }

    public function crop()
	{
        if(!empty($this->input->post('image')))
        {
            $data = $this->input->post("image");
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $time = time();
            $imageName = 'assets/files/question/'.$time.'.png';
            file_put_contents($imageName, $data);
            echo '<img src="'.base_url().$imageName.'" class="img-thumbnail" />
            <input type="hidden" name="img" value="'.$time.'.png">';
            
        }
    }

}