<?php
require_once "DBConnect.php";
include 'layout/header1.php';
include 'layout/nav.php';
$err= "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email = $_POST['email'];
  $mypassword = $_POST['password'];
  $sql1 = "SELECT patientId, password as hashedPassword FROM Patient WHERE email = '$email'";
  $stmt1 = $conn->prepare($sql1);
  $stmt1->execute();
  $result = $stmt1->get_result();
 
  if ($result->num_rows > 0) {

    $row = $result->fetch_array(MYSQLI_ASSOC);
	$hashedPassword = $row['hashedPassword'];
    $patientId = $row['patientId'];
	if (password_verify($mypassword, $hashedPassword)) {

      session_start();

      $_SESSION["loggedin"] = true;
      $_SESSION["id"] = $patientId;
      echo "patientId". $_SESSION["id"];
      $_SESSION["email"] = $email;
	  $stmt1->close();
	  header("location: welcome.php"); 
      
    } 
	else 
	{
    
	  $err="Username or password was incorrect!";
    }
  }

}
?>

<body>
  <style type="text/css">
    body {
      font: 14px sans-serif;
    }

    .wrapper {
      width: 350px;
      padding: 20px;
    }
  </style>

  <div class="wrapper container">
    <img class="rounded mx-auto d-block" src="assets/patient.png" width="300" height="170" alt="">
    <h1>Patient Login</h1>
	<p>Please fill in your credentials to login.</p>
	<h5 style="color:red;"><?php echo($err);?></h5>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2, 4}$" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
        Title="password between 8 to 15 characters which contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character" required>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Login">
      </div>
      <p>Don't have an account? <a href="patient_signup_new.php">Sign up now</a>.</p>
    </form>
  </div>
</body>

</html>
<?php
 include 'layout/footer2.php';
?>