(function () {
  'use strict';

  /* ---------- Sidebar mobilny ---------- */
  var hamburger = document.getElementById('hamburger');
  var sidebar = document.getElementById('sidebar');
  var tlo = document.getElementById('tlo-nawigacji');
  if (hamburger && sidebar && tlo) {
    function zamknijSidebar() {
      sidebar.classList.remove('otwarty');
      tlo.classList.remove('widoczne');
      hamburger.setAttribute('aria-expanded', 'false');
    }
    hamburger.addEventListener('click', function () {
      var otwarty = sidebar.classList.toggle('otwarty');
      tlo.classList.toggle('widoczne', otwarty);
      hamburger.setAttribute('aria-expanded', otwarty ? 'true' : 'false');
    });
    tlo.addEventListener('click', zamknijSidebar);
  }

  /* ---------- Toasty: auto-znikanie + zamykanie ---------- */
  document.querySelectorAll('.toast').forEach(function (toast) {
    var czasomierz = setTimeout(function () { toast.remove(); }, 5000);
    var zamknij = toast.querySelector('.toast-zamknij');
    if (zamknij) zamknij.addEventListener('click', function () { clearTimeout(czasomierz); toast.remove(); });
  });

  /* ---------- Modale (<dialog>) ---------- */
  document.querySelectorAll('[data-modal-otworz]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var modal = document.getElementById(btn.dataset.modalOtworz);
      if (modal && modal.showModal) modal.showModal();
    });
  });
  document.querySelectorAll('[data-modal-zamknij]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var modal = btn.closest('dialog');
      if (modal) modal.close();
    });
  });
  document.querySelectorAll('dialog.modal').forEach(function (modal) {
    modal.addEventListener('click', function (e) {
      if (e.target === modal) modal.close();
    });
  });

  // Modal odrzucenia wszystkiego: przycisk potwierdzenia odblokowany dopiero po wpisaniu "usuń".
  document.querySelectorAll('[data-wymaga-tekstu]').forEach(function (input) {
    var oczekiwane = input.dataset.wymagaTekstu.trim().toLowerCase();
    var przycisk = input.closest('form').querySelector('[data-czeka-na-tekst]');
    input.addEventListener('input', function () {
      przycisk.disabled = input.value.trim().toLowerCase() !== oczekiwane;
    });
  });

  /* ---------- Wyszukiwarka listy + chipy filtrow ---------- */
  document.querySelectorAll('[data-lista-szukaj]').forEach(function (input) {
    var kontener = document.querySelector(input.dataset.listaSzukaj);
    var licznikEl = document.querySelector('[data-lista-licznik="' + input.dataset.listaSzukaj.replace('#', '') + '"]');
    var wiersze = kontener ? Array.prototype.slice.call(kontener.querySelectorAll('[data-wiersz]')) : [];
    var stanFiltrow = {};
    var pasekWyszukiwania = kontener ? kontener.closest('.pasek-narzedzi-wrap') || document : document;
    var chipy = pasekWyszukiwania.querySelectorAll('[data-chip-filtr]');

    function zastosujFiltry() {
      var fraza = input.value.trim().toLowerCase();
      var filtrAktywny = fraza !== '' || Object.keys(stanFiltrow).some(function (g) { return !!stanFiltrow[g]; });
      var widocznych = 0;
      wiersze.forEach(function (w) {
        var tekst = (w.dataset.szukaj || '').toLowerCase();
        var pasujeSzukaj = fraza === '' || tekst.indexOf(fraza) !== -1;
        var pasujeChipy = true;
        Object.keys(stanFiltrow).forEach(function (grupa) {
          if (!stanFiltrow[grupa]) return;
          var flagi = (w.dataset['filtr' + grupa] || '').split(' ');
          if (flagi.indexOf(stanFiltrow[grupa]) === -1) pasujeChipy = false;
        });
        var pokaz = pasujeSzukaj && pasujeChipy;
        w.hidden = !pokaz;
        if (pokaz) widocznych++;

        // Kolejnosc (drag&drop, strzalki w menu) ma sens tylko na pelnej, niefiltrowanej
        // liscie - przy aktywnym filtrze indeksy widocznych wierszy nie odpowiadaja realnej
        // kolejnosci w danych, wiec przeciaganie dawaloby mylacy, bledny efekt.
        w.draggable = !filtrAktywny;
        var uchwyt = w.querySelector('.uchwyt-przeciagania');
        if (uchwyt) uchwyt.classList.toggle('uchwyt-przeciagania--zablokowany', filtrAktywny);
        w.querySelectorAll('[data-w-gore], [data-w-dol]').forEach(function (btn) {
          if (btn.dataset.brzeg === undefined) btn.dataset.brzeg = btn.disabled ? '1' : '0';
          btn.disabled = filtrAktywny || btn.dataset.brzeg === '1';
        });
      });
      if (licznikEl) licznikEl.textContent = 'Pokazano ' + widocznych + ' z ' + wiersze.length;
      var pustyWynik = kontener.querySelector('[data-stan-pusty-wyniku]');
      if (pustyWynik) pustyWynik.hidden = widocznych !== 0 || wiersze.length === 0;
      var wyczysc = document.querySelector('[data-szukaj-wyczysc="' + input.id + '"]');
      if (wyczysc) wyczysc.hidden = fraza === '';
      var info = document.querySelector('[data-szukajka-info-kolejnosc]');
      if (info) info.hidden = !filtrAktywny;
    }
    input.addEventListener('input', zastosujFiltry);
    var wyczyscBtn = document.querySelector('[data-szukaj-wyczysc="' + input.id + '"]');
    if (wyczyscBtn) wyczyscBtn.addEventListener('click', function () { input.value = ''; zastosujFiltry(); input.focus(); });

    chipy.forEach(function (chip) {
      chip.addEventListener('click', function () {
        var grupa = chip.dataset.chipFiltr;
        var wartosc = chip.dataset.chipWartosc;
        var aktywny = stanFiltrow[grupa] === wartosc;
        stanFiltrow[grupa] = aktywny ? null : wartosc;
        pasekWyszukiwania.querySelectorAll('[data-chip-filtr="' + grupa + '"]').forEach(function (c) { c.classList.remove('aktywny'); });
        if (!aktywny) chip.classList.add('aktywny');
        zastosujFiltry();
      });
    });
    zastosujFiltry();
  });

  /* ---------- Reorder list drag&drop + strzalki menu ---------- */
  function podepnijReorder(kontenerSelektor, elementSelektor, uchwytSelektor) {
    document.querySelectorAll(kontenerSelektor).forEach(function (kontener) {
      var przeciagany = null;

      function pokazPasekZmiany() {
        var pasek = document.getElementById('pasek-kolejnosc');
        if (pasek) pasek.hidden = false;
      }

      kontener.addEventListener('dragstart', function (e) {
        var el = e.target.closest(elementSelektor);
        if (!el) return;
        przeciagany = el;
        el.classList.add('przeciagany');
      });
      kontener.addEventListener('dragend', function (e) {
        var el = e.target.closest(elementSelektor);
        if (el) el.classList.remove('przeciagany');
        przeciagany = null;
      });
      kontener.addEventListener('dragover', function (e) {
        e.preventDefault();
        var nad = e.target.closest(elementSelektor);
        if (!nad || nad === przeciagany || !przeciagany) return;
        var rect = nad.getBoundingClientRect();
        var wSrodku = kontener.classList.contains('galeria-lista')
          ? (e.clientX - rect.left) < rect.width / 2
          : (e.clientY - rect.top) < rect.height / 2;
        kontener.insertBefore(przeciagany, wSrodku ? nad : nad.nextSibling);
      });
      kontener.addEventListener('drop', function (e) {
        e.preventDefault();
        pokazPasekZmiany();
        kontener.dispatchEvent(new CustomEvent('cmk:kolejnosc-zmieniona'));
      });

      kontener.querySelectorAll('[data-w-gore], [data-w-dol]').forEach(function (btn) {
        btn.addEventListener('click', function () {
          var el = btn.closest(elementSelektor);
          if (!el) return;
          if (btn.hasAttribute('data-w-gore') && el.previousElementSibling) {
            kontener.insertBefore(el, el.previousElementSibling);
          } else if (btn.hasAttribute('data-w-dol') && el.nextElementSibling) {
            kontener.insertBefore(el.nextElementSibling, el);
          }
          btn.focus();
          pokazPasekZmiany();
          kontener.dispatchEvent(new CustomEvent('cmk:kolejnosc-zmieniona'));
        });
      });
    });
  }
  podepnijReorder('[data-reorder-lista]', '[data-wiersz]');
  podepnijReorder('.galeria-lista', '.galeria-item');

  // Pasek "Kolejność zmieniona": Zapisz przelicza hidden inputs kolejnosc[] wg biezacego DOM,
  // Cofnij przeladowuje strone (najprostszy, niezawodny powrot do stanu z serwera).
  var paskZmiany = document.getElementById('pasek-kolejnosc');
  if (paskZmiany) {
    var formularzListy = document.getElementById('formularz-lista');
    var kontenerListy = document.querySelector('[data-reorder-lista]');
    document.addEventListener('cmk:kolejnosc-zmieniona', function () { paskZmiany.hidden = false; });
    var zapiszBtn = paskZmiany.querySelector('[data-zapisz-kolejnosc]');
    var cofnijBtn = paskZmiany.querySelector('[data-cofnij-kolejnosc]');
    if (zapiszBtn) zapiszBtn.addEventListener('click', function () {
      if (!formularzListy || !kontenerListy) return;
      formularzListy.querySelectorAll('input[name="kolejnosc[]"]').forEach(function (i) { i.remove(); });
      kontenerListy.querySelectorAll('[data-wiersz]').forEach(function (w) {
        var input = document.createElement('input');
        input.type = 'hidden'; input.name = 'kolejnosc[]'; input.value = w.dataset.indeks;
        formularzListy.appendChild(input);
      });
      formularzListy.submit();
    });
    if (cofnijBtn) cofnijBtn.addEventListener('click', function () { window.location.reload(); });
  }

  /* ---------- Usuwanie: <dialog> zamiast confirm() ---------- */
  document.querySelectorAll('[data-usun-otworz]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var modal = document.getElementById('modal-usun');
      if (!modal) return;
      modal.querySelector('[data-usun-nazwa]').textContent = btn.dataset.usunOtworz;
      modal.querySelector('input[name="poz"]').value = btn.dataset.usunPoz;
      if (modal.showModal) modal.showModal();
    });
  });

  /* ---------- Formularz: podwojny submit, brudny stan, licznik znakow ---------- */
  document.querySelectorAll('form[data-formularz-glowny]').forEach(function (form) {
    var stanPoczatkowy = new FormData(form);
    var brudny = false;
    form.addEventListener('input', function () { brudny = true; });
    form.addEventListener('change', function () { brudny = true; });
    window.addEventListener('beforeunload', function (e) {
      if (!brudny) return;
      e.preventDefault();
      e.returnValue = '';
    });
    form.addEventListener('submit', function () {
      brudny = false;
      var submitBtn = form.querySelector('[data-zapisz-glowny]');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Zapisywanie…';
      }
    });
  });

  document.querySelectorAll('input[data-licznik]').forEach(function (input) {
    var limit = parseInt(input.dataset.licznik, 10);
    var info = document.createElement('span');
    info.className = 'pole-pomoc';
    input.insertAdjacentElement('afterend', info);
    function odswiez() { info.textContent = input.value.length + ' / ' + limit + ' znaków'; }
    input.addEventListener('input', odswiez);
    odswiez();
  });

  /* ---------- Markdown: toolbar wstawiajacy znaczniki + podglad ---------- */
  var REGULY_MD = [
    [/^### (.*)$/gm, '<h3>$1</h3>'],
    [/^## (.*)$/gm, '<h3>$1</h3>'],
  ];
  function cmkPodgladMarkdown(tekst) {
    var esc = tekst.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    var linie = esc.split('\n');
    var html = '';
    var wListe = false;
    var akapit = [];
    function domknijAkapit() {
      if (akapit.length) { html += '<p>' + akapit.join(' ') + '</p>'; akapit = []; }
    }
    linie.forEach(function (linia) {
      var naglowek = linia.match(/^#{2,3}\s+(.*)$/);
      var pozycjaListy = linia.match(/^[-*]\s+(.*)$/);
      if (naglowek) {
        domknijAkapit();
        if (wListe) { html += '</ul>'; wListe = false; }
        html += '<h3>' + naglowek[1] + '</h3>';
      } else if (pozycjaListy) {
        domknijAkapit();
        if (!wListe) { html += '<ul>'; wListe = true; }
        html += '<li>' + pozycjaListy[1] + '</li>';
      } else if (linia.trim() === '') {
        if (wListe) { html += '</ul>'; wListe = false; }
        domknijAkapit();
      } else {
        akapit.push(linia);
      }
    });
    if (wListe) html += '</ul>';
    domknijAkapit();
    html = html.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>').replace(/\*(.+?)\*/g, '<em>$1</em>');
    html = html.replace(/\[([^\]]+)\]\((https?:\/\/[^\s)]+|mailto:[^\s)]+|tel:[^\s)]+)\)/g, '<a href="$2" target="_blank" rel="noopener">$1</a>');
    return html || '<p style="color:var(--text-muted)">Brak treści.</p>';
  }

  document.querySelectorAll('.md-toolbar').forEach(function (toolbar) {
    var klucz = toolbar.dataset.mdDla;
    var pole = document.getElementById(klucz);
    var podglad = document.getElementById(klucz + '-podglad');
    var tabPodglad = toolbar.querySelector('.md-tab-podglad');

    toolbar.querySelectorAll('[data-md]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var akcja = btn.dataset.md;
        var start = pole.selectionStart, koniec = pole.selectionEnd;
        var zaznaczone = pole.value.slice(start, koniec) || 'tekst';
        var wstawka, przesuniecieStart = 0, przesuniecieKoniec = 0;
        if (akcja === 'pogrubienie') { wstawka = '**' + zaznaczone + '**'; przesuniecieStart = 2; }
        else if (akcja === 'kursywa') { wstawka = '*' + zaznaczone + '*'; przesuniecieStart = 1; }
        else if (akcja === 'naglowek') { wstawka = '## ' + zaznaczone; przesuniecieStart = 3; }
        else if (akcja === 'lista') { wstawka = zaznaczone.split('\n').map(function (l) { return '- ' + l; }).join('\n'); }
        else if (akcja === 'link') { wstawka = '[' + zaznaczone + '](https://)'; }
        pole.setRangeText(wstawka, start, koniec, 'end');
        pole.focus();
        pole.selectionStart = start + przesuniecieStart;
        pole.selectionEnd = start + przesuniecieStart + zaznaczone.length;
      });
    });

    if (tabPodglad) {
      tabPodglad.addEventListener('click', function () {
        var pokazujePodglad = !podglad.hidden;
        podglad.hidden = pokazujePodglad;
        pole.hidden = !pokazujePodglad;
        tabPodglad.classList.toggle('aktywny', !pokazujePodglad);
        if (!pokazujePodglad) podglad.innerHTML = cmkPodgladMarkdown(pole.value);
      });
    }
  });

  /* ---------- Wybor specjalizacji: szukajka + chipy + licznik ---------- */
  document.querySelectorAll('.wybor-specjalizacji').forEach(function (wrap) {
    var szukaj = wrap.querySelector('[data-role="szukaj"]');
    var siatka = wrap.querySelector('[data-role="siatka"]');
    var chipy = wrap.querySelector('[data-role="chipy"]');
    var licznik = wrap.querySelector('[data-role="licznik"]');
    var etykiety = siatka.querySelectorAll('label');

    function odswiezChipy() {
      chipy.innerHTML = '';
      var wybraneCheckboxy = siatka.querySelectorAll('input:checked');
      wybraneCheckboxy.forEach(function (cb) {
        var chip = document.createElement('span');
        chip.className = 'chip-usuwalny';
        var etykietaTekst = cb.closest('label').textContent.trim();
        chip.innerHTML = '<span>' + etykietaTekst + '</span>';
        var usunBtn = document.createElement('button');
        usunBtn.type = 'button';
        usunBtn.setAttribute('aria-label', 'Usuń ' + etykietaTekst);
        usunBtn.textContent = '×';
        usunBtn.addEventListener('click', function () { cb.checked = false; odswiezChipy(); });
        chip.appendChild(usunBtn);
        chipy.appendChild(chip);
      });
      licznik.textContent = 'Wybrano ' + wybraneCheckboxy.length + ' z ' + etykiety.length;
    }
    siatka.addEventListener('change', odswiezChipy);
    if (szukaj) szukaj.addEventListener('input', function () {
      var fraza = szukaj.value.trim().toLowerCase();
      etykiety.forEach(function (l) { l.hidden = fraza !== '' && l.dataset.nazwa.indexOf(fraza) === -1; });
    });
    odswiezChipy();
  });

  /* ---------- Picker ikon: szukajka + wybor + podglad ---------- */
  document.querySelectorAll('.ikona-picker').forEach(function (picker) {
    var klucz = picker.dataset.klucz;
    var ukryte = document.getElementById(klucz);
    var podglad = document.querySelector('[data-ikona-podglad="' + klucz + '"]');
    var szukaj = document.querySelector('[data-ikona-szukaj="' + klucz + '"]');

    picker.querySelectorAll('.ikona-item').forEach(function (item) {
      item.addEventListener('click', function () {
        ukryte.value = item.dataset.ikonaWybor;
        picker.querySelectorAll('.ikona-item').forEach(function (i) { i.classList.remove('wybrana'); });
        item.classList.add('wybrana');
        if (podglad) {
          podglad.innerHTML = item.dataset.ikonaWybor
            ? '<img src="' + (item.querySelector('img') ? item.querySelector('img').src : '') + '" alt="" width="40" height="40"><span>' + item.dataset.ikonaWybor + '</span>'
            : '<span class="pole-pomoc" style="margin:0;">Brak wybranej ikony</span>';
        }
      });
    });
    if (szukaj) szukaj.addEventListener('input', function () {
      var fraza = szukaj.value.trim().toLowerCase();
      picker.querySelectorAll('.ikona-item').forEach(function (i) {
        i.hidden = fraza !== '' && i.dataset.nazwa.indexOf(fraza) === -1;
      });
    });
  });

  /* ---------- Dropzone: klik + drag&drop + podglad pliku ---------- */
  document.querySelectorAll('[data-dropzone]').forEach(function (strefa) {
    var input = strefa.querySelector('input[type=file]');
    var podglad = strefa.querySelector('[data-dropzone-podglad]');
    function pokazPodglad(plik) {
      if (!podglad || !plik) return;
      var url = URL.createObjectURL(plik);
      podglad.hidden = false;
      podglad.innerHTML = '<img src="' + url + '" alt=""><span>' + plik.name + ' · ' + Math.round(plik.size / 1024) + ' KB</span>';
    }
    input.addEventListener('change', function () { if (input.files[0]) pokazPodglad(input.files[0]); });
    ['dragover', 'dragleave', 'drop'].forEach(function (typ) {
      strefa.addEventListener(typ, function (e) {
        e.preventDefault();
        strefa.classList.toggle('przeciagane-nad', typ === 'dragover');
      });
    });
    strefa.addEventListener('drop', function (e) {
      if (e.dataTransfer.files.length) { input.files = e.dataTransfer.files; pokazPodglad(e.dataTransfer.files[0]); }
    });
  });

  /* ---------- Galeria aktualnosci: usuwanie kafelka + licznik ---------- */
  document.querySelectorAll('.galeria-lista').forEach(function (lista) {
    var klucz = lista.dataset.klucz;
    var licznikEl = document.querySelector('[data-galeria-licznik="' + klucz + '"]');
    function odswiezLicznik() {
      if (licznikEl) licznikEl.textContent = lista.querySelectorAll('.galeria-item').length + ' z 8 zdjęć';
    }
    lista.addEventListener('click', function (e) {
      var usunBtn = e.target.closest('[data-galeria-usun]');
      if (!usunBtn) return;
      usunBtn.closest('.galeria-item').remove();
      odswiezLicznik();
    });
    odswiezLicznik();
  });

  /* ---------- Guard post_max_size ---------- */
  document.querySelectorAll('form[enctype]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      if (!window.CMK_POST_MAX_BAJTOW) return;
      var suma = 0;
      form.querySelectorAll('input[type=file]').forEach(function (input) {
        for (var i = 0; i < input.files.length; i++) suma += input.files[i].size;
      });
      if (suma > 0 && suma > window.CMK_POST_MAX_BAJTOW - 200 * 1024) {
        e.preventDefault();
        alert('Wybrane zdjęcia są za duże. Limit serwera na jedno przesłanie to ' + Math.round(window.CMK_POST_MAX_BAJTOW / 1024 / 1024) + ' MB. Dodaj mniej zdjęć naraz albo zmniejsz je przed wysłaniem.');
      }
    });
  });

  /* ---------- Cennik: dodawanie/usuwanie/duplikowanie wierszy pozycji ---------- */
  var pozycjeLista = document.getElementById('pozycje-lista');
  var pozycjaDodaj = document.getElementById('pozycja-dodaj');
  if (pozycjeLista && pozycjaDodaj) {
    function podepnijWiersz(wiersz) {
      var usunBtn = wiersz.querySelector('[data-pozycja-usun]');
      usunBtn.addEventListener('click', function () {
        if (pozycjeLista.querySelectorAll('.pozycja-row').length > 1) wiersz.remove();
        else wiersz.querySelectorAll('input').forEach(function (i) { i.value = ''; });
      });
      var duplikujBtn = wiersz.querySelector('[data-pozycja-duplikuj]');
      if (duplikujBtn) duplikujBtn.addEventListener('click', function () {
        var kopia = wiersz.cloneNode(true);
        wiersz.insertAdjacentElement('afterend', kopia);
        podepnijWiersz(kopia);
      });
    }
    pozycjeLista.querySelectorAll('.pozycja-row').forEach(podepnijWiersz);
    pozycjaDodaj.addEventListener('click', function () {
      var wiersz = pozycjeLista.querySelector('.pozycja-row').cloneNode(true);
      wiersz.querySelectorAll('input').forEach(function (i) { i.value = ''; });
      pozycjeLista.appendChild(wiersz);
      podepnijWiersz(wiersz);
      wiersz.querySelector('input').focus();
    });
    podepnijReorder('#pozycje-lista', '.pozycja-row');
  }

  window.CMK_POST_MAX_BAJTOW = window.CMK_POST_MAX_BAJTOW || 0;
})();
