<html>
<body>>

<center>
<h2><br>Thankyou for information</h2>
</center>
<center>

<?php
include 'dbconnect.php';
include 'layout/nav2.php';
//TODO session doe provider id value : TBU
// zero appointments case : DONE 
$a_id = $_SESSION["aid"];

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$today_date = date("Y/m/d");
if (isset($_POST['Accept']))
	
{ 
$status="Accepted";
$query1 = "UPDATE AppointmentOffer
SET
AppointmentOffer.status = '$status',
AppointmentOffer.replydt='$today_date'
WHERE AppointmentOffer.appointmentId = ? ";

 $stmt = $conn->prepare($query1);
  $stmt->bind_param('i', $a_id);
  $res = $stmt->execute();
  $result = $stmt->get_result();
}
if (isset($_POST['Decline'])) 
{ $status="Declined";
$query1 = "UPDATE AppointmentOffer
SET
AppointmentOffer.status = '$status',
AppointmentOffer.replydt='$today_date'
WHERE AppointmentOffer.appointmentId = ? ";

 $stmt = $conn->prepare($query1);
  $stmt->bind_param('i', $a_id);
  $res = $stmt->execute();
  $result = $stmt->get_result();

$query2 = "UPDATE ProviderAppointment
SET
ProviderAppointment.isAvailable = 1
WHERE ProviderAppointment.appointmentId = ".$a_id;
$result = $conn->query($query2);
}
?>
</body>
</html>