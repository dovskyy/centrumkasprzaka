<?php
// Powloka panelu: sidebar, topbar mobilny, pasek publikacji, toasty. Jedno miejsce, zeby
// kazdy ekran wygladal tak samo i zeby stan kolekcji (liczniki, drafty) nie rozjezdzal sie
// miedzy Pulpitem, sidebarem i paskiem publikacji.

$GLOBALS['CMK_ETYKIETY_KOLEKCJI'] = [
    'lekarze' => 'Lekarze',
    'specjalizacje' => 'Specjalizacje',
    'cennik' => 'Cennik',
    'aktualnosci' => 'Aktualności',
];

$GLOBALS['CMK_OPIS_KOLEKCJI'] = [
    'lekarze' => 'Karty na stronie Specjaliści i na stronie głównej',
    'specjalizacje' => 'Kafle specjalizacji na stronie głównej',
    'cennik' => 'Tabela cen na stronie Cennik',
    'aktualnosci' => 'Wpisy na stronie głównej i w zakładce Aktualności',
];

$GLOBALS['CMK_PODGLAD_KOLEKCJI'] = [
    'lekarze' => 'specjalisci.php',
    'specjalizacje' => 'index.php',
    'cennik' => 'cennik.php',
    'aktualnosci' => 'aktualnosci.php',
];

// Jedno zrodlo prawdy o stanie kazdej z 4 kolekcji: etykieta, liczba pozycji (liczona
// z wersji roboczej, jesli istnieje - inaczej licznik na Pulpicie rozjezdzalby sie z tym,
// co uzytkownik widzi na liscie), czy ma draft, href.
function cmk_panel_stan_kolekcji() {
    require_once __DIR__ . '/dane.php';
    $wynik = [];
    foreach ($GLOBALS['CMK_ETYKIETY_KOLEKCJI'] as $klucz => $etykieta) {
        $sciezki = cmk_sciezki($klucz);
        $maDraft = file_exists($sciezki['draft']);
        $dane = cmk_wczytaj_robocze($sciezki['opublikowana'], $sciezki['draft']);
        $wynik[$klucz] = [
            'klucz' => $klucz,
            'etykieta' => $etykieta,
            'opis' => $GLOBALS['CMK_OPIS_KOLEKCJI'][$klucz],
            'liczba' => cmk_liczba_pozycji_z_danych($klucz, $dane),
            'ma_draft' => $maDraft,
            'href' => 'edytuj.php?kolekcja=' . urlencode($klucz),
            'podglad' => '../' . $GLOBALS['CMK_PODGLAD_KOLEKCJI'][$klucz] . '?podglad=1',
        ];
    }
    return $wynik;
}

// $opcje: tytul, sekcja (klucz aktywnej nawigacji), okruszki ([etykieta => href|null]),
// akcja_glowna (HTML gotowego przycisku), bez_powloki (true = tylko strona logowania).
function cmk_panel_naglowek(array $opcje) {
    $tytul = $opcje['tytul'] ?? 'Panel';
    $bezPowloki = !empty($opcje['bez_powloki']);
    ?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Panel — <?= htmlspecialchars($tytul) ?></title>
<link rel="stylesheet" href="../_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/styles.css">
<link rel="stylesheet" href="assets/panel.css">
</head>
<body class="<?= $bezPowloki ? 'panel-bez-powloki' : '' ?>">
<?php if ($bezPowloki): ?>
  <main class="logowanie-uklad">
<?php else:
    $sekcjaAktywna = $opcje['sekcja'] ?? '';
    $stan = cmk_panel_stan_kolekcji();
    $draftowe = array_filter($stan, fn($k) => $k['ma_draft']);
    ?>
  <div class="powloka">
    <header class="topbar-mobilny">
      <button type="button" class="hamburger" id="hamburger" aria-expanded="false" aria-controls="sidebar">
        <span></span><span></span><span></span>
        <span class="sr-only">Otwórz nawigację</span>
      </button>
      <span class="topbar-mobilny-tytul">Panel</span>
    </header>

    <nav class="sidebar" id="sidebar">
      <div class="sidebar-marka">Centrum Medyczne<br>Kasprzaka</div>
      <ul class="sidebar-lista">
        <li><a href="index.php" class="sidebar-link <?= $sekcjaAktywna === 'pulpit' ? 'aktywny' : '' ?>">Pulpit</a></li>
        <?php foreach ($stan as $k): ?>
          <li>
            <a href="<?= htmlspecialchars($k['href']) ?>" class="sidebar-link <?= $sekcjaAktywna === $k['klucz'] ? 'aktywny' : '' ?>">
              <span><?= htmlspecialchars($k['etykieta']) ?></span>
              <span class="sidebar-meta">
                <span class="sidebar-licznik"><?= (int) $k['liczba'] ?></span>
                <?php if ($k['ma_draft']): ?><span class="kropka-draft" title="Niepublikowane zmiany" aria-hidden="true"></span><?php endif; ?>
              </span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
      <div class="sidebar-separator"></div>
      <ul class="sidebar-lista">
        <li><a href="../index.php" target="_blank" rel="noopener" class="sidebar-link">Zobacz stronę ↗</a></li>
        <li>
          <form method="post" action="logout.php" class="sidebar-wyloguj-form">
            <?= cmk_csrf_pole() ?>
            <button type="submit" class="sidebar-link sidebar-link--przycisk">Wyloguj</button>
          </form>
        </li>
      </ul>
    </nav>

    <div class="tlo-nawigacji" id="tlo-nawigacji"></div>

    <main class="tresc-glowna">
      <?php if (!empty($opcje['okruszki'])): ?>
        <nav class="okruszki" aria-label="Ścieżka">
          <?php foreach ($opcje['okruszki'] as $etykieta => $href): ?>
            <?php if ($href): ?><a href="<?= htmlspecialchars($href) ?>"><?= htmlspecialchars($etykieta) ?></a><span aria-hidden="true">/</span>
            <?php else: ?><span class="okruszki-aktywny"><?= htmlspecialchars($etykieta) ?></span>
            <?php endif; ?>
          <?php endforeach; ?>
        </nav>
      <?php endif; ?>

      <div class="naglowek-strony">
        <h1><?= htmlspecialchars($tytul) ?></h1>
        <?php if (!empty($opcje['akcja_glowna'])) echo $opcje['akcja_glowna']; ?>
      </div>

      <div id="toast-host" class="toast-host" role="status" aria-live="polite">
        <?php if (!empty($opcje['toast'])): $t = $opcje['toast']; ?>
          <div class="toast toast--<?= htmlspecialchars($t['typ'] ?? 'sukces') ?>">
            <span><?= htmlspecialchars($t['tekst']) ?></span>
            <?php if (!empty($t['link'])): ?><a href="<?= htmlspecialchars($t['link']['href']) ?>"><?= htmlspecialchars($t['link']['etykieta']) ?></a><?php endif; ?>
            <button type="button" class="toast-zamknij" aria-label="Zamknij">&times;</button>
          </div>
        <?php endif; ?>
      </div>
<?php endif; ?>
<?php
}

// Domkniecie <main>/powloki + pasek publikacji (poza logowaniem) + skrypt.
function cmk_panel_stopka(array $opcje = []) {
    $bezPowloki = !empty($opcje['bez_powloki']);
    if ($bezPowloki) {
        echo '</main>';
    } else {
        $stan = cmk_panel_stan_kolekcji();
        $draftowe = array_values(array_filter($stan, fn($k) => $k['ma_draft']));
        echo '</main></div>';
        if ($draftowe): ?>
          <div class="pasek-publikacji" id="pasek-publikacji">
            <div class="pasek-publikacji-tekst">
              Masz niezapublikowane zmiany:
              <?php foreach ($draftowe as $i => $k): ?>
                <strong><?= htmlspecialchars($k['etykieta']) ?></strong><?= $i < count($draftowe) - 1 ? ', ' : '' ?>
              <?php endforeach; ?>
            </div>
            <div class="pasek-publikacji-akcje">
              <a class="btn btn--ghost" href="<?= htmlspecialchars($draftowe[0]['podglad']) ?>" target="_blank" rel="noopener">Podgląd strony</a>
              <button type="button" class="btn btn--primary" data-modal-otworz="modal-opublikuj-wszystko">Opublikuj wszystko</button>
              <details class="menu">
                <summary class="btn btn--icon" aria-label="Więcej opcji">⋯</summary>
                <div class="menu-lista">
                  <button type="button" class="menu-pozycja menu-pozycja--danger" data-modal-otworz="modal-odrzuc-wszystko">Odrzuć wszystkie zmiany</button>
                </div>
              </details>
            </div>
          </div>

          <dialog class="modal" id="modal-opublikuj-wszystko">
            <form method="post" action="publikuj.php">
              <?= cmk_csrf_pole() ?>
              <input type="hidden" name="akcja" value="opublikuj-wszystko">
              <input type="hidden" name="powrot" value="<?= htmlspecialchars($_SERVER['REQUEST_URI'] ?? 'index.php') ?>">
              <h2>Opublikować wszystkie zmiany?</h2>
              <p>Na stronie pojawią się zmiany z: <?php foreach ($draftowe as $i => $k): ?><strong><?= htmlspecialchars($k['etykieta']) ?></strong><?= $i < count($draftowe) - 1 ? ', ' : '' ?><?php endforeach; ?>.</p>
              <div class="modal-akcje">
                <button type="button" class="btn btn--secondary" data-modal-zamknij autofocus>Anuluj</button>
                <button type="submit" class="btn btn--primary">Opublikuj wszystko</button>
              </div>
            </form>
          </dialog>

          <dialog class="modal" id="modal-odrzuc-wszystko">
            <form method="post" action="publikuj.php">
              <?= cmk_csrf_pole() ?>
              <input type="hidden" name="akcja" value="odrzuc-wszystko">
              <input type="hidden" name="powrot" value="<?= htmlspecialchars($_SERVER['REQUEST_URI'] ?? 'index.php') ?>">
              <h2>Odrzucić wszystkie niepublikowane zmiany?</h2>
              <p>Stracisz zmiany we wszystkich sekcjach z wersją roboczą. Tej operacji nie da się cofnąć.</p>
              <label class="pole-pomoc" for="potwierdz-odrzucenie">Wpisz <strong>usuń</strong>, żeby potwierdzić.</label>
              <input type="text" id="potwierdz-odrzucenie" data-wymaga-tekstu="usuń" autocomplete="off">
              <div class="modal-akcje">
                <button type="button" class="btn btn--secondary" data-modal-zamknij>Anuluj</button>
                <button type="submit" class="btn btn--danger" disabled data-czeka-na-tekst>Odrzuć wszystko</button>
              </div>
            </form>
          </dialog>
        <?php endif;
    }
    ?>
<script src="assets/panel.js"></script>
</body>
</html>
<?php
}
