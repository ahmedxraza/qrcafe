<?php
// Include the session management file
include "../partials/Admin-Session.php";

// Include the database connection
include "../partials/_dbconnect.php";

// Check if the form is submitted
$login = false;
$showErr = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Collect form data
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $password = $_POST["password"]; // Don't hash here if you already store hashed passwords.

  // Fetch admin record by email only
  $sql = "SELECT * FROM admin WHERE AdminEmail = '$email'";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  
  if ($num == 1) {
      $row = mysqli_fetch_assoc($result);

      // Now, verify the plain text password with the hashed password from the database
      if (password_verify($password, $row['AdminPassword'])) {
          adminLogin($row['AdminName']);  // Pass AdminName into the session if needed
          header("location: ./Admin-Dashboard.php");
          exit;
      } else {
          $showErr = "Invalid Credentials";
      }
  } else {
      $showErr = "Invalid Credentials";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/Admin-Login.css" />
    <title>Admin Login</title>
  </head>
  <body>
    <div class="navbar">
      <h1 class="heading">QR Cafe Admin Panel</h1>
    </div>

    <div class="admin-info">
      <form action="Admin-Login.php" method="POST">
        <div class="input">
          <h2>Admin Log-in</h2>
          <br />
        </div>


        <!-- Email -->
        <label>Email</label><br />
        <input type="email" name="email" />

        <!-- Password -->
        <label>Password</label><br />
        <input type="password" name="password" /><br />

        <p class="error1">*Please Enter Username</p>
        <p class="error2">*Please Enter Email</p>
        <p class="error3">*Please Enter Password</p>

        <!-- Submit Button -->
        <input type="submit" value="Login" />
      </form>
      <?php 
        if ($showErr) {
            echo '<small style="color:red;">*' . $showErr . '</small>';
        }
      ?>
    </div>
    <script>
        document
        .querySelector("form")
        .addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent form submission

            let email = document
                .querySelector("input[name='email']")
                .value.trim();
            let password = document
                .querySelector("input[name='password']")
                .value.trim();

            // Hide all error messages first (only error2 and error3 exist now)
            document.querySelector(".error2").style.display = "none";
            document.querySelector(".error3").style.display = "none";

            // Show the first unfilled error message
            if (email === "") {
                document.querySelector(".error2").style.display = "block";
            } else if (password === "") {
                document.querySelector(".error3").style.display = "block";
            } else {
                this.submit(); // Submit the form if all fields are filled
            }
        });
</script>

  </body>
</html>  