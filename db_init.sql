CREATE DATABASE IF NOT EXISTS personal_portfolio;
USE personal_portfolio;

CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    technologies VARCHAR(255),
    project_link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO projects (title, description, technologies, project_link)
VALUES 
('Library Management System', 'A web app to manage books and users', 'PHP, MySQL, HTML, CSS', 'https://github.com/johnguteta465/-Online-Library-Management-System-OLMS-'),
('E-commerce Website', 'Online store with product management', 'PHP, MySQL, JavaScript, CSS', 'https://github.com/yourusername/ecommerce');

CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);