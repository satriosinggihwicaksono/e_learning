<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grade extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('user_agent');
		$this->load->helper('url');
    	$this->load->library('form_validation');
		if(!$this->session->logged_in){
			redirect('auth');
		}

		$this->load->model('grade_model','grade');
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


    public function ajax_grade()
    {
        $list = $this->grade->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $grade) {
            $no++;
            $row = array();
            $row[] = $grade->grade;
        
            //add html for action
        $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_grade('."'".$grade->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_grade('."'".$grade->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->grade->count_all(),
                        "recordsFiltered" => $this->grade->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->grade->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $data = array(
                'grade' => $this->input->post('name'),
                'created_at' => date('Y-m-d'),
            );
        $insert = $this->grade->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $data = array(
                'grade' => $this->input->post('name'),
                'updated_at' => date('Y-m-d'),
            );
        $this->grade->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->grade->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}