<?php
// Biblioteka funkcji do obslugi uploadu zdjec. Nie jest wywolywana bezposrednio jako
// endpoint HTTP - edytuj.php woła cmk_upload_zdjecie() po zweryfikowaniu sesji.

define('CMK_UPLOAD_DOZWOLONE_TYPY', [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP]);
define('CMK_UPLOAD_MAX_BAJTOW', 8 * 1024 * 1024);
define('CMK_UPLOAD_MAX_SZEROKOSC', 900);

// Zwraca sciezke wzgledna (np. "uploads/xxxx.webp") albo tablice ['blad' => '...'].
function cmk_upload_zdjecie(array $plik) {
    if (!isset($plik['error']) || $plik['error'] !== UPLOAD_ERR_OK) {
        return ['blad' => 'Blad przesylania pliku.'];
    }
    if ($plik['size'] > CMK_UPLOAD_MAX_BAJTOW) {
        return ['blad' => 'Plik jest zbyt duzy (limit 8 MB).'];
    }
    // getimagesize czyta naglowek pliku, nie ufa rozszerzeniu - odrzuca np. .php zmienione na .jpg.
    $info = @getimagesize($plik['tmp_name']);
    if ($info === false || !in_array($info[2], CMK_UPLOAD_DOZWOLONE_TYPY, true)) {
        return ['blad' => 'Nieobslugiwany format pliku - dozwolone: JPG, PNG, WebP.'];
    }

    $obraz = cmk_wczytaj_obraz($plik['tmp_name'], $info[2]);
    if (!$obraz) {
        return ['blad' => 'Nie udalo sie odczytac obrazu.'];
    }

    $obraz = cmk_zastosuj_orientacje_exif($obraz, $plik['tmp_name'], $info[2]);
    $obraz = cmk_przeskaluj($obraz, CMK_UPLOAD_MAX_SZEROKOSC);

    $katalogUploads = __DIR__ . '/../uploads/';
    $mozeWebp = function_exists('imagewebp');
    $nazwa = 'cmk-' . bin2hex(random_bytes(8)) . ($mozeWebp ? '.webp' : '.jpg');
    $sciezkaPelna = $katalogUploads . $nazwa;

    imagesavealpha($obraz, true);
    $zapisano = $mozeWebp ? imagewebp($obraz, $sciezkaPelna, 82) : imagejpeg($obraz, $sciezkaPelna, 85);
    imagedestroy($obraz);

    if (!$zapisano) {
        return ['blad' => 'Nie udalo sie zapisac przeskalowanego obrazu.'];
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
