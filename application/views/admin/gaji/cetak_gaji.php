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
	<th class="text-center" >No</th>
						<th class="text-center" >NIK</th>
						<th class="text-center" >Nama Pegawai</th>
						<!-- <th class="text-center" >Jenis Kelamin</th> -->
						<th class="text-center" >Jabatan</th>
						<th class="text-center" >Hadir</th>
						<th class="text-center" >Gaji</th>
						<th class="text-center" >Tj. Transport</th>
						<th class="text-center" >Uang Makan</th>
						<th class="text-center" >Potongan [<i>Telat</i>]</th>
						<th class="text-center" >Tambahan [<i>Lembur</i>]</th>
						<th class="text-center" >Total Gaji</th>
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
        
$jumlah_kehadiran = $g->hadir;

$tgl = $countTanggal - 4;

$persentase_kehadiran = ($jumlah_kehadiran / $tgl) * 100;
$persentase_kehadiran_bulat = round($persentase_kehadiran);
$gajiPoko = $g->gaji_pokok * ($persentase_kehadiran / 100);
$uangMakan = $g->uang_makan * ($persentase_kehadiran / 100);
$transport = $g->tj_transport * ($persentase_kehadiran / 100);

        $uniqueNiks[] = $g->nik; // Mark "nik" as displayed
        
        ?>
       <tr>
	   <td class="text-center"><?php echo $no++ ?></td>
						<td class="text-center"><?php echo $g->nik ?></td>
						<td class="text-center"><?php echo $g->nama_pegawai ?></td>
						<td class="text-center" title="Gaji Pokok: Rp <?= number_format($g->gaji_pokok, 2, ',', '.') ?>&#10;Transport: Rp <?= number_format($g->tj_transport, 2, ',', '.') ?>&#10;Uang Makan: Rp <?= number_format($g->uang_makan, 2, ',', '.') ?>"><?php echo $g->nama_jabatan ?></td>

						<td class="text-center" title="[Persentase Kehadiran=(Kehadiran/Jumlah Hari dalam Bulan)*100% ]"><?=$g->hadir?>
						<br>
						<b>[<?php echo $persentase_kehadiran_bulat ?>%  ]</b>   </td>
						<!-- <td class="text-center">15x31hari - 4hari (libur)=100%</td> -->
						<td class="text-right" title="Gaji pokok berdasarkan persentase kehadiran [gaji pokok * persentase khadiran) ]"><span class="">
 							Rp. <br>
							<b> <?php echo number_format($gajiPoko,0,',','.') ?></b> 
							</b>
				</td>
						<td class="text-right">Rp. <br><b><?php echo number_format($transport,0,',','.') ?></b></td>
						<td class="text-right">Rp. <br><b><?php echo number_format($uangMakan,0,',','.') ?></b></td>
						<!-- <td class="text-center"><i><?=$g->alpha?>x</i> <br>Rp. <?php echo number_format($total_potongan ,0, ',','.') ?></td> -->
						<td class="text-center"><i><?=$g->telat?> Jam</i> <br>Rp. <?php echo number_format($total_potonganTelat ,0, ',','.') ?></td>
						<td class="text-center"><i><?=$g->lembur?> jam</i> <br>Rp. <?php echo number_format($total_tambahan ,0, ',','.') ?></td>
						<td class="text-center">Rp. <?php echo number_format($gajiPoko + $transport + $uangMakan + $total_tambahan+$total_potonganTelat ,0,',','.') ?></td>
					</tr> 
    <?php endif; ?>
<?php endforeach; ?>
<?php endforeach; ?>
</table>

	<table width="100%">
		<tr>
			<td></td>
			<td width="200px">
				<p>Jakarta, <?php echo date("d M Y") ?> <br> Finance</p>
				<br>
				<br>
				<p>_____________________</p>
			</td>
		</tr>
	</table>
</body>

</html>

<script type="text/javascript">
	// window.print();
</script>