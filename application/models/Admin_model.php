<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	var $table = 'admin';
	var $column = array('admin.email','admin.name','admin.level','admin.presentase','paket.paket','admin.photo','admin.created_at','admin.updated_at');
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		    $this->search = '';

	}

	private function _get_datatables_query()
	{
		$this->db->select('admin.presentase,admin.photo,admin.id,admin.email,admin.name,admin.level,admin.status,paket.paket,admin.created_at,admin.updated_at,admin.deleted_at,admin.id_paket');
		$this->db->from($this->table);
		$this->db->join('paket','admin.id_paket = paket.id','left');
		$this->db->where('admin.deleted_at', null);
		$this->db->where('admin.level !=', 'superadmin');
		$i = 0;
	
		foreach ($this->column as $item) 
		{
			if($_POST['search']['value'])
				($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
			$column[$i] = $item;
			$i++;
		}
		
		if($this->input->post('level'))
        {
            $this->db->where('admin.level', $this->input->post('level'));
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
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->select('admin.presentase,admin.photo,admin.id,admin.email,admin.name,admin.level,admin.status,paket.paket,admin.created_at,admin.updated_at,admin.deleted_at,admin.id_paket');
		$this->db->from($this->table);
		$this->db->join('paket','admin.id_paket = paket.id','left');
		$this->db->where('admin.deleted_at', null);
		$this->db->where('admin.id',$id);
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
