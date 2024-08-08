<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Metrocom extends CI_Controller {
	public function __construct()
	{
		parent:: __construct();
		$this->load->library('datatables_ci3');
		$this->load->model('metrocom_model', 'metrocom');
	}

	public function index()
	{
		$data['title'] = "Metrocom";
		$this->load->view('v-index', $data);
	}

	public function get_data()
	{
		$dataArr = $this->metrocom->get_data();
		$fetchData = $this->datatables_ci3->generate($dataArr);
		$data = [];
		$no = $_POST['start'];

		foreach ($fetchData['data'] as $key) {
			if ($key->status == 'Pending') {
				$status = '<span class="badge badge-warning">Pending</span>';
			} elseif ($key->status == 'In Progress') {
				$status = '<span class="badge badge-info">In Progress</span>';
			} elseif ($key->status == 'Completed') {
				$status = '<span class="badge badge-success">Completed</span>';
			}

			$edit = "<button class='btn btn-primary btn-sm' onclick='edit({$key->id});'><i class='fa-solid fa-edit'></i></button>";
			$delete = "<button class='btn btn-danger btn-sm' onclick='deleted({$key->id})'><i class='fa-solid fa-trash'></i></button>";

			$no++;
			$row = [];
			$row[] = $no;
			$row[] = $key->title;
			$row[] = $status;
			$row[] = $edit.' '.$delete;

			$data[] = $row;
		}

		$output = [
			'draw'				=> $_POST['draw'],
			'recordsTotal'		=> $fetchData['recordsTotal'],
			'recordsFiltered'	=> $fetchData['recordsFiltered'],
			'data'				=> $data
		];

		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	public function get_data_add()
	{
		$this->load->view('backend/modal/add');
	}

	public function save_data()
	{
		$data = [
			'title' => $_POST['title'],
			'description' => $_POST['description']
		];

		$this->metrocom->save_data($data);
		$this->session->set_flashdata('messuccess', 'Your data has been added.');
		redirect(base_url(''));
	}

	public function get_data_edit()
	{
		$id = $_POST['id'];
		$data['dataById'] = $this->metrocom->get_data_byid($id);
		$this->load->view('backend/modal/edit', $data);
	}

	public function update_data()
	{
		$id = $_POST['id'];
		$data = ['status' => $_POST['status']];

		$this->metrocom->update_data($id, $data);	
		$this->session->set_flashdata('messuccess', 'Your data has been updated.');
		redirect(base_url(''));
	}

	public function delete_data()
	{
		$id = $_POST['id'];
		$this->metrocom->delete_data($id);
	}
}