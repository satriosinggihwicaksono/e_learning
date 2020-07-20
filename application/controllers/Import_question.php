<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_question extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('user_agent');
		$this->load->helper('url');
    	$this->load->library('form_validation');
		if(!$this->session->logged_in){
			redirect('auth');
		}
        $this->load->model('import_question_model','import_question');
       
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
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


    public function ajax_import_question($id)
    {
        $list = $this->import_question->get_datatables($id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $import_question) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $import_question->sub_question;
            $row[] = $import_question->answer;
        
            //add html for action
        $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_import_question('."'".$import_question->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_import_question('."'".$import_question->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
            <a class="btn btn-sm btn-info" href="javascript:void(0)" title="View" onclick="view_import_question('."'".$import_question->id."'".')"><i class="glyphicon glyphicon-file"></i> View</a>';

            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->import_question->count_all($id),
                        "recordsFiltered" => $this->import_question->count_filtered($id),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->import_question->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add($id)
    {
        $data = array(
            'sub_question' => $this->input->post('import_question'),
            'a' => $this->input->post('a'),
            'b' => $this->input->post('b'),
            'c' => $this->input->post('c'),
            'd' => $this->input->post('d'),
            'e' => $this->input->post('e'),
            'answer' => $this->input->post('answer'),
            'id_question' => $id,
            'created_at' => date('Y-m-d'),
        );
        $insert = $this->import_question->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update($id)
    {
        $data = array(
            'sub_question' => $this->input->post('import_question'),
            'a' => $this->input->post('a'),
            'b' => $this->input->post('b'),
            'c' => $this->input->post('c'),
            'd' => $this->input->post('d'),
            'e' => $this->input->post('e'),
            'answer' => $this->input->post('answer'),
            'id_question' => $id,
            'updated_at' => date('Y-m-d'),
        );
        $this->import_question->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->import_question->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function import_temp($id)
    {
        if(empty($_FILES['file']['name'])){
            $this->session->set_flashdata('msg', '<div class="alert alert-danger"><p>Anda Belum Upload file.</p></div>');
            redirect('import_question/index/'.$id);
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
                'sub_question' => $rowData[0][0],
                'a' => $rowData[0][1],
                'b' => $rowData[0][2],
                'c' => $rowData[0][3],
                'd' => $rowData[0][4],
                'e' => $rowData[0][5],
                'answer' => $rowData[0][6],
                'id_question' => $id,
                'created_at' => date('Y-m-d'),
            );
            $this->db->insert('import_question_temp',$data);
        }
        unlink(FCPATH.'assets/'.$fileName);
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>Data has uploaded.</p></div>');
        redirect('import_question/index/'.$id);
    }

    public function clear($id)
    {
        $this->db->where('id_question',$id);
        $this->db->delete('import_question_temp');
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>Data has cleared.</p></div>');
        redirect('import_question/index/'.$id);
    }

    public function import($id)
    {
        $this->db->where('id_question',$id);
        $question_temp = $this->db->get('import_question_temp')->result_array();
        if(empty($question_temp)){
            $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>Tidak ada data yang di import.</p></div>');
            redirect('import_question/index/'.$id);    
        }
        foreach($question_temp as $q){
            $data = [
                'sub_question' => $q['sub_question'],
                'a' => $q['a'],
                'b' => $q['b'],
                'c' => $q['c'],
                'd' => $q['d'],
                'e' => $q['e'],
                'answer' => $q['answer'],
                'id_question' => $id,
                'created_at' => date('Y-m-d'),
            ];
            $this->db->insert('sub_question',$data);
        }
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>Import examp success.</p></div>');
        redirect('sub_question/index/'.$id);
    }
}