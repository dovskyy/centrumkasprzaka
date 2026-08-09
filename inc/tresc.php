<?php
function cmk_tresc() {
    $katalog = __DIR__ . '/../data/';
    $kolekcje = ['specjalizacje', 'lekarze', 'cennik', 'aktualnosci'];

    // Podglad wersji roboczej: ?podglad=1 + wazna sesja panelu pokazuje *.draft.json
    // zamiast opublikowanej tresci. Bez zalogowania parametr jest ignorowany.
    $pokazDrafty = false;
    if (($_GET['podglad'] ?? '') === '1') {
        require_once __DIR__ . '/../panel/auth.php';
        $pokazDrafty = cmk_is_logged_in();
    }

    $tresc = [];
    foreach ($kolekcje as $nazwa) {
        $plikDraft = $katalog . $nazwa . '.draft.json';
        $plikOpublikowany = $katalog . $nazwa . '.json';
        $plik = ($pokazDrafty && file_exists($plikDraft)) ? $plikDraft : $plikOpublikowany;
        $tresc[$nazwa] = file_exists($plik) ? json_decode(file_get_contents($plik), true) : [];
    }
    return $tresc;
}
