<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('user_agent');
		$this->load->helper('url');
    	$this->load->library('form_validation');
		if(!$this->session->logged_in && $this->uri->segment(2) != 'upload'){
			redirect('auth');
		}

		$this->load->model('users_model','users');
	}

	public function index()
	{
        $this->db->select('division.id,division.division,division_p.id as id_division');
        $this->db->join('division','division.id = division_p.id_division','left')->group_by('division_p.id_division');
        $this->db->where('division_p.id_paket',$this->session->userdata('id_paket'));
        $this->db->where('division.deleted_at',null);
        $division = $this->db->get('division_p')->result_array();

        $this->db->select('position.id,position.position,position_p.id as id_position');
        $this->db->join('position','position.id = position_p.id_position','left')->group_by('position_p.id_position');
        $this->db->where('position_p.id_paket',$this->session->userdata('id_paket'));
        $this->db->where('position.deleted_at',null);
        $position = $this->db->get('position_p')->result_array();

        $this->db->select('grade.id,grade.grade,grade_p.id as id_grede');
        $this->db->join('grade','grade.id = grade_p.id_grade','left')->group_by('grade_p.id_grade');
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


    public function ajax_user()
    {
        $list = $this->users->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $users) {
            $no++;
            $row = array();
            $row[] = $users->name;
            $row[] = $users->email;
            $row[] = $users->field;
            $row[] = $users->division;
            $row[] = $users->position;
            $row[] = $users->grade_p;
            $row[] = $users->status;

            //add html for action
        $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_users('."'".$users->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_users('."'".$users->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
            <a class="btn btn-sm btn-info" href="javascript:void(0)" title="View" onclick="view_users('."'".$users->id."'".')"><i class="glyphicon glyphicon-file"></i> View</a>';

            $data[] = $row;
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->users->count_all(),
                "recordsFiltered" => $this->users->count_filtered(),
                "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->users->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'status' => $this->input->post('status'),
            'id_division' => $this->input->post('division'),
            'id_position' => $this->input->post('position'),
            'grade' => $this->input->post('grade'),
            'id_admin' => $this->session->userdata('id'),
            'created_at' => date('Y-m-d'),
        );
        if($this->session->userdata('level') == 'superadmin'){
            $data['id_field'] = $this->input->post('field');
        } else {
            $data['id_field'] = $this->session->userdata('id_field');
        }
        $this->db->where('email',$this->input->post('email'));
        $this->db->where('deleted_at',null);
        $check = $this->db->get('users')->num_rows();
        if($check < 1){
            $insert = $this->users->save($data);
            echo json_encode(array("status" => TRUE));
        }
    }

    public function ajax_update()
    {
        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'status' => $this->input->post('status'),
            'id_division' => $this->input->post('division'),
            'id_position' => $this->input->post('position'),
            'grade' => $this->input->post('grade'),
            'updated_at' => date('Y-m-d'),
        );

        if($this->session->userdata('level') == 'superadmin'){
            $data['id_field'] = $this->input->post('field');
        } else {
            $data['id_field'] = $this->session->userdata('id_field');
        }

        $this->users->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->users->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    public function upload($id){

        file_get_contents('photo');
        if(!empty($_FILES['photo']['name'])){
            $file = $_FILES['photo']['tmp_name'];
            file_get_contents($file);
            $file_name = $_FILES['photo']['name'];
            $file_name_array = explode(".",$file_name);
            $extension = end($file_name_array);
            $new_image_name = time().'.'.$extension;
            $allowed_extension = array("jpg", "gif", "png");
           
            if(in_array($extension, $allowed_extension))
            {
             move_uploaded_file($file, 'assets/files/users/'.$new_image_name);
                $data = array(
                    'photo' => $new_image_name,
                );
                $this->db->where('id',$id);
                $update = $this->db->update('users',$data);
                $data2 = array(
                    'status' => 'sukses',
                    'image' => base_url().'assets/files/users/'.$new_image_name,
                );
            } 
        } else {
            $data2 = array(
                'status' => 'fail',
                'image' => base_url().'assets/files/users/',
            );
        }

        echo json_encode($data2);
    }
}