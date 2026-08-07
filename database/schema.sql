CREATE DATABASE IF NOT EXISTS bookstore;
USE bookstore;

CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS books (
    book_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    author VARCHAR(100) NOT NULL,
    genre VARCHAR(50) NOT NULL,
	language VARCHAR(50) DEFAULT 'English',
    price DECIMAL(10,2) NOT NULL,
    book_condition VARCHAR(50) NOT NULL,
    description TEXT,
    image VARCHAR(255) DEFAULT 'default_book.jpg'
);

CREATE TABLE IF NOT EXISTS cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    quantity INT DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE
);

-- sample book data for testing
INSERT INTO books (title, author, genre, language, price, book_condition, description) VALUES
('Database System Concepts', 'Silberschatz', 'Textbook', 'English', 45.00, 'Used - Like New', 'A foundational textbook on database management.', 'database-system.jpg'),
('Clean Code', 'Robert C. Martin', 'Technology', 'English', 30.00, 'Used - Good', 'A handbook of agile software craftsmanship.', 'clean-code.jpg'),
('The Great Gatsby', 'F. Scott Fitzgerald', 'Fiction', 'English', 12.50, 'Used - Acceptable', 'Classic modern literature with minor edge wear.', 'great-gatsby.jpg'),
('《小王子》', '安托万·德·圣-埃克苏佩里', 'Fiction', 'Mandarin', 15.00, 'Used - Like New', '《小王子》讲述了来自外星球的小王子从自己星球出发前往地球的过程以及来到地球之后的各种历险。如果你要驯服一个人，就要冒着掉眼泪的危险。', '小王子.jpg'),
('《被讨厌的勇气》', '岸见一郎, 古贺史健', 'Novel', 'Mandarin', 18.00, 'Used - Good', '《被讨厌的勇气》是一本探讨如何获得幸福和内心强大的书籍，基于阿德勒心理学的核心思想。不必讨好全世界，真正的自由始于"被讨厌的勇气"。', '被讨厌的勇气.jpg'),
('《平凡的世界》', '路遥', 'Novel', 'Mandarin', 22.50, 'Used - Acceptable', '《平凡的世界》讲述了孙少安和孙少平两兄弟为中心人物，通过复杂的矛盾纠葛，刻画了当时社会各阶层普通人的形象。苦难是人生的磨刀石，让生命更加锋利。', '平凡的世界.jpg');
