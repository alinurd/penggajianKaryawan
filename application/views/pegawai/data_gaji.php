<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
	</div>

	<table class="table table-striped table-bordered">
		<tr>
			<!-- <th>Bulan/Tahun</th> -->
			<th>Gaji Pokok</th>
			<th>Tunjangan Transportasi</th>
			<th>Uang Makan</th>
			<!-- <th>Potongan</th> -->
			<th>Total Gaji</th>
			<!-- <th>Cetak Slip</th> -->
		</tr>
		<?php foreach ($potongan as $p) : ?>
			<?php $potongan = $p->jml_potongan; ?>
		<?php endforeach; ?>

		<?php foreach ($gaji as $g) : ?>
			<?php $pot_gaji = $g->alpha * $potongan;
			// var_dump($g)
			?>
			<tr>
				<!-- <td><?php echo $g->bulan ?></td> -->
				<td>Rp. <?php echo number_format($g->gaji_pokok, 0, ',', '.') ?></td>
				<td>Rp. <?php echo number_format($g->tj_transport, 0, ',', '.') ?></td>
				<td>Rp. <?php echo number_format($g->uang_makan, 0, ',', '.') ?></td>
				<!-- <td>Rp. <?php echo number_format($pot_gaji, 0, ',', '.') ?></td> -->
				<td>Rp. <?php echo number_format($g->gaji_pokok + $g->tj_transport + $g->uang_makan, 0, ',', '.') ?></td>
				<!-- <td>
  			<center>
  				<a class="btn btn-sm btn-primary" href="<?php echo base_url('pegawai/data_gaji/cetak_slip/' . $g->id_kehadiran) ?>"><i class="fas fa-print"></i></a>
  			</center> -->
				</td>
			</tr>
		<?php endforeach; ?>
		<!-- <tr>
			<th colspan="7" class="">Per 100% kehadiran</th>
		</tr> -->

	</table>

<br><br>	

	<?php foreach ($print_slip as $ps) : ?>

		<?php
		$potongan_gaji = $ps->alpha * $potongan;
		$total_tambahan = $ps->lembur * $paramLembur->jml_potongan;
		$potonagn_telat = $ps->telat * $paramTelat->jml_potongan;

		$jumlah_kehadiran = $ps->hadir;

		$tgl = $countTanggal - 4;

		$persentase_kehadiran = ($jumlah_kehadiran / $tgl) * 100;
		$persentase_kehadiran_bulat = round($persentase_kehadiran);
		$gajiPoko = $ps->gaji_pokok * ($persentase_kehadiran / 100);
		$uangMakan = $ps->uang_makan * ($persentase_kehadiran / 100);
		$transport = $ps->tj_transport * ($persentase_kehadiran / 100);



		?>

		<table class="table table-striped table-bordered mt-3">
			<tr>
				<span>Pendapatan Berdasrkan Persetase Kehadiran</span>
				<th class="text-center" width="5%">No</th>
				<th class="text-center">Keterangan</th>
				<th class="text-center">Jumlah</th>
			</tr>
			<tr>
				<td>1</td>
				<td>Gaji Pokok</td>
				<td>Rp. <?php echo number_format($gajiPoko, 0, ',', '.') ?></td>
			</tr>

			<tr>
				<td>2</td>
				<td>Tunjangan Transportasi</td>
				<td>Rp. <?php echo number_format($transport, 0, ',', '.') ?></td>
			</tr>

			<tr>
				<td>3</td>
				<td>Uang Makan</td>
				<td>Rp. <?php echo number_format($uangMakan, 0, ',', '.') ?></td>
			</tr>

			<tr>
				<td >4</td>
				<td>jumlah kehadiran: <?= $jumlah_kehadiran ?> [ persentas: <?= $persentase_kehadiran_bulat ?>% ]</td>
				<td>Rp. <?php echo number_format($potongan_gaji, 0, ',', '.') ?></td>
			</tr>
			<tr>
				<td >5</td>
				<td>Potongan Telat [<?= $ps->telat ?> jam]</td>
				<td>Rp. <?php echo number_format($potonagn_telat, 0, ',', '.') ?></td>
			</tr>
			<tr>
				<td>6</td>
				<td>Tambahan [<?= $ps->lembur ?> jam]</td>
				<td>Rp. <?php echo number_format($total_tambahan, 0, ',', '.') ?></td>
			</tr>

			<tr>
				<th colspan="2" style="text-align: right;">Total Gaji : </th>
				<th>Rp. <?php echo number_format($gajiPoko + $transport + $uangMakan + $total_tambahan + $potonagn_telat, 0, ',', '.') ?></th>
			</tr>
		</table>



	<?php endforeach; ?>


	</table>

</div>
<!-- /.container-fluid -->