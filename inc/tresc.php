<?php
require_once __DIR__ . '/aktualnosci.php';

define('CMK_BAZOWY_URL', 'https://cmkasprzaka.pl');

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
    $tresc['aktualnosci'] = cmk_normalizuj_aktualnosci($tresc['aktualnosci']);
    $tresc['lekarze'] = array_map('cmk_uzupelnij_zdjecie_lekarza', $tresc['lekarze'] ?? []);
    return $tresc;
}

// Lekarz bez wgranego zdjecia (zdjecie: null w danych) dostaje domyslny placeholder
// dobrany po polu "plec" - zeby karty na /specjalisci.php nigdy nie byly puste.
function cmk_uzupelnij_zdjecie_lekarza($lekarz) {
    if (empty($lekarz['zdjecie'])) {
        $lekarz['zdjecie'] = ($lekarz['plec'] ?? '') === 'M'
            ? 'uploads/doctor-placeholder-male.png'
            : 'uploads/doctor-placeholder-female.png';
    }
    return $lekarz;
}
