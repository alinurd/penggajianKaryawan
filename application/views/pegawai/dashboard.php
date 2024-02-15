<style>
 

#calendar {
    display: inline-block;
}

 
.today {
    background-color: #4CAF50; /* Warna latar belakang hijau untuk menandai hari ini */
    color: white;
    border-radius: 50%;
}
#jam {
    font-size: 20px;
    color: #333;
    margin-top: 10px;
}
</style>
<?php

$lemburTxt = "Lembur?";
// Set timezone to 'Asia/Jakarta'
date_default_timezone_set('Asia/Jakarta');

// Get current server time
$currentServerTime = date("H:i");

// Set waktu buka absen
$bukaAbsen = "08:00";

// Ubah format waktu buka absen menjadi format yang sesuai untuk pembandingan
$bukaAbsenTimestamp = strtotime($bukaAbsen);

// Ubah waktu server saat ini menjadi format yang sama
$currentServerTimeTimestamp = strtotime($currentServerTime);

$absenHide = " ";
// Bandingkan waktu saat ini dengan waktu buka absen
$absenHideOk = "hidden";
if ($currentServerTimeTimestamp < $bukaAbsenTimestamp) {
    $absenHide = "hidden";
    $absenHideOk = "";
 } 


 
if ($presensi) {
	$pt = $presensi->tanggal;
	$pw = $presensi->waktu;
	$ptp = $presensi->tanggal_pulang;
	$ptw = $presensi->waktu_pulang;
	if ($presensi->status_absen == 1) {
		$lembur = "disabled";
		$sts = "Masuk";
		$absesnTxt = "Absen Pulang";
		$absenDis = "";
		$ptp = "-";
		$ptw = "-";
	} elseif ($presensi->status_absen == 2) {
		$absenDis = "disabled";
		$absesnTxt = "Sudah Pulang";
		$lembur = "";
		$sts = "Pulang";
		if ($dataLembur) {
			if ($dataLembur->status_lembur == 1) {
				// var_dump($lembur->id);
				$lemburTxt = "Selesai Lembur?";
				$sts = "Sedang Lembur";
			} elseif ($dataLembur->status_lembur == 2) {
				$lembur = "disabled";

				$lemburTxt = "Sudah Lembur";
				$sts = "Pulang & Selesai Lembur";
			}
		}
	}
} else {
	$pt = "-";
	$pw = "-";
	$ptp = "-";
	$ptw = "-";
	$lembur = "disabled";
	$absenDis = "";
	$sts = "Belum Absen";
	$absesnTxt = "Absen sekarang";
}

?>

<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
	</div>

	<div class="alert alert-success font-weight-bold mb-4" style="width: 100%">Selamat datang, Anda login sebagai pegawai</div>
	<div class="row">
		<div class="card" style="margin-bottom: 120px; width: 65%">
			<div class="card-header text-center font-weight-bold bg-primary text-white">
				Data Pegawai
			</div>

			<?php foreach ($pegawai as $p) : ?>
				<div class="card-body">
					<div class="row">
						<div>
							<img style="width: 250px" src="<?php echo base_url('photo/' . $p->photo) ?>">
						</div>
						<div>
							<table class="table">
								<tr>
									<td>Nama Pegawai</td>
									<td>:</td>
									<td><?php echo $p->nama_pegawai ?></td>
								</tr>
								<tr>
									<td>Jabatan</td>
									<td>:</td>
									<td><?php echo $p->jabatan ?></td>
								</tr>
								<tr>
									<td>Tanggal Masuk</td>
									<td>:</td>
									<td><?php echo $p->tanggal_masuk ?></td>
								</tr>
								<tr>
									<td>Status</td>
									<td>:</td>
									<td><?php echo $p->status ?></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<div style="width: 2px">
		</div>
		<div class="card" style="margin-bottom: 120px; width: 30%">
			<div class="card-header text-center font-weight-bold bg-primary text-white">
				Data Absensi
			</div>
			<div class="card-body hide" <?= $absenHide ?> >
				<center>
					

					<a id="inputId" class="btn btn-primary  <?= $absenDis ?>" href="<?php echo base_url('pegawai/presensi') ?>">
						<i class="fas fa-fw fa-tachometer-alt"></i>
						<span><?= $absesnTxt ?></span></a>
					<a class="btn btn-info <?= $lembur ?>" href="<?php echo base_url('pegawai/lembur') ?>">
						<i class="fas fa-fw fa-tachometer-alt"></i>
						<span><?= $lemburTxt ?></span></a>
						<br><br><br>
						<input type="date" name="date" id="date" value="<?=$date?$date:""?>"><br> <br>
						<button class="btn btn-warning" id="lihat">lihat berdasrkan tanggal</button>
 				</center>
				<br><br>
				<div class="row">
					<div>
						<table class="table">
							<tr>
								<td>Tanggal Masuk</td>
								<td>:</td>
								<td><?php echo $pt ?> <i> <?php echo $pw ?></i></td>
							</tr>
							<tr>
								<td>Tanggal Keluar</td>
								<td>:</td>
								<td><?php echo $ptp ?> <i> <?php echo $ptw ?></i></td>
							</tr>
							<tr>
								<td>Status</td>
								<td>:</td>
								<td><?= $sts ?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="card-body hide" <?= $absenHideOk ?> >
				 <b>Note: </b><br><i>belum waktunya absen, absen di buka pada pukul 80:00</i>
				 <div id="jam"></div>

			</div>
		</div>
	</div>
	<!-- /.container-fluid -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script>
	<script language="JavaScript">
		    $('#lihat').on('click', function(event) {
			var date= $("#date").val();
			if(!date){
				alert("tanggal tidka boleh kosong")
			}else{
				window.location.href = '<?= site_url("pegawai/dashboard?date=") ?>' + date;

			}
 			});
		// JavaScript untuk menangani penonaktifan dinamis berdasarkan waktu server
		window.onload = function() {
			// Mendapatkan waktu saat ini pada format yang sesuai ("HH:mm")
			var currentTime = new Date().toLocaleTimeString('en-US', {
				hour12: false,
				hour: '2-digit',
				minute: '2-digit'
			});

			// Mendapatkan elemen input berdasarkan ID (ganti 'inputId' dengan ID yang sebenarnya)
			var inputElement = document.getElementById('inputId');

			// Menentukan waktu batas untuk keterlambatan (08:15)
			var lateLimitTime = '08:15';

			// Menonaktifkan input jika waktu saat ini melebihi batas keterlambatan
			if (currentTime > lateLimitTime) {
				inputElement.disabled = true;
			}
		};

	</script>