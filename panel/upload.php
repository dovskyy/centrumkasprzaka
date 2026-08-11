<?php
// Biblioteka funkcji do obslugi uploadu zdjec. Nie jest wywolywana bezposrednio jako
// endpoint HTTP - edytuj.php woła cmk_upload_zdjecie() po zweryfikowaniu sesji.

define('CMK_UPLOAD_DOZWOLONE_TYPY', [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP]);
define('CMK_UPLOAD_MAX_BAJTOW', 12 * 1024 * 1024);
define('CMK_UPLOAD_MAX_SZEROKOSC', 900);

// Mapuje kod bledu $_FILES[...]['error'] na czytelny komunikat PL - klient (fotka z telefonu)
// najczesciej trafi na UPLOAD_ERR_INI_SIZE.
function cmk_blad_uploadu($kod) {
    switch ($kod) {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            return 'Zdjęcie jest za duże — limit serwera to ' . ini_get('upload_max_filesize') . '.';
        case UPLOAD_ERR_PARTIAL:
            return 'Przesyłanie zdjęcia zostało przerwane. Spróbuj ponownie.';
        case UPLOAD_ERR_NO_FILE:
            return 'Nie wybrano pliku.';
        case UPLOAD_ERR_NO_TMP_DIR:
        case UPLOAD_ERR_CANT_WRITE:
        case UPLOAD_ERR_EXTENSION:
            return 'Błąd serwera przy zapisie pliku. Spróbuj ponownie.';
        default:
            return 'Błąd przesyłania pliku.';
    }
}

// Zwraca sciezke wzgledna (np. "uploads/xxxx.webp") albo tablice ['blad' => '...'].
// $maxSzerokosc: galeria aktualnosci wola z 1400 (zdjecia na cala szerokosc kolumny 720px, 900px
// to za malo na ekrany 2x), pozostale wywolania uzywaja domyslnych 900.
function cmk_upload_zdjecie(array $plik, $maxSzerokosc = CMK_UPLOAD_MAX_SZEROKOSC) {
    if (!isset($plik['error']) || $plik['error'] !== UPLOAD_ERR_OK) {
        return ['blad' => cmk_blad_uploadu($plik['error'] ?? UPLOAD_ERR_NO_FILE)];
    }
    if ($plik['size'] > CMK_UPLOAD_MAX_BAJTOW) {
        return ['blad' => 'Plik jest zbyt duży (limit ' . (CMK_UPLOAD_MAX_BAJTOW / 1024 / 1024) . ' MB).'];
    }
    if (!extension_loaded('gd')) {
        return ['blad' => 'Serwer nie ma zainstalowanego rozszerzenia GD do obsługi zdjęć — skontaktuj się z administratorem.'];
    }
    // getimagesize czyta naglowek pliku, nie ufa rozszerzeniu - odrzuca np. .php zmienione na .jpg.
    $info = @getimagesize($plik['tmp_name']);
    if ($info === false || !in_array($info[2], CMK_UPLOAD_DOZWOLONE_TYPY, true)) {
        return ['blad' => 'Nieobsługiwany format pliku — dozwolone: JPG, PNG, WebP.'];
    }

    $obraz = cmk_wczytaj_obraz($plik['tmp_name'], $info[2]);
    if (!$obraz) {
        return ['blad' => 'Nie udało się odczytać obrazu.'];
    }

    $obraz = cmk_zastosuj_orientacje_exif($obraz, $plik['tmp_name'], $info[2]);
    $obraz = cmk_przeskaluj($obraz, $maxSzerokosc);

    $katalogUploads = __DIR__ . '/../uploads/';
    $mozeWebp = function_exists('imagewebp');
    $nazwa = 'cmk-' . bin2hex(random_bytes(8)) . ($mozeWebp ? '.webp' : '.jpg');
    $sciezkaPelna = $katalogUploads . $nazwa;

    imagesavealpha($obraz, true);
    $zapisano = $mozeWebp ? imagewebp($obraz, $sciezkaPelna, 82) : imagejpeg($obraz, $sciezkaPelna, 85);
    imagedestroy($obraz);

    if (!$zapisano) {
        return ['blad' => 'Nie udało się zapisać przeskalowanego obrazu.'];
    }
    return 'uploads/' . $nazwa;
}

function cmk_wczytaj_obraz($tmpName, $typ) {
    switch ($typ) {
        case IMAGETYPE_JPEG: return @imagecreatefromjpeg($tmpName);
        case IMAGETYPE_PNG: return @imagecreatefrompng($tmpName);
        case IMAGETYPE_WEBP: return function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($tmpName) : false;
        default: return false;
    }
}

// Telefony zapisuja zdjecia w EXIF-owej orientacji zamiast obracac piksele - bez tego
// zdjecia pionowe wychodza polozone na boku.
function cmk_zastosuj_orientacje_exif($obraz, $tmpName, $typ) {
    if ($typ !== IMAGETYPE_JPEG || !function_exists('exif_read_data')) return $obraz;
    $exif = @exif_read_data($tmpName);
    if (!$exif || empty($exif['Orientation'])) return $obraz;
    switch ($exif['Orientation']) {
        case 3: return imagerotate($obraz, 180, 0);
        case 6: return imagerotate($obraz, -90, 0);
        case 8: return imagerotate($obraz, 90, 0);
        default: return $obraz;
    }
}

function cmk_przeskaluj($obraz, $maxSzerokosc) {
    $w = imagesx($obraz);
    $h = imagesy($obraz);
    if ($w <= $maxSzerokosc) return $obraz;
    $nowaH = (int) round($h * ($maxSzerokosc / $w));
    $docelowy = imagecreatetruecolor($maxSzerokosc, $nowaH);
    imagealphablending($docelowy, false);
    imagesavealpha($docelowy, true);
    imagecopyresampled($docelowy, $obraz, 0, 0, 0, 0, $maxSzerokosc, $nowaH, $w, $h);
    imagedestroy($obraz);
    return $docelowy;
}
