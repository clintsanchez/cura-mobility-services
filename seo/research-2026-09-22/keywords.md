# Cura Mobility Services — Keyword Research (Baton Rouge NEMT)

Compiled 2026-09-22. Free-source only (Google autocomplete via
`suggestqueries.google.com`, WebSearch/SERP snapshots, no paid SEO API).
**No search-volume numbers are invented anywhere in this doc** — all "demand
proxy" values are relative labels derived from autocomplete presence/position
or repeated appearance across queries, per the task's ground rules.

---

## 0. Method & limitations

- **Autocomplete**: fetched `suggestqueries.google.com/complete/search?client=firefox&q=...`
  for ~10 seed variants. Google's suggest endpoint returned a genuine, unranked
  list per query (position in the returned array is used as a rough proxy for
  "depth" — first 2-3 = high, rest = low — this is NOT a volume number).
- **PAA / related searches**: approximated via WebSearch result summaries,
  which surface some "People Also Ask"-style facts but not the literal PAA
  question list Google shows in-SERP. Treat informational-intent questions
  below as representative, not exhaustive/verbatim scraped PAA.
- **Google Trends**: not reachable in this environment (no interactive/JS
  fetch); relative-interest data is *not* included. This is a known gap —
  recommend a manual Trends pull (geo: Louisiana / Baton Rouge DMA) before
  finalizing content priority.
- **SERP overlap**: assessed qualitatively from the WebSearch result sets
  captured for ~9 queries (URLs returned, not a true 10-blue-links scrape with
  ranking positions — WebSearch is a synthesized/AI layer over search, so
  overlap counts below are directional, not exact rank-for-rank matches).
- **Unconfirmed service/status flags** used throughout:
  - `[UNCONF-SVC]` = depends on a service Cura hasn't confirmed offering
    (wheelchair, stretcher, ambulatory-only, dialysis-specific, long-distance).
  - `[UNCONF-PAY]` = depends on unconfirmed payer status (Medicaid broker
    enrollment with MediTrans/Verida, private-pay only, Medicare — note
    Medicare generally does NOT cover NEMT vans at all, only rare ambulance
    cases — see §4).
  - `[UNCONF-GEO]` = depends on an unconfirmed service city/parish.
  - `[MIXED-INTENT]` = query mixes NEMT-seeker intent with something else
    (jobs, van sales/rental, business-startup) — excluded from the page map
    but listed for negative-keyword/exclusion awareness.

---

## 1. Keyword table

### 1a. Core transactional-local (city/service combos)

| Keyword | Intent | Demand proxy | Flags |
|---|---|---|---|
| non emergency medical transportation baton rouge | transactional-local | High — top autocomplete result, appears across seed + all SERP pulls | — |
| non emergency medical transportation near me | transactional-local | High — autocomplete depth 1-2 on 2 seeds | — |
| medical transportation baton rouge | transactional-local | High — autocomplete + repeat SERP appearance | — |
| medical transportation near me | transactional-local | High — full autocomplete branch (10 suggestions) | — |
| medical transportation companies in baton rouge | transactional-local | Med — appears in SERP result titles (Yelp/BBB lists) | — |
| medical transportation baton rouge louisiana | transactional-local | Med — autocomplete position 2-3 | — |
| wheelchair transportation baton rouge | transactional-local | High — autocomplete + dedicated SERP | `[UNCONF-SVC]` wheelchair |
| wheelchair transportation near me | transactional-local | Med — autocomplete position 5 | `[UNCONF-SVC]` |
| wheelchair van baton rouge | transactional-local | Med — autocomplete "wheelchair vans baton rouge" pos 1 | `[UNCONF-SVC]`; SERP dominated by van *sales/rental* (Superior Van, AMS Vans), not ride services — `[MIXED-INTENT]` risk |
| wheelchair vans baton rouge | transactional-local | Med — same as above | `[UNCONF-SVC]`, `[MIXED-INTENT]` risk (sales vs. rides) |
| handicap vans baton rouge | transactional-local | Low-med — autocomplete pos 3 | `[UNCONF-SVC]`, `[MIXED-INTENT]` (van sales) |
| wheelchair accessible van taxi near me | transactional-local | Low — autocomplete tail | `[UNCONF-SVC]` |
| wheelchair transportation rates | commercial | Med — in seed list + autocomplete | `[UNCONF-SVC]` |
| medicaid transportation baton rouge | transactional-local | High — full autocomplete branch, recurring in SERPs | `[UNCONF-PAY]` |
| medicaid transportation near me | transactional-local | Med — autocomplete pos 4 | `[UNCONF-PAY]` |
| medicaid transportation phone number near baton rouge la | informational/navigational-ish | Med — autocomplete pos 2 | `[UNCONF-PAY]` — likely wants broker number (Verida/MediTrans), not Cura |
| aetna medicaid transportation phone number near baton rouge la | navigational | — (excluded per intent rule) | `[UNCONF-PAY]` — payer-specific, excluded |
| louisiana medicaid transportation number | navigational | — (excluded) | excluded |
| how to get medicaid transportation | informational | Med — autocomplete tail | `[UNCONF-PAY]` |
| non emergency medical transportation louisiana | transactional/commercial | Med — seed + repeated in SERPs (MediTrans, LDH) | — |
| medical transportation louisiana | transactional/commercial | Med | — |
| dialysis transportation baton rouge | transactional-local | Med-high — autocomplete branch + seed | `[UNCONF-SVC]` (recurring/standing-order rides) |
| dialysis transportation near me | transactional-local | Med — autocomplete pos 4 | `[UNCONF-SVC]` |
| how to get transportation to dialysis | informational | Low-med — autocomplete tail | `[UNCONF-SVC]` |
| senior transportation baton rouge | transactional-local | Med — autocomplete top result | — |
| senior transportation near me | transactional-local | Med — autocomplete pos 4 | — |
| hospital discharge transportation baton rouge | transactional-local | Low-med — not in autocomplete, but SERP shows dedicated competitor pages (MedicalRide.org, National Healthcare Connect) | `[UNCONF-SVC]` (discharge timing/urgency) |
| doctor appointment transportation baton rouge | transactional-local | Low (constructed modifier; not autocompleted directly) | — |
| long distance medical transportation louisiana | transactional/commercial | Med — dedicated competitor sites nationally (Eastern Royal, Long-Distance-Medical-Transport.com, medic-trans.com) rank for Louisiana pages | `[UNCONF-SVC]` — long-distance/stretcher-adjacent, likely out of scope for a new local van company |
| airport medical transportation baton rouge | transactional-local | Low (constructed; no direct autocomplete/SERP signal found) | `[UNCONF-SVC]` |
| veterans medical transportation baton rouge | transactional-local | Low-med — real competing resource (DAV vans, VA beneficiary travel) | `[UNCONF-SVC]`/`[UNCONF-PAY]` — DAV/VA already owns this niche free; hard to compete/monetize |
| non emergency medical transportation denham springs | transactional-local | Low — bare autocomplete hit, no branch | `[UNCONF-GEO]` |
| non emergency medical transportation gonzales la | transactional-local | Low — bare autocomplete hit, no branch | `[UNCONF-GEO]` |
| non emergency medical transportation zachary la | transactional-local | Low (constructed, not autocompleted) | `[UNCONF-GEO]` |
| non emergency medical transportation prairieville la | transactional-local | Low (constructed) | `[UNCONF-GEO]` |
| non emergency medical transportation plaquemine la | transactional-local | Low (constructed) | `[UNCONF-GEO]` |
| non emergency medical transportation st francisville la | transactional-local | Low (constructed) | `[UNCONF-GEO]` — but matches client's own possible second base |
| non emergency medical transportation west feliciana parish | transactional-local | Low (constructed) | `[UNCONF-GEO]` |
| non emergency medical transportation ascension parish | transactional-local | Low (constructed) | `[UNCONF-GEO]` |
| non emergency medical transportation livingston parish | transactional-local | Low (constructed) | `[UNCONF-GEO]` |
| non emergency medical transportation port allen la | transactional-local | Low (constructed) | `[UNCONF-GEO]` |
| non emergency medical transportation baker la | transactional-local | Low (constructed) | `[UNCONF-GEO]` |
| non emergency medical transportation central la | transactional-local | Low (constructed) | `[UNCONF-GEO]` |
| private pay medical transportation baton rouge | transactional-local | Low-med (constructed; matches "private-pay" segment seen in SERP — MedicalRide.org) | `[UNCONF-PAY]` |
| same day medical transportation baton rouge | transactional-local | Low (constructed) | `[UNCONF-SVC]` (same-day capacity unconfirmed for brand-new fleet) |
| weekend medical transportation baton rouge | transactional-local | Low (constructed) | `[UNCONF-SVC]` |
| ambulatory transportation baton rouge | transactional-local | Low-med — matches MedicalRide.org's "Ambulatory transport in Baton Rouge" page | `[UNCONF-SVC]` (confirm ambulatory is the confirmed core service) |
| stretcher transportation baton rouge | transactional-local | Low — appears only via National Healthcare Connect competitor listing | `[UNCONF-SVC]` — stretcher explicitly "unknown" per brief |

### 1b. "Near me" / near-me variants worth targeting via GBP + local pages

| Keyword | Intent | Demand proxy | Flags |
|---|---|---|---|
| medical transportation near me for seniors | transactional-local | Med — autocomplete pos 4 of "medical transportation near me" branch | — |
| medical transportation near me open now | transactional-local | Low-med — autocomplete pos 7 | — |
| medical transport near me | transactional-local | Med — autocomplete variant spelling, pos 9 | — |
| medical transportation near me within 5 mi / within 20 mi | transactional-local | Low — autocomplete tail, radius-intent (GBP/map-pack signal, not a page target) | — |

### 1c. Commercial (comparison/evaluation, pre-purchase)

| Keyword | Intent | Demand proxy | Flags |
|---|---|---|---|
| best medical transportation baton rouge | commercial | Low-med (constructed; Yelp/BBB "best of" lists rank here) | — |
| medical transportation reviews baton rouge | commercial | Low (constructed) | — |
| wheelchair van rental baton rouge | commercial/`[MIXED-INTENT]` | Med — autocomplete hit | `[UNCONF-SVC]` — this is van *rental for self-drive*, not a ride service; exclude from ride-service pages, flag for possible separate note |
| handicap van rental baton rouge | commercial/`[MIXED-INTENT]` | Low-med — autocomplete hit | exclude |
| how to get a wheelchair van for free | informational/`[MIXED-INTENT]` | Low — autocomplete tail | exclude (grant/nonprofit topic, not Cura's service) |

### 1d. Informational (blog/FAQ targets)

| Keyword | Intent | Demand proxy | Flags |
|---|---|---|---|
| how much does non emergency medical transportation cost | informational | Med-high — rich SERP with dedicated rate-guide competitors (Ecolane, Call The Care, DreamCareRides) | — |
| how much does NEMT cost | informational | Med (seed) | — |
| wheelchair transportation rates | informational/commercial crossover | Med (seed) | `[UNCONF-SVC]` |
| does medicare pay for non emergency medical transportation | informational | High — very rich, authoritative SERP (Medicare.gov, AARP, Humana) | — |
| will medicare pay for NEMT | informational | Med (seed variant) | — |
| does medicaid cover non emergency medical transportation | informational | Med-high (parallel to Medicare query; strongly implied by LA Medicaid SERP results) | `[UNCONF-PAY]` |
| how to get NEMT in Louisiana | informational | Med (seed) | — |
| how to get medical transportation on louisiana medicaid | informational | Med — matches ranking competitor (Nest Health blog) directly | `[UNCONF-PAY]` |
| louisiana medicaid transportation phone number | informational (borderline navigational) | Med — resolved to Verida 1-855-325-7626 (FFS) / plan-specific numbers (MCO) in SERP | `[UNCONF-PAY]` — do not publish a client phone number here; this is a broker lookup query |
| how to get transportation to dialysis | informational | Low-med (autocomplete) | `[UNCONF-SVC]` |
| free transportation baton rouge | informational | Med — real, well-served competing answer set (EBRCOA Lotus Rides, ACS Road to Recovery, findhelp.org) | — |
| free transportation for seniors baton rouge medical appointments | informational | Med (constructed variant of above, same SERP) | — |
| veterans transportation to VA appointments baton rouge | informational | Med — DAV/VA own this space heavily | `[UNCONF-SVC]` |
| what is non emergency medical transportation | informational | Med (foundational definition query, implied by CMS.gov ranking) | — |
| what's the difference between ambulatory and wheelchair transport | informational | Low-med (constructed, matches rate-guide competitor content structuring by tier) | `[UNCONF-SVC]` |
| how far in advance do I need to book medicaid transportation | informational | Med — directly answered in SERP (48-hour rule, excludes weekends/holidays) | `[UNCONF-PAY]` |
| how to become a medicaid transportation provider in louisiana | informational | Med — real, well-ranked topic (Verida/MediTrans provider enrollment) | **Explicitly excluded per brief** (provider-application/how-to-start-a-business content) |

### 1e. Excluded / negative-keyword noise (per brief)

| Keyword | Reason excluded |
|---|---|
| how to start a wheelchair transportation business | business-startup, excluded |
| how do i start a wheelchair transportation business | business-startup, excluded |
| how to start my own senior transportation business | business-startup, excluded |
| medical transportation jobs baton rouge | jobs, excluded |
| non emergency medical transportation jobs | jobs, excluded |
| wheelchair van rental / handicap van rental (baton rouge) | van rental/purchase, `[MIXED-INTENT]`, excluded from ride-service pages |
| wheelchair vans for lease near me | van rental, excluded |
| how to get a wheelchair van for free | grant/nonprofit info, not a service page, excluded |
| NEMT provider requirements / Request for Qualifications (Verida/MediTrans) | provider-application content, excluded per brief |
| aetna medicaid transportation phone number near baton rouge la | navigational to a payer, excluded |
| louisiana medicaid transportation number | navigational, excluded |

**Count of clustering-eligible keywords (1a–1d, minus excluded): ~62.** Combined
with near-me/radius variants and constructed parish modifiers this reaches the
~100+ target when every parish/city combination is expanded (7 parishes × 2-3
service modifiers each ≈ 40 more long-tail rows not each individually tabled
above to avoid redundancy — see §3 city page list).

---

## 2. SERP overlap notes (top transactional terms)

Based on WebSearch result sets captured (directional, not rank-verified):

| Pair | Shared domains observed | Read |
|---|---|---|
| "non emergency medical transportation baton rouge" vs "medical transportation companies in baton rouge" | Uber Health, brla.gov, Yelp, BBB-style list, MediTrans — 3-4 shared | Same cluster, likely same pillar page (service overview) — **do not split into two separate pages**, would cannibalize |
| "non emergency medical transportation baton rouge" vs "medicaid transportation baton rouge la" | brla.gov, MediTrans/LDH-family docs — 2 shared, otherwise diverges into Medicaid-specific government/broker pages | Interlink, not same page — Medicaid page should be a distinct FAQ/spoke, not folded into the main service page |
| "wheelchair transportation baton rouge" vs "wheelchair van baton rouge" | 0 shared in captured results — wheelchair van pulls van-sales/rental sites (Superior Van, AMS Vans), wheelchair transportation pulls ride-service sites (WE LIFT, Freedmans Health) | **Separate intent** — treat "wheelchair van baton rouge" as contaminated by sales/rental competitors; target "wheelchair transportation baton rouge" / "wheelchair transportation service" phrasing instead, and avoid bare "van" head terms in title tags |
| "dialysis transportation baton rouge" vs "medical transportation baton rouge" | Same seed autocomplete branch, but SERP not independently re-pulled for dialysis-baton-rouge exact phrase (autocomplete folded it under generic "medical transportation baton rouge" results) | Likely same cluster/interlink — dialysis is a use-case spoke off the core service pillar, not a fully separate SERP universe |
| "hospital discharge transportation baton rouge" vs "long distance medical transportation louisiana" | 1 shared domain (medicalride.org, different sub-pages) | Separate — different competitor set (discharge = local hospital-adjacent players; long-distance = a distinct national niche of stretcher/medical-escort companies) — recommend NOT building a long-distance page until stretcher/long-haul capability is confirmed |
| "how much does non emergency medical transportation cost" vs "wheelchair transportation rates" | 0 shared captured (cost query surfaces national rate-guide blogs; no baton-rouge-specific rate page exists yet in the SERP) | Opportunity gap — no strong local competitor owns "cost/rates" content for Baton Rouge; good pillar-adjacent blog target |
| "does medicare pay for non emergency medical transportation" vs "how to get medicaid transportation" | 0 shared (Medicare.gov/AARP/Humana vs. LDH/Louisiana Healthcare Connections/Nest Health) | Fully separate — Medicare and Medicaid are different payers with different answers; must be two distinct FAQ/blog posts, never merged (this is a common accuracy trap — see accuracy guardrail) |

**Cannibalization risk flagged:** "wheelchair van baton rouge" / "wheelchair vans baton rouge" should NOT be a primary target for a ride-service page — the current SERP for that phrase is owned by van dealerships (Superior Van & Mobility, AMS Vans), which is a different business model (selling/leasing accessible vehicles) than what Cura does (providing rides). Using it as a primary keyword risks confused intent-matching and wasted content effort.

---

## 3. Proposed hub-and-spoke page map

### Pillar / hub
**Home / Non-Emergency Medical Transportation in Baton Rouge (pillar service page)**
- Primary: `non emergency medical transportation baton rouge`
- Secondary: `medical transportation baton rouge`, `medical transportation near me`, `medical transportation companies in baton rouge`
- Notes: This is the page that should absorb the "companies/near me" overlap cluster identified in §2. Must state confirmed service area only (do not claim "statewide" until proven — accuracy guardrail).

### Service spokes (each = own page, 2-4 per cluster)

**Cluster A — Service type**
1. Ambulatory Transportation Baton Rouge — primary: `ambulatory transportation baton rouge` `[UNCONF-SVC — confirm this is the core offering before publishing]`
2. Wheelchair Transportation Baton Rouge — primary: `wheelchair transportation baton rouge`; secondary: `wheelchair transportation near me`, `wheelchair transportation rates` `[UNCONF-SVC]` — copy must avoid "van" as the lead noun per SERP-overlap finding above
3. Dialysis Transportation Baton Rouge — primary: `dialysis transportation baton rouge`; secondary: `dialysis transportation near me`, `how to get transportation to dialysis` `[UNCONF-SVC]`
4. (Hold) Stretcher Transportation — do not build until stretcher capability is confirmed; currently `[UNCONF-SVC]`, low autocomplete signal anyway

**Cluster B — Use case / occasion**
1. Senior Medical Transportation Baton Rouge — primary: `senior transportation baton rouge`; secondary: `senior transportation near me`, `medical transportation near me for seniors`
2. Doctor Appointment & Hospital Discharge Transportation — primary: `hospital discharge transportation baton rouge`; secondary: `doctor appointment transportation baton rouge` `[UNCONF-SVC]` (confirm discharge-timing/on-call capacity)
3. (Hold) Long-Distance Medical Transportation — do not build until long-distance/stretcher scope is confirmed; SERP is a distinct national-competitor niche per §2

**Cluster C — Payer / cost (high-accuracy-risk cluster — route through the accuracy guardrail before publishing any of these)**
1. Medicaid Transportation in Baton Rouge (FAQ/spoke, not a sales page) — primary: `medicaid transportation baton rouge`; secondary: `medicaid transportation near me`, `how to get medicaid transportation` `[UNCONF-PAY]` — content should explain the broker system (MediTrans for MCO plans, Verida for fee-for-service) and clarify whether Cura is/plans to be an enrolled provider; **do not publish a specific broker phone number as if it's Cura's**
2. Does Medicare Cover Non-Emergency Medical Transportation? (blog/FAQ) — primary: `does medicare pay for non emergency medical transportation`; secondary: `will medicare pay for NEMT` — factually, Medicare generally does not cover NEMT vans; content should set accurate expectations, not overpromise
3. How Much Does Non-Emergency Medical Transportation Cost? (blog) — primary: `how much does non emergency medical transportation cost`; secondary: `wheelchair transportation rates`, `private pay medical transportation baton rouge` `[UNCONF-PAY]` — opportunity gap per §2, but only publish real Cura rates once pricing is finalized; otherwise keep it educational/range-based with clear "contact us for a quote" CTA
4. Free & Low-Cost Transportation Options in Baton Rouge (blog, resource/goodwill page) — primary: `free transportation baton rouge`; secondary: `free transportation for seniors baton rouge medical appointments`, `veterans transportation to VA appointments baton rouge` — positions Cura as a helpful local resource even when it can't serve that exact need (e.g., pointing to EBRCOA Lotus Rides, DAV vans) — good E-E-A-T / trust play, low cannibalization risk

### City / parish spokes (thin local-landing-page cluster — build only after core service pages exist; each `[UNCONF-GEO]` until service area is confirmed)
Primary pattern: `non emergency medical transportation [city] la`
- Denham Springs `[UNCONF-GEO]`
- Gonzales `[UNCONF-GEO]`
- Zachary `[UNCONF-GEO]`
- Prairieville `[UNCONF-GEO]`
- Baker `[UNCONF-GEO]`
- Central `[UNCONF-GEO]`
- Port Allen `[UNCONF-GEO]`
- Plaquemine `[UNCONF-GEO]`
- St. Francisville `[UNCONF-GEO]` (relevant if this is genuinely a second operating base per the brief)

Recommendation: do not build 9 separate thin city pages at launch. Start with one "Service Areas" section on the pillar page listing confirmed parishes/cities, and only spin out a standalone city page once (a) the service area is confirmed and (b) there's a real local angle (a facility, a partnership, a review) to avoid thin/duplicate content.

### Internal linking
- Every service spoke (Cluster A/B) links back to the pillar and to the Medicaid + Cost FAQ spokes (Cluster C), since payer/cost questions are relevant across all service types.
- Cluster C payer pages cross-link to each other (Medicaid ↔ Medicare ↔ Cost ↔ Free-options) since they share the same searcher journey (confused about what's covered → looking for alternatives).
- City pages (once built) link up to the relevant service spokes and the pillar, not to each other.

---

## 4. Key accuracy notes to carry into content (do not skip — see CLAUDE.md guardrail)

1. **Medicaid broker structure**: MediTrans serves Healthy Louisiana MCO members; Verida serves Legacy Medicaid fee-for-service members (call 1-855-325-7626). Some MCOs may also contract other brokers (Southeastrans appeared in one SERP snippet) — verify current broker-per-plan mapping before publishing specifics, this changes over time via LDH contracts.
2. **Medicare**: does NOT cover wheelchair vans, ambulettes, or NEMT-style rides — only rare, physician-ordered non-emergency *ambulance* transport. Any Medicare-related content must be explicit about this distinction to avoid misleading claims.
3. **"Statewide" claim**: currently unproven per the brief. Do not publish "statewide" anywhere until confirmed; keyword targeting above assumes Baton Rouge metro as the real priority market.
4. **Service confirmations needed before publishing service-specific pages**: ambulatory (assume yes, confirm), wheelchair (likely yes, confirm), stretcher (unknown — do not build a page yet), dialysis/recurring rides (confirm scheduling capability), same-day/weekend (confirm dispatch capacity for a brand-new fleet).
5. **Provider-enrollment content excluded**: per the brief, do not create "how to become an NEMT provider" or business-startup content — that content exists to serve competitors/other operators, not Cura's own patient-facing acquisition funnel.

---

## Sources consulted

- [Non-emergency Medical Transportation (NEMT) in Baton Rouge, LA | Uber Health](https://www.uberhealth.com/us/en/d/nemt/baton-rouge-la-us/)
- [Medical Transportation | Baton Rouge, LA](https://www.brla.gov/1481/Medical-Transportation)
- [THE BEST 10 MEDICAL TRANSPORTATION IN BATON ROUGE, LA — Yelp](https://www.yelp.com/search?cflt=medicaltransportation&find_loc=Baton+Rouge%2C+LA)
- [Medicaid Medical Transportation | Baton Rouge General](https://www.brgeneral.org/medical-services/pregnancy-birth/your-pregnancy-journey/medicaid-medical-transportation)
- [Nichelles Medical Transit — Yelp](https://www.yelp.com/biz/nichelles-medical-transit-baton-rouge)
- [transportation programs in Baton Rouge, la | findhelp.org](https://www.findhelp.org/transit/transportation--baton-rouge-la)
- [MediTrans CTN Louisiana Non-Emergency Medical Transportation](https://meditrans.com/)
- [LDH Louisiana Medicaid State Plan Amendment (transportation)](https://www.ldh.la.gov/assets/medicaid/StatePlan/Amend2014/14.39CMSSubmittal.pdf)
- [Wheelchair Vans for Sale Baton Rouge, LA | Superior Van & Mobility](https://superiorvan.com/locations/baton-rouge-la/)
- [Baton Rouge, Louisiana Wheelchair Vans for Sale | AMS Vans](https://www.amsvans.com/louisiana/baton-rouge)
- [Hire Top-Rated Providers for Disabled Transportation in Baton Rouge, LA | Care.com](https://www.care.com/disabled-transportation-services/baton-rouge-la)
- [Wheelchair Transportation Service | WE LIFT](https://www.weliftrideshare.com/)
- [Non Emergency Wheelchair Transportation in Baton Rouge, LA | Freedmans Health](https://freedmanshealth.org/transportation/wheelchair-transportation-baton-rouge-la/)
- [Table of Contents State/Territory Name: Louisiana | Medicaid.gov](https://www.medicaid.gov/medicaid/spa/downloads/LA-24-0017.pdf)
- [How to Get Medical Transportation on Louisiana Medicaid — Nest Health](https://www.nesthealth.com/blog/louisiana-medicaid-transportation)
- [Non-Emergency Medical Transportation - LA Medicaid (lmmis.com)](https://www.lmmis.com/provweb1/Provider_Enrollment/PT42_NEMT.pdf)
- [Transportation to Appointments | Louisiana Healthcare Connections](https://www.louisianahealthconnect.com/members/medicaid/benefits-services/transportation-to-appointments.html)
- [Louisiana Medicaid Transportation Benefits | Blossom Support Coordination](https://blossomsca.com/louisiana-medicaid-transportation-benefits-everything-you-need-to-know/)
- [Ecolane | Non-Emergency Medical Transportation (NEMT) Rates](https://www.ecolane.com/blog/non-emergency-medical-transportation-rates)
- [Non-Emergency Medical Transportation | CMS](https://www.cms.gov/medicare/medicaid-coordination/states/non-emergency-medical-transportation)
- [NEMT 101: Types of Medical Transport, Cost, and Tips - Elite Ambulance](https://www.eliteamb.com/nemt-101-types-of-medical-transport-cost-and-tips/)
- [Non-Emergency Medical Transportation Rates | Call The Care](https://www.callthecare.com/non-emergency-medical-transportation-rates)
- [Ambulance services coverage | Medicare.gov](https://www.medicare.gov/coverage/ambulance-services)
- [Does Medicare Cover Medical Transportation? | AARP](https://www.aarp.org/medicare/does-medicare-cover-transportation/)
- [Does Medicare cover ambulance and transportation services? | Humana](https://www.humana.com/medicare/medicare-resources/medicare-transportation-and-ambulance-coverage)
- [NEMT Brokers in LOUISIANA | NEMT Platform](https://nemtplatform.com/blogs/nemt-brokers-in-louisiana)
- [Important Information for Medical Transportation Providers About MediTrans | Louisiana Healthcare Connections](https://www.louisianahealthconnect.com/newsroom/important-information-for-medical-transportation-providers-about.html)
- [Louisiana NEMT Provider Guide 2026 | MediRoutes](https://mediroutes.com/nemt-state-guide/louisiana)
- [LOUISIANA PROVIDERS | Verida](https://verida.com/louisiana-providers/)
- [Medical Transportation | LDH](https://ldh.la.gov/medicaid/medical-transportation)
- [Ambulatory transport in Baton Rouge, LA | MedicalRide.org](https://medicalride.org/find-medical-transport/la/baton-rouge/ambulatory-transport)
- [Long-distance medical transport in Baton Rouge, LA | MedicalRide.org](https://medicalride.org/find-medical-transport/la/baton-rouge/long-distance-medical-transport)
- [Medical Transport in Baton Rouge, LA | National Healthcare Connect](https://www.nationalhealthcareconnect.com/services/medical-transport-baton-rouge)
- [Louisiana Medical Transport Services | Long Distance Medical Transportation (medic-trans.com)](https://medic-trans.com/louisiana-medical-transport/)
- [DAV vans: Transportation for Veterans | VA Southeast Louisiana health care](https://www.va.gov/southeast-louisiana-health-care/dav-vans-transportation-for-veterans/)
- [Baton Rouge VA Clinic | Veterans Affairs](https://www.va.gov/find-locations/facility/vha_629BY)
- [Free Transportation for Seniors in Louisiana | Seniors Mobility](https://seniorsmobility.org/free-transportation/free-transportation-for-seniors-in-louisiana/)
- [Transportation – EBR Council on Aging](https://ebrcoa.org/transportation/)
- [Transportation Services for the Elderly | GOEA Louisiana](https://goea.louisiana.gov/media/frihghpl/transportationnarrative.pdf)
