<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
	</div>
	<div class="card" style="width: 60% ; margin-bottom: 100px">
		<div class="card-body">
			<form id="register">
				<center>
				<div id="my_camera"></div><br>
				<input type="hidden" name="nik" id="nik" value="<?=$pegawai->nik?>" /><br/>
				<button type="submit" class="btn btn-success">Simpan</button>
				</center>
			</form>


		</div>
	</div>
</div>
<!-- /.container-fluid -->



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script>
<script language="JavaScript">
	Webcam.set({
		width: 320,
		height: 240,
		image_format: 'jpeg',
		jpeg_quality: 90
	});
	Webcam.attach('#my_camera');
</script>
<!-- Code to handle taking the snapshot and displaying it locally -->
<script type="text/javascript">
	$(document).ready(function() {
		$('#register').on('submit', function(event) {
			var nik = $("#nik").val();
			event.preventDefault();
			if (!nik) {
				alert("nik tidak boleh kosong")
				return false
			}
			var image = '';
			Webcam.snap(function(data_uri) {
				image = data_uri;

				// AJAX request
				$.ajax({
					url: '<?php echo site_url("admin/data_pegawai/savefcaeid"); ?>',
					type: 'POST',
					dataType: 'json',
					data: {
						image: image,
						nik: nik,
					},
					success: function(response) {
						console.log(response);
						// console.log(response.success); // Memeriksa respons secara keseluruhan dan properti success
						if (response.success) { // Perhatikan pembandingan dengan false, bukan dengan string "false"
							alert(response.msg);
						} else {
							alert(response.msg);
						}
						window.location.href = '<?= site_url("admin/data_pegawai") ?>';
					},
					error: function(xhr, status, error) {
						alert(error);
						window.location.href = '<?= site_url("admin/data_pegawai") ?>';
					}
				});
			});
		});
	});
</script>