# Raspbian MariaDB Setup

## Create database for web access
    CREATE DATABASE web;
    USE web;

## Create database table to store temperatures
    CREATE TABLE temperature (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      sampled_at TIMESTAMP NOT NULL,
      sensor_id VARCHAR(20) NOT NULL,
      sensor_val FLOAT(5,2) NOT NULL
    );

## Create database user for web access
    CREATE USER 'webusername'@'localhost' IDENTIFIED BY 'webpassword';
    GRANT INSERT,SELECT ON web.* TO 'webusername'@'localhost';
