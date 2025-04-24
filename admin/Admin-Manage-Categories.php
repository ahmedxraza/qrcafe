<?php 
  include("../partials/Admin-Session.php");
  include("../partials/_dbconnect.php");
  restrictAdminPage();

  // Add Category Logic
  if (isset($_POST['categoryName'])) {
    $categoryName = $_POST['categoryName'];
    $sql = "INSERT INTO Category (CategoryName) VALUES ('$categoryName')";
    if (mysqli_query($conn, $sql)) {
      $message = "Category added successfully!";
      $messageColor = "green";
    } else {
      $message = "Error adding category: " . mysqli_error($conn);
      $messageColor = "red";
    }
  }

  // Update Category Logic
  if (isset($_POST['updateCategoryId'])) {
    $categoryId = $_POST['updateCategoryId'];
    $categoryName = $_POST['updateCategoryName'];
    $sql = "UPDATE Category SET CategoryName = '$categoryName' WHERE CategoryID = $categoryId";
    if (mysqli_query($conn, $sql)) {
      $message = "Category updated successfully!";
      $messageColor = "green";
    } else {
      $message = "Error updating category: " . mysqli_error($conn);
      $messageColor = "red";
    }
  }

  // Delete Category Logic
  if (isset($_POST['categoryId'])) {
    $categoryId = $_POST['categoryId'];

    // Delete all food items associated with the category
    $deleteFoodItemsSql = "DELETE FROM Food WHERE FoodCategory = $categoryId";
    if (mysqli_query($conn, $deleteFoodItemsSql)) {
      // Delete the category
      $deleteCategorySql = "DELETE FROM Category WHERE CategoryID = $categoryId";
      if (mysqli_query($conn, $deleteCategorySql)) {
        $message = "Category and all associated food items deleted successfully!";
        $messageColor = "green";
      } else {
        $message = "Error deleting category: " . mysqli_error($conn);
        $messageColor = "red";
      }
    } else {
      $message = "Error deleting food items: " . mysqli_error($conn);
      $messageColor = "red";
    }
  }

  // Fetch all Categories
  $sql = "SELECT * FROM Category";
  $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/Admin-Manage-Categories.css" />
    <title>Manage Categories</title>
  </head>
  <body>
    <?php include("../partials/Admin-Nav-Side.php");?>

    <!-- MANAGE CATEGORIES STARTS -->
    <!-- MODALS ADD -->
    <dialog id="Add-Category">
      <div class="wrapper">
        <h2>Add Category</h2>
        <form id="addCategoryForm" method="post" action="">
          <label for="categoryName">Category Name:</label>
          <input
            type="text"
            id="categoryName"
            name="categoryName"
            required
            minlength="3"
            maxlength="50"
            pattern="^[a-zA-Z\s]+$"
            placeholder="Enter Category Name"
          />
          <small id="nameError" style="color: red; display: none">Please enter a valid category name (only letters and spaces, 3-50 characters).</small>
          <input type="submit" value="Add" />
        </form>
      </div>
    </dialog>

    <!-- MODALS UPDATE -->
    <dialog id="Update-Category">
      <div class="wrapper">
        <h2>Update Category</h2>
        <form id="UpdateCategoryForm" method="post" action="">
          <input type="hidden" id="updateCategoryId" name="updateCategoryId" />
          <label for="UpdatecategoryName">Category Name:</label>
          <input
            type="text"
            id="UpdatecategoryName"
            name="updateCategoryName"
            required
            minlength="3"
            maxlength="50"
            pattern="^[a-zA-Z\s]+$"
            placeholder="Update Category"
          />
          <small id="nameError" style="color: red; display: none">Please enter a valid category name (only letters and spaces, 3-50 characters).</small>
          <input type="submit" value="Update" />
        </form>
      </div>
    </dialog>

    <!-- MODALS DELETE -->
    <dialog id="Delete-Category">
      <div class="wrapper">
        <h2>Are you sure you want to delete this category?</h2>
        <p class="dlt-p">
          Do you want to delete this category? Once you delete this category, all the food items with the same category will be deleted!
        </p>
        <form id="DeleteCategoryForm" method="post" action="">

          <input type="hidden" id="deleteCategoryId" name="categoryId" />
          <div class="buttons">
            <button type="button" onclick="closeDeleteDialog()">Cancel</button>
            <button type="submit" onclick="deleteCategory()">Delete</button>
          </div>
        </form>
      </div>
    </dialog>

    <!-- MANAGE CATEGORIES STARTS -->
    <div class="container">
      <div class="add">
        <h1 class="Head">Manage Categories</h1>
        <button class="add-cat" onclick="ShowAddCatDialog()">Add Category</button>

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
            <th>Category ID</th>
            <th>Category Name</th>
            <th>Action</th>
          </tr>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?php echo $row['CategoryID']; ?></td>
              <td><?php echo $row['CategoryName']; ?></td>
              <td>
                <button class="btn1 btn" onclick="openUpdateDialog(<?php echo $row['CategoryID']; ?>, '<?php echo $row['CategoryName']; ?>')">Update</button>
                <button class="btn2 btn" onclick="openDeleteDialog(<?php echo $row['CategoryID']; ?>)">Delete</button>
              </td>
            </tr>
          <?php } ?>
        </table>
      </div>
    </div>
    <!-- MODAL SCRIPTING -->
    <script>
      const dialogAdd = document.getElementById("Add-Category");
const dialogUpdate = document.getElementById("Update-Category");
const dialogDelete = document.getElementById("Delete-Category");

// Get wrappers inside each dialog
const wrapperAdd = dialogAdd.querySelector(".wrapper");
const wrapperUpdate = dialogUpdate.querySelector(".wrapper");
const wrapperDelete = dialogDelete.querySelector(".wrapper");

function ShowAddCatDialog() {
  dialogAdd.showModal();
}

function ShowUpdateCatDialog() {
  dialogUpdate.showModal();
}

function ShowDeleteCatDialog() {
  dialogDelete.showModal();
}

function CloseAddCatDialog() {
  dialogAdd.close();
}

function CloseUpdateCatDialog() {
  dialogUpdate.close();
}

function CloseDeleteCatDialog() {
  dialogDelete.close();
}

function openUpdateDialog(id, name) {
  document.getElementById("updateCategoryId").value = id;
  document.getElementById("UpdatecategoryName").value = name;
  dialogUpdate.showModal();
}

function openDeleteDialog(id) {
  document.getElementById("deleteCategoryId").value = id;
  dialogDelete.showModal();
}

function closeDeleteDialog() {
  dialogDelete.close();
}

function deleteCategory() {
  const categoryId = document.getElementById("deleteCategoryId").value;
  console.log(`Deleting category with ID: ${categoryId}`);
  closeDeleteDialog();
}

// Close modals when clicking outside of wrapper
dialogAdd.addEventListener("click", (e) => {
  if (!wrapperAdd.contains(e.target)) {
    dialogAdd.close();
  }
});

dialogUpdate.addEventListener("click", (e) => {
  if (!wrapperUpdate.contains(e.target)) {
    dialogUpdate.close();
  }
});

dialogDelete.addEventListener("click", (e) => {
  if (!wrapperDelete.contains(e.target)) {
    dialogDelete.close();
  }
});

// Hide success/error message after 3 seconds
<?php if (isset($message)): ?>
  setTimeout(function() {
    document.getElementById("successMessage").style.display = "none";
  }, 3000);
<?php endif; ?>

    </script>
  </body>
</html>