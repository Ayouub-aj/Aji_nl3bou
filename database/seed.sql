

-- ========================================================
-- TEST USERS DATA
-- ========================================================
-- All passwords follow the pattern: [username] + '123'
-- Example: User 'admin' has password 'admin123'
-- --------------------------------------------------------
-- 1. admin   | Role: admin  | Password: admin123
-- 2. yassine | Role: client | Password: yassine123
-- 3. salma   | Role: client | Password: salma123
-- 4. mehdi   | Role: client | Password: mehdi123
-- 5. aya     | Role: client | Password: aya123
-- 6. hamza   | Role: client | Password: hamza123
-- ========================================================

INSERT INTO users (username, password, role) VALUES
('admin', '$2y$10$TOJkQIVbhltQ3GahLWsYAelDo6HQotmKKGDC1piPPa6HHSOZ7w.gW', 'admin'),
('yassine', '$2y$10$/U.eYVOqSTvXI25OhjQ6suhNcIgsn075oJ8iM6AUotYVROG0E5NFW', 'client'),
('salma', '$2y$10$HbFOGUs04AeH7Qedn0P62.j7l8ddpVtG6PNqyO870FAr.ojuc045S', 'client'),
('mehdi', '$2y$10$UrtTNyQnT.4ALhBh2MOvv.pXeeb/.7fJSvb5pl/5J5TWOcEUiI2uq', 'client'),
('aya', '$2y$10$rQXzcXeC/8mdMg.r.5sHiuAmmEmfTrAgMoa8d.eqrAS2hsLmQfLuO', 'client'),
('hamza', '$2y$10$br1WfvsJXincmRWO3EbSzurWydvcQOPiIBV1hE7o/79tNM6TwmoVi', 'client');


-- ========================================================
-- GAMES CATALOG DATA
-- ========================================================
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


-- ========================================================
-- TABLES CONFIGURATION
-- ========================================================
INSERT INTO tables (number, capacity) VALUES
(1, 2),
(2, 2),
(3, 4),
(4, 4),
(5, 6),
(6, 6),
(7, 8),
(8, 8);


-- ========================================================
-- SAMPLE RESERVATIONS
-- ========================================================
INSERT INTO reservations (users_id, client_phone, players_count, date, time, status, table_id) VALUES
(2, '0612345678', 4, '2026-04-15', '18:00:00', 'confirmed', 3),
(3, '0623456789', 2, '2026-04-15', '19:00:00', 'pending', 1),
(4, '0634567890', 6, '2026-04-16', '20:00:00', 'confirmed', 5),
(5, '0645678901', 3, '2026-04-16', '17:30:00', 'confirmed', 4),
(6, '0656789012', 8, '2026-04-17', '21:00:00', 'pending', 7);


-- ========================================================
-- GAME SESSIONS HISTORY
-- ========================================================
INSERT INTO sessions (start_time, end_time, status, reservation_id, game_id, table_id) VALUES
('2026-04-15 18:05:00', '2026-04-15 19:40:00', 'finished', 1, 1, 3),
('2026-04-16 20:10:00', NULL, 'active', 3, 9, 5),
('2026-04-16 17:35:00', '2026-04-16 18:20:00', 'finished', 4, 5, 4);



