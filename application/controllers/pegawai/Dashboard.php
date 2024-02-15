<?php

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('ModelPresensi');
		$this->load->model('ModelLembur');

		if($this->session->userdata('hak_akses') != '2'){
			$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Anda Belum Login!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
				redirect('login');
		}
	}
	public function index() 
	{
		$data['title'] = "Dashboard";
		$id=$this->session->userdata('id_pegawai');
		$nik=$this->session->userdata('nik');
		
		if($_GET){
			$tanggal = $_GET['date'];
			$this->db->where("nik", $nik);
			$this->db->where("tanggal", $tanggal);
			$getPresensi = $this->db->get("presensi")->row();
			// var_dump($tanggal);
			// var_dump($id);
			// var_dump($getPresensi);
		}else{
			$getPresensi=$this->ModelPresensi->get_data();
			$tanggal = date("Y-m-d");

		}
		$data['date']=$tanggal;
		$data['presensi']=$getPresensi;
		$data['dataLembur'] =$this->ModelLembur->get_data();
 
		// $getPresensi = $this->ModelPresensi->get_data();
 

		// var_dump($data['lembur']->id);
		$data['pegawai'] = $this->db->query("SELECT * FROM data_pegawai WHERE id_pegawai='$id'")->result();

		$this->load->view('template_pegawai/header',$data);
		$this->load->view('template_pegawai/sidebar');
		$this->load->view('pegawai/dashboard', $data);
		$this->load->view('template_pegawai/footer');
	}
}

?>