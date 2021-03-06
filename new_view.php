<html>
<body>
<br>

<title>Confirmed Appointment<br></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/googlemap.js"></script>
<center>
<h1>Confirmed Appointments</h1>
</center>
<center>

<?php
include 'dbconnect.php';
include 'layout/nav2.php';
//TODO session doe provider id value : TBU
// zero appointments case : DONE 
// change asssigned
$patientid = $_SESSION["id"];

function display_function(&$a,&$b,&$c,&$d,&$e)
{
  echo '<tr>
  <style>
  table {

    border-collapse: collapse;
    width: 90%;
    margin : auto;

  }
  td{
    text-align: center; 
    background-color: lightblue; 
    padding: 10px;
  }
  </style>
  <table>
  <tr>
  <td>   <b>Apointment id </td>
  <td>   <b>Provider Name </td> 
  <td>   <b>Provider Address </td> 
  <td>   <b>Apointment Date</td> 
  <td>   <b>Status</td> 
  <br>
  </tr>
  <tr>
  <td>'.htmlspecialchars($a).'</td>
  <td> '.htmlspecialchars($b).'</td>
  <td> '.htmlspecialchars($c).'</td>
  <td>'.htmlspecialchars($d).'</td> 
  <td>'.htmlspecialchars($e).'</td> 
  </tr>
  </table>
  </tr>';
}

function display_function2()
{
  echo '
  <br> <br> <form action="patient_confirmed_cancel.php" method="POST" >
    <input  class="col-60" type="submit" name="value" value="Cancel Appointment">
  </form>';
}

$query1 = "SELECT AppointmentOffer.appointmentId as a_id ,
AppointmentOffer.status as a_status,
AppointmentOffer.patientId as patient_id,
AppointmentOffer.providerid as provider_id,
ProviderAppointment.date as a_date,
Provider.providerName as po_name,
Provider.address as po_address,
Provider.city as po_city,
Provider.state as po_state,
Provider.pin as po_pin
FROM AppointmentOffer 
JOIN Provider join ProviderAppointment
WHERE AppointmentOffer.providerid = Provider.providerId 
and patientid = ? 
and AppointmentOffer.appointmentId = ProviderAppointment.appointmentId and AppointmentOffer.status = 'confirmed' ";
  $stmt = $conn->prepare($query1);
  $stmt->bind_param('i', $patientid);
  $res = $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0)  
  {
    while ($row = $result->fetch_assoc())
    {
    $a_id=$row["a_id"];
    $po_name=$row["po_name"];

    $po_address=$row["po_address"];
    $po_city=$row["po_city"];
    $po_state=$row["po_state"];
    $po_pin=$row["po_pin"];
    $po_address_full= $po_address.''.$po_city." ".$po_state." ".$po_pin;

    $a_date=$row["a_date"];
    $a_status=$row["a_status"];
	  $_SESSION["aid"] = $a_id;
    display_function($a_id,$po_name,$po_address_full,$a_date,$a_status);
    }
    display_function2();
  } 
  else
  {
    echo '<p color:red;> <b><h2>'."Please confirm your apointments in book appointments page".'</p></b></h2>';
  }



mysqli_close($conn);
?>
<br>
<style>
.col-60 {
  float: center;
  margin: auto;
  margin-bottom: 0px;
  background-color: #0e8c16;
  border: none;
  color: white;
  padding: 10px 10px;
  text-decoration: none;
  margin: 4px 2px;
  cursor: pointer;
  width: 15%;
  font-size: 20px;

}
.col-65 {
  float: center;
  margin: auto;
  margin-bottom: 0px;
  border: none;
  color: blue;
  padding: 10px 10px;
  text-decoration: none;
  margin: 4px 2px;
  cursor: pointer;
  width: 15%;
  font-size: 20px;
}
</style>
<style type="text/css">
		.container {
			height: 450px;
		}
		#map {
			width: 100%;
			height: 100%;
			border: 1px solid blue;
		}
		#data, #allData {
			display: none;
		}
</style>
<div class="container">
		<center><h1>Access Google Maps API in PHP</h1></center>
		<div id="map"></div>
	</div>

<div class="col-65">
  <u><a class="btn btn-primary" onclick="history.back()"> Back Page </a></u>
</div>
</center>

</body>
<script>
function loadMap() {
	var pune = {lat: 40.632823, lng: -74.027552};
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
      center: pune
    });

    var marker = new google.maps.Marker({
      position: pune,
      map: map
    });
}
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=GAPIKey&callback=loadMap">
</script>
</html>

