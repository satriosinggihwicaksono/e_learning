<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_detail extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('user_agent');
		$this->load->helper('url');
    	$this->load->library('form_validation');
		if(!$this->session->logged_in){
			redirect('auth');
		}

		$this->load->model('rekap_detail_model','rekap_detail');
	}

	public function index($id_field,$id_division,$id_position,$grade)
	{
        
        $this->db->where('field',$id_field);
        $this->db->where('division',$id_division);
        $this->db->where('position',$id_position);
        $this->db->where('deleted_at',null);
        $this->db->where('status','ready');
        $this->db->where('status_article','apply');
        $this->db->where('status_article','apply');
        $question = $this->db->get('question')->result_array();

		$data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content',
            'footer' => 'footer',
            'question' => $question,
            'id_field' => $id_field,
            'id_division' => $id_division,
            'id_position' => $id_position,
            'grade' => $grade,
		];
		
		$this->load->view('admin/template',$data);
	}


    public function ajax_rekap_detail($id_field,$id_division,$id_position,$grade)
    {
        $list = $this->rekap_detail->get_datatables($id_field,$id_division,$id_position,$grade);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rekap_detail) {
            $no++;
            $row = array();
            $row[] = $rekap_detail->judul;
            $row[] = $rekap_detail->time;
            $row[] = $rekap_detail->article;
            $row[] = $rekap_detail->video;
            $row[] = $rekap_detail->question;
            $row[] = $rekap_detail->peserta;
        
            //add html for action
        $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_rekap_detail('."'".$rekap_detail->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_rekap_detail('."'".$rekap_detail->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a> ';

            $data[] = $row;
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->rekap_detail->count_all($id_field,$id_division,$id_position,$grade),
                "recordsFiltered" => $this->rekap_detail->count_filtered($id_field,$id_division,$id_position,$grade),
                "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->rekap_detail->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->db->where('grade',$this->input->post('grade'));
        $this->db->where('id_position',$this->input->post('id_position'));
        $this->db->where('id_field',$this->input->post('id_field'));
        $this->db->where('id_division',$this->input->post('id_division'));
        $this->db->where('id_admin',$this->session->userdata('id'));
        $this->db->where('deleted_at',null);
        $total = $this->db->get('users')->num_rows();
        
        $data = array(
            'id_question' => $this->input->post('id_question'),
            'id_field' => $this->input->post('id_field'),
            'id_position' => $this->input->post('id_position'),
            'id_division' => $this->input->post('id_division'),
            'grade' => $this->input->post('grade'),
            'article' => $this->input->post('article'),
            'question' => $this->input->post('question'),
            'time' => $this->input->post('time'),
            'id_admin' => $this->session->userdata('id'),
            'peserta' => $total,
        );
        
        $this->db->where('id_field',$this->input->post('id_field'));
        $this->db->where('id_position',$this->input->post('id_position'));
        $this->db->where('id_division',$this->input->post('id_division'));
        $this->db->where('id_question',$this->input->post('id_question'));
        $this->db->where('id_admin',$this->session->userdata('id'));
        $cek = $this->db->get('uji')->num_rows();
        if($cek < 1){
            $insert = $this->rekap_detail->save($data);
            echo json_encode(array("status" => TRUE));
        }
    }

    public function ajax_update()
    {
        $data = array(
                'id_question' => $this->input->post('id_question'),
                'article' => $this->input->post('article'),
                'question' => $this->input->post('question'),
                'time' => $this->input->post('time'),
            );
        $this->rekap_detail->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->rekap_detail->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}