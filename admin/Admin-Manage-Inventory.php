<?php 
  include("../partials/Admin-Session.php");
  include("../partials/_dbconnect.php");
  restrictAdminPage();

  // Delete Food Logic
  if (isset($_POST['foodId'])) {
    $foodId = $_POST['foodId'];
    $sql = "DELETE FROM Food WHERE FoodID = $foodId";
    if (mysqli_query($conn, $sql)) {
      $message = "Food item deleted successfully!";
      $messageColor = "green";
    } else {
      $message = "Error deleting food item: " . mysqli_error($conn);
      $messageColor = "red";
    }
  }

  // Fetch all Food Items
  $sql = "SELECT Food.FoodID, Food.FoodName, Food.FoodPrice, Food.FoodDescription, Food.FoodImage, Category.CategoryName 
          FROM Food 
          JOIN Category ON Food.FoodCategory = Category.CategoryID";
  $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/Admin-Manage-Inventory.css" />
    <link rel="stylesheet" href="../css/Admin-Nav-Side.css" />
    <title>Manage Inventory</title>
  </head>
  <body>
    <?php include("../partials/Admin-Nav-Side.php");?>

    <!-- DELETE MODAL -->
    <dialog id="Delete-Food">
      <div class="wrapper">
        <h2>Are you sure you want to delete this food item?</h2>
        <p class="dlt-p">
          Do you want to delete this food item? Once you delete this item, it cannot be recovered!
        </p>
        <form id="DeleteFoodForm" method="post" action="">
          <input type="hidden" id="deleteFoodId" name="foodId" />
          <div class="buttons">
            <button type="button" onclick="closeDeleteDialog()">Cancel</button>
            <button type="submit" onclick="deleteFood()">Delete</button>
          </div>
        </form>
      </div>
    </dialog>

    <!-- Manage Inventory Starts Here -->
    <div class="container">
      <div class="add">
        <h1 class="Head">Manage Inventory</h1>
        <a href="./Admin-Add-Food.php" id="add-food">Add Food</a>
        
        <!-- Success or Error Message -->
        <?php if (isset($message)): ?>
          <p id="successMessage" style="color: <?php echo $messageColor; ?>; font-size: 1.6rem;"><?php echo $message; ?></p>
        <?php endif; ?>
        <hr />
      </div>
      <!-- Table -->
      <div class="table">
        <table>
          <tr>
            <th>Food ID</th>
            <th>Food Name</th>
            <th>Food Price</th>
            <th>Food Description</th>
            <th>Food Image</th>
            <th>Food Category</th>
            <th>Action</th>
          </tr>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?php echo $row['FoodID']; ?></td>
              <td><?php echo $row['FoodName']; ?></td>
              <td>₹<?php echo $row['FoodPrice']; ?></td>
              <td><?php echo $row['FoodDescription']; ?></td>
              <td><img src="../assets/Foods/<?php echo $row['FoodImage']; ?>" alt="<?php echo $row['FoodName']; ?>" class="food-img" /></td>
              <td><?php echo $row['CategoryName']; ?></td>
              <td>
                <a href="Admin-Update-Food.php?foodID=<?php echo $row['FoodID']; ?>" class="btn" id="update">Update</a>
                <button class="delete btn" onclick="openDeleteDialog(<?php echo $row['FoodID']; ?>)">Delete</button>
              </td>
            </tr>
          <?php } ?>
        </table>
      </div>
    </div>

    <script>
      const dialogDelete = document.getElementById("Delete-Food");
      const wrapper = document.querySelector(".wrapper");

      function openDeleteDialog(id) {
        document.getElementById("deleteFoodId").value = id;
        dialogDelete.showModal();
      }

      function closeDeleteDialog() {
        dialogDelete.close();
      }

      function deleteFood() {
        const foodId = document.getElementById("deleteFoodId").value;
        // Perform delete action (send request to server)
        console.log(`Deleting food item with ID: ${foodId}`);
        closeDeleteDialog();
        // Submit form
        document.getElementById("DeleteFoodForm").submit();
      }

      dialogDelete.addEventListener("click", (e) => {
        if (!wrapper.contains(e.target)) {
          dialogDelete.close();
        }
      });

      // Hide the message after 3 seconds
      <?php if (isset($message)): ?>
        setTimeout(function() {
          document.getElementById("successMessage").style.display = "none";
        }, 3000); // 3 seconds delay
      <?php endif; ?>
    </script>
  </body>
</html>
