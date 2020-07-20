<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_question_model extends CI_Model {

	var $table = 'import_question_temp';
	var $column = array('sub_question');
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->search = '';
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);
		$this->db->where('deleted_at', null);
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

	function get_datatables($id)
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where('id_question',$id);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($id)
	{
		$this->_get_datatables_query();
		$this->db->where('id_question',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_question',$id);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
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
