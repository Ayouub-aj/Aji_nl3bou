-- Aji L3bo Cafe - Database Schema

CREATE DATABASE IF NOT EXISTS game_cafe;
USE game_cafe;

-- Users Table
CREATE TABLE users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50) NOT NULL UNIQUE,
    email       VARCHAR(100),
    password    VARCHAR(255) NOT NULL,
    phone       VARCHAR(30),
    role        ENUM('admin', 'client') DEFAULT 'client',
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_login  DATETIME
);

-- Games Table
CREATE TABLE games (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(150) NOT NULL,
    category    ENUM('Stratégie', 'Ambiance', 'Famille', 'Experts'),
    description TEXT,
    difficulty  ENUM('Facile', 'Moyen', 'Difficile') DEFAULT 'Moyen',
    min_players INT,
    max_players INT,
    duration    INT,
    status     ENUM('available', 'unavailable') DEFAULT 'available',
    image_url  VARCHAR(500)
);

-- Tables (Game Tables)
CREATE TABLE tables (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    number   INT NOT NULL UNIQUE,
    name     VARCHAR(100),
    capacity INT NOT NULL,
    status   ENUM('free', 'reserved', 'occupied', 'available') DEFAULT 'free'
);

-- Reservations Table
CREATE TABLE reservations (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    users_id      INT,                              -- FK to users (nullable for guest reservations)
    client_name   VARCHAR(100),
    client_phone  VARCHAR(30) NOT NULL,
    players_count INT NOT NULL,
    date          DATE NOT NULL,
    time          TIME NOT NULL,
    status        ENUM('pending', 'confirmed', 'cancelled', 'canceled', 'completed') DEFAULT 'pending',
    table_id      INT NOT NULL,                    -- FK to tables
    game_id       INT,                             -- FK to games (optional)
    
    FOREIGN KEY (table_id) REFERENCES tables(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE SET NULL ON UPDATE CASCADE
);

-- Sessions Table
CREATE TABLE sessions (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    start_time     DATETIME NOT NULL,
    end_time       DATETIME,
    status         ENUM('active', 'finished') DEFAULT 'active',
    reservation_id INT,                            -- FK to reservations (optional)
    game_id        INT,                           -- FK to games (optional)
    table_id       INT NOT NULL,                  -- FK to tables
    notes          TEXT,
    
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (table_id) REFERENCES tables(id) ON DELETE CASCADE ON UPDATE CASCADE
);





-- ========================================
-- USERS TABLE
-- ========================================
ALTER TABLE users 
ADD COLUMN email VARCHAR(100),
ADD COLUMN phone VARCHAR(30),
ADD COLUMN created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN last_login DATETIME;

-- ========================================
-- RESERVATIONS TABLE
-- ========================================
ALTER TABLE reservations 
ADD COLUMN client_name VARCHAR(100),
ADD COLUMN game_id INT;

-- users_id nullable (guest support)
ALTER TABLE reservations 
MODIFY users_id INT NULL;

-- Fix status (clean ENUM)
ALTER TABLE reservations 
MODIFY status ENUM('pending', 'confirmed', 'cancelled', 'completed') 
DEFAULT 'pending';

-- Add foreign keys (IMPORTANT)
ALTER TABLE reservations 
ADD CONSTRAINT fk_res_user 
FOREIGN KEY (users_id) REFERENCES users(id) 
ON DELETE SET NULL;

ALTER TABLE reservations 
ADD CONSTRAINT fk_res_game 
FOREIGN KEY (game_id) REFERENCES games(id) 
ON DELETE SET NULL;

-- Indexes for performance
CREATE INDEX idx_res_user ON reservations(users_id);
CREATE INDEX idx_res_game ON reservations(game_id);

-- ========================================
-- TABLES TABLE

ALTER TABLE tables 
ADD COLUMN name VARCHAR(100);

ALTER TABLE tables 
MODIFY status ENUM('free', 'reserved', 'occupied') 
DEFAULT 'free';

-- ========================================
-- GAMES TABLE
-- ========================================
ALTER TABLE games 
ADD COLUMN image_url VARCHAR(255);

-- ========================================
-- DONE
-- ========================================
