<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_question extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('user_agent');
		$this->load->helper('url');
    	$this->load->library('form_validation');
		if(!$this->session->logged_in){
			redirect('auth');
		}

		$this->load->model('bank_question_model','bank_question');
	}

	public function index()
	{
		$data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content',
            'footer' => 'footer',
      	];
		$this->load->view('admin/template',$data);
	}


    public function ajax_bank_question()
    {
        $list = $this->bank_question->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $bank_question) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $bank_question->question;
            if(!empty($bank_question->cover)){
                $row[] = '<img src="'.base_url().'assets/files/question/'.$bank_question->cover.'" width="80px"/>';
            } else {
                $row[] = '<img src="'.base_url().'assets/files/users/nophoto.png" width="70px">';
            }
            $row[] = $bank_question->field;
            $row[] = $bank_question->division;
            $row[] = $bank_question->position;
            $row[] = $bank_question->grade;
            $row[] = $bank_question->name;
            $row[] = '<a class="btn btn-sm btn-info btn-success" href="javascript:void(0)" title="View" onclick="view_bank_question('."'".$bank_question->id."'".')"><i class="glyphicon glyphicon-file"></i> Detail</a>';

            $data[] = $row;
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->bank_question->count_all(),
                "recordsFiltered" => $this->bank_question->count_filtered(),
                "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->bank_question->get_by_id($id);
        echo json_encode($data);
    }

    public function view_bank_soal($id)
    {
        $this->db->select('
            field.field,
            grade.grade,
            division.division,
            position.position,
            question.question,
            question.ringkasan,
            question.cover,
            question.ringkasan,
        ');
		$this->db->join('field', 'field.id = question.field','left');
		$this->db->join('division', 'division.id = question.division','left');
		$this->db->join('position', 'position.id = question.position','left');
		$this->db->join('grade', 'grade.id = question.grade','left');
        $this->db->join('admin','question.id_admin = admin.id','left');
	    $this->db->where('question.id',$id);
        $data = $this->db->get('question')->row();
        echo json_encode($data);
    }


}