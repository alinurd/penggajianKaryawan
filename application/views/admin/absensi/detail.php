<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <!-- <h1 class="h3 mb-0 text-gray-800"><?php echo $title?></h1> -->
  </div>

  <div class="card mb-3">
  <div class="card-header bg-primary text-white">
  <?php echo $title?>  </div>
  
  <div class="card-body">
  <!-- <form class="form-inline"> -->
	  <div class="form-group mb-2">
	    <label for="staticEmail2">Bulan</label>
	     

	 <select class="form-control ml-3" name="bulan" onchange="redirectToDetailAbsen(this)" data-pegawai=<?=$nik?> data-nik="<?=$nik?>">
    <option value="">Pilih Bulan</option>
    <option value="1">Januari</option>
    <option value="2">Februari</option>
    <option value="3">Maret</option>
    <option value="4">April</option>
    <option value="5">Mei</option>
    <option value="6">Juni</option>
    <option value="7">Juli</option>
    <option value="8">Agustus</option>
    <option value="9">September</option>
    <option value="10">Oktober</option>
    <option value="11">November</option>
    <option value="12">Desember</option>
</select>
<br><br>
	 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="1">
    <thead class="thead-dark">
        <tr>
            <th class="text-center" rowspan="2">No</th>
            <th class="text-center" rowspan="2">Tanggal</th>
             <th class="text-center" colspan="3">Abseni</th>
            <th class="text-center" colspan="3">Lembur</th>
        </tr>
        <tr>
            <th class="text-center">Keterangan</th>
            <th class="text-center">Masuk</th>
            <th class="text-center">Pulang</th>
            <th class="text-center">Keterangan</th>
            <th class="text-center">Masuk</th>
            <th class="text-center">Pulang</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tanggal as $index => $tgl) : ?>
            <tr>
                <td class="text-center"><?= $index + 1 ?></td>
                <td class="text-center"><?= $tgl ?></td>
                <?php
                $kehadiranPresent = false;
                $lemburPresent = false;

                foreach ($data as $index => $kehadiran) {
                    if ($tgl == $kehadiran->p_tanggal) {
                        $kehadiranPresent = true;
                        break;
                    }
                }

                foreach ($data as $index => $lembur) {
					if ($tgl == $lembur->l_tanggal) {
						// var_dump($lembur->l_tanggal);
                        $lemburPresent = true;
                        break;
                    }
                }
                ?>
                <td class="text-center"><?= $kehadiranPresent ? "Masuk" : "Tanpa Keterangan" ?></td>
                <td class="text-center"><?= $kehadiranPresent ? $kehadiran->p_waktu : "-" ?></td>
                <td class="text-center"><?= $kehadiranPresent ? $kehadiran->p_waktu_pulang : "-" ?></td>
                <td class="text-center"><?= $lemburPresent ? "Lembur" : "Tanpa Keterangan" ?></td>
                <td class="text-center"><?= $lemburPresent ? $kehadiran->l_waktu : "-" ?></td>
                <td class="text-center"><?= $lemburPresent ? $kehadiran->l_waktu_pulang : "-" ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

  </div>
</div> 

<script>
            function redirectToDetailAbsen(select) {
                var selectedMonth = select.value;
                if (selectedMonth !== "") {
                    var nik = <?php echo strval($nik) ; ?>;
                    var pegawai = select.getAttribute('data-nik');
					console.log(pegawai)
                    window.location.href = "<?php echo base_url('admin/data_absensi/detailAbsen/') ?>" + nik + '/' + selectedMonth;
                }
            }
        </script>