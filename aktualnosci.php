<?php require_once __DIR__ . '/inc/tresc.php'; $TRESC = cmk_tresc(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>window.TRESC = <?= json_encode($TRESC, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;</script>
<script src="./support.js"></script>
<style>
  #intro-reveal{position:fixed;inset:0;z-index:9999;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:18px;background:linear-gradient(120deg,#0e1a3c 0%,#16265c 48%,#1d4ed8 100%);animation:introOverlayOut var(--intro-duration,2s) ease forwards;}
  #intro-reveal .intro-reveal__mark{position:relative;width:120px;height:120px;display:flex;align-items:center;justify-content:center;}
  #intro-reveal .intro-reveal__ring{position:absolute;width:120px;height:120px;border-radius:50%;border:1px solid rgba(255,255,255,.35);opacity:0;transform:scale(.3);animation:introRing .9s cubic-bezier(.16,1,.3,1) .05s forwards;}
  #intro-reveal .intro-reveal__logo{position:relative;width:96px;height:96px;opacity:0;transform:scale(.72);filter:drop-shadow(0 12px 30px rgba(0,0,0,.35));animation:introLogoIn .7s cubic-bezier(.16,1,.3,1) .15s forwards;}
  #intro-reveal .intro-reveal__text{opacity:0;transform:translateY(8px);font-family:var(--font-display,inherit);font-weight:var(--weight-extrabold,800);font-size:18px;letter-spacing:.02em;color:#fff;text-align:center;animation:introTextIn .6s ease .5s forwards;}
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
  <div class="intro-reveal__text">Centrum Medyczne Kasprzaka</div>
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
<title>Aktualności — Centrum Medyczne Kasprzaka, Warszawa Wola</title>
<meta name="description" content="Aktualności i ogłoszenia Centrum Medycznego Kasprzaka przy ul. Kasprzaka 31 w Warszawie.">
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
  @media (max-width:1000px) {
    .nav-links, .nav-cta { display:none !important; }
    .nav-toggle { display:inline-flex !important; margin-left:auto; }
  }
  @media (min-width:1001px) {
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
    <div style="background:rgba(255,255,255,.68); backdrop-filter:blur(22px) saturate(180%); -webkit-backdrop-filter:blur(22px) saturate(180%); border-bottom:1px solid rgba(14,26,60,.08);">
      <div style="max-width:var(--container-max); margin:0 auto; padding:14px var(--gutter); display:flex; align-items:center; gap:24px;">
        <a href="index.php" style="display:flex; align-items:center; gap:12px; text-decoration:none; color:var(--navy-900);">
          <img src="uploads/assets-1786096163757-0x49.webp" alt="Centrum Medyczne Kasprzaka" width="42" height="42" style="display:block; width:42px; height:42px; flex-shrink:0;">
          <span class="brand-text" style="font-family:var(--font-display); font-weight:var(--weight-extrabold); font-size:15px; letter-spacing:var(--tracking-heading); line-height:1.2; max-width:170px;">Centrum Medyczne Kasprzaka</span>
        </a>
        <nav class="nav-links" aria-label="Główna" style="margin-left:auto; display:flex; align-items:center; gap:4px; flex-wrap:wrap;">
          <a href="index.php#specjalizacje" style="padding:9px 16px; border-radius:var(--radius-pill); font-family:var(--font-display); font-size:15px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none; white-space:nowrap; transition:var(--transition-control);" style-hover="background:rgba(255,255,255,.75); box-shadow:inset 0 0 0 1px rgba(14,26,60,.08);">Specjalizacje</a>
          <a href="specjalisci.php" style="padding:9px 16px; border-radius:var(--radius-pill); font-family:var(--font-display); font-size:15px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none; white-space:nowrap; transition:var(--transition-control);" style-hover="background:rgba(255,255,255,.75); box-shadow:inset 0 0 0 1px rgba(14,26,60,.08);">Specjaliści</a>
          <a href="index.php#opinie" style="padding:9px 16px; border-radius:var(--radius-pill); font-family:var(--font-display); font-size:15px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none; white-space:nowrap; transition:var(--transition-control);" style-hover="background:rgba(255,255,255,.75); box-shadow:inset 0 0 0 1px rgba(14,26,60,.08);">Opinie</a>
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
          <a href="specjalisci.php" onClick="{{ closeMenu }}" style="padding:13px 14px; border-radius:var(--radius-md); font-family:var(--font-display); font-size:16px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none;">Specjaliści</a>
          <a href="index.php#opinie" onClick="{{ closeMenu }}" style="padding:13px 14px; border-radius:var(--radius-md); font-family:var(--font-display); font-size:16px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none;">Opinie</a>
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
          <sc-if value="{{ wpis }}">
            <a href="aktualnosci.php" style="color:rgba(255,255,255,.82); text-decoration:none;">Aktualności</a>
            <span aria-hidden="true">/</span>
            <span style="color:var(--white);">{{ wpis.tytul }}</span>
          </sc-if>
          <sc-if value="{{ !wpis }}">
            <span style="color:var(--white);">Aktualności</span>
          </sc-if>
        </nav>
        <div style="font-family:var(--font-display); font-size:var(--text-eyebrow); font-weight:var(--weight-bold); letter-spacing:var(--tracking-eyebrow); text-transform:uppercase; color:var(--blue-200); margin-bottom:14px;">Co u nas słychać</div>
        <sc-if value="{{ wpis }}">
          <h1 id="tytul" style="margin:0 0 18px; font-family:var(--font-display); font-size:var(--text-display-2); font-weight:var(--weight-extrabold); letter-spacing:var(--tracking-display); line-height:var(--leading-tight); color:var(--white); max-width:720px;">{{ wpis.tytul }}</h1>
        </sc-if>
        <sc-if value="{{ !wpis }}">
          <h1 id="tytul" style="margin:0 0 18px; font-family:var(--font-display); font-size:var(--text-display-2); font-weight:var(--weight-extrabold); letter-spacing:var(--tracking-display); line-height:var(--leading-tight); color:var(--white); max-width:720px;">Aktualności</h1>
        </sc-if>
      </div>
    </section>

    <sc-if value="{{ wpis }}">
      <section aria-labelledby="wpis-h" style="background:var(--white);">
        <div style="max-width:720px; margin:0 auto; padding:56px var(--gutter) 96px;">
          <h2 id="wpis-h" style="position:absolute; width:1px; height:1px; overflow:hidden; clip:rect(0 0 0 0);">{{ wpis.tytul }}</h2>
          <sc-if value="{{ wpis.zdjecie }}">
            <img src="{{ wpis.zdjecie }}" alt="" style="display:block; width:100%; max-height:420px; object-fit:cover; border-radius:var(--radius-card); margin-bottom:28px;">
          </sc-if>
          <p style="margin:0 0 28px; font-size:14px; color:var(--text-muted);">{{ wpisData }}</p>
          <div style="display:flex; flex-direction:column; gap:16px;">
            <sc-for list="{{ wpisAkapity }}" as="akapit" hint-placeholder-count="2">
              <p style="margin:0; font-size:var(--text-body); line-height:var(--leading-body); color:var(--navy-800);">{{ akapit }}</p>
            </sc-for>
          </div>
          <div style="margin-top:40px;">
            <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Button" as="a" href="aktualnosci.php" variant="secondary" icon="chevron-left" hint-size="auto,46px">Wszystkie aktualności</x-import>
          </div>
        </div>
      </section>
    </sc-if>

    <sc-if value="{{ !wpis }}">
      <section aria-labelledby="lista-h" style="background:var(--white);">
        <div style="max-width:800px; margin:0 auto; padding:56px var(--gutter) 96px;">
          <h2 id="lista-h" style="position:absolute; width:1px; height:1px; overflow:hidden; clip:rect(0 0 0 0);">Lista aktualności</h2>
          <sc-if value="{{ brakAktualnosci }}">
            <p style="margin:0; font-size:var(--text-body); color:var(--text-muted);">Na razie nie mamy żadnych ogłoszeń — zaglądaj tu od czasu do czasu.</p>
          </sc-if>
          <sc-if value="{{ !brakAktualnosci }}">
            <div style="display:flex; flex-direction:column; gap:18px;">
              <sc-for list="{{ aktualnosci }}" as="a" hint-placeholder-count="3">
                <a href="{{ a.href }}" style="text-decoration:none; display:block;">
                  <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Card" interactive="{{ true }}">
                    <div style="display:flex; gap:18px; align-items:flex-start;">
                      <sc-if value="{{ a.zdjecie }}">
                        <img src="{{ a.zdjecie }}" alt="" style="display:block; width:96px; height:96px; object-fit:cover; border-radius:var(--radius-md); flex-shrink:0;">
                      </sc-if>
                      <div style="min-width:0;">
                        <p style="margin:0 0 8px; font-size:13px; color:var(--text-muted);">{{ a.dataOpis }}</p>
                        <h3 style="margin:0 0 8px; font-family:var(--font-display); font-size:19px; font-weight:var(--weight-bold); color:var(--navy-900);">{{ a.tytul }}</h3>
                        <p style="margin:0; font-size:14.5px; line-height:1.6; color:var(--text-muted);">{{ a.zajawka }}</p>
                      </div>
                    </div>
                  </x-import>
                </a>
              </sc-for>
            </div>
          </sc-if>
        </div>
      </section>
    </sc-if>

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
          <li><a href="specjalisci.php" style="color:rgba(255,255,255,.72); text-decoration:none;">Specjaliści</a></li>
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

</div>

</x-dc>
<script type="text/x-dc" data-dc-script>
// Treść wstrzyknięta przez PHP z data/aktualnosci.json (patrz inc/tresc.php).
const AKTUALNOSCI = window.TRESC.aktualnosci;
const MIESIACE = ['stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia'];

function formatujDate(iso) {
  const [rok, miesiac, dzien] = iso.split('-').map(Number);
  return Number(dzien) + ' ' + MIESIACE[miesiac - 1] + ' ' + rok;
}

class Component extends DCLogic {
  state = { menuOtwarte: false, kalendarzOtwarty: false };

  toggleMenu = () => this.setState({ menuOtwarte: !this.state.menuOtwarte });
  closeMenu = () => this.setState({ menuOtwarte: false });

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
  otworzKalendarzZMenu = (e) => {
    this.closeMenu();
    this.otworzKalendarz(e);
  };
  zatrzymaj = (e) => { if (e && e.stopPropagation) e.stopPropagation(); };

  componentDidMount() {
    this.obslugaKlawiszy = (e) => {
      if (e.key === 'Escape' && this.state.kalendarzOtwarty) this.zamknijKalendarz();
    };
    window.addEventListener('keydown', this.obslugaKlawiszy);
  }
  componentWillUnmount() {
    window.removeEventListener('keydown', this.obslugaKlawiszy);
    document.body.style.overflow = '';
  }

  renderVals() {
    const idZUrl = new URLSearchParams(location.search).get('post');
    const wpisZrodlo = idZUrl ? AKTUALNOSCI.find(a => a.id === idZUrl) : null;

    const wspolne = {
      menuOtwarte: this.state.menuOtwarte, toggleMenu: this.toggleMenu, closeMenu: this.closeMenu,
      kalendarzOtwarty: this.state.kalendarzOtwarty,
      otworzKalendarz: this.otworzKalendarz,
      otworzKalendarzZMenu: this.otworzKalendarzZMenu,
      zamknijKalendarz: this.zamknijKalendarz,
      zatrzymaj: this.zatrzymaj
    };

    if (wpisZrodlo) {
      return {
        ...wspolne,
        wpis: wpisZrodlo,
        wpisData: formatujDate(wpisZrodlo.data),
        wpisAkapity: wpisZrodlo.tresc.split('\n\n')
      };
    }

    const aktualnosci = AKTUALNOSCI
      .slice()
      .sort((a, b) => a.data < b.data ? 1 : -1)
      .map(a => ({
        ...a,
        href: 'aktualnosci.php?post=' + encodeURIComponent(a.id),
        dataOpis: formatujDate(a.data),
        zajawka: a.tresc.split('\n\n')[0]
      }));

    return {
      ...wspolne,
      wpis: null,
      aktualnosci,
      brakAktualnosci: aktualnosci.length === 0
    };
  }
}
</script>
</body>
</html>
