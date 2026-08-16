<?php
// I/O na plikach data/*.json: wczytywanie, wersje robocze (draft), publikacja, kopie zapasowe.
// Przeniesione bez zmian logiki z dawnego panel/edytuj.php.

function cmk_wczytaj_json($sciezka) {
    if (!file_exists($sciezka)) return [];
    $dane = json_decode(file_get_contents($sciezka), true);
    return is_array($dane) ? $dane : [];
}

function cmk_wczytaj_robocze($opublikowana, $draft) {
    return file_exists($draft) ? cmk_wczytaj_json($draft) : cmk_wczytaj_json($opublikowana);
}

function cmk_zapisz_draft($draft, $dane) {
    file_put_contents($draft, json_encode($dane, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT), LOCK_EX);
}

function cmk_publikuj($kolekcja, $opublikowana, $draft, $katalogKopii) {
    if (!file_exists($draft)) return;
    if (file_exists($opublikowana)) {
        if (!is_dir($katalogKopii)) mkdir($katalogKopii, 0755, true);
        $kopia = $katalogKopii . $kolekcja . '-' . date('Ymd-His') . '.json';
        copy($opublikowana, $kopia);
        cmk_przytnij_kopie($kolekcja, $katalogKopii);
    }
    copy($draft, $opublikowana);
    unlink($draft);
}

// Trzyma tylko ostatnie 20 kopii per kolekcja, zeby data/_kopie/ nie rosla bez konca.
function cmk_przytnij_kopie($kolekcja, $katalogKopii) {
    $pliki = glob($katalogKopii . $kolekcja . '-*.json');
    if ($pliki === false || count($pliki) <= 20) return;
    sort($pliki);
    $doUsuniecia = array_slice($pliki, 0, count($pliki) - 20);
    foreach ($doUsuniecia as $p) unlink($p);
}

function cmk_odrzuc_draft($draft) {
    if (file_exists($draft)) unlink($draft);
}

// $_FILES z polem name="x[]" multiple ma ksztalt "tablica per klucz" ('name'=>[...], 'tmp_name'=>[...]);
// przepakowuje na "tablica per plik", jak w pojedynczym uploadzie, zeby cmk_upload_zdjecie() dzialalo bez zmian.
function cmk_przepakuj_pliki($pliki) {
    if (!is_array($pliki) || !isset($pliki['name']) || !is_array($pliki['name'])) return [];
    $wynik = [];
    foreach ($pliki['name'] as $i => $nazwa) {
        $wynik[] = [
            'name' => $nazwa,
            'type' => $pliki['type'][$i],
            'tmp_name' => $pliki['tmp_name'][$i],
            'error' => $pliki['error'][$i],
            'size' => $pliki['size'][$i],
        ];
    }
    return $wynik;
}

// Parsuje wartosci php.ini jak "64M"/"8M" na bajty (do wstrzykniecia limitu do JS).
function cmk_ini_bajty($wartosc) {
    $wartosc = trim((string) $wartosc);
    if ($wartosc === '') return 0;
    $mnoznik = ['g' => 1024 * 1024 * 1024, 'm' => 1024 * 1024, 'k' => 1024];
    $ostatni = strtolower(substr($wartosc, -1));
    if (isset($mnoznik[$ostatni])) return (int) $wartosc * $mnoznik[$ostatni];
    return (int) $wartosc;
}

// Zamienia nazwę na identyfikator używany w relacji lekarz <-> specjalizacja
// (np. "Medycyna estetyczna" -> "medycyna-estetyczna"), z dopiskiem -2, -3... przy kolizji.
function cmk_unikalny_slug($nazwa, $istniejaceRekordy) {
    $zamiana = ['ą'=>'a','ć'=>'c','ę'=>'e','ł'=>'l','ń'=>'n','ó'=>'o','ś'=>'s','ź'=>'z','ż'=>'z'];
    $slug = strtr(mb_strtolower($nazwa, 'UTF-8'), $zamiana);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');
    if ($slug === '') $slug = 'pozycja';

    $zajete = array_column($istniejaceRekordy, 'id');
    $kandydat = $slug;
    $i = 2;
    while (in_array($kandydat, $zajete, true)) {
        $kandydat = $slug . '-' . $i++;
    }
    return $kandydat;
}

// Sciezki plikow danych dla kolekcji (opublikowana/draft) - jedno miejsce zamiast powtarzania wzorca.
function cmk_sciezki($kolekcja) {
    return [
        'opublikowana' => __DIR__ . '/../../data/' . $kolekcja . '.json',
        'draft' => __DIR__ . '/../../data/' . $kolekcja . '.draft.json',
        'kopie' => __DIR__ . '/../../data/_kopie/',
    ];
}

function cmk_liczba_pozycji_z_danych($kolekcja, $dane) {
    if ($kolekcja === 'cennik') {
        $n = 0;
        foreach ($dane as $kat) $n += count($kat['pozycje'] ?? []);
        return $n;
    }
    return count($dane);
}
