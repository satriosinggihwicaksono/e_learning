<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('user_agent');
		$this->load->helper('url');
    	$this->load->library('form_validation');
		if(!$this->session->logged_in){
			redirect('auth');
		}

		$this->load->model('admin_model','admin');
	}

	public function index()
	{
        $this->db->where('deleted_at',null);
        $paket = $this->db->get('paket')->result_array();

		$data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content',
            'footer' => 'footer',
            'paket' => $paket,
        ];
        
		$this->load->view('admin/template',$data);
    }
    
    public function dashboard()
	{
        $dashboard = $this->session->userdata('level');
        if($dashboard == 'content'){
            $dashboard = 'creator';
        }
		$data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => $dashboard,
            'footer' => 'footer',
        ];
        
		$this->load->view('admin/template',$data);
	}


    public function ajax_admin2()
    {
        $list = $this->admin->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $admin) {
            $time = date('d-m-Y',strtotime($admin->created_at));
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $admin->email;
            $row[] = $admin->name;
            $row[] = $admin->level;
            $row[] = $admin->paket;
            $row[] = $admin->presentase;
            if($admin->photo){
                $row[] = '<img src="'.base_url().'assets/files/users/'.$admin->photo.'" width="70px">';
            } else {
                $row[] = '<img src="'.base_url().'assets/files/users/nophoto.png" width="70px">';
            }
            $row[] = $time;
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_admin('."'".$admin->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_admin('."'".$admin->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                <a class="btn btn-sm btn-info" href="javascript:void(0)" title="View" onclick="view_admin('."'".$admin->id."'".')"><i class="glyphicon glyphicon-file"></i> View</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->admin->count_all(),
            "recordsFiltered" => $this->admin->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->admin->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        if(!empty($this->input->post('name')) && !empty($this->input->post('email'))){
            $data = array(
                'name' => $this->input->post('name'),
                'level' => $this->input->post('level'),
                'email' => $this->input->post('email'),
                'status' => $this->input->post('status'),
                'id_paket' => $this->input->post('paket'),
                'presentase' => $this->input->post('presentase'),
                'password' => md5('123456'),
                'photo' => $this->input->post('img'),
                'created_at' => date('Y-m-d'),
            );
            $this->db->where('email',$this->input->post('email'));
            $this->db->where('deleted_at',null);
            $check = $this->db->get('admin')->num_rows();
        
            if($check < 1){
                $insert = $this->admin->save($data);
                echo json_encode(array("status" => TRUE));
            } 
        }
    }

    public function ajax_update()
    {
        $data = array(
            'name' => $this->input->post('name'),
            'level' => $this->input->post('level'),
            'email' => $this->input->post('email'),
            'status' => $this->input->post('status'),
            'id_paket' => $this->input->post('paket'),
            'presentase' => $this->input->post('presentase'),
            'updated_at' => date('Y-m-d'),
        );

        if(!empty($this->input->post('img'))){
            $data['photo'] = $this->input->post('img');
        }

        $this->admin->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->admin->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function profile()
	{
        $bank = $this->db->get('bank')->result_array();
        
        $this->db->where('id',$this->session->userdata('id'));
        if($this->session->userdata('level') == 'users'){
            $profile = $this->db->get('users')->row_array();
            $content = 'profile_user';
        } else {
            $profile = $this->db->get('admin')->row_array();
            $content = 'profile';
        }

		$data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => $content,
            'footer' => 'footer',
            'profile' => $profile,
            'bank' => $bank,
        ];
        
		$this->load->view('admin/template',$data);
    }
    
    public function update()
	{
        $id = $this->input->post('id');
       
        $data = [
            'alamat' => $this->input->post('alamat'),
            'name' => $this->input->post('name'),
            'telepone' => $this->input->post('telepone'),
            'id_bank' => $this->input->post('id_bank'),
            'no_rek' => $this->input->post('no_rek'),
            'an_bank' => $this->input->post('an_bank'),
        ];

        if(!empty($this->input->post('img'))){
            $data['photo'] = $this->input->post('img');
        }
        
        $this->db->where('id',$id);
        $add = $this->db->update('admin',$data);
        
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>Update profile success.</p></div>');
        redirect('admin/profile/');
    }

    public function update_user()
	{
        $id = $this->input->post('id');
       
        $data = [
            'alamat' => $this->input->post('alamat'),
            'name' => $this->input->post('name'),
            'telepone' => $this->input->post('telepone'),
        ];

        if(!empty($this->input->post('img'))){
            $data['photo'] = $this->input->post('img');
        }
        
        $this->db->where('id',$id);
        $add = $this->db->update('users',$data);
        
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>Update profile success.</p></div>');
        redirect('admin/profile/');
    }
    
    public function setting()
	{
		$data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'setting',
            'footer' => 'footer',
        ];
        
		$this->load->view('admin/template',$data);
    }

    public function konfigurasi()
	{
        $config = $this->db->get('setting')->row_array();
		$data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'konfigurasi',
            'footer' => 'footer',
            'config' => $config,
        ];
        
		$this->load->view('admin/template',$data);
    }

    public function addkonfigurasi()
	{
        $data = [
            'name' => $this->input->post('name'),
        ];
        $this->db->where('id',1);
        $this->db->update('setting',$data);
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>Update Konfigurasi success.</p></div>');
        redirect('admin/konfigurasi');
    }

    public function update_setting()
	{
        $id = $this->input->post('id');
        $password = md5($this->input->post('password_lama'));
        $password_baru = md5($this->input->post('password_baru'));
        $this->db->where('id',$id);
        $this->db->where('password',$password);
        $cek = $this->db->get('admin')->num_rows();
        
        if($cek == 1){
            $data = [
                'password' => $password_baru,
            ];

            $this->db->where('id',$id);
            $add = $this->db->update('admin',$data);
            echo json_encode(array("status" => TRUE));
        }
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
            $imageName = 'assets/files/users/'.$time.'.png';
            file_put_contents($imageName, $data);
            echo '<img src="'.base_url().$imageName.'" class="img-thumbnail" />
            <input type="hidden" name="img" value="'.$time.'.png">';
            
        }
    }

    public function upload()
	{
        if(isset($_FILES['upload']['name'])){
            $file = $_FILES['upload']['tmp_name'];
            $file_name = $_FILES['upload']['name'];
            $file_name_array = explode(".",$file_name);
            $extension = end($file_name_array);
            $new_image_name = time().'.'.$extension;
            $allowed_extension = array("jpg", "gif", "png");
           
            if(in_array($extension, $allowed_extension))
            {
             move_uploaded_file($file, 'assets/files/ckeditor/'.$new_image_name);
             $function_number = $_GET['CKEditorFuncNum'];
             $url = base_url().'assets/files/ckeditor/'. $new_image_name;
             $message = '';
             echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
           
            }
        }
    }

    public function rekening()
	{
        $bank = $this->db->get('bank')->result_array();
		$data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_rekening',
            'footer' => 'footer',
            'bank' => $bank,
        ];
		$this->load->view('admin/template',$data);
    }

    public function add_rekening()
    {
        if(!empty($this->input->post('nama')) && !empty($this->input->post('norek')) && !empty($this->input->post('bank'))){
        $data = array(
            'nama' => $this->input->post('nama'),
			'norek' => $this->input->post('norek'),
			'bank' => $this->input->post('bank'),
        );
        
        $this->db->insert('rekening',$data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>Rekening ditambahkan</p></div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger"><p>Harap data diisi dengan lengkap</p></div>');
        }
        redirect('admin/rekening/');
    }

    public function delete_rekening($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('rekening');
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>Rekening dihapus</p></div>');
        redirect('admin/rekening/');
    }

}