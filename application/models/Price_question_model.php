<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Price_question_model extends CI_Model {

	var $table = 'question';
	var $column = array('question.id','question.question','field.field','division.division','position.position','question.status','question.grade','question.discount','question.price','question.time','question.nilai');
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		    $this->search = '';

	}

	private function _get_datatables_query()
	{
		
		$this->db->select('question.nilai,question.time,admin.name,question.price,question.discount,question.status_dis,question.id,question.created_at,question.updated_at,question.deleted_at,question.question,field.field,division.division,position.position,question.status,question.grade');
		$this->db->from($this->table);
		$this->db->join('field', 'field.id = question.field','left');
		$this->db->join('division', 'division.id = question.division','left');
		$this->db->join('position', 'position.id = question.position','left');
		$this->db->join('admin','question.id_admin = admin.id','left');
		$this->db->where('admin.deleted_at', null);
		$this->db->where('question.deleted_at', null);
		$where = "question.status='ready' OR question.status='apply'";
		$this->db->where($where);
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
		$this->db->where('deleted_at', null);
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->select('question.nilai,question.time,admin.name,question.price,question.discount,question.status_dis,question.id,question.created_at,question.updated_at,question.deleted_at,question.question,question.status,question.grade');
		$this->db->from($this->table);
		$this->db->join('admin','question.id_admin = admin.id','left');
		$this->db->where('admin.deleted_at', null);
		$this->db->where('question.deleted_at', null);
		$this->db->where('question.id',$id);
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

}
