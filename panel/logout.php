<?php
require_once __DIR__ . '/auth.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cmk_sprawdz_csrf();
}
cmk_logout();
header('Location: index.php');
exit;
