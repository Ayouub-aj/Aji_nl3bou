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


INSERT INTO users (username, password, role) VALUES
('admin', '$2y$10$hashedpasswordadmin', 'admin'),
('yassine', '$2y$10$hashedpassword1', 'client'),
('salma', '$2y$10$hashedpassword2', 'client'),
('mehdi', '$2y$10$hashedpassword3', 'client'),
('aya', '$2y$10$hashedpassword4', 'client'),
('hamza', '$2y$10$hashedpassword5', 'client');


INSERT INTO games (title, category, description, difficulty, min_players, max_players, duration) VALUES
('Catan', 'Stratégie', 'Trade, build and settle the island of Catan.', 'Moyen', 3, 4, 90),
('Uno', 'Ambiance', 'Fast and fun card game for everyone.', 'Facile', 2, 10, 30),
('Chess', 'Stratégie', 'Classic strategy game for two players.', 'Difficile', 2, 2, 60),
('Monopoly', 'Famille', 'Buy properties and bankrupt your friends.', 'Facile', 2, 6, 120),
('Dixit', 'Ambiance', 'Creative storytelling with beautiful cards.', 'Facile', 3, 8, 45),
('7 Wonders', 'Experts', 'Build a civilization and manage resources.', 'Difficile', 2, 7, 40),
('Carcassonne', 'Famille', 'Build cities and roads with tiles.', 'Moyen', 2, 5, 45),
('Werewolf', 'Ambiance', 'Social deduction party game.', 'Facile', 6, 18, 30),
('Risk', 'Stratégie', 'World domination strategy game.', 'Moyen', 2, 6, 120),
('Ticket to Ride', 'Famille', 'Build train routes across countries.', 'Moyen', 2, 5, 60);


INSERT INTO tables (number, capacity) VALUES
(1, 2),
(2, 2),
(3, 4),
(4, 4),
(5, 6),
(6, 6),
(7, 8),
(8, 8);


INSERT INTO reservations (users_id, client_phone, players_count, date, time, status, table_id) VALUES
(2, '0612345678', 4, '2026-04-15', '18:00:00', 'confirmed', 3),
(3, '0623456789', 2, '2026-04-15', '19:00:00', 'pending', 1),
(4, '0634567890', 6, '2026-04-16', '20:00:00', 'confirmed', 5),
(5, '0645678901', 3, '2026-04-16', '17:30:00', 'confirmed', 4),
(6, '0656789012', 8, '2026-04-17', '21:00:00', 'pending', 7);


INSERT INTO sessions (start_time, end_time, status, reservation_id, game_id, table_id) VALUES
('2026-04-15 18:05:00', '2026-04-15 19:40:00', 'finished', 1, 1, 3),
('2026-04-16 20:10:00', NULL, 'active', 3, 9, 5),
('2026-04-16 17:35:00', '2026-04-16 18:20:00', 'finished', 4, 5, 4);



