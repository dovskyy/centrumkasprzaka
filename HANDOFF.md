# Handoff — CMK2 (Centrum Medyczne Kasprzaka)

## Co to za projekt
Strona przychodni, migrowana ze statycznego HTML (React-owy runtime "dc" w `support.js`,
**nie edytować `support.js` ręcznie** — wygenerowany, nieprzebudowywalny z tego repo) na
PHP z panelem edycji treści dla właściciela (osoba nietechniczna, bez gita).

Pełny plan wdrożenia: `C:\Users\Marcel\.claude\plans\przeanalizuj-struktur-tego-projektu-radiant-lecun.md`
(Etapy 0–5, Etapy 0–3 zrobione, patrz niżej).

Repo: `dovskyy/centrumkasprzaka`. **Pracujemy na branchu `master`** (nie `php-implementation` —
użytkownik scalił sam po tym, jak wcześniej zbudowaliśmy to na osobnym branchu).

## 🔴 Do zrobienia NATYCHMIAST (przed kolejnym pushem)
`.github/workflows/deploy.yml` ma `rsync --delete` i wyklucza tylko `/data/` i `/uploads/`.
`panel/config.php` jest w `.gitignore` (nigdy nie trafia do CI checkout), więc **przy `--delete`
rsync go skasuje z serwera przy każdym kolejnym deployu**. Trzeba dodać do `EXCLUDE`:
```
/panel/config.php, /panel/_attempts.json
```
To najpewniej przyczyna błędu "config.php: No such file or directory", z którym użytkownik
się zgłosił. Po dodaniu wykluczenia przypomnieć, żeby ponownie utworzył `panel/config.php`
na serwerze (patrz sekcja "Sekrety" niżej).

## Stack i architektura
- Czysty PHP (bez frameworka, bez buildu). Strony: `index.php`, `specjalisci.php`,
  `cennik.php`, `aktualnosci.php`. Każda ma nagłówek `<?php require_once 'inc/tresc.php'; ...?>`
  wstrzykujący `window.TRESC` (JSON z `data/*.json`) do `<head>`, potem statyczny markup
  `<x-dc>` z `{{ }}` interpolacją i `sc-for`/`sc-if` obsługiwanym przez `support.js`.
- **Kluczowa pułapka tego frameworka**: cały markup w `<x-dc>` trafia do przeglądarki jako
  zwykły, żywy HTML zanim React go zhydruje (skrypty w `<head>` blokujące, `x-dc{display:none}`
  ukrywa wizualnie, ale nie blokuje np. eager-fetchu `<img src>` ani obecności elementów w DOM).
  Stąd zasada: **nigdy nie renderować dwóch wariantów tego samego `id`/atrybutu przez `sc-if`**
  jeśli cokolwiek zewnętrzne (np. widget.js ZnanyLekarz) skanuje całą stronę po atrybutach —
  ugryzło nas to boleśnie przy widgecie kalendarza (patrz niżej).
- Dane: `data/lekarze.json`, `data/specjalizacje.json`, `data/cennik.json`, `data/aktualnosci.json`
  — **to teraz prawdziwa treść klienta** (14 lekarzy, realne specjalizacje), nie dane testowe.
- `data/*.draft.json` — wersje robocze z panelu (gitignored). `data/_kopie/` — backupy przy
  publikacji, ostatnie 20 (gitignored, poza `.gitkeep`).
- `inc/tresc.php` — ładuje `data/*.json`, obsługuje `?podglad=1` (pokazuje draft tylko dla
  zalogowanej sesji panelu).
- `inc/ikony.php` — generuje sprite SVG (`<symbol>`/`<use>`) z `assets/specialties/*.svg`
  (43 ikony) na podstawie tego, co wybrano w panelu. Index.php buduje `<defs>` dynamicznie w PHP.

## Panel (`panel/`)
- `panel/index.php` — logowanie (`password_hash`/`password_verify`) + dashboard.
- `panel/auth.php` — sesja (cookie path `/`, httponly, samesite=Lax), limiter prób logowania
  per IP w `panel/_attempts.json` (rosnące opóźnienie, przetrwa restart sesji).
- `panel/edytuj.php` — generyczny CRUD sterowany schematem pól (`$schematy` w pliku) dla
  lekarzy/specjalizacji/aktualności + osobna, dedykowana obsługa cennika (kategorie+pozycje,
  dynamiczne dodawanie/usuwanie wierszy w JS). Workflow: edycja → `*.draft.json` →
  "Podgląd na stronie" → "Opublikuj" (backup + podmiana) / "Odrzuć".
- `panel/upload.php` — walidacja `getimagesize()` (odrzuca np. `.php` pod `.jpg`), EXIF
  orientation, resize do 900px, zapis jako WebP (fallback JPEG).
- **`panel/config.php` NIE jest w repo** (`.gitignore`). Zawiera `CMK_PANEL_LOGIN` i
  `CMK_PANEL_HASH`. Trzeba go ręcznie stworzyć na **każdym** środowisku (lokalnie i na
  produkcji) wg wzoru `panel/config.example.php`. Lokalne testowe hasło (Docker):
  login `admin`, hasło `zmien-to-haslo-123`.
- `.htaccess` w `data/` i `panel/` blokuje bezpośredni dostęp — **zweryfikowane na
  prawdziwym Apache** (osobny kontener testowy), nie tylko `php -S` (który `.htaccess` ignoruje).

## Środowisko lokalne
Docker, PHP 7.4-cli (zgodność z produkcją, patrz Etap 0 w planie):
```bash
docker run --rm -p 8000:8000 -v "${PWD}:/var/www/html" php:7.4-cli php -S 0.0.0.0:8000
```
**GD + EXIF nie są w tym obrazie domyślnie** — trzeba je doinstalować w działającym
kontenerze (nie jest to zapisane na trwałe w Dockerfile, więc po restarcie kontenera
trzeba powtórzyć):
```bash
docker exec <container> bash -c "apt-get update -qq && apt-get install -qq -y libpng-dev libjpeg-dev libwebp-dev && docker-php-ext-configure gd --with-jpeg --with-webp && docker-php-ext-install -j$(nproc) gd exif"
```
Uwaga dla PowerShell/Git Bash na Windows: `docker exec`/`docker run` z ścieżkami
zaczynającymi się od `/` wymaga `MSYS_NO_PATHCONV=1` w Bash, inaczej Git Bash mangla ścieżki
na Windowsowe.

## Zrobione (Etapy 0–3 z planu + dodatki)
- **Etap 0**: rozeznanie hostingu — PHP 7.4.33 (CLI pokazywał 5.4, nieistotne), serwer
  LiteSpeed za Cloudflare, GD+WebP+EXIF dostępne, limity uploadu 2M/8M (**za małe na realne
  zdjęcia z telefonu, trzeba podnieść przed produkcyjnym użyciem uploadu**), domena
  `cmkasprzaka.pl` dziś to WordPress (do zastąpienia tą stroną — backup przed cutoverem).
- **Etap 1**: `.html`→`.php`, dane wyciągnięte do JSON, `sc-for`/`sc-if` zamiast kopiowanych kart.
- **Etap 2**: `cennik.php`, `aktualnosci.php` (lista + pojedynczy wpis przez `?post=slug`,
  opcjonalne zdjęcie).
- **Etap 3**: panel edycji, upload zdjęć, draft/publikacja, `.htaccess`.
- **Dodatkowo (poza pierwotnym planem, na życzenie użytkownika)**:
  - Relacja lekarz↔specjalizacja jako wiele-do-wielu (`specjalizacje: [id, ...]`).
  - Wizualny picker ikon specjalizacji (43 ikony, stronicowanie po stronie klienta, `loading="lazy"`).
  - Dynamiczne dodawanie/usuwanie pozycji cennika w panelu.
  - **Widget ZnanyLekarz per lekarz** — po dwóch nieudanych, "sprytnych" próbach (patrz niżej)
    finalne rozwiązanie: admin wkleja **cały surowy HTML** widgetu (link+`<script>`) do pola
    textarea w panelu (`data/lekarze.json: widgetHtml`), renderowany w osobnym modalu przez
    `innerHTML` + ręczne odtworzenie `<script>` (przeglądarki nie wykonują skryptów wstawionych
    przez innerHTML). Ogólny "Umów wizytę" (bez konkretnego lekarza) wrócił 1:1 do stanu
    sprzed jakichkolwiek zmian w tym obszarze — zero współdzielonej logiki z widgetem per-lekarz.
  - **Naprawiony realny XSS/breakage risk**: `json_encode($TRESC, ...)` w `<head>` używał
    `JSON_UNESCAPED_SLASHES`, więc wklejony przez admina `</script>` w `widgetHtml`
    przedwcześnie zamykał zewnętrzny `<script>window.TRESC=...</script>` i wysypywał całą
    stronę. Zmienione na `JSON_HEX_TAG` (escapuje `<`/`>` do `\u003C`/`\u003E` we wszystkich
    polach tekstowych, nie tylko w tym jednym).

## Ważne wnioski/pułapki (żeby nie powtórzyć błędów)
1. **Nigdy nie renderuj dwóch wariantów tego samego elementu przez `sc-if`**, jeśli coś
   zewnętrznie skanuje całą stronę po jego atrybutach — surowy pre-hydration HTML zawiera
   OBA warianty jednocześnie. Widget ZnanyLekarz się na tym wywalił dwa razy z rzędu.
2. **Nie zmieniaj identyfikatorów (`id`) elementów/skryptów integrowanych ze skryptami
   stron trzecich** bez pewności, że nic ich nie szuka po sztywno zakodowanej nazwie —
   błąd `Cannot read properties of null (reading 'getAttribute')` w konsoli był objawem
   właśnie tego (zmieniłem `id="zl-facility-widget"` na coś "czytelniejszego" i to zepsuło
   widget, bo skrypt ZnanyLekarz szukał dokładnie tego stringa).
3. **`{{ pole }}` wewnątrz atrybutu `src` obrazka** powoduje jeden nieszkodliwy, ale realny
   404 w konsoli (przeglądarka próbuje pobrać dosłowny tekst placeholdera zanim React
   zdąży go podmienić) — znany, zaakceptowany kompromis tego frameworka, nie próbować naprawiać.
4. **Zawsze `php -l` po edycji PHP** i test w Dockerze przed commitem — kilka razy uratowało
   to przed wysłaniem błędnej składni.
5. Testowe zmiany w danych robione do weryfikacji (przez panel, przez `?podglad=1`) zawsze
   odrzucaj przyciskiem "Odrzuć" przed commitem, chyba że użytkownik wyraźnie chce je zachować.
6. Deploy do `master` **automatycznie triggeruje production deploy** (rsync/SSH) —
   zawsze pytać o zgodę przed pushem, chyba że użytkownik już się zgodził w tej samej sprawie.

## Zostało z planu
- **Etap 4**: staging przed produkcją, naprawić `deploy.yml` (patrz 🔴 wyżej), wyczyścić repo
  z ~700 nieużywanych SVG (`assets/blood|body|conditions|...`, zostawić tylko
  `assets/specialties/`), usunąć `.thumbnail`/`cmk2.iml`, podnieść limity uploadu na hostingu,
  rozważyć purge cache Cloudflare po publikacji z panelu.
- **Etap 5**: szkolenie klienta, przekazanie hasła kanałem innym niż e-mail.
- Nie ruszone: SEO (strona renderuje się w całości po stronie klienta, brak treści w źródle
  HTML dla Google — świadomie odłożone w oryginalnym planie jako osobny temat).

## Stan repo
Wszystko na `master`, zapushowane, deploy powinien już działać (poza `panel/config.php`
usuwanym przez brak wykluczenia — patrz 🔴). Dane w `data/*.json` to prawdziwa treść klienta,
nie testowa — nie nadpisywać bez pytania.
