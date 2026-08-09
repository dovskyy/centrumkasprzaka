<?php
require_once __DIR__ . '/auth.php';

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

$kolekcje = [
    'lekarze' => 'Lekarze',
    'specjalizacje' => 'Specjalizacje',
    'cennik' => 'Cennik',
    'aktualnosci' => 'Aktualności',
];

function cmk_liczba_pozycji($kolekcja) {
    $plik = __DIR__ . '/../data/' . $kolekcja . '.json';
    if (!file_exists($plik)) return 0;
    $dane = json_decode(file_get_contents($plik), true);
    if ($kolekcja === 'cennik' && is_array($dane)) {
        $n = 0;
        foreach ($dane as $kat) $n += count($kat['pozycje'] ?? []);
        return $n;
    }
    return is_array($dane) ? count($dane) : 0;
}

function cmk_ma_draft($kolekcja) {
    return file_exists(__DIR__ . '/../data/' . $kolekcja . '.draft.json');
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Panel — Centrum Medyczne Kasprzaka</title>
<link rel="stylesheet" href="../_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/fonts.css">
<link rel="stylesheet" href="../_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/colors.css">
<link rel="stylesheet" href="../_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/typography.css">
<link rel="stylesheet" href="../_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/spacing.css">
<link rel="stylesheet" href="../_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/radius.css">
<link rel="stylesheet" href="../_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/base.css">
<style>
  body { margin:0; background:var(--surface-subtle); color:var(--text-body); font-family:var(--font-body); }
  .wrap { max-width:640px; margin:0 auto; padding:48px 20px; }
  .card { background:var(--white); border:1px solid var(--border-subtle); border-radius:var(--radius-card); box-shadow:var(--shadow-xs); padding:32px; }
  h1 { font-family:var(--font-display); font-size:22px; margin:0 0 24px; color:var(--navy-900); }
  label { display:block; font-size:14px; font-weight:var(--weight-medium); color:var(--navy-800); margin:16px 0 6px; }
  input[type=text], input[type=password] { width:100%; box-sizing:border-box; padding:11px 14px; border:1px solid var(--border-default); border-radius:var(--radius-md); font-size:15px; }
  button { margin-top:24px; padding:11px 20px; border:none; border-radius:var(--radius-pill); background:var(--action-primary); color:var(--white); font-family:var(--font-display); font-weight:var(--weight-semibold); font-size:15px; cursor:pointer; }
  button:hover { background:var(--blue-700); }
  .blad { margin:16px 0 0; padding:12px 14px; border-radius:var(--radius-md); background:var(--danger-050, #fdecec); color:var(--danger-700, #b42318); font-size:14px; }
  .lista { list-style:none; margin:0; padding:0; display:flex; flex-direction:column; gap:10px; }
  .lista li a { display:flex; align-items:center; justify-content:space-between; padding:16px 18px; border:1px solid var(--border-subtle); border-radius:var(--radius-md); text-decoration:none; color:var(--navy-900); font-family:var(--font-display); font-weight:var(--weight-semibold); }
  .lista li a:hover { border-color:var(--blue-200); background:var(--blue-050); }
  .badge { font-size:12.5px; font-weight:var(--weight-medium); color:var(--text-muted); font-family:var(--font-body); }
  .draft-badge { color:var(--blue-700); }
  .top { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
  .top a { font-size:14px; color:var(--text-muted); text-decoration:none; }
</style>
</head>
<body>
<div class="wrap">
<?php if (!$zalogowany): ?>
  <div class="card">
    <h1>Panel — logowanie</h1>
    <form method="post">
      <label for="login">Login</label>
      <input type="text" id="login" name="login" autocomplete="username" required>
      <label for="haslo">Hasło</label>
      <input type="password" id="haslo" name="haslo" autocomplete="current-password" required>
      <?php if ($blad): ?><div class="blad"><?= htmlspecialchars($blad) ?></div><?php endif; ?>
      <button type="submit">Zaloguj</button>
    </form>
  </div>
<?php else: ?>
  <div class="top">
    <h1 style="margin:0;">Panel treści</h1>
    <a href="logout.php">Wyloguj</a>
  </div>
  <ul class="lista">
    <?php foreach ($kolekcje as $klucz => $nazwa): ?>
      <li>
        <a href="edytuj.php?kolekcja=<?= urlencode($klucz) ?>">
          <span><?= htmlspecialchars($nazwa) ?></span>
          <span class="badge">
            <?= cmk_liczba_pozycji($klucz) ?> poz.
            <?php if (cmk_ma_draft($klucz)): ?><span class="draft-badge"> · wersja robocza</span><?php endif; ?>
          </span>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
</div>
</body>
</html>
