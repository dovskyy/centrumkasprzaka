<?php
// Biblioteka ikon specjalizacji - katalog assets/specialties/ (43 gotowe ikony Healthicons,
// ujednolicone do viewBox 0 0 48 48). Panel pozwala wybrać jedną z nich dla specjalizacji,
// strona generuje z wybranych ikon sprite <symbol>/<use> - żadnych ikon nie trzeba już
// ręcznie dopisywać do index.php.

function cmk_katalog_ikon() {
    return __DIR__ . '/../assets/specialties/';
}

// Lista dostepnych identyfikatorow ikon (nazwy plikow bez .svg), posortowana alfabetycznie.
function cmk_lista_ikon() {
    $pliki = glob(cmk_katalog_ikon() . '*.svg');
    if ($pliki === false) return [];
    $ikony = array_map(fn($p) => basename($p, '.svg'), $pliki);
    sort($ikony);
    return $ikony;
}

// Zwraca sciezke do pliku SVG danej ikony, tylko jesli identyfikator jest na biezacej
// liscie dostepnych ikon (bialna lista - chroni przed path traversal przy budowaniu sciezki).
function cmk_sciezka_ikony($id) {
    if (!in_array($id, cmk_lista_ikon(), true)) return null;
    return cmk_katalog_ikon() . $id . '.svg';
}

// Zwraca gotowy blok <symbol id="icon-{id}">...</symbol> do wstrzykniecia w sprite na stronie,
// albo null jesli ikona nie istnieje / plik jest nieczytelny.
function cmk_ikona_symbol($id) {
    $sciezka = cmk_sciezka_ikony($id);
    if ($sciezka === null || !is_readable($sciezka)) return null;
    $svg = file_get_contents($sciezka);
    // Wnetrze pliku to <svg ...>...</svg> - wyciagamy sama zawartosc (paths), viewBox
    // wszystkich ikon w tym katalogu jest ujednolicony do "0 0 48 48".
    if (!preg_match('/<svg\b[^>]*>(.*)<\/svg>/is', $svg, $m)) return null;
    return '<symbol id="icon-' . htmlspecialchars($id, ENT_QUOTES) . '" viewBox="0 0 48 48">' . $m[1] . '</symbol>';
}
