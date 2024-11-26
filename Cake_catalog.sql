CREATE DATABASE cake_catalog;

USE cake_catalog;

CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE cakes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    image_url TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0
);

CREATE TABLE cart (
	id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    image_url TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0
);

INSERT INTO employees (username, password) values ("Fulano", "$2y$10$/OR5BsqbqsGuypmpPZfK9uR.2fo553EPXwfw.x68lIoysI35qfAOq");
