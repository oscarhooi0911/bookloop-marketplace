CREATE DATABASE IF NOT EXISTS secondhand_book_marketplace;
USE secondhand_book_marketplace;

CREATE TABLE users (
	user_id INT AUTO_INCREMENT PRIMARY KEY,
	full_name VARCHAR(100) NOT NULL,
	email VARCHAR(100) UNIQUE NOT NULL,
	password VARCHAR(100) NOT NULL,
	phone VARCHAR(20),
	address TEXT,
	profile_picture VARCHAR(255) DEFAULT 'default.png',
	
	role ENUM('customer', 'staff') DEFAULT 'customer',
	
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (full_name, email, password, role)
VALUES(
'System Administrator',
'admin@bookstore.com',
'$2y$10$bGMdkaI3OvL7fMxJCp4.3.f4HUwrC8bw/nFk9GJYNjx3g4/bq0PVu',
'staff'
);
