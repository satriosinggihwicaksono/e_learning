<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
		$this->load->helper('url');
		$this->load->model('m_login');
		$this->load->helper('form');
		$this->load->library('form_validation');

		if($this->session->logged_in && $this->uri->segment(2) != 'logout'){
			redirect('e_learning');
		}

	}

	public function admin()
	{
		$this->load->view('login/index');
	}

	public function index()
	{
		$this->load->view('login/index');
		// $this->load->view('login/user');
	}

	public function forgot()
	{
		$this->load->view('login/forgot');
	}

	function aksi_login(){
		$this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('password','Password','required');
		
		if($this->form_validation->run() === FALSE ){
			$this->session->set_flashdata('message','<b>Isi Kolom Email dan Password!!!</b>');
			redirect('auth/admin');
		} else {
		
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$where = array(
				'email' => $email,
				'password' => md5($password),
				'deleted_at' => null,
			);

			$this->db->where('email',$email);
			$cek_email = $this->db->get('admin')->row_array();
			
			if($cek_email == 0){
				$this->session->set_flashdata('message','<b>Email Belum Terdaftar</b>');
				redirect('auth/admin');
			}

			$cek = $this->m_login->cek_login("admin",$where)->row_array();
			if($cek > 0){
				$this->db->where('id',$cek['id_paket']);
				$paket = $this->db->get('paket')->row_array();
				$data_session = array(
					'name' => $cek['name'],
					'email' => $email,
					'id' => $cek['id'],
					'id_paket' => $cek['id_paket'],
					'level' => $cek['level'],
					'logged_in' => TRUE,
				);
				if(!empty($paket)){
					$data_session['id_field'] = $paket['id_field'];
				} else {
					$data_session['id_field'] = 0;
				}
				$this->session->set_userdata($data_session);
				$this->session->set_flashdata('message','<b>Selamat Datang</b>');
				redirect('admin/dashboard');
			} else {
				$this->session->set_flashdata('message','<b>Password Anda Salah</b>');
				redirect('auth/admin');
			}
		}
	}
	
	function aksi_login_user(){
		$this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('password','Password','required');
		
		if($this->form_validation->run() === FALSE ){
			$this->session->set_flashdata('message','<b>Isi Kolom Email dan Password!!!</b>');
			redirect('auth');
		} else {
		
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$where = array(
				'email' => $email,
				'password' => md5($password)
			);

			$this->db->where('email',$email);
			$cek_email = $this->db->get('users')->row_array();
			
			if($cek_email == 0){
				$this->session->set_flashdata('message','<b>Email Belum Terdaftar</b>');
				redirect('auth');
			}

			$cek = $this->m_login->cek_login("users",$where)->row_array();
			if($cek > 0){
	
				$data_session = array(
					'name' => $cek['name'],
					'email' => $email,
					'id' => $cek['id'],
					'id_admin' => $cek['id_admin'],
					'level' => 'users',	
					'grade' => $cek['grade'],
					'id_position' => $cek['id_position'],
					'id_division' => $cek['id_division'],
					'id_field' => $cek['id_field'],
					'logged_in' => TRUE,
				);
	
				$this->session->set_userdata($data_session);
				$this->session->set_flashdata('message','<b>Selamat Datang</b>');
				redirect('admin/dashboard');
			} else {
				$this->session->set_flashdata('message','<b>Password Anda Salah</b>');
				redirect('auth');
			}
		}
	}

	function logout(){
		$level = $this->session->userdata('level');
		$this->session->sess_destroy();
		if($level == 'users'){
			redirect();
		} else {
			redirect('auth/admin');
		}
	}
}
