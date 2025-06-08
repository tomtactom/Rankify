<?php
// KEIN LEERZEICHEN ODER BOM vor diesem Tag!

// Einfacher, dateibasierter oder Cookie-basierter Progress
// Du kannst dies auf SESSION oder COOKIE umstellen. Hier: SESSION (am wenigsten problematisch)
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

/**
 * Lädt den aktuellen Bearbeitungsstand für ein Kartenset aus der SESSION.
 *
 * @param string $kartensetPfad
 * @return array (enthält: 'antworten', 'paare', 'instruktion_gelesen' etc.)
 */
function loadProgress($kartensetPfad) {
    $key = 'rankifmy_' . md5($kartensetPfad);
    if(isset($_SESSION[$key])) {
        $progress = $_SESSION[$key];
        // Rückwärtskompatibilität:
        if(!isset($progress['antworten'])) $progress['antworten'] = [];
        if(!isset($progress['paare'])) $progress['paare'] = [];
        if(!isset($progress['instruktion_gelesen'])) $progress['instruktion_gelesen'] = false;
        return $progress;
    }
    // Noch kein Fortschritt
    return [
        'antworten' => [],
        'paare' => [],
        'instruktion_gelesen' => false,
    ];
}

/**
 * Speichert den Bearbeitungsstand für ein Kartenset in die SESSION.
 *
 * @param string $kartensetPfad
 * @param array $progress
 */
function saveProgress($kartensetPfad, $progress) {
    $key = 'rankifmy_' . md5($kartensetPfad);
    $_SESSION[$key] = $progress;
}

/**
 * Setzt den Fortschritt zurück (Session löschen).
 *
 * @param string $kartensetPfad
 */
function resetProgress($kartensetPfad) {
    $key = 'rankifmy_' . md5($kartensetPfad);
    unset($_SESSION[$key]);
}
