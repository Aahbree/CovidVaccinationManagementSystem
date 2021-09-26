<!DOCTYPE html>
<html>
<head>
	<title>COVID Vaccination</title>
</head>
<body>
<?php

// Include config file
require_once "DBConnect.php";
include 'layout/header1.php'; 
include 'layout/nav.php'; 
?>

<div class="card-1" >
        <div class="card-body">
			<img class="img-fluid" src="assets/vaccine.png" width="200px">
            <h1 class="card-title">Welcome to<br> Covid-19 Vaccination Management System</h1>
            <h4 class="card-text">One Stop for COVID Vaccination</h4>
         
            
            <a href="alogin.php" class="btn btn-primary" style="margin-bottom:3%">Book an appointment</a>
        
         
            <a href="plogin.php" class="btn btn-primary" style="margin-bottom:3%" >Vaccine Provider</a>
          
        </div>
    </div>
</body>
</html>
<?php
 include 'layout/footer2.php'
?>