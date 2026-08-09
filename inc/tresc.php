<?php
function cmk_tresc() {
    $katalog = __DIR__ . '/../data/';
    $kolekcje = ['specjalizacje', 'lekarze', 'cennik', 'aktualnosci'];
    $tresc = [];
    foreach ($kolekcje as $nazwa) {
        $plik = $katalog . $nazwa . '.json';
        $tresc[$nazwa] = file_exists($plik) ? json_decode(file_get_contents($plik), true) : [];
    }
    return $tresc;
}
