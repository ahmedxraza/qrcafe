-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2025 at 07:40 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qrcafedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `AdminName` varchar(100) NOT NULL,
  `AdminEmail` varchar(100) NOT NULL,
  `AdminPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `AdminName`, `AdminEmail`, `AdminPassword`) VALUES
(101, 'Ahmed Raza', 'workahmadraza@gmail.com', '$2y$10$Q9xmtOYRmdX3utWfeM7rXuGfREkBsPEIFnIZFMxScMhy8CMFqthTy');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `FoodID` int(11) NOT NULL,
  `FoodName` varchar(255) NOT NULL,
  `Quantity` int(11) NOT NULL DEFAULT 1,
  `FoodTotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartID`, `userID`, `FoodID`, `FoodName`, `Quantity`, `FoodTotal`) VALUES
(180, 29, 6008, ' Margherita Pizza', 1, '199.00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `CategoryName`) VALUES
(1001, 'Pizza'),
(1002, 'Burger'),
(1003, 'Fries'),
(1004, 'Sandwiches'),
(1005, 'Tea Beverages'),
(1006, 'Coffee Beverages'),
(1007, 'Mocktails'),
(1008, 'Desserts');

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `FoodID` int(11) NOT NULL,
  `FoodName` varchar(255) NOT NULL,
  `FoodPrice` decimal(10,2) NOT NULL,
  `FoodDescription` text DEFAULT NULL,
  `FoodImage` varchar(255) DEFAULT NULL,
  `FoodCategory` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`FoodID`, `FoodName`, `FoodPrice`, `FoodDescription`, `FoodImage`, `FoodCategory`) VALUES
(6008, ' Margherita Pizza', '199.00', 'Classic Italian pizza topped with fresh tomato sauce, mozzarella cheese, and basil leaves for a simple yet delicious taste.', 'Margherita-Pizzaa.jpg', 1001),
(6009, 'Farmhouse Pizza', '299.00', 'Loaded with fresh vegetables like capsicum, onions, tomatoes, and mushrooms, topped with mozzarella cheese.', 'FarmHouse-Pizza.jpg', 1001),
(6011, 'Peppy Paneer Pizza', '349.00', 'Spicy paneer cubes combined with crispy capsicum and red paprika, layered over a cheesy base.', 'PeppyPaneer-Pizza.jpg', 1001),
(6012, 'Mexican Green Wave Pizza', '349.00', 'A spicy and tangy pizza featuring jalapeños, capsicum, onions, and crunchy nachos with a Mexican seasoning blend.', 'MexicanGreenWave-Pizza.jpg', 1001),
(6016, 'Pepperoni Pizza', '459.00', 'A classic pizza with spicy pepperoni slices, gooey cheese, and a crispy crust.', 'Pepperoni-Pizza.jpg', 1001),
(6017, 'BBQ Chicken Pizza', '399.00', 'Smoky BBQ chicken pieces, onions, and bell peppers, topped with a tangy barbecue sauce.', 'BbqChicken-Pizza.jpg', 1001),
(6018, 'Cheese Burst Pizza', '449.00', 'A cheese lover’s dream with extra molten cheese inside the crust and a generous cheese topping.', 'CheeseBurst-Pizza.jpg', 1001),
(6019, 'Turkish Pizza', '399.00', 'A thin and crispy flatbread topped with a flavorful mixture of minced lamb or beef, tomatoes, onions, fresh herbs, and aromatic spices.', 'Turkish-Pizza.jpg', 1001),
(6020, 'Classic Veggie Burger', '149.00', 'A crispy vegetable patty made with potatoes, peas, carrots, and special spices, served with fresh lettuce, tomatoes, onions, and creamy mayo inside a toasted sesame bun.', 'ClassicVeggie-Burger.jpg', 1002),
(6021, 'Double Decker Meat Burger', '299.00', 'A hearty burger with two succulent Meat patties, cheddar cheese, caramelized onions, lettuce, and a tangy special sauce, served in a toasted brioche bun.', 'DoubleDecker-Burger.jpg', 1002),
(6022, 'Cheese Burst Burger', '179.00', 'A juicy grilled Potato patty topped with melted cheese, crisp lettuce, tomatoes, and a smoky mayo sauce, served in a soft, butter-toasted bun.', 'CheeseBurst-Burger.jpg', 1002),
(6023, 'Classic French Fries', '99.00', 'Golden, crispy, and lightly salted potato fries served hot, perfect for pairing with ketchup or mayo.', 'ClassicFrenchFries.jpg', 1003),
(6024, 'Peri-Peri Fries', '129.00', 'Crispy French fries tossed in a spicy and tangy peri-peri seasoning, giving them an extra kick of flavor.', 'Peri-PeriFries.jpg', 1003),
(6025, 'Cheese Loaded Fries', '179.00', 'A cheesy delight with crispy fries smothered in gooey melted cheese and sprinkled with mixed herbs.', 'Cheese Loaded Fries.jpg', 1003),
(6026, 'BBQ Chicken Fries', '199.00', 'A perfect snack with crispy fries topped with shredded BBQ chicken, melted cheese, and a smoky sauce.', 'BBQ Chicken Fries.jpg', 1003),
(6027, 'Grilled Veggie Sandwich', '149.00', 'A wholesome sandwich loaded with grilled bell peppers, tomatoes, onions, and lettuce, topped with cheese and a tangy mayo spread, served in toasted bread.', 'Grilled Veggie Sandwich.jpg', 1004),
(6028, 'Paneer Tikka Sandwich', '199.00', 'A fusion sandwich with marinated paneer tikka, onions, capsicum, and a hint of mint chutney, grilled to perfection in soft bread.', 'Paneer Tikka Sandwich.jpg', 1004),
(6029, 'Classic Chicken Club Sandwich', '149.00', 'A three-layered sandwich with grilled chicken, crispy bacon, fried egg, lettuce, and cheese, served with a creamy mayo dressing.', 'Classic Chicken Club Sandwich.jpg', 1004),
(6030, 'Cheese & Corn Sandwich', '169.00', 'A delicious mix of sweet corn and melted cheese, seasoned with herbs and grilled between buttered bread slices for a perfect crunch.', 'Cheese & Corn Sandwich.jpg', 1004),
(6031, 'Masala Chai', '29.00', 'A traditional Indian tea brewed with black tea leaves, milk, and aromatic spices like cardamom, ginger, and cinnamon for a rich and flavorful taste.', 'Masalachai.jpg', 1005),
(6032, 'Ginger Tea', '69.00', 'A soothing blend of black tea, fresh ginger, and milk, perfect for relaxation and digestion.', 'Ginger Tea.jpg', 1005),
(6033, 'Lemon Honey Green Tea', '89.00', 'A refreshing and healthy green tea infused with fresh lemon juice and honey for a light, detoxifying experience.', 'Lemon Honey Green Tea.jpg', 1005),
(6034, 'Tulsi Herbal Tea', '99.00', 'A caffeine-free herbal infusion made with holy basil (tulsi) leaves, known for its calming and immunity-boosting properties.', 'Tulsi Herbal Tea.jpg', 1005),
(6035, 'Iced Lemon Tea ', '99.00', 'A chilled, tangy, and mildly sweet iced tea with a hint of lemon, perfect for hot days.', 'Iced Lemon Tea.jpg', 1005),
(6036, 'Regular Coffee', '59.00', 'A simple yet classic blend of brewed coffee and milk, lightly sweetened and served hot for a comforting and refreshing experience. Perfect for a daily caffeine boost!', 'Simple Coffee.jpg', 1006),
(6037, 'Espresso', '99.00', 'A strong, rich shot of pure coffee, perfect for caffeine lovers.', 'espresso.jpg', 1006),
(6038, 'Cappuccino', '149.00', 'A classic Italian coffee with a perfect blend of espresso, steamed milk, and frothy milk foam.', 'Cappuccino.jpg', 1006),
(6039, 'Café Latte', '159.00', 'A smooth and creamy coffee with espresso and steamed milk, topped with light foam.', 'Café Latte.jpg', 1006),
(6040, 'Cold Coffee', '169.00', 'A refreshing blend of chilled coffee, milk, sugar, and ice, served with whipped cream.', 'Cold Coffee.jpg', 1006),
(6041, 'Mocha Coffee', '199.00', 'A delicious mix of espresso, chocolate syrup, steamed milk, and whipped cream for a chocolaty coffee delight.', 'green Matcha Coffee.jpg', 1006),
(6042, 'Virgin Mojito', '149.00', 'A refreshing blend of fresh mint leaves, lemon juice, sugar, and soda, served over crushed ice for a cool and fizzy experience.', 'Virgin Mojito.jpg', 1007),
(6043, 'Blue Lagoon', '169.00', 'A vibrant blue mocktail made with blue curacao syrup, lemon juice, and sprite, giving it a sweet and tangy tropical flavor.', 'Blue Lagoon.jpg', 1007),
(6044, 'Strawberry Delight', '179.00', 'A fruity and refreshing drink made with fresh strawberry puree, lime juice, and soda, topped with crushed ice and mint leaves.', 'Strawberry Delight.jpg', 1007),
(6045, 'Pina Colada (Non-Alcoholic)', '199.00', 'A creamy and tropical blend of coconut milk, pineapple juice, and crushed ice, served chilled for a smooth and exotic taste.', 'Pina Colada.jpg', 1007),
(6046, 'Watermelon Cooler', '159.00', 'A hydrating summer drink made with fresh watermelon juice, lime, and mint, served over ice for a revitalizing experience.', 'Watermelon Cooler.jpg', 1007),
(6047, 'Chocolate Brownie', '149.00', 'A rich and fudgy chocolate brownie, served warm with a drizzle of chocolate sauce. Perfect with a scoop of vanilla ice cream!', 'Chocolate Brownie.jpg', 1008),
(6048, 'Classic Tiramisu', '199.00', 'A creamy Italian dessert made with layers of coffee-soaked sponge, mascarpone cheese, and cocoa powder for a heavenly taste.', 'Classic Tiramisu.jpg', 1008),
(6049, 'Blueberry Cheesecake', '249.00', 'A creamy and smooth cheesecake with a buttery biscuit base, topped with a luscious blueberry compote.', 'Blueberry Cheesecake.jpg', 1008),
(6050, 'Choco Lava Cake', '179.00', 'A decadent chocolate cake with a molten chocolate center that oozes out with every bite, served warm with vanilla ice cream.', 'Choco Lava Cake.jpg', 1008);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `OrderType` varchar(50) NOT NULL,
  `tableORsitting` varchar(50) NOT NULL,
  `SubTotal` decimal(10,2) NOT NULL,
  `GST` decimal(10,2) NOT NULL,
  `GrandTotal` decimal(10,2) NOT NULL,
  `OrderStatus` varchar(50) DEFAULT 'Pending',
  `PaymentStatus` varchar(10) DEFAULT 'Pending',
  `OrderDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `userID`, `OrderType`, `tableORsitting`, `SubTotal`, `GST`, `GrandTotal`, `OrderStatus`, `PaymentStatus`, `OrderDate`) VALUES
(18001, 17, 'Dine-In', 'Table-1', '527.00', '26.35', '553.35', 'Served', 'Paid', '2025-03-25 09:57:55'),
(18002, 18, 'Dine-In', 'Table-4', '797.00', '39.85', '836.85', 'Served', 'Paid', '2025-03-25 10:01:29'),
(18003, 19, 'Takeaway', 'Sitting-2', '965.00', '48.25', '1013.25', 'Served', 'Paid', '2025-03-25 10:06:30'),
(18004, 20, 'Dine-In', 'Table-6', '1115.00', '55.75', '1170.75', 'Served', 'Paid', '2025-03-25 10:12:11'),
(18005, 21, 'Takeaway', 'Sitting-5', '1005.00', '50.25', '1055.25', 'Served', 'Paid', '2025-03-25 10:16:24'),
(18006, 22, 'Takeaway', 'Sitting-4', '1047.00', '52.35', '1099.35', 'Cancelled', 'Pending', '2025-03-25 10:37:23'),
(18008, 24, 'Takeaway', 'Sitting-2', '1194.00', '59.70', '1253.70', 'Served', 'Pending', '2025-03-26 04:33:25'),
(18009, 25, 'Takeaway', 'Sitting-3', '278.00', '13.90', '291.90', 'Pending', 'Pending', '2025-03-26 04:46:23'),
(18010, 26, 'Dine-In', 'Table-4', '597.00', '29.85', '626.85', 'Cancelled', 'Pending', '2025-03-26 04:54:03'),
(18011, 30, 'Dine-In', 'Table-3', '299.00', '14.95', '313.95', 'Pending', 'Pending', '2025-04-02 06:39:27'),
(18012, 31, 'Takeaway', 'Sitting-3', '1047.00', '52.35', '1099.35', 'Pending', 'Pending', '2025-04-03 05:37:03');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `OrderItemsID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `FoodID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `FoodPrice` decimal(10,2) NOT NULL,
  `FoodTotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`OrderItemsID`, `OrderID`, `userID`, `FoodID`, `Quantity`, `FoodPrice`, `FoodTotal`) VALUES
(14001, 18001, 17, 6021, 1, '299.00', '299.00'),
(14002, 18001, 17, 6024, 1, '129.00', '129.00'),
(14003, 18001, 17, 6035, 1, '99.00', '99.00'),
(14004, 18002, 18, 6017, 1, '399.00', '399.00'),
(14005, 18002, 18, 6038, 1, '149.00', '149.00'),
(14006, 18002, 18, 6049, 1, '249.00', '249.00'),
(14007, 18003, 19, 6042, 1, '149.00', '149.00'),
(14008, 18003, 19, 6046, 1, '159.00', '159.00'),
(14009, 18003, 19, 6050, 1, '179.00', '179.00'),
(14010, 18003, 19, 6009, 1, '299.00', '299.00'),
(14011, 18003, 19, 6025, 1, '179.00', '179.00'),
(14012, 18004, 20, 6019, 1, '399.00', '399.00'),
(14013, 18004, 20, 6040, 1, '169.00', '169.00'),
(14014, 18004, 20, 6045, 2, '199.00', '398.00'),
(14015, 18004, 20, 6047, 1, '149.00', '149.00'),
(14016, 18005, 21, 6012, 1, '349.00', '349.00'),
(14017, 18005, 21, 6020, 1, '149.00', '149.00'),
(14018, 18005, 21, 6027, 1, '149.00', '149.00'),
(14019, 18005, 21, 6044, 2, '179.00', '358.00'),
(14020, 18006, 22, 6011, 1, '349.00', '349.00'),
(14021, 18006, 22, 6012, 2, '349.00', '698.00'),
(14026, 18008, 24, 6022, 5, '179.00', '895.00'),
(14027, 18008, 24, 6009, 1, '299.00', '299.00'),
(14028, 18009, 25, 6024, 1, '129.00', '129.00'),
(14029, 18009, 25, 6027, 1, '149.00', '149.00'),
(14030, 18010, 26, 6008, 3, '199.00', '597.00'),
(14031, 18011, 30, 6009, 1, '299.00', '299.00'),
(14032, 18012, 31, 6011, 1, '349.00', '349.00'),
(14033, 18012, 31, 6012, 2, '349.00', '698.00');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `reviewID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `fullName` varchar(100) NOT NULL,
  `mobileNo` varchar(15) NOT NULL,
  `review` text NOT NULL,
  `reviewDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`reviewID`, `userID`, `fullName`, `mobileNo`, `review`, `reviewDate`) VALUES
(23, 18, 'Fatima', '9987645233', 'The Food was so much delicious its my 4th time having lunch in this cafe, the service was 10/10 and the environment of this cafe was also good 1 thing i loved about this cafe was the qr code cafe food ordering system which was a unique concept in india. overall it was 10/10 experience', '2025-03-25 10:03:26'),
(24, 19, 'Aaryan', '8142672323', 'I came in this cafe for the first time and the unique thing was it has a qr code cafe ordering system. this food ordering system is totally contact less like i dont have to wait and call the waiter and place order. i can simply just scan the qr and placed the order this was very Smooth Experience....!!!!!!!!', '2025-03-25 10:08:48'),
(25, 20, 'Ahmed Raza', '9228744494', 'QR Cafe is a simple yet efficient food ordering system designed for cafes. It streamlines the ordering process, offering easy menu browsing, order management, and admin controls. With a user-friendly interface and database-driven functionality, it enhances the dine-in experience.', '2025-03-25 10:13:02'),
(27, 26, 'Mohammad Kais', '9313433993', 'Great experience !!!', '2025-03-26 04:55:04');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobileNo` varchar(15) NOT NULL,
  `tableORsitting` varchar(50) NOT NULL,
  `orderType` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `fullName`, `email`, `mobileNo`, `tableORsitting`, `orderType`) VALUES
(17, 'Kais', 'kais123@gmail.com', '9192762522', 'Table-1', 'Dine-In'),
(18, 'Fatima', 'fatima2244@gmail.com', '9987645233', 'Table-4', 'Dine-In'),
(19, 'Aaryan', 'aaryan72@gmail.com', '8142672323', 'Sitting-2', 'Takeaway'),
(20, 'Ahmed Raza', 'raza69@gmail.com', '9228744494', 'Table-6', 'Dine-In'),
(21, 'Dhwani', 'dhwani91@gmail.com', '8539056156', 'Sitting-5', 'Takeaway'),
(22, 'Sahil', 'sahil121@gmail.com', '8546723156', 'Sitting-4', 'Takeaway'),
(23, 'Prakriti', 'prakritiiiii@gmail.com', '9134457232', 'Sitting-3', 'Takeaway'),
(24, 'Yogesh', 'yogesh123@gmail.com', '9867452227', 'Sitting-2', 'Takeaway'),
(25, 'Maitri', 'maitri445@gmail.com', '9986544453', 'Sitting-3', 'Takeaway'),
(26, 'Mohammad Kais', 'kais22334@gmail.com', '9313433993', 'Table-4', 'Dine-In'),
(27, 'mahi', 'mahi123@gmail.com', '9878987564', 'Sitting-4', 'Takeaway'),
(29, 'Salman', 'salman@gmail.com', '9096723156', 'Sitting-3', 'Takeaway'),
(30, 'Hrittik', 'hrittik22@gmail.com', '9095457232', 'Table-3', 'Dine-In'),
(31, 'Adil', 'adil11@gmail.com', '9985634242', 'Sitting-3', 'Takeaway');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `AdminEmail` (`AdminEmail`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `FoodID` (`FoodID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`FoodID`),
  ADD KEY `FoodCategory` (`FoodCategory`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`OrderItemsID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `FoodID` (`FoodID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewID`),
  ADD KEY `fk_user` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1020;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `FoodID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6051;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18013;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `OrderItemsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14034;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`FoodID`) REFERENCES `food` (`FoodID`);

--
-- Constraints for table `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `food_ibfk_1` FOREIGN KEY (`FoodCategory`) REFERENCES `category` (`CategoryID`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`FoodID`) REFERENCES `food` (`FoodID`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
