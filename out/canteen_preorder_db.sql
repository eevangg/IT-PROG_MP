-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema canteen_preorder_db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema canteen_preorder_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `canteen_preorder_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ;
USE `canteen_preorder_db` ;

-- -----------------------------------------------------
-- Table `canteen_preorder_db`.`menu_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `canteen_preorder_db`.`menu_items` (
  `item_id` INT NOT NULL AUTO_INCREMENT,
  `item_name` VARCHAR(100) NOT NULL,
  `category` ENUM('Breakfast', 'Lunch', 'Snack', 'Beverage') NULL DEFAULT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `stock` INT NOT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `image` VARCHAR(100) NULL DEFAULT NULL,
  `status` ENUM('active', 'inactive') NULL DEFAULT 'active',
  PRIMARY KEY (`item_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_general_ci;

-- -----------------------------------------------------
-- Sample Data for `menu_items`
-- -----------------------------------------------------
INSERT INTO `menu_items` (`item_name`, `category`, `price`, `stock`, `description`, `status`) VALUES
('Pancake Meal', 'Breakfast', 50.00, 15, 'Fluffy pancakes with syrup', 'active'),
('Chicken Adobo', 'Lunch', 85.00, 20, 'Classic Filipino dish with rice', 'active'),
('Tuna Sandwich', 'Snack', 40.00, 25, 'Freshly made tuna sandwich', 'active'),
('Pancit Canton', 'Lunch', 55.00, 25, 'Stir-fried noodles with vegetables and meat', 'active'),
('Beef Tapa Meal', 'Breakfast', 70.00, 20, 'Beef tapa with garlic rice and egg', 'active'),
('Pork Sinigang', 'Lunch', 90.00, 18, 'Tamarind-based soup with pork and vegetables', 'active'),
('Chicken Inasal', 'Lunch', 85.00, 22, 'Grilled chicken marinated in calamansi and spices', 'active'),
('Lumpiang Shanghai', 'Snack', 35.00, 50, 'Fried spring rolls with pork filling', 'active'),
('Turon', 'Snack', 20.00, 30, 'Banana with sugar wrapped in lumpia wrapper', 'active'),
('Bibingka', 'Snack', 45.00, 18, 'Rice cake with cheese and salted egg', 'active'),
('Halo-Halo', 'Beverage', 60.00, 25, 'Shaved ice dessert with mixed ingredients', 'active'),
('Sago Gulaman', 'Beverage', 25.00, 40, 'Sweet drink with tapioca pearls and jelly', 'active'),
('Chicken Arroz Caldo', 'Breakfast', 50.00, 20, 'Ginger rice porridge with chicken and egg', 'active'),
('Bistek Tagalog', 'Lunch', 95.00, 15, 'Soy-calamansi beef with onions', 'active'),
('Tortang Talong', 'Snack', 40.00, 22, 'Grilled eggplant omelette', 'active'),
('Laing', 'Lunch', 70.00, 18, 'Taro leaves cooked in coconut milk', 'active'),
('Adobong Manok', 'Lunch', 85.00, 24, 'Chicken adobo in soy-vinegar sauce', 'active'),
('Pork Sisig', 'Lunch', 95.00, 20, 'Crispy minced pork sizzling dish', 'active'),
('Kare-Kare', 'Lunch', 110.00, 14, 'Peanut stew with vegetables and meat', 'active'),
('Sinigang na Hipon', 'Lunch', 100.00, 12, 'Shrimp in sour soup with vegetables', 'active'),
('Chicken Sopas', 'Snack', 45.00, 30, 'Creamy macaroni chicken soup', 'active'),
('Batchoy', 'Snack', 55.00, 22, 'Hot noodle soup with pork and egg', 'active'),
('Goto', 'Breakfast', 40.00, 28, 'Rice porridge with tripe and egg', 'active'),
('Tokwa’t Baboy', 'Snack', 50.00, 20, 'Fried tofu with pork and soy-vinegar sauce', 'active'),
('Puto Cheese', 'Snack', 15.00, 40, 'Steamed rice cake topped with cheese', 'active'),
('Kutsinta', 'Snack', 12.00, 35, 'Sticky brown rice cake with grated coconut', 'active'),
('Champorado', 'Breakfast', 35.00, 25, 'Chocolate rice porridge with milk', 'active'),
('Taho', 'Snack', 25.00, 40, 'Soft tofu with syrup and pearls', 'active'),
('Calamares', 'Snack', 65.00, 15, 'Battered fried squid rings', 'active'),
('Chicken BBQ Skewer', 'Snack', 30.00, 50, 'Barbecued chicken on stick', 'active'),
('Pork BBQ Skewer', 'Snack', 35.00, 50, 'Barbecued pork on stick', 'active'),
('Bulalo', 'Lunch', 120.00, 10, 'Beef shank soup with vegetables', 'active'),
('Ginisang Monggo', 'Lunch', 55.00, 18, 'Mung bean stew with pork and spinach', 'active'),
('Pinakbet', 'Lunch', 60.00, 22, 'Vegetable stew with bagoong', 'active'),
('Fried Bangus', 'Lunch', 80.00, 20, 'Crispy fried milkfish', 'active'),
('Tinolang Manok', 'Lunch', 75.00, 25, 'Chicken broth with papaya and malunggay', 'active'),
('Pork Menudo', 'Lunch', 85.00, 18, 'Tomato-based pork stew with veggies', 'active'),
('Chicken Curry', 'Lunch', 90.00, 20, 'Filipino-style chicken curry', 'active'),
('Spaghetti Pinoy Style', 'Snack', 45.00, 28, 'Sweet-style Filipino spaghetti', 'active'),
('Pancit Palabok', 'Lunch', 60.00, 20, 'Rice noodles with orange sauce and toppings', 'active'),
('Siomai (4 pcs)', 'Snack', 35.00, 40, 'Steamed pork siomai with seasoning', 'active'),
('Siopao Asado', 'Snack', 45.00, 30, 'Steamed bun with pork asado filling', 'active'),
('Iced Coffee', 'Beverage', 35.00, 30, 'Sweet iced coffee drink', 'active'),
('Royal Softdrink', 'Beverage', 20.00, 50, 'Orange soda bottle', 'active'),
('Coke Mismo', 'Beverage', 20.00, 50, 'Coca-Cola 295ml', 'active'),
('Buko Juice', 'Beverage', 25.00, 35, 'Fresh coconut juice', 'active'),
('Mais Con Yelo', 'Beverage', 55.00, 20, 'Crushed ice with corn and milk', 'active'),
('Banana Cue', 'Snack', 25.00, 40, 'Caramelized fried banana on stick', 'active'),
('Mais Lugaw', 'Breakfast', 30.00, 32, 'Corn porridge served warm', 'active'),
('Longsilog', 'Breakfast', 65.00, 22, 'Longganisa with garlic rice and egg', 'active'),
('Hotsilog', 'Breakfast', 55.00, 25, 'Hotdog with garlic rice and egg', 'active'),
('Tocilog', 'Breakfast', 60.00, 24, 'Tocino with garlic rice and egg', 'active');


-- -----------------------------------------------------
-- Table `canteen_preorder_db`.`inventory_logs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `canteen_preorder_db`.`inventory_logs` (
  `log_id` INT NOT NULL AUTO_INCREMENT,
  `item_id` INT NOT NULL,
  `change_type` ENUM('restock', 'order', 'adjustment') NOT NULL,
  `quantity_changed` INT NOT NULL,
  `log_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  INDEX `item_id` (`item_id` ASC),
  CONSTRAINT `inventory_logs_ibfk_1`
    FOREIGN KEY (`item_id`)
    REFERENCES `canteen_preorder_db`.`menu_items` (`item_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_general_ci;

-- -----------------------------------------------------
-- Sample Data for `inventory_logs`
-- -----------------------------------------------------
INSERT INTO `inventory_logs` (`item_id`, `change_type`, `quantity_changed`, `log_date`) VALUES
(1, 'restock', 30, NOW()),
(2, 'restock', 25, NOW()),
(3, 'order', -5, NOW()),
(1, 'restock', 30, NOW()),
(2, 'restock', 20, NOW()),
(3, 'restock', 20, NOW()),
(5, 'restock', 40, NOW()),
(7, 'adjustment', -2, NOW()),
(10, 'restock', 25, NOW()),
(12, 'order', -3, NOW()),
(15, 'order', -2, NOW()),
(20, 'adjustment', -1, NOW()),
(25, 'restock', 50, NOW()),
(30, 'order', -1, NOW()),
(35, 'restock', 15, NOW()),
(40, 'order', -2, NOW()),
(45, 'adjustment', -3, NOW());


-- -----------------------------------------------------
-- Table `canteen_preorder_db`.`meal_plans`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `canteen_preorder_db`.`meal_plans` (
  `plan_id` INT NOT NULL AUTO_INCREMENT,
  `item_id` INT NOT NULL,
  `day_of_week` ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday') NOT NULL,
  `week_start` DATE NOT NULL,
  `available_qty` INT NULL DEFAULT '0',
  `status` ENUM('available', 'unavailable') NULL DEFAULT 'available',
  PRIMARY KEY (`plan_id`),
  INDEX `item_id` (`item_id` ASC),
  CONSTRAINT `meal_plans_ibfk_1`
    FOREIGN KEY (`item_id`)
    REFERENCES `canteen_preorder_db`.`menu_items` (`item_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_general_ci;

-- -----------------------------------------------------
-- Sample Data for `meal_plans`
-- -----------------------------------------------------
INSERT INTO `meal_plans` (`item_id`, `day_of_week`, `week_start`, `available_qty`, `status`) VALUES
(1, 'Monday', '2025-10-20', 20, 'available'),
(2, 'Tuesday', '2025-10-20', 15, 'available'),
(3, 'Wednesday', '2025-10-20', 10, 'available'),
(2, 'Monday', '2025-11-24', 20, 'available'),
(4, 'Monday', '2025-11-24', 15, 'available'),
(10, 'Tuesday', '2025-11-24', 25, 'available'),
(15, 'Tuesday', '2025-11-24', 18, 'available'),
(20, 'Wednesday', '2025-11-24', 30, 'available'),
(27, 'Wednesday', '2025-11-24', 20, 'available'),
(33, 'Thursday', '2025-11-24', 22, 'available'),
(41, 'Thursday', '2025-11-24', 30, 'available'),
(48, 'Friday', '2025-11-24', 25, 'available'),
(50, 'Friday', '2025-11-24', 20, 'available');


-- -----------------------------------------------------
-- Table `canteen_preorder_db`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `canteen_preorder_db`.`users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NULL DEFAULT NULL,
  `user_type` ENUM('student', 'staff', 'admin') NULL DEFAULT 'student',
  `balance` DECIMAL(10,2) NULL DEFAULT '0.00',
  `date_created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('active', 'inactive') NULL DEFAULT 'active',
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `username` (`username` ASC),
  UNIQUE INDEX `email` (`email` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_general_ci;

-- -----------------------------------------------------
-- Sample Data for `users`
-- -----------------------------------------------------
INSERT INTO `users` (`username`, `password`, `full_name`, `email`, `user_type`, `balance`, `status`) VALUES
('jason123', '$2y$10$RZQVgh0V1SMfcdguFkhYduDfmlFI9DzxCkOEv8vsyPES.ZrQ1qBfu', 'Jason Dela Cruz', 'jason@example.com', 'student', 500.00, 'active'),
('anna_smith', '$2y$10$ZtsnDpNAha37HyXo9GHPA.gd.cLsyPg3.hf8hrLd.bnS4RrGGh.Jm', 'Anna Smith', 'anna@example.com', 'staff', 800.00, 'active'),
('admin', '$2y$10$9nKNc35ugeGlJiOZ78Yhs.QLy6FI0EZb8kc6vhniZDOebZxHt.Lgi', 'System Admin', 'admin@email.com', 'admin', 100.00, 'active');


-- -----------------------------------------------------
-- Table `canteen_preorder_db`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `canteen_preorder_db`.`orders` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `plan_id` INT NULL DEFAULT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `payment_method` ENUM('wallet', 'cash', 'qr', 'card') NULL DEFAULT 'wallet',
  `order_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `pickup_time` TIME NULL DEFAULT NULL,
  `status` ENUM('pending', 'confirmed', 'preparing', 'ready', 'completed', 'cancelled') NULL DEFAULT 'pending',
  PRIMARY KEY (`order_id`),
  INDEX `user_id` (`user_id` ASC),
  INDEX `plan_id` (`plan_id` ASC),
  CONSTRAINT `orders_ibfk_1`
    FOREIGN KEY (`user_id`)
    REFERENCES `canteen_preorder_db`.`users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `orders_ibfk_2`
    FOREIGN KEY (`plan_id`)
    REFERENCES `canteen_preorder_db`.`meal_plans` (`plan_id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_general_ci;

-- -----------------------------------------------------
-- Sample Data for `orders`
-- -----------------------------------------------------
INSERT INTO `orders` (`user_id`, `plan_id`, `total_amount`, `payment_method`, `pickup_time`, `status`) VALUES
-- Jason (user_id = 1)
(1, 1, 50.00, 'wallet', '08:00:00', 'completed'),
(1, 3, 90.00, 'qr', '12:00:00', 'confirmed'),

-- Anna (user_id = 2)
(2, 2, 85.00, 'cash', '11:45:00', 'completed'),
(2, NULL, 40.00, 'wallet', '10:30:00', 'pending'),

-- Admin (user_id = 3)
(3, NULL, 120.00, 'card', '09:15:00', 'ready'),
(3, 1, 50.00, 'qr', '15:30:00', 'cancelled');


-- -----------------------------------------------------
-- Table `canteen_preorder_db`.`order_details`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `canteen_preorder_db`.`order_details` (
  `detail_id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `item_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `subtotal` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`detail_id`),
  INDEX `order_id` (`order_id` ASC),
  INDEX `item_id` (`item_id` ASC),
  CONSTRAINT `order_details_ibfk_1`
    FOREIGN KEY (`order_id`)
    REFERENCES `canteen_preorder_db`.`orders` (`order_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `order_details_ibfk_2`
    FOREIGN KEY (`item_id`)
    REFERENCES `canteen_preorder_db`.`menu_items` (`item_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_general_ci;


-- -----------------------------------------------------
-- Sample Data for `order_details`
-- -----------------------------------------------------
INSERT INTO `order_details` (`order_id`, `item_id`, `quantity`, `subtotal`) VALUES
-- Order 1: Jason (₱50)
(1, 1, 1, 50.00),

-- Order 2: Jason (₱90) — Pancake (50) + Tuna (40)
(2, 1, 1, 50.00),
(2, 3, 1, 40.00),

-- Order 3: Anna (₱85)
(3, 2, 1, 85.00),

-- Order 4: Anna (₱40)
(4, 3, 1, 40.00),

-- Order 5: Admin (₱120) — Adobo x1 + Pancake x1 + Sandwich x1
(5, 2, 1, 85.00),
(5, 1, 1, 50.00),
(5, 3, 1, 40.00),

-- Order 6: Admin (₱50)
(6, 1, 1, 50.00);


-- -----------------------------------------------------
-- Table `canteen_preorder_db`.`payments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `canteen_preorder_db`.`payments` (
  `payment_id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `payment_method` ENUM('wallet', 'cash', 'qr', 'card') NULL DEFAULT 'wallet',
  `amount_paid` DECIMAL(10,2) NOT NULL,
  `payment_status` ENUM('pending', 'paid', 'failed', 'refunded') NULL DEFAULT 'pending',
  `payment_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`payment_id`),
  INDEX `order_id` (`order_id` ASC),
  CONSTRAINT `payments_ibfk_1`
    FOREIGN KEY (`order_id`)
    REFERENCES `canteen_preorder_db`.`orders` (`order_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_general_ci;


-- -----------------------------------------------------
-- Sample Data for `payments`
-- -----------------------------------------------------
INSERT INTO `payments` (`order_id`, `payment_method`, `amount_paid`, `payment_status`) VALUES
-- Order 1: Paid by wallet
(1, 'wallet', 50.00, 'paid'),

-- Order 2: Jason confirmed but not yet paid
(2, 'qr', 90.00, 'pending'),

-- Order 3: Anna cash paid
(3, 'cash', 85.00, 'paid'),

-- Order 4: Wallet pending
(4, 'wallet', 40.00, 'pending'),

-- Order 5: Admin card payment successful
(5, 'card', 120.00, 'paid'),

-- Order 6: QR payment refunded (cancelled order)
(6, 'qr', 50.00, 'refunded');

-- -----------------------------------------------------
-- Table `canteen_preorder_db`.`cart`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `canteen_preorder_db`.`cart` (
  `cart_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cart_id`),
  CONSTRAINT `cart_ibfk_1`
    FOREIGN KEY (`user_id`)
    REFERENCES `canteen_preorder_db`.`users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_general_ci;

-- -----------------------------------------------------
-- Sample Data for `cart`
-- -----------------------------------------------------
INSERT INTO `cart` (`user_id`) VALUES (1), (2), (3);

-- -----------------------------------------------------
-- Table `canteen_preorder_db`.`cart_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `canteen_preorder_db`.`cart_items` (
  `cart_item_id` INT NOT NULL AUTO_INCREMENT,
  `cart_id` INT NOT NULL,
  `item_id` INT NOT NULL,
  `quantity` INT NOT NULL DEFAULT 1,
  `subtotal` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`cart_item_id`),
  INDEX `cart_id` (`cart_id` ASC),
  INDEX `item_id` (`item_id` ASC),
  CONSTRAINT `cart_items_ibfk_1`
    FOREIGN KEY (`cart_id`)
    REFERENCES `canteen_preorder_db`.`cart` (`cart_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `cart_items_ibfk_2`
    FOREIGN KEY (`item_id`)
    REFERENCES `canteen_preorder_db`.`menu_items` (`item_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_general_ci;

-- -----------------------------------------------------
-- Sample Data for `cart_items`
-- -----------------------------------------------------
INSERT INTO `cart_items` (`cart_id`, `item_id`, `quantity`, `subtotal`) VALUES
(1, 1, 2, 100.00),
(1, 3, 1, 40.00),
(2, 2, 1, 85.00),

(1, 2, 1, 70.00),
(1, 5, 2, 70.00),
(1, 9, 1, 25.00),

(2, 12, 1, 40.00),
(2, 38, 1, 35.00),
(2, 46, 2, 50.00),

(3, 15, 1, 95.00),
(3, 1, 1, 55.00),
(3, 29, 1, 120.00);

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
