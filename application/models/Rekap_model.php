<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_model extends CI_Model {

	var $table = 'users';
	var $column = array('field.field','position.position','users.grade','division.division');
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		    $this->search = '';
	}

	private function _get_datatables_query()
	{
		$this->db->select('users.grade as id_grade,COUNT(status) as total,field.field,position.position,division.division,users.id,users.id_field,users.id_position,grade.grade,users.id_division');
		$this->db->from($this->table);
		$this->db->group_by(array('users.id_field','users.id_position','users.id_division','users.grade'));
		$this->db->join('field','field.id = users.id_field','left');
		$this->db->join('division','division.id = users.id_division','left');
		$this->db->join('position','position.id = users.id_position','left');
		$this->db->join('grade','grade.id = users.grade','left');
		$this->db->where('users.deleted_at', null);
		if($this->session->userdata('level') != 'superadmin' && $this->session->userdata('level') != 'admin'){
			$this->db->where('users.id_admin', $this->session->userdata('id'));
		}
		
		$i = 0;
	
		foreach ($this->column as $item) 
		{
			if($_POST['search']['value'])
				($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
			$column[$i] = $item;
			$i++;
			$this->db->where('users.id_admin',$this->session->userdata('id'));

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
		$this->db->select('COUNT(status) as total,field.field,position.position,division.division,users.id,users.id_field,users.id_position,,grade.grade,users.id_division');
		$this->db->from($this->table);
		$this->db->group_by(array('users.id_field','users.id_position','users.id_division','users.grade'));
		$this->db->join('field','field.id = users.id_field','left');
		$this->db->join('division','division.id = users.id_division','left');
		$this->db->join('position','position.id = users.id_position','left');
		$this->db->join('grade','grade.id = users.grade','left');
		$this->db->where('users.deleted_at', null);
		if($this->session->userdata('level') != 'superadmin' && $this->session->userdata('level') != 'admin'){
			$this->db->where('users.id_admin', $this->session->userdata('id'));
		}
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->select('COUNT(status) as total,field.field,position.position,division.division,users.id,users.id_field,users.id_position,,users.grade,users.id_division');
		$this->db->from($this->table);
		$this->db->group_by(array('users.id_field','users.id_position','users.id_division','users.grade'));
		$this->db->join('field','field.id = users.id_field','left');
		$this->db->join('division','division.id = users.id_division','left');
		$this->db->join('position','position.id = users.id_position','left');
		$this->db->where('users.deleted_at', null);
		if($this->session->userdata('level') != 'superadmin' && $this->session->userdata('level') != 'admin'){
			$this->db->where('users.id_admin', $this->session->userdata('id'));
		}
		$this->db->where('users.id',$id);
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
