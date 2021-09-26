<html>
<body>>

<center>
<h2><br>Appointment cancelled successful</h2>
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


$choice = $_POST["value"];
echo $choice;

if($choice == "Cancel Appointment")
{
    $status="Cancelled";
    echo $status;

    $today_date = date("Y/m/d");
    echo $today_date;

    $query1 = "UPDATE AppointmentOffer
    SET
    AppointmentOffer.status = '$status',
    AppointmentOffer.replydt='$today_date'
    WHERE AppointmentOffer.appointmentId = ? ";

    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param('i', $a_id);
    $res1 = $stmt1->execute();


    $query2 = "UPDATE ProviderAppointment
    SET ProviderAppointment.isAvailable = true
    WHERE ProviderAppointment.appointmentId = ? ";

    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param('i', $a_id);
    $res2 = $stmt2->execute();

}
else
{
    echo "Go Back to cancel appointment";
}

  mysqli_close($conn);

?>

<div class="col-65">
  <u><a class="btn btn-primary" onclick="history.back()"> Back Page </a></u>
</div>

</body>
</html>

