-- Создание базы данных
CREATE DATABASE IF NOT EXISTS lart_site CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE lart_site;

-- Таблица пользователей (администраторов)
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  role ENUM('admin', 'user') DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблица постов
CREATE TABLE IF NOT EXISTS posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  image_url VARCHAR(255) DEFAULT NULL,
  author_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Создание первого администратора (пароль "admin123" захэширован)
-- В реальном проекте замените на более надёжный пароль
INSERT INTO users (username, password, email, role) VALUES 
('admin', '$2y$10$8Xe9vBGtFAdXLdGAMxRP9OcEzH1AJKkDBZ63G2NeTeams7RWR/uZe', 'admin@example.com', 'admin');