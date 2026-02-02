![Course](https://img.shields.io/badge/Course-IT--PROG-lightblue)
![Institution](https://img.shields.io/badge/Institution-De%20La%20Salle%20University-green)
![Project Type](https://img.shields.io/badge/Project-Type%3A%20Machine%20Project-lightgrey)
![Technologies](https://img.shields.io/badge/Technologies-PHP%2C%20MySQL%2C%20HTML%2FCSS-blueviolet)
![Group Name](https://img.shields.io/badge/Group-ArcherInnov-orange)

![PHP](https://img.shields.io/badge/PHP-v8.0%2B-8892BF?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-v8.0-blue?logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-%3E%3D5-E34F26?logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-%3E%3D3-1572B6?logo=css3&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-v5-purple?logo=bootstrap&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-yellow?logo=javascript&logoColor=black)
![jQuery](https://img.shields.io/badge/jQuery-v3.6-blue?logo=jquery&logoColor=white)

![License](https://img.shields.io/badge/License-MIT-yellow)
![Academic Project](https://img.shields.io/badge/Project-Type%3A%20Academic-lightgrey)

---

# IT-PROG Machine Project  
## 🍽️Ordering, Inventory, and Pre-Order Management System

---

## 📌 Project Overview

This repository contains the source code for an **Ordering, Inventory, and Pre-Order Management System** developed as a **Machine Project** for the *IT-PROG* course. The system models a real-world food service ordering workflow by integrating **client-side ordering**, **server-side administration**, and **database persistence**.

Designed with both **academic rigor** and **practical applicability**, the project demonstrates how integrative programming concepts are applied in a full-stack PHP application.

The school canteen pre-ordering system is designed to streamline food ordering for middle schools, high schools, and universities by eliminating long wait times. Recognizing that students often have limited break periods between classes and lectures, this system enables quick, efficient pre-orders, thereby helping students save time and ensuring they receive their meals promptly.

---

## 🎯 System Objectives

The system aims to:

- Enable users to **select and pre-order meals** efficiently  
- Persist successful transactions in a **MySQL database**  
- Provide administrators with tools to **manage menus, inventory, and reports**  


---

## 🧩 System Architecture

The system is divided into two major phases:

### Phase 1 – Client Side
Handles customer interaction, meal selection, quantity management, and checkout processing.

### Phase 2 – Server Side
Handles administrative authentication, menu and inventory management, transaction records, reporting, and XML integration.

Both phases are implemented using **PHP and MySQL**, following separation of concerns for maintainability.

---

## ✨ Features

### 🧑‍🍳 Client-Side Features

- Menu browsing by category:
  - Mains
  - Sides
  - Drinks
- Selection of **one item per category** with adjustable quantities
- Checkout process including:
  - Automatic total computation
  - Payment validation
  - Change calculation
- Transaction cancellation at any point
- Successful transactions saved with the customer name and date
- Past orders view
- Profile management

### 🛠️ Server-Side Features

- Secure administrator authentication
- Menu & meal plan management (add, update, delete items)
- Inventory tracking and stock updates
- Order and payment record management
- Sales and inventory summary reports

---

## ⚙️ Technologies & Libraries Used

- PHP
- MySQL / MariaDB
- HTML
- CSS & Bootstrap
- JavaScript & JQuery
- XAMPP (Apache, PHP, MySQL)

---

## 🚀 Setup & Installation

### Prerequisites
- XAMPP
- Web browser

### Installation Steps

1. Clone the repository:
   ```bash
   git clone https://github.com/eevangg/IT-PROG_MP.git
   ```
2. Move the project folder to:
   ```bash
   C:\xampp\htdocs\
   ```
3. Start Apache and MySQL via XAMPP Control Panel (configure and change MySQL port number to numbers in this range 3306 - 3308 if unable to start MySQL)
4. Import the database schema
5. Access the system at:
   ```bash
   http://localhost/IT-PROG_MP
   ```
---

### 👥 Development Team – ArcherInnov
- Agunanne Henry
- Gian Klarence Sy
- Lorenzo Luis Palay
- Reginald Andre Evangelista

---

## 👥 Team Contributions

The project was developed collaboratively by ArcherInnov, with responsibilities distributed to ensure a balanced workload and effective system integration.

| Team Member              | Primary Responsibilities                                                                                  |
|-------------------------|-----------------------------------------------------------------------------------------------------------|
| Agunanne Henry           | Server-side administration features, Backend processing logic, Database design and integration, MySQL schema management, transaction persistence, and data consistency |
| Gian Klarence Sy        |  menu browsing logic, order computation, and report generation|
| Lorenzo Luis Palay       | user interaction flow and UI layout structuring |
| Reginald Andre Evangelista |Client-side interface development, system configuration,  and checkout workflow|

All members contributed to testing, debugging, documentation, and final system integration.

---

### 🔮 Future Improvements
To further enhance the system and prepare it for real-world deployment, the following improvements are planned or recommended:

- Responsive UI design for improved mobile usability
- Support XML import/export for data integration and reporting
- Combo-based meals availability
- Automatically apply combo-based discounts
- Online and e-wallet payment gateway integration
- Improvement of Reports in Admin Dashboard
- Advanced analytics dashboard for sales trends and demand forecasting
- Deployment to a cloud-based hosting environment

  
These enhancements would significantly improve scalability, security, and user experience.

---

### 🏫 Academic Context

This project fulfills the Machine Project requirement for the IT-PROG (Integrative Programming) course. It demonstrates applied competencies in:

- Full-stack PHP development
- Database-driven application design
- Business logic and system integration

---

### 📄 License
This project is licensed under the MIT License.

---

### ⭐ Acknowledgements
Special thanks to the IT-PROG instructors and the College of Computer Studies for their guidance and support.


