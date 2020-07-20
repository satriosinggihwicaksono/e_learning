<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_question extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('user_agent');
		$this->load->helper('url');
    	$this->load->library('form_validation');
		if(!$this->session->logged_in){
			redirect('auth');
		}

		$this->load->model('sub_question_model','sub_question');
	}

	public function index()
	{
        $this->db->select('question.question,field.field,division.division,position.position,question.status,question.grade');
		$this->db->join('field', 'field.id = question.field','left');
		$this->db->join('division', 'division.id = question.division','left');
		$this->db->join('position', 'position.id = question.position','left');
        $this->db->where('question.deleted_at', null);
        $this->db->where('question.id',$this->uri->segment(3));
        $question  = $this->db->get('question')->row_array();

		$data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content',
            'footer' => 'footer',
            'question' => $question,
		];
		
		$this->load->view('admin/template',$data);
	}


    public function ajax_auidt_history($id)
    {

        $this->db->select('audit_question.revision,audit_question.status,admin.name,audit_question.description,audit_question.id,audit_question.time');
        $this->db->join('admin','admin.id = audit_question.id_admin','left');
        $this->db->where('audit_question.type','question');
        $this->db->where('audit_question.id_question',$id);
        $list = $this->db->get('audit_question')->result_array();

        $this->db->where('id_question',$id);
        $this->db->where('type','question');
        $this->db->from('audit_question');
        $count = $this->db->count_all_results();

        $this->db->where('id_question',$id);
        $this->db->where('type','question');
        $filtter = $this->db->get('audit_question')->num_rows();

        $data = array();
        $no = 1;
        foreach ($list as $aq) {
            $row = array();
            $row[] = $no;
            $row[] = $aq['name'];
            $row[] = $aq['revision'];
            $row[] = $aq['status'];
            $row[] = $aq['description'];
            $row[] = $aq['time'];
            $data[] = $row;
            $no++;
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $count,
                "recordsFiltered" => $filtter,
                "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_sub_question($id)
    {
        $list = $this->sub_question->get_datatables($id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $sub_question) {
            $this->db->where('id_question',$sub_question->id_question);
            $this->db->limit(1);
            $this->db->order_by('id','desc');
            $ad = $this->db->get('audit_question')->row_array();
            if(!empty($ad['revision'])){
                $arr_revision = explode (",",$ad['revision']);
                if(in_array($sub_question->id,$arr_revision)){
                    $status = 'revisi';
                } else {
                    $status = 'diterima';
                }
            } else {
                $status = 'belum diproses';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $sub_question->sub_question;
            $row[] = $sub_question->answer;
            $row[] = $status;
        
            //add html for action
        $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_sub_question('."'".$sub_question->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_sub_question('."'".$sub_question->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
            <a class="btn btn-sm btn-info" href="javascript:void(0)" title="View" onclick="view_sub_question('."'".$sub_question->id."'".')"><i class="glyphicon glyphicon-file"></i> View</a>';

            $data[] = $row;
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->sub_question->count_all($id),
                "recordsFiltered" => $this->sub_question->count_filtered($id),
                "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->sub_question->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add($id)
    {
        $data = array(
            'sub_question' => $this->input->post('sub_question'),
            'a' => $this->input->post('a'),
            'b' => $this->input->post('b'),
            'c' => $this->input->post('c'),
            'd' => $this->input->post('d'),
            'e' => $this->input->post('e'),
            'answer' => $this->input->post('answer'),
            'id_question' => $id,
            'created_at' => date('Y-m-d'),
        );
        $insert = $this->sub_question->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update($id)
    {
        $data = array(
            'sub_question' => $this->input->post('sub_question'),
            'a' => $this->input->post('a'),
            'b' => $this->input->post('b'),
            'c' => $this->input->post('c'),
            'd' => $this->input->post('d'),
            'e' => $this->input->post('e'),
            'answer' => $this->input->post('answer'),
            'id_question' => $id,
            'updated_at' => date('Y-m-d'),
        );
        $this->sub_question->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->sub_question->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}