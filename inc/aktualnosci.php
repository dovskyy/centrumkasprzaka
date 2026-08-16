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
        $r['akapity'] = $akapity; // zachowane dla kompatybilnosci (stary format renderowania)
        $r['trescHtml'] = cmk_tresc_html($tresc);
        $r['zajawka'] = cmk_przytnij_zajawke(cmk_tresc_bez_znacznikow($akapity[0] ?? ''), 180);

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

// Konwerter tresci aktualnosci z prostego, zamknietego zbioru znacznikow na bezpieczny HTML.
// Kolejnosc operacji jest krytyczna dla bezpieczenstwa: najpierw htmlspecialchars() calego
// tekstu, potem podmiana znacznikow na tagi - wynik z definicji nie moze zawierac HTML-a
// wpisanego przez uzytkownika (nawet gdyby wpisal <script> recznie, trafi jako tekst).
// Zbior regul (utrzymywac zsynchronizowany z podgladem JS w panel/assets/panel.js):
//   ## / ### tekst        -> <h3>
//   - tekst / * tekst      -> <li> w <ul>
//   **tekst**              -> <strong>, *tekst* -> <em>
//   [napis](url)           -> <a>, whitelist schematow https?://|mailto:|tel:
//   pusta linia            -> nowy <p>
function cmk_tresc_html($tresc) {
    $tresc = str_replace(["\r\n", "\r"], "\n", (string) $tresc);
    if (trim($tresc) === '') return '';
    $esc = htmlspecialchars($tresc, ENT_QUOTES, 'UTF-8');

    $linie = explode("\n", $esc);
    $html = '';
    $wLiscie = false;
    $akapit = [];

    $domknijAkapit = function () use (&$html, &$akapit) {
        if (!empty($akapit)) {
            $html .= '<p>' . implode(' ', $akapit) . '</p>';
            $akapit = [];
        }
    };

    foreach ($linie as $linia) {
        if (preg_match('/^#{2,3}\s+(.*)$/', $linia, $m)) {
            $domknijAkapit();
            if ($wLiscie) { $html .= '</ul>'; $wLiscie = false; }
            $html .= '<h3>' . $m[1] . '</h3>';
        } elseif (preg_match('/^[-*]\s+(.*)$/', $linia, $m)) {
            $domknijAkapit();
            if (!$wLiscie) { $html .= '<ul>'; $wLiscie = true; }
            $html .= '<li>' . $m[1] . '</li>';
        } elseif (trim($linia) === '') {
            if ($wLiscie) { $html .= '</ul>'; $wLiscie = false; }
            $domknijAkapit();
        } else {
            $akapit[] = $linia;
        }
    }
    if ($wLiscie) $html .= '</ul>';
    $domknijAkapit();

    $html = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $html);
    $html = preg_replace('/\*(.+?)\*/s', '<em>$1</em>', $html);
    $html = preg_replace_callback('/\[([^\]]+)\]\((https?:\/\/[^\s)]+|mailto:[^\s)]+|tel:[^\s)]+)\)/i', function ($m) {
        return '<a href="' . $m[2] . '" target="_blank" rel="noopener">' . $m[1] . '</a>';
    }, $html);

    return $html;
}

// Usuwa znaczniki (##, **, -, [..](..)) z tekstu - uzywane do liczenia zajawki, zeby
// "### Nowi specjalisci" nie trafialo z hashami do <meta description>.
function cmk_tresc_bez_znacznikow($tekst) {
    $tekst = preg_replace('/^#{2,3}\s+/', '', $tekst);
    $tekst = preg_replace('/^[-*]\s+/', '', $tekst);
    $tekst = preg_replace('/\*\*(.+?)\*\*/s', '$1', $tekst);
    $tekst = preg_replace('/\*(.+?)\*/s', '$1', $tekst);
    $tekst = preg_replace('/\[([^\]]+)\]\([^)]+\)/', '$1', $tekst);
    return trim($tekst);
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
