<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_model extends CI_Model {

	var $table = 'question';
	var $column = array('question.id','question.question','field.field','division.division','position.position','question.status','question.grade');
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		    $this->search = '';

	}

	private function _get_datatables_query()
	{
		
		$this->db->select('question.ringkasan,question.status_article,question.status_video,COUNT(sub_question) as total,question.id,question.created_at,question.updated_at,question.deleted_at,question.question,field.field,division.division,position.position,question.status,grade.grade');
		$this->db->from($this->table);
		$this->db->join('field', 'field.id = question.field','left');
		$this->db->join('division', 'division.id = question.division','left');
		$this->db->join('position', 'position.id = question.position','left');
		$this->db->join('grade', 'grade.id = question.grade','left');
		$this->db->join('sub_question','sub_question.id_question = question.id','left')->group_by('question.id');
		$this->db->where('question.deleted_at', null);
		if($this->session->userdata('level') != 'superadmin'){
			$this->db->where('question.id_admin', $this->session->userdata('id'));
		}
		$this->db->where('status','send');
		$i = 0;
	
		foreach ($this->column as $item) 
		{
			if($_POST['search']['value'])
				($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
			$column[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->select('COUNT(sub_question) as total,question.id,question.created_at,question.updated_at,question.deleted_at,question.question,field.field,division.division,position.position,question.status,question.grade');
		$this->db->from($this->table);
		$this->db->join('field', 'field.id = question.field','left');
		$this->db->join('division', 'division.id = question.division','left');
		$this->db->join('position', 'position.id = question.position','left');
		$this->db->join('sub_question','sub_question.id_question = question.id','left')->group_by('question.id');
		$this->db->where('question.deleted_at', null);
		if($this->session->userdata('level') != 'superadmin'){
			$this->db->where('question.id_admin', $this->session->userdata('id'));
		}
		$this->db->where('status','send');
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->select(
			'COUNT(sub_question) as total,
			question.id,
			question.created_at,
			question.updated_at,
			question.deleted_at,
			question.question,
			field.field,
			division.division,
			position.position,
			question.status,
			question.grade,
			question.field as id_field,
			question.ringkasan,
			question.grade as id_grade,
			question.division as id_division,
			question.position as id_position,
			question.article,
			question.video,
			question.soal,
		');
		$this->db->from($this->table);
		$this->db->join('field', 'field.id = question.field','left');
		$this->db->join('division', 'division.id = question.division','left');
		$this->db->join('position', 'position.id = question.position','left');
		$this->db->join('sub_question','sub_question.id_question = question.id','left')->group_by('question.id');
		$this->db->where('question.deleted_at', null);
		if($this->session->userdata('level') != 'superadmin'){
			$this->db->where('question.id_admin', $this->session->userdata('id'));
		}
		$this->db->where('question.id',$id);
		$this->db->where('status','send');
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$data = [
			'deleted_at' => date('Y-m-d H:i:s'),
		];
		$this->db->where('id', $id);
		$this->db->update($this->table,$data);
	}

		public function get_by_id_view($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$results = $query->result();
		}
		return $results;
	}

}
