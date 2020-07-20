<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Price_question extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('user_agent');
		$this->load->helper('url');
    	$this->load->library('form_validation');
		if(!$this->session->logged_in){
			redirect('auth');
		}

		$this->load->model('price_question_model','price_question');
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


    public function ajax_price_question()
    {
        $list = $this->price_question->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $price_question) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $price_question->question;
            $row[] = $price_question->field;
            $row[] = $price_question->division;
            $row[] = $price_question->position;
            $row[] = $price_question->grade;
            $row[] = $price_question->status;
            $row[] = $price_question->price;
            $row[] = $price_question->discount;
            $row[] = $price_question->time;
            $row[] = $price_question->nilai;
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_price_question('."'".$price_question->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->price_question->count_all(),
            "recordsFiltered" => $this->price_question->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->price_question->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_update()
    {
        $data = array(
            'price' => $this->input->post('harga'),
            'discount' => $this->input->post('diskon'),
            'status' => 'ready',
            'status_article' => 'apply',
            'status_video' => 'apply',
            'time' => $this->input->post('time'),
            'nilai' => $this->input->post('nilai'),
        );
        $this->price_question->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
}