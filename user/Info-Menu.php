<?php
// Include database connection file
require_once '../partials/_dbconnect.php';
session_start();  // Start session at top (needed for later)

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderType = $_POST['orderType'] ?? '';
    $tableORsitting = $_POST['table'] ?? '';
    $fullName = $_POST['fullname'] ?? '';
    $mobileNo = $_POST['mobile'] ?? '';
    $email = $_POST['email'] ?? '';

    // Basic PHP validation (backend safety)
    if (empty($orderType) || empty($tableORsitting) || empty($fullName) || empty($mobileNo) || empty($email)) {
        die("All fields are required. Please fill the form properly.");
    }

    // SQL query
    $sql = "INSERT INTO `user` (`fullName`, `email`, `mobileNo`, `tableORsitting`, `orderType`) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $fullName, $email, $mobileNo, $tableORsitting, $orderType);

        if (mysqli_stmt_execute($stmt)) {
            $userID = mysqli_insert_id($conn);
            $_SESSION['userID'] = $userID;
            $_SESSION['fullname'] = $fullName; // ADD THIS
        
            header("Location: ./Main-Menu.php");
            exit();
        }else {
            die("Error executing query: " . mysqli_error($conn));
        }
    } else {
        die("Error preparing statement: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/info-menu.css">
    <title>Details Page</title>
</head>
<body>
    <h2 class="H-Q">QR CAFE</h2>

    <div class="user-info">
        <form action="./Info-Menu.php" method="POST" onsubmit="return validateForm()">
            <p class="H-1">Select An Option...</p>

            <input type="radio" id="dinein" name="orderType" value="Dine-In" onchange="updateDropdown()">
            <label for="Dine-In" class="lbl1">Dine-In</label><br>

            <input type="radio" id="takeaway" name="orderType" value="Takeaway" onchange="updateDropdown()">
            <label for="Takeaway" class="lbl2">Takeaway</label><br><br>

            <p class="H-2">Where Are You Seated?</p>
            <select class="ddl" id="table-selection" name="table">
                <option value="">Select an option</option>
            </select><br>

            <p class="H-3">Full Name</p>
            <input type="text" name="fullname" class="ttbx" pattern="^[a-zA-Z\s]+$" placeholder="Enter your full name">

            <p class="H-4">Mobile No</p>
            <input type="tel" name="mobile" class="ttbx" pattern="[0-9]{10}" placeholder="Enter mobile no">

            <p class="H-5">Email</p>
            <input type="email" name="email" class="ttbx" placeholder="Enter Email">

            <p class="error1">*Please Select option (dine-in / Takeaway)</p>
            <p class="error2">*Please Select your Table no / Sitting no</p>
            <p class="error3">*Please Enter Your Full Name</p>
            <p class="error4">*Please Enter Your Mobile No</p>
            <p class="error5">*Please Enter Your Email</p>

            <input type="submit" class="Continue" value="Continue">
        </form>
    </div>

    <script>
        function updateDropdown() {
            const dropdown = document.getElementById("table-selection");
            const dineIn = document.getElementById("dinein").checked;

            dropdown.innerHTML = `<option value="">Select an option</option>`;

            if (dineIn) {
                dropdown.innerHTML += `
                    <option value="Table-1">Table #1</option>
                    <option value="Table-2">Table #2</option>
                    <option value="Table-3">Table #3</option>
                    <option value="Table-4">Table #4</option>
                    <option value="Table-5">Table #5</option>   
                    <option value="Table-6">Table #6</option>
                `;
            } else {
                dropdown.innerHTML += `
                    <option value="Sitting-1">Sitting #1</option>
                    <option value="Sitting-2">Sitting #2</option>
                    <option value="Sitting-3">Sitting #3</option>
                    <option value="Sitting-4">Sitting #4</option>
                    <option value="Sitting-5">Sitting #5</option>
                `;
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector(".Continue").addEventListener("click", function (event) {
                event.preventDefault();

                document.querySelectorAll(".error1, .error2, .error3, .error4, .error5").forEach((el) => {
                    el.style.display = "none";
                });

                let errors = [];

                const dineInChecked = document.getElementById("dinein").checked;
                const takeawayChecked = document.getElementById("takeaway").checked;
                if (!dineInChecked && !takeawayChecked) {
                    errors.push(".error1");
                }

                const tableSelection = document.getElementById("table-selection").value;
                if (!tableSelection) {
                    errors.push(".error2");
                }

                const fullName = document.querySelector("input[name='fullname']").value.trim();
                if (fullName === "") {
                    errors.push(".error3");
                }

                const mobile = document.querySelector("input[name='mobile']").value.trim();
                if (!/^\d{10}$/.test(mobile)) {
                    errors.push(".error4");
                }

                const email = document.querySelector("input[name='email']").value.trim();
                if (!email.includes("@") || !email.includes(".")) {
                    errors.push(".error5");
                }

                if (errors.length > 0) {
                    document.querySelector(errors[0]).style.display = "block";
                } else {
                    document.querySelector("form").submit();
                }
            });
        });
    </script>
</body>
</html>
