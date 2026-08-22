# Second-Hand Book Marketplace

A lightweight web application for listing, browsing, and managing second-hand books. Features user authentication, role-based access control (Customers, Sellers, Staff), item management, cart, wishlist, and customer review capabilities.

---

## Prerequisites
Ensure you have the following installed on your system:

* **Web Server Environment**: WAMP, XAMPP, LAMP, or MAMP
* **PHP**: Version 7.4 or higher
* **MySQL / MariaDB**: Version 5.7 or higher
* **Apache HTTP Server**
* Web browser (Chrome, Firefox, Edge, Safari)

---

## Installation Instructions
1. **Clone or Extract Project Directory**
   Place the project directory into your local web server's root folder:
   * **WAMPServer**: `C:\wamp64\www\bookloop-marketplace\`
   * **XAMPP**: `C:\xampp\htdocs\bookloop-marketplace\`

2. **Verify Required Folder Structure**
   Ensure the following directory layout exists in your project directory:
   ```text
   bookloop-marketplace/
   ├── authentication/
   │   └── check_login.php
   ├── css/
   │   ├── seller.css
   │   └── style.css
   ├── database/
   │   └── database.php
   ├── images/
   ├── includes/
   │   ├── footer.php
   │   └── header.php
   ├── js/
   │   └── seller.js
   ├── seller/
   │   ├── add_book.php
   │   ├── delete_book.php
   │   ├── edit_book.php
   │   └── my_books.php
   ├── index.php
   ├── login.php
   ├── logout.php
   ├── register.php
   └── schema.sql


## Database Configuration
1. Start your WAMP / XAMPP server
2. Navigate to Database management and open phpmyadmin (http://localhost/phpmyadmin) in your browser.
3. Open ```database/database.php``` and match your local database credentials
4. Import SQL database ```database/database.sql```

## How to Run the Project
Open your browser and navigate to the application URL: ```http://localhost/bookloop-marketplace/```
