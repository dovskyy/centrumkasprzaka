<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/upload.php';
require_once __DIR__ . '/inc/dane.php';
require_once __DIR__ . '/inc/uklad.php';
require_once __DIR__ . '/../inc/ikony.php';
require_once __DIR__ . '/../inc/aktualnosci.php';
require_once __DIR__ . '/inc/schematy.php';
require_once __DIR__ . '/inc/pola.php';
cmk_require_login();

$kolekcje = ['lekarze', 'specjalizacje', 'cennik', 'aktualnosci'];
$kolekcja = $_GET['kolekcja'] ?? '';
if (!in_array($kolekcja, $kolekcje, true)) {
    header('Location: index.php');
    exit;
}

$s = cmk_sciezki($kolekcja);
$sciezkaOpublikowana = $s['opublikowana'];
$sciezkaDraft = $s['draft'];
$katalogKopii = $s['kopie'];

// Chipy filtrow narzedzia listy (klucz grupy => [wartosc => etykieta]) oraz funkcja liczaca
// flagi filtrow dla pojedynczego rekordu (uzywane jako atrybuty data-filtr-<grupa> na wierszu).
$chipyFiltrow = [
    'lekarze' => ['glowna' => ['tak' => 'Na stronie głównej'], 'zdjecie' => ['brak' => 'Bez zdjęcia']],
    'specjalizacje' => ['kafel' => ['tak' => 'Kafel na stronie głównej'], 'ikona' => ['brak' => 'Bez ikony']],
    'aktualnosci' => ['typ' => CMK_TYPY_AKTUALNOSCI, 'wygasl' => ['tak' => 'Wygasłe']],
    'cennik' => [],
][$kolekcja];

function cmk_flagi_filtrow($kolekcja, $it) {
    $dzis = date('Y-m-d');
    switch ($kolekcja) {
        case 'lekarze':
            return [
                'glowna' => !empty($it['naStronieGlownej']) ? 'tak' : '',
                'zdjecie' => empty($it['zdjecie']) ? 'brak' : '',
            ];
        case 'specjalizacje':
            return [
                'kafel' => !empty($it['naStronieGlownej']) ? 'tak' : '',
                'ikona' => empty($it['ikona']) ? 'brak' : '',
            ];
        case 'aktualnosci':
            $dataDo = (string) ($it['dataDo'] ?? '');
            return [
                'typ' => $it['typ'] ?? 'aktualnosc',
                'wygasl' => ($dataDo !== '' && $dataDo < $dzis) ? 'tak' : '',
            ];
    }
    return [];
}

$akcja = $_GET['akcja'] ?? ($_POST['akcja'] ?? 'lista');
$komunikat = null;
$bledy = [];
$rekordFormularza = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && (int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
    // PHP czysci $_POST/$_FILES w calosci, gdy przekroczony post_max_size - bez tej detekcji
    // formularz "nic nie robi", a wpisana tresc przepada bez zadnego komunikatu.
    $komunikat = 'Przesłane zdjęcia są za duże (limit serwera: ' . ini_get('post_max_size')
        . '). Dodaj mniej zdjęć naraz albo zmniejsz je przed wysłaniem.';
    $akcja = 'formularz';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cmk_sprawdz_csrf();

    if ($kolekcja !== 'cennik' && $akcja === 'zapisz') {
        $dane = cmk_wczytaj_robocze($sciezkaOpublikowana, $sciezkaDraft);
        $pola = $schematy[$kolekcja]['pola'];
        $poz = $_POST['poz'];

        $rekord = ($poz !== 'nowy' && isset($dane[(int) $poz])) ? $dane[(int) $poz] : [];
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
                    if (is_array($wynik)) { $bledy[$klucz] = $wynik['blad']; }
                    else { $rekord[$klucz] = $wynik; }
                } elseif (!empty($_POST[$klucz . '_usun'])) {
                    $rekord[$klucz] = null;
                } elseif (!array_key_exists($klucz, $rekord)) {
                    $rekord[$klucz] = null;
                }
                continue;
            }
            if ($def['typ'] === 'wybor' || $def['typ'] === 'radio') {
                $klucze = array_keys($def['opcje']);
                $wartosc = (string) ($_POST[$klucz] ?? '');
                $rekord[$klucz] = in_array($wartosc, $klucze, true) ? $wartosc : ($klucze[0] ?? '');
                continue;
            }
            if ($def['typ'] === 'data') {
                $wartosc = trim((string) ($_POST[$klucz] ?? ''));
                if ($wartosc !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $wartosc)) {
                    $bledy[$klucz] = 'Nieprawidłowy format daty.';
                } elseif (!empty($def['wymagane']) && $wartosc === '') {
                    $bledy[$klucz] = $def['etykieta'] . ' jest wymagane.';
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
                    if (is_array($wynik)) { $bledy[$klucz] = $wynik['blad']; }
                    else { $zachowane[] = $wynik; }
                }
                if (count($zachowane) > 8) {
                    $bledy[$klucz] = 'Maksymalnie 8 zdjęć na wpis.';
                }
                $rekord[$klucz] = $zachowane;
                unset($rekord['zdjecie']);
                continue;
            }
            // Przegladarka wysyla wieloliniowy tekst z \r\n - bez normalizacji explode("\n\n", ...)
            // w inc/aktualnosci.php nigdy by nie trafil na pusta linie i akapity by sie nie rozdzielily.
            $wartosc = trim(str_replace(["\r\n", "\r"], "\n", (string) ($_POST[$klucz] ?? '')));
            if (!empty($def['wymagane']) && $wartosc === '') {
                $bledy[$klucz] = $def['etykieta'] . ' jest wymagane.';
            }
            if ($klucz === 'ctaUrl' && $wartosc !== '' && !preg_match('#^(https?://|mailto:|tel:)#i', $wartosc)) {
                $bledy[$klucz] = 'Adres musi zaczynać się od https://, http://, mailto: albo tel:.';
            }
            $rekord[$klucz] = $wartosc;
        }

        if (in_array($kolekcja, ['specjalizacje', 'aktualnosci'], true) && empty($rekord['id'])) {
            $rekord['id'] = cmk_unikalny_slug($rekord['nazwa'] ?? $rekord['tytul'] ?? '', $dane);
        }
        if ($kolekcja === 'lekarze' && empty($rekord['id'])) {
            $rekord['id'] = cmk_unikalny_slug($rekord['imie'] ?? '', $dane);
        }

        if (empty($bledy)) {
            if ($poz === 'nowy') $dane[] = $rekord;
            else $dane[(int) $poz] = $rekord;
            cmk_zapisz_draft($sciezkaDraft, array_values($dane));
            header('Location: edytuj.php?kolekcja=' . urlencode($kolekcja) . '&ok=zapisano');
            exit;
        }
        // Naprawa utraty danych: formularz renderuje sie z $rekord (to, co uzytkownik wpisal),
        // nie z dysku - inaczej caly wpis (i wgrane juz zdjecia) przepadalby przy bledzie walidacji.
        $komunikat = 'Popraw zaznaczone pola.';
        $rekordFormularza = $rekord;
        $akcja = 'formularz';
        $_GET['poz'] = $poz;
    }

    if ($akcja === 'usun') {
        $dane = cmk_wczytaj_robocze($sciezkaOpublikowana, $sciezkaDraft);
        $poz = (int) $_POST['poz'];
        unset($dane[$poz]);
        cmk_zapisz_draft($sciezkaDraft, array_values($dane));
        header('Location: edytuj.php?kolekcja=' . urlencode($kolekcja) . '&ok=usunieto');
        exit;
    }

    if ($akcja === 'zmien-kolejnosc') {
        $dane = cmk_wczytaj_robocze($sciezkaOpublikowana, $sciezkaDraft);
        $nowaKolejnosc = $_POST['kolejnosc'] ?? [];
        $oczekiwane = range(0, count($dane) - 1);
        $podana = array_map('intval', $nowaKolejnosc);
        sort($podana);
        if ($podana === $oczekiwane) {
            $przestawione = [];
            foreach (array_map('intval', $nowaKolejnosc) as $i) $przestawione[] = $dane[$i];
            cmk_zapisz_draft($sciezkaDraft, $przestawione);
        }
        header('Location: edytuj.php?kolekcja=' . urlencode($kolekcja) . '&ok=kolejnosc');
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
        if ($kategoria === '') {
            $bledy['kategoria'] = 'Nazwa kategorii jest wymagana.';
            $rekordFormularza = ['kategoria' => $kategoria, 'pozycje' => $pozycje];
            $komunikat = 'Popraw zaznaczone pola.';
            $akcja = 'formularz';
            $_GET['poz'] = $poz;
        } else {
            $wpis = ['kategoria' => $kategoria, 'pozycje' => $pozycje];
            if ($poz === 'nowy') $dane[] = $wpis;
            else $dane[(int) $poz] = $wpis;
            cmk_zapisz_draft($sciezkaDraft, array_values($dane));
            header('Location: edytuj.php?kolekcja=cennik&ok=zapisano');
            exit;
        }
    }
}

$dane = cmk_wczytaj_robocze($sciezkaOpublikowana, $sciezkaDraft);
$maDraft = file_exists($sciezkaDraft);

$toast = null;
$ok = $_GET['ok'] ?? null;
if ($ok === 'zapisano') {
    $toast = ['tekst' => 'Zapisano w wersji roboczej. Kliknij „Opublikuj”, żeby zmiany pojawiły się na stronie.', 'typ' => 'sukces'];
} elseif ($ok === 'usunieto') {
    $toast = ['tekst' => 'Usunięto z wersji roboczej.', 'typ' => 'info'];
} elseif ($ok === 'kolejnosc') {
    $toast = ['tekst' => 'Zapisano nową kolejność.', 'typ' => 'sukces'];
}

$edytowanaPoz = $_GET['poz'] ?? null;
$edytowanyRekord = $rekordFormularza !== null
    ? $rekordFormularza
    : (($edytowanaPoz !== null && $edytowanaPoz !== 'nowy' && isset($dane[(int) $edytowanaPoz]))
        ? $dane[(int) $edytowanaPoz]
        : []);

$etykietaListy = $schematy[$kolekcja]['etykieta_listy'] ?? 'Cennik';
$etykietaPojedyncza = $schematy[$kolekcja]['etykieta_pojedyncza'] ?? 'kategorię';
$wTrybieFormularza = ($akcja === 'formularz') || ($edytowanaPoz !== null);
$tytulRekordu = $kolekcja === 'cennik'
    ? ($edytowanyRekord['kategoria'] ?? '(nowa kategoria)')
    : $schematy[$kolekcja]['tytul']($edytowanyRekord);

$akcjaGlowna = !$wTrybieFormularza
    ? '<a class="btn btn--primary" href="edytuj.php?kolekcja=' . urlencode($kolekcja) . '&poz=nowy">+ Dodaj ' . htmlspecialchars($etykietaPojedyncza) . '</a>'
    : '';

cmk_panel_naglowek([
    'tytul' => $wTrybieFormularza ? (($edytowanaPoz === 'nowy' || $edytowanaPoz === null) ? 'Nowy: ' . $etykietaPojedyncza : $tytulRekordu) : $etykietaListy,
    'sekcja' => $kolekcja,
    'okruszki' => $wTrybieFormularza ? [$etykietaListy => 'edytuj.php?kolekcja=' . urlencode($kolekcja), (($edytowanaPoz === 'nowy' || $edytowanaPoz === null) ? 'Nowy wpis' : 'Edycja') => null] : [],
    'akcja_glowna' => $akcjaGlowna,
    'toast' => $toast,
]);

if ($komunikat && !empty($bledy)): ?>
  <div class="blad-podsumowanie">
    <h2><?= htmlspecialchars($komunikat) ?></h2>
    <ul>
      <?php foreach ($bledy as $klucz => $tekst): ?>
        <li><a href="#<?= htmlspecialchars($klucz) ?>"><?= htmlspecialchars($tekst) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php elseif ($komunikat): ?>
  <div class="plakietka plakietka--blad" style="display:block; padding:12px 14px; margin-bottom:16px;"><?= htmlspecialchars($komunikat) ?></div>
<?php endif;

if ($maDraft && !$wTrybieFormularza): ?>
  <div class="karta" style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;">
    <span style="font-size:14px; color:var(--navy-800);">Ta sekcja ma niepublikowane zmiany.</span>
    <div style="display:flex; gap:8px;">
      <a class="btn btn--secondary btn--sm" href="../<?= htmlspecialchars($GLOBALS['CMK_PODGLAD_KOLEKCJI'][$kolekcja]) ?>?podglad=1" target="_blank" rel="noopener">Podgląd na stronie</a>
      <form method="post" action="publikuj.php" style="display:inline;">
        <?= cmk_csrf_pole() ?>
        <input type="hidden" name="akcja" value="opublikuj">
        <input type="hidden" name="kolekcja" value="<?= htmlspecialchars($kolekcja) ?>">
        <input type="hidden" name="powrot" value="edytuj.php?kolekcja=<?= urlencode($kolekcja) ?>">
        <button class="btn btn--primary btn--sm" type="submit">Opublikuj tę sekcję</button>
      </form>
    </div>
  </div>
<?php endif;

if ($kolekcja !== 'cennik'):

    if ($wTrybieFormularza):
        $pola = $schematy[$kolekcja]['pola'];
        $poz = $edytowanaPoz ?? 'nowy';
        $rekord = $edytowanyRekord;
        $grupyGlowna = [];
        $grupyBoczna = [];
        foreach ($pola as $klucz => $def) {
            $grupa = $def['grupa'] ?? 'Treść';
            $tab = ($def['kolumna'] ?? 'glowna') === 'boczna' ? 'grupyBoczna' : 'grupyGlowna';
            ${$tab}[$grupa][$klucz] = $def;
        }
        ?>
        <?php if ($kolekcja === 'aktualnosci'): ?>
          <p class="formularz-info"><strong>Jak to działa:</strong> wpis pojawia się na stronie dopiero po kliknięciu <strong>Opublikuj</strong>. Pole „Widoczne do” sprawia, że promocja sama zniknie ze strony po tym dniu.</p>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data" data-formularz-glowny>
          <?= cmk_csrf_pole() ?>
          <input type="hidden" name="akcja" value="zapisz">
          <input type="hidden" name="poz" value="<?= htmlspecialchars($poz) ?>">
          <div class="uklad-formularza">
            <div class="kolumna-glowna">
              <?php foreach ($grupyGlowna as $nazwaGrupy => $polaGrupy): ?>
                <div class="karta">
                  <h2><?= htmlspecialchars($nazwaGrupy) ?></h2>
                  <?php foreach ($polaGrupy as $klucz => $def) cmk_pole($klucz, $def, $rekord, $bledy); ?>
                </div>
              <?php endforeach; ?>
            </div>
            <div class="kolumna-boczna">
              <?php foreach ($grupyBoczna as $nazwaGrupy => $polaGrupy): ?>
                <div class="karta">
                  <h2><?= htmlspecialchars($nazwaGrupy) ?></h2>
                  <?php foreach ($polaGrupy as $klucz => $def) cmk_pole($klucz, $def, $rekord, $bledy); ?>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="stopka-formularza">
            <div class="stopka-formularza-lewo">
              <button class="btn btn--primary" type="submit" data-zapisz-glowny>Zapisz</button>
              <a class="btn btn--secondary" href="edytuj.php?kolekcja=<?= urlencode($kolekcja) ?>">Anuluj</a>
            </div>
            <?php if ($poz !== 'nowy'): ?>
              <button type="button" class="btn btn--danger" data-usun-otworz="<?= htmlspecialchars($schematy[$kolekcja]['tytul']($rekord)) ?>" data-usun-poz="<?= htmlspecialchars($poz) ?>">Usuń</button>
            <?php endif; ?>
          </div>
        </form>
        <?php if ($kolekcja === 'aktualnosci' && !empty($rekord['id'])): ?>
          <p class="pole-pomoc" style="margin-top:12px;">Adres wpisu: aktualnosci.php?post=<?= htmlspecialchars($rekord['id']) ?></p>
        <?php endif; ?>

    <?php else: ?>

      <?php if (empty($dane)): ?>
        <div class="stan-pusty">
          <div class="stan-pusty-ikona">🗂️</div>
          <h2>Nie masz jeszcze żadnej pozycji</h2>
          <p>Dodaj pierwszą, żeby pojawiła się na stronie po opublikowaniu.</p>
          <a class="btn btn--primary" href="edytuj.php?kolekcja=<?= urlencode($kolekcja) ?>&poz=nowy">+ Dodaj <?= htmlspecialchars($etykietaPojedyncza) ?></a>
        </div>
      <?php else: ?>
        <div class="pasek-narzedzi pasek-narzedzi-wrap">
          <div class="szukajka">
            <input type="text" id="szukaj-lista" placeholder="Szukaj…" data-lista-szukaj="#lista-pozycji" autocomplete="off">
            <button type="button" class="szukajka-wyczysc" data-szukaj-wyczysc="szukaj-lista" hidden aria-label="Wyczyść">&times;</button>
          </div>
          <span class="szukajka-licznik" data-lista-licznik="lista-pozycji"></span>
          <?php if ($chipyFiltrow): ?>
            <div class="chipy-filtr">
              <?php foreach ($chipyFiltrow as $grupa => $opcje): foreach ($opcje as $wartosc => $etykieta): ?>
                <button type="button" class="chip-filtr" data-chip-filtr="<?= htmlspecialchars($grupa) ?>" data-chip-wartosc="<?= htmlspecialchars($wartosc) ?>"><?= htmlspecialchars($etykieta) ?></button>
              <?php endforeach; endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
        <p class="szukajka-info-kolejnosc" data-szukajka-info-kolejnosc hidden>Wyczyść wyszukiwanie, żeby zmienić kolejność przeciąganiem.</p>

        <form method="post" id="formularz-lista">
          <?= cmk_csrf_pole() ?>
          <input type="hidden" name="akcja" value="zmien-kolejnosc">
          <input type="hidden" name="kolekcja" value="<?= htmlspecialchars($kolekcja) ?>">
          <div class="lista-pozycji" id="lista-pozycji" data-reorder-lista>
            <?php foreach ($dane as $i => $it): $flagi = cmk_flagi_filtrow($kolekcja, $it); $miniatura = !empty($schematy[$kolekcja]['miniatura']) ? $schematy[$kolekcja]['miniatura']($it) : null; ?>
              <div class="wiersz-pozycji" data-wiersz data-indeks="<?= $i ?>" draggable="true"
                data-szukaj="<?= htmlspecialchars(mb_strtolower($schematy[$kolekcja]['tytul']($it) . ' ' . ($it['podtytul'] ?? $it['opis'] ?? ''), 'UTF-8')) ?>"
                <?php foreach ($flagi as $grupa => $wartosc): ?>data-filtr-<?= htmlspecialchars($grupa) ?>="<?= htmlspecialchars($wartosc) ?>" <?php endforeach; ?>>
                <span class="uchwyt-przeciagania" aria-hidden="true">⠿</span>
                <?php if ($miniatura): ?>
                  <img src="../<?= htmlspecialchars($miniatura) ?>" alt="" class="wiersz-miniatura">
                <?php else: ?>
                  <span class="wiersz-miniatura-brak" aria-hidden="true">—</span>
                <?php endif; ?>
                <div class="wiersz-tresc">
                  <a class="wiersz-tytul" href="edytuj.php?kolekcja=<?= urlencode($kolekcja) ?>&poz=<?= $i ?>"><?= htmlspecialchars($schematy[$kolekcja]['tytul']($it)) ?></a>
                  <?php if (!empty($schematy[$kolekcja]['plakietki'])): ?>
                    <div class="wiersz-plakietki">
                      <?php foreach ($schematy[$kolekcja]['plakietki']($it) as $p): ?>
                        <span class="plakietka plakietka--<?= htmlspecialchars($p['ton']) ?>"><?= htmlspecialchars($p['tekst']) ?></span>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="wiersz-akcje">
                  <a class="btn btn--secondary btn--sm" href="edytuj.php?kolekcja=<?= urlencode($kolekcja) ?>&poz=<?= $i ?>">Edytuj</a>
                  <details class="menu">
                    <summary class="btn btn--secondary btn--icon" aria-label="Więcej opcji">⋯</summary>
                    <div class="menu-lista">
                      <button type="button" class="menu-pozycja" data-w-gore <?= $i === 0 ? 'disabled' : '' ?>>Przenieś w górę</button>
                      <button type="button" class="menu-pozycja" data-w-dol <?= $i === count($dane) - 1 ? 'disabled' : '' ?>>Przenieś w dół</button>
                      <div class="menu-separator"></div>
                      <button type="button" class="menu-pozycja menu-pozycja--danger" data-usun-otworz="<?= htmlspecialchars($schematy[$kolekcja]['tytul']($it)) ?>" data-usun-poz="<?= $i ?>">Usuń</button>
                    </div>
                  </details>
                </div>
              </div>
            <?php endforeach; ?>
            <div class="stan-pusty" data-stan-pusty-wyniku hidden>
              <p style="margin:0;">Brak wyników dla tego wyszukiwania.</p>
            </div>
          </div>
        </form>

        <div class="pasek-kolejnosc" id="pasek-kolejnosc" hidden>
          <span>Kolejność zmieniona</span>
          <button type="button" class="btn btn--secondary btn--sm" data-cofnij-kolejnosc>Cofnij</button>
          <button type="button" class="btn btn--primary btn--sm" data-zapisz-kolejnosc>Zapisz kolejność</button>
        </div>
      <?php endif; ?>
    <?php endif; ?>

<?php else: /* CENNIK: kategorie + pozycje */ ?>

  <?php if ($edytowanaPoz !== null): ?>
    <?php $poz = $edytowanaPoz; $kat = $edytowanyRekord; $pozycje = $kat['pozycje'] ?? []; if (empty($pozycje)) $pozycje[] = ['nazwa' => '', 'cena' => '', 'czas' => '', 'opis' => '']; ?>
    <div class="karta">
      <form method="post" data-formularz-glowny>
        <?= cmk_csrf_pole() ?>
        <input type="hidden" name="akcja" value="zapisz-kategoria">
        <input type="hidden" name="poz" value="<?= htmlspecialchars($poz) ?>">
        <div class="pole<?= isset($bledy['kategoria']) ? ' pole--blad' : '' ?>">
          <label for="kategoria">Nazwa kategorii <span class="pole-wymagane">*</span></label>
          <input type="text" id="kategoria" name="kategoria" value="<?= htmlspecialchars($kat['kategoria'] ?? '') ?>" aria-required="true">
          <?php if (isset($bledy['kategoria'])): ?><p class="pole-blad-tekst"><?= htmlspecialchars($bledy['kategoria']) ?></p><?php endif; ?>
        </div>

        <label class="pole-etykieta">Pozycje cennika</label>
        <div class="pozycja-tabela-naglowek">
          <span></span><span>Nazwa*</span><span>Cena</span><span>Czas</span><span>Opis</span><span></span>
        </div>
        <div id="pozycje-lista">
          <?php foreach ($pozycje as $p): ?>
            <div class="pozycja-row" draggable="true">
              <span class="pozycja-uchwyt" aria-hidden="true">⠿</span>
              <div class="pozycja-pole--nazwa"><span class="pozycja-etykieta">Nazwa*</span><input type="text" name="pozycja_nazwa[]" value="<?= htmlspecialchars($p['nazwa'] ?? '') ?>" placeholder="np. Konsultacja"></div>
              <div class="pozycja-pole--cena"><span class="pozycja-etykieta">Cena</span><input type="text" name="pozycja_cena[]" value="<?= htmlspecialchars($p['cena'] ?? '') ?>" placeholder="np. 200 zł"></div>
              <div class="pozycja-pole--czas"><span class="pozycja-etykieta">Czas</span><input type="text" name="pozycja_czas[]" value="<?= htmlspecialchars($p['czas'] ?? '') ?>" placeholder="np. 20 min"></div>
              <div class="pozycja-pole--opis"><span class="pozycja-etykieta">Opis</span><input type="text" name="pozycja_opis[]" value="<?= htmlspecialchars($p['opis'] ?? '') ?>" placeholder="opcjonalnie"></div>
              <button type="button" class="pozycja-usun" title="Usuń pozycję" data-pozycja-usun>&times;</button>
            </div>
          <?php endforeach; ?>
        </div>
        <div style="display:flex; gap:8px; margin-top:6px;">
          <button type="button" class="btn btn--secondary btn--sm" id="pozycja-dodaj">+ Dodaj pozycję</button>
        </div>
        <p class="pole-pomoc" style="margin-top:8px;">Puste wiersze (bez nazwy) są pomijane przy zapisie.</p>

        <div class="stopka-formularza">
          <div class="stopka-formularza-lewo">
            <button class="btn btn--primary" type="submit" data-zapisz-glowny>Zapisz kategorię</button>
            <a class="btn btn--secondary" href="edytuj.php?kolekcja=cennik">Anuluj</a>
          </div>
          <?php if ($poz !== 'nowy'): ?>
            <button type="button" class="btn btn--danger" data-usun-otworz="<?= htmlspecialchars($kat['kategoria'] ?? '(bez nazwy)') ?>" data-usun-poz="<?= htmlspecialchars($poz) ?>">Usuń</button>
          <?php endif; ?>
        </div>
      </form>
    </div>
  <?php else: ?>
    <?php if (empty($dane)): ?>
      <div class="stan-pusty">
        <div class="stan-pusty-ikona">💳</div>
        <h2>Nie masz jeszcze żadnej kategorii cennika</h2>
        <p>Dodaj pierwszą, żeby cennik pojawił się na stronie po opublikowaniu.</p>
        <a class="btn btn--primary" href="edytuj.php?kolekcja=cennik&poz=nowy">+ Dodaj kategorię</a>
      </div>
    <?php else: ?>
      <div class="pasek-narzedzi pasek-narzedzi-wrap">
        <div class="szukajka">
          <input type="text" id="szukaj-lista" placeholder="Szukaj kategorii lub pozycji…" data-lista-szukaj="#lista-pozycji" autocomplete="off">
          <button type="button" class="szukajka-wyczysc" data-szukaj-wyczysc="szukaj-lista" hidden aria-label="Wyczyść">&times;</button>
        </div>
        <span class="szukajka-licznik" data-lista-licznik="lista-pozycji"></span>
      </div>
      <p class="szukajka-info-kolejnosc" data-szukajka-info-kolejnosc hidden>Wyczyść wyszukiwanie, żeby zmienić kolejność przeciąganiem.</p>
      <form method="post" id="formularz-lista">
        <?= cmk_csrf_pole() ?>
        <input type="hidden" name="akcja" value="zmien-kolejnosc">
        <input type="hidden" name="kolekcja" value="cennik">
        <div class="lista-pozycji" id="lista-pozycji" data-reorder-lista>
          <?php foreach ($dane as $i => $kat): $nazwyPozycji = implode(' ', array_column($kat['pozycje'] ?? [], 'nazwa')); ?>
            <div class="wiersz-pozycji" data-wiersz data-indeks="<?= $i ?>" draggable="true" data-szukaj="<?= htmlspecialchars(mb_strtolower(($kat['kategoria'] ?? '') . ' ' . $nazwyPozycji, 'UTF-8')) ?>">
              <span class="uchwyt-przeciagania" aria-hidden="true">⠿</span>
              <div class="wiersz-tresc">
                <a class="wiersz-tytul" href="edytuj.php?kolekcja=cennik&poz=<?= $i ?>"><?= htmlspecialchars($kat['kategoria'] ?? '(bez nazwy)') ?></a>
                <div class="wiersz-plakietki"><span class="plakietka plakietka--neutralna"><?= count($kat['pozycje'] ?? []) ?> pozycji</span></div>
              </div>
              <div class="wiersz-akcje">
                <a class="btn btn--secondary btn--sm" href="edytuj.php?kolekcja=cennik&poz=<?= $i ?>">Edytuj</a>
                <details class="menu">
                  <summary class="btn btn--secondary btn--icon" aria-label="Więcej opcji">⋯</summary>
                  <div class="menu-lista">
                    <button type="button" class="menu-pozycja" data-w-gore <?= $i === 0 ? 'disabled' : '' ?>>Przenieś w górę</button>
                    <button type="button" class="menu-pozycja" data-w-dol <?= $i === count($dane) - 1 ? 'disabled' : '' ?>>Przenieś w dół</button>
                    <div class="menu-separator"></div>
                    <button type="button" class="menu-pozycja menu-pozycja--danger" data-usun-otworz="<?= htmlspecialchars($kat['kategoria'] ?? '(bez nazwy)') ?>" data-usun-poz="<?= $i ?>">Usuń</button>
                  </div>
                </details>
              </div>
            </div>
          <?php endforeach; ?>
          <div class="stan-pusty" data-stan-pusty-wyniku hidden><p style="margin:0;">Brak wyników dla tego wyszukiwania.</p></div>
        </div>
      </form>
      <div class="pasek-kolejnosc" id="pasek-kolejnosc" hidden>
        <span>Kolejność zmieniona</span>
        <button type="button" class="btn btn--secondary btn--sm" data-cofnij-kolejnosc>Cofnij</button>
        <button type="button" class="btn btn--primary btn--sm" data-zapisz-kolejnosc>Zapisz kolejność</button>
      </div>
      <a class="btn btn--primary" style="margin-top:16px;" href="edytuj.php?kolekcja=cennik&poz=nowy">+ Dodaj kategorię</a>
    <?php endif; ?>
  <?php endif; ?>

<?php endif; ?>

<dialog class="modal" id="modal-usun">
  <form method="post">
    <?= cmk_csrf_pole() ?>
    <input type="hidden" name="akcja" value="usun">
    <input type="hidden" name="kolekcja" value="<?= htmlspecialchars($kolekcja) ?>">
    <input type="hidden" name="poz" value="">
    <h2>Usunąć „<span data-usun-nazwa></span>”?</h2>
    <p>Zniknie z wersji roboczej. Na stronie przestanie być widoczny dopiero po opublikowaniu.</p>
    <div class="modal-akcje">
      <button type="button" class="btn btn--secondary" data-modal-zamknij autofocus>Anuluj</button>
      <button type="submit" class="btn btn--danger">Usuń</button>
    </div>
  </form>
</dialog>

<script>window.CMK_POST_MAX_BAJTOW = <?= (int) cmk_ini_bajty(ini_get('post_max_size')) ?>;</script>
<?php cmk_panel_stopka(); ?>
