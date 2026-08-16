<?php
// Renderery pol formularza. cmk_pole() to wspolny wrapper (etykieta, pomoc, blad,
// aria-describedby) wolajacy renderer wlasciwy dla typu pola.

function cmk_pole($klucz, array $def, array $rekord, array $bledy) {
    $typ = $def['typ'];
    // Checkbox/radio maja wlasny uklad etykiety - nie owijac w standardowy wrapper.
    if ($typ === 'checkbox') {
        cmk_pole_checkbox($klucz, $def, $rekord);
        return;
    }

    $idOpisu = $klucz . '-pomoc';
    $idBledu = $klucz . '-blad';
    $blad = $bledy[$klucz] ?? null;
    $opisIds = [];
    if (!empty($def['pomoc'])) $opisIds[] = $idOpisu;
    if ($blad) $opisIds[] = $idBledu;

    $tresc = function () use ($typ, $klucz, $def, $rekord, $opisIds) {
        switch ($typ) {
            case 'text': cmk_pole_text($klucz, $def, $rekord, $opisIds); break;
            case 'textarea': cmk_pole_textarea($klucz, $def, $rekord, $opisIds); break;
            case 'markdown': cmk_pole_markdown($klucz, $def, $rekord, $opisIds); break;
            case 'wybor': cmk_pole_wybor($klucz, $def, $rekord, $opisIds); break;
            case 'radio': cmk_pole_radio($klucz, $def, $rekord); break;
            case 'data': cmk_pole_data($klucz, $def, $rekord, $opisIds); break;
            case 'galeria': cmk_pole_galeria($klucz, $def, $rekord); break;
            case 'multi-wybor': cmk_pole_multi_wybor($klucz, $def, $rekord); break;
            case 'ikona-picker': cmk_pole_ikona_picker($klucz, $def, $rekord); break;
            case 'zdjecie': cmk_pole_zdjecie($klucz, $def, $rekord); break;
        }
    };

    $otwarcieDetails = !empty($def['zwiniete']);
    if ($otwarcieDetails) {
        echo '<details class="pole-zwiniete"><summary>' . htmlspecialchars($def['etykieta']) . '</summary><div class="pole-zwiniete-tresc">';
    }

    echo '<div class="pole' . ($blad ? ' pole--blad' : '') . '">';
    if (!$otwarcieDetails) {
        echo '<label for="' . htmlspecialchars($klucz) . '">' . htmlspecialchars($def['etykieta'])
            . (!empty($def['wymagane']) ? ' <span class="pole-wymagane" aria-hidden="true">*</span>' : '')
            . '</label>';
    }
    if (!empty($def['pomoc'])) {
        echo '<p class="pole-pomoc" id="' . $idOpisu . '">' . htmlspecialchars($def['pomoc']) . '</p>';
    }
    $tresc();
    if ($blad) {
        echo '<p class="pole-blad-tekst" id="' . $idBledu . '" role="alert">' . htmlspecialchars($blad) . '</p>';
    }
    echo '</div>';

    if ($otwarcieDetails) {
        echo '</div></details>';
    }
}

function cmk_atrybuty_opisu($opisIds) {
    return $opisIds ? ' aria-describedby="' . htmlspecialchars(implode(' ', $opisIds)) . '"' : '';
}

function cmk_pole_text($klucz, $def, $rekord, $opisIds) {
    $licznikAttr = !empty($def['licznik']) ? ' data-licznik="' . (int) $def['licznik'] . '"' : '';
    echo '<input type="text" id="' . htmlspecialchars($klucz) . '" name="' . htmlspecialchars($klucz) . '"'
        . ' value="' . htmlspecialchars($rekord[$klucz] ?? '') . '"'
        . (!empty($def['placeholder']) ? ' placeholder="' . htmlspecialchars($def['placeholder']) . '"' : '')
        . (!empty($def['wymagane']) ? ' aria-required="true"' : '')
        . $licznikAttr . cmk_atrybuty_opisu($opisIds) . '>';
}

function cmk_pole_textarea($klucz, $def, $rekord, $opisIds) {
    echo '<textarea id="' . htmlspecialchars($klucz) . '" name="' . htmlspecialchars($klucz) . '"'
        . (!empty($def['placeholder']) ? ' placeholder="' . htmlspecialchars($def['placeholder']) . '"' : '')
        . (!empty($def['wymagane']) ? ' aria-required="true"' : '')
        . cmk_atrybuty_opisu($opisIds) . '>' . htmlspecialchars($rekord[$klucz] ?? '') . '</textarea>';
}

function cmk_pole_markdown($klucz, $def, $rekord, $opisIds) {
    echo '<div class="md-toolbar" data-md-dla="' . htmlspecialchars($klucz) . '">'
        . '<button type="button" data-md="pogrubienie" title="Pogrubienie"><strong>B</strong></button>'
        . '<button type="button" data-md="kursywa" title="Kursywa"><em>I</em></button>'
        . '<button type="button" data-md="naglowek" title="Nagłówek">Nagłówek</button>'
        . '<button type="button" data-md="lista" title="Lista">Lista</button>'
        . '<button type="button" data-md="link" title="Link">Link</button>'
        . '<button type="button" class="md-tab-podglad" data-md-podglad="' . htmlspecialchars($klucz) . '">Podgląd</button>'
        . '</div>';
    echo '<textarea id="' . htmlspecialchars($klucz) . '" name="' . htmlspecialchars($klucz) . '" class="md-pole"'
        . (!empty($def['wymagane']) ? ' aria-required="true"' : '')
        . cmk_atrybuty_opisu($opisIds) . '>' . htmlspecialchars($rekord[$klucz] ?? '') . '</textarea>';
    echo '<div class="md-podglad" id="' . htmlspecialchars($klucz) . '-podglad" hidden></div>';
}

function cmk_pole_wybor($klucz, $def, $rekord, $opisIds) {
    echo '<select id="' . htmlspecialchars($klucz) . '" name="' . htmlspecialchars($klucz) . '"' . cmk_atrybuty_opisu($opisIds) . '>';
    foreach ($def['opcje'] as $wartosc => $etykieta) {
        $wybrana = ($rekord[$klucz] ?? '') === (string) $wartosc;
        echo '<option value="' . htmlspecialchars($wartosc) . '"' . ($wybrana ? ' selected' : '') . '>' . htmlspecialchars($etykieta) . '</option>';
    }
    echo '</select>';
}

function cmk_pole_radio($klucz, $def, $rekord) {
    $wybrana = $rekord[$klucz] ?? array_key_first($def['opcje']);
    echo '<div class="radio-rzad">';
    foreach ($def['opcje'] as $wartosc => $etykieta) {
        $id = $klucz . '_' . $wartosc;
        echo '<label class="radio-opcja"><input type="radio" id="' . htmlspecialchars($id) . '" name="' . htmlspecialchars($klucz) . '" value="' . htmlspecialchars($wartosc) . '"'
            . ($wybrana === $wartosc ? ' checked' : '') . '> ' . htmlspecialchars($etykieta) . '</label>';
    }
    echo '</div>';
}

function cmk_pole_data($klucz, $def, $rekord, $opisIds) {
    echo '<input type="date" id="' . htmlspecialchars($klucz) . '" name="' . htmlspecialchars($klucz) . '"'
        . ' value="' . htmlspecialchars($rekord[$klucz] ?? '') . '"'
        . (!empty($def['wymagane']) ? ' aria-required="true"' : '')
        . cmk_atrybuty_opisu($opisIds) . '>';
}

function cmk_pole_checkbox($klucz, $def, $rekord) {
    echo '<div class="pole pole-checkbox">';
    echo '<label class="checkbox-rzad"><input type="checkbox" id="' . htmlspecialchars($klucz) . '" name="' . htmlspecialchars($klucz) . '"'
        . (!empty($rekord[$klucz]) ? ' checked' : '') . '> ' . htmlspecialchars($def['etykieta']) . '</label>';
    if (!empty($def['pomoc'])) echo '<p class="pole-pomoc">' . htmlspecialchars($def['pomoc']) . '</p>';
    echo '</div>';
}

function cmk_pole_multi_wybor($klucz, $def, $rekord) {
    if (empty($def['opcje'])) {
        echo '<p class="pole-pomoc">Brak zdefiniowanych specjalizacji — dodaj je najpierw w zakładce „Specjalizacje”.</p>';
        return;
    }
    $wybrane = $rekord[$klucz] ?? [];
    echo '<div class="wybor-specjalizacji" data-klucz="' . htmlspecialchars($klucz) . '">';
    echo '<div class="wybor-specjalizacji-chipy" data-role="chipy"></div>';
    echo '<input type="text" class="wybor-specjalizacji-szukaj" placeholder="Szukaj specjalizacji…" data-role="szukaj">';
    echo '<p class="wybor-specjalizacji-licznik" data-role="licznik"></p>';
    echo '<div class="wybor-specjalizacji-siatka" data-role="siatka">';
    foreach ($def['opcje'] as $wartosc => $etykieta) {
        $id = $klucz . '_' . $wartosc;
        echo '<label class="checkbox-rzad" data-nazwa="' . htmlspecialchars(mb_strtolower($etykieta, 'UTF-8')) . '">'
            . '<input type="checkbox" id="' . htmlspecialchars($id) . '" name="' . htmlspecialchars($klucz) . '[]" value="' . htmlspecialchars($wartosc) . '"'
            . (in_array($wartosc, $wybrane, true) ? ' checked' : '') . '> ' . htmlspecialchars($etykieta) . '</label>';
    }
    echo '</div></div>';
}

function cmk_pole_ikona_picker($klucz, $def, $rekord) {
    $ikonaWybrana = $rekord[$klucz] ?? '';
    echo '<input type="hidden" id="' . htmlspecialchars($klucz) . '" name="' . htmlspecialchars($klucz) . '" value="' . htmlspecialchars($ikonaWybrana) . '">';
    echo '<input type="text" class="ikona-szukaj" placeholder="Szukaj ikony…" data-ikona-szukaj="' . htmlspecialchars($klucz) . '">';
    echo '<div class="ikona-podglad" data-ikona-podglad="' . htmlspecialchars($klucz) . '">';
    if ($ikonaWybrana !== '') {
        echo '<img src="../assets/specialties/' . htmlspecialchars($ikonaWybrana) . '.svg" alt="" width="40" height="40"> <span>' . htmlspecialchars($ikonaWybrana) . '</span>';
    } else {
        echo '<span class="pole-pomoc" style="margin:0;">Brak wybranej ikony</span>';
    }
    echo '</div>';
    echo '<div class="ikona-picker" data-klucz="' . htmlspecialchars($klucz) . '">';
    echo '<button type="button" class="ikona-item ikona-item--brak' . ($ikonaWybrana === '' ? ' wybrana' : '') . '" data-ikona-wybor="" data-nazwa="brak">Brak</button>';
    foreach ($def['opcje'] as $ikonaId) {
        echo '<button type="button" class="ikona-item' . ($ikonaId === $ikonaWybrana ? ' wybrana' : '') . '" data-ikona-wybor="' . htmlspecialchars($ikonaId) . '" data-nazwa="' . htmlspecialchars($ikonaId) . '" title="' . htmlspecialchars($ikonaId) . '">'
            . '<img src="../assets/specialties/' . htmlspecialchars($ikonaId) . '.svg" alt="" width="28" height="28" loading="lazy"></button>';
    }
    echo '</div>';
}

function cmk_pole_zdjecie($klucz, $def, $rekord) {
    if (!empty($rekord[$klucz])) {
        echo '<div class="zdjecie-podglad">'
            . '<img src="../' . htmlspecialchars($rekord[$klucz]) . '" alt="">'
            . '<label class="checkbox-rzad"><input type="checkbox" name="' . htmlspecialchars($klucz) . '_usun"> Usuń zdjęcie</label>'
            . '</div>';
    }
    echo '<label class="dropzone" data-dropzone="' . htmlspecialchars($klucz) . '">'
        . '<input type="file" id="' . htmlspecialchars($klucz) . '" name="' . htmlspecialchars($klucz) . '" accept="image/jpeg,image/png,image/webp">'
        . '<span class="dropzone-tekst">Przeciągnij zdjęcie albo kliknij, żeby wybrać</span>'
        . '<span class="dropzone-podglad" data-dropzone-podglad hidden></span>'
        . '</label>';
}

function cmk_pole_galeria($klucz, $def, $rekord) {
    echo '<div class="galeria-lista" data-klucz="' . htmlspecialchars($klucz) . '">';
    foreach ((array) ($rekord[$klucz] ?? []) as $sciezka) {
        if (!is_string($sciezka) || $sciezka === '') continue;
        echo '<div class="galeria-item" draggable="true">'
            . '<img src="../' . htmlspecialchars($sciezka) . '" alt="">'
            . '<input type="hidden" name="zdjecia_istniejace[]" value="' . htmlspecialchars($sciezka) . '">'
            . '<button type="button" class="galeria-item-x" data-galeria-usun title="Usuń">&times;</button>'
            . '</div>';
    }
    echo '</div>';
    echo '<label class="dropzone dropzone--galeria" data-dropzone-galeria="' . htmlspecialchars($klucz) . '">'
        . '<input type="file" name="zdjecia_nowe[]" multiple accept="image/jpeg,image/png,image/webp">'
        . '<span class="dropzone-tekst">Przeciągnij zdjęcia albo kliknij, żeby wybrać</span>'
        . '</label>';
    echo '<p class="galeria-licznik" data-galeria-licznik="' . htmlspecialchars($klucz) . '"></p>';
}
