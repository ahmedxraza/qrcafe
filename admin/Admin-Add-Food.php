<?php
include '../partials/_dbconnect.php'; // Database connection file
include("../partials/Admin-Session.php");
restrictAdminPage();

$message = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $foodName = mysqli_real_escape_string($conn, $_POST['foodName']);
    $foodPrice = $_POST['foodPrice'];
    $foodDescription = mysqli_real_escape_string($conn, $_POST['foodDescription']);
    $foodCategory = $_POST['foodCategory'];

    // Image upload handling
    $targetDir = "../assets/Foods/"; // Folder to save images
    $fileName = basename($_FILES["foodImage"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow only image formats
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array(strtolower($fileType), $allowedTypes)) {
        if (move_uploaded_file($_FILES["foodImage"]["tmp_name"], $targetFilePath)) {
            // Insert food item into database
            $sql = "INSERT INTO Food (FoodName, FoodPrice, FoodDescription, FoodImage, FoodCategory) 
                    VALUES ('$foodName', '$foodPrice', '$foodDescription', '$fileName', '$foodCategory')";

            if (mysqli_query($conn, $sql)) {
                $message = "<span class='success'>Food added successfully!</span>";
            } else {
                $message = "<span class='error'>Error: Could not add food. " . mysqli_error($conn) . "</span>";
            }
        } else {
            $message = "<span class='error'>Error: Image upload failed.</span>";
        }
    } else {
        $message = "<span class='error'>Invalid file format! Only JPG, JPEG, PNG, GIF allowed.</span>";
    }
}

// Fetch categories dynamically from database
$categoryOptions = "";
$categoryQuery = "SELECT CategoryID, CategoryName FROM Category";
$result = mysqli_query($conn, $categoryQuery);
while ($row = mysqli_fetch_assoc($result)) {
    $categoryOptions .= "<option value='{$row['CategoryID']}'>{$row['CategoryName']}</option>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Admin-Add-Food.css">
    <link rel="stylesheet" href="../css/Admin-Nav-Side.css">
    <title>Add Food</title>
    <style>
        .message {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
            display: none; /* Hidden by default */
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <?php include("../partials/Admin-Nav-Side.php");?>
    <!-- Add Food Form -->
    <div class="container">
        <div class="add">
            <h1 class="Head">Add Food</h1>
            <div class="container2">
                <form action="Admin-Add-Food.php" method="POST" enctype="multipart/form-data">
                    <label for="foodName">Food Name:</label>
                    <input type="text" id="foodName" name="foodName" placeholder="Enter Food Name" required>

                    <label for="foodPrice">Food Price:</label>
                    <input type="number" id="foodPrice" name="foodPrice" placeholder="Enter Food Price" min="0" required>

                    <label for="foodDescription">Food Description:</label>
                    <textarea id="foodDescription" name="foodDescription" rows="3" placeholder="Enter Food Description" required></textarea>

                    <label for="foodImage">Upload Image:</label>
                    <div class="image-upload">
                        <div class="image-preview" id="imagePreview">
                            <img id="previewImg" src="" alt="Image Preview">
                        </div>
                        <label for="foodImage" class="upload-btn">Choose Image</label>
                        <input type="file" id="foodImage" name="foodImage" accept="image/*" required onchange="previewImage(event)">
                        <span id="fileName">No file chosen</span>
                    </div>

                    <label for="foodCategory">Food Category:</label>
                    <select id="foodCategory" name="foodCategory" required>
                        <option value="">Select Category</option>
                        <?php echo $categoryOptions; ?>
                    </select>

                    <button type="submit" class="ADDF">Add Food</button>

                    <!-- Success/Error Message Display -->
                    <div class="message" id="messageBox"><?php echo $message; ?></div>
                </form>
            </div>
        </div>
    </div>

    <script src="../js/Admin-Nav-Side.js"></script>
    <script>
        function previewImage(event) {
            const previewBox = document.getElementById("imagePreview");
            const previewImg = document.getElementById("previewImg");
            const fileNameDisplay = document.getElementById("fileName");
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = "block";
                };
                reader.readAsDataURL(file);
                fileNameDisplay.textContent = file.name;
            } else {
                fileNameDisplay.textContent = "No file chosen";
                previewImg.style.display = "none";
            }
        }

        // Auto-hide messages after 3 seconds
        document.addEventListener("DOMContentLoaded", function () {
            const messageBox = document.getElementById("messageBox");
            if (messageBox.innerHTML.trim() !== "") {
                messageBox.style.display = "block"; // Show message
                setTimeout(() => {
                    messageBox.style.display = "none"; // Hide after 3 seconds
                }, 3000);
            }
        });
    </script>
</body>
</html>
