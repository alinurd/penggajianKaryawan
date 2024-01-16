<!DOCTYPE html>
<html>

<head>
	<title>Capture || Codeigniter</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<center>
					<h1>Presensi</h1>

					<form id="register">
						<div id="my_camera">
						</div>
						<br>
						<button type="submit" class="btn btn-primary">Absen Sekarang</button>
						<a class="btn btn-danger" href="<?php echo base_url('pegawai/dashboard') ?>">
							<i class="fas fa-fw fa-tachometer-alt"></i>
							<span>Censel</span></a>
					</form>
				</center>
			</div>
		</div>
	</div>

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
        event.preventDefault();
        var image = '';
        Webcam.snap(function(data_uri) {
            image = data_uri;

            // AJAX request
            $.ajax({
                url: '<?php echo site_url("pegawai/presensi/save"); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    image: image
                    // Include other data properties if needed, e.g., property_name: property_value
                },
                success: function(response) {
        
                },
                error: function(xhr, status, error) {
					alert('Insert data sukses');
                    window.location.href = '<?= site_url("pegawai/dashboard") ?>';
                }
            });
        });
    });
});
</script>
</body>

</html>