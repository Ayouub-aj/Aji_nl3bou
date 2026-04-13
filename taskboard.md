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

| Done | # | Task | Label | Priority | Time | Assigné | Notes |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- | :--- |
| [ ] | T-01 | Initialiser le repo GitHub + `.gitignore` | `ARCH` | High | 0.5h | — | Ajouter `vendor/` dans `.gitignore` |
| [ ] | T-02 | Configurer `composer.json` avec PSR-4 autoloading | `ARCH` | High | 0.5h | — | `App\\` → `src/` |
| [ ] | T-03 | Exécuter `composer dump-autoload` et vérifier | `ARCH` | High | 0.2h | — | |
| [ ] | T-04 | Créer la structure de dossiers (`src/Controllers`, `src/Models`, `views/`, `public/`) | `ARCH` | High | 0.5h | — | |
| [ ] | T-05 | Implémenter le Router personnalisé (`src/Core/Router.php`) | `ARCH` | High | 2h | — | Toutes URLs via `index.php` |
| [ ] | T-06 | Configurer `.htaccess` pour rediriger vers `index.php` | `ARCH` | High | 0.5h | — | |
| [ ] | T-07 | Créer le script SQL complet (tables + FK) | `DOC` | High | 2h | — | games, reservations, sessions, tables |
| [ ] | T-08 | Ajouter les seeds SQL (4 tables, 15 jeux, 5 réservations, 2 sessions, 1 admin) | `DOC` | Medium | 1.5h | — | |
| [ ] | T-09 | Créer le Jira board + renseigner toutes les US | `AGILE` | Medium | 1h | — | ⚠️ Deadline lundi 13/04 16:00 |
| [ ] | T-10 | Répartir les modules officiellement (1 module / membre) | `AGILE` | Medium | 0.5h | — | |
| [ ] | T-11 | `US1` — Lister tous les jeux (`GET /games`) | `MOD1` | High | 3h | Membre 1 | |
| [ ] | T-12 | `US2` — Détails d'un jeu (`GET /games/{id}`) | `MOD1` | Medium | 2h | Membre 1 | |
| [ ] | T-13 | `US3` — CRUD Admin jeux (Add / Edit / Delete) | `MOD1` | High | 4h | Membre 1 | |
| [ ] | T-14 | `US4` — Filtrer jeux par catégorie | `MOD1` | Low | 1.5h | Membre 1 | |
| [ ] | T-15 | `US5` — Vérifier disponibilité des tables | `MOD2` | High | 3h | Membre 2 | |
| [ ] | T-16 | `US6` — Créer une réservation (`POST /reservations`) | `MOD2` | High | 3h | Membre 2 | Validation nom, téléphone, date |
| [ ] | T-17 | `US7` — Historique des réservations client | `MOD2` | Medium | 2h | Membre 2 | |
| [ ] | T-18 | `US8` — Admin : voir & gérer réservations du jour | `MOD2` | Medium | 3h | Membre 2 | Statuts : confirmer / annuler |
| [ ] | T-19 | `US9` — Démarrer une session (réservation + jeu + table) | `MOD3` | High | 4h | Membre 3 | |
| [ ] | T-20 | `US10` — Dashboard sessions actives en temps réel | `MOD3` | Medium | 3h | Membre 3 | |
| [ ] | T-21 | `US11` — Terminer une session / libérer la table | `MOD3` | High | 2h | Membre 3 | |
| [ ] | T-22 | `US12` — Historique complet des sessions | `MOD3` | Medium | 2h | Membre 3 | |
| [ ] | T-23 | Choisir et implémenter le bonus trinôme | `MOD1`/`MOD2`/`MOD3` | Low | 4h | — | 1 seule extension |
| [ ] | T-24 | Écrire le `README.md` (arborescence, routes, install) | `DOC` | Medium | 1h | — | |
| [ ] | T-25 | Préparer screenshot du board Jira final | `DOC` | Low | 0.5h | — | |

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