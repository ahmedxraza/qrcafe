<?php
session_start();

// Check if user is logged in by checking both required session variables
if (!isset($_SESSION['fullname']) || !isset($_SESSION['userID'])) {
    header('Location: Info-Menu.php');
    exit;
}

// Include database connection
include('../partials/_dbconnect.php');

// Get the fullname from session (to display "Heyy, Ahmed Raza")
$fullname = $_SESSION['fullname'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Main-Menu.css">
    <title>Main Menu Page</title>
</head>
<body>

<header class="navbar">
    <div class="logo"><h2 class="logotext">QR Cafe</h2></div>
    <nav class="nav-links">
        <a href="./About-Us.php">ABOUT US</a>
        <a href="#CATEGORIES">CATEGORIES</a>
        <a href="./Write-Review.php">REVIEW</a>
        <a href="./User-Cart.php" class="cart-link">MY CART</a>
    </nav>
    <div class="cart-icon" id="cart-icon">
        <a href="./User-Cart.php">
            <img src="../assets/mainMenu-imgs/cart-png.png" alt="Cart" width="30" height="30">
        </a>
    </div>
    <div class="hamburger" id="hamburger">&#9776;</div>
    <div class="sidebar" id="sidebar">
        <div class="close-btn" id="close-btn">&times;</div>
        <a href="./About-Us.php">ABOUT US</a>
        <a href="#CATEGORIES">CATEGORIES</a>
        <a href="./Write-Review.php">REVIEW</a>
        <a href="./User-Cart.php">MY CART</a>
    </div>
</header>

<div class="heading">
    <img src="../assets/mainMenu-imgs/heading-Pizza.jpg" alt="Pizza Image" class="heading-image">
    <div class="overlay-text">Heyy, <?php echo htmlspecialchars($fullname); ?> <br>Welcome to our Cafe</div>
</div>

<!-- Categories Section -->
<div class="categories" id="CATEGORIES">
    <div class="categoriesHeading">
        <h2>Categories</h2>
    </div>
    <div class="categoryContainer">
        <?php
        $categorySql = "SELECT CategoryID, CategoryName FROM category";
        $categoryResult = mysqli_query($conn, $categorySql);

        if(mysqli_num_rows($categoryResult) > 0){
            while($row = mysqli_fetch_assoc($categoryResult)){
                $categoryID = $row['CategoryID'];
                $categoryName = $row['CategoryName'];

                echo '<a href="#category-'.$categoryID.'" class="category-button">'.htmlspecialchars($categoryName).'</a>';
            }
        } else {
            echo '<p>No categories found.</p>';
        }
        ?>
    </div>
    <hr class="divider">
</div>

<!-- Food Items Section -->
<div class="outer">
    <?php
    mysqli_data_seek($categoryResult, 0); // Reset result pointer to re-use in food items loop
    while($category = mysqli_fetch_assoc($categoryResult)) {
        $categoryID = $category['CategoryID'];
        $categoryName = $category['CategoryName'];

        echo '<div class="food-container" id="category-'.$categoryID.'">';
        echo '<h1 id="food">'.htmlspecialchars($categoryName).'</h1>';
        echo '<hr class="divider-2">';

        $foodSql = "SELECT FoodID, FoodName, FoodPrice, FoodDescription, FoodImage FROM food WHERE FoodCategory = '$categoryID'";
        $foodResult = mysqli_query($conn, $foodSql);

        if(mysqli_num_rows($foodResult) > 0){
            while($food = mysqli_fetch_assoc($foodResult)){
                $foodName = $food['FoodName'];
                $foodPrice = $food['FoodPrice'];
                $foodDescription = $food['FoodDescription'];
                $foodImage = $food['FoodImage'];

                echo '
                <div class="food-item">
                    <div class="food-details">
                        <h2 class="food-title">'.htmlspecialchars($foodName).'</h2>
                        <p class="food-price">₹'.htmlspecialchars($foodPrice).'</p>
                        <p class="food-description">'.htmlspecialchars($foodDescription).'</p>
                    </div>
                    <div class="food-image-btn-container">
                        <img src="../assets/Foods/'.htmlspecialchars($foodImage).'" height="170px" width="170px" alt="'.htmlspecialchars($foodName).'" class="food-image" loading="lazy">
                        <div class="add-to-cart">
                        <form class="add-to-cart-form" 
                            data-foodid="' . $food['FoodID'] . '" 
                            data-foodname="' . htmlspecialchars($food['FoodName']) . '" 
                            data-foodprice="' . $food['FoodPrice'] . '">
                            <button type="button" class="add-cart-btn">Add Cart+</button>
                        </form>
                        </div>
                    </div>
                    <hr>
                </div>';
            }
        } else {
            echo '<p>No food items available in this category.</p>';
        }

        echo '</div><hr>';
    }
    ?>
</div>

<!-- Floating Cart Icon  -->
<a href="User-Cart.php" class="cart-iconn" id="cartIcon">
    <img src="../assets/mainMenu-imgs/cart-png.png" alt="Cart">
</a>


<!-- Footer -->
<div class="footer">
    <h1 class="tagline">"Cravings Meet Convenience!"</h1>
    <p>Contact Us: +91 9228744494</p>
    <p>© 2025 QR Cafe. All rights reserved.</p>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.getElementById("hamburger");
    const sidebar = document.getElementById("sidebar");
    const closeBtn = document.getElementById("close-btn");

    hamburger.addEventListener("click", () => sidebar.classList.add("active"));
    closeBtn.addEventListener("click", () => sidebar.classList.remove("active"));

    document.addEventListener("click", (event) => {
        if (!sidebar.contains(event.target) && !hamburger.contains(event.target)) {
            sidebar.classList.remove("active");
        }
    });
});
</script>
<script>
document.querySelectorAll('.add-cart-btn').forEach(button => {
    button.addEventListener('click', function() {
        const form = this.closest('.add-to-cart-form');
        const foodID = form.getAttribute('data-foodid');
        const foodName = form.getAttribute('data-foodname');
        const foodPrice = form.getAttribute('data-foodprice');
        const cartIcon = document.getElementById("cartIcon");

        fetch('add-to-cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `foodID=${foodID}&foodName=${encodeURIComponent(foodName)}&foodPrice=${foodPrice}`
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // Optional for debugging
            cartIcon.classList.add("cart-visible");
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to add to cart!');
        });
    });
});
</script>

</body>
</html>
