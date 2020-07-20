<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_users_model extends CI_Model {

	var $table = 'import_users_temp';
	var $column = array('import_users_temp.name','import_users_temp.email','field.field','position.position','division.division','grade.grade');
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		    $this->search = '';

	}

	private function _get_datatables_query()
	{
		$this->db->select('import_users_temp.id_grade,import_users_temp.id_grade,grade.grade,import_users_temp.id,field.field,position.position,division.division,import_users_temp.name,import_users_temp.email,import_users_temp.status,import_users_temp.deleted_at,import_users_temp.updated_at,import_users_temp.created_at,import_users_temp.id_field,import_users_temp.id_position,import_users_temp.id_division');
		$this->db->from($this->table);
		$this->db->join('field','field.id = import_users_temp.id_field','left');
		$this->db->join('division','division.id = import_users_temp.id_division','left');
		$this->db->join('position','position.id = import_users_temp.id_position','left');
		$this->db->join('grade','grade.id = import_users_temp.id_grade','left');
		$this->db->where('import_users_temp.deleted_at', null);
		$this->db->where('import_users_temp.id_admin', $this->session->userdata('id'));
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
		$this->db->select('import_users_temp.id_grade,import_users_temp.id_grade,grade.grade,import_users_temp.id,field.field,position.position,division.division,import_users_temp.name,import_users_temp.email,import_users_temp.status,import_users_temp.deleted_at,import_users_temp.updated_at,import_users_temp.created_at,import_users_temp.id_field,import_users_temp.id_position,import_users_temp.id_division');
		$this->db->from($this->table);
		$this->db->join('field','field.id = import_users_temp.id_field','left');
		$this->db->join('division','division.id = import_users_temp.id_division','left');
		$this->db->join('position','position.id = import_users_temp.id_position','left');
		$this->db->join('grade','grade.id = import_users_temp.id_grade','left');
		$this->db->where('import_users_temp.deleted_at', null);
		$this->db->where('import_users_temp.id_admin', $this->session->userdata('id'));
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->select('import_users_temp.id_grade,import_users_temp.id_grade,grade.grade,import_users_temp.id,field.field,position.position,division.division,import_users_temp.name,import_users_temp.email,import_users_temp.status,import_users_temp.deleted_at,import_users_temp.updated_at,import_users_temp.created_at,import_users_temp.id_field,import_users_temp.id_position,import_users_temp.id_division');
		$this->db->from($this->table);
		$this->db->join('field','field.id = import_users_temp.id_field','left');
		$this->db->join('division','division.id = import_users_temp.id_division','left');
		$this->db->join('position','position.id = import_users_temp.id_position','left');
		$this->db->join('grade','grade.id = import_users_temp.id_grade','left');
		$this->db->where('import_users_temp.deleted_at', null);
		$this->db->where('import_users_temp.id_admin', $this->session->userdata('id'));
		$this->db->where('import_users_temp.id',$id);
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
		$this->db->where('id', $id);
		$this->db->delete($this->table);
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
