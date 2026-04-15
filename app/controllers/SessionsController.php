<?php

namespace Controllers;

use Models\Session;
use PDO;

class SessionController
{
    private Session $sessionModel;

    public function __construct(PDO $db)
    {
        $this->sessionModel = new Session($db);
    }

    /**
     * GET /sessions/start
     * Show the form to start a new session
     */
    public function showStartForm(): void
    {
        $reservations = $this->sessionModel->getPendingReservations();
        $games        = $this->sessionModel->getAvailableGames();

        require_once __DIR__ . '/../../views/sessions/start.php';
    }

    /**
     * POST /sessions/start
     * Process starting a new session
     */
    public function start(): void
    {
        $reservationId = (int) ($_POST['reservation_id'] ?? 0);
        $gameId        = (int) ($_POST['game_id']        ?? 0);
        $tableId       = (int) ($_POST['table_id']       ?? 0);

        if (!$reservationId || !$gameId || !$tableId) {
            $_SESSION['error'] = 'Tous les champs sont obligatoires.';
            header('Location: /sessions/start');
            exit;
        }

        $sessionId = $this->sessionModel->startSession($reservationId, $gameId, $tableId);

        if ($sessionId === false) {
            $_SESSION['error'] = 'Impossible de démarrer la session. Veuillez réessayer.';
            header('Location: /sessions/start');
            exit;
        }

        $_SESSION['success'] = 'Session #' . $sessionId . ' démarrée avec succès !';
        header('Location: /sessions');
        exit;
    }

    /**
     * GET /sessions
     * List all active sessions
     */
    public function index(): void
    {
        $activeSessions = $this->sessionModel->getActiveSessions();
        require_once __DIR__ . '/../../views/sessions/index.php';
    }

    /**
     * POST /sessions/{id}/end
     * End a specific active session
     */
    public function end(int $id): void
    {
        $success = $this->sessionModel->endSession($id);

        if (!$success) {
            $_SESSION['error'] = 'Session introuvable ou déjà terminée.';
        } else {
            $_SESSION['success'] = 'Session terminée avec succès.';
        }

        header('Location: /sessions');
        exit;
    }

    /**
     * GET /sessions/{id}
     * Show details of a single session
     */
    public function show(int $id): void
    {
        $session = $this->sessionModel->getSessionById($id);

        if (!$session) {
            http_response_code(404);
            echo 'Session introuvable.';
            exit;
        }

        require_once __DIR__ . '/../../views/sessions/show.php';
    }

    /**
     * POST /sessions/{id}/stop
     * Stop (end) a specific active session and free the table
     */
    public function stop(int $id): void
    {
        $this->end($id);
    }
}