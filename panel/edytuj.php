<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/upload.php';
require_once __DIR__ . '/../inc/ikony.php';
require_once __DIR__ . '/../inc/aktualnosci.php';
cmk_require_login();

$kolekcje = ['lekarze', 'specjalizacje', 'cennik', 'aktualnosci'];
$kolekcja = $_GET['kolekcja'] ?? '';
if (!in_array($kolekcja, $kolekcje, true)) {
    header('Location: index.php');
    exit;
}

$sciezkaOpublikowana = __DIR__ . '/../data/' . $kolekcja . '.json';
$sciezkaDraft = __DIR__ . '/../data/' . $kolekcja . '.draft.json';
$katalogKopii = __DIR__ . '/../data/_kopie/';

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
    if ($slug === '') $slug = 'specjalizacja';

    $zajete = array_column($istniejaceRekordy, 'id');
    $kandydat = $slug;
    $i = 2;
    while (in_array($kandydat, $zajete, true)) {
        $kandydat = $slug . '-' . $i++;
    }
    return $kandydat;
}

// Schemat pol dla kolekcji plaskich (lista rekordow). Cennik (kategorie + pozycje) ma osobna obsluge nizej.
// Lista specjalizacji jako opcje do zaznaczenia przy lekarzu (relacja wiele-do-wielu).
// Czytana zawsze z opublikowanej wersji - zmiana nazw specjalizacji w toku (draft) nie
// przestawia tu etykiet, dopóki nie zostanie opublikowana (rzadki, akceptowalny przypadek).
$opcjeSpecjalizacji = [];
foreach (cmk_wczytaj_json(__DIR__ . '/../data/specjalizacje.json') as $s) {
    if (!empty($s['id'])) $opcjeSpecjalizacji[$s['id']] = $s['nazwa'] ?? $s['id'];
}

$schematy = [
    'lekarze' => [
        'etykieta_listy' => 'Lekarze',
        'tytul' => fn($it) => $it['imie'] ?? '(nowy lekarz)',
        'pola' => [
            'imie' => ['etykieta' => 'Imię i nazwisko', 'typ' => 'text', 'wymagane' => true],
            'podtytul' => ['etykieta' => 'Podtytuł widoczny na karcie (np. "USG dzieci")', 'typ' => 'text', 'wymagane' => true],
            'specjalizacje' => ['etykieta' => 'Wykonywane specjalizacje', 'typ' => 'multi-wybor', 'opcje' => $opcjeSpecjalizacji],
            'zakres' => ['etykieta' => 'Zakres usług', 'typ' => 'textarea'],
            'pacjenci' => ['etykieta' => 'Pacjenci (np. Dorośli)', 'typ' => 'text'],
            'zdjecie' => ['etykieta' => 'Zdjęcie', 'typ' => 'zdjecie'],
            'widgetHtml' => ['etykieta' => 'Widget ZnanyLekarz tego lekarza (opcjonalnie) — wklej tu CAŁY kod widgetu skopiowany z panelu ZnanyLekarz (link + skrypt), bez zmian. Jeśli puste, przycisk „Umów” otwiera ogólny kalendarz placówki.', 'typ' => 'textarea'],
            'naStronieGlownej' => ['etykieta' => 'Pokaż na stronie głównej', 'typ' => 'checkbox'],
        ],
    ],
    'specjalizacje' => [
        'etykieta_listy' => 'Specjalizacje',
        'tytul' => fn($it) => $it['nazwa'] ?? '(nowa specjalizacja)',
        'pola' => [
            'nazwa' => ['etykieta' => 'Nazwa', 'typ' => 'text', 'wymagane' => true],
            'opis' => ['etykieta' => 'Krótki opis', 'typ' => 'text'],
            'ikona' => ['etykieta' => 'Ikona (tylko dla kafli na stronie głównej)', 'typ' => 'ikona-picker', 'opcje' => cmk_lista_ikon()],
            'naStronieGlownej' => ['etykieta' => 'Pokaż jako kafel na stronie głównej', 'typ' => 'checkbox'],
        ],
    ],
    'aktualnosci' => [
        'etykieta_listy' => 'Aktualności',
        'tytul' => fn($it) => $it['tytul'] ?? '(nowy wpis)',
        'miniatura' => function ($it) {
            if (!empty($it['zdjecia'][0]) && is_string($it['zdjecia'][0])) return $it['zdjecia'][0];
            if (!empty($it['zdjecie']) && is_string($it['zdjecie'])) return $it['zdjecie'];
            return null;
        },
        'podtytul' => function ($it) {
            $typ = $it['typ'] ?? 'aktualnosc';
            if (!array_key_exists($typ, CMK_TYPY_AKTUALNOSCI)) $typ = 'aktualnosc';
            $bity = [htmlspecialchars(CMK_TYPY_AKTUALNOSCI[$typ])];
            if (!empty($it['data'])) $bity[] = htmlspecialchars($it['data']);
            $tekst = implode(' · ', $bity);
            $dataDo = (string) ($it['dataDo'] ?? '');
            if ($dataDo !== '' && $dataDo < date('Y-m-d')) {
                $tekst .= ' <span style="color:#b42318; font-weight:var(--weight-semibold);">— Nie pokazuje się na stronie, minął termin (widoczne do ' . htmlspecialchars($dataDo) . ')</span>';
            }
            return $tekst;
        },
        'pola' => [
            'tytul'       => ['etykieta' => 'Tytuł', 'typ' => 'text', 'wymagane' => true],
            'typ'         => ['etykieta' => 'Rodzaj wpisu', 'typ' => 'wybor', 'opcje' => CMK_TYPY_AKTUALNOSCI],
            'data'        => ['etykieta' => 'Data wpisu', 'typ' => 'data', 'wymagane' => true],
            'dataDo'      => ['etykieta' => 'Widoczne do (opcjonalnie) — po tym dniu wpis sam zniknie ze strony', 'typ' => 'data'],
            'tresc'       => ['etykieta' => 'Treść (pusta linia = nowy akapit). Można zostawić puste, jeśli wpis to samo zdjęcie.', 'typ' => 'textarea'],
            'zdjecia'     => ['etykieta' => 'Zdjęcia (można dodać kilka naraz; wpis działa też bez żadnego)', 'typ' => 'galeria'],
            'ctaEtykieta' => ['etykieta' => 'Napis na przycisku (opcjonalnie, np. „Umów badanie")', 'typ' => 'text'],
            'ctaUrl'      => ['etykieta' => 'Adres przycisku (https://…, tel:… albo mailto:…)', 'typ' => 'text'],
            'przypiety'   => ['etykieta' => 'Przypnij na górze listy', 'typ' => 'checkbox'],
        ],
    ],
];

$akcja = $_GET['akcja'] ?? ($_POST['akcja'] ?? 'lista');
$komunikat = null;

// PHP czysci $_POST/$_FILES w calosci, gdy przekroczony post_max_size - bez tej detekcji
// formularz "nic nie robi", a wpisana tresc przepada bez zadnego komunikatu.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && (int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
    $komunikat = 'Przesłane zdjęcia są za duże (limit serwera: ' . ini_get('post_max_size')
        . '). Dodaj mniej zdjęć naraz albo zmniejsz je przed wysłaniem.';
    $akcja = 'formularz';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($akcja === 'opublikuj') {
        cmk_publikuj($kolekcja, $sciezkaOpublikowana, $sciezkaDraft, $katalogKopii);
        header('Location: edytuj.php?kolekcja=' . urlencode($kolekcja) . '&info=opublikowano');
        exit;
    }
    if ($akcja === 'odrzuc') {
        cmk_odrzuc_draft($sciezkaDraft);
        header('Location: edytuj.php?kolekcja=' . urlencode($kolekcja) . '&info=odrzucono');
        exit;
    }

    if ($kolekcja !== 'cennik' && $akcja === 'zapisz') {
        $dane = cmk_wczytaj_robocze($sciezkaOpublikowana, $sciezkaDraft);
        $pola = $schematy[$kolekcja]['pola'];
        $poz = $_POST['poz'];

        $rekord = ($poz !== 'nowy' && isset($dane[(int) $poz])) ? $dane[(int) $poz] : [];
        $bledy = [];
        foreach ($pola as $klucz => $def) {
            if ($def['typ'] === 'checkbox') {
                $rekord[$klucz] = isset($_POST[$klucz]);
                continue;
            }
            if ($def['typ'] === 'multi-wybor') {
                $wybrane = $_POST[$klucz] ?? [];
                $rekord[$klucz] = array_values(array_intersect($wybrane, array_keys($def['opcje'])));
                continue;
            }
            if ($def['typ'] === 'zdjecie') {
                if (!empty($_FILES[$klucz]['name'])) {
                    $wynik = cmk_upload_zdjecie($_FILES[$klucz]);
                    if (is_array($wynik)) { $bledy[] = $wynik['blad']; }
                    else { $rekord[$klucz] = $wynik; }
                } elseif (!empty($_POST[$klucz . '_usun'])) {
                    $rekord[$klucz] = null;
                } elseif (!array_key_exists($klucz, $rekord)) {
                    $rekord[$klucz] = null;
                }
                continue;
            }
            if ($def['typ'] === 'wybor') {
                $klucze = array_keys($def['opcje']);
                $wartosc = (string) ($_POST[$klucz] ?? '');
                $rekord[$klucz] = in_array($wartosc, $klucze, true) ? $wartosc : ($klucze[0] ?? '');
                continue;
            }
            if ($def['typ'] === 'data') {
                $wartosc = trim((string) ($_POST[$klucz] ?? ''));
                if ($wartosc !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $wartosc)) {
                    $bledy[] = $def['etykieta'] . ' ma nieprawidłowy format daty.';
                } elseif (!empty($def['wymagane']) && $wartosc === '') {
                    $bledy[] = $def['etykieta'] . ' jest wymagane.';
                }
                $rekord[$klucz] = $wartosc;
                continue;
            }
            if ($def['typ'] === 'galeria') {
                $istniejace = $_POST['zdjecia_istniejace'] ?? [];
                $usunSet = $_POST['zdjecia_usun'] ?? [];
                $zachowane = [];
                foreach ($istniejace as $sciezka) {
                    $sciezka = (string) $sciezka;
                    if (in_array($sciezka, $usunSet, true)) continue;
                    if (!preg_match('#^uploads/[A-Za-z0-9._-]+$#', $sciezka)) continue;
                    if (!file_exists(__DIR__ . '/../' . $sciezka)) continue;
                    $zachowane[] = $sciezka;
                }
                foreach (cmk_przepakuj_pliki($_FILES['zdjecia_nowe'] ?? null) as $plikNowy) {
                    if ($plikNowy['error'] === UPLOAD_ERR_NO_FILE) continue;
                    $wynik = cmk_upload_zdjecie($plikNowy, 1400);
                    if (is_array($wynik)) { $bledy[] = $wynik['blad']; }
                    else { $zachowane[] = $wynik; }
                }
                if (count($zachowane) > 8) {
                    $bledy[] = 'Maksymalnie 8 zdjęć na wpis.';
                }
                $rekord[$klucz] = $zachowane;
                unset($rekord['zdjecie']);
                continue;
            }
            // Przegladarka wysyla wieloliniowy tekst z \r\n - bez normalizacji explode("\n\n", ...)
            // w inc/aktualnosci.php nigdy by nie trafil na pusta linie i akapity by sie nie rozdzielily.
            $wartosc = trim(str_replace(["\r\n", "\r"], "\n", (string) ($_POST[$klucz] ?? '')));
            if (!empty($def['wymagane']) && $wartosc === '') {
                $bledy[] = $def['etykieta'] . ' jest wymagane.';
            }
            if ($klucz === 'ctaUrl' && $wartosc !== '' && !preg_match('#^(https?://|mailto:|tel:)#i', $wartosc)) {
                $bledy[] = 'Adres przycisku musi zaczynać się od https://, http://, mailto: albo tel:.';
            }
            $rekord[$klucz] = $wartosc;
        }

        if (in_array($kolekcja, ['specjalizacje', 'aktualnosci'], true) && empty($rekord['id'])) {
            $rekord['id'] = cmk_unikalny_slug($rekord['nazwa'] ?? $rekord['tytul'] ?? '', $dane);
        }

        if (empty($bledy)) {
            if ($poz === 'nowy') $dane[] = $rekord;
            else $dane[(int) $poz] = $rekord;
            cmk_zapisz_draft($sciezkaDraft, array_values($dane));
            header('Location: edytuj.php?kolekcja=' . urlencode($kolekcja));
            exit;
        }
        $komunikat = implode(' ', $bledy);
        $akcja = 'formularz';
    }

    if ($akcja === 'usun') {
        $dane = cmk_wczytaj_robocze($sciezkaOpublikowana, $sciezkaDraft);
        $poz = (int) $_POST['poz'];
        unset($dane[$poz]);
        cmk_zapisz_draft($sciezkaDraft, array_values($dane));
        header('Location: edytuj.php?kolekcja=' . urlencode($kolekcja));
        exit;
    }

    if ($akcja === 'przesun') {
        $dane = cmk_wczytaj_robocze($sciezkaOpublikowana, $sciezkaDraft);
        $poz = (int) $_POST['poz'];
        $kierunek = $_POST['kierunek'] === 'gora' ? -1 : 1;
        $docelowa = $poz + $kierunek;
        if (isset($dane[$poz]) && isset($dane[$docelowa])) {
            [$dane[$poz], $dane[$docelowa]] = [$dane[$docelowa], $dane[$poz]];
        }
        cmk_zapisz_draft($sciezkaDraft, array_values($dane));
        header('Location: edytuj.php?kolekcja=' . urlencode($kolekcja));
        exit;
    }

    // Cennik: kategorie + pozycje, zapisywane jako calosc jednej kategorii naraz.
    if ($kolekcja === 'cennik' && $akcja === 'zapisz-kategoria') {
        $dane = cmk_wczytaj_robocze($sciezkaOpublikowana, $sciezkaDraft);
        $poz = $_POST['poz'];
        $kategoria = trim((string) $_POST['kategoria']);
        $pozycje = [];
        foreach ($_POST['pozycja_nazwa'] as $i => $nazwa) {
            $nazwa = trim((string) $nazwa);
            if ($nazwa === '') continue;
            $pozycja = ['nazwa' => $nazwa, 'cena' => trim((string) $_POST['pozycja_cena'][$i])];
            $czas = trim((string) ($_POST['pozycja_czas'][$i] ?? ''));
            $opis = trim((string) ($_POST['pozycja_opis'][$i] ?? ''));
            if ($czas !== '') $pozycja['czas'] = $czas;
            if ($opis !== '') $pozycja['opis'] = $opis;
            $pozycje[] = $pozycja;
        }
        $wpis = ['kategoria' => $kategoria, 'pozycje' => $pozycje];
        if ($kategoria !== '') {
            if ($poz === 'nowy') $dane[] = $wpis;
            else $dane[(int) $poz] = $wpis;
            cmk_zapisz_draft($sciezkaDraft, array_values($dane));
        }
        header('Location: edytuj.php?kolekcja=cennik');
        exit;
    }
}

$dane = cmk_wczytaj_robocze($sciezkaOpublikowana, $sciezkaDraft);
$maDraft = file_exists($sciezkaDraft);

if ($_GET['info'] ?? null) {
    $komunikat = $_GET['info'] === 'opublikowano' ? 'Opublikowano zmiany.' : 'Odrzucono wersję roboczą.';
}

$podgladCel = [
    'lekarze' => 'specjalisci.php',
    'specjalizacje' => 'index.php',
    'cennik' => 'cennik.php',
    'aktualnosci' => 'aktualnosci.php',
][$kolekcja];

$edytowanaPoz = $_GET['poz'] ?? null;
$edytowanyRekord = ($edytowanaPoz !== null && $edytowanaPoz !== 'nowy' && isset($dane[(int) $edytowanaPoz]))
    ? $dane[(int) $edytowanaPoz]
    : [];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Panel — <?= htmlspecialchars($schematy[$kolekcja]['etykieta_listy'] ?? 'Cennik') ?></title>
<link rel="stylesheet" href="../_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/fonts.css">
<link rel="stylesheet" href="../_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/colors.css">
<link rel="stylesheet" href="../_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/typography.css">
<link rel="stylesheet" href="../_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/spacing.css">
<link rel="stylesheet" href="../_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/radius.css">
<link rel="stylesheet" href="../_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/base.css">
<style>
  body { margin:0; background:var(--surface-subtle); color:var(--text-body); font-family:var(--font-body); }
  .wrap { max-width:760px; margin:0 auto; padding:32px 20px 80px; }
  .top { display:flex; align-items:center; justify-content:space-between; margin-bottom:8px; flex-wrap:wrap; gap:8px; }
  .top a { font-size:14px; color:var(--text-muted); text-decoration:none; }
  h1 { font-family:var(--font-display); font-size:22px; margin:0 0 20px; color:var(--navy-900); }
  .tabs { display:flex; gap:6px; margin-bottom:24px; flex-wrap:wrap; }
  .tabs a { padding:8px 14px; border-radius:var(--radius-pill); text-decoration:none; font-size:14px; color:var(--navy-800); border:1px solid var(--border-subtle); }
  .tabs a.aktywna { background:var(--navy-900); color:var(--white); border-color:var(--navy-900); }
  .card { background:var(--white); border:1px solid var(--border-subtle); border-radius:var(--radius-card); box-shadow:var(--shadow-xs); padding:24px; margin-bottom:16px; }
  .info { padding:12px 14px; border-radius:var(--radius-md); background:var(--success-100, #e6f4ea); color:var(--success-700, #1e7b34); font-size:14px; margin-bottom:16px; }
  .blad { padding:12px 14px; border-radius:var(--radius-md); background:#fdecec; color:#b42318; font-size:14px; margin-bottom:16px; }
  .draft-pasek { display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; padding:14px 18px; border-radius:var(--radius-md); background:var(--blue-050); border:1px solid var(--blue-200); margin-bottom:20px; }
  .draft-pasek span { font-size:14px; color:var(--navy-800); }
  .btn { padding:9px 16px; border:none; border-radius:var(--radius-pill); font-family:var(--font-display); font-weight:var(--weight-semibold); font-size:14px; cursor:pointer; text-decoration:none; display:inline-block; }
  .btn-primary { background:var(--action-primary); color:var(--white); }
  .btn-secondary { background:var(--white); color:var(--navy-800); border:1px solid var(--border-default); }
  .btn-danger { background:var(--white); color:#b42318; border:1px solid #f3c6c2; }
  .btn-small { padding:5px 10px; font-size:12.5px; }
  .lista-item { display:flex; align-items:center; justify-content:space-between; gap:12px; padding:14px 16px; border:1px solid var(--border-subtle); border-radius:var(--radius-md); margin-bottom:10px; background:var(--white); }
  .lista-item .nazwa { font-family:var(--font-display); font-weight:var(--weight-semibold); color:var(--navy-900); }
  .lista-item .akcje { display:flex; gap:6px; align-items:center; flex-shrink:0; }
  form.inline { display:inline; }
  label { display:block; font-size:14px; font-weight:var(--weight-medium); color:var(--navy-800); margin:16px 0 6px; }
  label:first-child { margin-top:0; }
  input[type=text], input[type=date], textarea, select { width:100%; box-sizing:border-box; padding:10px 12px; border:1px solid var(--border-default); border-radius:var(--radius-md); font-size:15px; font-family:inherit; }
  textarea { min-height:110px; resize:vertical; }
  .galeria-lista { display:flex; flex-wrap:wrap; gap:10px; margin-top:8px; }
  .galeria-item { display:flex; flex-direction:column; align-items:center; gap:6px; width:100px; padding:8px; border:1px solid var(--border-subtle); border-radius:var(--radius-md); background:var(--white); }
  .galeria-item img { width:80px; height:80px; object-fit:cover; border-radius:var(--radius-md); }
  .galeria-item-akcje { display:flex; align-items:center; gap:4px; }
  .galeria-usun { display:flex; align-items:center; gap:4px; font-size:11px; font-weight:normal; color:#b42318; margin:0; }
  .galeria-usun input { width:auto; }
  .checkbox-row { display:flex; align-items:center; gap:8px; margin:16px 0 6px; }
  .checkbox-row input { width:auto; }
  .checkbox-row label { margin:0; }
  .zdjecie-podglad { display:flex; align-items:center; gap:14px; margin-top:6px; }
  .zdjecie-podglad img { width:64px; height:64px; object-fit:cover; border-radius:var(--radius-md); border:1px solid var(--border-subtle); }
  .form-akcje { margin-top:24px; display:flex; gap:10px; }
  .pozycja-row { display:grid; grid-template-columns:2fr 1fr 1fr 1.5fr auto; gap:8px; margin-bottom:8px; align-items:center; }
  .pozycja-row input { padding:8px 10px; font-size:14px; }
  .pozycja-usun { background:none; border:none; color:#b42318; cursor:pointer; font-size:18px; line-height:1; padding:6px; }
  @media (max-width:640px) { .pozycja-row { grid-template-columns:1fr; } }

  .ikona-picker { display:flex; flex-wrap:wrap; gap:8px; }
  .ikona-item { display:flex; align-items:center; justify-content:center; width:52px; height:52px; border:1px solid var(--border-default); border-radius:var(--radius-md); cursor:pointer; background:var(--white); }
  .ikona-item:hover { border-color:var(--blue-200); }
  .ikona-item.wybrana { border-color:var(--action-primary); background:var(--blue-050); box-shadow:0 0 0 1px var(--action-primary) inset; }
  .ikona-item--brak { width:auto; padding:0 12px; font-size:12.5px; color:var(--text-muted); }
  .ikona-stronicowanie { display:flex; align-items:center; gap:12px; margin-top:10px; }
  .ikona-strona-info { font-size:13px; color:var(--text-muted); }
</style>
</head>
<body>
<div class="wrap">
  <div class="top">
    <a href="index.php">&larr; Panel</a>
    <a href="logout.php">Wyloguj</a>
  </div>
  <h1><?= htmlspecialchars($schematy[$kolekcja]['etykieta_listy'] ?? 'Cennik') ?></h1>

  <div class="tabs">
    <?php foreach ($kolekcje as $k): ?>
      <a href="edytuj.php?kolekcja=<?= urlencode($k) ?>" class="<?= $k === $kolekcja ? 'aktywna' : '' ?>"><?= htmlspecialchars(ucfirst($k)) ?></a>
    <?php endforeach; ?>
  </div>

  <?php if ($komunikat): ?><div class="<?= $akcja === 'formularz' ? 'blad' : 'info' ?>"><?= htmlspecialchars($komunikat) ?></div><?php endif; ?>

  <?php if ($maDraft): ?>
    <div class="draft-pasek">
      <span>Masz niezapisane (niepublikowane) zmiany w tej kolekcji.</span>
      <div class="akcje">
        <a class="btn btn-secondary btn-small" href="../<?= htmlspecialchars($podgladCel) ?>?podglad=1" target="_blank">Podgląd na stronie</a>
        <form class="inline" method="post"><input type="hidden" name="akcja" value="opublikuj"><button class="btn btn-primary btn-small" type="submit">Opublikuj</button></form>
        <form class="inline" method="post" onsubmit="return confirm('Odrzucić wersję roboczą i wrócić do opublikowanej treści?');"><input type="hidden" name="akcja" value="odrzuc"><button class="btn btn-danger btn-small" type="submit">Odrzuć</button></form>
      </div>
    </div>
  <?php endif; ?>

  <?php if ($kolekcja !== 'cennik'): ?>

    <?php if ($akcja === 'formularz' || ($edytowanaPoz !== null)): ?>
      <?php $pola = $schematy[$kolekcja]['pola']; $poz = $edytowanaPoz ?? 'nowy'; $rekord = $edytowanyRekord; ?>
      <div class="card">
        <?php if ($kolekcja === 'aktualnosci'): ?>
          <p style="font-size:13px; line-height:1.5; color:var(--navy-800); background:var(--blue-050); border:1px solid var(--blue-200); border-radius:var(--radius-md); padding:12px 14px; margin:0 0 20px;">
            <strong>Jak to działa:</strong> wpis pojawia się na stronie głównej i w zakładce „Aktualności" dopiero po kliknięciu <strong>Opublikuj</strong>. Zdjęcia możesz dodać albo zostawić bez nich. Pole „Widoczne do" sprawia, że promocja sama zniknie ze strony po tym dniu.
          </p>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
          <input type="hidden" name="akcja" value="zapisz">
          <input type="hidden" name="poz" value="<?= htmlspecialchars($poz) ?>">
          <?php foreach ($pola as $klucz => $def): ?>
            <?php if ($def['typ'] === 'text'): ?>
              <label for="<?= $klucz ?>"><?= htmlspecialchars($def['etykieta']) ?></label>
              <input type="text" id="<?= $klucz ?>" name="<?= $klucz ?>" value="<?= htmlspecialchars($rekord[$klucz] ?? '') ?>">
            <?php elseif ($def['typ'] === 'textarea'): ?>
              <label for="<?= $klucz ?>"><?= htmlspecialchars($def['etykieta']) ?></label>
              <textarea id="<?= $klucz ?>" name="<?= $klucz ?>"><?= htmlspecialchars($rekord[$klucz] ?? '') ?></textarea>
            <?php elseif ($def['typ'] === 'wybor'): ?>
              <label for="<?= $klucz ?>"><?= htmlspecialchars($def['etykieta']) ?></label>
              <select id="<?= $klucz ?>" name="<?= $klucz ?>">
                <?php foreach ($def['opcje'] as $wartosc => $etykietaOpcji): ?>
                  <option value="<?= htmlspecialchars($wartosc) ?>" <?= ($rekord[$klucz] ?? '') === $wartosc ? 'selected' : '' ?>><?= htmlspecialchars($etykietaOpcji) ?></option>
                <?php endforeach; ?>
              </select>
            <?php elseif ($def['typ'] === 'data'): ?>
              <label for="<?= $klucz ?>"><?= htmlspecialchars($def['etykieta']) ?></label>
              <input type="date" id="<?= $klucz ?>" name="<?= $klucz ?>" value="<?= htmlspecialchars($rekord[$klucz] ?? '') ?>">
            <?php elseif ($def['typ'] === 'galeria'): ?>
              <label><?= htmlspecialchars($def['etykieta']) ?></label>
              <div class="galeria-lista" data-klucz="<?= $klucz ?>">
                <?php foreach ((array) ($rekord[$klucz] ?? []) as $sciezka): if (!is_string($sciezka) || $sciezka === '') continue; ?>
                  <div class="galeria-item">
                    <img src="../<?= htmlspecialchars($sciezka) ?>" alt="">
                    <input type="hidden" name="zdjecia_istniejace[]" value="<?= htmlspecialchars($sciezka) ?>">
                    <div class="galeria-item-akcje">
                      <button type="button" class="btn btn-secondary btn-small" data-galeria-gora title="Przesuń w lewo">&uarr;</button>
                      <button type="button" class="btn btn-secondary btn-small" data-galeria-dol title="Przesuń w prawo">&darr;</button>
                    </div>
                    <label class="galeria-usun"><input type="checkbox" name="zdjecia_usun[]" value="<?= htmlspecialchars($sciezka) ?>"> Usuń</label>
                  </div>
                <?php endforeach; ?>
              </div>
              <input type="file" name="zdjecia_nowe[]" multiple accept="image/jpeg,image/png,image/webp" style="margin-top:10px;">
              <p style="font-size:13px; color:var(--text-muted); margin:6px 0 0;">Maksymalnie 8 zdjęć na wpis.</p>
            <?php elseif ($def['typ'] === 'checkbox'): ?>
              <div class="checkbox-row">
                <input type="checkbox" id="<?= $klucz ?>" name="<?= $klucz ?>" <?= !empty($rekord[$klucz]) ? 'checked' : '' ?>>
                <label for="<?= $klucz ?>"><?= htmlspecialchars($def['etykieta']) ?></label>
              </div>
            <?php elseif ($def['typ'] === 'multi-wybor'): ?>
              <label><?= htmlspecialchars($def['etykieta']) ?></label>
              <?php if (empty($def['opcje'])): ?>
                <p style="font-size:13px; color:var(--text-muted); margin:0;">Brak zdefiniowanych specjalizacji — dodaj je najpierw w zakładce „Specjalizacje".</p>
              <?php else: $wybrane = $rekord[$klucz] ?? []; ?>
                <div style="display:flex; flex-direction:column; gap:8px;">
                  <?php foreach ($def['opcje'] as $wartosc => $etykietaOpcji): ?>
                    <div class="checkbox-row">
                      <input type="checkbox" id="<?= $klucz . '_' . $wartosc ?>" name="<?= $klucz ?>[]" value="<?= htmlspecialchars($wartosc) ?>" <?= in_array($wartosc, $wybrane, true) ? 'checked' : '' ?>>
                      <label for="<?= $klucz . '_' . $wartosc ?>" style="margin:0;"><?= htmlspecialchars($etykietaOpcji) ?></label>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            <?php elseif ($def['typ'] === 'ikona-picker'): ?>
              <?php $ikonaWybrana = $rekord[$klucz] ?? ''; $naStrone = 15; $strony = array_chunk($def['opcje'], $naStrone); ?>
              <label><?= htmlspecialchars($def['etykieta']) ?></label>
              <input type="hidden" id="<?= $klucz ?>" name="<?= $klucz ?>" value="<?= htmlspecialchars($ikonaWybrana) ?>">
              <div class="ikona-picker" data-klucz="<?= $klucz ?>">
                <label class="ikona-item ikona-item--brak <?= $ikonaWybrana === '' ? 'wybrana' : '' ?>" data-ikona-wybor="">
                  <span>Brak</span>
                </label>
                <?php foreach ($strony as $nrStrony => $ikonyNaStronie): ?>
                  <?php foreach ($ikonyNaStronie as $ikonaId): ?>
                    <label class="ikona-item <?= $ikonaId === $ikonaWybrana ? 'wybrana' : '' ?>" data-ikona-wybor="<?= htmlspecialchars($ikonaId) ?>" data-strona="<?= $nrStrony ?>" style="<?= $nrStrony === 0 ? '' : 'display:none;' ?>">
                      <img src="../assets/specialties/<?= htmlspecialchars($ikonaId) ?>.svg" alt="<?= htmlspecialchars($ikonaId) ?>" width="28" height="28" loading="lazy">
                    </label>
                  <?php endforeach; ?>
                <?php endforeach; ?>
              </div>
              <?php if (count($strony) > 1): ?>
                <div class="ikona-stronicowanie" data-klucz="<?= $klucz ?>" data-stron="<?= count($strony) ?>">
                  <button type="button" class="btn btn-secondary btn-small" data-ikona-strona="poprzednia">&larr; Poprzednie</button>
                  <span class="ikona-strona-info">1 / <?= count($strony) ?></span>
                  <button type="button" class="btn btn-secondary btn-small" data-ikona-strona="nastepna">Następne &rarr;</button>
                </div>
              <?php endif; ?>
            <?php elseif ($def['typ'] === 'zdjecie'): ?>
              <label for="<?= $klucz ?>"><?= htmlspecialchars($def['etykieta']) ?></label>
              <?php if (!empty($rekord[$klucz])): ?>
                <div class="zdjecie-podglad">
                  <img src="../<?= htmlspecialchars($rekord[$klucz]) ?>" alt="">
                  <label style="margin:0; font-weight:normal; display:flex; align-items:center; gap:6px;"><input type="checkbox" name="<?= $klucz ?>_usun" style="width:auto;"> Usuń zdjęcie</label>
                </div>
              <?php endif; ?>
              <input type="file" id="<?= $klucz ?>" name="<?= $klucz ?>" accept="image/jpeg,image/png,image/webp" style="margin-top:8px;">
            <?php endif; ?>
          <?php endforeach; ?>
          <div class="form-akcje">
            <button class="btn btn-primary" type="submit">Zapisz</button>
            <a class="btn btn-secondary" href="edytuj.php?kolekcja=<?= urlencode($kolekcja) ?>">Anuluj</a>
          </div>
        </form>
        <?php if ($kolekcja === 'aktualnosci' && !empty($rekord['id'])): ?>
          <p style="font-size:13px; color:var(--text-muted); margin:16px 0 0;">Adres wpisu: aktualnosci.php?post=<?= htmlspecialchars($rekord['id']) ?></p>
        <?php endif; ?>
      </div>
    <?php else: ?>
      <?php foreach ($dane as $i => $it): ?>
        <div class="lista-item">
          <div style="display:flex; align-items:center; gap:12px; min-width:0;">
            <?php if (!empty($schematy[$kolekcja]['miniatura']) && ($miniatura = $schematy[$kolekcja]['miniatura']($it))): ?>
              <img src="../<?= htmlspecialchars($miniatura) ?>" alt="" style="width:44px; height:44px; object-fit:cover; border-radius:var(--radius-md); border:1px solid var(--border-subtle); flex-shrink:0;">
            <?php endif; ?>
            <div style="min-width:0;">
              <div class="nazwa"><?= htmlspecialchars($schematy[$kolekcja]['tytul']($it)) ?></div>
              <?php if (!empty($schematy[$kolekcja]['podtytul'])): ?>
                <div style="font-size:12.5px; color:var(--text-muted); margin-top:2px;"><?= $schematy[$kolekcja]['podtytul']($it) ?></div>
              <?php endif; ?>
            </div>
          </div>
          <div class="akcje">
            <form class="inline" method="post"><input type="hidden" name="akcja" value="przesun"><input type="hidden" name="poz" value="<?= $i ?>"><input type="hidden" name="kierunek" value="gora"><button class="btn btn-secondary btn-small" type="submit" <?= $i === 0 ? 'disabled' : '' ?>>&uarr;</button></form>
            <form class="inline" method="post"><input type="hidden" name="akcja" value="przesun"><input type="hidden" name="poz" value="<?= $i ?>"><input type="hidden" name="kierunek" value="dol"><button class="btn btn-secondary btn-small" type="submit" <?= $i === count($dane) - 1 ? 'disabled' : '' ?>>&darr;</button></form>
            <a class="btn btn-secondary btn-small" href="edytuj.php?kolekcja=<?= urlencode($kolekcja) ?>&poz=<?= $i ?>">Edytuj</a>
            <form class="inline" method="post" onsubmit="return confirm('Usunąć ten wpis z wersji roboczej?');"><input type="hidden" name="akcja" value="usun"><input type="hidden" name="poz" value="<?= $i ?>"><button class="btn btn-danger btn-small" type="submit">Usuń</button></form>
          </div>
        </div>
      <?php endforeach; ?>
      <a class="btn btn-primary" href="edytuj.php?kolekcja=<?= urlencode($kolekcja) ?>&poz=nowy">+ Dodaj</a>
    <?php endif; ?>

  <?php else: /* CENNIK: kategorie + pozycje */ ?>

    <?php if ($edytowanaPoz !== null): ?>
      <?php $poz = $edytowanaPoz; $kat = $edytowanyRekord; $pozycje = $kat['pozycje'] ?? []; if (empty($pozycje)) $pozycje[] = ['nazwa' => '', 'cena' => '', 'czas' => '', 'opis' => '']; ?>
      <div class="card">
        <form method="post">
          <input type="hidden" name="akcja" value="zapisz-kategoria">
          <input type="hidden" name="poz" value="<?= htmlspecialchars($poz) ?>">
          <label for="kategoria">Nazwa kategorii</label>
          <input type="text" id="kategoria" name="kategoria" value="<?= htmlspecialchars($kat['kategoria'] ?? '') ?>">

          <label>Pozycje cennika</label>
          <div class="pozycja-row" style="font-size:12.5px; color:var(--text-muted); margin-bottom:4px;">
            <span>Nazwa</span><span>Cena</span><span>Czas</span><span>Opis (opcjonalnie)</span><span></span>
          </div>
          <div id="pozycje-lista">
            <?php foreach ($pozycje as $p): ?>
              <div class="pozycja-row">
                <input type="text" name="pozycja_nazwa[]" value="<?= htmlspecialchars($p['nazwa'] ?? '') ?>" placeholder="np. Konsultacja">
                <input type="text" name="pozycja_cena[]" value="<?= htmlspecialchars($p['cena'] ?? '') ?>" placeholder="np. 200 zł">
                <input type="text" name="pozycja_czas[]" value="<?= htmlspecialchars($p['czas'] ?? '') ?>" placeholder="np. 20 min">
                <input type="text" name="pozycja_opis[]" value="<?= htmlspecialchars($p['opis'] ?? '') ?>" placeholder="opcjonalnie">
                <button type="button" class="pozycja-usun" title="Usuń pozycję" data-pozycja-usun>&times;</button>
              </div>
            <?php endforeach; ?>
          </div>
          <button type="button" class="btn btn-secondary btn-small" id="pozycja-dodaj" style="margin-top:6px;">+ Dodaj pozycję</button>
          <p style="font-size:13px; color:var(--text-muted); margin:8px 0 0;">Puste wiersze (bez nazwy) są pomijane przy zapisie.</p>

          <div class="form-akcje">
            <button class="btn btn-primary" type="submit">Zapisz kategorię</button>
            <a class="btn btn-secondary" href="edytuj.php?kolekcja=cennik">Anuluj</a>
          </div>
        </form>
      </div>
    <?php else: ?>
      <?php foreach ($dane as $i => $kat): ?>
        <div class="lista-item">
          <span class="nazwa"><?= htmlspecialchars($kat['kategoria'] ?? '(bez nazwy)') ?> <span style="font-weight:normal; color:var(--text-muted); font-size:13px;">(<?= count($kat['pozycje'] ?? []) ?> poz.)</span></span>
          <div class="akcje">
            <form class="inline" method="post"><input type="hidden" name="akcja" value="przesun"><input type="hidden" name="poz" value="<?= $i ?>"><input type="hidden" name="kierunek" value="gora"><button class="btn btn-secondary btn-small" type="submit" <?= $i === 0 ? 'disabled' : '' ?>>&uarr;</button></form>
            <form class="inline" method="post"><input type="hidden" name="akcja" value="przesun"><input type="hidden" name="poz" value="<?= $i ?>"><input type="hidden" name="kierunek" value="dol"><button class="btn btn-secondary btn-small" type="submit" <?= $i === count($dane) - 1 ? 'disabled' : '' ?>>&darr;</button></form>
            <a class="btn btn-secondary btn-small" href="edytuj.php?kolekcja=cennik&poz=<?= $i ?>">Edytuj</a>
            <form class="inline" method="post" onsubmit="return confirm('Usunąć tę kategorię z wersji roboczej?');"><input type="hidden" name="akcja" value="usun"><input type="hidden" name="poz" value="<?= $i ?>"><button class="btn btn-danger btn-small" type="submit">Usuń</button></form>
          </div>
        </div>
      <?php endforeach; ?>
      <a class="btn btn-primary" href="edytuj.php?kolekcja=cennik&poz=nowy">+ Dodaj kategorię</a>
    <?php endif; ?>

  <?php endif; ?>
</div>
<script>
// Picker ikon: klik na kafelek ustawia ukryte pole i podswietla wybor; strzalki przelaczaja
// widoczna strone siatki (wszystkie ikony sa juz w DOM, stronicowanie to tylko show/hide).
document.querySelectorAll('.ikona-picker').forEach(function (picker) {
  var klucz = picker.dataset.klucz;
  var ukryte = document.getElementById(klucz);
  picker.querySelectorAll('.ikona-item').forEach(function (item) {
    item.addEventListener('click', function () {
      ukryte.value = item.dataset.ikonaWybor;
      picker.querySelectorAll('.ikona-item').forEach(function (i) { i.classList.remove('wybrana'); });
      item.classList.add('wybrana');
    });
  });
});
document.querySelectorAll('.ikona-stronicowanie').forEach(function (nav) {
  var klucz = nav.dataset.klucz;
  var picker = document.querySelector('.ikona-picker[data-klucz="' + klucz + '"]');
  var strony = parseInt(nav.dataset.stron, 10);
  var aktualna = 0;
  var info = nav.querySelector('.ikona-strona-info');
  function pokazStrone(nr) {
    aktualna = nr;
    picker.querySelectorAll('.ikona-item[data-strona]').forEach(function (item) {
      item.style.display = (parseInt(item.dataset.strona, 10) === aktualna) ? '' : 'none';
    });
    info.textContent = (aktualna + 1) + ' / ' + strony;
  }
  nav.querySelector('[data-ikona-strona="poprzednia"]').addEventListener('click', function () {
    pokazStrone((aktualna - 1 + strony) % strony);
  });
  nav.querySelector('[data-ikona-strona="nastepna"]').addEventListener('click', function () {
    pokazStrone((aktualna + 1) % strony);
  });
});

// Cennik: dodawanie/usuwanie wierszy pozycji bez przeladowania strony.
var pozycjeLista = document.getElementById('pozycje-lista');
var pozycjaDodaj = document.getElementById('pozycja-dodaj');
if (pozycjeLista && pozycjaDodaj) {
  function podepnijUsuwanie(wiersz) {
    var przycisk = wiersz.querySelector('[data-pozycja-usun]');
    przycisk.addEventListener('click', function () {
      if (pozycjeLista.querySelectorAll('.pozycja-row').length > 1) wiersz.remove();
      else wiersz.querySelectorAll('input').forEach(function (i) { i.value = ''; });
    });
  }
  pozycjeLista.querySelectorAll('.pozycja-row').forEach(podepnijUsuwanie);
  pozycjaDodaj.addEventListener('click', function () {
    var wiersz = pozycjeLista.querySelector('.pozycja-row').cloneNode(true);
    wiersz.querySelectorAll('input').forEach(function (i) { i.value = ''; });
    pozycjeLista.appendChild(wiersz);
    podepnijUsuwanie(wiersz);
  });
}

// Galeria aktualnosci: strzalki przestawiaja kafelek w DOM, kolejnosc w DOM = kolejnosc zapisu.
document.querySelectorAll('.galeria-lista').forEach(function (lista) {
  lista.addEventListener('click', function (e) {
    var item = e.target.closest('.galeria-item');
    if (!item) return;
    if (e.target.closest('[data-galeria-gora]') && item.previousElementSibling) {
      lista.insertBefore(item, item.previousElementSibling);
    } else if (e.target.closest('[data-galeria-dol]') && item.nextElementSibling) {
      lista.insertBefore(item.nextElementSibling, item);
    }
  });
});

// Guard po stronie przegladarki: ostrzega przed wyslaniem, gdy suma wybranych plikow
// przekroczy limit serwera - bez tego formularz "znika" (patrz PHP: pusty $_POST przy CONTENT_LENGTH>0).
window.CMK_POST_MAX_BAJTOW = <?= (int) cmk_ini_bajty(ini_get('post_max_size')) ?>;
document.querySelectorAll('form[enctype]').forEach(function (form) {
  form.addEventListener('submit', function (e) {
    if (!window.CMK_POST_MAX_BAJTOW) return;
    var suma = 0;
    form.querySelectorAll('input[type=file]').forEach(function (input) {
      for (var i = 0; i < input.files.length; i++) suma += input.files[i].size;
    });
    if (suma > 0 && suma > window.CMK_POST_MAX_BAJTOW - 200 * 1024) {
      e.preventDefault();
      alert('Wybrane zdjęcia są za duże. Limit serwera na jedno przesłanie to ' + Math.round(window.CMK_POST_MAX_BAJTOW / 1024 / 1024) + ' MB. Dodaj mniej zdjęć naraz albo zmniejsz je przed wysłaniem.');
    }
  });
});
</script>
</body>
</html>
