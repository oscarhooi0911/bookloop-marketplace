CREATE DATABASE IF NOT EXISTS secondhand_book_marketplace;
USE secondhand_book_marketplace;

-- table for user(authentication), books(sale), cart, review
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    profile_picture VARCHAR(255) NOT NULL DEFAULT 'default.png',
    role ENUM('customer', 'staff') NOT NULL DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS books (
    book_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    author VARCHAR(100) NOT NULL,
    genre VARCHAR(50) NOT NULL,
    language VARCHAR(50) NOT NULL DEFAULT 'English',
    price DECIMAL(10,2) NOT NULL,
    book_condition VARCHAR(50) NOT NULL,
    description TEXT,
    image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    UNIQUE KEY unique_cart_item (user_id, book_id),
    CONSTRAINT cart_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    CONSTRAINT cart_book FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS wishlist (
    wishlist_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_wishlist_item (user_id, book_id),
    CONSTRAINT wishlist_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    CONSTRAINT wishlist_book FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    user_id INT NOT NULL,
    rating TINYINT NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT review_rating CHECK (rating BETWEEN 1 AND 5),
    CONSTRAINT review_book FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE,
    CONSTRAINT review_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Add staff (Password is Oscarhooi@0911)
INSERT IGNORE INTO users (full_name, email, password, role) VALUES
('System Administrator', 'admin@bookstore.com', '$2y$10$xNS9vbMO4wRFzM59r6vqWegheUBDxhjrLhfKBt6LznNMFYWzYCAiC', 'staff');

INSERT IGNORE INTO books (book_id, title, author, genre, language, price, book_condition, description, image) VALUES
(1, 'Database System Concepts', 'Silberschatz', 'Textbook', 'English', 45.00, 'Used - Like New', 'A foundational textbook on database management.', 'database-system.jpg'),
(2, 'Clean Code', 'Robert C. Martin', 'Technology', 'English', 30.00, 'Used - Good', 'A handbook of agile software craftsmanship.', 'clean-code.jpg'),
(3, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Fiction', 'English', 12.50, 'Used - Acceptable', 'Classic modern literature with minor edge wear.', 'great-gatsby.jpg'),
(4, '小王子', '安托万·德·圣-埃克苏佩里', 'Fiction', 'Mandarin', 15.00, 'Used - Like New', 'A classic story about friendship and discovery.', '小王子.jpg'),
(5, '被讨厌的勇气', '岸见一郎, 古贺史健', 'Novel', 'Mandarin', 18.00, 'Used - Good', 'An introduction to Adlerian psychology.', '被讨厌的勇气.jpg'),
(6, '平凡的世界', '路遥', 'Novel', 'Mandarin', 22.50, 'Used - Acceptable', 'A portrait of ordinary lives and resilience.', '平凡的世界.jpg');
