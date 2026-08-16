<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/inc/dane.php';
require_once __DIR__ . '/inc/uklad.php';

$blad = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $wynik = cmk_attempt_login(trim($_POST['login']), (string) $_POST['haslo']);
    if ($wynik === true) {
        header('Location: index.php');
        exit;
    }
    $blad = $wynik;
}

$zalogowany = cmk_is_logged_in();

if (!$zalogowany):
    cmk_panel_naglowek(['tytul' => 'Logowanie', 'bez_powloki' => true]);
    ?>
    <div class="logowanie-karta">
      <img src="../uploads/CM-Kasprzaka_logo_przezrocz_tlo.webp" alt="Centrum Medyczne Kasprzaka" class="logowanie-logo">
      <h1>Panel treści</h1>
      <form method="post">
        <div class="pole">
          <label for="login">Login</label>
          <input type="text" id="login" name="login" autocomplete="username" required>
        </div>
        <div class="pole">
          <label for="haslo">Hasło</label>
          <input type="password" id="haslo" name="haslo" autocomplete="current-password" required>
        </div>
        <?php if ($blad): ?><div class="plakietka plakietka--blad" style="display:block; padding:12px 14px; margin-bottom:16px;"><?= htmlspecialchars($blad) ?></div><?php endif; ?>
        <button type="submit" class="btn btn--primary" style="width:100%;">Zaloguj</button>
      </form>
    </div>
    <?php
    cmk_panel_stopka(['bez_powloki' => true]);
    exit;
endif;

$toast = null;
$ok = $_GET['ok'] ?? null;
if ($ok === 'opublikowano') $toast = ['tekst' => 'Opublikowano zmiany.', 'typ' => 'sukces'];
elseif ($ok === 'opublikowano-wszystko') $toast = ['tekst' => 'Opublikowano wszystkie zmiany. Strona pokazuje teraz aktualną treść.', 'typ' => 'sukces'];
elseif ($ok === 'odrzucono') $toast = ['tekst' => 'Odrzucono wersję roboczą.', 'typ' => 'info'];
elseif ($ok === 'odrzucono-wszystko') $toast = ['tekst' => 'Odrzucono wszystkie wersje robocze.', 'typ' => 'info'];

$stan = cmk_panel_stan_kolekcji();
$draftowe = array_values(array_filter($stan, fn($k) => $k['ma_draft']));

cmk_panel_naglowek(['tytul' => 'Pulpit', 'sekcja' => 'pulpit', 'toast' => $toast]);
?>

<?php if (empty($draftowe)): ?>
  <div class="status-karta status-karta--ok">
    <div>
      <h2>Wszystko opublikowane</h2>
      <p>Strona pokazuje aktualną treść ze wszystkich sekcji.</p>
    </div>
  </div>
<?php else: ?>
  <div class="status-karta status-karta--draft">
    <div>
      <h2>Masz niepublikowane zmiany</h2>
      <p>
        <?php foreach ($draftowe as $i => $k): ?>
          <strong><?= htmlspecialchars($k['etykieta']) ?></strong><?= $i < count($draftowe) - 1 ? ', ' : '' ?>
        <?php endforeach; ?>
        — strona ich jeszcze nie pokazuje.
      </p>
    </div>
    <div class="status-karta-akcje">
      <a class="btn btn--secondary" href="<?= htmlspecialchars($draftowe[0]['podglad']) ?>" target="_blank" rel="noopener">Podgląd</a>
      <button type="button" class="btn btn--primary" data-modal-otworz="modal-opublikuj-wszystko">Opublikuj wszystko</button>
    </div>
  </div>
<?php endif; ?>

<div class="siatka-sekcji">
  <?php foreach ($stan as $k): ?>
    <div class="karta sekcja-karta">
      <div class="sekcja-karta-naglowek">
        <h2><?= htmlspecialchars($k['etykieta']) ?></h2>
        <span class="sekcja-karta-liczba"><?= (int) $k['liczba'] ?> poz.</span>
      </div>
      <p class="sekcja-karta-opis"><?= htmlspecialchars($k['opis']) ?></p>
      <?php if ($k['ma_draft']): ?><span class="plakietka plakietka--ostrzezenie">Wersja robocza</span><?php endif; ?>
      <div class="sekcja-karta-akcje">
        <a class="btn btn--secondary btn--sm" href="<?= htmlspecialchars($k['href']) ?>">Zarządzaj</a>
        <a class="btn btn--ghost btn--sm" href="<?= htmlspecialchars($k['href']) ?>&poz=nowy">+ Dodaj</a>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<details class="jak-to-dziala">
  <summary>Jak to działa?</summary>
  <ol>
    <li>Edytujesz treść w danej sekcji.</li>
    <li>Zapisujesz — zmiana trafia do wersji roboczej, strona jeszcze jej nie pokazuje.</li>
    <li>Sprawdzasz podglądem, czy wygląda dobrze.</li>
    <li>Publikujesz — dopiero wtedy zmiana pojawia się na stronie.</li>
  </ol>
</details>

<?php cmk_panel_stopka(); ?>
