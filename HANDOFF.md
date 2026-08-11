# Handoff — CMK2 (Centrum Medyczne Kasprzaka)

## Co to za projekt
Strona przychodni, migrowana ze statycznego HTML (React-owy runtime "dc" w `support.js`,
**nie edytować `support.js` ręcznie** — wygenerowany, nieprzebudowywalny z tego repo) na
PHP z panelem edycji treści dla właściciela (osoba nietechniczna, bez gita).

Plan pierwszego wdrożenia (Etapy 0–5, zrobione): `C:\Users\Marcel\.claude\plans\przeanalizuj-struktur-tego-projektu-radiant-lecun.md`.
Plan sekcji Aktualności/Promocje/Wydarzenia (Etapy 0–6 zrobione, patrz niżej):
`C:\Users\Marcel\.claude\plans\aktualnosci-promocje-wydarzenia-lucid-hopper.md`.

Repo: `dovskyy/centrumkasprzaka`. **Pracujemy na branchu `master`** (nie `php-implementation` —
użytkownik scalił sam po tym, jak wcześniej zbudowaliśmy to na osobnym branchu).

## 🔴 Do zrobienia po najbliższym pushu
1. **Podnieść limity uploadu na hostingu** — dziś `upload_max_filesize=2M`, `post_max_size=8M`,
   za mało na zdjęcia z telefonu i galerię kilku zdjęć naraz. Podnieść do min. `12M`/`64M`
   (panel hostingu albo `.user.ini` — zweryfikować `phpinfo()` po zmianie).
2. Odtworzyć/zweryfikować `panel/config.php` na serwerze (patrz sekcja "Panel" niżej) —
   `.github/workflows/deploy.yml` już go wyklucza z `rsync --delete` (poprawione, patrz "Zrobione").
3. Rozważyć purge cache Cloudflare po pierwszej publikacji nowych treści z panelu.

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
  `data/*.json` jest w `.gitignore` (od commitu `242cfe9`) — plik na produkcji żyje własnym
  życiem, deploy go nie nadpisuje.
- `data/*.draft.json` — wersje robocze z panelu (gitignored). `data/_kopie/` — backupy przy
  publikacji, ostatnie 20 (gitignored, poza `.gitkeep`).
- `inc/tresc.php` — ładuje `data/*.json`, obsługuje `?podglad=1` (pokazuje draft tylko dla
  zalogowanej sesji panelu), wpina normalizację aktualności (patrz niżej) i definiuje
  `CMK_BAZOWY_URL` (do absolutnych `og:image`).
- `inc/aktualnosci.php` — **nowy**. `cmk_normalizuj_aktualnosci()`: jedno miejsce, gdzie rekord
  aktualności dostaje ostateczny kształt — uzupełnia braki, tłumaczy stary format
  (`zdjecie: string|null`) na nowy (`zdjecia: string[]`), odsiewa wpisy z przeterminowanym
  `dataDo`, dolicza `dataOpis`/`dataDoOpis`/`zajawka`/`akapity`/`href`/`typEtykieta`, sortuje
  (przypięte → data malejąco → indeks wejściowy jako tiebreaker, bo `usort` w PHP 7.4 nie jest
  stabilny). `index.php`/`aktualnosci.php` konsumują już gotowe dane, JS nic nie dolicza.
  Panel czyta pliki surowo (własnym `cmk_wczytaj_json`) — wpisy po terminie muszą być
  w panelu nadal edytowalne.
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
  Typy pól: `text`, `textarea`, `checkbox`, `multi-wybor` (checkboxy, wiele wartości),
  `wybor` (select, kontrakt `wartość => etykieta` — assoc, nie płaska lista), `zdjecie`
  (jeden plik), `ikona-picker`, **`data`** (`<input type=date>`, walidacja `RRRR-MM-DD`),
  **`galeria`** (wiele zdjęć: istniejące jako ukryte pola `zdjecia_istniejace[]` w kolejności
  DOM + checkbox `zdjecia_usun[]` usuwany po ścieżce nie indeksie, strzałki JS do reorderu,
  nowe pliki `zdjecia_nowe[]` — `$_FILES` z `multiple` ma kształt "tablica per klucz",
  `cmk_przepakuj_pliki()` przepakowuje na "tablica per plik" przed `cmk_upload_zdjecie()`;
  limit 8 zdjęć/wpis). `id` dla `aktualnosci`/`specjalizacje` generowany automatycznie
  (`cmk_unikalny_slug()`) przy pierwszym zapisie, potem niezmienny.
  **Uwaga:** wartości `textarea` normalizują `\r\n`→`\n` przy zapisie (przeglądarka wysyła
  CRLF, a `explode("\n\n", ...)` w `inc/aktualnosci.php` by tego nie rozdzielił — akapity
  by się nie rozbiły). Guard w JS + PHP na przekroczony `post_max_size` (patrz pułapka niżej).
- `panel/upload.php` — walidacja `getimagesize()` (odrzuca np. `.php` pod `.jpg`), EXIF
  orientation, resize do `$maxSzerokosc` (domyślnie 900px, galeria aktualności woła z 1400px),
  zapis jako WebP (fallback JPEG), limit 12MB/plik. Komunikaty błędów PL per kod `UPLOAD_ERR_*`.
  **Nigdy nie kasujemy plików z `uploads/`** przy usunięciu zdjęcia z wpisu (draft→publikacja
  workflow: zdjęcie usunięte w draft może być wciąż używane przez opublikowaną wersję).
  Osierocone pliki zostają — świadoma decyzja, nie błąd.
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

## Zrobione: sekcja Aktualności/Promocje/Wydarzenia (Etapy 0–6 z drugiego planu)
Rekord `data/aktualnosci.json` ma teraz: `id`, `typ` (`aktualnosc`/`promocja`/`wydarzenie`),
`tytul`, `data`, `dataDo` (opcjonalnie — po tym dniu wpis znika ze strony automatycznie),
`przypiety` (bool, na górze listy), `zdjecia` (tablica, może być pusta), `tresc`, `ctaEtykieta`/
`ctaUrl` (opcjonalny przycisk, whitelist schematów https/http/mailto/tel — zabezpieczenie XSS
w panelu i w normalizatorze, druga linia obrony). Stare rekordy (`zdjecie: string|null`,
bez `typ`) współistnieją bez migracji — normalizacja przy odczycie w `inc/aktualnosci.php`.

- Górna nawigacja (4 pliki, nav-links + mobile-menu) ma teraz link "Aktualności". Breakpoint
  nawigacji podniesiony 1000px -> 1120px (CSS w 3 plikach x2 miejsca + JS w `index.php` x2
  miejsca) - szósta pozycja w menu zaczynała się łamać przy starym progu.
  `specjalisci.php`/`cennik.php`/`aktualnosci.php` nadal nie mają linku "Cennik" w górnym
  menu (przedistniejący gap, poza zakresem tego zadania - "Aktualności" wstawione tam, gdzie
  "Cennik" byłby w kolejności, czyli przed "Kontakt").
- Strona główna: sekcja `#aktualnosci` między `#opinie` a `#kontakt` (`var(--gradient-wash)`,
  znika całkowicie gdy brak wpisów), max 3 najnowsze kafelki + "Zobacz wszystkie".
- `aktualnosci.php`: archiwum z filtrami po typie (chipy widoczne tylko dla typów, które
  faktycznie występują w danych), kafelki z badge/miniaturą/"+N" przy wielu zdjęciach; widok
  pojedynczego wpisu z galerią (1 zdjęcie -> pełna szerokość, 2 -> dwie kolumny, 3+ -> pierwsze
  pełna szerokość + reszta w siatce - CSS klasy `.wpis-galeria-2`/`.wpis-galeria-3plus`, nie
  inline `grid-template-columns`, żeby media query na mobile mogło to nadpisać), CTA, poprzedni/
  następny wpis. Prawdziwy `<head>` (nie `<helmet>`) z SEO: title/meta description/og:*/
  canonical per wpis, `http_response_code(404)` dla nieznanego `?post=`.
- Etap 0 z pierwszego planu dociągnięty: `.github/workflows/deploy.yml` `EXCLUDE` ma teraz
  `/panel/config.php, /panel/_attempts.json`.
- Nie zrobione (Etap 7 z drugiego planu, opcjonalne, poza zakresem): lightbox galerii, pasek
  promocyjny pod headerem, `<noscript>` z listą dla crawlerów, skrypt czyszczący osierocone pliki.

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
7. **Wartości `<textarea>` z formularza w panelu trzeba normalizować `\r\n`→`\n` przed zapisem**
   (przeglądarka wysyła CRLF), inaczej `explode("\n\n", $tresc)` po stronie PHP nigdy nie
   znajdzie pustej linii i wielo-akapitowa treść wyrenderuje się jako jeden akapit ze sklejonymi
   złamaniami linii w środku. Złapane przy budowie `inc/aktualnosci.php` — normalizacja jest
   teraz w dwóch miejscach: przy zapisie w `panel/edytuj.php` i defensywnie w normalizatorze.

## Zostało z planu
- **Etap 4** (pierwszy plan): staging przed produkcją, wyczyścić repo z ~700 nieużywanych SVG
  (`assets/blood|body|conditions|...`, zostawić tylko `assets/specialties/`), usunąć
  `.thumbnail`/`cmk2.iml`, podnieść limity uploadu na hostingu (patrz 🔴 wyżej), rozważyć purge
  cache Cloudflare po publikacji z panelu.
- **Etap 5** (pierwszy plan): szkolenie klienta, przekazanie hasła kanałem innym niż e-mail.
- Nie ruszone: ogólne SEO stron innych niż `aktualnosci.php` (index/specjalisci/cennik nadal
  renderują się w całości po stronie klienta, brak treści w źródle HTML dla Google —
  `aktualnosci.php` ma już to rozwiązane, patrz wyżej).
- Etap 7 z drugiego planu (opcjonalne rozszerzenia aktualności) — patrz wyżej.

## Stan repo
Zmiany z drugiego planu (sekcja Aktualności/Promocje/Wydarzenia) **zaimplementowane i
przetestowane lokalnie (Docker, PHP 7.4-cli), jeszcze niezapushowane** — pytać o zgodę przed
pushem (patrz pułapka 6 wyżej). Poza tym wszystko na `master`, zapushowane, deploy powinien już
działać. Dane w `data/*.json` to prawdziwa treść klienta, nie testowa — nie nadpisywać bez
pytania (testowe wpisy dodane podczas tej sesji do weryfikacji zostały usunięte przed
zakończeniem pracy, `data/aktualnosci.json` wrócił do dwóch oryginalnych wpisów klienta).
