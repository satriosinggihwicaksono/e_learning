<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends CI_Controller {

	public function __construct(){
        parent::__construct();
        if(!$this->session->logged_in){
			redirect('auth');
		}
		$this->load->helper('form');
		$this->load->library('user_agent');
		$this->load->helper('url');
    	$this->load->library('form_validation');
		if(!$this->session->logged_in){
			redirect('auth');
		}

		$this->load->model('article_model','article');
	}

	public function index()
	{
        
        $this->db->select('audit_question.status,admin.name,audit_question.description,audit_question.id,audit_question.time');
        $this->db->join('admin','admin.id = audit_question.id_admin','left');
        $this->db->where('audit_question.type','article');
        $this->db->where('audit_question.id_question',$this->uri->segment(3));
        $article_question = $this->db->get('audit_question')->result_array();

        $this->db->select('audit_question.status,admin.name,audit_question.description,audit_question.id,audit_question.time');
        $this->db->join('admin','admin.id = audit_question.id_admin','left');
        $this->db->where('audit_question.type','video');
        $this->db->where('audit_question.id_question',$this->uri->segment(3));
        $video_question = $this->db->get('audit_question')->result_array();


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
            'article_question' => $article_question,
            'video_question' => $video_question,
		];
		
		$this->load->view('admin/template',$data);
	}


    public function ajax_article($id)
    {
        $list = $this->article->get_datatables($id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $article) {
            if($article->category == 'article'){
                $show = '<img src="'.base_url().'assets/files/videos/'.$article->video.'" width=100px;>';
            } else {
                $show = '<a rel="noopener" target="_blank" href="'.base_url('article/play/'.$article->id).'">'.$article->video.'</a>';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $article->title;
            $row[] = $article->category;
            $row[] = $show;
        
            //add html for action
        $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_article('."'".$article->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_article('."'".$article->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
            <a class="btn btn-sm btn-info" href="javascript:void(0)" title="View" onclick="view_article('."'".$article->id."'".')"><i class="glyphicon glyphicon-file"></i> View</a>';

            $data[] = $row;
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->article->count_all($id),
                "recordsFiltered" => $this->article->count_filtered($id),
                "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_table_article($id)
    {

        $this->db->select('audit_question.revision,audit_question.status,admin.name,audit_question.description,audit_question.id,audit_question.time');
        $this->db->join('admin','admin.id = audit_question.id_admin','left');
        $this->db->where('audit_question.type','article');
        $this->db->where('audit_question.id_question',$id);
        $list = $this->db->get('audit_question')->result_array();

        $this->db->where('id_question',$id);
        $this->db->from('audit_question');
        $this->db->where('type','article');
        $count = $this->db->count_all_results();

        $this->db->where('id_question',$id);
        $this->db->where('type','article');
        $filtter = $this->db->get('audit_question')->num_rows();

        $data = array();
        $no = 1;
        foreach ($list as $aq) {
            $row = array();
            $row[] = $no;
            $row[] = $aq['name'];
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

    public function ajax_table_video($id)
    {

        $this->db->select('audit_question.revision,audit_question.status,admin.name,audit_question.description,audit_question.id,audit_question.time');
        $this->db->join('admin','admin.id = audit_question.id_admin','left');
        $this->db->where('audit_question.type','video');
        $this->db->where('audit_question.id_question',$id);
        $list = $this->db->get('audit_question')->result_array();

        $this->db->where('id_question',$id);
        $this->db->from('audit_question');
        $this->db->where('type','video');
        $count = $this->db->count_all_results();

        $this->db->where('id_question',$id);
        $this->db->where('type','video');
        $filtter = $this->db->get('audit_question')->num_rows();

        $data = array();
        $no = 1;
        foreach ($list as $aq) {
            $row = array();
            $row[] = $no;
            $row[] = $aq['name'];
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

    public function ajax_edit($id)
    {
        $data = $this->article->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_delete($id)
    {
        $this->article->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }


    public function add_article($id)
    {

        if($this->input->post('category') == 'video'){
            $data = array(
                'article' => $this->input->post('article'),
                'title' => $this->input->post('title'),
                'id_question' => $id,
                'category' => $this->input->post('category'),
            );

            $config['upload_path']="./assets/files/videos/";
            $config['file_name'] = time();
            $config['max_size'] = '40000';
            $config['allowed_types'] = 'avi|flv|wmv|mp3|mp4';
            $config['overwrite'] = TRUE;
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload',$config);

            if(!empty($this->input->post('cover'))){
                $data['thumbnail'] = $this->input->post('cover');
            }
            
            if(!empty($_FILES['video']['name'])){
                $this->upload->do_upload("video");
                $photo = array('upload_data' => $this->upload->data());
                $data['video'] = $photo['upload_data']['file_name'];
            }

            if($this->input->post('id') != ""){
                $this->db->where('id',$this->input->post('id'));
                $update = $this->db->update('article_question',$data); 
            } else {
                $insert = $this->db->insert('article_question',$data);
            }
        } else {
            
            $data = array(
                'article' => $this->input->post('article'),
                'title' => $this->input->post('title'),
                'id_question' => $id,
                'category' => $this->input->post('category'),
            );

            if(!empty($this->input->post('id'))){
                $data['video'] = $this->input->post('cover');
                $this->db->where('id',$this->input->post('id'));
                $update = $this->db->update('article_question',$data); 
            } else {
                $data['video'] = $this->input->post('cover');
                $insert = $this->db->insert('article_question',$data);
            }
        }
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>Insert and Update success.</p></div>');
        redirect('article/index/'.$id);
    }

    public function play($id)
    {
        $this->db->where('id',$id);
        $video  = $this->db->get('article_question')->row_array();
		$data = [
            'video' => $video['video'],
		];
        $this->load->view('article/play',$data);
    }

    public function crop()
	{
        if(!empty($this->input->post('image')))
        {
            $data = $this->input->post("image");
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $time = time();
            $imageName = 'assets/files/videos/'.$time.'.png';
            file_put_contents($imageName, $data);
            echo '<img src="'.base_url().$imageName.'" class="img-thumbnail" />
            <input type="hidden" name="cover" value="'.$time.'.png">';
        }
    }
}