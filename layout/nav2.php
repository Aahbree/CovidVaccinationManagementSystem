<?php
include "DBConnect.php";
// Initialize the session
session_start();
//echo "nav".$_SESSION['id'];

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: index.php");
  exit;
}
?>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="welcome.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="updatePatientDetails.html">Update Profile</a>
                    </li>
					
					<li class="nav-item">
                        <a class="nav-link" href="updatePreference.html">Update Preference</a>
                    </li>
                    
					<li class="nav-item">
                        <a class="nav-link" href="updatePassword.html">Update Password</a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link" href="logout.php" >Logout</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>