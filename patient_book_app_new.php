<html>
<body>>

<title>Apointments<br></title>
<center>
<h2><br>Apointments</h2>
</center>
<center>

<?php
include 'dbconnect.php';
//TODO session doe provider id value : TBU
// zero appointments case : DONE 
// change asssigned
$patientid = 2;

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
    background-color: 
    lightblue; border: 
    display: inline-block;
    margin-top:10px;
    padding: 19px;

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
echo'  
<form action="patient_book_update.php" method="POST" >
<input class="col-65" type="submit" name="value" value="Confirm">
<input class="col-65" type="submit" name="value" value="Cancel">
</form>
';
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
and AppointmentOffer.appointmentId = ProviderAppointment.appointmentId and AppointmentOffer.status ='offered' ";
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
    display_function($a_id,$po_name,$po_address_full,$a_date,$a_status);
    }
    display_function2();
  } 
  else
  {
    echo '<p color:red;> <b>'."Apointments not yet aasigned".'</p></b>';
  }



mysqli_close($conn);
?>
<br>
<style>
.col-65 {
  float: center;
  margin: auto;
  margin-bottom: 0px;
  background-color: blue;
  border: none;
  color: white;
  padding: 2px 2px;
  text-decoration: none;
  margin: 4px 2px;
  cursor: pointer;
  width: 8%;
  height: 5%;
  font-size: 15px;
}
.col-60 {
  float: center;
  margin: auto;
  margin-bottom: 0px;
  background-color: green;
  border: none;
  color: white;
  padding: 16px 30px;
  text-decoration: none;
  margin: 4px 2px;
  cursor: pointer;
  width: 8%;
  font-size: 15px;
}
</style>


<div class="col-65">
  <u><a class="btn btn-primary" onclick="history.back()"> Back Page </a></u>
</div>
</center>

</body>
</html>

