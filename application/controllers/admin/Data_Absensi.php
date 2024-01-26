<?php

class Data_Absensi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('hak_akses') != '1') {
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
		$data['title'] = "Data Absensi Pegawai";

		if ((isset($_GET['bulan']) && $_GET['bulan'] != '') && (isset($_GET['tahun']) && $_GET['tahun'] != '')) {
			$bulan = $_GET['bulan'];
			$tahun = $_GET['tahun'];
			$bulantahun = $bulan . $tahun;
		} else {
			$bulan = date('m');
			$tahun = date('Y');
			$bulantahun = $bulan . $tahun;
		}

		$data['absensi'] = $this->db->query("SELECT data_kehadiran.*, data_pegawai.nama_pegawai, data_pegawai.jenis_kelamin, data_pegawai.jabatan
			FROM data_kehadiran
			INNER JOIN data_pegawai ON data_kehadiran.nik= data_pegawai.nik
			INNER JOIN data_jabatan ON data_pegawai.jabatan = data_jabatan.nama_jabatan
			WHERE data_kehadiran.bulan='$bulantahun' ORDER BY data_pegawai.nama_pegawai ASC")->result();

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/absensi/data_absensi', $data);
		$this->load->view('template_admin/footer');
	}

	public function input_absensi()
	{
		if ($this->input->post('submit', TRUE) == 'submit') {
			$post = $this->input->post();

			foreach ($post['bulan'] as $key => $value) {
				if ($post['bulan'][$key] != '' || $post['nik'][$key] != '') {
					$simpan = array(
						// 'nik'     => $post['nik'][$key], 
						'sakit'   => $post['sakit'][$key],
						'alpha'   => $post['alpha'][$key],
					);

					// $where should be an associative array
					$where = array('nik' => $post['nik'][$key]);

					// Update the data in the 'data_kehadiran' table
					$this->ModelPenggajian->update_data('data_kehadiran', $simpan, $where);
				}
			}
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data berhasil ditambahkan!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect('admin/data_absensi');
		}

		$data['title'] = "Updadet Absensi";

		if ((isset($_GET['bulan']) && $_GET['bulan'] != '') && (isset($_GET['tahun']) && $_GET['tahun'] != '')) {
			$bulan = $_GET['bulan'];
			$tahun = $_GET['tahun'];
			$bulantahun = $bulan . $tahun;
		} else {
			$bulan = date('m');
			$tahun = date('Y');
			$bulantahun = $bulan . $tahun;
		}
		$data['input_absensi'] = $this->db->query("SELECT * FROM data_kehadiran WHERE bulan='$bulantahun' ORDER BY nama_pegawai ASC")->result();
		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/absensi/tambah_dataAbsensi', $data);
		$this->load->view('template_admin/footer');
	}
	public function detailAbsen($nik,$month)
{
    // Corrected table name and adjusted ORDER BY clause
	// echo $nik;
	$p = $this->db->query("SELECT * FROM data_pegawai WHERE nik = $nik")->row();
	// var_dump($p);
	
	$kehadiran = $this->db->query("SELECT * FROM detail_absensi WHERE kh_nik = '$p->nik' ORDER BY p_tanggal ASC;")->result();
	if($p){
		$pegawai=$p->nama_pegawai;
	}
    // Assuming 'tanggal' is the correct column name for date
    $data['title'] = "Detail Kehadiran [ " . $pegawai . " ]";
    $data['data'] = $kehadiran;
    $data['nik'] = $p->nik;
 	 
	
 	// $month = 8;
$timezone = new DateTimeZone('Asia/Jakarta');
$currentDateTime = new DateTime('now', $timezone);
$firstDayOfMonth = $currentDateTime->format('Y-m-01');

// Set the month to the specified value
$currentDateTime->setDate($currentDateTime->format('Y'), $month, 1);
$firstDayOfMonth = $currentDateTime->format('Y-m-01');

// Get the last day of the specified month
$lastDayOfMonth = $currentDateTime->format('Y-m-t');

// Create an array of all dates in the specified month
// var_dump($firstDayOfMonth);
$allDatesInMonth = [];
$currentDate = new DateTime($firstDayOfMonth);
while ($currentDate <= new DateTime($lastDayOfMonth)) {
    $allDatesInMonth[] = $currentDate->format('Y-m-d');
    $currentDate->modify('+1 day');
}

$data['tanggal'] = $allDatesInMonth;
$data['countTanggal'] = count($allDatesInMonth);

	
 	
    $this->load->view('template_admin/header', $data);
    $this->load->view('template_admin/sidebar');
    $this->load->view('admin/absensi/detail', $data);
    $this->load->view('template_admin/footer');
}

}
