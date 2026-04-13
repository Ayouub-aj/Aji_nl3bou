# 🎲 Aji L3bo Café — Scrum Task Board
**kanban:** 13/04/2026 → 17/04/2026 | **Team:** Trinôme | **Scrum Master:** —

---

## 📋 Legend

| Label | Meaning |
|-------|---------|
| `ARCH` | Architecture / Setup |
| `MOD1` | Module 1 — Catalogue de Jeux |
| `MOD2` | Module 2 — Réservations |
| `MOD3` | Module 3 — Sessions |
| `AGILE` | Process Agile / Collaboration |
| `QA` | Code Quality / Tests |
| `DOC` | Documentation / Livrables |

---

## 📝 Tasks Board

| Done | # | Task | Label | Priority | Time | Assigné | Detailed Implementation & Files |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- | :--- |
| [ ] | T-01 | Initialiser le repo GitHub + `.gitignore` | `ARCH` | High | 0.5h | — | **Files to Create:**<br>- `.gitignore`<br>- `README.md`<br>- `LICENSE` |
| [ ] | T-02 | Configurer `composer.json` PSR-4 | `ARCH` | High | 0.5h | — | **Files to Create/Edit:**<br>- `composer.json`: Configure PSR-4 `App\` mapping to `src/` |
| [ ] | T-03 | `composer dump-autoload` | `ARCH` | High | 0.2h | — | **Action:**<br>- Generate `vendor/autoload.php` |
| [ ] | T-04 | Structure MVC Complète | `ARCH` | High | 0.5h | — | **Directories to Create:**<br>- `src/Controllers/`, `src/Models/`, `src/Core/`<br>- `views/`<br>- `public/assets/{css,img}/`<br>- `config/`<br>- `tests/` |
| [ ] | T-05 | Router & Front Controller | `ARCH` | High | 2h | — | **Files to Create:**<br>- `src/Core/Router.php`: Handle dynamic routing<br>- `public/index.php`: Main entry point |
| [ ] | T-06 | `.htaccess` Configuration | `ARCH` | High | 0.5h | — | **Files to Create:**<br>- `.htaccess`: Redirect all requests to `public/index.php` |
| [ ] | T-07 | Script SQL (Schema) | `DOC` | High | 2h | — | **Files to Create:**<br>- `config/database.sql`: Tables for `games`, `reservations`, `sessions`, `tables` |
| [ ] | T-08 | Seeding SQL (Initial Data) | `DOC` | Medium | 1.5h | — | **Files to Create:**<br>- `config/seeds.sql`: Insert 15+ games, 5 reservations, 2 sessions, 1 admin |
| [ ] | T-09 | Jira Board Setup | `AGILE` | Medium | 1h | — | **Action:** Create project and US in Jira |
| [ ] | T-10 | Répartition & Planning | `AGILE` | Medium | 0.5h | — | **Action:** Assign members to modules in this file |
| [ ] | T-11 | `US1` — Catalogue (Liste) | `MOD1` | High | 3h | Membre 1 | **Files to Create:**<br>- `src/Controllers/GameController.php` (index)<br>- `src/Models/Game.php` (all)<br>- `views/games/index.php` (User UI)<br>**Route:** `GET /games` |
| [ ] | T-12 | `US2` — Détails d'un jeu | `MOD1` | Medium | 2h | Membre 1 | **Files to Create/Edit:**<br>- `src/Controllers/GameController.php` (show)<br>- `views/games/details.php` (User UI)<br>**Route:** `GET /games/{id}` |
| [ ] | T-13 | `US3` — CRUD Admin Jeux | `MOD1` | High | 4h | Membre 1 | **Files to Create:**<br>- `src/Controllers/Admin/GameController.php` (CRUD logic)<br>- `views/admin/games/index.php` (List table)<br>- `views/admin/games/create.php` (Add form)<br>- `views/admin/games/edit.php` (Edit form)<br>**Routes:** `/admin/games/**/*` |
| [ ] | T-14 | `US4` — Filtre par catégorie | `MOD1` | Low | 1.5h | Membre 1 | **Modifications:**<br>- `src/Models/Game.php`: Add `filterByCategory` method<br>- Update `GameController` to handle query params |
| [ ] | T-15 | `US5` — Dispo des Tables | `MOD2` | High | 3h | Membre 2 | **Files to Create:**<br>- `src/Models/TableModel.php`: Check table availability status (pure PHP logic) |
| [ ] | T-16 | `US6` — Créer Réservation | `MOD2` | High | 3h | Membre 2 | **Files to Create:**<br>- `src/Models/Reservation.php`: Store reservation data<br>- `src/Controllers/ReservationController.php`: Process form<br>- `views/reservations/create.php`: Form UI<br>**Route:** `POST /reservations/create` |
| [ ] | T-17 | `US7` — Historique Client | `MOD2` | Medium | 2h | Membre 2 | **Files to Create:**<br>- `views/reservations/index.php`: User history list (PHP/HTML only) |
| [ ] | T-18 | `US8` — Admin Résas | `MOD2` | Medium | 3h | Membre 2 | **Files to Create:**<br>- `src/Controllers/Admin/ReservationController.php`: Accept/Cancel logic<br>- `views/admin/reservations/index.php`: Admin list view |
| [ ] | T-19 | `US9` — Démarrer Session | `MOD3` | High | 4h | Membre 3 | **Files to Create:**<br>- `src/Models/Session.php`: Manage active sessions<br>- `src/Controllers/SessionController.php`: Start logic<br>- `views/sessions/start.php`: UI for starting |
| [ ] | T-20 | `US10` — Dashboard Active | `MOD3` | Medium | 3h | Membre 3 | **Files to Create:**<br>- `views/admin/sessions/dashboard.php`: PHP list of active sessions (Manual refresh via HTML meta or button) |
| [ ] | T-21 | `US11` — Terminer Session | `MOD3` | High | 2h | Membre 3 | **Modifications:**<br>- `SessionController.php`: Add `stop` method<br>- Logic to free up the table in `tables` table |
| [ ] | T-22 | `US12` — Historique complet | `MOD3` | Medium | 2h | Membre 3 | **Files to Create:**<br>- `views/admin/sessions/history.php`: Past sessions list<br>- `src/Models/Session.php`: `getHistory` method |
| [ ] | T-23 | Extension Bonus | `QA` | Low | 4h | — | **Action:** Implement chosen bonus feature (No JS) |
| [ ] | T-24 | `README.md` Technique | `DOC` | Medium | 1h | — | **Update:** Add installation guide, routes table |
| [ ] | T-25 | Capture Jira Board | `DOC` | Low | 0.5h | — | **Action:** Finalize and screenshot Jira state |
| [ ] | T-26 | **Setup Environnement de Test** | `QA` | High | 1h | — | **Dirs:** Create `tests/` at the root.<br>**Files:** `tests/test_bootstrap.php` (load autoloader) |
| [ ] | T-27 | **Test Unitaires: Modèles** | `QA` | High | 2h | — | **Files to Create:**<br>- `tests/GameTest.php`: Validate DB fetch logic<br>- `tests/ReservationTest.php`: Validate reservation overlapping rules |
| [ ] | T-28 | **Test d'Intégration: Routes** | `QA` | Medium | 2h | — | **Files:** `tests/RouteTest.php`: Verify Router-to-Controller mapping. |
| [ ] | T-29 | **Audit Sécurité (SQLi/XSS)** | `QA` | High | 1.5h | — | **Action:** Verify `PDO::prepare` across all models; test form inputs with special characters (`<script>`, `'`, etc.). |
| [ ] | T-30 | **Vérification Intégrité DB (FK)** | `QA` | High | 1h | — | **Action:** Test "Cascade Delete" or isolation: verify that deleting a game doesn't break active sessions or reservations. |
| [ ] | T-31 | **Test de Validation de Formulaires** | `QA` | High | 1.5h | — | **Files:** `tests/ValidationTest.php`: Test edge cases (duplicate names, dates in the past, invalid phone formats). |
| [ ] | T-32 | **Smoke Test: Navigation UI** | `QA` | Medium | 1h | — | **Action:** Manual click-through of every route to ensure no 404s or 500s in any module. |
| [ ] | T-33 | **Audit Performance SQL (JOINs)** | `QA` | Low | 1h | — | **Action:** Verify that sessions dashboard and history use efficient `JOIN` queries instead of multiple selects. |

---

## 📅 Daily Standups

| Jour | Ce qu'on a fait | Ce qu'on fait aujourd'hui | Blockers |
|------|----------------|--------------------------|---------|
| Lundi 13/04 | | | |
| Mardi 14/04 | | | |
| Mercredi 15/04 *(Mid-retro)* | | | |
| Jeudi 16/04 | | | |
| Vendredi 17/04 | | | |

---

## 🔁 Rétrospective Mi-Sprint (Mercredi 15/04)

| Question | Réponse |
|----------|---------|
| ✅ Ce qui va bien | |
| ⚠️ Ce qui bloque | |
| 🔧 Ce qu'on améliore | |

---

## 🔁 Rétrospective Finale (Vendredi 17/04)

| Question | Réponse |
|----------|---------|
| ✅ Ce qui a bien fonctionné | |
| ❌ Ce qui n'a pas marché | |
| 💡 Ce qu'on ferait différemment | |
| 🏆 Fierté de l'équipe | |

---

## 📦 Checklist Livrables Finaux

| Livrable | Critère | Statut |
|----------|---------|--------|
| GitHub Repo | ≥ 20 commits répartis entre 3 membres | ⬜ |
| GitHub Repo | Messages de commits explicites | ⬜ |
| GitHub Repo | Feature branches visibles dans l'historique | ⬜ |
| GitHub Repo | PRs avec ≥ 1 commentaire de review | ⬜ |
| Fichier SQL | Script complet avec Foreign Keys | ⬜ |
| Fichier SQL | Seeding complet (4 tables, 15 jeux, 5 résa, 2 sessions, 1 admin) | ⬜ |
| README.md | Description du projet | ⬜ |
| README.md | Screenshot du board Jira final | ⬜ |
| README.md | Arborescence de l'architecture | ⬜ |
| README.md | Instructions d'installation | ⬜ |
| README.md | Table des endpoints / routes disponibles | ⬜ |
| Composer | `composer.json` configuré PSR-4 | ⬜ |
| Composer | `vendor/` dans `.gitignore` | ⬜ |
| Jira | Board livré avant lundi 13/04 16:00 | ⬜ |
| Jira | US traduites en tasks avec historique de mouvements | ⬜ |

---

## 🏆 Critères de Performance

### Architecture (40%)
| Critère | Statut |
|---------|--------|
| ✅ Router gère toutes les URLs (pas d'accès direct) | ⬜ |
| ✅ Namespaces PSR-4 correctement utilisés | ⬜ |
| ✅ Autoloading Composer fonctionnel (zéro `require_once`) | ⬜ |
| ✅ Séparation MVC stricte (logique dans Models, pas dans Views) | ⬜ |

### Collaboration (30%)
| Critère | Statut |
|---------|--------|
| ✅ 3 modules clairement répartis (1 par membre) | ⬜ |
| ✅ Daily standups documentés | ⬜ |
| ✅ Jira board à jour (historique visible) | ⬜ |
| ✅ Pull Requests avec reviews constructives | ⬜ |
| ✅ Commits équilibrés entre les 3 membres | ⬜ |

### Code Quality (20%)
| Critère | Statut |
|---------|--------|
| ✅ Foreign Keys et JOINs corrects | ⬜ |
| ✅ Prepared Statements (PDO) | ⬜ |
| ✅ Validation des formulaires | ⬜ |
| ✅ Gestion des erreurs (404, validation) | ⬜ |
| ✅ Code indenté, nommage cohérent | ⬜ |

### Process Agile (10%)
| Critère | Statut |
|---------|--------|
| ✅ Jira board livré lundi 16:00 | ⬜ |
| ✅ Mid-week retrospective effectuée | ⬜ |
| ✅ US traduites en tasks Jira | ⬜ |
| ✅ Rétrospective finale documentée | ⬜ |

---

*Dernière mise à jour : 13/04/2026*