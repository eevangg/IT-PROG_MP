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
  `image` VARCHAR(500) NULL DEFAULT NULL,
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

UPDATE menu_items
SET image = CASE item_id
    WHEN 4 THEN 'hhttps://www.marthastewart.com/thmb/Vgb9cQSlegZz5fcoSbkkqyHPmHY=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/338185-basic-pancakes-09-00b18f8418fd4e52bb2050173d083d04.jpg'
    WHEN 5 THEN 'https://www.seriouseats.com/thmb/uc8nb040OwgXekR9obuhEqm8WoI=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/__opt__aboutcom__coeus__resources__content_migration__serious_eats__seriouseats.com__2019__10__20191023-chicken-adobo-vicky-wasik-19-12ce105a2e1a44dfb1e2673775118064.jpg'
    WHEN 6 THEN 'https://cdn6.projectmealplan.com/wp-content/uploads/2021/07/lazy-no-chop-tuna-salad-hero-side-scaled.jpg'
    WHEN 7 THEN 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ6QWGUhvMK40QEIf4SuAEtLJHYZwXovJokZA&s'
    WHEN 8 THEN 'https://www.kawalingpinoy.com/wp-content/uploads/2016/01/filipino-beef-tapa-7.jpg'
    WHEN 9 THEN 'https://panlasangpinoy.com/wp-content/uploads/2022/09/pork-sinigang-panlasang-pinoy.jpg'
    WHEN 10 THEN 'https://www.nestlegoodnes.com/ph/sites/default/files/srh_recipes/fb57f76d3cd9b83f1509f030c7024b51.jpg'
    WHEN 11 THEN 'https://www.nestlegoodnes.com/ph/sites/default/files/styles/1_1_768px_width/public/srh_recipes/25cf95a942d7253ccb0e43f8b039143f.jpg.webp'
    WHEN 12 THEN 'https://themayakitchen.com/wp-content/uploads/2019/10/TURON-1024x683.jpg'
    WHEN 13 THEN 'https://upload.wikimedia.org/wikipedia/commons/7/7e/Bibingka-6.jpg'
    WHEN 14 THEN 'https://ricelifefoodie.com/wp-content/uploads/2025/06/filipino-halo-halo-mix-mix-dessert-in-a-big-glass-500x500.jpg?crop=1'
    WHEN 15 THEN 'https://i1.wp.com/www.foodwithmae.com/wp-content/uploads/2021/07/sagotgulamandrinkFoodwithMae-1-e1628688120251.jpg?fit=667%2C737&ssl=1'
    WHEN 16 THEN 'https://panlasangpinoy.com/wp-content/uploads/2017/05/Chicken-Arroz-Caldo-2-500x500.jpg'
    WHEN 17 THEN 'https://cdn.sanity.io/images/f3knbc2s/production/b5318405e36335e00e82b10ffcf7b439fff513af-2500x1600.jpg?auto=format'
    WHEN 18 THEN 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1e/EGGPLANT_TORTA.jpg/1200px-EGGPLANT_TORTA.jpg'
    WHEN 19 THEN 'https://www.kawalingpinoy.com/wp-content/uploads/2019/05/laing-9-500x500.jpg'
    WHEN 20 THEN 'https://yummyfood.ph/wp-content/uploads/2021/08/Chicken-Adobo-Recipe-1.jpg'
    WHEN 21 THEN 'https://upload.wikimedia.org/wikipedia/commons/d/d7/Authentic_Kapampangan_Sisig.jpg'
    WHEN 22 THEN 'https://pilipinasrecipes.com/wp-content/uploads/2017/08/Kare-Kare-Recipe.jpg'
    WHEN 23 THEN 'https://www.nestlegoodnes.com/ph/sites/default/files/styles/1_1_768px_width/public/srh_recipes/cc4a6bd562aaede4f83cbf6415965691.jpg.webp'
    WHEN 24 THEN 'https://www.simplyrecipes.com/thmb/TL9sgDRkhyiU9ed6nPfoFEoOKrA=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/Simply-Recipes-Macaroni-Chicken-Sopas-LEAD-03-8cd1732ce3dd4417b4310ddae8dc2ca0.jpg'
    WHEN 25 THEN 'https://assets.unileversolutions.com/recipes-v2/110752.jpg'
    WHEN 26 THEN 'https://www.foxyfolksy.com/wp-content/uploads/2021/07/goto-recipe.jpg'
    WHEN 27 THEN 'https://cdn.sanity.io/images/f3knbc2s/production/20d7a65b5be8b1b90dac5995c0265fea7a3798be-2500x1500.jpg?auto=format'
    WHEN 28 THEN 'https://yummykitchentv.com/wp-content/uploads/2021/05/puto-cheese-without-eggs.jpg'
    WHEN 29 THEN 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRupEQNw-TluStsLqcJ3skM0AVle8nH-_HAWQ&s'
    WHEN 30 THEN 'https://yummykitchentv.com/wp-content/uploads/2023/08/champorado-recipe.jpg'
    WHEN 31 THEN 'https://www.foxyfolksy.com/wp-content/uploads/2017/05/taho-recipe-640-500x500.jpg'
    WHEN 32 THEN 'https://i0.wp.com/www.russianfilipinokitchen.com/wp-content/uploads/2015/04/crispy-fried-calamari-01.jpg'
    WHEN 33 THEN 'https://assets.epicurious.com/photos/5b9147b3f2a7a12d4192d0a5/1:1/w_2560%2Cc_limit/inihaw-bbq-chicken-skewers-090418.jpg'
    WHEN 34 THEN 'https://pinoybites.com/wp-content/uploads/2020/06/Snapseed-52-scaled.jpg'
    WHEN 35 THEN 'https://i2.wp.com/www.foodwithmae.com/wp-content/uploads/2019/01/BeefBulaloMaeRecipe.jpg?fit=2548%2C2506&ssl=1'
    WHEN 36 THEN 'https://www.kawalingpinoy.com/wp-content/uploads/2018/07/ginisang-munggo-chicharon-5.jpg'
    WHEN 37 THEN 'https://www.seriouseats.com/thmb/BHTueEcNShZmWVlwc4_VVmhfLYs=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/20210712-pinakbet-vicky-wasik-seriouseats-12-37ac6b9ea57145728de86f927dc5fef6.jpg'
    WHEN 38 THEN 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRv5kCgLz2w16AgoLGr5IYbMOBkYAMkLO__Dg&s'
    WHEN 39 THEN 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR08DfYetJEU-nHRoqNESRDOT2DLb1tBWABZA&s'
    WHEN 40 THEN 'https://assets.unileversolutions.com/recipes-v2/214409.png'
    WHEN 41 THEN 'https://panlasangpinoy.com/wp-content/uploads/2021/08/Pinoy-Style-Chicken-Curry-jpg.webp'
    WHEN 42 THEN 'https://www.marionskitchen.com/wp-content/uploads/2022/12/Filipino-Spaghetti-01-1200x1500.jpg'
    WHEN 43 THEN 'https://kitchenconfidante.com/wp-content/uploads/2021/01/Pancit-Palabok-kitchenconfidante.com-2868-FEATURED-IMAGE.jpg'
    WHEN 44 THEN 'https://thefatbutcherph.com/cdn/shop/articles/Untitled_2cf98e1c-d858-4a03-afab-123344145030.jpg?v=1755828196'
    WHEN 45 THEN 'https://www.kawalingpinoy.com/wp-content/uploads/2020/07/siopao-asado-4.jpg'
    WHEN 46 THEN 'https://cdn.loveandlemons.com/wp-content/uploads/2025/05/iced-coffee.jpg'
    WHEN 47 THEN 'https://shopmetro.ph/lapulapu-supermarket/wp-content/uploads/2025/06/SM2071671-1-6.webp'
    WHEN 48 THEN 'https://cdn.shortpixel.ai/spai/q_lossy+ret_img+to_webp/salangikopu.com/wp-content/uploads/2020/09/Coca-Cola-Coke-Mismo-295ml-Main.png'
    WHEN 49 THEN 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcScnMYpAXdL19uHDohOhQRpisO1VG_sGAxvSw&s'
    WHEN 50 THEN 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/76/Mais_con_yelo.jpg/250px-Mais_con_yelo.jpg'
    WHEN 51 THEN 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTGRQhsPWEZpnzeSUUUvd2Eal5mFTnIHYt2PQ&s'
    WHEN 52 THEN 'https://panlasangpinoy.com/wp-content/uploads/2010/04/ginataang-mais-corn-in-coconut-milk-recipe.jpg'
    WHEN 53 THEN 'https://kusinasecrets.com/wp-content/uploads/2025/06/u3317447599_Longsilog_on_white_ceramic_plate_golden_crispy_lo_8944ae52-3a4c-4587-916e-1d0d11aa2d64_0-500x500.jpg'
    WHEN 54 THEN 'https://panlasangpinoy.com/wp-content/uploads/2017/07/Hotdog-Sinangag-at-Itlog.jpg'
    WHEN 55 THEN 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSmPWLOaBk-ThI7LjueKnQ5ioSfiE1ntuWuPw&s'
END
WHERE item_id IN (4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55);
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
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (9, 'Monday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (4, 'Monday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (52, 'Monday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (19, 'Monday', '2025-11-24', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (18, 'Monday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (38, 'Monday', '2025-11-24', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (8, 'Monday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (33, 'Monday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (15, 'Monday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (12, 'Monday', '2025-11-24', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (28, 'Monday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (24, 'Monday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (6, 'Monday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (43, 'Monday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (50, 'Monday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (44, 'Monday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (9, 'Tuesday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (53, 'Tuesday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (4, 'Tuesday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (33, 'Tuesday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (40, 'Tuesday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (19, 'Tuesday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (34, 'Tuesday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (5, 'Tuesday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (41, 'Tuesday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (15, 'Tuesday', '2025-11-24', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (49, 'Tuesday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (24, 'Tuesday', '2025-11-24', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (11, 'Tuesday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (47, 'Tuesday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (45, 'Tuesday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (50, 'Tuesday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (23, 'Wednesday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (27, 'Wednesday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (52, 'Wednesday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (8, 'Wednesday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (16, 'Wednesday', '2025-11-24', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (18, 'Wednesday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (40, 'Wednesday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (37, 'Wednesday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (31, 'Wednesday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (26, 'Wednesday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (41, 'Wednesday', '2025-11-24', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (29, 'Wednesday', '2025-11-24', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (30, 'Wednesday', '2025-11-24', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (47, 'Wednesday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (44, 'Wednesday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (45, 'Wednesday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (23, 'Thursday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (27, 'Thursday', '2025-11-24', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (52, 'Thursday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (35, 'Thursday', '2025-11-24', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (34, 'Thursday', '2025-11-24', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (33, 'Thursday', '2025-11-24', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (10, 'Thursday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (8, 'Thursday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (49, 'Thursday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (42, 'Thursday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (11, 'Thursday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (31, 'Thursday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (6, 'Thursday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (50, 'Thursday', '2025-11-24', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (43, 'Thursday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (44, 'Thursday', '2025-11-24', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (4, 'Friday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (27, 'Friday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (54, 'Friday', '2025-11-24', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (16, 'Friday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (38, 'Friday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (10, 'Friday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (35, 'Friday', '2025-11-24', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (32, 'Friday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (28, 'Friday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (24, 'Friday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (12, 'Friday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (22, 'Friday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (31, 'Friday', '2025-11-24', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (44, 'Friday', '2025-11-24', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (47, 'Friday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (48, 'Friday', '2025-11-24', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (54, 'Monday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (13, 'Monday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (55, 'Monday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (38, 'Monday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (35, 'Monday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (17, 'Monday', '2025-12-01', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (36, 'Monday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (19, 'Monday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (24, 'Monday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (28, 'Monday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (49, 'Monday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (29, 'Monday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (39, 'Monday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (45, 'Monday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (46, 'Monday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (47, 'Monday', '2025-12-01', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (9, 'Tuesday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (23, 'Tuesday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (13, 'Tuesday', '2025-12-01', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (37, 'Tuesday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (17, 'Tuesday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (14, 'Tuesday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (33, 'Tuesday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (20, 'Tuesday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (42, 'Tuesday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (25, 'Tuesday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (31, 'Tuesday', '2025-12-01', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (49, 'Tuesday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (41, 'Tuesday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (46, 'Tuesday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (44, 'Tuesday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (43, 'Tuesday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (13, 'Wednesday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (53, 'Wednesday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (9, 'Wednesday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (19, 'Wednesday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (36, 'Wednesday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (18, 'Wednesday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (35, 'Wednesday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (7, 'Wednesday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (41, 'Wednesday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (15, 'Wednesday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (6, 'Wednesday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (29, 'Wednesday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (26, 'Wednesday', '2025-12-01', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (50, 'Wednesday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (43, 'Wednesday', '2025-12-01', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (48, 'Wednesday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (55, 'Thursday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (54, 'Thursday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (9, 'Thursday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (17, 'Thursday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (20, 'Thursday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (40, 'Thursday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (5, 'Thursday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (38, 'Thursday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (11, 'Thursday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (29, 'Thursday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (6, 'Thursday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (41, 'Thursday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (28, 'Thursday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (46, 'Thursday', '2025-12-01', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (47, 'Thursday', '2025-12-01', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (48, 'Thursday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (52, 'Friday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (23, 'Friday', '2025-12-01', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (13, 'Friday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (34, 'Friday', '2025-12-01', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (14, 'Friday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (20, 'Friday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (18, 'Friday', '2025-12-01', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (16, 'Friday', '2025-12-01', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (12, 'Friday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (6, 'Friday', '2025-12-01', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (25, 'Friday', '2025-12-01', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (28, 'Friday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (39, 'Friday', '2025-12-01', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (43, 'Friday', '2025-12-01', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (50, 'Friday', '2025-12-01', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (47, 'Friday', '2025-12-01', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (9, 'Monday', '2025-12-08', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (55, 'Monday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (52, 'Monday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (40, 'Monday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (14, 'Monday', '2025-12-08', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (19, 'Monday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (38, 'Monday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (20, 'Monday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (24, 'Monday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (29, 'Monday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (15, 'Monday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (42, 'Monday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (39, 'Monday', '2025-12-08', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (50, 'Monday', '2025-12-08', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (45, 'Monday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (47, 'Monday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (9, 'Tuesday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (13, 'Tuesday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (27, 'Tuesday', '2025-12-08', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (7, 'Tuesday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (33, 'Tuesday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (14, 'Tuesday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (17, 'Tuesday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (8, 'Tuesday', '2025-12-08', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (11, 'Tuesday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (28, 'Tuesday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (22, 'Tuesday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (31, 'Tuesday', '2025-12-08', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (6, 'Tuesday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (45, 'Tuesday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (44, 'Tuesday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (48, 'Tuesday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (53, 'Wednesday', '2025-12-08', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (4, 'Wednesday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (55, 'Wednesday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (37, 'Wednesday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (18, 'Wednesday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (17, 'Wednesday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (35, 'Wednesday', '2025-12-08', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (38, 'Wednesday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (30, 'Wednesday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (28, 'Wednesday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (39, 'Wednesday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (31, 'Wednesday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (15, 'Wednesday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (44, 'Wednesday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (43, 'Wednesday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (50, 'Wednesday', '2025-12-08', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (52, 'Thursday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (55, 'Thursday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (23, 'Thursday', '2025-12-08', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (38, 'Thursday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (10, 'Thursday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (34, 'Thursday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (36, 'Thursday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (20, 'Thursday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (24, 'Thursday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (26, 'Thursday', '2025-12-08', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (6, 'Thursday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (30, 'Thursday', '2025-12-08', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (49, 'Thursday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (43, 'Thursday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (47, 'Thursday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (48, 'Thursday', '2025-12-08', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (53, 'Friday', '2025-12-08', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (13, 'Friday', '2025-12-08', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (27, 'Friday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (20, 'Friday', '2025-12-08', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (34, 'Friday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (5, 'Friday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (14, 'Friday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (36, 'Friday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (24, 'Friday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (39, 'Friday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (31, 'Friday', '2025-12-08', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (28, 'Friday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (42, 'Friday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (48, 'Friday', '2025-12-08', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (45, 'Friday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (46, 'Friday', '2025-12-08', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (23, 'Monday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (54, 'Monday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (27, 'Monday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (8, 'Monday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (36, 'Monday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (35, 'Monday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (38, 'Monday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (32, 'Monday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (24, 'Monday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (31, 'Monday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (25, 'Monday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (49, 'Monday', '2025-12-15', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (15, 'Monday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (44, 'Monday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (48, 'Monday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (43, 'Monday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (54, 'Tuesday', '2025-12-15', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (55, 'Tuesday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (13, 'Tuesday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (18, 'Tuesday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (19, 'Tuesday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (37, 'Tuesday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (32, 'Tuesday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (10, 'Tuesday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (26, 'Tuesday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (41, 'Tuesday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (11, 'Tuesday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (30, 'Tuesday', '2025-12-15', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (21, 'Tuesday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (44, 'Tuesday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (45, 'Tuesday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (48, 'Tuesday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (53, 'Wednesday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (55, 'Wednesday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (54, 'Wednesday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (5, 'Wednesday', '2025-12-15', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (34, 'Wednesday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (37, 'Wednesday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (40, 'Wednesday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (16, 'Wednesday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (28, 'Wednesday', '2025-12-15', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (31, 'Wednesday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (39, 'Wednesday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (41, 'Wednesday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (24, 'Wednesday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (47, 'Wednesday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (48, 'Wednesday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (50, 'Wednesday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (9, 'Thursday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (53, 'Thursday', '2025-12-15', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (55, 'Thursday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (36, 'Thursday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (16, 'Thursday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (7, 'Thursday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (14, 'Thursday', '2025-12-15', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (17, 'Thursday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (29, 'Thursday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (24, 'Thursday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (25, 'Thursday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (22, 'Thursday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (39, 'Thursday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (50, 'Thursday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (46, 'Thursday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (45, 'Thursday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (13, 'Friday', '2025-12-15', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (54, 'Friday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (52, 'Friday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (10, 'Friday', '2025-12-15', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (17, 'Friday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (36, 'Friday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (33, 'Friday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (14, 'Friday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (30, 'Friday', '2025-12-15', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (22, 'Friday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (28, 'Friday', '2025-12-15', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (41, 'Friday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (49, 'Friday', '2025-12-15', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (48, 'Friday', '2025-12-15', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (43, 'Friday', '2025-12-15', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (44, 'Friday', '2025-12-15', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (9, 'Monday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (52, 'Monday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (4, 'Monday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (35, 'Monday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (37, 'Monday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (10, 'Monday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (17, 'Monday', '2025-12-22', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (16, 'Monday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (41, 'Monday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (21, 'Monday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (24, 'Monday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (12, 'Monday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (30, 'Monday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (47, 'Monday', '2025-12-22', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (48, 'Monday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (45, 'Monday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (13, 'Tuesday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (54, 'Tuesday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (9, 'Tuesday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (33, 'Tuesday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (19, 'Tuesday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (32, 'Tuesday', '2025-12-22', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (14, 'Tuesday', '2025-12-22', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (20, 'Tuesday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (26, 'Tuesday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (6, 'Tuesday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (49, 'Tuesday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (15, 'Tuesday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (11, 'Tuesday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (44, 'Tuesday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (48, 'Tuesday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (46, 'Tuesday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (55, 'Wednesday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (52, 'Wednesday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (13, 'Wednesday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (36, 'Wednesday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (19, 'Wednesday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (20, 'Wednesday', '2025-12-22', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (14, 'Wednesday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (10, 'Wednesday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (15, 'Wednesday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (24, 'Wednesday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (22, 'Wednesday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (11, 'Wednesday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (30, 'Wednesday', '2025-12-22', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (47, 'Wednesday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (48, 'Wednesday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (44, 'Wednesday', '2025-12-22', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (4, 'Thursday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (27, 'Thursday', '2025-12-22', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (52, 'Thursday', '2025-12-22', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (14, 'Thursday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (37, 'Thursday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (10, 'Thursday', '2025-12-22', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (35, 'Thursday', '2025-12-22', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (5, 'Thursday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (28, 'Thursday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (42, 'Thursday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (25, 'Thursday', '2025-12-22', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (41, 'Thursday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (22, 'Thursday', '2025-12-22', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (44, 'Thursday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (43, 'Thursday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (45, 'Thursday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (54, 'Friday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (55, 'Friday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (13, 'Friday', '2025-12-22', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (35, 'Friday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (20, 'Friday', '2025-12-22', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (7, 'Friday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (38, 'Friday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (33, 'Friday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (15, 'Friday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (24, 'Friday', '2025-12-22', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (29, 'Friday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (49, 'Friday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (21, 'Friday', '2025-12-22', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (48, 'Friday', '2025-12-22', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (43, 'Friday', '2025-12-22', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (44, 'Friday', '2025-12-22', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (27, 'Monday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (23, 'Monday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (54, 'Monday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (10, 'Monday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (18, 'Monday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (14, 'Monday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (36, 'Monday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (37, 'Monday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (21, 'Monday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (12, 'Monday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (6, 'Monday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (42, 'Monday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (31, 'Monday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (45, 'Monday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (47, 'Monday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (48, 'Monday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (23, 'Tuesday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (4, 'Tuesday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (53, 'Tuesday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (19, 'Tuesday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (7, 'Tuesday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (16, 'Tuesday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (18, 'Tuesday', '2025-12-29', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (40, 'Tuesday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (41, 'Tuesday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (26, 'Tuesday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (12, 'Tuesday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (28, 'Tuesday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (24, 'Tuesday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (48, 'Tuesday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (46, 'Tuesday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (43, 'Tuesday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (27, 'Wednesday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (52, 'Wednesday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (4, 'Wednesday', '2025-12-29', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (34, 'Wednesday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (38, 'Wednesday', '2025-12-29', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (5, 'Wednesday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (32, 'Wednesday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (35, 'Wednesday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (41, 'Wednesday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (39, 'Wednesday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (6, 'Wednesday', '2025-12-29', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (15, 'Wednesday', '2025-12-29', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (26, 'Wednesday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (45, 'Wednesday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (47, 'Wednesday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (46, 'Wednesday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (23, 'Thursday', '2025-12-29', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (9, 'Thursday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (55, 'Thursday', '2025-12-29', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (10, 'Thursday', '2025-12-29', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (14, 'Thursday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (37, 'Thursday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (36, 'Thursday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (33, 'Thursday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (28, 'Thursday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (26, 'Thursday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (24, 'Thursday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (39, 'Thursday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (25, 'Thursday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (46, 'Thursday', '2025-12-29', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (44, 'Thursday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (50, 'Thursday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (52, 'Friday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (55, 'Friday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (27, 'Friday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (40, 'Friday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (34, 'Friday', '2025-12-29', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (36, 'Friday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (37, 'Friday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (16, 'Friday', '2025-12-29', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (24, 'Friday', '2025-12-29', 4, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (25, 'Friday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (28, 'Friday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (49, 'Friday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (15, 'Friday', '2025-12-29', 5, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (50, 'Friday', '2025-12-29', 2, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (46, 'Friday', '2025-12-29', 3, 'available');
INSERT INTO meal_plans (item_id, day_of_week, week_start, available_qty, status) VALUES (43, 'Friday', '2025-12-29', 5, 'available');


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
(1, 4, 1, 50.00),

-- Order 2: Jason (₱90) — Pancake (50) + Tuna (40)
(2, 4, 1, 50.00),
(2, 6, 1, 40.00),

-- Order 3: Anna (₱85)
(3, 5, 1, 85.00),

-- Order 4: Anna (₱40)
(4, 6, 1, 40.00),

-- Order 5: Admin (₱120) — Adobo x1 + Pancake x1 + Sandwich x1
(5, 5, 1, 85.00),
(5, 4, 1, 50.00),
(5, 6, 1, 40.00),

-- Order 6: Admin (₱50)
(6, 4, 1, 50.00);


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
  `cart_item_id` INT(11) NOT NULL AUTO_INCREMENT,
  `cart_id` INT(11) NOT NULL,
  `plan_id` INT(11) NOT NULL,
  `item_id` INT(11) NOT NULL,
  `quantity` INT(11) NOT NULL DEFAULT 1,
  `subtotal` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`cart_item_id`),
  INDEX `cart_id` (`cart_id` ASC),
  INDEX `item_id` (`item_id` ASC),
  INDEX `fk_cart_items_meal_plans1_idx` (`plan_id` ASC),
  CONSTRAINT `cart_items_ibfk_1`
    FOREIGN KEY (`cart_id`)
    REFERENCES `canteen_preorder_db`.`cart` (`cart_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `cart_items_ibfk_2`
    FOREIGN KEY (`item_id`)
    REFERENCES `canteen_preorder_db`.`menu_items` (`item_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_cart_items_meal_plans1`
    FOREIGN KEY (`plan_id`)
    REFERENCES `canteen_preorder_db`.`meal_plans` (`plan_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_general_ci;

-- -----------------------------------------------------
-- Sample Data for `cart_items`
-- -----------------------------------------------------
INSERT INTO `cart_items` (`cart_id`, `plan_id`, `item_id`, `quantity`, `subtotal`) VALUES
(1, 8, 4, 2, 100.00),
(1, 29, 6, 1, 40.00),
(2, 40,  5, 1, 85.00),

(1, 40, 5, 1, 70.00),
(1, 52, 8, 2, 70.00),
(1, 91, 12, 1, 25.00),

(2, 91, 12, 1, 25.00),
(2, 85, 38, 1, 35.00),
(2, 111, 46, 2, 50.00),

(3, 42, 15, 1, 95.00),
(3, 8, 4, 1, 55.00),
(3, 60, 29, 1, 120.00);

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
