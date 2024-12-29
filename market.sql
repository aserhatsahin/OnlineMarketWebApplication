-- SQL script to create the required database and tables for the project

-- Create database
CREATE DATABASE online_market;

-- Use the database
USE online_market;

-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'user') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create categories table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Create cart_items table
CREATE TABLE cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Sample data for testing

-- Insert sample users
INSERT INTO users (username, password, email, role) VALUES
('admin', ' $2y$10$YNmU79ZrpKxrzbxrBiMDkO6tT/ZC/V3Ihj6Cg4iGGV/cBE/L449.W', 'admin@example.com', 'admin'),
('user1', ' $2y$10$fqqOCWHb2Y/HzKAeWHUbhOxasUKCcrMKc0o3HyXdP0xVJZzRLeBNm', 'user1@example.com', 'user');

-- Insert sample categories
INSERT INTO categories (name) VALUES
('Electronics'),
('Clothing'),
('Books');

-- Insert sample products
INSERT INTO products (name, description, price, image, category_id) VALUES
('Laptop', 'High performance laptop', 999.99, 'laptop.jpg', 1),
('T-Shirt', 'Comfortable cotton t-shirt', 19.99, 'tshirt.jpg', 2),
('Novel', 'Bestselling novel', 14.99, 'novel.jpg', 3);
