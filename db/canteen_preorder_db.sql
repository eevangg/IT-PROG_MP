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
  `category` ENUM('Breakfast', 'Lunch', 'Snack') NULL DEFAULT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `status` ENUM('active', 'inactive') NULL DEFAULT 'active',
  PRIMARY KEY (`item_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_general_ci;

-- -----------------------------------------------------
-- Sample Data for `menu_items`
-- -----------------------------------------------------
INSERT INTO `menu_items` (`item_name`, `category`, `price`, `description`, `status`) VALUES
('Pancake Meal', 'Breakfast', 50.00, 'Fluffy pancakes with syrup', 'active'),
('Chicken Adobo', 'Lunch', 85.00, 'Classic Filipino dish with rice', 'active'),
('Tuna Sandwich', 'Snack', 40.00, 'Freshly made tuna sandwich', 'active');


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
(3, 'order', -5, NOW());


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
(3, 'Wednesday', '2025-10-20', 10, 'available');


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
('jason123', 'password123', 'Jason Dela Cruz', 'jason@example.com', 'student', 500.00, 'active'),
('anna_smith', 'pass456', 'Anna Smith', 'anna@example.com', 'staff', 800.00, 'active'),
('admin', 'adminpass', 'System Admin', 'admin@example.com', 'admin', 0.00, 'active');


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
(1, 1, 50.00, 'wallet', '08:30:00', 'completed'),
(2, 2, 85.00, 'cash', '12:15:00', 'confirmed'),
(1, 3, 40.00, 'qr', '15:00:00', 'pending');


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
(1, 1, 1, 50.00),
(2, 2, 1, 85.00),
(3, 3, 1, 40.00);


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
(1, 'wallet', 50.00, 'paid'),
(2, 'cash', 85.00, 'paid'),
(3, 'qr', 40.00, 'pending');


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
