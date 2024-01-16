<?php

class Lembur extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ModelLembur');

		if ($this->session->userdata('hak_akses') != '2') {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
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
		$data['lembur'] = $this->ModelLembur->get_data();
		$id = $this->session->userdata('id_pegawai');
		$data['pegawai'] = $this->db->query("SELECT * FROM data_pegawai WHERE id_pegawai='$id'")->result();

		$this->load->view('template_pegawai/header', $data);
		$this->load->view('template_pegawai/sidebar');
		$this->load->view('pegawai/lembur', $data);
		$this->load->view('template_pegawai/footer');
	}
	public function save()
	{
		$id_pegawai = $this->session->userdata('id_pegawai');
		$nik = $this->session->userdata('nik');

		$getLembur = $this->ModelLembur->get_data();
		

		$image = $this->input->post('image');
		$image = str_replace('data:image/jpeg;base64,', '', $image);
		$image = base64_decode($image);
		$filename = 'image_' . time() . '.jpg';  // Adjust the file extension if needed
		$filepath = FCPATH . 'Lembur/' . $filename;

		// Make sure the directory exists, create it if not
		if (!is_dir(FCPATH . 'Lembur/')) {
			mkdir(FCPATH . 'Lembur/');
		}

		// Save the image to the specified path
		if (file_put_contents($filepath, $image) !== false) {
			echo 'Image uploaded successfully.';
		} else {
			echo 'Failed to upload the image.';
		}

		$time=date("H:i:s");
		$dt=date("Y-m-d");
		if($getLembur->status_lembur==1){
			
			$status_absen = 2; // 1=> masuk | 2=> pulang
			$data = array(
				'tanggal_pulang' => $dt,
				'waktu_pulang' => $time,
				'status_lembur' => $status_absen,
				'image_pulang' => $filename,
 			);
			$whare=[
				"id" => $getLembur->id
				];
 			$res = $this->ModelLembur->update_data("lembur", $data, $whare);
			 $this->ModelLembur->updateRekapAbsen($getLembur->id);

		}else{
			$status_absen = 1; // 1=> masuk | 2=> pulang
			$data = array(
				'id_pegawai' => $id_pegawai,
				'tanggal' => $dt,
				'waktu' => $time,
				'status_lembur' => $status_absen,
				'image' => $filename,
				'nik' => $nik,
			);
	
			$res = $this->ModelLembur->insert_data($data, "lembur");
			//  $this->ModelLembur->updateRekapAbsen($nik);
  		}

		



		// Respond with JSON
		header('Content-Type: application/json');
		echo json_encode(array('success' => true));
	}
}
