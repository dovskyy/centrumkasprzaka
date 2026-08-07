# Centrum Medyczne Kasprzaka — Design System

A brand and UI system for **Centrum Medyczne Kasprzaka**, a private multi-specialty medical clinic at ul. Kasprzaka 31 lok. U7, 01-255 Warszawa (Wola district). The clinic treats children and adults, runs its own ultrasound suite (Voluson S8, 3D/4D), a blood-draw point and a vaccination point, and takes bookings by phone, in person, or through its online Portal Pacjenta.

Everything here is Polish-language first. Copy, dates, prices (zł) and honorifics assume a Polish patient.

## Sources this system was built from

| Source | What it gave us |
| --- | --- |
| `uploads/doctor-2-transparent.webp`, `uploads/doctor-3-transparent.webp` | The only genuine brand assets supplied: cut-out staff portraits in the clinic's navy uniform with the embroidered CMK mark. The brand navy (`--navy-600 #243568`, shadows to `#101F43`) was sampled from these fabrics. |
| `uploads/Modern website design.png` ("ProHealth"), `uploads/Zrzut ekranu 2026-08-07 140214.png` ("Nexora Clinic") | Two third-party healthcare landing-page comps the user supplied as **style references only** — modern clinic web design: big geometric-sans headlines, blue CTA pills, glass stat bars, cut-out doctor photography, white specialty grids. No copy, no marks and no proprietary layouts were taken from them. |
| https://cmkasprzaka.pl | Real product context read live: navigation structure, specialty and diagnostics inventory, tone of voice, address, phone, opening claims. Quoted copy in the kits is adapted from this site. |

**No codebase, Figma file, brand book, font files or logo file were provided.** Two consequences are flagged throughout:

1. **No logo.** The CMK mark exists only as low-resolution embroidery inside the uniform photos. It was deliberately *not* traced or reconstructed. Everywhere a mark would sit, the `Wordmark` component renders the clinic name in type. Replace it with the real SVG (the site serves `CM-Kasprzaka_logo_przezrocz_tlo.png`) when you have it.
2. **Substituted fonts.** The live site is a WordPress/Elementor build with no published typeface. This system commits to **Plus Jakarta Sans** (display) and **Source Sans 3** (body), both loaded from Google Fonts with full `latin-ext` Polish diacritics. If CMK has real brand fonts, swap `tokens/fonts.css`.

## Products covered

- **Marketing website** (`ui_kits/website/`) — public clinic site: homepage, specialty detail page, booking dialog.
- **Portal Pacjenta** (`ui_kits/portal/`) — logged-in patient area: dashboard, visits, results.

---

## Content fundamentals

**Language.** Polish. Medical terms keep their Polish names (`Kardiologia`, `USG jamy brzusznej`, `Echo serca`, `Punkt pobrań`). English appears only in file names and code.

**Person.** The clinic speaks as **my** ("Nasz zespół tworzą…", "Wykonujemy badania…") and addresses the patient with the informal-polite **Ty** in product UI ("Umów wizytę", "Zapisz się online", "Wybierz specjalistę i termin"), and with the formal **Państwo** in institutional prose on the website ("mają Państwo możliwość wykonania badań diagnostycznych"). Keep that split: **product UI is direct and second-person; page copy about the clinic is formal.**

**Casing.** Sentence case everywhere except the eyebrow kicker, which is uppercase with 0.14em tracking (`CZYM SIĘ ZAJMUJEMY`). Never title-case a Polish sentence. Buttons are sentence case: `Zapisz się online`, not `Zapisz Się Online`.

**Tone.** Calm, concrete, reassuring — never salesy, never clinical-cold. Lead with what the patient gets and when:

- Good: *"Echo serca i EKG wykonujemy na miejscu, w dniu konsultacji."*
- Good: *"Bezpłatne odwołanie do 24 h przed wizytą."*
- Avoid: *"Rewolucyjna opieka nowej generacji."*

**Claims.** Only claims the clinic can back: equipment by name (Voluson S8), scope ("dla dzieci i dorosłych"), access ("bez skierowania", "przystosowane dla osób z niepełnosprawnościami"). Never imply outcomes or guarantee diagnoses.

**Numbers.** Polish formatting — `250 zł` (space, lowercase zł), `4,9` with a decimal comma, `15 tys.+`, `+48 727 500 085`, dates as `12 sierpnia` or `12 sie` in compact chips, times as `09:30`. All figures render tabular-nums.

**Microcopy patterns.** Actions are verbs (`Umów`, `Rezerwuję 09:30`, `Pobierz`, `Odwołaj`). Statuses are adjectives agreeing with *wizyta*: `Potwierdzona`, `Oczekuje`, `Zrealizowana`, `Odwołana`. Empty and error states say what to do next, not what went wrong.

**Emoji: never.** Not in UI, not in marketing copy. Iconography carries all the visual punctuation.

---

## Visual foundations

**Colour.** One brand anchor: the uniform navy. `--navy-900 #0E1A3C` is the dark surface (hero, footer, sidebar); `--navy-600 #243568` is the sampled fabric colour; `--navy-050 #F1F4FB` is the alternating section wash. Action lives in a separate, brighter blue — `--blue-600 #0F62D0` for every CTA, link and selected state — so "brand" and "clickable" never blur. `--teal-500` is a small secondary accent for diagnostics and wellbeing badges, never a button. Status colours are muted, not neon. At most two background colours per page: white and one of navy / navy-050.

**Type.** Plus Jakarta Sans 800 with −0.025em tracking for display, 700 for headings; Source Sans 3 400 at 16/1.62 for body. Headlines run tight (1.06–1.18) and short — under nine words. A blue uppercase eyebrow precedes almost every section title. Body copy is grey-700; secondary copy grey-500.

**Backgrounds.** No patterns, no textures, no noise. Sections alternate flat white and `--navy-050`. The only gradients are `--gradient-hero` (navy → blue, 120°, used for the hero and the CTA band), `--gradient-wash` (navy-050 → white, behind cut-out portraits) and `--scrim-photo`, a left-to-right navy scrim that protects headline text over photography. No purple, ever.

**Imagery.** Cut-out (transparent-background) staff portraits in navy uniforms, cool and evenly lit, placed bottom-anchored against a gradient so the figure appears to stand in the layout. Full-bleed photography only in the hero, always behind a scrim. No stock-hospital clichés, no b&w, no grain, no warm filters.

**Corner radii.** Buttons and chips are fully pill (`--radius-pill`). Inputs and slot tiles 10px. Cards 18px (`--radius-card`). Photos 24px. Large marketing bands 28px. Nothing is square-cornered except full-bleed sections and table rules.

**Cards.** White, 18px radius, 1px `--grey-200` hairline, `--shadow-xs` at rest. Interactive cards lift `translateY(-3px)`, deepen to `--shadow-md`, and tint the border to `--blue-200` on hover. Shadows are navy-tinted (`rgba(14,26,60,…)`), never neutral black, and never larger than `--shadow-lg` (reserved for modals and toasts).

**Transparency and blur.** Only two places: the glass stat bar over hero photography (`--glass-bg` 14% white + `--glass-blur` 18px + 28% white border) and the `onDark` button variant. Never blur over white.

**Animation.** 200ms `--ease-standard` on colour, border and shadow; 340ms `--ease-out` for larger movements like a portrait scaling on card hover. Fades and short translations only — no bounce, no spring, no scroll-triggered choreography. Loading is a single 24px ring.

**States.** Hover darkens the fill one step (blue-600 → blue-700) and adds `--shadow-sm`; secondary and ghost controls fill with `--navy-050`. Press shrinks to `scale(.975)` — never a colour change alone. Focus is a 3px `--blue-200` ring plus the blue border. Disabled is 45% opacity with `not-allowed`, never a grey re-colour. Unavailable appointment slots stay visible, struck through and disabled — never removed.

**Layout.** 1240px max container, 24px gutter, 96px section padding (64px tight). Three-column grids for specialties and four for the team, 16–18px gaps. Fixed elements: the portal topbar is sticky; the specialty page's slot-picker card is sticky at 24px; the site header is not. Content columns cap at ~680px for reading.

**Borders.** 1px only. `--grey-200` for hairlines inside light surfaces, `--grey-300` on form controls, `rgba(255,255,255,.12)` on navy. No 2px rules, no coloured left-border accents.

---

## Iconography

**Lucide** ([lucide-static@0.544.0](https://unpkg.com/lucide-static@0.544.0/), CDN-linked, ~1.5–2px stroke, rounded caps) is the system's icon set. **This is a flagged substitution**: the clinic's own site uses one-off raster PNG icons per Elementor block, with no coherent icon system and no downloadable sprite, so nothing could be copied in. Lucide was chosen because its stroke weight and roundness match the thin-line medical glyphs in the reference comps.

Rules:

- Always render through the `Icon` component (`<Icon name="heart-pulse" size={20} />`). It masks the SVG so the glyph takes `currentColor`. Never paste hand-drawn SVG paths, never use an icon font, never substitute emoji or Unicode dingbats.
- Default size 20px; 16px inline with text, 24px in feature tiles, 28px+ only in empty states.
- Specialty glyphs in use: `baby` (pediatria), `heart-pulse` (kardiologia), `scan-heart` (USG / echo), `bone` (ortopedia), `eye` (okulistyka), `venus` (ginekologia), `activity` (endokrynologia), `syringe` (szczepienia), `test-tube` (badania laboratoryjne).
- Utility glyphs: `calendar-check`, `calendar-clock`, `phone`, `map-pin`, `clock`, `file-text`, `download`, `search`, `shield-check`, `chevron-right`.
- Icons in tiles sit in a 38–46px rounded square (`--radius-md`) filled `--blue-050` with a `--blue-600` glyph; on selected/dark surfaces the chip is 18% white with a white glyph.

**Assets on disk:** `assets/photos/doctor-female-navy.webp`, `assets/photos/doctor-male-navy.webp`. No logo file — see the flag above.

---

## Index

**Root**
- `styles.css` — the single entry point consumers link. `@import` list only.
- `readme.md` — this file. `SKILL.md` — Agent Skills wrapper. `thumbnail.html` — homepage tile.
- `tokens/` — `fonts.css`, `colors.css`, `typography.css`, `spacing.css`, `radius.css`, `elevation.css`, `motion.css`, `base.css`.
- `guidelines/` — 20 specimen cards (Colors, Type, Spacing, Brand groups).
- `assets/photos/` — cut-out staff portraits.

**Components** (`components/<group>/<Name>.jsx` + `.d.ts` + `.prompt.md`, one `@dsCard` HTML per group)

- `core/` — **Button**, **IconButton**, **Icon**, **Badge**, **Tag**, **Card**, **Stat**, **Wordmark**
- `forms/` — **FormField**, **Input**, **Textarea**, **Select**, **Checkbox**, **Radio**, **Switch**
- `feedback/` — **Alert**, **Toast**, **Dialog**, **Tooltip**, **Spinner**
- `navigation/` — **SiteHeader**, **SiteFooter**, **Tabs**, **Breadcrumbs**
- `patterns/` — **SectionHeading**, **ServiceCard**, **DoctorCard**, **StatBar**, **AppointmentCard**, **SlotPicker**, **PriceRow**

**Intentional additions.** No source defined a component inventory, so the standard primitive set was authored, plus five clinic-specific patterns the two products genuinely need: `ServiceCard` (specialty grid), `DoctorCard` (zespół grid), `AppointmentCard` (portal visit row), `SlotPicker` (bookable times) and `PriceRow` (cennik line). `Wordmark` exists only because there is no logo file.

**UI kits**
- `ui_kits/website/` — `index.html` (click-through), `Home.jsx`, `Specialty.jsx`, `Booking.jsx`, `README.md`
- `ui_kits/portal/` — `index.html` (click-through), `Shell.jsx`, `Dashboard.jsx`, `Visits.jsx`, `README.md`

No slide template was supplied, so no deck samples were authored.
