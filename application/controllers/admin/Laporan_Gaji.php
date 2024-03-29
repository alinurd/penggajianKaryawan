<?php

class Laporan_Gaji extends CI_Controller {

	public function __construct(){
		parent::__construct();

		if($this->session->userdata('hak_akses') != '1'){
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
		$data['title'] = "Laporan Gaji Pegawai";

		$this->load->view('template_admin/header',$data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/gaji/laporan_gaji');
		$this->load->view('template_admin/footer');
	}

	public function cetak_laporan_gaji(){

	$data['title'] = "Cetak Laporan Gaji Pegawai";
		if((isset($_GET['bulan']) && $_GET['bulan']!='') && (isset($_GET['tahun']) && $_GET['tahun']!='')){
			$bulan = $_GET['bulan'];
			$tahun = $_GET['tahun'];
			$bulantahun = $bulan.$tahun;
		}else{
			$bulan = date('m');
			$tahun = date('Y');
			$bulantahun = $bulan.$tahun;
		}
		$data['ptn'] = $this->ModelPenggajian->get_data_alpha();
		$data['paramLembur'] = $this->ModelPenggajian->get_data_lembur();
		$data['paramTelat'] = $this->ModelPenggajian->get_data_telat();

		$data['potongan'] = $this->ModelPenggajian->get_data('parameter_gaji')->result();

		
$timezone = new DateTimeZone('Asia/Jakarta');
$currentDateTime = new DateTime('now', $timezone);
$firstDayOfMonth = $currentDateTime->format('Y-m-01');

// Set the month to the specified value
$currentDateTime->setDate($currentDateTime->format($tahun), $bulan, 1);
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




$data['cetak_gaji'] = $this->db->query("SELECT data_pegawai.nik,data_pegawai.nama_pegawai,
data_pegawai.jenis_kelamin,data_jabatan.nama_jabatan,data_jabatan.gaji_pokok,
data_jabatan.tj_transport,data_jabatan.uang_makan,data_kehadiran.alpha,data_kehadiran.lembur,data_kehadiran.telat,data_kehadiran.hadir	 FROM data_pegawai
INNER JOIN data_kehadiran ON data_kehadiran.nik=data_pegawai.nik
INNER JOIN data_jabatan ON data_jabatan.nama_jabatan=data_pegawai.jabatan
WHERE data_kehadiran.bulan='$bulantahun'
ORDER BY data_pegawai.nama_pegawai ASC")->result();

		$this->load->view('template_admin/header', $data);
		$this->load->view('admin/gaji/cetak_gaji', $data);
	}
}

?>