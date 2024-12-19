CREATE DATABASE IF NOT EXISTS mydb;

USE mydb;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO users (name, password) VALUES ('Alvaro', 'alvaro123');
INSERT INTO users (name, password) VALUES ('Javi', 'javi123');
INSERT INTO users (name, password) VALUES ('Camacho', 'camacho123');
