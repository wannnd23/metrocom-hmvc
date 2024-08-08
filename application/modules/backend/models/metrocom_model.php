<?php
class Metrocom_model extends CI_Model
{
	public function get_data()
	{
		$data = [
			'table' => 'task_manager',
			'select' => [
				'task_manager.id',
				'task_manager.title',
				'task_manager.description',
				'task_manager.status'],
			'order' => [
				'task_manager.id',
				'DESC']
		];

		return $data;
	}

	public function get_data_byid($id)
	{
		return $this->db->get_where('task_manager', ['id' => $id])->row_array();

	}

	public function save_data($data)
	{
		$this->db->insert('task_manager', $data);
		return $this->db->affected_rows();
	}

	public function update_data($id, $data)
	{
		$this->db->update('task_manager', $data, ['id' => $id]);
		return $this->db->affected_rows();
	}

	public function delete_data($id)
	{
		$this->db->delete('task_manager', ['id' => $id]);
		return $this->db->affected_rows();
	}
}