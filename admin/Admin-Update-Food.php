<?php
  // Include database connection
  include("../partials/Admin-Session.php");
  include("../partials/_dbconnect.php");
  restrictAdminPage();

  // Fetch the food ID from the URL
  if (isset($_GET['foodID'])) {
    $foodID = $_GET['foodID'];

    // Fetch the food details from the database
    $sql = "SELECT Food.FoodID, Food.FoodName, Food.FoodPrice, Food.FoodDescription, Food.FoodImage, Category.CategoryID, Category.CategoryName 
            FROM Food 
            JOIN Category ON Food.FoodCategory = Category.CategoryID 
            WHERE Food.FoodID = '$foodID'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      $food = mysqli_fetch_assoc($result);
    } else {
      die("Food item not found");
    }
  } else {
    die("Food ID not provided");
  }

  // Update the food details if the form is submitted
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get updated data from the form
    $foodName = $_POST['foodName'];
    $foodPrice = $_POST['foodPrice'];
    $foodDescription = $_POST['foodDescription'];
    $foodCategory = $_POST['foodCategory'];

    // Handle image upload
    $foodImage = $food['FoodImage']; // Default to existing image
    if (isset($_FILES['foodImage']) && $_FILES['foodImage']['error'] == 0) {
      // If a new image is uploaded, handle the file upload
      $targetDir = "../assets/Foods/";
      $fileName = basename($_FILES["foodImage"]["name"]);
      $targetFilePath = $targetDir . $fileName;

      if (move_uploaded_file($_FILES["foodImage"]["tmp_name"], $targetFilePath)) {
        $foodImage = $fileName; // Update the image name
      }
    }

    // Update the food item in the database
    $updateQuery = "UPDATE Food SET 
                      FoodName = '$foodName', 
                      FoodPrice = '$foodPrice', 
                      FoodDescription = '$foodDescription', 
                      FoodCategory = '$foodCategory', 
                      FoodImage = '$foodImage' 
                    WHERE FoodID = '$foodID'";

    if (mysqli_query($conn, $updateQuery)) {
      echo "<script>alert('Food item updated successfully!'); window.location.href='Admin-Manage-Inventory.php';</script>";
    } else {
      echo "Error: " . mysqli_error($conn);
    }
  }

  // Fetch categories dynamically for the dropdown
  $categoryQuery = "SELECT * FROM Category WHERE CategoryID >= 1001"; // Assuming CategoryID starts from 1001
  $categoryResult = mysqli_query($conn, $categoryQuery);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/Admin-Update-Food.css" />
    <link rel="stylesheet" href="../css/Admin-Nav-Side.css" />
    <title>Update Food</title>
  </head>
  <body>
    <?php include "../partials/Admin-Nav-Side.php"; ?>
    <!-- Add Food starts here -->
    <div class="container">
      <div class="add">
        <h1 class="Head">Update Food</h1>
        <div class="container2">
          <form action="Admin-Update-Food.php?foodID=<?php echo $foodID; ?>" method="POST" enctype="multipart/form-data">
            <!-- Food Name -->
            <label for="foodName">Food Name:</label>
            <input
              type="text"
              id="foodName"
              name="foodName"
              placeholder="Enter Food Name"
              value="<?php echo $food['FoodName']; ?>"
              required
            />

            <!-- Food Price -->
            <label for="foodPrice">Food Price:</label>
            <input
              type="number"
              id="foodPrice"
              name="foodPrice"
              placeholder="Enter Food Price"
              min="0"
              value="<?php echo $food['FoodPrice']; ?>"
              required
            />

            <!-- Food Description -->
            <label for="foodDescription">Food Description:</label>
            <textarea
              id="foodDescription"
              name="foodDescription"
              rows="3"
              placeholder="Enter Food Description"
              required
            ><?php echo $food['FoodDescription']; ?></textarea>

            <!-- Food Image Upload -->
            <label for="foodImage">Upload Image:</label>

            <div class="image-upload">
  <!-- Image Preview Box -->
  <div class="image-preview" id="imagePreview">
    <?php
      // Check if the image exists in the directory before displaying it
      $foodImagePath = "../assets/Foods/".$food['FoodImage'];
      if (file_exists($foodImagePath) && $food['FoodImage'] != '') {
        echo "<img id='previewImg' src='" . $foodImagePath . "' alt='Image Preview' />";
      } else {
        // Fallback image if the original image doesn't exist
        echo "<img id='previewImg' src='../assets/Foods/default-image.jpg' alt='Image Preview' />";
      }
    ?>
  </div>

              <!-- Custom Upload Button -->
  <label for="foodImage" class="upload-btn">Choose Image</label>
  <input
    type="file"
    id="foodImage"
    name="foodImage"
    accept="image/*"
    onchange="previewImage(event)"
  />

             <!-- Display Selected File Name -->
  <span id="fileName"><?php echo $food['FoodImage'] ? $food['FoodImage'] : 'No image chosen'; ?></span>
</div>

            <!-- Food Category Dropdown -->
            <label for="foodCategory">Food Category:</label>
            <select id="foodCategory" name="foodCategory" required>
              <option value="">Select Category</option>
              <?php
                // Loop through categories and create dropdown options
                while ($category = mysqli_fetch_assoc($categoryResult)) {
                  echo "<option value='" . $category['CategoryID'] . "' " . ($food['CategoryID'] == $category['CategoryID'] ? 'selected' : '') . ">" . $category['CategoryName'] . "</option>";
                }
              ?>
            </select>

            <!-- Submit Button -->
            <button type="submit" class="ADDF">Update Food</button>
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
            previewImg.style.display = "block"; // Show the image
          };
          reader.readAsDataURL(file);

          fileNameDisplay.textContent = file.name; // Show file name
        } else {
          fileNameDisplay.textContent = "No file chosen"; // Reset text if no file selected
          previewImg.style.display = "none"; // Hide preview if no file
        }
      }
    </script>
  </body>
</html>
