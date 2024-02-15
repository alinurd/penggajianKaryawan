<?php

class Presensi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ModelPresensi');

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
		$data['presensi'] = $this->ModelPresensi->get_data();
		$id = $this->session->userdata('id_pegawai');
		$data['pegawai'] = $this->db->query("SELECT * FROM data_pegawai WHERE id_pegawai='$id'")->result();

		$this->load->view('template_pegawai/header', $data);
		$this->load->view('template_pegawai/sidebar');
		$this->load->view('pegawai/presensi', $data);
		$this->load->view('template_pegawai/footer');
	}
	public function save()
	{
		date_default_timezone_set('Asia/Jakarta');

		$id_pegawai = $this->session->userdata('id_pegawai');
		$nik=$this->session->userdata('nik');

		// $getPresensi = $this->ModelPresensi->get_data();


		$image = $this->input->post('image');
		$tanggal = $this->input->post('tanggal');
		
		$this->db->where("nik", $nik);
		$this->db->where("tanggal", $tanggal);
		$getPresensi = $this->db->get("presensi")->row();
		
		
		// var_dump($tanggal);
		// var_dump($nik);
		// var_dump($getPresensi);


		$image = str_replace('data:image/jpeg;base64,', '', $image);
		$image = base64_decode($image);
		$filename = 'image_' . time() . '.jpg';  // Adjust the file extension if needed
		$filepath = FCPATH . 'presensi/' . $filename;

		// Make sure the directory exists, create it if not
		if (!is_dir(FCPATH . 'presensi/')) {
			mkdir(FCPATH . 'presensi/');
		}

		// Save the image to the specified path
		if (file_put_contents($filepath, $image) !== false) {
			// echo 'Image uploaded successfully.';
		} else {
			// echo 'Failed to upload the image.';
		}
		$date = date("H:i");





		$image1_path = FCPATH . 'presensiDaftar/'.$nik.".jpg";
		// $filename	 = './Path/To/Your/File.zip';
		// $image1_path = 'path_to_image1.jpg';
		// $image2_path = 'path_to_image2.jpg';

		$image1 = imagecreatefromjpeg($image1_path);
		$image2 = imagecreatefromjpeg($filepath);

		$image1_width = imagesx($image1);
		$image1_height = imagesy($image1);
		$image2_width = imagesx($image2);
		$image2_height = imagesy($image2);

		$width = min($image1_width, $image2_width);
		$height = min($image1_height, $image2_height);

		$image1_resized = imagescale($image1, $width, $height);
		$image2_resized = imagescale($image2, $width, $height);

		// Calculate the Mean Squared Error (MSE)
		$sum_squared_diff = 0;
		for ($x = 0; $x < $width; $x++) {
			for ($y = 0; $y < $height; $y++) {
				$pixel1 = imagecolorat($image1_resized, $x, $y);
				$pixel2 = imagecolorat($image2_resized, $x, $y);

				$r1 = ($pixel1 >> 16) & 0xFF;
				$g1 = ($pixel1 >> 8) & 0xFF;
				$b1 = $pixel1 & 0xFF;

				$r2 = ($pixel2 >> 16) & 0xFF;
				$g2 = ($pixel2 >> 8) & 0xFF;
				$b2 = $pixel2 & 0xFF;

				$sum_squared_diff += pow($r1 - $r2, 2) + pow($g1 - $g2, 2) + pow($b1 - $b2, 2);
			}
		}

		$mse = $sum_squared_diff / ($width * $height);

		$max_intensity = 255;
		$ssi = (1 - $mse / pow($max_intensity, 2));

		// echo "mse: " . $mse;
		// echo "ssi: " . $ssi;
		// echo "Similarity Index: " . round($ssi, 5);

		// imagedestroy($image1);
		// imagedestroy($image2);
		// imagedestroy($image1_resized);
		// imagedestroy($image2_resized);


		if ($ssi > 0.800000) {
			if($getPresensi){
				if ($getPresensi->status_absen == 1 ) {

					$status_absen = 2; // 1=> masuk | 2=> pulang
					$data = array(
						'tanggal_pulang' => $tanggal,
						'waktu_pulang' => date("H:i:s"),
						'status_absen' => $status_absen,
						'image_pulang' => $filename,
					);
					$whare = [
						"id" => $getPresensi->id
					];
					$res = $this->ModelPresensi->update_data("presensi", $data, $whare);
					$this->ModelPresensi->updateRekapAbsen($nik, 0); 
				$sts = true;
				$msg = "absensi berhasil";

				} 
			}else {
				$status_absen = 1; // 1=> masuk | 2=> pulang


				// Waktu sekarang
				$currentTime = date("H:i");

				// Waktu tujuan
				$destinationTime = "08:20";

				// Konversi waktu menjadi format yang dapat dihitung
				$currentTimestamp = strtotime($currentTime);
				$destinationTimestamp = strtotime($destinationTime);

				// Hitung selisih dalam satuan detik
				$diffInSeconds = $destinationTimestamp - $currentTimestamp;

				// Konversi selisih ke jam
				$diffInHours = $diffInSeconds / 3600;
				$roundedHours = round($diffInHours);


				$data = array(
					'tanggal' => $tanggal,
					'waktu' => date("H:i:s"),
					'id_pegawai' => $id_pegawai,
					'status_absen' => $status_absen,
					'image' => $filename,
					'nik' => $nik,
					'telat' => $roundedHours,
				);

				$sts = $this->ModelPresensi->insert_data($data, "presensi");
				$this->ModelPresensi->updateRekapAbsen($nik, $roundedHours);
				$msg = "absensi berhasil";
			}
		} else {
			// $msg = "absensi gagal, foto tidak mirip dengan yang di daftarkan. nilai kemiripan: " . round($ssi, 5);
			$msg = "absensi gagal, FaceId tidak Terdaftar ";
			 $sts=false;
		}

		 
		echo json_encode(array('success' => $sts, 'msg' => $msg));
		}

	public function compare($image2_path)
	{
		// Path gambar pertama (dari server)
		$image1_path = FCPATH . 'presensi/image_1707800648.jpg';
		$image2_path = FCPATH . 'presensi/' . $image2_path;
		// $filename	 = './Path/To/Your/File.zip';
		// $image1_path = 'path_to_image1.jpg';
		// $image2_path = 'path_to_image2.jpg';

		$image1 = imagecreatefromjpeg($image1_path);
		$image2 = imagecreatefromjpeg($image2_path);

		// Get the image dimensions
		$image1_width = imagesx($image1);
		$image1_height = imagesy($image1);
		$image2_width = imagesx($image2);
		$image2_height = imagesy($image2);

		// Resize the images to the same dimensions for comparison (optional)
		$width = min($image1_width, $image2_width);
		$height = min($image1_height, $image2_height);

		$image1_resized = imagescale($image1, $width, $height);
		$image2_resized = imagescale($image2, $width, $height);

		// Calculate the Mean Squared Error (MSE)
		$sum_squared_diff = 0;
		for ($x = 0; $x < $width; $x++) {
			for ($y = 0; $y < $height; $y++) {
				$pixel1 = imagecolorat($image1_resized, $x, $y);
				$pixel2 = imagecolorat($image2_resized, $x, $y);

				$r1 = ($pixel1 >> 16) & 0xFF;
				$g1 = ($pixel1 >> 8) & 0xFF;
				$b1 = $pixel1 & 0xFF;

				$r2 = ($pixel2 >> 16) & 0xFF;
				$g2 = ($pixel2 >> 8) & 0xFF;
				$b2 = $pixel2 & 0xFF;

				$sum_squared_diff += pow($r1 - $r2, 2) + pow($g1 - $g2, 2) + pow($b1 - $b2, 2);
			}
		}

		$mse = $sum_squared_diff / ($width * $height);

		// Calculate the Structural Similarity Index (SSI)
		$max_intensity = 255;
		$ssi = (1 - $mse / pow($max_intensity, 2));

		// Output the similarity index
		echo "Similarity Index: " . round($ssi, 4);

		// Free up memory
		imagedestroy($image1);
		imagedestroy($image2);
		imagedestroy($image1_resized);
		imagedestroy($image2_resized);
	}
}
