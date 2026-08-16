<?php
require_once __DIR__ . '/config.php';

function cmk_panel_session_start() {
    if (session_status() === PHP_SESSION_ACTIVE) return;
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    session_set_cookie_params([
        // Sciezka '/' (nie '/panel/') celowo - podglad wersji roboczej dziala na stronach
        // poza /panel/ (index.php?podglad=1 itd.), wiec ciasteczko sesji musi tam docierac.
        'lifetime' => 0,
        'path' => '/',
        'httponly' => true,
        'secure' => $secure,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function cmk_is_logged_in() {
    cmk_panel_session_start();
    return !empty($_SESSION['cmk_panel_user']);
}

function cmk_require_login() {
    if (!cmk_is_logged_in()) {
        header('Location: index.php');
        exit;
    }
}

function cmk_client_ip() {
    return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
}

function cmk_attempts_path() {
    return __DIR__ . '/_attempts.json';
}

function cmk_read_attempts() {
    $plik = cmk_attempts_path();
    if (!file_exists($plik)) return [];
    $dane = json_decode(file_get_contents($plik), true);
    return is_array($dane) ? $dane : [];
}

function cmk_write_attempts($dane) {
    file_put_contents(cmk_attempts_path(), json_encode($dane), LOCK_EX);
}

// Rosnace opoznienie po nieudanym logowaniu: 1., 2. proba bez opoznienia,
// potem 2^(liczba_prob-2) sekund, max 5 minut. Licznik trzymany per IP w pliku,
// wiec przetrwa restart sesji (a nie tylko cookie atakujacego).
function cmk_login_delay_remaining($ip) {
    $dane = cmk_read_attempts();
    if (empty($dane[$ip])) return 0;
    $pozostalo = $dane[$ip]['do'] - time();
    return $pozostalo > 0 ? $pozostalo : 0;
}

function cmk_record_failed_attempt($ip) {
    $dane = cmk_read_attempts();
    $wpis = $dane[$ip] ?? ['count' => 0, 'do' => 0];
    $wpis['count']++;
    $opoznienie = min(300, (int) pow(2, max(0, $wpis['count'] - 2)));
    $wpis['do'] = time() + $opoznienie;
    $dane[$ip] = $wpis;
    cmk_write_attempts($dane);
}

function cmk_reset_attempts($ip) {
    $dane = cmk_read_attempts();
    unset($dane[$ip]);
    cmk_write_attempts($dane);
}

function cmk_attempt_login($login, $haslo) {
    $ip = cmk_client_ip();
    if (cmk_login_delay_remaining($ip) > 0) {
        return 'Zbyt wiele prob logowania. Sprobuj ponownie za chwile.';
    }
    if ($login === CMK_PANEL_LOGIN && password_verify($haslo, CMK_PANEL_HASH)) {
        cmk_reset_attempts($ip);
        cmk_panel_session_start();
        session_regenerate_id(true);
        $_SESSION['cmk_panel_user'] = $login;
        return true;
    }
    cmk_record_failed_attempt($ip);
    return 'Niepoprawny login lub haslo.';
}

function cmk_logout() {
    cmk_panel_session_start();
    $_SESSION = [];
    session_destroy();
}

// CSRF: token per sesja (nie per formularz - prostsze, wystarczajace dla panelu jednego uzytkownika).
function cmk_csrf_token() {
    cmk_panel_session_start();
    if (empty($_SESSION['cmk_csrf'])) {
        $_SESSION['cmk_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['cmk_csrf'];
}

function cmk_csrf_pole() {
    return '<input type="hidden" name="csrf" value="' . htmlspecialchars(cmk_csrf_token()) . '">';
}

// Wywolywac na poczatku obslugi kazdego POST-a. Przy niezgodnosci konczy zadanie 403-ka
// z czytelnym komunikatem PL zamiast bialego ekranu.
function cmk_sprawdz_csrf() {
    cmk_panel_session_start();
    $wyslany = (string) ($_POST['csrf'] ?? '');
    $oczekiwany = (string) ($_SESSION['cmk_csrf'] ?? '');
    if ($oczekiwany === '' || !hash_equals($oczekiwany, $wyslany)) {
        http_response_code(403);
        header('Content-Type: text/html; charset=utf-8');
        echo '<!DOCTYPE html><html lang="pl"><head><meta charset="utf-8"><title>Sesja wygasła</title></head><body style="font-family:sans-serif; max-width:480px; margin:80px auto; text-align:center;">'
            . '<h1 style="font-size:20px;">Sesja wygasła</h1>'
            . '<p>Zaloguj się ponownie, aby kontynuować.</p>'
            . '<p><a href="index.php">Wróć do logowania</a></p>'
            . '</body></html>';
        exit;
    }
}
