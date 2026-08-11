<?php require_once __DIR__ . '/inc/tresc.php'; $TRESC = cmk_tresc(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>window.TRESC = <?= json_encode($TRESC, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;</script>
<script src="./support.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;500;700;800&display=swap" rel="stylesheet">
<style>
  :root{--font-logo:"Oswald","Segoe UI",system-ui,sans-serif;}
  #intro-reveal{position:fixed;inset:0;z-index:9999;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:18px;background:linear-gradient(120deg,#0e1a3c 0%,#16265c 48%,#1d4ed8 100%);animation:introOverlayOut var(--intro-duration,2s) ease forwards;}
  #intro-reveal .intro-reveal__mark{position:relative;width:120px;height:120px;display:flex;align-items:center;justify-content:center;}
  #intro-reveal .intro-reveal__ring{position:absolute;width:120px;height:120px;border-radius:50%;border:1px solid rgba(255,255,255,.35);opacity:0;transform:scale(.3);animation:introRing .9s cubic-bezier(.16,1,.3,1) .05s forwards;}
  #intro-reveal .intro-reveal__logo{position:relative;width:96px;height:96px;opacity:0;transform:scale(.72);filter:drop-shadow(0 12px 30px rgba(0,0,0,.35));animation:introLogoIn .7s cubic-bezier(.16,1,.3,1) .15s forwards;}
  #intro-reveal .intro-reveal__text{opacity:0;transform:translateY(8px);font-family:var(--font-logo,inherit);font-weight:300;text-transform:uppercase;font-size:26px;line-height:1.15;letter-spacing:.02em;color:#fff;text-align:center;animation:introTextIn .6s ease .5s forwards;}
  @keyframes introLogoIn{0%{opacity:0;transform:scale(.72);}65%{opacity:1;transform:scale(1.08);}100%{opacity:1;transform:scale(1);}}
  @keyframes introRing{0%{opacity:.6;transform:scale(.3);}70%{opacity:0;transform:scale(1.7);}100%{opacity:0;transform:scale(1.7);}}
  @keyframes introTextIn{0%{opacity:0;transform:translateY(8px);}100%{opacity:1;transform:translateY(0);}}
  @keyframes introOverlayOut{0%,62%{opacity:1;visibility:visible;pointer-events:auto;}93%{opacity:0;visibility:visible;pointer-events:none;}100%{opacity:0;visibility:hidden;pointer-events:none;}}
  html.intro-active,html.intro-active body{overflow:hidden;}
  @media (prefers-reduced-motion: reduce){#intro-reveal{display:none !important;}}
</style>
<script>
(function(){
  try{
    var firstRun = !localStorage.getItem('cmkIntroSeenEver');
    if(firstRun) localStorage.setItem('cmkIntroSeenEver','1');
    document.documentElement.style.setProperty('--intro-duration', (2 + (firstRun ? 0.5 : 0)) + 's');
  }catch(e){}
  document.documentElement.classList.add('intro-active');
})();
</script>
</head>
<body>
<div id="intro-reveal" aria-hidden="true">
  <div class="intro-reveal__mark">
    <div class="intro-reveal__ring"></div>
    <img src="uploads/assets-1786096163757-0x49.webp" alt="" class="intro-reveal__logo" width="96" height="96">
  </div>
  <div class="intro-reveal__text">Centrum Medyczne<br><span style="font-weight:200;">Kasprzaka</span></div>
</div>
<script>
(function(){
  var el = document.getElementById('intro-reveal');
  if(!el) return;
  if(!document.documentElement.classList.contains('intro-active')){ el.remove(); return; }
  el.addEventListener('animationend', function(e){
    if(e.target !== el) return;
    document.documentElement.classList.remove('intro-active');
    el.remove();
  });
})();
</script>
<x-dc>
<helmet>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Specjaliści — Centrum Medyczne Kasprzaka, Warszawa Wola</title>
<meta name="description" content="Lekarze przyjmujący w Centrum Medycznym Kasprzaka przy ul. Kasprzaka 31 w Warszawie. Ginekologia, dermatologia, pediatria, kardiologia, USG dzieci i dorosłych.">
<link rel="stylesheet" href="_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/fonts.css">
<link rel="stylesheet" href="_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/colors.css">
<link rel="stylesheet" href="_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/typography.css">
<link rel="stylesheet" href="_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/spacing.css">
<link rel="stylesheet" href="_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/radius.css">
<link rel="stylesheet" href="_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/elevation.css">
<link rel="stylesheet" href="_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/motion.css">
<link rel="stylesheet" href="_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/tokens/base.css">
<link rel="stylesheet" href="_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/styles.css">
<script src="_ds/cm-kasprzaka-design-system-10ef7737-e664-437d-a8ae-74af75e92b43/_ds_bundle.js"></script>
<style>
  body { margin:0; background:var(--white); color:var(--text-body); font-family:var(--font-body); -webkit-font-smoothing:antialiased; }
  a { color:var(--text-link); }
  a:hover { color:var(--text-link-hover); }
  *:focus-visible { outline:3px solid var(--blue-200); outline-offset:2px; }
  @media (prefers-reduced-motion: reduce) { * { animation:none !important; transition:none !important; } }

  .nav-toggle { display:none; align-items:center; justify-content:center; width:42px; height:42px; border-radius:var(--radius-pill); border:1px solid rgba(14,26,60,.14); background:transparent; color:var(--navy-900); cursor:pointer; flex-shrink:0; padding:0; }
  .nav-toggle .icon-close { display:none; }
  .nav-toggle[aria-expanded="true"] .icon-menu { display:none; }
  .nav-toggle[aria-expanded="true"] .icon-close { display:block; }
  .mobile-menu a:hover { background:var(--navy-050); }
  @media (max-width:1120px) {
    .nav-links, .nav-cta { display:none !important; }
    .nav-toggle { display:inline-flex !important; margin-left:auto; }
  }
  @media (min-width:1121px) {
    .mobile-menu { display:none !important; }
  }
  @media (max-width:400px) {
    .brand-text { max-width:120px; font-size:13.5px; }
  }

  @keyframes kalOverlayIn { from { opacity:0; } to { opacity:1; } }
  @keyframes kalCardIn { from { opacity:0; transform:translateY(22px) scale(.95); } to { opacity:1; transform:translateY(0) scale(1); } }
  .kalendarz-overlay { animation:kalOverlayIn .22s ease both; }
  .kalendarz-card { animation:kalCardIn .38s cubic-bezier(.16,1,.3,1) both; }
  @media (prefers-reduced-motion: reduce) {
    .kalendarz-overlay, .kalendarz-card { animation:none; }
  }
</style>
</helmet>

<div lang="pl" style="min-height:100vh; background:var(--white);">

  <header style="position:sticky; top:0; z-index:50;">
    <div style="background:rgba(255,255,255,.98); backdrop-filter:blur(22px) saturate(180%); -webkit-backdrop-filter:blur(22px) saturate(180%); border-bottom:1px solid rgba(14,26,60,.08);">
      <div style="max-width:var(--container-max); margin:0 auto; padding:14px var(--gutter); display:flex; align-items:center; gap:24px;">
        <a href="index.php" style="display:flex; align-items:center; gap:12px; text-decoration:none; color:var(--navy-900);">
          <img src="uploads/assets-1786096163757-0x49.webp" alt="Centrum Medyczne Kasprzaka" width="42" height="42" style="display:block; width:42px; height:42px; flex-shrink:0;">
          <span class="brand-text" style="font-family:var(--font-logo); font-weight:300; text-transform:uppercase; font-size:15px; letter-spacing:var(--tracking-heading); line-height:1.2; max-width:170px;">Centrum Medyczne Kasprzaka</span>
        </a>
        <nav class="nav-links" aria-label="Główna" style="margin-left:auto; display:flex; align-items:center; gap:4px; flex-wrap:wrap;">
          <a href="index.php#specjalizacje" style="padding:9px 16px; border-radius:var(--radius-pill); font-family:var(--font-display); font-size:15px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none; white-space:nowrap; transition:var(--transition-control);" style-hover="background:rgba(255,255,255,.75); box-shadow:inset 0 0 0 1px rgba(14,26,60,.08);">Specjalizacje</a>
          <a href="#lista" aria-current="page" style="padding:9px 16px; border-radius:var(--radius-pill); font-family:var(--font-display); font-size:15px; font-weight:var(--weight-semibold); color:var(--blue-700); background:var(--blue-050); text-decoration:none; white-space:nowrap;">Specjaliści</a>
          <a href="index.php#opinie" style="padding:9px 16px; border-radius:var(--radius-pill); font-family:var(--font-display); font-size:15px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none; white-space:nowrap; transition:var(--transition-control);" style-hover="background:rgba(255,255,255,.75); box-shadow:inset 0 0 0 1px rgba(14,26,60,.08);">Opinie</a>
          <a href="aktualnosci.php" style="padding:9px 16px; border-radius:var(--radius-pill); font-family:var(--font-display); font-size:15px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none; white-space:nowrap; transition:var(--transition-control);" style-hover="background:rgba(255,255,255,.75); box-shadow:inset 0 0 0 1px rgba(14,26,60,.08);">Aktualności</a>
          <a href="index.php#kontakt" style="padding:9px 16px; border-radius:var(--radius-pill); font-family:var(--font-display); font-size:15px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none; white-space:nowrap; transition:var(--transition-control);" style-hover="background:rgba(255,255,255,.75); box-shadow:inset 0 0 0 1px rgba(14,26,60,.08);">Kontakt</a>
        </nav>
        <div class="nav-cta" style="margin-left:auto; display:flex; align-items:center; gap:10px; flex-shrink:0; white-space:nowrap;">
          <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Button" onClick="{{ otworzKalendarz }}" icon="calendar-check" hint-size="auto,46px">Umów wizytę</x-import>
        </div>
        <button type="button" class="nav-toggle" aria-label="Otwórz menu" aria-expanded="{{ menuOtwarte }}" onClick="{{ toggleMenu }}">
          <svg class="icon-menu" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="4" y1="7" x2="20" y2="7"></line><line x1="4" y1="12" x2="20" y2="12"></line><line x1="4" y1="17" x2="20" y2="17"></line></svg>
          <svg class="icon-close" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="6" y1="6" x2="18" y2="18"></line><line x1="18" y1="6" x2="6" y2="18"></line></svg>
        </button>
      </div>
    </div>

    <sc-if value="{{ menuOtwarte }}" hint-placeholder-val="{{ false }}">
      <div class="mobile-menu" style="border-top:1px solid rgba(14,26,60,.08); background:rgba(255,255,255,.98); backdrop-filter: blur(22px) saturate(180%);">
        <div style="max-width:var(--container-max); margin:0 auto; padding:10px var(--gutter) 20px; display:flex; flex-direction:column; gap:2px;">
          <a href="index.php#specjalizacje" onClick="{{ closeMenu }}" style="padding:13px 14px; border-radius:var(--radius-md); font-family:var(--font-display); font-size:16px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none;">Specjalizacje</a>
          <a href="#lista" onClick="{{ closeMenu }}" style="padding:13px 14px; border-radius:var(--radius-md); font-family:var(--font-display); font-size:16px; font-weight:var(--weight-semibold); color:var(--blue-700); background:var(--blue-050); text-decoration:none;">Specjaliści</a>
          <a href="index.php#opinie" onClick="{{ closeMenu }}" style="padding:13px 14px; border-radius:var(--radius-md); font-family:var(--font-display); font-size:16px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none;">Opinie</a>
          <a href="aktualnosci.php" onClick="{{ closeMenu }}" style="padding:13px 14px; border-radius:var(--radius-md); font-family:var(--font-display); font-size:16px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none;">Aktualności</a>
          <a href="index.php#kontakt" onClick="{{ closeMenu }}" style="padding:13px 14px; border-radius:var(--radius-md); font-family:var(--font-display); font-size:16px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none;">Kontakt</a>
          <div style="margin-top:10px;">
            <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Button" onClick="{{ otworzKalendarzZMenu }}" icon="calendar-check" style="width:100%; justify-content:center;" hint-size="100%,46px">Umów wizytę</x-import>
          </div>
        </div>
      </div>
    </sc-if>
  </header>

  <main>

    <section aria-labelledby="tytul" style="background:var(--gradient-hero); color:var(--white);">
      <div style="max-width:var(--container-max); margin:0 auto; padding:56px var(--gutter) 64px;">
        <nav aria-label="Ścieżka" style="display:flex; align-items:center; gap:8px; font-size:14px; color:rgba(255,255,255,.66); margin-bottom:20px;">
          <a href="index.php" style="color:rgba(255,255,255,.82); text-decoration:none;">Strona główna</a>
          <span aria-hidden="true">/</span>
          <span style="color:var(--white);">Specjaliści</span>
        </nav>
        <div style="font-family:var(--font-display); font-size:var(--text-eyebrow); font-weight:var(--weight-bold); letter-spacing:var(--tracking-eyebrow); text-transform:uppercase; color:var(--blue-200); margin-bottom:14px;">Nasz zespół</div>
        <h1 id="tytul" style="margin:0 0 18px; font-family:var(--font-display); font-size:var(--text-display-2); font-weight:var(--weight-extrabold); letter-spacing:var(--tracking-display); line-height:var(--leading-tight); color:var(--white); max-width:720px;">Lekarze przyjmujący</h1>

      </div>
    </section>

    <section id="lista" aria-labelledby="lista-h" style="background:var(--white);">
      <div style="max-width:var(--container-max); margin:0 auto; padding:56px var(--gutter) 96px;">

        <h2 id="lista-h" style="position:absolute; width:1px; height:1px; overflow:hidden; clip:rect(0 0 0 0);">Lista specjalistów</h2>

        <div style="display:flex; align-items:center; gap:14px; flex-wrap:wrap; padding-bottom:28px; border-bottom:1px solid var(--border-subtle);">
          <label for="filtr-specjalizacja" style="font-family:var(--font-display); font-size:14.5px; font-weight:var(--weight-semibold); color:var(--navy-800); white-space:nowrap;">Specjalizacja</label>
          <div style="position:relative; width:100%; max-width:260px;">
            <select id="filtr-specjalizacja" value="{{ filtr }}" onChange="{{ ustawFiltr }}" aria-label="Filtruj według specjalizacji" style="width:100%; height:46px; padding:0 40px 0 18px; border-radius:var(--radius-pill); border:1px solid var(--border-default); background:var(--white); font-family:var(--font-display); font-size:14.5px; font-weight:var(--weight-semibold); color:var(--navy-900); appearance:none; -webkit-appearance:none; cursor:pointer; outline:none; transition:var(--transition-control);" style-focus="border-color:var(--border-focus); box-shadow:0 0 0 3px var(--blue-100);" style-hover="border-color:var(--navy-300);">
              <sc-for list="{{ opcje }}" as="o" hint-placeholder-count="8">
                <option value="{{ o.id }}">{{ o.nazwa }}</option>
              </sc-for>
            </select>
            <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--navy-700)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position:absolute; right:16px; top:50%; transform:translateY(-50%); pointer-events:none;">
              <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
          </div>
        </div>

        <p aria-live="polite" style="margin:22px 0 26px; font-size:15px; color:var(--text-muted);">{{ podpisWyniku }}</p>

        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(272px, 1fr)); gap:18px;">
          <sc-for list="{{ lekarzeWidoczni }}" as="l" hint-placeholder-count="6">
            <article style="height:100%; border-radius:var(--radius-card); overflow:hidden; background:var(--white); border:1px solid var(--border-subtle); box-shadow:var(--shadow-xs); display:flex; flex-direction:column; transition:var(--transition-control);" style-hover="border-color:var(--blue-200); box-shadow:var(--shadow-md);">
              <sc-if value="{{ l.zdjecie }}">
                <div style="height:240px; background:var(--gradient-wash); display:flex; align-items:flex-end; justify-content:center; overflow:hidden; border-bottom:1px solid var(--border-subtle); position:relative;">
                  <img src="{{ l.zdjecie }}" alt="{{ l.imie }}" style="display:block; width:88%; height:auto; margin-bottom:-6%;">
                  <span style="position:absolute; left:14px; top:14px; padding:6px 12px; border-radius:var(--radius-pill); background:rgba(255,255,255,.74); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px); border:1px solid rgba(255,255,255,.9); font-family:var(--font-display); font-size:12.5px; font-weight:var(--weight-semibold); color:var(--navy-900); white-space:nowrap;">{{ l.podtytul }}</span>
                </div>
              </sc-if>
              <sc-if value="{{ !l.zdjecie }}">
                <div style="height:240px; background:var(--gradient-wash); display:grid; place-items:center; border-bottom:1px solid var(--border-subtle); position:relative;">
                  <span style="font-size:13px; line-height:1.5; color:var(--navy-300); text-align:center;">zdjęcie lekarza<br>— do uzupełnienia</span>
                  <span style="position:absolute; left:14px; top:14px; padding:6px 12px; border-radius:var(--radius-pill); background:rgba(255,255,255,.74); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px); border:1px solid rgba(255,255,255,.9); font-family:var(--font-display); font-size:12.5px; font-weight:var(--weight-semibold); color:var(--navy-900); white-space:nowrap;">{{ l.podtytul }}</span>
                </div>
              </sc-if>
              <div style="padding:18px 20px 20px; display:flex; flex-direction:column; gap:10px; flex:1;">
                <h3 style="margin:0; font-family:var(--font-display); font-size:17.5px; font-weight:var(--weight-bold); letter-spacing:var(--tracking-heading); color:var(--navy-900);">{{ l.imie }}</h3>
                <p style="margin:0; font-size:14.5px; line-height:1.55; color:var(--text-muted);">{{ l.zakres }}</p>
                <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-top:auto; padding-top:14px; border-top:1px solid var(--border-subtle);">
                  <span style="font-size:13.5px; color:var(--text-muted);">{{ l.pacjenci }}</span>
                  <button type="button" onClick="{{ l.otworzKalendarzDlaNiego }}" style="background:var(--blue-100); color:var(--blue-700); font-family:var(--font-display); font-weight:var(--weight-semibold); font-size:14px; padding:9px 16px; border-radius:var(--radius-pill); border:none; cursor:pointer; white-space:nowrap; transition:var(--transition-control);" style-hover="background:var(--blue-200);">Umów</button>
                </div>
              </div>
            </article>
          </sc-for>
        </div>

      </div>
    </section>

    <section aria-labelledby="cta-h" style="background:var(--white);">
      <div style="max-width:var(--container-max); margin:0 auto; padding:0 var(--gutter) 96px;">
        <div style="background:var(--gradient-hero); border-radius:28px; color:var(--white); padding:56px 48px; display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:28px;">
          <div style="max-width:600px;">
            <h2 id="cta-h" style="margin:0 0 12px; font-family:var(--font-display); font-size:var(--text-h2); font-weight:var(--weight-extrabold); letter-spacing:var(--tracking-display); line-height:var(--leading-heading); color:var(--white);">Nie wiesz, do kogo się zapisać?</h2>
            <p style="margin:0; font-size:var(--text-body-lg); line-height:var(--leading-body); color:rgba(255,255,255,.78);">Zadzwoń do rejestracji — pomożemy wybrać specjalistę i najbliższy wolny termin.</p>
          </div>
          <div style="display:flex; flex-wrap:wrap; gap:12px; white-space:nowrap;">
            <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Button" as="a" href="tel:+48727500085" size="lg" icon="phone" hint-size="auto,56px">Zadzwoń do rejestracji</x-import>
            <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Button" onClick="{{ otworzKalendarz }}" variant="onDark" size="lg" icon="calendar-check" hint-size="auto,56px">Umów wizytę</x-import>
          </div>
        </div>
      </div>
    </section>

  </main>

  <footer style="background:var(--surface-inverse); color:rgba(255,255,255,.72);">
    <div style="max-width:var(--container-max); margin:0 auto; padding:56px var(--gutter) 28px; display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:40px;">
      <div>
        <img src="uploads/assets-1786096163757-0x49.webp" alt="" width="40" height="40" style="display:block; width:40px; height:40px; margin-bottom:16px;">
        <p style="margin:0; font-size:14.5px; line-height:1.65;">Centrum Medyczne Kasprzaka Sp. z o.o.<br>ul. Marcina Kasprzaka 31 lok. U7, 01-211 Warszawa<br>NIP: 5272935293 · REGON: 387123910</p>
      </div>
      <nav aria-label="Stopka — serwis">
        <div style="font-family:var(--font-display); font-size:var(--text-eyebrow); font-weight:var(--weight-bold); letter-spacing:var(--tracking-eyebrow); text-transform:uppercase; color:var(--white); margin-bottom:16px;">Serwis</div>
        <ul style="margin:0; padding:0; list-style:none; display:flex; flex-direction:column; gap:10px; font-size:14.5px;">
          <li><a href="index.php" style="color:rgba(255,255,255,.72); text-decoration:none;">Strona główna</a></li>
          <li><a href="#lista" style="color:rgba(255,255,255,.72); text-decoration:none;">Specjaliści</a></li>
          <li><a href="index.php#specjalizacje" style="color:rgba(255,255,255,.72); text-decoration:none;">Zakres usług</a></li>
          <li><a href="cennik.php" style="color:rgba(255,255,255,.72); text-decoration:none;">Cennik</a></li>
          <li><a href="aktualnosci.php" style="color:rgba(255,255,255,.72); text-decoration:none;">Aktualności</a></li>
          <li><a href="index.php#kontakt" style="color:rgba(255,255,255,.72); text-decoration:none;">Kontakt</a></li>
        </ul>
      </nav>
      <div>
        <div style="font-family:var(--font-display); font-size:var(--text-eyebrow); font-weight:var(--weight-bold); letter-spacing:var(--tracking-eyebrow); text-transform:uppercase; color:var(--white); margin-bottom:16px;">Rejestracja</div>
        <p style="margin:0 0 8px; font-size:14.5px;"><a href="tel:+48727500085" style="color:var(--white); font-weight:var(--weight-semibold); text-decoration:none;">727 500 085</a></p>
        <p style="margin:0 0 8px; font-size:14.5px;"><a href="mailto:rejestracja@cmkasprzaka.pl" style="color:rgba(255,255,255,.72); text-decoration:none; word-break:break-all;">rejestracja@cmkasprzaka.pl</a></p>
        <p style="margin:0; font-size:14.5px;">pon.–pt. 8:00–20:00, sob. 8:00–14:00</p>
      </div>
    </div>
    <div style="border-top:1px solid rgba(255,255,255,.12);">
      <div style="max-width:var(--container-max); margin:0 auto; padding:18px var(--gutter) 40px; font-size:13.5px;">© 2026 Centrum Medyczne Kasprzaka</div>
    </div>
  </footer>

  <sc-if value="{{ kalendarzOtwarty }}" hint-placeholder-val="{{ false }}">
    <div class="kalendarz-overlay" role="dialog" aria-modal="true" aria-labelledby="kalendarz-h" onClick="{{ zamknijKalendarz }}" style="position:fixed; inset:0; z-index:100; display:flex; align-items:center; justify-content:center; padding:20px; background:rgba(10,19,48,.6); backdrop-filter:blur(10px) saturate(140%); -webkit-backdrop-filter:blur(10px) saturate(140%);">
      <div class="kalendarz-card" onClick="{{ zatrzymaj }}" style="width:100%; max-width:560px; max-height:min(680px, 90vh); display:flex; flex-direction:column; background:var(--white); border-radius:var(--radius-lg); box-shadow:var(--shadow-lg); overflow:hidden; border-top:4px solid #00A99D;">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; padding:20px 24px; border-bottom:1px solid var(--border-subtle);">
          <div style="display:flex; align-items:center; gap:12px;">
            <img src="uploads/znany-lekarz.webp" alt="ZnanyLekarz.pl" style="width:32px; height:32px; border-radius:8px; flex-shrink:0; object-fit:contain;">
            <h2 id="kalendarz-h" style="margin:0; font-family:var(--font-display); font-size:20px; font-weight:var(--weight-extrabold); color:var(--navy-900);">ZnanyLekarz.pl</h2>
          </div>
          <button type="button" onClick="{{ zamknijKalendarz }}" aria-label="Zamknij" style="flex-shrink:0; width:36px; height:36px; border-radius:var(--radius-pill); border:1px solid var(--border-subtle); background:var(--white); color:var(--navy-800); cursor:pointer; display:grid; place-items:center;" style-hover="background:#E6F5F3; color:#00A99D; border-color:#00A99D;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="6" y1="6" x2="18" y2="18"></line><line x1="18" y1="6" x2="6" y2="18"></line></svg>
          </button>
        </div>
        <div style="padding:24px; overflow-y:auto; min-height:320px;">
          <a id="zl-widget-anchor" href="https://www.znanylekarz.pl/placowki/centrum-medyczne-kasprzaka" data-zl-widget-facility="centrum-medyczne-kasprzaka" rel="nofollow" data-placement="inline" data-zlw-type="facility-calendar-listing-with-saas-only">Umów wizytę</a>
        </div>
        <div style="padding:16px 24px 24px; border-top:1px solid var(--border-subtle); display:flex; justify-content:flex-end;">
          <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Button" variant="secondary" onClick="{{ zamknijKalendarz }}" hint-size="auto,46px">Zamknij</x-import>
        </div>
      </div>
    </div>
  </sc-if>

  <sc-if value="{{ widgetLekarzaOtwarty }}" hint-placeholder-val="{{ false }}">
    <div class="kalendarz-overlay" role="dialog" aria-modal="true" aria-labelledby="widget-lekarza-h" onClick="{{ zamknijWidgetLekarza }}" style="position:fixed; inset:0; z-index:100; display:flex; align-items:center; justify-content:center; padding:20px; background:rgba(10,19,48,.6); backdrop-filter:blur(10px) saturate(140%); -webkit-backdrop-filter:blur(10px) saturate(140%);">
      <div class="kalendarz-card" onClick="{{ zatrzymaj }}" style="width:100%; max-width:560px; max-height:min(680px, 90vh); display:flex; flex-direction:column; background:var(--white); border-radius:var(--radius-lg); box-shadow:var(--shadow-lg); overflow:hidden; border-top:4px solid #00A99D;">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; padding:20px 24px; border-bottom:1px solid var(--border-subtle);">
          <div style="display:flex; align-items:center; gap:12px;">
            <img src="uploads/znany-lekarz.webp" alt="ZnanyLekarz.pl" style="width:32px; height:32px; border-radius:8px; flex-shrink:0; object-fit:contain;">
            <h2 id="widget-lekarza-h" style="margin:0; font-family:var(--font-display); font-size:20px; font-weight:var(--weight-extrabold); color:var(--navy-900);">ZnanyLekarz.pl</h2>
          </div>
          <button type="button" onClick="{{ zamknijWidgetLekarza }}" aria-label="Zamknij" style="flex-shrink:0; width:36px; height:36px; border-radius:var(--radius-pill); border:1px solid var(--border-subtle); background:var(--white); color:var(--navy-800); cursor:pointer; display:grid; place-items:center;" style-hover="background:#E6F5F3; color:#00A99D; border-color:#00A99D;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="6" y1="6" x2="18" y2="18"></line><line x1="18" y1="6" x2="6" y2="18"></line></svg>
          </button>
        </div>
        <div id="zl-lekarz-widget-slot" style="padding:24px; overflow-y:auto; min-height:320px;"></div>
        <div style="padding:16px 24px 24px; border-top:1px solid var(--border-subtle); display:flex; justify-content:flex-end;">
          <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Button" variant="secondary" onClick="{{ zamknijWidgetLekarza }}" hint-size="auto,46px">Zamknij</x-import>
        </div>
      </div>
    </div>
  </sc-if>

</div>

</x-dc>
<script type="text/x-dc" data-dc-script data-props="{&quot;domyslnyFiltr&quot;:{&quot;editor&quot;:&quot;enum&quot;,&quot;options&quot;:[&quot;Wszyscy&quot;,&quot;usg&quot;,&quot;pediatria&quot;,&quot;kardiologia&quot;,&quot;dermatologia&quot;,&quot;ginekologia&quot;],&quot;default&quot;:&quot;Wszyscy&quot;,&quot;tsType&quot;:&quot;string&quot;,&quot;section&quot;:&quot;Lista&quot;}}">
// Treść wstrzyknięta przez PHP z data/*.json (patrz inc/tresc.php) — to samo źródło co index.php.
// Lekarz może mieć kilka specjalizacji naraz (l.specjalizacje to tablica id-ków) —
// filtr dopasowuje, gdy aktywne id znajduje się w tej tablicy.
const LEKARZE = window.TRESC.lekarze;
const SPECJALIZACJE = window.TRESC.specjalizacje;

// Skrypty wstawione przez innerHTML sie nie wykonuja (przegladarka to blokuje) - trzeba je
// recznie odtworzyc, zeby wklejony 1:1 z ZnanyLekarz snippet faktycznie zadzialal.
function cmkWstrzyknijWidget(kontener, html) {
  kontener.innerHTML = html;
  kontener.querySelectorAll('script').forEach((stary) => {
    const nowy = document.createElement('script');
    for (const atrybut of stary.attributes) nowy.setAttribute(atrybut.name, atrybut.value);
    nowy.textContent = stary.textContent;
    stary.replaceWith(nowy);
  });
}

class Component extends DCLogic {
  state = { filtr: 'Wszyscy', menuOtwarte: false, kalendarzOtwarty: false, widgetLekarzaOtwarty: false };

  toggleMenu = () => this.setState({ menuOtwarte: !this.state.menuOtwarte });
  closeMenu = () => this.setState({ menuOtwarte: false });

  ustawFiltr = (e) => this.setState({ filtr: e.target.value });

  // Ogolny kalendarz placowki - bez zadnej logiki per-lekarz, dokladnie jak przed
  // wprowadzeniem widgetow dla poszczegolnych lekarzy.
  otworzKalendarz = (e) => {
    if (e && e.preventDefault) e.preventDefault();
    document.body.style.overflow = 'hidden';
    this.setState({ kalendarzOtwarty: true });
    setTimeout(() => {
      if (!document.getElementById('zl-widget-anchor')) return;
      const stary = document.getElementById('zl-facility-widget');
      if (stary) stary.remove();
      const s = document.createElement('script');
      s.id = 'zl-facility-widget';
      s.src = 'https://www.znanylekarz.pl/platform/js/widget.js';
      document.body.appendChild(s);
    }, 0);
  };
  zamknijKalendarz = () => {
    document.body.style.overflow = '';
    this.setState({ kalendarzOtwarty: false });
  };
  // Osobny, calkowicie niezalezny modal na widget lekarza wklejony 1:1 z panelu -
  // zero wspoldzielonych id/atrybutow z modalem ogolnego kalendarza powyzej.
  otworzWidgetLekarza = (e, lekarz) => {
    if (e && e.preventDefault) e.preventDefault();
    document.body.style.overflow = 'hidden';
    this.setState({ widgetLekarzaOtwarty: true });
    setTimeout(() => {
      const kontener = document.getElementById('zl-lekarz-widget-slot');
      if (kontener) cmkWstrzyknijWidget(kontener, lekarz.widgetHtml);
    }, 0);
  };
  zamknijWidgetLekarza = () => {
    document.body.style.overflow = '';
    this.setState({ widgetLekarzaOtwarty: false });
  };
  otworzKalendarzZMenu = (e) => {
    this.closeMenu();
    this.otworzKalendarz(e);
  };
  zatrzymaj = (e) => { if (e && e.stopPropagation) e.stopPropagation(); };

  componentDidMount() {
    this.obslugaKlawiszy = (e) => {
      if (e.key === 'Escape' && this.state.kalendarzOtwarty) this.zamknijKalendarz();
      if (e.key === 'Escape' && this.state.widgetLekarzaOtwarty) this.zamknijWidgetLekarza();
    };
    window.addEventListener('keydown', this.obslugaKlawiszy);

    // Wejście z kafelka specjalizacji na stronie głównej: specjalisci.php?spec=ginekologia.
    // support.js nie mapuje query stringa na propsy, więc czytamy go tutaj. Nieznane id = brak filtra.
    const zUrl = new URLSearchParams(location.search).get('spec');
    if (zUrl && SPECJALIZACJE.some(s => s.id === zUrl)) this.setState({ filtr: zUrl });
  }
  componentWillUnmount() {
    window.removeEventListener('keydown', this.obslugaKlawiszy);
    document.body.style.overflow = '';
  }

  renderVals() {
    const aktywny = this.props.domyslnyFiltr && this.state.filtr === 'Wszyscy'
      ? this.props.domyslnyFiltr
      : this.state.filtr;

    // sc-for iteruje bezpośrednio po przefiltrowanej liście — bez sprzężenia po indeksie
    // (dawny błąd: przestawienie kolejności lekarzy cicho psuło filtrowanie ukryty1..6).
    // Lekarz może wykonywać kilka specjalizacji naraz, stąd includes() zamiast ===.
    const lekarzeWidoczni = LEKARZE
      .filter(l => aktywny === 'Wszyscy' || (l.specjalizacje || []).includes(aktywny))
      .map(l => ({
        ...l,
        otworzKalendarzDlaNiego: l.widgetHtml ? (e) => this.otworzWidgetLekarza(e, l) : this.otworzKalendarz
      }));

    // Lista specjalizacji jest długa (20+ pozycji) — zamiast ściany przycisków-filtrów
    // jeden dropdown, alfabetycznie, żeby łatwo znaleźć pozycję po nazwie.
    const uzywaneId = new Set();
    LEKARZE.forEach(l => (l.specjalizacje || []).forEach(id => uzywaneId.add(id)));
    const uzywane = SPECJALIZACJE
      .filter(s => uzywaneId.has(s.id))
      .slice()
      .sort((a, b) => a.nazwa.localeCompare(b.nazwa, 'pl'));

    const aktywnaNazwa = aktywny === 'Wszyscy' ? 'Wszyscy' : (uzywane.find(s => s.id === aktywny) || {}).nazwa || aktywny;
    const opcje = [{ id: 'Wszyscy', nazwa: 'Wszyscy' }].concat(uzywane);

    const n = lekarzeWidoczni.length;
    const podpisWyniku = aktywny === 'Wszyscy'
      ? n + (n === 1 ? ' specjalista' : ' specjalistów') + ' przyjmuje na Kasprzaka'
      : n + (n === 1 ? ' specjalista' : ' specjalistów') + ' — ' + aktywnaNazwa;

    return {
      lekarzeWidoczni, opcje, filtr: aktywny, ustawFiltr: this.ustawFiltr, podpisWyniku,
      menuOtwarte: this.state.menuOtwarte, toggleMenu: this.toggleMenu, closeMenu: this.closeMenu,
      kalendarzOtwarty: this.state.kalendarzOtwarty,
      otworzKalendarz: this.otworzKalendarz,
      otworzKalendarzZMenu: this.otworzKalendarzZMenu,
      zamknijKalendarz: this.zamknijKalendarz,
      widgetLekarzaOtwarty: this.state.widgetLekarzaOtwarty,
      zamknijWidgetLekarza: this.zamknijWidgetLekarza,
      zatrzymaj: this.zatrzymaj
    };
  }
}
</script>
</body>
</html>
