<?php
// Include the database connection
include "../partials/_dbconnect.php";

// Initialize variables for error handling
$showErr = false;
$signupSuccess = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $adminName = $_POST["adminName"];
    $adminEmail = $_POST["adminEmail"];
    $adminPassword = $_POST["adminPassword"];
    $adminConfirmPassword = $_POST["adminConfirmPassword"];

    // Check if passwords match
    if ($adminPassword != $adminConfirmPassword) {
        $showErr = "Passwords do not match.";
    } else {
        // Hash the password before storing
        $hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

        // Check if email already exists
        $sqlCheck = "SELECT * FROM admin WHERE AdminEmail = '$adminEmail'";
        $resultCheck = mysqli_query($conn, $sqlCheck);

        if (mysqli_num_rows($resultCheck) > 0) {
            $showErr = "Email already exists. Please use a different one.";
        } else {
            // SQL query to insert the new admin into the database
            $sqlInsert = "INSERT INTO admin (AdminName, AdminEmail, AdminPassword) VALUES ('$adminName', '$adminEmail', '$hashedPassword')";

            // Execute the query and check if the insert was successful
            if (mysqli_query($conn, $sqlInsert)) {
                $signupSuccess = true;  // Set success flag
            } else {
                $showErr = "Error while signing up. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/Admin-Login.css" />
    <title>Admin Signup</title>
  </head>
  <body>
    <div class="navbar">
      <h1>QR Cafe Admin Panel</h1>
    </div>

    <div class="admin-info">
      <form action="" method="POST">
        <div class="input">
          <h2>Admin Signup</h2>
          <br />
        </div>

        <!-- Admin Name -->
        <label>Admin Name</label><br />
        <input type="text" name="adminName" required /><br />

        <!-- Admin Email -->
        <label>Email</label><br />
        <input type="email" name="adminEmail" required /><br />

        <!-- Admin Password -->
        <label>Password</label><br />
        <input type="password" name="adminPassword" required /><br />

        <!-- Confirm Password -->
        <label>Confirm Password</label><br />
        <input type="password" name="adminConfirmPassword" required /><br />

        <!-- Submit Button -->
        <input type="submit" value="Sign Up" />
      </form>

      <?php 
        // Show error message if any
        if ($showErr) {
            echo '<p style="color:red;">*' . $showErr . '</p>';
        }
        // Show success message if signup was successful
        if ($signupSuccess) {
            echo '<p style="color:green;">* Signup successful! You can now log in.</p>';
        }
      ?>
      <a class="redirect" href="./Admin-Login.php">Already Have an Account?</a>
    </div>
  </body>
</html>
