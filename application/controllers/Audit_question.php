<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_question extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('user_agent');
		$this->load->helper('url');
    	$this->load->library('form_validation');
		if(!$this->session->logged_in){
			redirect('auth');
		}

		$this->load->model('audit_question_model','audit_question');
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
    
    public function audit($id)
	{
        $this->db->where('id_question',$id);
        $sub_question = $this->db->get('sub_question')->result_array();

        $this->db->where('id_question',$id);
        $this->db->where('type','question');
        $audit_question = $this->db->get('audit_question')->result_array();
        
        $this->db->select('question,field.field,division.division,position.position,question.status,question.grade');
        $this->db->join('field', 'field.id = question.field','left');
		$this->db->join('division', 'division.id = question.division','left');
		$this->db->join('position', 'position.id = question.position','left');
        $this->db->where('question.id',$id);
        $question = $this->db->get('question')->row_array();
        
        $data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_audit',
            'footer' => 'footer',
            'sub_question' => $sub_question,
            'question' => $question,
            'audit_question' => $audit_question,
       ];
		$this->load->view('admin/template',$data);
    }
    
    public function audit_article($id)
	{
        $this->db->where('id_question',$id);
        $this->db->where('category','article');
        $article_question = $this->db->get('article_question')->result_array();

        $this->db->where('id_question',$id);
        $this->db->where('type','article');
        $audit_question = $this->db->get('audit_question')->result_array();
        
        $this->db->select('question,field.field,division.division,position.position,question.status,question.grade');
        $this->db->join('field', 'field.id = question.field','left');
		$this->db->join('division', 'division.id = question.division','left');
		$this->db->join('position', 'position.id = question.position','left');
        $this->db->where('question.id',$id);
        $question = $this->db->get('question')->row_array();
        
        $data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_audit_artcle',
            'footer' => 'footer',
            'article_question' => $article_question,
            'question' => $question,
            'audit_question' => $audit_question,
       ];
		$this->load->view('admin/template',$data);
    }
    
    public function audit_video($id)
	{
        $this->db->where('id_question',$id);
        $this->db->where('category','video');
        $video_question = $this->db->get('article_question')->result_array();

        $this->db->where('id_question',$id);
        $this->db->where('type','video');
        $audit_question = $this->db->get('audit_question')->result_array();
        
        $this->db->select('question,field.field,division.division,position.position,question.status,question.grade');
        $this->db->join('field', 'field.id = question.field','left');
		$this->db->join('division', 'division.id = question.division','left');
		$this->db->join('position', 'position.id = question.position','left');
        $this->db->where('question.id',$id);
        $question = $this->db->get('question')->row_array();
        
        $data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_audit_video',
            'footer' => 'footer',
            'video_question' => $video_question,
            'question' => $question,
            'audit_question' => $audit_question,
       ];
		$this->load->view('admin/template',$data);
	}


    public function ajax_audit_question()
    {
        $list = $this->audit_question->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $audit_question) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $audit_question->question;
            $row[] = $audit_question->field;
            $row[] = $audit_question->division;
            $row[] = $audit_question->position;
            $row[] = $audit_question->grade;
            $row[] = $audit_question->status;
            $row[] = $audit_question->status_article;
            $row[] = $audit_question->status_video;
            $row[] = $audit_question->total;
            $row[] = '<a class="btn btn-sm btn-success" href="'.base_url().'audit_question/audit/'.$audit_question->id.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Soal</a>';
            $row[] = '<a class="btn btn-sm btn-success" href="'.base_url().'audit_question/audit_article/'.$audit_question->id.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Artikel</a>';
            $row[] = '<a class="btn btn-sm btn-success" href="'.base_url().'audit_question/audit_video/'.$audit_question->id.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Video</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->audit_question->count_all(),
            "recordsFiltered" => $this->audit_question->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->audit_question->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_edit_audit($id)
    {
		$this->db->from('audit_question');
		$this->db->where('id_question',$id);
		$query = $this->db->get();

		$data =  $query->row();
        echo json_encode($data);
    }

    public function ajax_update()
    {
        $data = array(
            'description' => $this->input->post('description'),
            'status' => $this->input->post('status'),
            'revision' => $this->input->post('revision'),
        );
        $this->db->where('id_question',$this->input->post('id'));
        $this->db->update('audit_question',$data);
        
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->audit_question->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function revision_content()
    {
        $data = array(
            'description' => $this->input->post('description'),
            'status' => $this->input->post('status'),
            'revision' => $this->input->post('revision'),
            'time' => date('Y-m-d H:i:s'),
            'id_admin' => $this->session->userdata('id'),
            'id_question' => $this->input->post('id'),
        );
        $this->db->insert('audit_question',$data);
        
        echo json_encode(array("status" => TRUE));
    }

    public function revision(){
        $revision = $this->input->post('revision');
        $description = $this->input->post('description');
        $question = $this->input->post('id_question');
        $status = $this->input->post('status');
        $type = $this->input->post('type');
        if($type == 'question'){
            $rev = '';
            for($i=0; $i<count($this->input->post('revision')); $i++){
                if(!empty($revision[$i])){
                    $rev .= $revision[$i].',';
                }
            }
        } else {
            $rev = '';
        }
        $data = [
            'revision' =>  $rev,
            'description' => $description,
            'status' => $status,
            'id_question' => $question,
            'time' => date('Y-m-d H:i:s'),
            'id_admin' => $this->session->userdata('id'),
            'type' => $type, 
        ];

        $add = $this->db->insert('audit_question',$data);
        
        if($add){
            $data = array();
            if($type == 'question'){
                $data['status'] = $status;
            } elseif($type == 'article'){
                $data['status_article'] = $status;
            } else {
                $data['status_video'] = $status;
            }

            $this->db->where('id',$question);
            $update = $this->db->update('question',$data);
        }

        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>Update audit success.</p></div>');
        redirect('audit_question/');
    }

    public function hapus_audit($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('audit_question');
        redirect($this->agent->referrer());       
    }
}