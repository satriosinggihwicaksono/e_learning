<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_users extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('user_agent');
		$this->load->helper('url');
    	$this->load->library('form_validation');
		if(!$this->session->logged_in){
			redirect('auth');
		}

        $this->load->model('import_users_model','import_users');
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
	}

	public function index()
	{
        $this->db->where('id',$this->session->userdata('id_field'));
        $field = $this->db->get('field')->row_array();
        
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
            'field' => $field,
		];
		
		$this->load->view('admin/template',$data);
	}


    public function ajax_user()
    {
        $list = $this->import_users->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $import_users) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $import_users->name;
            $row[] = $import_users->email;
            $row[] = $import_users->field;
            $row[] = $import_users->division;
            $row[] = $import_users->position;
            $row[] = $import_users->grade;
            $row[] = $import_users->status;

            //add html for action
        $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_import_users('."'".$import_users->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_import_users('."'".$import_users->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
            <a class="btn btn-sm btn-info" href="javascript:void(0)" title="View" onclick="view_import_users('."'".$import_users->id."'".')"><i class="glyphicon glyphicon-file"></i> View</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->import_users->count_all(),
            "recordsFiltered" => $this->import_users->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->import_users->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'status' => $this->input->post('status'),
            'id_field' => $this->session->userdata('id_field'),
            'id_division' => $this->input->post('division'),
            'id_position' => $this->input->post('position'),
            'id_grade' => $this->input->post('grade'),
            'id_admin' => $this->session->userdata('id'),
            'created_at' => date('Y-m-d'),
        );
        $insert = $this->import_users->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'status' => $this->input->post('status'),
            'id_field' => $this->session->userdata('id_field'),
            'id_division' => $this->input->post('division'),
            'id_position' => $this->input->post('position'),
            'id_grade' => $this->input->post('grade'),
            'updated_at' => date('Y-m-d'),
        );
        $this->import_users->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->import_users->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function import_temp()
    {
        if(empty($_FILES['file']['name'])){
            $this->session->set_flashdata('msg', '<div class="alert alert-danger"><p>Anda Belum Upload file.</p></div>');
            redirect('import_users/index/');
        }

        $fileName = time().$_FILES['file']['name']; 
        $config['upload_path'] = './assets/'; //buat folder dengan nama assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;
         
        $this->load->library('upload');
        $this->upload->initialize($config);
         
        if(! $this->upload->do_upload('file') )
        $this->upload->display_errors();
             
        $media = $this->upload->data('file');
        $inputFileName = './assets/'.$fileName;
        chmod(FCPATH.'assets/'.$fileName,0777);
         
        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
 
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
             
            for ($row = 2; $row <= $highestRow; $row++){              //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
            $data = array(
                'email' => $rowData[0][0],
                'name' => $rowData[0][1],
                'password' => md5(123456),
                'status' => 'A',
                'id_field' => $rowData[0][2],
                'id_division' => $rowData[0][3],
                'id_position' => $rowData[0][4],
                'id_admin' => $this->session->userdata('id'),
                'id_grade' => $rowData[0][5],
                'created_at' => date('Y-m-d'),
            );
            $this->db->insert('import_users_temp',$data);
        }
        unlink(FCPATH.'assets/'.$fileName);
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>Data has uploaded.</p></div>');
        redirect('import_users/index/'.$id);
    }

    public function clear()
    {
        $this->db->where('id_admin',$this->session->userdata('id'));
        $this->db->delete('import_users_temp');
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>Data has cleared.</p></div>');
        redirect('import_users/');
    }

    public function import()
    {
        $this->db->where('id_admin',$this->session->userdata('id'));
        $users_temp = $this->db->get('import_users_temp')->result_array();
        if(empty($users_temp)){
            $this->session->set_flashdata('msg', '<div class="alert alert-danger"><p>Tidak ada data yang di import.</p></div>');
            redirect('import_users/');    
        }
        foreach($users_temp as $u){
            $data = [
                'email' => $u['email'],
                'name' => $u['name'],
                'password' => md5($u['password']),
                'status' => 'A',
                'id_field' => $u['id_field'],
                'id_division' => $u['id_division'],
                'id_position' => $u['id_position'],
                'grade' => $u['id_grade'],
                'id_admin' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d'),
            ];
            $this->db->insert('users',$data);
        }
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>Import users success.</p></div>');
        redirect('users/');
    }
}