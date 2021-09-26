<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
include 'dbconnect.php';
include 'layout/header1.php';
include 'layout/navp.php';

$providerid = $_SESSION["pid"];
$providername = "";

$query = "SELECT * FROM Provider WHERE providerId = $providerid";
if (($result = $conn->query($query))&&($result->num_rows > 0)) 
{
    while ($row = $result->fetch_assoc()) 
    {
        $providername = $row["providerName"];
    }
}
else
{
        echo'<h1>'."ID not found ".'<h1/>';
}
?>

<div class="card-1" >
        <div class="card-body">
			<h1 class="card-title">Covid-19 Vaccination Management System</h1>
            <h4 class="card-text">Welcome <?php echo htmlspecialchars($providername);?></h4>
         
            
            <a href="schedules_provider.html" class="btn btn-primary" style="margin-bottom:3%">Upload Appointment</a>
        
            <a href="viewAppointment.php" class="btn btn-primary" style="margin-bottom:3%">View Accepted Appointments</a>
			
			<a href="viewCancelledAppointment.php" class="btn btn-primary" style="margin-bottom:3%">View Cancelled Appointments</a>

                     
        </div>
    </div>

</body>
</html>









