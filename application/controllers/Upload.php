<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('user_agent');
		$this->load->helper('url');
    	$this->load->library('form_validation');
	}
	
	function upload_image() {
        $id = $this->uri->segment(3);
        $folderPath = "assets/files/users/";
        
        $img = $_POST['photo'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $fileName = time() . '.png';
        $target_dir = $folderPath . $fileName;
        $success = file_put_contents($target_dir, $data);
    
        $data = array(
            'photo'  => $fileName,
        );
        $this->db->where('id', $id);
        $update = $this->db->update('users', $data);
        
        if ($update) {
            $b['message'] = "Sukses";
            $b['status'] = "202";
            $b['url_photo'] = base_url().'assets/files/users/'.$fileName;
        } else {
            $b['message'] = "Eror";
            $b['status'] = "502";
        }
        echo json_encode($b);
	}

}
