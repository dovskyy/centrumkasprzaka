<?php require_once __DIR__ . '/inc/tresc.php'; require_once __DIR__ . '/inc/ikony.php'; $TRESC = cmk_tresc(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>window.TRESC = <?= json_encode($TRESC, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;</script>
<script src="./support.js"></script>
<style>
  #intro-reveal{position:fixed;inset:0;z-index:9999;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:18px;background:linear-gradient(120deg,#0e1a3c 0%,#16265c 48%,#1d4ed8 100%);animation:introOverlayOut var(--intro-duration,3s) ease forwards;}
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
    document.documentElement.style.setProperty("--intro-duration", (3 + (firstRun ? 0.5 : 0)) + "s");
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
<title>Centrum Medyczne Kasprzaka — prywatna przychodnia na Woli, Warszawa</title>
<meta name="description" content="Prywatna przychodnia przy ul. Kasprzaka 31 na warszawskiej Woli. Ginekologia, dermatologia, pediatria, kardiologia, USG. Wizyty umawiane online.">
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

  .spec-header-wrap {
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:24px;
    margin-bottom:32px;
  }
  .spec-slider-controls {
    display:flex;
    align-items:center;
    gap:10px;
    flex-shrink:0;
    margin-bottom:8px;
  }
  .spec-swipe-indicator { display:none; }
  @media (max-width:760px) {
    .spec-header-wrap { flex-direction:column; align-items:flex-start; gap:16px; margin-bottom:12px; }
    .spec-slider-controls { display:none !important; }
    .spec-swipe-indicator { display:flex; font-size:13px; color:var(--text-muted); align-items:center; justify-content:center; gap:6px; margin:-4px 0 16px; }
  }
  .spec-slider-btn {
    width:44px;
    height:44px;
    border-radius:var(--radius-pill);
    border:1px solid rgba(14,26,60,.14);
    background:var(--white);
    color:var(--navy-900);
    display:grid;
    place-items:center;
    cursor:pointer;
    transition:all .35s cubic-bezier(.16,1,.3,1);
    box-shadow:0 2px 6px rgba(14,26,60,.04);
  }
  .spec-slider-btn:hover {
    background:var(--blue-600);
    color:var(--white);
    border-color:var(--blue-600);
    transform:translateY(-2px);
    box-shadow:0 6px 16px rgba(15,98,208,.22);
  }
  .spec-slider-btn:active { transform:scale(.96); }

  .spec-grid { 
    display:flex; 
    gap:18px; 
    overflow-x:auto; 
    scroll-snap-type:x mandatory; 
    scroll-behavior:smooth; 
    -webkit-overflow-scrolling:touch; 
    padding:6px 4px 20px; 
    margin-top:0; 
    scrollbar-width:none; 
  }
  .spec-grid::-webkit-scrollbar { display:none; }

  .spec-card { 
    flex:0 0 310px; 
    scroll-snap-align:start; 
    position:relative; 
    display:flex; 
    flex-direction:column; 
    justify-content:space-between; 
    gap:20px; 
    padding:24px 24px 22px; 
    border-radius:var(--radius-card); 
    text-decoration:none !important; 
    background:linear-gradient(135deg, #EBF3FD 0%, #E0EEFD 100%); 
    border:1px solid #B6D4F9; 
    box-shadow:0 4px 14px -2px rgba(15,98,208,.08); 
    transition:all .35s cubic-bezier(.16,1,.3,1); 
    overflow:hidden; 
  }

  .spec-card::before {
    content:'';
    position:absolute;
    top:0;
    left:0;
    right:0;
    height:4px;
    background:linear-gradient(90deg, var(--blue-600), var(--teal-500));
    opacity:1;
    transition:opacity .35s ease;
  }

  .spec-card:hover { 
    text-decoration:none !important; 
    transform:translateY(-4px); 
    background:linear-gradient(135deg, #DEEBFD 0%, #D3E5FC 100%); 
    border-color:var(--blue-500); 
    box-shadow:0 14px 28px -6px rgba(15,98,208,.18); 
  }

  /* Static Background Watermark Icon - NO ANIMATIONS */
  .spec-card__bg-icon {
    position:absolute;
    right:-18px;
    bottom:-22px;
    width:140px;
    height:140px;
    color:var(--blue-600);
    opacity:0.14;
    filter:none;
    pointer-events:none;
    transform:rotate(-6deg);
    z-index:0;
  }

  .spec-card__header { display:flex; align-items:center; justify-content:space-between; width:100%; position:relative; z-index:1; }
  
  .spec-card__icon { 
    width:56px; 
    height:56px; 
    border-radius:16px; 
    display:grid; 
    place-items:center; 
    background:var(--white); 
    color:var(--blue-600); 
    border:1px solid rgba(27,118,238,.22); 
    box-shadow:0 3px 10px rgba(15,98,208,.12); 
    transition:all .35s cubic-bezier(.16,1,.3,1); 
  }
  .spec-card:hover .spec-card__icon { 
    background:var(--blue-600); 
    color:var(--white); 
    border-color:var(--blue-600); 
    transform:scale(1.05); 
    box-shadow:0 6px 16px rgba(15,98,208,.25); 
  }

  .spec-card__action { 
    width:34px; 
    height:34px; 
    border-radius:50%; 
    display:grid; 
    place-items:center; 
    background:var(--white); 
    color:var(--blue-600); 
    border:1px solid rgba(27,118,238,.2); 
    box-shadow:0 2px 6px rgba(15,98,208,.08); 
    transition:all .35s cubic-bezier(.16,1,.3,1); 
  }
  .spec-card:hover .spec-card__action { 
    background:var(--blue-600); 
    color:var(--white); 
    border-color:var(--blue-600); 
    transform:translateX(4px); 
  }

  .spec-card__body { display:flex; flex-direction:column; gap:6px; position:relative; z-index:1; }
  .spec-card__title { 
    font-family:var(--font-display); 
    font-size:22.5px; 
    line-height:1.25; 
    font-weight:var(--weight-bold); 
    letter-spacing:-0.018em; 
    color:var(--navy-900); 
    transition:color .25s ease; 
  }
  .spec-card:hover .spec-card__title { color:var(--blue-700); }
  .spec-card__desc { font-size:14px; line-height:1.5; color:var(--navy-800); opacity:.82; }

  .spec-card--more { 
    background:linear-gradient(135deg, var(--navy-900) 0%, var(--navy-800) 100%); 
    border:1px solid var(--navy-700); 
  }
  .spec-card--more .spec-card__bg-icon { color:var(--white); opacity:0.1; }
  .spec-card--more .spec-card__title { color:var(--white); }
  .spec-card--more .spec-card__desc { color:rgba(255,255,255,.8); opacity:1; }
  .spec-card--more .spec-card__icon { 
    background:rgba(255,255,255,.1); 
    color:var(--white); 
    border-color:rgba(255,255,255,.15); 
    box-shadow:none; 
  }
  .spec-card--more:hover .spec-card__icon { background:var(--blue-600); color:var(--white); }
  .spec-card--more .spec-card__action { background:rgba(255,255,255,.08); color:rgba(255,255,255,.8); border-color:transparent; }
  .spec-card--more:hover .spec-card__action { background:var(--white); color:var(--navy-900); }

  .visit-photo-wrap { min-height:420px; }
  .visit-photo { height:480px; }
  @media (max-width:760px) {
    .visit-photo-wrap { min-height:0; }
    .visit-photo { height:280px; }
  }

  .hero-phone-btn { flex-shrink:0; }
  @media (max-width:760px) {
    .hero-copy { padding-bottom:48px !important; }
    .hero-phone-btn { width:56px !important; padding:0 !important; }
    .hero-phone-label { display:none; }
  }

  /* Umów wizytę — na hover ikonka kalendarza "przeobraża się" w logo ZnanyLekarz,
     a guzik z niebieskiego przechodzi na biały. */
  .cta-book-btn { transition:background .35s ease, border-color .35s ease, color .35s ease; }
  .cta-book-btn:hover, .cta-book-btn:focus-visible {
    background:var(--white) !important;
    color:var(--success-600) !important;
    border-color:var(--border-default) !important;
    outline:none !important;
  }
  .cta-book-btn span[aria-hidden="true"] {
    transition:transform .12s ease-in, opacity .12s ease-in;
  }
  .cta-book-btn:hover span[aria-hidden="true"], .cta-book-btn:focus-visible span[aria-hidden="true"] {
    transform:scale(.3) rotate(-25deg);
    opacity:0;
  }
  .cta-book-btn:hover span[aria-hidden="true"], .cta-book-btn:focus-visible span[aria-hidden="true"] {
    -webkit-mask-image:none !important;
    mask-image:none !important;
    background-color:transparent !important;
    background-image:url('uploads/znany-lekarz2.webp') !important;
    background-size:contain !important;
    background-position:center !important;
    background-repeat:no-repeat !important;
    image-rendering:auto;
    animation:ctaIconIn .3s cubic-bezier(.34,1.56,.64,1) .12s forwards;
  }
  @keyframes ctaIconIn { 0% { transform:scale(.3) rotate(20deg); opacity:0; } 70% { transform:scale(1.15) rotate(0); opacity:1; } 100% { transform:scale(1) rotate(0); opacity:1; } }

  /* Złoto gwiazdki oceny. Wspólne dla obu platform — gwiazdka znaczy "ocena", platformę identyfikuje jej własny znak.
     Nie trafia do tokenów DS, bo to konwencja serwisów z opiniami, a nie kolor marki CMK. */
  :root { --star-rating:#F5B400; }
  .u-sr-only { position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0 0 0 0); white-space:nowrap; border:0; }
  .u-num { font-variant-numeric:tabular-nums; }

  /* Pasek ocen — wariant "glass" wzorca StatBar z design systemu, wyniesiony między hero a specjalizacje. */
  .hero-proof { max-width:560px; display:grid; grid-template-columns:repeat(3, 1fr); gap:8px; padding:18px 22px; border-radius:var(--radius-lg); background:var(--glass-bg); border:var(--glass-border); backdrop-filter:var(--glass-blur); -webkit-backdrop-filter:var(--glass-blur); }
  .hero-proof-bridge { max-width:900px; margin:-24px auto 0; padding:0 var(--gutter); position:relative; z-index:5; }
  .hero-proof--bridge { max-width:none; margin:0 auto; background:rgba(255,255,255,.85); border:1px solid rgba(14,26,60,.12); box-shadow:var(--shadow-sm); backdrop-filter:blur(16px) saturate(180%); -webkit-backdrop-filter:blur(16px) saturate(180%); }
  .hero-proof--bridge .hero-proof__item, .hero-proof--bridge a.hero-proof__item:hover, .hero-proof--bridge .hero-proof__value { color:var(--navy-900); }
  .hero-proof--bridge .hero-proof__label { color:var(--navy-700); }
  .hero-proof--bridge .hero-proof__item + .hero-proof__item { border-left-color: rgba(14,26,60,.12); }
  @media (max-width:520px) {
    .hero-proof-bridge { margin-top:-16px; }
  }
  .hero-proof__item { display:flex; flex-direction:column; justify-content:center; gap:5px; min-height:46px; text-decoration:none; color:var(--white); border-radius:var(--radius-xs); transition:var(--transition-control); }
  .hero-proof__item + .hero-proof__item { padding-left:20px; border-left:1px solid rgba(255,255,255,.22); }
  a.hero-proof__item:hover { color:var(--white); text-decoration:none; }
  a.hero-proof__item:hover .hero-proof__value { text-decoration:underline; text-underline-offset:3px; }
  .hero-proof__value { display:flex; align-items:center; gap:7px; font-family:var(--font-display); font-size:22px; font-weight:var(--weight-extrabold); letter-spacing:var(--tracking-display); line-height:1; color:var(--white); }
  .hero-proof__label { display:flex; align-items:center; gap:6px; font-size:13px; line-height:1.3; color:rgba(255,255,255,.72); }
  @media (max-width:520px) {
    .hero-proof { grid-template-columns:1fr 1fr; gap:12px; padding:16px 18px; }
    .hero-proof__item + .hero-proof__item { padding-left:14px; }
    .hero-proof__item:nth-child(3) { grid-column:1 / -1; padding-left:0; padding-top:12px; border-left:none; border-top:1px solid rgba(255,255,255,.22); }
    .hero-proof--bridge .hero-proof__item:nth-child(3) { border-top-color: rgba(14,26,60,.12); }
  }

  /* Sekcja opinii */
  .opinie-head { display:flex; flex-wrap:wrap; align-items:flex-end; justify-content:space-between; gap:24px; }
  .opinie-oceny { display:flex; flex-wrap:wrap; gap:10px; }
  .ocena-pigulka { display:flex; align-items:center; gap:10px; min-height:46px; padding:10px 16px; border-radius:var(--radius-pill); background:var(--white); border:1px solid var(--border-subtle); box-shadow:var(--shadow-xs); text-decoration:none; color:var(--navy-900); transition:var(--transition-control); }
  .ocena-pigulka:hover { color:var(--navy-900); text-decoration:none; border-color:var(--blue-200); box-shadow:var(--shadow-sm); }
  @media (max-width:520px) { .mobile-hide-google-text { display:none !important; } }

  .reviews-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:24px; width:100%; text-align:left; }
  .swipe-indicator { display:none; }
  @media (max-width:960px) {
    .reviews-grid { display:flex; overflow-x:auto; scroll-snap-type:x mandatory; padding-bottom:16px; -webkit-overflow-scrolling:touch; gap:16px; scroll-padding:0; margin:0; padding-left:0; padding-right:0; width:100%; align-self:stretch; }
    .reviews-grid::-webkit-scrollbar { height:4px; }
    .reviews-grid::-webkit-scrollbar-track { background:rgba(14,26,60,.05); border-radius:10px; }
    .reviews-grid::-webkit-scrollbar-thumb { background:rgba(14,26,60,.15); border-radius:10px; }
    .reviews-grid > div { flex:0 0 90%; scroll-snap-align:center; min-width:240px; }
    .swipe-indicator { display:flex; font-size:13px; color:var(--text-muted); align-items:center; justify-content:center; gap:6px; margin-bottom:-16px; }
  }
  /* Karta mapy — podgląd do kliknięcia, iframe dociąga się dopiero na żądanie */
  .mapa-karta { position:relative; height:340px; border-radius:var(--radius-photo); overflow:hidden; border:1px solid var(--border-subtle); background:var(--navy-050); }
  .mapa-karta iframe { display:block; width:100%; height:100%; border:0; }
  @media (max-width:560px) {
    .mapa-karta { height:400px; }
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

    <div style="backdrop-filter: blur(22px) saturate(180%); -webkit-backdrop-filter: blur(22px) saturate(180%); border-bottom: 1px solid rgba(14,26,60,.08)">
      <div style="max-width:var(--container-max); margin:0 auto; padding:14px var(--gutter); display:flex; align-items:center; gap:24px;">
        <a href="#" style="display:flex; align-items:center; gap:12px; text-decoration:none; color:var(--navy-900);">
          <img src="uploads/assets-1786096163757-0x49.webp" alt="Centrum Medyczne Kasprzaka" width="42" height="42" style="display:block; width:42px; height:42px; flex-shrink:0;">
          <span class="brand-text" style="font-family:var(--font-display); font-weight:var(--weight-extrabold); font-size:15px; letter-spacing:var(--tracking-heading); line-height:1.2; max-width:170px;">Centrum Medyczne Kasprzaka</span>
        </a>
        <nav class="nav-links" aria-label="Główna" style="margin-left:auto; display:flex; align-items:center; gap:4px; flex-wrap:wrap;">
          <a href="#specjalizacje" style="padding:9px 16px; border-radius:var(--radius-pill); font-family:var(--font-display); font-size:15px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none; white-space:nowrap; transition:var(--transition-control);" style-hover="background:rgba(255,255,255,.75); box-shadow:inset 0 0 0 1px rgba(14,26,60,.08);">Specjalizacje</a>
          <a href="#zespol" style="padding:9px 16px; border-radius:var(--radius-pill); font-family:var(--font-display); font-size:15px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none; white-space:nowrap; transition:var(--transition-control);" style-hover="background:rgba(255,255,255,.75); box-shadow:inset 0 0 0 1px rgba(14,26,60,.08);">Specjaliści</a>
          <a href="#opinie" style="padding:9px 16px; border-radius:var(--radius-pill); font-family:var(--font-display); font-size:15px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none; white-space:nowrap; transition:var(--transition-control);" style-hover="background:rgba(255,255,255,.75); box-shadow:inset 0 0 0 1px rgba(14,26,60,.08);">Opinie</a>
          <a href="#kontakt" style="padding:9px 16px; border-radius:var(--radius-pill); font-family:var(--font-display); font-size:15px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none; white-space:nowrap; transition:var(--transition-control);" style-hover="background:rgba(255,255,255,.75); box-shadow:inset 0 0 0 1px rgba(14,26,60,.08);">Kontakt</a>
        </nav>
        <div class="nav-cta" style="margin-left:auto; display:flex; align-items:center; gap:10px; flex-shrink:0; white-space:nowrap;">
          <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Button" class="cta-book-btn" onClick="{{ otworzKalendarz }}" icon="calendar-check" hint-size="auto,46px">Umów wizytę</x-import>
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
          <a href="#specjalizacje" onClick="{{ closeMenu }}" style="padding:13px 14px; border-radius:var(--radius-md); font-family:var(--font-display); font-size:16px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none;">Specjalizacje</a>
          <a href="#zespol" onClick="{{ closeMenu }}" style="padding:13px 14px; border-radius:var(--radius-md); font-family:var(--font-display); font-size:16px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none;">Specjaliści</a>
          <a href="#opinie" onClick="{{ closeMenu }}" style="padding:13px 14px; border-radius:var(--radius-md); font-family:var(--font-display); font-size:16px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none;">Opinie</a>
          <a href="#kontakt" onClick="{{ closeMenu }}" style="padding:13px 14px; border-radius:var(--radius-md); font-family:var(--font-display); font-size:16px; font-weight:var(--weight-medium); color:var(--navy-800); text-decoration:none;">Kontakt</a>
          <div style="margin-top:10px;">
            <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Button" class="cta-book-btn" onClick="{{ otworzKalendarzZMenu }}" icon="calendar-check" style="width:100%; justify-content:center;" hint-size="100%,46px">Umów wizytę</x-import>
          </div>
        </div>
      </div>
    </sc-if>
  </header>

  <main id="tresc">

    <section aria-labelledby="hero-h" style="background:var(--gradient-hero); color:var(--white);">
      <div style="max-width:var(--container-max); margin:0 auto; padding:72px var(--gutter) 0; display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:48px; align-items:end;">
        <div class="hero-copy" style="max-width:620px; padding-bottom:88px;">

          <div style="display: flex; align-items: center; gap: 24px; margin: 0 0 20px;">
            <img src="uploads/assets-1786096163757-0x49.webp" alt="Logo CMK" style="height: clamp(80px, 9vw, 120px); width: auto; object-fit: contain; flex-shrink: 0;">
            <h1 id="hero-h" style="margin:0; font-family:var(--font-display); font-size:45px; font-weight:var(--weight-extrabold); letter-spacing:var(--tracking-display); line-height:var(--leading-tight); color:var(--white);">Centrum Medyczne Kasprzaka</h1>
          </div>
          <p style="margin:0 0 32px; font-size:var(--text-body-lg); line-height:var(--leading-body); color:rgba(255,255,255,.78); max-width:520px; text-wrap:pretty;">Konsultacje specjalistyczne i diagnostyka USG w jednym miejscu. Termin zwykle w ciągu kilku dni, bez skierowania.</p>
          <div style="display:flex; flex-wrap:wrap; gap:12px; white-space:nowrap;">
            <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Button" class="cta-book-btn" onClick="{{ otworzKalendarz }}" size="lg" icon="calendar-check" hint-size="auto,56px">Umów wizytę online</x-import>
            <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Button" class="hero-phone-btn" as="a" href="tel:+48727500085" variant="onDark" size="lg" icon="phone" hint-size="auto,56px"><span class="hero-phone-label">Zadzwoń: 727 500 085</span></x-import>
          </div>

        </div>
        <div style="position: relative; align-self: end; display: flex; justify-content: center">

          <span aria-hidden="true" style="position:absolute; left:50%; bottom:0; transform:translateX(-50%); width:min(360px, 84%); aspect-ratio:1/1.06; border-radius:999px 999px 28px 28px; background:rgba(255,255,255,.10); border:1px solid rgba(255,255,255,.20);"></span>

          <img src="uploads/doctor-2-transparent.webp" alt="Lekarka Centrum Medycznego Kasprzaka w granatowym uniformie" style="position: relative; display: block; max-width: 440px; height: auto; filter: drop-shadow(0 30px 60px rgba(14,26,60,.45)); width: 100%; flex-grow: 15; object-fit: fill">

        </div>
      </div>
    </section>

    <!-- Pasek ocen wyniesiony między hero a specjalizacje: nachodzi w połowie na obie sekcje. -->
    <div class="hero-proof-bridge">
      <!-- Zadowoleni pacjenci (Odnośnik do ZnanyLekarz) -->
      <div class="hero-proof hero-proof--bridge">
        <a class="hero-proof__item" href="https://www.znanylekarz.pl/placowki/centrum-medyczne-kasprzaka" target="_blank" rel="noopener noreferrer">
          <span class="hero-proof__value">
            <span class="u-num">1000+</span>
          </span>
          <span class="hero-proof__label">
            Zadowolonych pacjentów
          </span>
        </a>
        <a class="hero-proof__item" href="https://www.znanylekarz.pl/placowki/centrum-medyczne-kasprzaka" target="_blank" rel="noopener noreferrer">
          <span class="hero-proof__value">
            <span class="u-num">5,0</span>
            <svg aria-hidden="true" width="14" height="14" viewBox="0 0 24 24" fill="var(--star-rating)"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          </span>
          <span class="hero-proof__label">
            <img src="uploads/znany-lekarz.webp" alt="" width="14" height="14" style="width:14px; height:14px; border-radius:3px; object-fit:contain;">
            ZnanyLekarz
          </span>
          <span class="u-sr-only">Ocena 5,0 na 5 w serwisie ZnanyLekarz — otwiera się w nowej karcie</span>
        </a>
        <a class="hero-proof__item" href="specjalisci.php">
          <span class="hero-proof__value"><span class="u-num">30+</span></span>
          <span class="hero-proof__label">Lekarzy specjalistów</span>
        </a>
      </div>
    </div>

    <section id="specjalizacje" aria-labelledby="spec-h" style="background:var(--white);">
      <div style="max-width:var(--container-max); margin:0 auto; padding:96px var(--gutter);">
        <div class="spec-header-wrap">
          <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.SectionHeading" eyebrow="Czym się zajmujemy" title="Wybierz specjalizację" lead="Poradnie dla dzieci i dorosłych oraz własna pracownia USG — wszystko pod jednym adresem." hint-size="100%,160px"></x-import>
          <div class="spec-slider-controls">
            <button type="button" class="spec-slider-btn spec-slider-btn--prev" aria-label="Poprzednie specjalizacje" onClick="{{ przewinSpecjalizacjeLewo }}">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </button>
            <button type="button" class="spec-slider-btn spec-slider-btn--next" aria-label="Następne specjalizacje" onClick="{{ przewinSpecjalizacjePrawo }}">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </button>
          </div>
        </div>
        <div class="spec-swipe-indicator">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 8l4 4-4 4M7 16l-4-4 4-4M21 12H3"/></svg>
          Przesuń, aby zobaczyć więcej
        </div>
        <svg aria-hidden="true" style="position:absolute; width:0; height:0; overflow:hidden;">
          <defs>
            <?php
            // Sprite budowany z ikon faktycznie uzywanych przez kafle na stronie glownej -
            // panel pozwala wybrac dowolna z 43 ikon w assets/specialties/, wiec sprite
            // musi je dociagac dynamicznie zamiast trzymac na sztywno w markupie.
            $ikonyDoWyswietlenia = [];
            foreach ($TRESC['specjalizacje'] as $s) {
                if (!empty($s['naStronieGlownej']) && !empty($s['ikona'])) $ikonyDoWyswietlenia[$s['ikona']] = true;
            }
            foreach (array_keys($ikonyDoWyswietlenia) as $ikonaId) {
                echo cmk_ikona_symbol($ikonaId);
            }
            ?>
          </defs>
        </svg>
        <div class="spec-grid">
          <sc-for list="{{ specjalizacje }}" as="s" hint-placeholder-count="3">
            <a href="specjalisci.php?spec={{ s.id }}" class="spec-card">
              <span class="spec-card__bg-icon" aria-hidden="true">
                <svg width="140" height="140" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon-{{ s.ikona }}"></use></svg>
              </span>
              <div class="spec-card__header">
                <span class="spec-card__icon" aria-hidden="true">
                  <svg width="38" height="38" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon-{{ s.ikona }}"></use></svg>
                </span>
                <span class="spec-card__action" aria-hidden="true">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </span>
              </div>
              <div class="spec-card__body">
                <span class="spec-card__title">{{ s.nazwa }}</span>
                <span class="spec-card__desc">{{ s.opis }}</span>
              </div>
            </a>
          </sc-for>
          <a href="specjalisci.php" class="spec-card spec-card--more">
            <span class="spec-card__bg-icon" aria-hidden="true">
              <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Icon" name="chevron-right" size="130px" hint-size="130px,130px"></x-import>
            </span>
            <div class="spec-card__header">
              <span class="spec-card__icon" aria-hidden="true">
                <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Icon" name="chevron-right" size="28px" hint-size="28px,28px"></x-import>
              </span>
              <span class="spec-card__action" aria-hidden="true">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
              </span>
            </div>
            <div class="spec-card__body">
              <span class="spec-card__title">Wszystkie specjalizacje</span>
              <span class="spec-card__desc">Kardiologia, USG i&nbsp;więcej</span>
            </div>
          </a>
        </div>
      </div>
    </section>

    <section aria-labelledby="dlaczego-h" style="background:var(--surface-subtle);">
      <div style="max-width:var(--container-max); margin:0 auto; padding:96px var(--gutter);">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:64px; align-items:center;">
          <div class="visit-photo-wrap" style="position:relative;">
            <img src="uploads/doctor-patient.webp" alt="Lekarka Centrum Medycznego Kasprzaka rozmawia z pacjentem podczas konsultacji" class="visit-photo" style="display:block; width:100%; object-fit:cover; border-radius:28px; box-shadow:var(--shadow-md, 0 24px 44px rgba(14,26,60,.18));">
          </div>
          <div>
            <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.SectionHeading" eyebrow="Jak wygląda wizyta" title="Cztery kroki, bez niespodzianek" lead="Od rezerwacji do wyniku — wszystko na miejscu, przy ul. Kasprzaka 31." hint-size="100%,160px"></x-import>
            <div style="position:relative; margin-top:36px;">
              <div aria-hidden="true" style="position:absolute; left:16px; top:17px; bottom:17px; width:2px; background:var(--border-subtle);"></div>
              <ol style="position:relative; margin:0; padding:0; list-style:none; display:flex; flex-direction:column; gap:30px;">
                <li style="position:relative; display:flex; gap:16px;">
                  <span style="position:relative; z-index:1; width:34px; height:34px; flex:0 0 auto; border-radius:var(--radius-pill); display:grid; place-items:center; background:var(--blue-600); color:var(--white); font-family:var(--font-display); font-weight:var(--weight-extrabold); font-size:14px; box-shadow:0 0 0 6px var(--surface-subtle);">1</span>
                  <span>
                    <span style="display:block; font-family:var(--font-display); font-size:16.5px; font-weight:var(--weight-bold); color:var(--navy-900);">Wybierasz termin online</span>
                    <span style="display:block; margin-top:4px; font-size:15px; line-height:1.6; color:var(--text-muted);">Wolne godziny widać od razu. Zwykle w ciągu 3 dni, bez skierowania.</span>
                  </span>
                </li>
                <li style="position:relative; display:flex; gap:16px;">
                  <span style="position:relative; z-index:1; width:34px; height:34px; flex:0 0 auto; border-radius:var(--radius-pill); display:grid; place-items:center; background:var(--white); color:var(--blue-600); border:2px solid var(--blue-200); font-family:var(--font-display); font-weight:var(--weight-extrabold); font-size:14px; box-shadow:0 0 0 6px var(--surface-subtle);">2</span>
                  <span>
                    <span style="display:block; font-family:var(--font-display); font-size:16.5px; font-weight:var(--weight-bold); color:var(--navy-900);">Przychodzisz do przychodni</span>
                    <span style="display:block; margin-top:4px; font-size:15px; line-height:1.6; color:var(--text-muted);">Parking przed budynkiem, wejście z poziomu ulicy, bez schodów.</span>
                  </span>
                </li>
                <li style="position:relative; display:flex; gap:16px;">
                  <span style="position:relative; z-index:1; width:34px; height:34px; flex:0 0 auto; border-radius:var(--radius-pill); display:grid; place-items:center; background:var(--white); color:var(--blue-600); border:2px solid var(--blue-200); font-family:var(--font-display); font-weight:var(--weight-extrabold); font-size:14px; box-shadow:0 0 0 6px var(--surface-subtle);">3</span>
                  <span>
                    <span style="display:block; font-family:var(--font-display); font-size:16.5px; font-weight:var(--weight-bold); color:var(--navy-900);">Badanie robimy na miejscu</span>
                    <span style="display:block; margin-top:4px; font-size:15px; line-height:1.6; color:var(--text-muted);">USG dla dzieci i dorosłych w tym samym gabinecie co konsultacja.</span>
                  </span>
                </li>
                <li style="position:relative; display:flex; gap:16px;">
                  <span style="position:relative; z-index:1; width:34px; height:34px; flex:0 0 auto; border-radius:var(--radius-pill); display:grid; place-items:center; background:var(--white); color:var(--blue-600); border:2px solid var(--blue-200); font-family:var(--font-display); font-weight:var(--weight-extrabold); font-size:14px; box-shadow:0 0 0 6px var(--surface-subtle);">4</span>
                  <span>
                    <span style="display:block; font-family:var(--font-display); font-size:16.5px; font-weight:var(--weight-bold); color:var(--navy-900);">Wynik dostajesz tego samego dnia</span>
                    <span style="display:block; margin-top:4px; font-size:15px; line-height:1.6; color:var(--text-muted);">Opis USG omawiamy bezpośrednio po badaniu.</span>
                  </span>
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="zespol" aria-labelledby="zespol-h" style="background:var(--white);">
      <div style="max-width:var(--container-max); margin:0 auto; padding:96px var(--gutter);">
        <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.SectionHeading" eyebrow="Nasz zespół" title="Specjaliści" lead="Zdjęcia lekarzy do uzupełnienia — karty działają także bez fotografii." hint-size="100%,160px"></x-import>
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:18px; margin-top:40px;">
          <sc-for list="{{ lekarzeTeaser }}" as="l" hint-placeholder-count="4">
            <article style="border-radius:var(--radius-card); overflow:hidden; background:var(--white); border:1px solid var(--border-subtle); box-shadow:var(--shadow-xs);">
              <div style="height:230px; background:var(--gradient-wash); display:flex; align-items:flex-end; justify-content:center; overflow:hidden; border-bottom:1px solid var(--border-subtle);">
                <img src="{{ l.zdjecie }}" alt="{{ l.imie }}" style="display:block; width:86%; height:auto; margin-bottom:-6%;">
              </div>
              <div style="padding:18px 20px 20px;">
                <h3 style="margin:0; font-family:var(--font-display); font-size:17px; font-weight:var(--weight-bold); color:var(--navy-900);">{{ l.imie }}</h3>
                <p style="margin:2px 0 0; font-size:14.5px; color:var(--text-muted);">{{ l.podtytul }}</p>
                <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-top:16px; padding-top:14px; border-top:1px solid var(--border-subtle);">
                  <span style="font-size:14px; color:var(--text-muted);">Terminy online</span>
                  <button type="button" onClick="{{ l.otworzKalendarzDlaNiego }}" style="background:var(--blue-100); color:var(--blue-700); font-family:var(--font-display); font-weight:var(--weight-semibold); font-size:14px; padding:9px 16px; border-radius:var(--radius-pill); border:none; cursor:pointer; white-space:nowrap;" style-hover="background:var(--blue-200);">Umów</button>
                </div>
              </div>
            </article>
          </sc-for>
        </div>
        <div style="display:flex; justify-content:center; margin-top:32px; white-space:nowrap;">
          <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Button" as="a" href="specjalisci.php" variant="secondary" icon-after="chevron-right" hint-size="auto,46px">Zobacz wszystkich specjalistów</x-import>
        </div>
      </div>
    </section>

    <section id="opinie" aria-labelledby="opinie-h" style="background:var(--surface-subtle);">
      <div style="max-width:var(--container-max); margin:0 auto; padding:96px var(--gutter);">
        <div class="opinie-head">
          <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.SectionHeading" eyebrow="Opinie pacjentów" title="Co mówią nasi pacjenci" lead="Opinie pochodzą bezpośrednio z profilu placówki w serwisie ZnanyLekarz — wystawiają je pacjenci po odbytej wizycie." hint-size="100%,160px"></x-import>
          <!-- TODO: potwierdzić ocenę i dopisać liczbę opinii ZnanyLekarz. -->
          <div class="opinie-oceny">
            <a class="ocena-pigulka" href="https://www.znanylekarz.pl/placowki/centrum-medyczne-kasprzaka" target="_blank" rel="noopener noreferrer">
              <img src="uploads/znany-lekarz.webp" alt="" width="20" height="20" style="width:20px; height:20px; border-radius:5px; object-fit:contain; flex-shrink:0;">
              <span style="display:flex; align-items:baseline; gap:7px;">
                <span class="u-num" style="font-family:var(--font-display); font-size:19px; font-weight:var(--weight-extrabold); letter-spacing:var(--tracking-display); color:var(--navy-900);">5,0</span>
                <span style="font-size:14px; color:var(--text-muted);">ZnanyLekarz</span>
              </span>
              <svg aria-hidden="true" width="13" height="13" viewBox="0 0 24 24" fill="var(--star-rating)" style="flex-shrink:0;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <span class="u-sr-only">Ocena 5,0 na 5 w serwisie ZnanyLekarz — otwiera się w nowej karcie</span>
            </a>

            <a class="ocena-pigulka" href="https://www.google.com/maps/search/?api=1&amp;query=Centrum%20Medyczne%20Kasprzaka%2C%20Marcina%20Kasprzaka%2031%2C%20Warszawa" target="_blank" rel="noopener noreferrer">
              <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" style="flex-shrink:0;">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
              </svg>
              <span style="display:flex; align-items:baseline; gap:7px;">
                <span class="mobile-hide-google-text" style="font-family:var(--font-display); font-size:19px; font-weight:var(--weight-extrabold); letter-spacing:var(--tracking-display); color:var(--navy-900);">Google</span>
                <span style="font-size:14px; color:var(--text-muted);"><span class="u-num">87</span> opinii</span>
              </span>
              <span class="u-sr-only">Zobacz opinie w Google na podstawie 87 opinii — otwiera się w nowej karcie</span>
            </a>
          </div>
        </div>

        <h2 id="opinie-h" class="u-sr-only">Opinie pacjentów</h2>

        <!--
          Miejsce na oficjalny widget opinii ZnanyLekarz.
          Wygeneruj go w panelu: Mój profil → Kanały rezerwacji → Utwórz widget → widget z opiniami.
          Z wygenerowanego snippetu przenieś WSZYSTKIE atrybuty data-zlw-* / data-zl-* naraz na poniższy <a>
          (id="zl-opinie-anchor" musi zostać). Znacznika <script> nie wklejaj — dociąga go leniwie
          zamontujWidgetOpinii(), dopiero gdy sekcja wjedzie w viewport.
          UWAGA: nie dodawaj samego data-zl-widget-facility bez kompletu atrybutów (w tym data-zlw-type).
          widget.js z ZnanyLekarz skanuje CAŁĄ stronę pod kątem [data-zl-widget-facility] — jeśli ten link
          ma ten atrybut, a modal kalendarza (#zl-widget-anchor) doładuje ten sam skrypt, widget kalendarza
          wstrzykuje się także tutaj i deformuje ten przycisk. Dopóki brakuje kompletu atrybutów, ten <a>
          zostaje zwykłym linkiem-fallbackiem bez żadnego data-zl-*.
        -->
        <div style="margin-top:40px; background:var(--white); border:1px solid var(--border-subtle); border-radius:var(--radius-card); box-shadow:var(--shadow-xs); padding:36px 28px; display:flex; flex-direction:column; align-items:center; gap:32px; overflow:hidden;">
          <div class="swipe-indicator">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 8l4 4-4 4M7 16l-4-4 4-4M21 12H3"/></svg>
            Przesuń, aby zobaczyć więcej
          </div>
          <div class="reviews-grid">
            
            <div style="background:var(--navy-050); border-radius:var(--radius-md); padding:24px; display:flex; flex-direction:column; gap:16px;">
              <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                  <div style="font-family:var(--font-display); font-weight:var(--weight-bold); color:var(--navy-900); font-size:16px;">Edyta</div>
                  <div style="font-size:12px; color:var(--success-700); background:var(--success-100); padding:3px 8px; border-radius:4px; display:inline-flex; align-items:center; gap:4px; margin-top:6px; font-weight:var(--weight-medium);">
                     <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg> Weryfikacja wizyty
                  </div>
                </div>
                <div style="color:var(--star-rating); display:flex; gap:2px;">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
              </div>
              <p style="margin:0; font-size:14.5px; line-height:1.6; color:var(--navy-800);">Doktor to świetny expert i dobry człowiek. Nie zostawia pacjenta samego po operacji, kiedy wychodzą dodatkowe rzeczy do zaopiekowania. Przywraca wiarę w to, że zawód lekarza to jednak misja, a ludzie, którzy go wykonują warci są naszego zaufania. Dziękuję Doktorze</p>
              <div style="margin-top:auto; padding-top:16px; border-top:1px solid rgba(14,26,60,.08); font-size:12.5px; color:var(--text-muted); line-height:1.45;">
                22 lipca 2026 • lek. Sebastian Janiczek • chirurgia ortopedyczna
              </div>
            </div>

            <div style="background:var(--navy-050); border-radius:var(--radius-md); padding:24px; display:flex; flex-direction:column; gap:16px;">
              <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                  <div style="font-family:var(--font-display); font-weight:var(--weight-bold); color:var(--navy-900); font-size:16px;">Dariusz</div>
                  <div style="font-size:12px; color:var(--success-700); background:var(--success-100); padding:3px 8px; border-radius:4px; display:inline-flex; align-items:center; gap:4px; margin-top:6px; font-weight:var(--weight-medium);">
                     <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg> Weryfikacja wizyty
                  </div>
                </div>
                <div style="color:var(--star-rating); display:flex; gap:2px;">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
              </div>
              <p style="margin:0; font-size:14.5px; line-height:1.6; color:var(--navy-800);">Bardzo dziękuję za profesjonalne podejście. Badanie Doppler wykonane skrupulatnie i drobiazgowo. Pani Doktor ma świetne podejście do pacjenta. Gorąco polecam!</p>
              <div style="margin-top:auto; padding-top:16px; border-top:1px solid rgba(14,26,60,.08); font-size:12.5px; color:var(--text-muted); line-height:1.45;">
                9 lipca 2026 • dr n. med. Dagmara Gralak-Łachowska • USG / doppler
              </div>
            </div>

            <div style="background:var(--navy-050); border-radius:var(--radius-md); padding:24px; display:flex; flex-direction:column; gap:16px;">
              <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                  <div style="font-family:var(--font-display); font-weight:var(--weight-bold); color:var(--navy-900); font-size:16px;">A.O.</div>
                  <div style="font-size:12px; color:var(--success-700); background:var(--success-100); padding:3px 8px; border-radius:4px; display:inline-flex; align-items:center; gap:4px; margin-top:6px; font-weight:var(--weight-medium);">
                     <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg> Weryfikacja wizyty
                  </div>
                </div>
                <div style="color:var(--star-rating); display:flex; gap:2px;">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
              </div>
              <p style="margin:0; font-size:14.5px; line-height:1.6; color:var(--navy-800);">Wizyta odbyła się punktualnie, w miłej i spokojniej atmosferze, na wszystkie moje pytania i wątpliwości pani doktor udzieliła wyczerpującej odpowiedzi oraz dała zalecenia. Serdecznie polecam</p>
              <div style="margin-top:auto; padding-top:16px; border-top:1px solid rgba(14,26,60,.08); font-size:12.5px; color:var(--text-muted); line-height:1.45;">
                27 czerwca 2026 • dr Anna Siniarska • konsultacja okulistyczna
              </div>
            </div>
          </div>
          
          <div style="display:flex; flex-direction:column; align-items:center; gap:16px; text-align:center; padding-top:12px; max-width:520px;">
            <p style="margin:0; font-size:var(--text-body); line-height:var(--leading-body); color:var(--text-muted);">Wszystkie zweryfikowane opinie pacjentów znajdziesz na naszym profilu ZnanyLekarz.</p>
            <a id="zl-opinie-anchor"
               href="https://www.znanylekarz.pl/placowki/centrum-medyczne-kasprzaka"
               target="_blank" rel="noopener noreferrer nofollow"
               style="display:inline-flex; align-items:center; gap:9px; min-height:46px; padding:12px 22px; border-radius:var(--radius-pill); background:var(--blue-600); color:var(--white); font-family:var(--font-display); font-weight:var(--weight-semibold); font-size:15px; text-decoration:none; transition:var(--transition-control);" style-hover="background:var(--blue-700); color:var(--white); text-decoration:none;">
              Zobacz opinie pacjentów
              <svg aria-hidden="true" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
            </a>
          </div>
        </div>
      </div>
    </section>

    <section id="kontakt" aria-labelledby="info-h" style="background:var(--white);">
      <div style="max-width:var(--container-max); margin:0 auto; padding:96px var(--gutter);">
        <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.SectionHeading" eyebrow="Zanim przyjdziesz" title="Praktyczne informacje" hint-size="100%,110px"></x-import>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:18px; margin-top:40px;">
          <!-- TODO: potwierdzić adres. Tu jest 01-211, a readme design systemu podaje "lok. U7, 01-255". -->
          <div style="background:var(--white); border:1px solid var(--border-subtle); border-radius:var(--radius-card); box-shadow:var(--shadow-xs); padding:26px;">
            <div style="font-family:var(--font-display); font-size:var(--text-eyebrow); font-weight:var(--weight-bold); letter-spacing:var(--tracking-eyebrow); text-transform:uppercase; color:var(--blue-600); margin-bottom:12px;">Adres</div>
            <p style="margin:0; font-size:var(--text-body); line-height:var(--leading-body); color:var(--navy-900);"><a href="https://www.google.com/maps/search/?api=1&amp;query=Centrum%20Medyczne%20Kasprzaka%2C%20Marcina%20Kasprzaka%2031%2C%20Warszawa" target="_blank" rel="noopener noreferrer" style="color:var(--navy-900); text-decoration:none;" style-hover="color:var(--blue-700); text-decoration:underline;">ul. Marcina Kasprzaka 31 lok. U7<br>01-211 Warszawa, Wola</a></p>
            <p style="margin:10px 0 0; font-size:var(--text-body-sm); line-height:var(--leading-body); color:var(--text-muted);">Wejście od strony ulicy, parter.</p>
          </div>
          <div style="background:var(--white); border:1px solid var(--border-subtle); border-radius:var(--radius-card); box-shadow:var(--shadow-xs); padding:26px;">
            <div style="font-family:var(--font-display); font-size:var(--text-eyebrow); font-weight:var(--weight-bold); letter-spacing:var(--tracking-eyebrow); text-transform:uppercase; color:var(--blue-600); margin-bottom:12px;">Godziny przyjęć</div>
            <p style="margin:0 0 14px; font-size:var(--text-body); line-height:var(--leading-body); color:var(--navy-900);">pon.–pt. 8:00–20:00<br>sob. 8:00–14:00<br>niedz. nieczynne</p>
            <span aria-live="polite" style="{{ statusStyl }}">
              <span aria-hidden="true" style="{{ statusKropka }}"></span>{{ statusOtwarcia }}
            </span>
          </div>
          <div style="background:var(--white); border:1px solid var(--border-subtle); border-radius:var(--radius-card); box-shadow:var(--shadow-xs); padding:26px; display:flex; flex-direction:column;">
            <div style="font-family:var(--font-display); font-size:var(--text-eyebrow); font-weight:var(--weight-bold); letter-spacing:var(--tracking-eyebrow); text-transform:uppercase; color:var(--blue-600); margin-bottom:12px;">Dojazd</div>
            <p style="margin:0 0 18px; font-size:var(--text-body-sm); line-height:var(--leading-body); color:var(--text-muted);">Tramwaj i autobus — przystanek przy ul. Kasprzaka. Parking dla pacjentów przed budynkiem.</p>
            <a href="https://www.google.com/maps/dir/?api=1&amp;destination=Centrum%20Medyczne%20Kasprzaka%2C%20Marcina%20Kasprzaka%2031%2C%20Warszawa" target="_blank" rel="noopener noreferrer" style="margin-top:auto; align-self:flex-start; display:inline-flex; align-items:center; gap:8px; min-height:44px; padding:10px 18px; border-radius:var(--radius-pill); background:var(--blue-100); color:var(--blue-700); font-family:var(--font-display); font-size:14px; font-weight:var(--weight-semibold); text-decoration:none; transition:var(--transition-control);" style-hover="background:var(--blue-200); text-decoration:none;">
              <svg aria-hidden="true" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
              Wyznacz trasę
            </a>
          </div>
          <div style="background:var(--white); border:1px solid var(--border-subtle); border-radius:var(--radius-card); box-shadow:var(--shadow-xs); padding:26px;">
            <div style="font-family:var(--font-display); font-size:var(--text-eyebrow); font-weight:var(--weight-bold); letter-spacing:var(--tracking-eyebrow); text-transform:uppercase; color:var(--blue-600); margin-bottom:12px;">Rejestracja</div>
            <p style="margin:0 0 6px; font-size:var(--text-body);"><a href="tel:+48727500085" style="text-decoration:none;">727 500 085</a></p>
            <p style="margin:0; font-size:var(--text-body);"><a href="mailto:rejestracja@cmkasprzaka.pl" style="text-decoration:none; word-break:break-all;">rejestracja@cmkasprzaka.pl</a></p>
          </div>
        </div>

        <!-- Mapa doczytywana na klik: bez zgody użytkownika nie leci żadne żądanie do Google. -->
        <div class="mapa-karta" style="margin-top:18px;">
          <sc-if value="{{ mapaWlaczona }}" hint-placeholder-val="{{ false }}">
            <iframe src="https://www.google.com/maps?q=Centrum+Medyczne+Kasprzaka,+Marcina+Kasprzaka+31,+Warszawa&amp;output=embed" title="Mapa dojazdu — Centrum Medyczne Kasprzaka, ul. Marcina Kasprzaka 31 w Warszawie" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </sc-if>
          <sc-if value="{{ mapaWylaczona }}" hint-placeholder-val="{{ true }}">
            <div style="height:100%; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:14px; padding:32px 24px; text-align:center;">
              <span aria-hidden="true" style="display:grid; place-items:center; width:44px; height:44px; border-radius:var(--radius-md); background:var(--blue-050); color:var(--blue-600);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
              </span>
              <p style="margin:0; font-family:var(--font-display); font-size:16.5px; font-weight:var(--weight-bold); color:var(--navy-900);">ul. Marcina Kasprzaka 31 lok. U7, Warszawa Wola</p>
              <button type="button" onClick="{{ wlaczMape }}" style="display:inline-flex; align-items:center; gap:8px; min-height:46px; padding:12px 22px; border-radius:var(--radius-pill); border:none; background:var(--blue-600); color:var(--white); font-family:var(--font-display); font-size:15px; font-weight:var(--weight-semibold); cursor:pointer; transition:var(--transition-control);" style-hover="background:var(--blue-700);">Pokaż mapę Google</button>
              <p style="margin:0; max-width:420px; font-size:var(--text-caption); line-height:1.5; color:var(--text-muted);">Załadowanie mapy nawiąże połączenie z serwerami Google. Trasę wyznaczysz też bez ładowania mapy — przyciskiem „Wyznacz trasę”.</p>
            </div>
          </sc-if>
        </div>
      </div>
    </section>

    <section aria-labelledby="cta-h" style="background:var(--surface-subtle);">
      <div style="max-width:var(--container-max); margin:0 auto; padding:96px var(--gutter);">
        <div style="background:var(--gradient-hero); border-radius:28px; color:var(--white); padding:56px 48px; display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:28px;">
          <div style="max-width:600px;">
            <h2 id="cta-h" style="margin:0 0 12px; font-family:var(--font-display); font-size:var(--text-h2); font-weight:var(--weight-extrabold); letter-spacing:var(--tracking-display); line-height:var(--leading-heading); color:var(--white);">Wolne terminy widoczne online</h2>
            <p style="margin:0; font-size:var(--text-body-lg); line-height:var(--leading-body); color:rgba(255,255,255,.78);">Kalendarz wizyt prowadzimy w serwisie ZnanyLekarz. Można też umówić się telefonicznie w godzinach pracy recepcji.</p>
          </div>
          <div style="display:flex; flex-wrap:wrap; gap:12px; white-space:nowrap;">
            <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Button" class="cta-book-btn" onClick="{{ otworzKalendarz }}" size="lg" icon="calendar-check" hint-size="auto,56px">Umów wizytę</x-import>
            <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Button" as="a" href="tel:+48727500085" variant="onDark" size="lg" icon="phone" hint-size="auto,56px">Zadzwoń</x-import>
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
        <p style="margin:12px 0 0; font-size:13px; line-height:1.65; color:rgba(255,255,255,.55);">Podmiot wpisany do Rejestru Podmiotów Wykonujących Działalność Leczniczą prowadzonego przez Wojewodę Mazowieckiego, nr księgi — do uzupełnienia.</p>
      </div>
      <nav aria-label="Stopka — serwis">
        <div style="font-family:var(--font-display); font-size:var(--text-eyebrow); font-weight:var(--weight-bold); letter-spacing:var(--tracking-eyebrow); text-transform:uppercase; color:var(--white); margin-bottom:16px;">Serwis</div>
        <ul style="margin:0; padding:0; list-style:none; display:flex; flex-direction:column; gap:10px; font-size:14.5px;">
          <li><a href="specjalisci.php" style="color:rgba(255,255,255,.72); text-decoration:none;">Specjaliści</a></li>
          <li><a href="#specjalizacje" style="color:rgba(255,255,255,.72); text-decoration:none;">Zakres usług</a></li>
          <li><a href="cennik.php" style="color:rgba(255,255,255,.72); text-decoration:none;">Cennik</a></li>
          <li><a href="aktualnosci.php" style="color:rgba(255,255,255,.72); text-decoration:none;">Aktualności</a></li>
          <li><a href="#kontakt" style="color:rgba(255,255,255,.72); text-decoration:none;">Kontakt</a></li>
        </ul>
      </nav>
      <nav aria-label="Stopka — dokumenty">
        <div style="font-family:var(--font-display); font-size:var(--text-eyebrow); font-weight:var(--weight-bold); letter-spacing:var(--tracking-eyebrow); text-transform:uppercase; color:var(--white); margin-bottom:16px;">Dokumenty</div>
        <ul style="margin:0; padding:0; list-style:none; display:flex; flex-direction:column; gap:10px; font-size:14.5px;">
          <li><a href="#" style="color:rgba(255,255,255,.72); text-decoration:none;">Polityka prywatności</a></li>
          <li><a href="#" style="color:rgba(255,255,255,.72); text-decoration:none;">Klauzula informacyjna RODO</a></li>
          <li><a href="#" style="color:rgba(255,255,255,.72); text-decoration:none;">Ustawienia prywatności</a></li>
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
      <div style="max-width:var(--container-max); margin:0 auto; padding:18px var(--gutter) 96px; font-size:13.5px;">© 2026 Centrum Medyczne Kasprzaka</div>
    </div>
  </footer>

  <sc-if value="{{ pokazPasek }}" hint-placeholder-val="{{ false }}">
    <sc-if value="{{ fabMenuOtwarte }}">
      <div onClick="{{ closeFabMenu }}" aria-hidden="true" style="position:fixed; inset:0; z-index:55; background:rgba(255,255,255,.6); backdrop-filter:blur(4px); -webkit-backdrop-filter:blur(4px);"></div>
    </sc-if>
    <div role="region" aria-label="Szybki kontakt" style="position:fixed; right:20px; bottom:20px; z-index:60; display:flex; flex-direction:column; align-items:flex-end; gap:16px;">
      
      <sc-if value="{{ fabMenuOtwarte }}">
        <div style="display:flex; flex-direction:column; gap:12px; align-items:flex-end; animation:kalCardIn .2s ease-out both;">
          <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Button" as="a" href="tel:+48727500085" onClick="{{ closeFabMenu }}" variant="secondary" icon="phone" size="lg" style="box-shadow:var(--shadow-lg); min-width:180px; justify-content:center;" hint-size="auto,56px">Zadzwoń</x-import>
          <x-import component-from-global-scope="CMKasprzakaDesignSystem_10ef77.Button" class="cta-book-btn" onClick="{{ otworzKalendarz }}" icon="calendar-check" size="lg" style="box-shadow:var(--shadow-lg); min-width:180px; justify-content:center;" hint-size="auto,56px">Umów wizytę</x-import>
        </div>
      </sc-if>
      
      <button type="button" onClick="{{ toggleFabMenu }}" aria-label="Opcje kontaktu" aria-expanded="{{ fabMenuOtwarte }}" style="width:64px; height:64px; border-radius:50%; background:var(--action-primary); color:var(--white); border:none; box-shadow:var(--shadow-lg); display:grid; place-items:center; cursor:pointer; transition:transform .2s;" style-hover="transform:scale(1.05);">
        <sc-if value="{{ !fabMenuOtwarte }}">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
        </sc-if>
        <sc-if value="{{ fabMenuOtwarte }}">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </sc-if>
      </button>
      
    </div>
  </sc-if>

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
<script type="text/x-dc" data-dc-script>
// Godziny przyjęć — jedyne źródło prawdy dla statusu "Otwarte teraz".
// Klucz to dzień tygodnia wg Date#getDay (0 = niedziela), wartość [godzina otwarcia, godzina zamknięcia].
const GODZINY = { 1: [8, 20], 2: [8, 20], 3: [8, 20], 4: [8, 20], 5: [8, 20], 6: [8, 14], 0: null };
// Z przyimkiem w tablicy, bo wtorek wymaga "we", a nie "w".
const DNI_KIEDY = ['w niedzielę', 'w poniedziałek', 'we wtorek', 'w środę', 'w czwartek', 'w piątek', 'w sobotę'];

// Treść wstrzyknięta przez PHP z data/*.json (patrz inc/tresc.php) — jedyne źródło prawdy,
// współdzielone z specjalisci.php.
const SPECJALIZACJE = window.TRESC.specjalizacje;
const LEKARZE = window.TRESC.lekarze;

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
  // "teraz" nie jest nigdzie czytane — służy wyłącznie za wyzwalacz przerysowania co minutę,
  // żeby renderVals policzył status otwarcia od nowa.
  state = { pokazPasek: false, szeroki: true, menuOtwarte: false, kalendarzOtwarty: false, widgetLekarzaOtwarty: false, mapaWlaczona: false, fabMenuOtwarte: false, teraz: Date.now() };
  aktualizuj = () => {
    const waski = window.innerWidth < 1000;
    const next = waski && window.scrollY > 420;
    if (next !== this.state.pokazPasek || !waski !== this.state.szeroki) {
      this.setState({ pokazPasek: next, szeroki: !waski, ...(next ? {} : { fabMenuOtwarte: false }) });
    }
    if (window.innerWidth > 1000 && this.state.menuOtwarte) {
      this.setState({ menuOtwarte: false });
    }
  };
  wlaczMape = () => this.setState({ mapaWlaczona: true });

  // Czas liczony w strefie placówki, nie przeglądarki — inaczej pacjent spoza Polski zobaczy zły status.
  czasWarszawski() {
    const czesci = new Intl.DateTimeFormat('en-US', {
      timeZone: 'Europe/Warsaw', weekday: 'short', hour: '2-digit', minute: '2-digit', hourCycle: 'h23'
    }).formatToParts(new Date());
    const pobierz = (t) => (czesci.find((c) => c.type === t) || {}).value;
    const dzien = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'].indexOf(pobierz('weekday'));
    return { dzien, minuty: Number(pobierz('hour')) * 60 + Number(pobierz('minute')) };
  }
  statusOtwarcia() {
    const { dzien, minuty } = this.czasWarszawski();
    if (dzien < 0) return null;
    const dzis = GODZINY[dzien];
    if (dzis && minuty >= dzis[0] * 60 && minuty < dzis[1] * 60) {
      return { otwarte: true, tekst: 'Otwarte teraz — do ' + dzis[1] + ':00' };
    }
    if (dzis && minuty < dzis[0] * 60) {
      return { otwarte: false, tekst: 'Zamknięte — otwieramy dziś o ' + dzis[0] + ':00' };
    }
    for (let i = 1; i <= 7; i++) {
      const kolejny = (dzien + i) % 7;
      if (GODZINY[kolejny]) {
        const kiedy = i === 1 ? 'jutro' : DNI_KIEDY[kolejny];
        return { otwarte: false, tekst: 'Zamknięte — otwieramy ' + kiedy + ' o ' + GODZINY[kolejny][0] + ':00' };
      }
    }
    return null;
  }

  // Widget opinii montowany dopiero, gdy sekcja wjeżdża w viewport — wejście na stronę nie ciągnie JS-a strony trzeciej.
  zamontujWidgetOpinii = () => {
    const kotwica = document.getElementById('zl-opinie-anchor');
    if (!kotwica || this.widgetOpiniiZamontowany) return;
    // Bez wygenerowanego w panelu atrybutu data-zlw-type nie ma czego montować — zostaje link jako fallback.
    if (!kotwica.getAttribute('data-zlw-type')) return;
    this.widgetOpiniiZamontowany = true;
    const s = document.createElement('script');
    s.id = 'zl-opinie-widget';
    s.src = 'https://www.znanylekarz.pl/platform/js/widget.js';
    document.body.appendChild(s);
  };
  toggleMenu = () => this.setState({ menuOtwarte: !this.state.menuOtwarte });
  closeMenu = () => this.setState({ menuOtwarte: false });
  toggleFabMenu = () => this.setState({ fabMenuOtwarte: !this.state.fabMenuOtwarte });
  closeFabMenu = () => this.setState({ fabMenuOtwarte: false });
  // Ogolny kalendarz placowki - bez zadnej logiki per-lekarz, dokladnie jak przed
  // wprowadzeniem widgetow dla poszczegolnych lekarzy.
  otworzKalendarz = (e) => {
    if (e && e.preventDefault) e.preventDefault();
    document.body.style.overflow = 'hidden';
    this.setState({ kalendarzOtwarty: true, fabMenuOtwarte: false });
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
  // Osobny, calkowicie niezalezny modal na widget lekarza wklejony 1:1 z panelu -
  // zero wspoldzielonych id/atrybutow z modalem ogolnego kalendarza powyzej.
  otworzWidgetLekarza = (e, lekarz) => {
    if (e && e.preventDefault) e.preventDefault();
    document.body.style.overflow = 'hidden';
    this.setState({ widgetLekarzaOtwarty: true, wybranyWidgetHtml: lekarz.widgetHtml, fabMenuOtwarte: false });
    setTimeout(() => {
      const kontener = document.getElementById('zl-lekarz-widget-slot');
      if (kontener) cmkWstrzyknijWidget(kontener, lekarz.widgetHtml);
    }, 0);
  };
  zamknijWidgetLekarza = () => {
    document.body.style.overflow = '';
    this.setState({ widgetLekarzaOtwarty: false });
  };
  przewinSpecjalizacjeLewo = () => {
    const el = document.querySelector('.spec-grid');
    if (el) el.scrollBy({ left: -320, behavior: 'smooth' });
  };
  przewinSpecjalizacjePrawo = () => {
    const el = document.querySelector('.spec-grid');
    if (el) el.scrollBy({ left: 320, behavior: 'smooth' });
  };
  zatrzymaj = (e) => { if (e && e.stopPropagation) e.stopPropagation(); };
  obslugaKlawiszy = (e) => {
    if (e.key === 'Escape' && this.state.kalendarzOtwarty) this.zamknijKalendarz();
    if (e.key === 'Escape' && this.state.widgetLekarzaOtwarty) this.zamknijWidgetLekarza();
  };
  componentDidMount() {
    this.aktualizuj();
    window.addEventListener('scroll', this.aktualizuj, { passive: true });
    window.addEventListener('resize', this.aktualizuj);
    window.addEventListener('keydown', this.obslugaKlawiszy);
    this.zegar = setInterval(() => this.setState({ teraz: Date.now() }), 60000);
    setTimeout(() => {
      const sekcja = document.getElementById('opinie');
      if (!sekcja) return;
      if (!('IntersectionObserver' in window)) { this.zamontujWidgetOpinii(); return; }
      this.obserwatorOpinii = new IntersectionObserver((wpisy, obs) => {
        if (!wpisy.some((w) => w.isIntersecting)) return;
        obs.disconnect();
        this.obserwatorOpinii = null;
        this.zamontujWidgetOpinii();
      }, { rootMargin: '200px' });
      this.obserwatorOpinii.observe(sekcja);
    }, 0);
  }
  componentWillUnmount() {
    window.removeEventListener('scroll', this.aktualizuj);
    window.removeEventListener('resize', this.aktualizuj);
    window.removeEventListener('keydown', this.obslugaKlawiszy);
    if (this.zegar) clearInterval(this.zegar);
    if (this.obserwatorOpinii) this.obserwatorOpinii.disconnect();
    document.body.style.overflow = '';
  }
  renderVals() {
    const status = this.statusOtwarcia();
    const pigulka = 'display:inline-flex; align-items:center; gap:8px; padding:7px 14px; border-radius:var(--radius-pill); font-family:var(--font-display); font-size:13.5px; font-weight:var(--weight-semibold);';
    const kropka = 'width:8px; height:8px; border-radius:50%; flex-shrink:0; background:currentColor;';
    return {
      specjalizacje: SPECJALIZACJE.filter((s) => s.naStronieGlownej),
      przewinSpecjalizacjeLewo: this.przewinSpecjalizacjeLewo,
      przewinSpecjalizacjePrawo: this.przewinSpecjalizacjePrawo,
      // Lekarz z wklejonym widgetem dostaje przycisk otwierajacy jego wlasny modal,
      // reszta dziala jak dotychczas - wspolny kalendarz placowki.
      lekarzeTeaser: LEKARZE.filter((l) => l.naStronieGlownej).map((l) => ({
        ...l,
        otworzKalendarzDlaNiego: l.widgetHtml ? (e) => this.otworzWidgetLekarza(e, l) : this.otworzKalendarz
      })),
      pokazPasek: this.state.pokazPasek,
      szeroki: this.state.szeroki,
      menuOtwarte: this.state.menuOtwarte,
      toggleMenu: this.toggleMenu,
      closeMenu: this.closeMenu,
      kalendarzOtwarty: this.state.kalendarzOtwarty,
      otworzKalendarz: this.otworzKalendarz,
      otworzKalendarzZMenu: this.otworzKalendarzZMenu,
      zamknijKalendarz: this.zamknijKalendarz,
      widgetLekarzaOtwarty: this.state.widgetLekarzaOtwarty,
      zamknijWidgetLekarza: this.zamknijWidgetLekarza,
      zatrzymaj: this.zatrzymaj,
      mapaWlaczona: this.state.mapaWlaczona,
      mapaWylaczona: !this.state.mapaWlaczona,
      wlaczMape: this.wlaczMape,
      fabMenuOtwarte: this.state.fabMenuOtwarte,
      toggleFabMenu: this.toggleFabMenu,
      closeFabMenu: this.closeFabMenu,
      statusOtwarcia: status ? status.tekst : '',
      statusStyl: status
        ? pigulka + (status.otwarte
            ? ' background:var(--success-100); color:var(--success-600);'
            : ' background:var(--grey-100); color:var(--grey-600);')
        : 'display:none;',
      statusKropka: kropka
    };
  }
}
</script>
</body>
</html>
