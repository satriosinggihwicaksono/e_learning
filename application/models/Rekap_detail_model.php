<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_detail_model extends CI_Model {

	var $table = 'uji';
	var $column = array('judul','uji.time');
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		    $this->search = '';

	}

	private function _get_datatables_query()
	{
		$this->db->select('uji.peserta,uji.video,uji.id_question,uji.id,field.field,division.division,position.position,uji.article,uji.question,uji.id_field,uji.id_position,uji.id_division,uji.question,question.question as judul,uji.time');
		$this->db->from($this->table);
		$this->db->join('field','field.id = uji.id_field','left');
		$this->db->join('position','position.id = uji.id_position','left');
		$this->db->join('division','division.id = uji.id_division','left');
		$this->db->join('question','question.id = uji.id_question','left');
		
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

	function get_datatables($id_field,$id_division,$id_position,$grade)
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where('uji.id_field',$id_field);
		$this->db->where('uji.id_division',$id_division);
		$this->db->where('uji.id_position',$id_position);
		$this->db->where('uji.grade',$grade);
		$this->db->where('uji.id_admin',$this->session->userdata('id'));
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($id_field,$id_division,$id_position,$grade)
	{
		$this->_get_datatables_query();
		$this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where('uji.id_field',$id_field);
		$this->db->where('uji.id_division',$id_division);
		$this->db->where('uji.id_position',$id_position);
		$this->db->where('uji.grade',$grade);
		$this->db->where('uji.id_admin',$this->session->userdata('id'));
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($id_field,$id_division,$id_position,$grade)
	{
		$this->db->select('uji.id_question,uji.id,field.field,division.division,position.position,uji.article,uji.question,uji.id_field,uji.id_position,uji.id_division,uji.question,question.question as judul,uji.time');
		$this->db->from($this->table);
		$this->db->join('field','field.id = uji.id_field','left');
		$this->db->join('position','position.id = uji.id_position','left');
		$this->db->join('division','division.id = uji.id_division','left');
		$this->db->join('question','question.id = uji.id_question','left');
		$this->db->where('uji.id_field',$id_field);
		$this->db->where('uji.id_division',$id_division);
		$this->db->where('uji.id_position',$id_position);
		$this->db->where('uji.grade',$grade);
		$this->db->where('uji.id_admin',$this->session->userdata('id'));
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->select('uji.id_question,uji.id,field.field,division.division,position.position,uji.article,uji.question,uji.id_field,uji.id_position,uji.id_division,uji.question,question.question as judul,uji.time');
		$this->db->from($this->table);
		$this->db->join('field','field.id = uji.id_field','left');
		$this->db->join('position','position.id = uji.id_position','left');
		$this->db->join('division','division.id = uji.id_division','left');
		$this->db->join('question','question.id = uji.id_question','left');
		$this->db->where('uji.id_admin',$this->session->userdata('id'));
		$this->db->where('uji.id',$id);
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
