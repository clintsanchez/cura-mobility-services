# Cura Mobility Services, LLC — NEMT Local SEO / Map Pack Research
Baton Rouge, LA metro | Prepared 2026-09-22 | Free/logged-out sources only

## Research method & tool limitations (read first)

This research was constrained to logged-out, free fetching. What actually worked vs. didn't:

- **Worked:** BBB business search (`bbb.org/search`) returned real, current business records (name/address/phone) for the "medical transportation" + "Baton Rouge, LA" query. This is the primary new data source in this report.
- **Did not work / blocked:** Google Search and Google Maps (JS-rendered, bot-walled, returns only shell/consent HTML to a non-JS fetch), Bing Search (returned dictionary/nav content, no local pack), DuckDuckGo HTML (CAPTCHA), Yelp (403 Forbidden), Facebook business pages (JS shell only), 211.org routes to LA-the-state-of-California by default rather than Louisiana, LDH.la.gov NEMT page (403), capitalareaaging.org (DNS not found — likely wrong/defunct domain).
- **No Playwright/browser-automation available in this environment** (not installed; installing browser binaries was out of scope for this pass), so I could not render JS map-pack results directly.
- **Conclusion:** I could **not independently re-verify live star ratings, review counts, or current map-pack rank order** for the 8 competitors named in the brief. Where the brief's 2026-09-22 baseline numbers are used below, they are carried forward **as-given and marked [UNCONFIRMED — carried from brief, not independently re-fetched]**, not re-confirmed by this pass. New facts actually pulled from BBB are marked [BBB-VERIFIED].
- Recommend a follow-up pass with either (a) DataForSEO/SERP API access, or (b) a logged-in/rendered browser tool, to get a true live local-pack screenshot and current GBP category strings before the client's launch date.

---

## 1. Local pack snapshot — competitor landscape

### 1a. Baseline from brief (2026-09-22), carried forward, NOT re-verified live

| Rank (as reported) | Business | Rating / Reviews | Notes |
|---|---|---|---|
| 1 | Hammond Medical Transportation LLC | 4.5★ / 33 | Category leader per brief |
| — | Reliant On Call | 1.9★ / 35 | High volume, poor rating |
| — | Lagarde's Medical Transportation | 2.0★ / 2 | Thin review base |
| — | Purple Love Transportation | 4.1★ / 9 | |
| — | St. Michael's Medical Transport | 0 / 0 | No reviews |
| — | Secure Patient Delivery | 0 / 0 | No reviews |
| — | MTK Transportation | 1.0★ / 1 | |
| — | Exquisite Transportation | 5.0★ / 3 | Perfect but thin |

All ratings/counts, hours, GBP categories, and address-vs-service-area status for this table are **[UNCONFIRMED]** — I could not reach Google Maps/Search to re-pull them this session.

### 1b. New/confirmed data — BBB search "medical transportation," Baton Rouge, LA [BBB-VERIFIED]

BBB's business search surfaced a **broader competitor set than the brief's 8**, several of which don't appear in the brief's list — worth checking directly on Google before launch since they may also hold map-pack positions:

| Business | Address | Phone | In brief's list? |
|---|---|---|---|
| Hammond Medical Transportation, LLC | 9111 Interline Ave, Baton Rouge, LA 70809-1979 | (225) 444-5592 | Yes (rank #1) |
| Stick With Us Medical Transportation LLC | 4724 Lemonwood Dr, Baton Rouge, LA 70805 | (225) 302-8463 | **No — new find** |
| One Call Medical Transportation, LLC | 2156 Wooddale Blvd, Ste 140B, Baton Rouge, LA 70806 | (225) 323-7405 | **No — new find** |
| Empathy Medical Transportation LLC | Baton Rouge, LA 70816 (no street shown) | (504) 234-3141 | **No — new find** |
| Tender Kare Transport, LLC | 11603 Newcastle Ave, Ste B, Baton Rouge, LA 70816 | (225) 218-4803 | **No — new find** |
| ACW Medical Transportation, LLC | 10795 Mead Rd, Baton Rouge, LA 70816 | (225) 610-5630 | **No — new find** |
| Capital City Transportation | 3217 Toronto Dr, Baton Rouge, LA 70819 | (225) 268-3163 | **No — new find** (general, not confirmed medical-only) |
| Cotton's Transportation, LLC | 16018 Somersby Ave, Baton Rouge, LA 70817 | (225) 888-5611 | **No — new find** (general, not confirmed medical-only) |

Notes on this table:
- Direct BBB profile pages (e.g., Hammond's own BBB profile) 404'd when fetched directly, so I could not pull BBB rating/accreditation letter grades — only the base directory listing came through.
- "Empathy Medical Transportation LLC" showing no street address on a public directory is a signal it may already be running as **service-area / hidden-address on GBP** — same posture Cura should consider.
- None of the 5 "new finds" (Stick With Us, One Call, Empathy, Tender Kare, ACW) were in the brief's map-pack snapshot — they may rank for different query variants (e.g., "medical transportation near me," "dialysis transportation"), may be newer/lower-volume, or may simply not have claimed/optimized GBP profiles yet. **Action:** re-check all 4 target queries in the brief against this expanded competitor set once live SERP access is available.

### 1c. Query-specific behavior to expect (based on general local-pack mechanics, not directly re-verified per query)

- **"non emergency medical transportation baton rouge"** and **"medical transportation baton rouge"** — near-identical intent; Hammond likely dominant per brief.
- **"wheelchair transportation baton rouge"** — a narrower vertical query. None of the 8 brief competitors nor the BBB list have "wheelchair" in the business name, meaning the local pack for this query is more winnable if Cura's GBP has "wheelchair accessible transportation" explicitly as a category/service/attribute and its name/description use that exact phrase (without keyword-stuffing the business name itself).
- **"medical transportation near me"** — heavily proximity- and category-weighted (see Whitespark/Search Atlas factors below); a hidden-address SAB profile is still eligible for the local pack but Google will use the coarser service-area centroid for ranking distance, putting Cura at a structural disadvantage against brick-and-mortar competitors near the searcher unless review/category signals compensate.
- **"dialysis transportation baton rouge"** — a valuable, lower-competition long-tail; worth a dedicated GBP "service" entry and a dedicated website service page (see #4).

---

## 2. GBP setup recommendation for Cura Mobility Services, LLC

### Business type & profile configuration
- **Configure as Service-Area Business (SAB) with hidden address.** Given the unresolved address situation (residential Baton Rouge apartment + St. Francisville road address), a hidden-address SAB avoids two real risks: (a) Google flags/suspends listings where the address doesn't match a legitimate, staffed commercial location ("virtual office"/residential mismatch is a classic suspension trigger), and (b) NEMT is inherently a "we come to you" service — SAB is the accurate model.
- Do **not** list the residential apartment as a public/pinned address. If either address becomes a genuine dispatch/office location later (staffed, signage, in-person visits), that's the point to reconsider brick-and-mortar or hybrid.
- **Service areas:** Set by city/parish, not by driving-radius circles (Google's own guidance discourages radius-only definitions and caps how far out listings should reasonably serve). Recommended starting set, centered on Baton Rouge:
  - East Baton Rouge Parish (core)
  - Ascension Parish
  - Livingston Parish
  - West Baton Rouge Parish
  - Iberville Parish
  - Pointe Coupee Parish (bridges toward St. Francisville/West Feliciana if that becomes a real operating base)
  - West Feliciana Parish (if St. Francisville address becomes operational)
  - **Do not exceed Google's stated limit** — GBP does not enforce a hard numeric cap on service-area places, but Google's help documentation advises keeping the service area to where the business is genuinely willing to send staff/vehicles same-day; an overly sprawling list (e.g., half of Louisiana) is itself a spam/quality signal and dilutes relevance. Recommend starting with the ~5-6 parishes above and expanding only as vehicle/driver capacity actually supports it. [Google's exact current UI limit on number of areas should be re-checked at setup time — it has changed over past product cycles.]

### Primary category — most important single decision
Real, current Google category names to verify at setup (category names/availability are periodically revised by Google, so re-check in the live GBP category picker at onboarding):
- **Primary (recommended): "Non-emergency medical transportation service"** — if unavailable in the live picker for the account's country/language, fall back to **"Medical transportation service."** [UNCONFIRMED which of the two currently populates for US English accounts — verify in the live GBP setup flow, as this is the single highest-weighted ranking factor per Whitespark's 2026 factor study, and choosing the wrong one is the #1 negative factor.]
- **Do not** primary-category as generic **"Transportation service"** — too broad, dilutes relevance versus named competitors who (per BBB naming conventions above) are clearly positioned as medical-specific.

### Secondary categories (add only what's genuinely true of services offered)
- Wheelchair transportation (if this exact category exists in picker — some GBP category sets have it; verify live)
- Ambulette service / Ambulance service — **only if actually licensed/equipped for that tier**; do not add for perceived SEO benefit if not licensed, this is a compliance and Google-quality-signal risk
- Airport shuttle service (only if genuinely offered)
- Wheelchair rental / Disability services and support organization — assess fit case by case, don't add categories the business doesn't perform

### Business name
- Use the exact legal name, **"Cura Mobility Services"** (drop "LLC" per Google guidelines unless it's part of the branded, on-signage name) — do **not** append descriptors like "Cura Mobility Services - Non Emergency Medical Transportation Baton Rouge." Keyword-stuffed GBP names are both against Google's guidelines and a common cause of suspension/rejection for new profiles, and several of the weak competitors in the map pack (e.g., "Reliant On Call," "St. Michael's Medical Transport") show naming isn't what's driving current rank — reviews and category are.

### Suspension risk factors specific to Cura's situation (new SAB, residential/unclear address)
1. **Address verification mismatch:** if the verification postcard/video call reveals a residential unit with no visible signage or dedicated commercial use, Google can still approve the SAB (hidden address is allowed for a home-based service business) but will likely **reject the address as a legitimate business location** if Cura ever tries to show it publicly or if it's flagged in a spam report by a competitor — a real risk given how competitive and complaint-prone the local NEMT space is.
2. **New-listing scrutiny + industry sensitivity:** healthcare-adjacent categories get extra scrutiny; missing/incomplete licensing info, no working phone answer, or a website that doesn't match the claimed service can trigger suspension on a new profile faster than in less-regulated verticals.
3. **Zero-content, thin-profile suspension bait:** launching with no photos, no description, no services list, and immediately buying/soliciting reviews in bulk is a common self-inflicted suspension trigger for brand-new profiles — pace review acquisition (see #4) rather than front-loading.
4. **Duplicate/competitor overlap:** given how many similarly-named LLCs exist in this space locally (per the BBB list), watch for any prior GBP listing under a variant of "Cura" or a predecessor entity claiming the same phone number — duplicate-listing conflicts are a common source of suspension appeals.
5. **NAP consistency from day one:** because two addresses are on record (Baton Rouge apartment, St. Francisville road address) and neither may be the "true" business address, pick and consistently use **one** phone number and **one** legal business name across GBP, website, and every citation from the start — inconsistent NAP is flagged in the current Whitespark factor set as a real (if smaller) ranking drag, and it's compounding risk for suspension review if Google's automated matching sees conflicting signals.

### Services list to add in GBP (map directly to future website service pages — see priority action below)
- Non-emergency medical transportation (general)
- Wheelchair-accessible transportation
- Dialysis appointment transportation
- Doctor's office / specialist appointment transportation
- Hospital discharge transportation
- Ambulatory / stretcher transport (only if equipped)
- Long-distance / out-of-parish medical transport (if offered)

---

## 3. Citation plan — top ~20 sources for Louisiana NEMT

### Tier 1 general (do these first — foundational, free, no licensing proof required)
1. **Google Business Profile** — foundational, not a "citation" per se but the anchor record
2. **Apple Business Connect** — free, growing importance for Apple Maps/Siri/CarPlay discovery
3. **Bing Places for Business** — free, feeds Bing + Copilot answers
4. **Facebook Business Page** — free; also functions as a review/social-proof surface
5. **Yelp** — free basic listing (claim, don't need paid ads)
6. **BBB (Better Business Bureau)** — free basic listing; accreditation is paid, but even the unaccredited profile is a citation/trust signal [confirmed BBB does index Baton Rouge medical-transportation businesses without needing accreditation — see Section 1b]
7. **Nextdoor Business Page** — free, hyperlocal, strong for neighborhood/home-services and eldercare-adjacent trust

### Tier 1 industry / health-specific (highest relevance for NEMT + AI-visibility per the brief's cited factor research)
8. **Louisiana 211 (Louisiana United Way 211 database)** — confirm correct current domain (the generic `211.org` routes elsewhere; Louisiana's 211 is typically reached via `unitedwayla.org`/`211.org` state-specific routing or `getconnected` platforms — **[UNCONFIRMED — could not resolve during this pass, verify exact submission portal before executing]**). High-value because caseworkers, hospital discharge planners, and family caregivers search here directly for transport resources.
9. **Governor's Office of Elderly Affairs (GOEA) / Louisiana Area Agencies on Aging resource directories** — Capital Area Agency on Aging serves the Baton Rouge region specifically; the domain I attempted (capitalareaaging.org) did not resolve — **verify the correct current domain before submission**, likely under `goea.louisiana.gov` regional agency links.
10. **FindHelp.org (formerly Aunt Bertha)** — free social-care resource directory used heavily by hospital discharge planners and case managers; searchable by zip + category including transportation.
11. **Louisiana Department of Health (LDH) NEMT provider/enrollment listings** — not a marketing citation per se, but Medicaid enrollment as an NEMT provider (if pursued) generates a de facto authoritative citation via LDH provider lists. LDH's NEMT page returned 403 on direct fetch this session — revisit via a browser, not raw fetch.
12. **Healthgrades-style provider directories** (Healthgrades itself is more physician-focused, but its transportation/ancillary-services adjacent directories and similar sites like WebMD Care, Caring.com "senior transportation" directories) — list under senior/caregiver transportation categories.
13. **Caring.com** — senior-care resource directory; has a transportation-services category, high organic visibility for "senior transportation [city]" queries.
14. **A Place for Mom — local resources/transportation partners** — referral network serving families arranging senior transport; worth a free/basic listing where available.
15. **Dialysis center resource/partner lists** — outreach to local **DaVita** and **Fresenius Kidney Care** center locations in Baton Rouge to be added to their patient transportation resource handouts/pages (not a self-service citation, but a high-intent, high-conversion local link/mention).
16. **Hospital discharge-planner resource lists** — Baton Rouge General, Our Lady of the Lake, Ochsner Baton Rouge, Baton Rouge Rehabilitation Hospital: request inclusion on any public/patient-facing "transportation resources" page they maintain (again, outreach-based, not self-serve).
17. **NEMT-specific industry directories** — e.g., NEMT.com-style provider directories and state NEMT broker network listings; Louisiana's Medicaid NEMT is administered through a managed broker model — **[UNCONFIRMED which broker currently holds the Louisiana contract; verify before assuming enrollment path]** — being listed in the broker's approved-provider directory (if Cura pursues Medicaid enrollment) is itself a strong, authoritative citation.

### Tier 2 general local/business directories (lower priority, still worth claiming)
18. **Chamber of Commerce (Baton Rouge Area Chamber)** — paid membership typically required for a listing, but often bundles a solid citation + local link.
19. **MapQuest** — free, still crawled/aggregated into some data feeds.
20. **Data aggregators — Data Axle / Foursquare / Neustar (Localeze)** — feed many downstream directories at once; free basic claim processes exist for some, others are paid tiers.

### Licensing / proof-of-enrollment gating — what to flag before submitting
- **LDH Medicaid NEMT provider enrollment** (if pursued): requires proof of vehicle licensing/insurance, driver background checks, and Louisiana-specific NEMT permitting — this is a prerequisite for being listed in the state's official broker provider directory (item 17) and likely for AAA/GOEA referral inclusion (item 9).
- **BBB accreditation** (optional, paid): not required to appear in BBB's basic search (confirmed — competitors appear without needing accreditation), but accreditation adds a badge/trust signal.
- **Chamber of Commerce** (item 18): typically a paid annual membership.
- **Hospital/dialysis center resource-page inclusion** (items 15-16): not a formal license check, but these organizations will informally vet a new provider (ask about insurance, vehicle inspection, driver credentials) before adding them to patient-facing materials — have that documentation ready before outreach.

---

## 4. Review velocity target to break into the Baton Rouge top 3

Working baseline (per brief, [UNCONFIRMED] but directionally reasonable): current #1 (Hammond) sits at 4.5★/33 reviews; the next-most-credible competitors are thin (Purple Love 4.1★/9, Exquisite 5.0★/3) with several others at 0-2 reviews or poor ratings (Reliant On Call 1.9★/35, Lagarde's 2.0★/2, MTK 1.0★/1).

**What this means for Cura, starting from zero:**
- **The bar to reach "top 3" is genuinely low on volume** — Cura doesn't need 33+ reviews to beat most of this field; it needs roughly **10-15 reviews at a 4.5-5.0★ average** to credibly outrank everyone except Hammond, since most competitors are stuck at single digits or actively damaged by 1-2★ averages.
- **To challenge for the #1 spot**, Cura should target **35-40+ reviews at 4.7★+** — enough volume to match/exceed Hammond's count while beating their average, combined with the category/schema/citation work above (since review count alone won't overcome a wrong primary category).
- **The 18-day rule is the binding constraint, not the total count.** Per Sterling Sky's research cited in the brief, rankings can cliff if a listing goes ~3 weeks without a new review — so the target isn't "get to 15 reviews once," it's **sustaining a minimum cadence of 1 new review every 2-3 weeks indefinitely**, i.e., roughly **2-3 reviews per month, forever**, not a one-time push.
- **Practical velocity plan for a brand-new NEMT provider:**
  - Month 1 (pre-/at-launch): 3-5 reviews from earliest riders, staggered over the month (not all on day one — a sudden burst on a zero-history profile is itself a spam-detection risk).
  - Months 2-3: sustain 2-4 reviews/month as ride volume ramps; this alone gets Cura to ~10-13 reviews by month 3, already ahead of most named competitors.
  - Ongoing: build a standing operational habit (e.g., a post-ride text/QR follow-up) that reliably produces 2-3 reviews/month indefinitely — this is what actually protects against the 18-day cliff long-term, more than any one-time campaign.
  - Response rate: respond to 100% of reviews (positive and negative) within 24-48 hours — review-response pattern is itself a tracked local-pack signal and costs nothing.

---

## Priority actions (for the audit/action-plan doc, not re-listed in full here)
1. **Critical:** Re-verify live Google local-pack results and exact current GBP category names with a rendered-browser or SERP-API tool before finalizing Cura's primary category choice — this session could not access live Maps data.
2. **Critical:** Resolve the address question before GBP setup — confirm hidden-address SAB is the intended configuration and that neither on-record address (Baton Rouge apartment, St. Francisville road) gets exposed publicly.
3. **High:** Set primary category to "Non-emergency medical transportation service" (or closest live equivalent) at GBP creation.
4. **High:** Build dedicated website service pages matching the GBP services list (dialysis transport, wheelchair transport, hospital discharge, etc.) — cited in the brief as the #1 local-organic and #2 AI-visibility factor.
5. **High:** Stand up the review-request workflow (post-ride SMS/QR) before or at launch so review velocity starts immediately and doesn't gap.
6. **Medium:** Submit Tier 1 general citations (GBP, Apple Business Connect, Bing Places, Facebook, Yelp, BBB, Nextdoor) with locked, final NAP.
7. **Medium:** Confirm current Louisiana 211 submission portal and Capital Area Agency on Aging correct domain (both failed to resolve this session) and submit.
8. **Medium:** Pursue LDH Medicaid NEMT enrollment path if applicable to the business model — unlocks the state broker provider directory citation and hospital/AAA referral eligibility.
9. **Low:** Outreach to local dialysis centers (DaVita, Fresenius) and hospitals (Baton Rouge General, OLOL, Ochsner BR) for resource-page inclusion once licensing/insurance documentation is ready.
10. **Low:** Monitor the 5 BBB-surfaced competitors not in the original brief's map-pack list (Stick With Us, One Call, Empathy, Tender Kare, ACW) in the next live SERP check — they may be relevant, currently-unranked, or ranking for query variants not yet checked.

---

### Sources
- BBB business search: `https://www.bbb.org/search?find_country=USA&find_text=medical+transportation&find_loc=Baton+Rouge%2C+LA` (fetched 2026-09-22)
- Brief-provided 2026-09-22 map-pack snapshot (client-supplied, not independently re-verified this session)
- Attempted, blocked/unresolved: google.com/search, google.com/maps, bing.com/search, html.duckduckgo.com, yelp.com (403), facebook.com (JS shell), bbb.org individual profile page (404), ldh.la.gov/page/nemt (403), capitalareaaging.org (DNS failure), 211.org (resolved to LA-California, not Louisiana)
- General GBP/local-SEO mechanics (category weighting, SAB service-area guidance, suspension patterns, review-velocity/18-day-rule framing) drawn from established local-SEO practice and the factor research cited in the task brief (Whitespark 2026, Sterling Sky, Search Atlas) — not independently re-fetched this session; treat vertical-specific claims (exact current GBP category name availability, exact Google service-area limits, current Louisiana Medicaid NEMT broker) as **[UNCONFIRMED]** until checked live.
