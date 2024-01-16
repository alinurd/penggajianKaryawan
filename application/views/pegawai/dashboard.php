<!-- Begin Page Content -->

<?php

$lemburTxt="Lembur?";

	if($presensi){
		$pt=$presensi->tanggal;
		$pw=$presensi->waktu;
		$ptp=$presensi->tanggal_pulang;
		$ptw=$presensi->waktu_pulang;
	if($presensi->status_absen==1){
		$lembur="disabled";
		$sts="Masuk";
		$absesnTxt="Absen Pulang";
		$absenDis="";
		$ptp="-";
		$ptw="-";
	}elseif($presensi->status_absen==2){
		$absenDis="disabled";
		$absesnTxt="Sudah Pulang";
		$lembur="";
		$sts="Pulang";
		if($dataLembur){
			if($dataLembur->status_lembur==1){
				// var_dump($lembur->id);
				$lemburTxt="Selesai Lembur?";
				$sts="Sedang Lembur";
			}elseif($dataLembur->status_lembur==2){
					$lembur="disabled";

			$lemburTxt="Sudah Lembur";
				$sts="Pulang & Selesai Lembur";
			}
		}
		
	}
}else{
		$pt="-";
		$pw="-";
		$ptp="-";
		$ptw="-";
	$lembur="disabled";
	$absenDis="";
	$lembur="hide";
	$sts="Belum Absen";
	$absesnTxt="Absen sekarang";
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

	<div  style="width: 2px">
	</div>

	<div class="card" style="margin-bottom: 120px; width: 30%">
		<div class="card-header text-center font-weight-bold bg-primary text-white">
			Data Absensi
		</div>
			<div class="card-body">
				<center>
				<a class="btn btn-primary <?=$absenDis?>" href="<?php echo base_url('pegawai/presensi') ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span><?=$absesnTxt?></span></a>
				<a class="btn btn-info <?=$lembur?>" href="<?php echo base_url('pegawai/lembur') ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span><?=$lemburTxt?></span></a>
 				</center>
				
				<br><br>

				<div class="row">
					<div>
						<table class="table"> 
							<tr>
								<td>Tanggal Masuk</td>
								<td>:</td>
								<td><?php echo $pt?> <i> <?php echo $pw?></i></td>
							</tr>
							<tr>
								<td>Tanggal Keluar</td>
								<td>:</td>
								<td><?php echo $ptp ?> <i> <?php echo $ptw?></i></td>
							</tr>
							<tr>
								<td>Status</td>
								<td>:</td>
								<td><?=$sts?></td>
							</tr>
						</table>
					</div>
				</div>
			</div> 
	</div>
 
	</div>
	<!-- /.container-fluid -->