<?php 
include "layout/header.php" ;
include 'layout/nav.php';

?>

<body>
	<img class="rounded mx-auto d-block" src="assets/logo.png">
<div class="jumbotron text-center">
  <h1 class="display-3">Thank You! <b><?php echo $_COOKIE["user"]; ?></b></h1>
  <p class="lead"><strong>Please try logging in after some time.</strong> </p>
  <hr>
  <p>
    Having trouble? <a href="contact.php">Contact us</a>
  </p>
  <p class="lead">
    <a class="btn btn-primary btn-sm" href="index.php" role="button">Continue to homepage</a>
  </p>
</div>

<?php 
    
include "layout/footer1.php";
?>