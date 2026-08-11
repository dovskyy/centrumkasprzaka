<?php
// Jedno miejsce, w ktorym rekord aktualnosci dostaje ostateczny ksztalt: uzupelnia braki,
// tlumaczy stary format (pojedyncze "zdjecie") na nowy ("zdjecia"), odsiewa wpisy po terminie
// i sortuje. Dzieki temu index.php i aktualnosci.php renderuja juz gotowa liste,
// a JS nie duplikuje zadnej logiki.

define('CMK_TYPY_AKTUALNOSCI', [
    'aktualnosc' => 'Aktualność',
    'promocja'   => 'Promocja',
    'wydarzenie' => 'Wydarzenie',
]);

function cmk_normalizuj_aktualnosci($lista) {
    if (!is_array($lista)) return [];
    date_default_timezone_set('Europe/Warsaw');
    $dzis = date('Y-m-d');
    $miesiace = ['stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia'];

    $wynik = [];
    foreach (array_values($lista) as $indeksWejsciowy => $rekord) {
        if (!is_array($rekord) || empty($rekord['id'])) continue;

        $r = [];
        $r['id'] = (string) $rekord['id'];
        $r['tytul'] = (string) ($rekord['tytul'] ?? '');

        if (isset($rekord['zdjecia']) && is_array($rekord['zdjecia'])) {
            $r['zdjecia'] = array_values(array_filter($rekord['zdjecia'], function ($z) {
                return is_string($z) && $z !== '';
            }));
        } elseif (!empty($rekord['zdjecie']) && is_string($rekord['zdjecie'])) {
            $r['zdjecia'] = [$rekord['zdjecie']];
        } else {
            $r['zdjecia'] = [];
        }

        $typ = $rekord['typ'] ?? 'aktualnosc';
        if (!array_key_exists($typ, CMK_TYPY_AKTUALNOSCI)) $typ = 'aktualnosc';
        $r['typ'] = $typ;
        $r['typEtykieta'] = CMK_TYPY_AKTUALNOSCI[$typ];

        $data = (string) ($rekord['data'] ?? '');
        $r['data'] = preg_match('/^\d{4}-\d{2}-\d{2}$/', $data) ? $data : '';

        $dataDo = (string) ($rekord['dataDo'] ?? '');
        $dataDo = preg_match('/^\d{4}-\d{2}-\d{2}$/', $dataDo) ? $dataDo : '';
        if ($dataDo !== '' && $dataDo < $dzis) continue; // promocja po terminie znika ze strony
        $r['dataDo'] = $dataDo;

        $r['przypiety'] = !empty($rekord['przypiety']);

        $r['dataOpis'] = cmk_data_opis($r['data'], $miesiace);
        $r['dataDoOpis'] = cmk_data_opis($r['dataDo'], $miesiace);

        $tresc = str_replace(["\r\n", "\r"], "\n", (string) ($rekord['tresc'] ?? ''));
        $akapity = $tresc !== '' ? explode("\n\n", $tresc) : [];
        $r['akapity'] = $akapity;
        $r['zajawka'] = cmk_przytnij_zajawke($akapity[0] ?? '', 180);

        $r['href'] = 'aktualnosci.php?post=' . rawurlencode($r['id']);

        $r['ctaEtykieta'] = (string) ($rekord['ctaEtykieta'] ?? '');
        $ctaUrl = (string) ($rekord['ctaUrl'] ?? '');
        $r['ctaUrl'] = preg_match('#^(https?://|mailto:|tel:)#i', $ctaUrl) ? $ctaUrl : '';

        $wynik[] = ['rekord' => $r, 'indeks' => $indeksWejsciowy];
    }

    usort($wynik, function ($a, $b) {
        $ra = $a['rekord'];
        $rb = $b['rekord'];
        if ($ra['przypiety'] !== $rb['przypiety']) return $ra['przypiety'] ? -1 : 1;
        if ($ra['data'] !== $rb['data']) return $ra['data'] < $rb['data'] ? 1 : -1;
        return $a['indeks'] <=> $b['indeks'];
    });

    return array_values(array_map(function ($w) { return $w['rekord']; }, $wynik));
}

function cmk_data_opis($iso, $miesiace) {
    if ($iso === '') return '';
    $czesci = array_map('intval', explode('-', $iso));
    return $czesci[2] . ' ' . $miesiace[$czesci[1] - 1] . ' ' . $czesci[0];
}

// Przycina do granicy slowa (nie w polowie wyrazu) - uzywane w kafelkach i <meta description>.
function cmk_przytnij_zajawke($tekst, $limit) {
    $tekst = trim($tekst);
    if (mb_strlen($tekst, 'UTF-8') <= $limit) return $tekst;
    $przyciete = mb_substr($tekst, 0, $limit, 'UTF-8');
    $ostatniaSpacja = mb_strrpos($przyciete, ' ', 0, 'UTF-8');
    if ($ostatniaSpacja !== false) $przyciete = mb_substr($przyciete, 0, $ostatniaSpacja, 'UTF-8');
    return rtrim($przyciete) . '…';
}
