<!DOCTYPE html>
<html>

<head>
	<title>Capture || Codeigniter</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>
<style>
 

#calendar {
    display: inline-block;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    border: 1px solid #dddddd;
    text-align: center;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
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
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <center>
                <h1>Presensi</h1>
                <!-- Tampilan Kalender -->
				
                
                <div id="jam"></div>
                <br>

                <form id="register">
                    <div id="my_camera"></div>
                    <br>
                    <button type="submit" class="btn btn-primary">Absen Sekarang</button>
                    <a class="btn btn-danger" href="<?php echo base_url('pegawai/dashboard') ?>">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Cancel</span>
                    </a>
                </form>
                <br>
                <div id="calendar"></div>
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
document.addEventListener("DOMContentLoaded", function () {
    createCalendar();
    updateTime();
    setInterval(updateTime, 1000); // Update waktu setiap detik
});

function updateTime() {
    const jamContainer = document.getElementById("jam");
    const today = new Date();
    const currentHours = today.getHours();
    const currentMinutes = today.getMinutes();
    const currentSeconds = today.getSeconds();

    jamContainer.innerHTML = `${currentHours}:${currentMinutes < 10 ? '0' : ''}${currentMinutes}:${currentSeconds < 10 ? '0' : ''}${currentSeconds}`;
}

function createCalendar() {
	
    const calendarContainer = document.getElementById("calendar");
    const today = new Date();
    const currentMonth = today.getMonth();
    const currentYear = today.getFullYear();
    const currentDay = today.getDate();

    const monthNames = [
        "January", "February", "March", "April",
        "May", "June", "July", "August",
        "September", "October", "November", "December"
    ];

    const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();

    let tableHTML = "<table><tr><th colspan='7'>" + monthNames[currentMonth] + " " + currentYear + "</th></tr>";
    tableHTML += "<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr><tr>";

    let dayCounter = 1;

    for (let i = 0; i < 42; i++) {
        if (i >= firstDayOfMonth && dayCounter <= daysInMonth) {
            // Menandai hari ini
            const isToday = currentDay === dayCounter && currentMonth === today.getMonth() && currentYear === today.getFullYear();
            tableHTML += "<td" + (isToday ? " class='today'" : "") + ">" + dayCounter + "</td>";
            dayCounter++;
        } else {
            tableHTML += "<td></td>";
        }

        if (i % 7 === 6) {
            tableHTML += "</tr><tr>";
        }
    }

    tableHTML += "</tr></table>";

    calendarContainer.innerHTML = tableHTML;
}

</script>
</body>

</html>