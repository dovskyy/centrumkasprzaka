<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/inc/dane.php';
require_once __DIR__ . '/inc/uklad.php';
cmk_require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}
cmk_sprawdz_csrf();

// Whitelist celu powrotu - tylko sciezki wewnatrz panel/, zeby nie dalo sie przekierowac
// gdzie indziej podmienionym POST-em.
function cmk_bezpieczny_powrot($powrot) {
    $powrot = (string) $powrot;
    if ($powrot === '' || $powrot[0] === '/' || strpos($powrot, '://') !== false || strpos($powrot, '..') !== false) {
        return 'index.php';
    }
    // REQUEST_URI bywa pelna sciezka "/panel/edytuj.php?..." - zredukuj do samego pliku panelu.
    $pozycja = strrpos($powrot, '/panel/');
    if ($pozycja !== false) $powrot = substr($powrot, $pozycja + strlen('/panel/'));
    if (!preg_match('#^[a-z0-9_\-]+\.php(\?.*)?$#i', $powrot)) return 'index.php';
    return $powrot;
}

$kolekcje = array_keys($GLOBALS['CMK_ETYKIETY_KOLEKCJI']);
$akcja = $_POST['akcja'] ?? '';
$powrot = cmk_bezpieczny_powrot($_POST['powrot'] ?? 'index.php');
$sep = strpos($powrot, '?') === false ? '?' : '&';

if ($akcja === 'opublikuj') {
    $kolekcja = $_POST['kolekcja'] ?? '';
    if (in_array($kolekcja, $kolekcje, true)) {
        $s = cmk_sciezki($kolekcja);
        cmk_publikuj($kolekcja, $s['opublikowana'], $s['draft'], $s['kopie']);
    }
    header('Location: ' . $powrot . $sep . 'ok=opublikowano');
    exit;
}

if ($akcja === 'opublikuj-wszystko') {
    foreach ($kolekcje as $kolekcja) {
        $s = cmk_sciezki($kolekcja);
        cmk_publikuj($kolekcja, $s['opublikowana'], $s['draft'], $s['kopie']);
    }
    header('Location: ' . $powrot . $sep . 'ok=opublikowano-wszystko');
    exit;
}

if ($akcja === 'odrzuc') {
    $kolekcja = $_POST['kolekcja'] ?? '';
    if (in_array($kolekcja, $kolekcje, true)) {
        $s = cmk_sciezki($kolekcja);
        cmk_odrzuc_draft($s['draft']);
    }
    header('Location: ' . $powrot . $sep . 'ok=odrzucono');
    exit;
}

if ($akcja === 'odrzuc-wszystko') {
    foreach ($kolekcje as $kolekcja) {
        $s = cmk_sciezki($kolekcja);
        cmk_odrzuc_draft($s['draft']);
    }
    header('Location: ' . $powrot . $sep . 'ok=odrzucono-wszystko');
    exit;
}

header('Location: index.php');
exit;
