# Build Prompt — Private Medical Clinic Website (Warsaw, PL)

> **How to use this file:** fill in every `{{PLACEHOLDER}}` in Section 0, then paste the whole
> document into Claude Design as the opening brief. Build **page by page** (Home first, get it
> approved, then the rest) — do not ask for all 6 pages in one shot.
>
> Instructions are in English (more precise for the model). **All user-facing copy must be in
> Polish** — Polish strings in this file are the actual copy, use them verbatim unless told otherwise.

---

## 0. Project variables — FILL THIS IN FIRST

```yaml
clinic_name:             "Centrum Medyczne Kasprzaka"
legal_entity:            "Centrum Medyczne Kasprzaka Sp. z o.o., NIP: 5272935293, REGON: 387123910"
address:                 "ul. Marcina Kasprzaka 17A, 01-211 Warszawa"
district:                "Wola"
phone:                   "+48 22 862 80 80"
email:                   "rejestracja@cmkasprzaka.pl"
current_website:         "https://cmkasprzaka.pl"
znanylekarz_facility_url: "https://www.znanylekarz.pl/placowki/centrum-medyczne-kasprzaka"
opening_hours:           "pon.–pt. 8:00–20:00, sob. 8:00–14:00"
brand_colors:           "granatowy, błękit, biel"
logo_file:          	"Logo bedzie dolaczone w osobnym pliku/czacie"
main_specialties:        "ginekologia, urologia, USG, endokrynologia, dermatologia, interna"
doctor_count:            "15"
target_patient:          "pacjent prywatny 25–55 lat, mieszkańcy Woli i okolic poszukujący kompleksowej diagnostyki"
tone:                    "spokojny, profesjonalny, konkretny i empatyczny"
```

If a variable is left empty, **do not invent facts** — insert a clearly marked
`<!-- TODO: uzupełnić -->` comment and use neutral placeholder text.

---

## 1. Context and single goal

We are rebuilding an outdated website for a **private medical clinic in Warsaw**. It is a
**business-card site (wizytówka)**, not a portal — no patient login, no payments, no e-commerce.

**The single job of every page: get the visitor to book an appointment via ZnanyLekarz.**

Success metric: clicks on "Umów wizytę". Every layout decision is judged against that. Secondary
goals: build trust in the doctors, make prices findable, make the phone number reachable in one tap.

Two hard constraints that shape the whole build:

1. **The client edits content themselves.** They are non-technical. See Section 6 — this is a
   structural requirement, not a nice-to-have.
2. **Booking is external.** We never own the booking flow. We link/embed ZnanyLekarz. See Section 5.

---

## 2. Sitemap

| Route | Title (PL) | Purpose |
|---|---|---|
| `/` | Strona główna | Trust + fastest path to booking |
| `/specjalisci` | Specjaliści | Doctor grid, filterable by specialty |
| `/specjalisci/[slug]` | Profil lekarza | One doctor, one strong CTA |
| `/uslugi` | Zakres usług | What we treat, grouped by specialty |
| `/uslugi/[slug]` | Pojedyncza usługa | Optional — only if content justifies it |
| `/cennik` | Cennik | Full price table, searchable |
| `/kontakt` | Kontakt | Address, map, hours, transit, parking |
| `/polityka-prywatnosci` | Polityka prywatności | RODO |
| `/rodo` | Klauzula informacyjna RODO | Patient data processing info |

Cross-linking rules (important for conversion):
- Every doctor card links to their profile **and** has a direct booking CTA.
- Every service links to the doctors who perform it.
- Every price row links to the relevant service and/or doctor.
- Doctor profile links to their services and their price rows.

---

## 3. Page-by-page content spec

### 3.1 `/` Strona główna

Sections in order:

1. **Hero** — clinic name, one-line positioning, primary CTA `Umów wizytę online`,
   secondary CTA `Zadzwoń: {{phone}}` (tel: link, visible on mobile as a tap target).
   No stock photo of a smiling model in a white coat. Use a real photo of the clinic interior,
   or a typographic hero. If no photography exists, go typographic — do not use generic stock.
2. **Szybki wybór specjalizacji** — 6–10 tiles (Ortopedia, Dermatologia, …). Each tile → filtered
   `/specjalisci`. This is the highest-value block on the page; place it above the fold on desktop.
3. **Dlaczego my** — 3–4 concrete, checkable facts. Not adjectives.
   Good: `Wizyta zwykle w ciągu 3 dni`, `Wyniki USG tego samego dnia`, `Parking dla pacjentów`.
   Bad: `Najwyższa jakość`, `Doświadczony zespół`, `Indywidualne podejście`.
4. **Zespół** — 4–6 featured doctors, photo + name + specialty + `Umów wizytę`. Link to full list.
5. **Praktyczne informacje** — hours, address, transit, parking, entrance/floor. Patients search
   for this more than anything else after booking.
6. **CTA band** — repeat booking CTA before the footer.

Explicitly **not** on the homepage: a blog feed, a newsletter signup, a testimonial carousel with
invented quotes, a "0+ zadowolonych pacjentów" counter.

### 3.2 `/specjalisci`

Grid of doctor cards. Client-side filter by specialty (chips, not a `<select>`). Each card:
photo, `dr n. med. Imię Nazwisko`, specialty, 2–3 keyword areas, `Umów wizytę` (direct ZnanyLekarz
link for that doctor), `Zobacz profil`.

Filter state should be URL-reflected (`?specjalizacja=ortopedia`) so tiles on the homepage can
deep-link into it and so the client can share filtered links.

Card must degrade gracefully when a doctor has no photo — use initials in a styled tile, never a
grey silhouette placeholder.

### 3.3 `/specjalisci/[slug]`

Layout: sticky booking panel (desktop right column / mobile bottom bar), content left.

Content blocks: photo, full title and name, specialties, `O mnie` (2–4 paragraphs),
`Wykształcenie i doświadczenie` (list), `Obszary` (tags), `Przyjmuje w dniach` (text, not a live
calendar — the calendar lives in the ZnanyLekarz widget), `Usługi` (linked), `Ceny` (linked rows
pulled from the same price data), booking widget.

### 3.4 `/uslugi`

Grouped by specialty as accordion or anchored sections. Each service: name, 1–2 sentence plain-language
description, `Kto wykonuje` (doctor links), `Cena od` (link to `/cennik`), `Umów wizytę`.

Copy rule: describe what happens during the visit, in plain Polish. No promises of results, no
"skuteczna terapia", no before/after claims.

### 3.5 `/cennik`

A real table, not cards. Columns: `Usługa`, `Cena`, and optionally `Czas trwania`.
Requirements:
- Grouped by specialty with sticky group headers.
- Live text filter at the top (`Szukaj w cenniku…`) — this is the single most-used control here.
- Mobile: stack to two-line rows, never horizontal scroll.
- Prices as `250 zł` or `od 250 zł`. Always a `zł` suffix, always a non-breaking space.
- Mandatory footnote: `Cennik ma charakter informacyjny i nie stanowi oferty w rozumieniu art. 66 §1 Kodeksu cywilnego. Ostateczny koszt ustalany jest podczas wizyty.`
- Last-updated date, driven from the content file.

### 3.6 `/kontakt`

Address, embedded map (lazy-loaded, consent-gated — see Section 8), phone as `tel:`, email as
`mailto:`, hours table, how to get there (metro/tram/bus lines, parking), floor and entrance
description, full legal entity data in the footer of this page.

**No contact form in v1.** A form means processing health data by email — added RODO burden with no
conversion benefit when ZnanyLekarz and a phone number exist. If the client insists, it must collect
name + phone + non-medical topic only, with an explicit consent checkbox and a link to `/rodo`.

---

## 4. Design direction

Work in two passes: propose a compact token system (palette, type, layout concept, one signature
element) and critique it against this brief **before** writing code.

**Anti-brief — avoid these, they are the defaults every clinic site already uses:**
- Medical blue `#0066CC` + white + a stethoscope icon set.
- Full-bleed stock photo of a doctor with folded arms.
- Rounded-corner cards with soft drop shadows in a 3-column grid, repeated four times down the page.
- Cream `#F4F1EA` background with terracotta `#D97757` accent (an AI-design tell).
- Gradient hero with a big number counter.

**Direction to pursue instead:** calm, precise, high-legibility. The subject's real world is
appointment cards, referral slips, clear signage, clinical order. Draw from **wayfinding and
signage systems** rather than "wellness branding": strong horizontal rules, generous whitespace,
a disciplined grid, one confident accent used only for actions.

- **Palette:** 4–6 named hex values. One neutral base, one deep anchor, exactly **one** action
  colour reserved for booking CTAs and nothing else — so "coloured = clickable = book" is learned
  in two seconds. If `brand_colors` is set, derive from it; do not discard existing brand equity.
- **Type:** two faces. A characterful but restrained display face for headings and doctor names;
  a highly legible body face (patients skew older — body text minimum 17px, line-height ≥ 1.6).
  Avoid Inter/Poppins/Montserrat defaults. **Both faces must have full Polish diacritics**
  (ą ć ę ł ń ó ś ź ż) — verify before committing.
- **Layout:** max content width ~1200px, 8px spacing scale, consistent vertical rhythm between
  sections. Mobile-first: ~70% of traffic will be phones.
- **Signature element:** pick one memorable device and spend the boldness there — e.g. the
  specialty-tile grid on the homepage, or the typographic treatment of doctor names. Everything
  else stays quiet.
- **Motion:** minimal. Subtle scroll reveals at most. Respect `prefers-reduced-motion`.
  No parallax, no autoplaying carousels.
- **Photography:** real clinic and real doctors only. Where a photo is missing, use a designed
  placeholder that looks intentional.

---

## 5. ZnanyLekarz integration — the conversion core

All booking is handled by ZnanyLekarz (Docplanner). We do not build a calendar.

**Do not invent embed code or widget URLs.** The client copies the real snippet from their
ZnanyLekarz panel (*Widgety / Marketing*). Your job is to build the slots it drops into.

Required implementation:

1. **Single integration module** — `src/integrations/znanylekarz.{js,ts}` — the only file that
   knows anything about ZnanyLekarz. Exports:
   - `<BookingButton doctorSlug? variant="primary|secondary|inline" />`
   - `<BookingWidget doctorSlug? />` — mounts the embed script.
2. **URLs live in the content file** (Section 6), never hardcoded in components:
   ```js
   znanylekarz: {
     facilityUrl: "https://www.znanylekarz.pl/placowki/...",
     widgetScript: "", // ← klient wkleja snippet z panelu ZnanyLekarz
   }
   // and per doctor:
   { slug: "jan-kowalski", znanylekarzUrl: "https://www.znanylekarz.pl/jan-kowalski/..." }
   ```
3. **Graceful fallback (mandatory).** If `widgetScript` is empty or the script fails to load, the
   component renders a plain link button to the doctor's ZnanyLekarz profile
   (`target="_blank" rel="noopener"`). If the doctor has no ZnanyLekarz URL, fall back to the
   facility URL; if that is also missing, fall back to `Zadzwoń: {{phone}}`. **The page must never
   show a broken or empty booking area.**
4. **Load behaviour:** load the widget script lazily (on viewport intersection or on click), never
   render-blocking. Third-party scripts are consent-gated — see Section 8.
5. **CTA copy, consistent everywhere:** `Umów wizytę` (primary),
   `Umów wizytę online` (hero only), `Zadzwoń` (secondary). Never mix in "Zarezerwuj",
   "Rezerwuj termin", "Book now".
6. **Mobile sticky bar:** on doctor and service pages, a bottom bar with `Umów wizytę` + `Zadzwoń`,
   appearing after the hero scrolls out.
7. **Click tracking:** fire a `book_click` event with `{ doctorSlug, source }` through a thin
   `analytics.track()` wrapper — so the client can later plug in GA4/Plausible without touching
   components.

---

## 6. Editability — hard requirement

The client is non-technical and must be able to change prices, add a doctor, and fix a typo
**without touching a component file**.

**Rule: zero hardcoded user-facing strings in components. All content comes from one place.**

```
src/content/
  clinic.js       # nazwa, adres, telefon, e-mail, godziny, dane rejestrowe, znanylekarz
  doctors.js      # tablica lekarzy
  services.js     # usługi zgrupowane po specjalizacji
  pricing.js      # cennik + lastUpdated
  pages.js        # nagłówki, teksty sekcji, meta title/description
```

Requirements for these files:
- **Polish key names and Polish comments** at the top of each file explaining exactly how to add an
  entry, with one filled-in example above the real data.
- Flat, obvious shapes. No nesting deeper than 2 levels. No IDs the client has to keep in sync
  manually beyond `slug`.
- Every optional field explicitly marked, and the UI must render correctly when it is `""` or absent
  (no photo, no bio, no ZnanyLekarz link, no price).
- A doctor object should look roughly like:
  ```js
  {
    slug: "anna-nowak",              // adres URL: /specjalisci/anna-nowak
    imie: "Anna", nazwisko: "Nowak",
    tytul: "dr n. med.",
    specjalizacje: ["ortopedia"],     // musi pasować do specjalizacji w services.js
    zdjecie: "/img/lekarze/anna-nowak.jpg", // opcjonalne
    opis: "…",                        // opcjonalne
    doswiadczenie: ["…", "…"],        // opcjonalne
    znanylekarzUrl: "https://…",      // opcjonalne — fallback: profil placówki
    wyswietlNaStronieGlownej: true
  }
  ```
- Add a `KONTENT.md` at the project root: a short, screenshot-friendly guide in Polish covering
  *"jak dodać lekarza"*, *"jak zmienić cenę"*, *"jak zmienić godziny otwarcia"*, and *"czego nie ruszać"*.
- Include a **validation step** (build-time or a `npm run sprawdz-tresc` script) that catches the
  realistic mistakes: a doctor referencing a non-existent specialty, a duplicate slug, a malformed
  price, a broken JS comma. Errors must print in Polish and name the file and line.

**Migration path (document in the README, do not build now):** the content files are shaped so they
can be swapped for a headless CMS later — Decap CMS (git-based, free, no server, editing via a web
panel) is the natural next step, with Sanity or Strapi if the client outgrows it. Keep the data
shapes CMS-friendly from day one.

---

## 7. Technical requirements

- **Stack:** React + Vite + Tailwind, or plain static HTML/CSS/JS if the client's hosting is
  simple. Static output either way — no server, no database. State the choice and why.
- **Responsive:** 360px → 1920px. Test at 360, 390, 768, 1280, 1440.
- **Accessibility — WCAG 2.1 AA, treat as non-negotiable** (older patient base, and it's a health
  service): semantic landmarks, one `<h1>` per page, logical heading order, visible keyboard focus,
  contrast ≥ 4.5:1 for body text, alt text on all images, tap targets ≥ 44×44px, `lang="pl"`,
  form labels tied to inputs, no information conveyed by colour alone.
- **Performance:** Lighthouse ≥ 90 on all four scores. LCP < 2.5s. Images as WebP with explicit
  width/height, lazy-loaded below the fold. Self-host fonts with `font-display: swap`, subset to
  Latin Extended.
- **SEO:**
  - Unique `<title>` and `<meta description>` per page, from `pages.js`.
  - Local-SEO oriented copy: `{{specjalizacja}} Warszawa {{dzielnica}}` used naturally in H1/H2,
    never keyword-stuffed.
  - `sitemap.xml`, `robots.txt`, canonical URLs, Open Graph + Twitter cards.
  - **JSON-LD:** `MedicalClinic` (with `address`, `geo`, `openingHoursSpecification`, `telephone`)
    on the homepage and contact page; `Physician` on each doctor page; `BreadcrumbList` on subpages.
    Generate it from the content files so it never drifts out of sync.
- **Browser support:** last 2 versions of Chrome, Safari, Firefox, Edge, plus iOS Safari.
- **404 page** in Polish, with links back to `/specjalisci` and `/kontakt`.
- **No external calls at runtime** other than the ZnanyLekarz widget and (consent-gated) the map.

---

## 8. Legal and compliance (Poland)

Build these in; flag anything you're unsure about rather than guessing.

- **RODO/GDPR:** cookie consent banner that **blocks non-essential scripts until consent is given**
  (analytics, map, and the ZnanyLekarz widget if it sets cookies). Reject must be as easy as accept —
  equally prominent buttons, no dark patterns. Consent stored, re-openable from the footer.
- **Required pages:** `Polityka prywatności` and `Klauzula informacyjna RODO` (administrator, purposes,
  legal basis, retention, patient rights, IOD contact if appointed). Generate a structured **draft with
  clearly marked gaps** — state plainly in the output that the final text must be reviewed by the
  clinic's lawyer or IOD.
- **Legal entity data in the footer:** full company name, address, NIP, REGON, and the RPWDL
  registration number with the registering authority (`Podmiot wpisany do Rejestru Podmiotów
  Wykonujących Działalność Leczniczą prowadzonego przez Wojewodę Mazowieckiego, nr księgi …`).
- **Advertising restrictions:** Polish law limits how medical services may be promoted — content must
  read as *information about the scope of services*, not as advertising. Practically this means:
  no superlatives (`najlepszy`, `nr 1`, `lider`), no discount/promotional framing, no guarantees of
  outcome, no comparisons to other clinics, no patient testimonials or before/after photos.
  This constrains copy on every page — apply it as you write, not as a final pass.
- **Prices:** the `nie stanowi oferty` footnote from Section 3.5 is mandatory.
- **Do not fabricate:** doctor credentials, PWZ numbers, certifications, awards, review counts,
  patient numbers, years in operation. Missing data → `<!-- TODO: uzupełnić -->`.

---

## 9. Copywriting rules (Polish)

- Address the patient with **Pan/Pani** or neutral impersonal forms. Never `Ty` — wrong register for
  a Warsaw medical clinic.
- Plain Polish over medical jargon; where a clinical term is necessary, gloss it in one clause.
- Verbs over nouns: `Umów wizytę`, not `Umawianie wizyt`.
- Buttons keep the same wording as the outcome they produce.
- Sentence case in UI. No exclamation marks. No emoji.
- Empty states are invitations: `Nie znaleziono usługi. Sprawdź inną specjalizację lub zadzwoń: {{phone}}`.
- Errors say what happened and what to do next, in the interface's voice.
- Reuse copy from `{{current_website}}` where it's accurate — but rewrite anything that reads as
  advertising (Section 8) or as filler.

---

## 10. Build order

1. Design tokens + a single component showcase page — **stop and get approval.**
2. Content file skeletons with 2–3 real example entries each.
3. Homepage — **stop and get approval.**
4. `/specjalisci` + doctor template.
5. `/uslugi` + `/cennik`.
6. `/kontakt`, legal pages, 404.
7. SEO, JSON-LD, consent banner, analytics wrapper.
8. `KONTENT.md`, `README.md`, content validation script.
9. Final pass: Lighthouse, keyboard-only walkthrough, 360px check, all-links check.

After each page, briefly self-critique against Section 4's anti-brief before moving on.

---

## 11. Definition of done

- [ ] `Umów wizytę` reachable within one scroll on every page, on mobile and desktop.
- [ ] Booking area never renders empty — fallback chain (widget → doctor link → facility link →
      phone) verified by emptying `widgetScript`.
- [ ] Adding a doctor, changing a price, and editing opening hours each require touching exactly
      one content file — verified by doing all three.
- [ ] Zero user-facing strings hardcoded in components (grep for Polish diacritics outside `content/`).
- [ ] Lighthouse ≥ 90 across all four categories on `/` and `/cennik`.
- [ ] Full keyboard navigation with visible focus; site usable at 200% zoom.
- [ ] All Polish diacritics render correctly in both typefaces, including in headings and buttons.
- [ ] No non-essential third-party script fires before consent.
- [ ] No invented facts anywhere; every gap marked `TODO: uzupełnić`.
- [ ] Copy contains no superlatives, testimonials, or outcome guarantees (Section 8).
- [ ] `KONTENT.md` written in Polish and understandable by a non-technical reader.

---

## 12. Open questions to raise before building

If any of these are unresolved, ask rather than assume:

1. Where will it be hosted, and does the client have a preference (Vercel/Netlify vs. existing Polish
   hosting)? This decides static-HTML vs. React.
2. Do real photos of the doctors and the clinic interior exist, and are they cleared for use?
3. Does every doctor have an individual ZnanyLekarz profile, or only the facility?
4. Is the existing logo usable, or is a refresh in scope?
5. Should old URLs be preserved with redirects to protect existing search rankings?
6. Is the price list final and dated?
7. Is there an appointed IOD (Data Protection Officer) whose contact must appear in the RODO clause?
