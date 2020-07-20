<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap extends CI_Controller {

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
        $this->load->model('rekap_model','rekap');
        $this->load->helper('tgl_indo');
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
    
    public function invoice()
	{
		$data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_invoice',
            'footer' => 'footer',
		];
		$this->load->view('admin/template',$data);
    }
    
    public function konfirmasi()
	{
		$data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_konfirmasi',
            'footer' => 'footer',
		];
		$this->load->view('admin/template',$data);
	}

    public function kelas(){
        $this->db->select('users.grade as id_grade,COUNT(status) as total,field.field,position.position,division.division,users.id,users.id_field,users.id_position,grade.grade,users.id_division,users.id_admin');
		$this->db->group_by(array('users.id_field','users.id_position','users.id_division','users.grade'));
		$this->db->join('field','field.id = users.id_field','left');
		$this->db->join('division','division.id = users.id_division','left');
		$this->db->join('position','position.id = users.id_position','left');
		$this->db->join('grade','grade.id = users.grade','left');
		$this->db->where('users.deleted_at', null);
		if($this->session->userdata('level') != 'superadmin' && $this->session->userdata('level') != 'admin'){
			$this->db->where('users.id_admin', $this->session->userdata('id'));
        }
        $data = $this->db->get('users')->result_array();
        $data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_kelas',
            'footer' => 'footer',
            'data' => $data,
		];
		
		$this->load->view('admin/template',$data);
    }

    public function shop($id_field,$id_division,$id_position,$grade){
      
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
			'content' => 'content_shop',
            'footer' => 'footer',
            'data' => $question,
            'id_field' => $id_field,
            'id_division' => $id_division,
            'id_position' => $id_position,
            'grade' => $grade,
		];
		
		$this->load->view('admin/template',$data);
    }

    public function question($id){
        $this->db->where('id',$id);
        $question = $this->db->get('question')->row_array();
        echo json_encode($question);
    }

    public function ajax_add()
    {
        $this->db->where('grade',$this->input->post('grade'));
        $this->db->where('id_position',$this->input->post('id_position'));
        $this->db->where('id_field',$this->input->post('id_field'));
        $this->db->where('id_division',$this->input->post('id_division'));
        $this->db->where('id_admin',$this->session->userdata('id'));
        $this->db->where('deleted_at',null);
        $total_user = $this->db->get('users')->num_rows();

        $this->db->where('id_field',$this->input->post('id_field'));
        $this->db->where('id_position',$this->input->post('id_position'));
        $this->db->where('id_division',$this->input->post('id_division'));
        $this->db->where('id_admin',$this->session->userdata('id'));
        $this->db->where('id_grade',$this->input->post('grade'));
        $count = $this->db->get('history')->num_rows();

        $total = $total_user - $count;
        
        $data = array(
            'id_question' => $this->input->post('id_question'),
            'id_field' => $this->input->post('id_field'),
            'id_position' => $this->input->post('id_position'),
            'id_division' => $this->input->post('id_division'),
            'grade' => $this->input->post('grade'),
            'time' => $this->input->post('time'),
            'id_admin' => $this->session->userdata('id'),
            'peserta' => $total,
        );
        
        $this->db->where('id_field',$this->input->post('id_field'));
        $this->db->where('id_position',$this->input->post('id_position'));
        $this->db->where('id_division',$this->input->post('id_division'));
        $this->db->where('id_question',$this->input->post('id_question'));
        $this->db->where('id_admin',$this->session->userdata('id'));
        $this->db->where('id_invoice',0);
        $cek = $this->db->get('uji')->num_rows();
        if($cek < 1){
            $insert = $this->rekap_detail->save($data);
            echo json_encode(array("status" => TRUE));
        }
    }

    public function ajax_rekap()
    {
        $list = $this->rekap->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rekap) {
            $no++;
            $row = array();
            $row[] = $rekap->field;
            $row[] = $rekap->division;
            $row[] = $rekap->position;
            $row[] = $rekap->grade;
            $row[] = $rekap->total;
        
       //     $row[] = '<a class="btn btn-sm btn-success" href="'.base_url('rekap_detail/index/'.$rekap->id_field.'/'.$rekap->id_division.'/'.$rekap->id_position.'/'.$rekap->id_grade).'" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Detail</a>';
            $data[] = $row;
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->rekap->count_all(),
                "recordsFiltered" => $this->rekap->count_filtered(),
                "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_table_keranjang()
    {
        $this->db->select('*,uji.time as tgl,uji.id');
        $this->db->join('question','question.id = uji.id_question','left');
        $this->db->where('uji.id_invoice',0);
        $this->db->where('uji.id_admin',$this->session->userdata('id'));
        $query = $this->db->get('uji');
        $list = $query->result_array();
        $count = $query->num_rows();

        $this->db->where('uji.id_admin',$this->session->userdata('id'));
        $this->db->from('uji');
        $count_result = $this->db->count_all_results();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $k) {
            $total = $k['peserta'] * $k['discount'];
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $k['question'];
            $row[] = '<img src="'.base_url().'assets/files/question/'.$k["cover"].'" width="100px">';
            $row[] = $k['tgl'];
            $row[] = $k['discount'];
            $row[] = $k['peserta'];
            $row[] = $total;
            $row[] = '<button onclick="delete_keranjang('.$k["id"].')" class="btn btn-danger">Delete</button>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $count_result,
            "recordsFiltered" => $count,
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function loadkeranjang(){
        $this->db->where('id_admin',$this->session->userdata('id'));
        $this->db->where('id_invoice',0);
        $total = $this->db->get('uji')->num_rows();
        echo $total;
    }

    public function delete_keranjang($id){
        $this->db->where('id',$id);
        $this->db->delete('uji');
        echo json_encode(array("status" => TRUE));
    }

    public function loadtotal(){
        $total = array();
        $this->db->join('question','uji.id_question = question.id','left');
        $this->db->where('uji.id_admin',$this->session->userdata('id'));
        $this->db->where('uji.id_invoice',0);
        $uji = $this->db->get('uji')->result_array();
        foreach($uji as $u){
          $total[] = $u['peserta'] * $u['discount'];
        }
        $total = array_sum($total);
        echo $total;
    }

    public function beli(){
        $this->db->select('*,uji.id');
        $this->db->join('question','question.id = uji.id_question','left');
        $this->db->where('uji.id_admin',$this->session->userdata('id'));
        $this->db->where('uji.id_invoice',0);
        $uji = $this->db->get('uji')->result_array();
        $total_bayar = array();
        foreach($uji as $uj){
            $total_bayar[] = $uj['peserta'] * $uj['discount'];
        }

        $total = $this->db->get('invoice')->num_rows();

        $tgl_kadarluasa = date('Y-m-d', strtotime('+7 days', strtotime(date('Y-m-d'))));
        $data = array(
            'tanggal' => date('Y-m-d'),
            'tgl_kadarluasa' => $tgl_kadarluasa,
            'invoice' => 'INV00'.$total,
            'id_admin' => $this->session->userdata('id'),
            'total' => array_sum($total_bayar),
        );
        $this->db->insert('invoice',$data);

        $id = $this->db->insert_id();
        foreach($uji as $u){
            $this->db->where('id',$u['id']);
            $this->db->update('uji',array('id_invoice' => $id));
        }

        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>Tangihan telah ditambahkan</p></div>');
        redirect('rekap/invoice');
    }

    public function ckonfirmasi($id)
    {   

        $this->db->join('uji','invoice.id = uji.id_invoice','left');
        $this->db->where('invoice.id',$id);
        $this->db->limit(1);
        $invoice = $this->db->get('invoice')->row_array();
        
        $id_division = $invoice['id_division'];
        $id_field = $invoice['id_field'];
        $id_position = $invoice['id_position'];
        $id_grade = $invoice['grade'];
        $id_admin = $invoice['id_admin'];
        $peserta = $invoice['peserta'];


        $this->db->where('id_division',$id_division);
        $this->db->where('id_field',$id_field);
        $this->db->where('id_position',$id_position);
        $this->db->where('id_grade',$id_grade);
        $this->db->where('id_admin',$id_admin);
        $fillter = $this->db->get('history')->result_array();


        $this->db->select('id');
        $this->db->where('id_division',$id_division);
        $this->db->where('id_field',$id_field);
        $this->db->where('id_position',$id_position);
        $this->db->where('grade',$id_grade);
        $this->db->where('deleted_at',null);
        $this->db->where('id_admin',$id_admin);
        foreach($fillter as $f){
            $this->db->where('id !=',$f['id_user']);
        }
        $this->db->limit($peserta);
        $this->db->order_by('id','asc');
        $user = $this->db->get('users')->result_array();
        
        foreach($user as $u){
            $data = [
                'id_field' => $id_field,
                'id_user' => $u['id'],
                'id_division' => $id_division,
                'id_position' => $id_position,
                'id_grade' => $id_grade,
                'id_invoice' => $id,
                'id_admin' => $id_admin,
            ];
            $this->db->insert('history',$data);
        }

        $this->db->where('id',$id);
        $this->db->update('invoice', array('status' => 1));
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>Tangihan telah dikonfirmasi</p></div>');
        redirect('rekap/konfirmasi');   
    }

    public function detail_invoice($id){
        $setting = $this->db->get('setting')->row_array();

        $this->db->select('*');
        $this->db->join('uji','invoice.id = uji.id_invoice','left');
        $this->db->join('question','question.id = uji.id_question','left');
        $this->db->join('admin','admin.id = invoice.id_admin','left');
        $this->db->where('invoice.id',$id);
        $invoice = $this->db->get('invoice')->result_array();

        $data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
            'footer' => 'footer',
            'invoice' => $invoice,
            'setting' => $setting,
        ];
        
        $this->load->view('rekap/invoice',$data);
    }

    public function mymateri(){
        $this->db->select('question.ringkasan,question.id,question.cover,grade.grade,field.field,position.position,division.division,question.question');
        $this->db->join('field','field.id = uji.id_field','left');
        $this->db->join('position','position.id = uji.id_position','left');
        $this->db->join('division','division.id = uji.id_division','left');
        $this->db->join('grade','grade.id = uji.grade','left');
        $this->db->join('question','uji.id_question = question.id','left');
        $this->db->join('invoice','uji.id_invoice = invoice.id','left');
        $this->db->where('invoice.id_admin',$this->session->userdata('id'));
        $this->db->group_by('uji.id_question');
        $this->db->where('invoice.status',1);
        $data = $this->db->get('uji')->result_array();
        $data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_materi',
            'footer' => 'footer',
            'data' => $data,
		];
		$this->load->view('admin/template',$data);
    }

    public function article($id){
        $this->db->where('category','article');
        $this->db->where('id_question',$id);
        $data = $this->db->get('article_question')->result_array();
        $data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_article',
            'footer' => 'footer',
            'data' => $data,
		];
		$this->load->view('admin/template',$data);
    }

    public function soal($id){
        $this->db->where('id_question',$id);
        $data = $this->db->get('sub_question')->result_array();
      
        $data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_soal',
            'footer' => 'footer',
            'data' => $data,
		];
		$this->load->view('admin/template',$data);
    }
    
    public function video($id){
        $this->db->where('category','video');
        $this->db->where('id_question',$id);
        $data = $this->db->get('article_question')->result_array();
      
        $data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_video',
            'footer' => 'footer',
            'data' => $data,
		];
		$this->load->view('admin/template',$data);
    }
    
    public function konfirmasi_invoice($id){
        
        $data = [
			'id_invoice' => $id,
			'tanggal' => $this->input->post('tanggal'),
			'jumlah' => $this->input->post('jumlah'),
			'nama' => $this->input->post('nama'),
            'rekening' => $this->input->post('rekening'),
            'bank' => $this->input->post('bank'),
        ];
        if(!empty($this->input->post('id'))){
            $this->db->where('id',$this->input->post('id'));
            $insert = $this->db->update('konfirmasi',$data);
        } else {
            $insert = $this->db->insert('konfirmasi',$data);
        }
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><p>Data telah tersimpan.</p></div>');
        redirect('rekap/invoice');
    }

    public function materi()
	{
        $this->db->where('deleted_at',null);
        $this->db->where('id_admin',$this->session->userdata('id'));
        $users = $this->db->get('users')->result_array();

        $data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_materi_user',
            'footer' => 'footer',
            'users' => $users,
		];
		$this->load->view('admin/template',$data);
    }

    public function nilai_user()
	{

        $this->db->select('question.ringkasan,question.id,question.question');
        $this->db->join('field','field.id = uji.id_field','left');
        $this->db->join('question','uji.id_question = question.id','left');
        $this->db->join('invoice','uji.id_invoice = invoice.id','left');
        $this->db->group_by('uji.id_question');
        $this->db->where('invoice.status',1);
        $this->db->where('invoice.id_admin',$this->session->userdata('id'));
        $materi = $this->db->get('uji')->result_array();

		$data = [
			'header' => 'header',
			'menu' => 'menu',
			'sidebar' => 'sidebar',
			'content' => 'content_nilai',
            'footer' => 'footer',
            'materi' => $materi,
		];
		$this->load->view('admin/template',$data);
    }
}