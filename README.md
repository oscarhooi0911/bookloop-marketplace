# Second-Hand Book Marketplace

A lightweight web application for listing, browsing, and managing second-hand books. Features user authentication, role-based access control (Customers, Sellers, Staff), item management, cart, wishlist, and customer review capabilities.

---
# Second-Hand Book Marketplace Setup & Installation Guide

This guide covers everything required to install WampServer, configure Apache and MySQL, import the database schema, and run the project.

---
## Prerequisites
Ensure you have the following installed on your system:
(Skip Part 1 if already installed)
* **Web Server Environment**: WAMP
* **PHP**
* **MySQL / MariaDB**
* **Apache HTTP Server**

---

## Part 1: Installing and Starting WampServer
### Installing WampServer
1. **Download Installer**: Obtain the installer from [WampServer Official Site](http://www.wampserver.com/en/). Download either the 64-bit or 32-bit version depending on your operating system platform.
2. **Install Prerequisites**: Download and install the **Microsoft Visual C++ Redistributable** package (linked on the WampServer download page) before executing the WampServer installer.

### Starting WampServer
1. **Launch**: Locate and click the **start WampServer** shortcut in your Start Menu or Start Screen. WampServer will automatically launch the Apache and MySQL services.
2. **Check System Tray Icon**:
   * 🔴 **Red**: All services are stopped.
   * 🟠 **Orange**: Some services are running, or a service failed to start due to a port conflict.
   * 🟢 **Green**: All services (Apache & MySQL) are up and running properly.
3. **Managing Services**: Click the WampServer system tray icon to display options to start, stop, or restart all services. You can also access individual Apache, MySQL, and PHP configuration files (`httpd.conf`, `php.ini`) and log files from their respective submenus.

### Apache & Web Root Directory Setup
1. **Web Root Location**: By default, WampServer sets the web root directory to:
   ```text
   C:\wamp64\www\ (or C:\wamp\www\)

---

## Part 2: Project Setup & Directory Placement
### Installation Instructions
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
   │   └── check_staff.php
   │   └── login_process.php
   │   └── register_process.php
   ├── css/
   │   ├── contact.css
   │   └── login.css
   │   └── seller.php
   │   └── style.php
   │   └── wishlist.php
   ├── customer/
   │   └── book_detail.php
   │   └── browse_book.php
   │   └── cart.php
   │   └── change_password.php
   │   └── contact.php
   │   └── dashboard.php
   │   └── edit_profile.php
   │   └── profile.php
   │   └── update_password.php
   │   └── update_profile.php
   │   └── wishlist.php
   │   └── wishlist_action.php
   ├── database/
   │   └── database.php
   │   └── bookstore.sql
   ├── images/
   ├── includes/
   │   ├── footer.php
   │   └── header.php
   ├── seller/
   │   ├── add_book.php
   │   ├── delete_book.php
   │   ├── edit_book.php
   │   └── my_books.php
   │   └── seller.js
   ├── staff/
   │   ├── dashboard.php
   │   ├── delete_user.php
   │   ├── manage_books.php
   │   └── manage_users.php
   │   └── reports.php
   │   └── view_user.php
   ├── upload/
   ├── index.php
   ├── login.php
   ├── logout.php
   ├── register.php
   ├── reset_password.php
   ├── update_reset_password.php
   ├── forgot_password.php
   └── hashStaffPassword.php


## Database Configuration
1. Start your WAMP / XAMPP server
2. Navigate to Database management and open phpmyadmin (```http://localhost/phpmyadmin```) in your browser.
3. Open ```database/database.php``` and match your local database credentials
4. Import SQL database ```database/bookstore.sql```

## How to Run the Project
Open your browser and navigate to the application URL: ```http://localhost/bookloop-marketplace/```
