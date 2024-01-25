<!DOCTYPE html>
<html>

<head>
	<title><?php echo $title ?></title>
	<style type="text/css">
		body {
			font-family: Arial;
			color: black;
		}
	</style>
</head>

<body>
	<center>
		<h1>PT. BAGUS BERJAYA</h1>
		<h2>Daftar Gaji Pegawai</h2>
	</center>

	<?php
	if ((isset($_GET['bulan']) && $_GET['bulan'] != '') && (isset($_GET['tahun']) && $_GET['tahun'] != '')) {
		$bulan = $_GET['bulan'];
		$tahun = $_GET['tahun'];
		$bulantahun = $bulan . $tahun;
	} else {
		$bulan = date('m');
		$tahun = date('Y');
		$bulantahun = $bulan . $tahun;
	}
	?>
	<table>
		<tr>
			<td>Bulan</td>
			<td>:</td>
			<td><?php echo $bulan ?></td>
		</tr>
		<tr>
			<td>Tahunn</td>
			<td>:</td>
			<td><?php echo $tahun ?></td>
		</tr>
	</table>
	<table class="table table-bordered table-triped">
	<tr>
				        <th class="text-center" rowspan="2">No</th>
						<th class="text-center" rowspan="2">NIK</th>
						<th class="text-center" rowspan="2">Nama Pegawai</th>
						<!-- <th class="text-center" rowspan="2">Jenis Kelamin</th> -->
						<th class="text-center" rowspan="2">Jabatan</th>
						<th class="text-center" rowspan="2">GajI Pokok</th>
						<th class="text-center" rowspan="2">Tj. Transport</th>
						<th class="text-center" rowspan="2">Uang Makan</th>
						<th class="text-center" colspan="2">Potongan</th>
						<th class="text-center" rowspan="2">Tambahan [<i>Lembur</i>]</th>
						<th class="text-center" rowspan="2">Total Gaji</th>
		           </tr>
		           <tr> 
						<th class="text-center" >[<i>Alpha</i>]</th>
						<th class="text-center" >[<i>Telat</i>]</th> 
		           </tr>
		<?php 
$no = 1;
$uniqueNiks = []; // To track unique "nik" values

foreach ($potongan as $p) : {
    $alpha = $p->jml_potongan;
} ?>
<?php 
foreach ($cetak_gaji as $g) :
    // Check if the "nik" is already displayed
    if (!in_array($g->nik, $uniqueNiks)):
        $total_potongan = 0;
        $total_tambahan = 0;
		$total_potonganTelat=0;
		if($g->telat){
			$total_potonganTelat  = $g->telat * $paramTelat->jml_potongan;
		}
        if ($g->alpha > 0) {
            $total_potongan = $g->alpha * $alpha;
        }
        
        if ($g->lembur > 0) {
            $total_tambahan = $g->lembur * $paramLembur->jml_potongan;
        }
        
        $uniqueNiks[] = $g->nik; // Mark "nik" as displayed
        
        ?>
       <tr>
						<td class="text-center"><?php echo $no++ ?></td>
						<td class="text-center"><?php echo $g->nik ?></td>
						<td class="text-center"><?php echo $g->nama_pegawai ?></td>
						<!-- <td class="text-center"><?php echo $g->jenis_kelamin ?></td> -->
						<td class="text-center"><?php echo $g->nama_jabatan ?></td>
						<td class="text-center">Rp. <?php echo number_format($g->gaji_pokok,0,',','.') ?></td>
						<td class="text-center">Rp. <?php echo number_format($g->tj_transport,0,',','.') ?></td>
						<td class="text-center">Rp. <?php echo number_format($g->uang_makan,0,',','.') ?></td>
						<td class="text-center"><i><?=$g->alpha?>x</i> <br>Rp. <?php echo number_format($total_potongan ,0, ',','.') ?></td>
						<td class="text-center"><i><?=$g->telat?> Jam</i> <br>Rp. <?php echo number_format($total_potonganTelat ,0, ',','.') ?></td>
						<td class="text-center"><i><?=$g->lembur?> jam</i> <br>Rp. <?php echo number_format($total_tambahan ,0, ',','.') ?></td>
						<td class="text-center">Rp. <?php echo number_format($g->gaji_pokok + $g->tj_transport + $g->uang_makan - $total_potongan + $total_tambahan+$total_potonganTelat ,0,',','.') ?></td>
					</tr> 
    <?php endif; ?>
<?php endforeach; ?>
<?php endforeach; ?>
</table>

	<table width="100%">
		<tr>
			<td></td>
			<td width="200px">
				<p>Tegal, <?php echo date("d M Y") ?> <br> Finance</p>
				<br>
				<br>
				<p>_____________________</p>
			</td>
		</tr>
	</table>
</body>

</html>

<script type="text/javascript">
	window.print();
</script>