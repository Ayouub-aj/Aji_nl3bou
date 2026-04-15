CREATE DATABASE IF NOT EXISTS game_cafe;
USE game_cafe;

create table users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'client') DEFAULT 'client'
);

create table games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    category enum('Stratégie', 'Ambiance', 'Famille', 'Experts'),
    description TEXT,
    difficulty enum ('Facile', 'Moyen', 'Difficile') default 'Moyen',
    min_players INT,
    max_players INT,
    duration INT,
    status ENUM('available', 'unavailable') DEFAULT 'available'
);

create table tables (
    id INT AUTO_INCREMENT PRIMARY KEY,
    number INT NOT NULL UNIQUE,
    capacity INT NOT NULL,
    status ENUM('free', 'reserved', 'occupied') DEFAULT 'free'
);

create table reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    users_id INT NOT NULL,
    client_phone VARCHAR(30) NOT NULL,
    players_count INT NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    table_id INT NOT NULL,
    FOREIGN KEY (table_id) REFERENCES tables(id) ON DELETE CASCADE ON UPDATE CASCADE 
    foreign key (users_id) references users(id) on delete cascade on update cascade
);

create table sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    start_time DATETIME NOT NULL,
    end_time DATETIME NULL,
    status ENUM('active', 'finished') DEFAULT 'active',
    reservation_id INT UNIQUE NOT NULL,
    game_id INT NOT NULL,
    table_id INT NOT NULL,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (table_id) REFERENCES tables(id) ON DELETE CASCADE ON UPDATE CASCADE
);
