-- Create data base command
-- XAMPP
-- mysql -u root -p
-- source C:\xampp\htdocs\database.sql
-- show databases
-- show tables

CREATE DATABASE IF NOT EXISTS db_cursos;
USE db_cursos;

CREATE TABLE IF NOT EXISTS Users
(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `names` VARCHAR(70) NULL,
    `lastnames` VARCHAR(70) NULL,
    `email` VARCHAR(70) NULL,
    `username` VARCHAR(40) NULL,
    `password` VARCHAR(40) NULL
) CHARACTER SET = "latin1";