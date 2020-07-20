<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uji extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('user_agent');
		$this->load->helper('url');
    	$this->load->library('form_validation');
		if(!$this->session->logged_in){
			redirect('auth');
		}

		$this->load->model('uji_model','uji');
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

    public function ajax_uji()
    {
        $list = $this->uji->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $value = 'Apa kamu yakin delete this item?';
        $add = 'onclick="return confirm('.$value.');"';
        foreach ($list as $uji) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $uji->time;
            $row[] = $uji->question;
            $row[] = $uji->field;
            $row[] = $uji->division;
            $row[] = $uji->position;
            $row[] = $uji->grade;
            $row[] = '';
            $row[] = '<a class="btn btn-sm btn-success" href="'.base_url().'uji/start/'.$uji->id.'/'.$uji->id_uji.'/'.$uji->id_admin.'" title="Kerjakan"><i class="glyphicon glyphicon-pencil"></i> Kerjan</a>';;
            //add html for action
        
            $data[] = $row;
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->uji->count_all(),
                "recordsFiltered" => $this->uji->count_filtered(),
                "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->uji->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_update()
    {
        $data = array(
            'uji' => $this->input->post('uji'),
            'division' => $this->input->post('division'),
            'field' => $this->input->post('field'),
            'position' => $this->input->post('position'),
            'grade' => $this->input->post('grade'),
            'status' => 'send',
            'updated_at' => date('Y-m-d'),
        );
        $this->uji->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->uji->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function ujian($id){
        $this->db->where('id',$id);
        $question = $this->db->get('question')->result_array();

        $this->db->where('id_question',$id);
        $sub_question = $this->db->get('sub_question')->result_array();

        $data = array(
            'question' => $question,
            'sub_question' => $sub_question,
        );
        $this->load->view('examp/index',$data);
    }

    public function start($id,$id_uji,$id_admin){
        $this->db->where('id_question',$id);
        $this->db->where('id_uji',$id_uji);
        $cek = $this->db->get('hasil_uji')->num_rows();
        if($cek == 0){
            $data = [
                'id_question' => $id,
                'id_user' => $this->session->userdata('id'),
                'id_uji' => $id_uji,
                'id_admin' => $id_admin,
                'created_at' => date('Y-m-d'),
            ];
       
        $this->db->insert('hasil_uji',$data);
        }
        $this->db->where('id',$id);
        $question = $this->db->get('question')->row_array();

        $this->db->where('id_question',$id);
        $sub_question = $this->db->get('sub_question')->result_array();
       
        $data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_uji',
            'footer' => 'footer',
            'question' => $question,
            'sub_question' => $sub_question,
        ];
		$this->load->view('admin/template',$data);
    }

}