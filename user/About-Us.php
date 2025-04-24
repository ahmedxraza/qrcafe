<?php
session_start();
if (!isset($_SESSION['fullname']) || !isset($_SESSION['userID'])) {
    header('Location: Info-Menu.php');
    exit;
}

include('../partials/_dbconnect.php'); 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/About-Us.css" />
    <title>About Us</title>
  </head>
  <body>
    <a href="./Main-Menu.php" class="back-arrow"
      ><img src="../assets/MainMenu-imgs/back.png" alt="back" />
    </a>

    <div class="container1">
      <div class="aboutus">
        <h1>About Us</h1>
        <div class="aboutus-p">
          <span style="font-weight: bold">Welcome to QR Cafe,</span>
          <br /><br />
          <span
            >a smart and seamless food ordering system designed to enhance your
            dining experience. We believe that ordering food should be quick,
            hassle-free, and efficient, which is why we created a contactless
            and user-friendly solution. <br />
            <br />
            With QR Cafe, customers can scan a QR code, browse the digital menu,
            and place their orders instantly—eliminating the need for long waits
            or manual order-taking. Our goal is to bring convenience, speed, and
            innovation to the food industry while ensuring a smooth experience
            for both customers and restaurant owners. <br />
            <br />At QR Cafe, we are committed to making dining simpler,
            smarter, and more enjoyable.</span
          >
        </div>
      </div>
      <hr />

      <div class="vision">
        <h1>Our Vision</h1>
        <div class="vision-p">
          <span
            >At QR Cafe, our vision is to redefine the dining experience by
            leveraging technology to create a fast, efficient, and contactless
            food ordering system. We aim to bridge the gap between convenience
            and quality service, ensuring that customers enjoy a seamless and
            hassle-free experience every time they dine. We envision a future
            where: <br /><br />
            - Customers can order food with a single scan, reducing wait
            times.<br />- Restaurants can streamline operations and improve
            efficiency.<br />- Technology enhances customer satisfaction and
            engagement.<br />- Sustainable and paperless menus contribute to an
            eco-friendly environment.<br /><br />
            With QR Cafe, we are not just building a system; we are shaping the
            future of smart dining!</span
          >
        </div>
      </div>
      <hr />
    </div>

    <div class="container2">
      <h1>How it works?</h1>
      <div class="section-container">
        <section class="section1">
          <h2>1. Scan The QR Code</h2>
          <p class="sp">
            - Every table has a QR code placed on it. <br /><br />
            - Simply scan the QR code using your smartphone's camera or a QR
            scanner app.
          </p>
        </section>

        <section class="section2">
          <h2>2. Choose Your Meal</h2>
          <p class="sp">
            - Explore a variety of delicious food items, categorized for easy
            selection. <br /><br />
            - Add your favorite dishes to the cart.
          </p>
        </section>

        <section class="section3">
          <h2>3. Place Your Order</h2>
          <p class="sp">
            - Once you've made your selection, proceed to checkout. <br /><br />
            - Confirm your order, and it will be sent directly to our admin.
          </p>
        </section>

        <section class="section4">
          <h2>4. Enjoy Your Meal</h2>
          <p class="sp">
            - Our team prepares your food with care and delivers it to your
            table. <br /><br />

            - Sit back, relax, and enjoy your meal without any waiting in
            queues!
          </p>
        </section>
      </div>
    </div>
    <div class="container1">
      <hr />
      <h1>Why choose us?</h1>
      <div class="choose">
        <span
          ><li>
            Seamless Ordering - Enjoy a hassle-free food ordering experience
            with our user-friendly interface.
          </li>
          <br />
          <li>
            Fast & Fresh - Your meals are prepared fresh and served quickly for
            the best dining experience
          </li>
          <br />
          <li>
            Wide Variety - Explore a diverse menu with delicious options for
            every taste
          </li>
          <br />
          <li>
            Convenient & Reliable - Order from your table and let us handle the
            rest—no waiting in lines
          </li></span
        >
      </div>
      <h1 class="heart">&lt;3</h1>
    </div>
    <div class="footer">
      <h1 class="tagline">"Cravings Meet Convenience!"</h1>
      <p>Contact Us: +91 9228744494</p>
      <p>© 2025 QR Cafe. All rights reserved.</p>
    </div>
  </body>
</html>
