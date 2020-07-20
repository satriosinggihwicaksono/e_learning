<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktur extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('user_agent');
		$this->load->helper('url');
    	$this->load->library('form_validation');
		if(!$this->session->logged_in){
			redirect('auth');
		}

		$this->load->model('struktur_model','struktur');
	}

	public function index()
	{
        $this->db->where('deleted_at',null); 
        $field = $this->db->get('field')->result_array(); 

		$data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content',
            'footer' => 'footer',
            'field' => $field,
        ];
        
		$this->load->view('admin/template',$data);
    }
    
    public function level($id)
	{
		$data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_level',
            'footer' => 'footer',
        ];
        
		$this->load->view('admin/template',$data);
    }

    public function position($id,$idcor)
	{

        $this->db->select('*,position_p.id as id_position');
        $this->db->join('position','position.id = position_p.id_position','left');
        $this->db->where('position_p.id_paket',$this->uri->segment(4));
        $this->db->where('position_p.id_division',$this->uri->segment(3));
        $get = $this->db->get('position_p')->result_array();

		$data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_position',
            'footer' => 'footer',
            'data'  => $get,
        ];
        
		$this->load->view('admin/template',$data);
    }

    public function ajax_struktur()
    {
        $list = $this->struktur->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $struktur){
            $division = '';
            $this->db->select('division.division');
            $this->db->join('division','division_p.id_division = division.id','left');
            $this->db->where('division_p.id_paket',$struktur->id);
            $level = $this->db->get('division_p')->result_array();
            $count = count($level);
            $x = 1;
            foreach($level as $l){
                $total =  $count - $x++;
                if($count == 1 || $total == 0){
                    $division .= $l['division'];
                } else {
                    $division .= $l['division'].', ';
                }
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $struktur->paket;
            $row[] = $struktur->field;
            //add html for action
            $row[] = $division;
            $row[] = '<a class="btn btn-sm btn-primary" href="'.base_url().'struktur/level/'.$struktur->id.'" title="Add"><i class="glyphicon glyphicon-pencil"></i> Add</a>
            <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Edit" onclick="edit_struktur('."'".$struktur->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_struktur('."'".$struktur->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
            <a class="btn btn-sm btn-info" href="javascript:void(0)" title="View" onclick="view_struktur('."'".$struktur->id."'".')"><i class="glyphicon glyphicon-file"></i> View</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->struktur->count_all(),
            "recordsFiltered" => $this->struktur->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->struktur->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $data = array(
            'paket' => $this->input->post('name'),
            'id_field' => $this->input->post('id_field'),
            'created_at' => date('Y-m-d'),
        );

        $insert = $this->struktur->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $data = array(
            'paket' => $this->input->post('name'),
            'id_field' => $this->input->post('id_field'),
            'updated_at' => date('Y-m-d'),
        );
        
        $this->struktur->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->struktur->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function addlevel($id){
        $data = array(
            'id_paket' => $id,
            'id_division' => $this->input->post('id_division'),
        );
        
        $insert = $this->db->insert('division_p',$data);
        
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>add level success.</p></div>');
        redirect('struktur/level/'.$id);

    }
    
    public function deletelevel($id,$idcor){
        $this->db->where('id',$id);
        $delete = $this->db->delete('division_p');
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>add level success.</p></div>');
        redirect('struktur/level/'.$idcor);

    }

    public function addposition($idcor,$id){
        $data = array(
            'id_paket' => $idcor,
            'id_division' => $id,
            'id_position' => $this->input->post('id_position'),
        );
        $insert = $this->db->insert('position_p',$data);
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>deleted success.</p></div>');
        redirect('struktur/position/'.$id.'/'.$idcor);
    }

    public function deleteposition($id,$idcor,$iddiv){
        $this->db->where('id',$id);
        $delete = $this->db->delete('position_p');
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>deleted success.</p></div>');
        redirect('struktur/position/'.$idcor.'/'.$iddiv);
    }

    public function addgrade($idcor,$id){
        $grade = $this->input->post('id_grade');
        foreach($grade as $g){
            $data = array(
                'id_paket' => $idcor,
                'id_division' => $id,
                'id_position' => $this->input->post('id_position'),
                'id_grade' => $g,
            );
            $insert = $this->db->insert('grade_p',$data);
        }

        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>added grade success.</p></div>');
        redirect('struktur/position/'.$id.'/'.$idcor);
    }

    public function deletegrade($id,$idcor,$iddiv){
        $this->db->where('id',$id);
        $delete = $this->db->delete('grade_p');
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>deleted success.</p></div>');
        redirect('struktur/position/'.$iddiv.'/'.$idcor);
    }
}