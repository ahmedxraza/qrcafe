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
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // SQL query to fetch the admin record with the given username and email
    $sql = "SELECT * FROM admin WHERE AdminName = '$username' AND AdminEmail = '$email'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    
    if ($num == 1) {
        // Fetch the user data
        $row = mysqli_fetch_assoc($result);
        
        // Verify the password with password_verify
        if (password_verify($password, $row['AdminPassword'])) {
            // Password is correct, set session variables in Admin-Session.php
            adminLogin($username);
            header("location: ./Admin-Dashboard.php"); // Redirect to the admin panel
            exit;
        } else {
            // Incorrect password
            $showErr = "Invalid Credentials";
        }
    } else {
        // Username or email does not exist
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
        <!-- Username -->
        <label>Username</label> <br />
        <input type="text" name="username" />

        <!-- Email -->
        <label>Email</label><br />
        <input type="email" name="email" />

        <!-- Password -->
        <label>Password</label><br />
        <input type="password" name="password" /><br />

        <p class="error1">*Please Enter Username</p>
        <p class="error2">*PLease Enter Email</p>
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

          let username = document
            .querySelector("input[name='username']")
            .value.trim();
          let email = document
            .querySelector("input[name='email']")
            .value.trim();
          let password = document
            .querySelector("input[name='password']")
            .value.trim();

          // Hide all error messages first
          document.querySelector(".error1").style.display = "none";
          document.querySelector(".error2").style.display = "none";
          document.querySelector(".error3").style.display = "none";

          // Show the first unfilled error message
          if (username === "") {
            document.querySelector(".error1").style.display = "block";
          } else if (email === "") {
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