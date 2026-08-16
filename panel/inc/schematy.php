<?php
// Definicje pol formularzy dla 4 kolekcji plaskich (lekarze/specjalizacje/aktualnosci).
// Cennik (kategorie+pozycje) ma osobna, dedykowana obsluge w edytuj.php.
//
// Klucze definicji pola: etykieta, pomoc (zdanie pod polem), typ, wymagane, opcje,
// grupa (nazwa karty, do ktorej pole trafia), kolumna ('glowna'|'boczna'), placeholder,
// zwiniete (pole w <details>).

// Lista specjalizacji jako opcje do zaznaczenia przy lekarzu (relacja wiele-do-wielu).
// Czytana zawsze z opublikowanej wersji - zmiana nazw specjalizacji w toku (draft) nie
// przestawia tu etykiet, dopoki nie zostanie opublikowana (rzadki, akceptowalny przypadek).
$opcjeSpecjalizacji = [];
foreach (cmk_wczytaj_json(__DIR__ . '/../../data/specjalizacje.json') as $s) {
    if (!empty($s['id'])) $opcjeSpecjalizacji[$s['id']] = $s['nazwa'] ?? $s['id'];
}

$opcjeTytulow = [
    '' => '(brak)',
    'lek.' => 'lek.',
    'lek. med.' => 'lek. med.',
    'dr' => 'dr',
    'dr n. med.' => 'dr n. med.',
    'dr hab. n. med.' => 'dr hab. n. med.',
    'prof. dr hab. n. med.' => 'prof. dr hab. n. med.',
];

$schematy = [
    // Cennik (kategorie+pozycje) ma osobna, dedykowana obsluge w edytuj.php - ten wpis
    // istnieje tylko po to, zeby etykieta_listy/etykieta_pojedyncza mialy skad sie wziac.
    'cennik' => [
        'etykieta_listy' => 'Cennik',
        'etykieta_pojedyncza' => 'kategorię',
    ],
    'lekarze' => [
        'etykieta_listy' => 'Lekarze',
        'etykieta_pojedyncza' => 'lekarza',
        'tytul' => fn($it) => $it['imie'] ?? '(nowy lekarz)',
        'miniatura' => fn($it) => !empty($it['zdjecie']) ? $it['zdjecie'] : null,
        'plakietki' => function ($it) use ($opcjeSpecjalizacji) {
            $b = [];
            $spec = array_map(function ($id) use ($opcjeSpecjalizacji) { return $opcjeSpecjalizacji[$id] ?? $id; }, $it['specjalizacje'] ?? []);
            $b[] = ['tekst' => $spec ? implode(', ', $spec) : 'Bez specjalizacji', 'ton' => $spec ? 'info' : 'ostrzezenie'];
            if (!empty($it['naStronieGlownej'])) $b[] = ['tekst' => 'Na stronie głównej', 'ton' => 'sukces'];
            if (empty($it['zdjecie'])) $b[] = ['tekst' => 'Brak zdjęcia', 'ton' => 'ostrzezenie'];
            return $b;
        },
        'pola' => [
            'imie' => ['etykieta' => 'Imię i nazwisko', 'typ' => 'text', 'wymagane' => true, 'grupa' => 'Treść', 'kolumna' => 'glowna'],
            'tytul' => ['etykieta' => 'Tytuł', 'typ' => 'wybor', 'opcje' => $opcjeTytulow, 'grupa' => 'Treść', 'kolumna' => 'glowna', 'pomoc' => 'Pojawia się przed imieniem i nazwiskiem.'],
            'podtytul' => ['etykieta' => 'Podtytuł na karcie', 'typ' => 'text', 'wymagane' => true, 'grupa' => 'Treść', 'kolumna' => 'glowna', 'placeholder' => 'np. „USG dzieci”', 'pomoc' => 'Krótki opis widoczny na plakietce zdjęcia.'],
            'zakres' => ['etykieta' => 'Zakres usług', 'typ' => 'textarea', 'grupa' => 'Treść', 'kolumna' => 'glowna'],
            'pacjenci' => ['etykieta' => 'Pacjenci', 'typ' => 'text', 'grupa' => 'Treść', 'kolumna' => 'glowna', 'placeholder' => 'np. Dorośli'],
            'specjalizacje' => ['etykieta' => 'Wykonywane specjalizacje', 'typ' => 'multi-wybor', 'opcje' => $opcjeSpecjalizacji, 'grupa' => 'Treść', 'kolumna' => 'glowna'],
            'zdjecie' => ['etykieta' => 'Zdjęcie', 'typ' => 'zdjecie', 'grupa' => 'Media', 'kolumna' => 'boczna'],
            'plec' => ['etykieta' => 'Płeć', 'typ' => 'radio', 'opcje' => ['K' => 'Kobieta', 'M' => 'Mężczyzna'], 'grupa' => 'Media', 'kolumna' => 'boczna', 'pomoc' => 'Decyduje tylko o tym, który domyślny obrazek pokaże się, gdy lekarz nie ma zdjęcia.'],
            'naStronieGlownej' => ['etykieta' => 'Pokaż na stronie głównej', 'typ' => 'checkbox', 'grupa' => 'Widoczność', 'kolumna' => 'boczna'],
            'widgetHtml' => ['etykieta' => 'Widget ZnanyLekarz (opcjonalnie)', 'typ' => 'textarea', 'grupa' => 'Widoczność', 'kolumna' => 'boczna', 'zwiniete' => true, 'pomoc' => 'Wklej tu CAŁY kod widgetu skopiowany z panelu ZnanyLekarz (link + skrypt), bez zmian. Jeśli puste, przycisk „Umów” otwiera ogólny kalendarz placówki.'],
        ],
    ],
    'specjalizacje' => [
        'etykieta_listy' => 'Specjalizacje',
        'etykieta_pojedyncza' => 'specjalizację',
        'tytul' => fn($it) => $it['nazwa'] ?? '(nowa specjalizacja)',
        'miniatura' => fn($it) => !empty($it['ikona']) ? 'assets/specialties/' . $it['ikona'] . '.svg' : null,
        'plakietki' => function ($it) {
            $b = [];
            $b[] = ['tekst' => !empty($it['ikona']) ? 'Ikona: ' . $it['ikona'] : 'Bez ikony', 'ton' => !empty($it['ikona']) ? 'info' : 'ostrzezenie'];
            if (!empty($it['naStronieGlownej'])) $b[] = ['tekst' => 'Kafel na stronie głównej', 'ton' => 'sukces'];
            return $b;
        },
        'pola' => [
            'nazwa' => ['etykieta' => 'Nazwa', 'typ' => 'text', 'wymagane' => true, 'grupa' => 'Treść', 'kolumna' => 'glowna'],
            'opis' => ['etykieta' => 'Krótki opis', 'typ' => 'text', 'grupa' => 'Treść', 'kolumna' => 'glowna'],
            'ikona' => ['etykieta' => 'Ikona', 'typ' => 'ikona-picker', 'opcje' => cmk_lista_ikon(), 'grupa' => 'Kafel na stronie głównej', 'kolumna' => 'boczna', 'pomoc' => 'Widoczna tylko, gdy kafel jest pokazany na stronie głównej.'],
            'naStronieGlownej' => ['etykieta' => 'Pokaż jako kafel na stronie głównej', 'typ' => 'checkbox', 'grupa' => 'Kafel na stronie głównej', 'kolumna' => 'boczna'],
        ],
    ],
    'aktualnosci' => [
        'etykieta_listy' => 'Aktualności',
        'etykieta_pojedyncza' => 'wpis',
        'tytul' => fn($it) => $it['tytul'] ?? '(nowy wpis)',
        'miniatura' => function ($it) {
            if (!empty($it['zdjecia'][0]) && is_string($it['zdjecia'][0])) return $it['zdjecia'][0];
            if (!empty($it['zdjecie']) && is_string($it['zdjecie'])) return $it['zdjecie'];
            return null;
        },
        'plakietki' => function ($it) {
            $b = [];
            $typ = $it['typ'] ?? 'aktualnosc';
            if (!array_key_exists($typ, CMK_TYPY_AKTUALNOSCI)) $typ = 'aktualnosc';
            $b[] = ['tekst' => CMK_TYPY_AKTUALNOSCI[$typ], 'ton' => 'info'];
            if (!empty($it['data'])) $b[] = ['tekst' => $it['data'], 'ton' => 'neutralna'];
            if (!empty($it['przypiety'])) $b[] = ['tekst' => 'Przypięty', 'ton' => 'sukces'];
            $dataDo = (string) ($it['dataDo'] ?? '');
            if ($dataDo !== '' && $dataDo < date('Y-m-d')) {
                $b[] = ['tekst' => 'Wygasł — nie widać na stronie', 'ton' => 'blad'];
            }
            return $b;
        },
        'pola' => [
            'tytul'       => ['etykieta' => 'Tytuł', 'typ' => 'text', 'wymagane' => true, 'grupa' => 'Treść', 'kolumna' => 'glowna'],
            'tresc'       => ['etykieta' => 'Treść', 'typ' => 'markdown', 'grupa' => 'Treść', 'kolumna' => 'glowna', 'pomoc' => 'Pusta linia = nowy akapit. Można zostawić puste, jeśli wpis to samo zdjęcie.'],
            'zdjecia'     => ['etykieta' => 'Zdjęcia', 'typ' => 'galeria', 'grupa' => 'Treść', 'kolumna' => 'glowna', 'pomoc' => 'Można dodać kilka naraz; wpis działa też bez żadnego. Maksymalnie 8.'],
            'typ'         => ['etykieta' => 'Rodzaj wpisu', 'typ' => 'wybor', 'opcje' => CMK_TYPY_AKTUALNOSCI, 'grupa' => 'Publikacja', 'kolumna' => 'boczna'],
            'data'        => ['etykieta' => 'Data wpisu', 'typ' => 'data', 'wymagane' => true, 'grupa' => 'Publikacja', 'kolumna' => 'boczna'],
            'dataDo'      => ['etykieta' => 'Widoczne do', 'typ' => 'data', 'grupa' => 'Publikacja', 'kolumna' => 'boczna', 'pomoc' => 'Opcjonalnie — po tym dniu wpis sam zniknie ze strony.'],
            'przypiety'   => ['etykieta' => 'Przypnij na górze listy', 'typ' => 'checkbox', 'grupa' => 'Publikacja', 'kolumna' => 'boczna'],
            'ctaEtykieta' => ['etykieta' => 'Napis na przycisku', 'typ' => 'text', 'grupa' => 'Przycisk (opcjonalnie)', 'kolumna' => 'boczna', 'placeholder' => 'np. „Umów badanie”', 'zwiniete' => true],
            'ctaUrl'      => ['etykieta' => 'Adres przycisku', 'typ' => 'text', 'grupa' => 'Przycisk (opcjonalnie)', 'kolumna' => 'boczna', 'placeholder' => 'https://…, tel:… albo mailto:…', 'zwiniete' => true],
        ],
    ],
];
