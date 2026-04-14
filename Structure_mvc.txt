#!/usr/bin/env bash

# Root project
mkdir -p AIJL_N3BOU
cd AIJL_N3BOU || exit

# Top level
mkdir -p config database public/css src/{controllers,core,models} views/{auth,includes,pages} tests

touch .gitignore LICENSE README.md sql.sql taskboard.md

# config
touch config/db.php

# database
touch database/database.sql database/seed.sql

# public
touch public/index.php
touch public/css/style.css

# src/controllers
touch src/controllers/AuthController.php
touch src/controllers/GamesController.php
touch src/controllers/ReservationController.php
touch src/controllers/RouterController.php
touch src/controllers/SessionsController.php

# src/core
touch src/core/Router.php

# src/models
touch src/models/AuthController.php
touch src/models/GamesController.php
touch src/models/ReservationController.php
touch src/models/RouterController.php
touch src/models/SessionsController.php

# views/auth
touch views/auth/login.php
touch views/auth/registration.php

# views/includes
touch views/includes/footer.php
touch views/includes/header.php

# views/pages
touch views/pages/dashboardAdmin.php
touch views/pages/dashboardClient.php

echo "✅ Project structure created."