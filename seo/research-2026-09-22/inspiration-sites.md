# Client Inspiration Sites: Analysis

**Client:** Cura Mobility Services (NEMT van company, Baton Rouge, LA; owner Michael Veal)
**Researched:** 2026-09-22
**Method:** raw HTML + CSS pulled with curl (meta, headings, JSON-LD, CSS custom properties), rendered in Playwright for JS-built pages, hero screenshots saved in `.playwright-mcp/` (`mitresonz_top.jpg`, `mitresonz_full.jpg`, `moride_top.jpg`, `caremove_top.jpg`, `golden_top.jpg`). No forms submitted, no logins, no bookings.

**Sources (tracking params stripped):**
1. https://moridellc.com/reliable-transportation-services-in-baton-rouge-la (+ https://moridellc.com/)
2. https://caremove.us/
3. https://www.goldenridestransport.com/ (+ /book-ride)
4. https://mitresonz.net/ (+ /m/bookings, which is login-walled; sitemaps)
   - Supporting records: https://www.bbb.org/us/la/baton-rouge/profile/medical-transportation/mitresonz-transportation-services-llc-0835-90034758 · https://www.stedi.com/npi-registry/npis/1730752684

---

## Quick comparison

| | MoRide (LP) | CareMove | Golden Rides | Mitresonz (consultant) |
|---|---|---|---|---|
| Actual HQ | Kissimmee, FL (BR "location" is an executive-suite room) | Richmond/Houston, TX | Cypress/Houston, TX | Baton Rouge, LA |
| Platform | GoHighLevel funnel | WordPress + Elementor | Next.js + Tailwind (Medflow Digital) | GoDaddy Website Builder |
| Payer model | **Private pay only**, "No insurance required" | **Private pay only** (banner) | **Medicaid + Medicare + private pay**, brokers named | Not stated on site (NPI registered as NEMT van, so broker work is plausible, unverified) |
| Primary CTA | Embedded booking form in hero + "Book Online Now" | Hero form "Request Ride" + call | "Book a Ride" to multi-step booking page | Call (top bar) + contact form |
| Pricing shown | No | No | No ("call for a straight price") | No |
| Hours | "Available 24/7" | Not prominent | 24/7 (schema: 00:00–23:59 daily) | M–Th 8–5, Fri 8–12, Sat by appt, Sun closed |
| Palette | Green #17A64A / yellow #FFC83D / blue #4266B0 | Teal-blue #4C6FB4, teal #0E90A0, aqua #38E1CF, navy #1A3C6E | Deep red #912024, navy #092646, white/gray | Plum #371841, dark plum #291031, mauve #9E6DAD, lavender-gray #C0B4C5, gold logo |
| Fonts | Sora (display), Inter/Lato/Poppins | Epilogue (heads), Inter (body) | Inter | Fjalla One (heads, all caps), Source Sans Pro |
| Tone | Bright, salesy, direct-response | Clinical-warm, soft | Clean, institutional, veteran-pride | Personal, warm, a bit luxe (purple + gold script logo) |
| SEO depth | 1 BR landing page + "local cities served" | 6 city pages + 5 audience pages + ~21 blog posts | 6 service pages + ~11 blog posts + FAQ schema | Single page, no service pages, no blog |

---

## 1. MoRide LLC: Baton Rouge Google Ads landing page

**URL:** https://moridellc.com/reliable-transportation-services-in-baton-rouge-la
**Business:** Multi-service "mobility transportation" company based in **Kissimmee, FL** (homepage: "Orlando, Kissimmee, & Beyond… expanding across the US and Canada"). Baton Rouge is one of its "starting points." Footer shows a Baton Rouge address of *2900 Westfork Drive, Suite 401, Room 27, Baton Rouge, LA 70827*, which reads like an executive-suite/virtual office. Phone is an Orlando-area 689 number. Built by Grapevine Marketing on GoHighLevel.

**Title:** Reliable Transportation Services in Baton Rouge, LA | MoRide LLC
**Meta description:** "MoRide LLC provides safe, on-time transportation services in Baton Rouge, LA, including airport transfers, medical transport, senior rides, and corporate travel. Get your instant quote today!" (It does not match the LP's private-pay medical angle.)
**H1:** "Private-Pay Medical Transportation in Baton Rouge — No Insurance Required" (a second H1 appears in the footer, "QUICK LINKS": a template bug)
**Schema:** none found.

**Page structure (top to bottom):**
1. Green top bar (phone, email, social) + white header (logo with wheelchair icon in the "o", nav, green "Book Online Now" pill)
2. Hero: green gradient, pill badge "Baton Rouge, LA · Available 24/7", H1 with yellow highlight, subline "No approvals. No insurance. Just reliable rides. Book online in minutes.", buttons "Book Your Ride Now" + phone; checkmarks (No prior authorization / ADA-compliant vehicles / Licensed & insured drivers). **Booking form embedded on the right** (name, email, phone, pickup time, date, # passengers, pickup address, drop-off…)
3. Strip: "Skip the insurance process — pay directly online. Available today." with three checks
4. "Reliable Rides for Every Medical Need": 4 cards, each with a tag: Dialysis Transport (Recurring · 3x/Week), Doctor Appointments (Same-Day Available), Hospital Discharge (Post-Surgery · Discharge), General Medical Rides (ADA-Compliant)
5. "Clean, ADA-Compliant Vehicles & Caring Drivers": Wheelchair-Accessible & Ramp-Equipped / ADA-Compliant Fleet / Licensed & Insured Drivers
6. Stats band "Baton Rouge Trusts MoRide": 10k+ rides, 4.9★, 24/7, 100% licensed & insured
7. "Where We Take You": named hospitals (Our Lady of the Lake, Baton Rouge General, Ochsner, Woman's Hospital, dialysis centers, specialty clinics); areas (Downtown, Mid City, Prairieville, Denham Springs, Zachary, Central); ZIP list 70801–70816, 70820, 70836 + "Call to confirm"
8. Testimonials (3 initials-avatar quotes: dialysis, discharge, doctor appts) + GHL reviews widget iframe
9. Closing CTA "Book Your Baton Rouge Ride in 2 Minutes" + footer (both addresses)

**Nav:** Home · Services (NEMT, Senior & Family, Social, Airport) · About · Contact · Book Online Now
**Services (site-wide):** Non-Emergency Medical & Accessibility; Senior & Family; Community, School & Corporate; Airport & Leisure.
**Booking:** online form in the hero plus `/get-quote`. Stripe is loaded (the page says "pay directly online"). The phone is secondary.
**Pricing:** none shown ("instant quote").
**Trust signals:** 10k+ rides, 4.9★, "Rated #1 for Safety & Care", licensed & insured, ADA. **These are unverifiable for a Florida company that is new to BR, and the testimonials look like placeholders (initials, generic names).** Do not copy this approach; it breaks our accuracy guardrail.
**Visual:** saturated green #17A64A (dark #0E7D37), yellow #FFC83D highlight, blue #4266B0 (logo). Sora display, Inter body. Bright, direct-response, no real photography above the fold.
**SEO angle:** a city-specific LP with "Baton Rouge" in the title, H1 and body; lists hospitals, neighborhoods and ZIPs. The homepage targets Orlando/Kissimmee. No blog seen.

**Borrow:**
- Private-pay pitch as the headline ("No insurance required / no prior authorization") if Cura does private pay
- Booking form above the fold on desktop
- Service cards with small context tags ("Recurring · 3x/week", "Same-day")
- "Where we take you" block naming BR hospitals, dialysis centers, parishes and ZIPs (strong local relevance)
- Trust checkmarks directly under the CTA

**Avoid:**
- Fabricated-feeling stats and testimonials
- Out-of-state phone number and a virtual-office address
- Meta description that doesn't match the page
- Duplicate H1s

---

## 2. CareMove (Houston, TX)

**URL:** https://caremove.us/
**Business:** Private-pay-only NEMT, Richmond/Houston TX (307 Old Silo St, Richmond, TX 77406), 800 number.
**Title:** Non-Emergency Medical Transportation in Houston, TX - CareMove
**Meta:** "CareMove provides safe, reliable non-emergency medical Transportation services in Houston, TX. Our ADA vans and caring drivers ensure on-time, comfortable rides for patients."
**H1:** Non-Emergency Medical Transportation Service in Houston, TX
**Schema:** Yoast defaults only (WebPage, BreadcrumbList, WebSite, Organization). No LocalBusiness or FAQPage.

**Page structure:**
1. Dismissible top banner: "We do not accept Medicaid or insurance plans. CareMove operates exclusively as a private pay service." (sets expectations immediately)
2. Header: logo, Home / About / Who We Serve ▾ / Areas ▾ / FAQs / Blogs / Contact, phone at right
3. Hero: full-bleed photo of a wheelchair van with the rear lift down, under a teal overlay; H1 + warm paragraph + "Call 800-293-9046"; **"Book Your Ride Now!" form on the right** (first/last, email, phone, "How did you hear about us?", message, SMS consent checkbox with A2P language, "Request Ride")
4. "Simple Process, Caring Service": 4 numbered steps: Book With Ease, Gentle Pickup, Safe Arrival, **Track Your Ride Live**
5. "NEMT Services in Houston You Can Trust": audience cards (Dialysis, Seniors, Nursing Homes, Wheelchair, Ambulatory/Sedan)
6. Counters (ADA vans in fleet, % on-time); they render "0" without JS
7. "Why Patients Count on Us": 6 value tiles (Safety First, Always On Time, Compassionate Drivers, Exceptional Care / "Flexible private pay options", Peace of Mind, Comfort and Dignity, Live Tracking)
8. Testimonials: 3 hand-written quotes (one reused name, "Google/Apple" labels) + a **Trustindex Google-reviews carousel** (real Google reviews)
9. Blog teaser (3 posts: private-pay NEMT for seniors, NEMT vs driving yourself, choosing dialysis transport in Harris County)
10. CTA band "Book Your Ride With CareMove" + value words marquee (Safety, Comfort, Compassion, Reliability, Accessibility, Trust)
11. Footer: tagline "CareMove — Moving You with Care.", who-we-serve, areas, quick links, contact, private-pay disclaimer

**Services / "Who We Serve":** Wheelchair Patients · Dialysis Patients · Seniors · Nursing Homes · Ambulatory Patients (Ambulatory / Sedan Transportation)
**Booking:** lead form (not true scheduling), SMS consent built in. Phone is secondary.
**Pricing:** none. "Reasonably priced / best rate" appears only inside reviews.
**Trust:** "brand new ADA vans", live GPS tracking, Google reviews via Trustindex, WP ADA Compliance plugin notice.
**Visual:** Elementor globals: primary #4C6FB4, secondary #99B9D8, teal #0E90A0, aqua #38E1CF, navy #1A3C6E, accent #1B2021, light #BACBD3. Fonts: Epilogue (headings), Inter (body). Real van photography under a teal wash. Soft, calm, "clinical-warm."
**SEO angle:** strong local architecture. **6 city pages** (`/nemt-in-katy-tx/` etc.), **5 audience/service pages**, FAQ page, ~21 blog posts with city/county keywords ("Harris County", "Houston").

**Borrow:**
- Payer-model banner (whichever way Cura goes, say it up front)
- Numbered 4-step "how it works"
- "Who We Serve" menu organised by patient type
- City pages with a `/nemt-in-{city}-la/` pattern (e.g. Denham Springs, Zachary, Central, Prairieville, Gonzales, Port Allen)
- Google-review widget once Cura has reviews
- SMS consent on the form (A2P compliance for GHL texting)
- Live-tracking feature, if Cura's dispatch software supports it

**Avoid:**
- Hand-typed testimonials attributed to "Google/Apple"
- Counters that show 0 without JS
- Generic Yoast-only schema
- Typos ("porgress", "We offers")

---

## 3. Golden Rides LLC (Houston, TX)

**URL:** https://www.goldenridestransport.com/
**Business:** Veteran-owned NEMT, Cypress/Houston TX. Accepts **Medicaid, Medicare and private pay**; names brokers **MTM, Modivcare, Veyo**. Built by Medflow Digital (an NEMT-specialist agency).
**Title:** NEMT & Medical Transportation Houston | Golden Rides LLC
**Meta:** "Veteran-owned NEMT services in Houston. Wheelchair and ambulatory transportation for dialysis, doctor visits, and hospital discharge. Medicaid accepted."
**H1:** Wheelchair, Ambulatory, and Medical Transportation in Houston, TX
**Schema:** **MedicalBusiness** (address, areaServed cities, 24/7 OpeningHoursSpecification, priceRange, sameAs incl. Google Business), **WebSite**, **FAQPage** (6 Q&As). The best schema of the four.

**Page structure:**
1. Floating rounded white nav card over the hero (Home, About, Services ▾, PASS Certification ▾, More ▾, red "Book a Ride")
2. Hero: full-bleed photo (caregiver pushing a wheelchair user beside a car) with a dark overlay; H1; paragraph listing every service and audience; "Schedule Your Ride" + "View All Services"
3. "Who We Are — Veteran-Founded": mission paragraph + badges (Veteran-Owned, ADA-Compliant Fleet, 24/7 Availability, Houston, TX)
4. "Every Ride You Need, Covered in Houston": 6 service cards with **hyper-local detail** (Texas Medical Center, Houston Methodist, Memorial Hermann, Ben Taub, DaVita/Fresenius, MD Anderson, IAH/Hobby, Galveston cruise port)
5. "We Handle Every Type of Medical Trip": checklist (medical/dental appts, outpatient procedures, dialysis, PT, rehab, discharge, airport/bus/train, long-distance, one-way & round trip)
6. "Who We Serve": Seniors, Dialysis Patients, Veterans, Hospital Case Managers, Insurance Members; Facilities & Partners (hospitals/rehab, dialysis centers, nursing/assisted living, Medicaid & insurance brokers)
7. "Why Choose Us": Veteran-Owned Locally Operated / Trained Medical Transport Drivers / 24/7 / **Medicaid, Medicare, and Private Pay Accepted**
8. Service area: 22 city chips + map ("Active Service Area")
9. FAQ accordion (cost, Medicaid coverage, same-day, airport, areas, how to book)
10. CTA "Your Next Medical Ride Is One Call Away" (Book a Ride + Call)
11. Footer (Partner With Us, Careers, Service Feedback, PASS pages, Blog, services, address, socials incl. Google Business)

**Services:** Wheelchair Transportation; Ambulatory Transportation; Hospital Discharge Transportation; Airport & Cruise Port Transfers; Long-Distance Medical Transportation; Dialysis Transportation (each has its own `/services/` page).
**Booking:** `/book-ride` is a **multi-step booking portal** with a live "Your trip so far" summary: passenger (name, DOB, gender, weight), trip (pickup, drop-off, schedule time, appointment time, state), vehicle (Ambulatory/Wheelchair), passenger count, return trip, notes. Call is always the alternative.
**Pricing:** none. FAQ: "Call us with your trip details and we will give you a straight price before you book."
**Trust:** veteran-owned, PASS-certified staff (Passenger Assistance Safety & Sensitivity) with dedicated pages, ADA fleet, 24/7, payer acceptance, Google Business link. No review widget on the homepage.
**Visual:** Tailwind tokens: primary **#912024** (deep red; 500 #C22B30), secondary **#092646** (navy), yellow-400 #FAC800 (accent), grays. Inter throughout. Real/stock human photography. Tone: clean, institutional, patriotic.
**SEO angle:** service pages, a Houston-heavy blog (~11 posts: NEMT cost 2026, what is NEMT, Medicaid transport in Texas, dialysis, wheelchair van vs ambulette, becoming an NEMT driver), MedicalBusiness + FAQPage schema. City chips only, no city pages.

**Borrow:**
- MedicalBusiness + FAQPage schema pattern
- Service pages that name local facilities (for BR: Our Lady of the Lake, Baton Rouge General, Ochsner Medical Center–BR, Woman's Hospital, Lane Regional, local DaVita/Fresenius centers, Mary Bird Perkins Cancer Center; long-distance runs to New Orleans/Ochsner main campus/Tulane)
- Multi-step booking form with a trip summary
- "Who we serve" split into patients and facility partners
- PASS-certification trust story (if Cura's drivers are certified)
- FAQ answering cost and Medicaid questions honestly

**Avoid:**
- Hero paragraph that just lists keywords (reads robotic)
- Ambiguous "PASS Certification" nav for lay users
- Site-wide "24/7" claim unless true

---

## 4. Mitresonz (consultant's company): MOST IMPORTANT

**URL:** https://mitresonz.net/
**What it is:** a **single-page GoDaddy Website Builder site** for "Mitresonz Unlimited LLC" (og:site_name / logo alt: "Mitresonz Transportation Services LLC"). There is no nav menu. The only links are the top-bar phone, anchor "Reserve Transportation", GoDaddy member links (Sign In / Create Account / Bookings / My Account, all login-walled) and a cart icon. The sitemap lists only `/` plus the member login pages. The GoDaddy online-appointments sitemap exists but is empty or private. **"Crawling every page" means this one page. There are no service, about, FAQ or testimonial pages.**

**Business records (independent of the site):**
- Legal entity **Mitresonz Transportation Services LLC**, 1529 Fairchild St, Baton Rouge, LA 70807. Owner **Sheeba M. King**. BBB: founded 2017-06-01, 2 employees, not accredited, 0 complaints ([BBB](https://www.bbb.org/us/la/baton-rouge/profile/medical-transportation/mitresonz-transportation-services-llc-0835-90034758)).
- **NPI 1730752684**, active since 2021-07-19, taxonomy 343900000X "Non-emergency Medical Transport (VAN)" ([Stedi NPI](https://www.stedi.com/npi-registry/npis/1730752684)). An NPI with an NEMT taxonomy is typically needed for Medicaid/broker billing, so Mitresonz **probably** does Medicaid broker trips, but the website never says so.
- Web listings mention "black-owned" and phones (225) 360-5572 / (225) 251-3545 / (888) 800-0293 and a separate domain **mitresonz.com** (returned 403 to us, so not analysed). The .net site uses **225-448-4557**. That is a NAP inconsistency.
- Google Maps 5.0★ / 185 reviews (per brief; the reviews are not shown on the website).

**Title:** Reliable Senior, Non Medical, Wheelchair Transportation Services | Mitresonz
**Meta description:** "Explore our trusted senior, non medical, wheelchair transportation solutions. We provide safe and comfortable rides tailored for seniors, (wheelchair) unique needs."
**H1:** Reliable Senior, Non Medical, Wheelchair Transportation Services
**Schema:** none. **Location keywords:** none. "Baton Rouge" never appears; the address is just "Louisiana, United States."

**Page structure (top to bottom):**
1. Black top bar: "CALL US TO RESERVE TRANSPORTATION TODAY 225-448-4557" (plain text, **not a tap-to-call link**)
2. Header: centered square logo (gold script "Mitresonz" in a gold brush circle, "UNLIMITED LLC" in purple, on black); cart + account icons
3. Hero: stock motion-blur highway at sunset with a diagonal purple overlay; white circle holding H1 + "Reserve Transportation" button (anchors to the contact form)
4. "About Mitresonz UNLIMITED LLC": 4-tab/accordion block: About us / Our Services / Our Team / Now Offering Premier Luxury Vehicle Transport
5. "Transportation Solutions for You and Your Loved Ones": 6 service cards (image + title + blurb) in a 3×2 grid
6. Contact Us: "Reserve Transportation" form (Name, Email, Phone, "What services can we help you with?", attach files) + "Better yet, Request a Ride Today!" phone, email, **hours**, bullet notes
7. Tagline banner "Empowering Your Journeys with Mitresonz UNLIMITED LLC: Safe, Dependable Transportation – Every Mile Matters With You and Your Loved Ones" + photo gallery (logo, delivery boxes, van interior, wheelchair securement, sunset road)
8. Newsletter "Stay Up to Date"
9. Callout: "Yes, we are able to transport bariatric passengers and oversized scooters. Inquire today!"
10. Privacy Policy blurb (doesn't sell/share passenger, vendor or broker info; note the word "brokers")
11. "We're Hiring! Join Our Team": apply form with resume upload for "Professional Certified Transport Specialist"
12. "We Want To Hear From You!": service-issue feedback form + "FOR MEDICAL EMERGENCIES, PLEASE CALL 911!"
13. Footer + cookie banner; TrustedSite badge (bottom-left)

### Mitresonz services (verbatim)

**Service cards** (verbatim titles and descriptions):
1. **Non-Emergency Medical Transportation**: "designed to ensure safe and comfortable transport to medical appointments, therapies, and other healthcare-related destinations. We prioritize your well-being, providing a supportive experience throughout the journey."
2. **Passenger Transport**: "Whether you're commuting to work, heading to an event, or just need a reliable ride, our Passenger Transport service offers a dependable and convenient way to get to your desired destination."
3. **ADA Passenger Transport**: "Our ADA-compliant Passenger Transport service is specifically tailored to cater to the needs of individuals with disabilities… making every trip accessible to all."
4. **Small Delivery**: "Need a package or item delivered quickly and securely?… ensuring your items reach their destination in the same condition they left."
5. **Courier Services**: "for businesses and individuals seeking reliable, swift, and secure document and small parcel deliveries."
6. **Prescription Drop Offs**: "ensuring your medications reach you or your loved ones safely and on time. We understand the importance of medication adherence…"

**Also named in the "Our Services" tab copy:** Child school pick up and drop off; Grocery pick up and drop off.
**About copy names these rider types:** Seniors, Non Medical, Wheelchair, **Bariatric** ("you name it we can do it!"), plus a callout for **oversized scooters**.
**Other capabilities stated:** "YES WE TRAVEL LONG DISTANCE!" · "YES WE ARE AVAILABLE ON HOLIDAYS!" · weekends by appointment.
**LUXURY (exclude for Cura):** **"Now Offering Premier Luxury Vehicle Transport"**: "where sophistication meets dependability… exceptional comfort, elegance, and security." This is the only luxury item.

**Fleet / vehicle types:** wheelchair (gallery shows a wheelchair secured in a van), ADA vans, bariatric capability, oversized scooters. **No stretcher service is mentioned.**
**Service area:** "Louisiana, United States" only (no city or parish list on site). Records place it in Baton Rouge 70807.
**Hours:** Mon–Thu 8:00 am–5:00 pm · Fri 8:00 am–12:00 pm · Sat by appointment · Sun closed (the notes also say weekends by appointment and holidays available).
**Booking flow:** call 225-448-4557 (primary), or the "Reserve Transportation" contact form (free-text "What services can we help you with?", file attach). GoDaddy customer accounts and "Bookings" exist but are login-walled. No online scheduler with a calendar was visible. A cart icon is present, but we found no public products.
**Payment / insurance / Medicaid:** **Not mentioned anywhere.** The only hint is the privacy note about "brokers." No pricing.
**Trust signals on site:** TrustedSite badge; "Professional Certified Transport Specialist" (job title); "cutting-edge technology"; "sheer amount of volume and rides that we provide daily." **No reviews shown** (despite 185 five-star Google reviews), no licenses, no years in business, no insurance statement, no founder story, no photos of the actual team.
**About / founder story:** generic mission ("the first step toward a better quality of life often begins with the simple act of reaching your appointment… respect, safety, punctuality, and courtesy"). The owner is never named on the site.
**FAQ:** none. **Testimonials:** none.
**Contact methods:** phone (text only), Gmail address mitresonzunlimited@gmail.com, contact form, feedback form, job-application form, newsletter.

**Visual design:** computed colours: plum **#371841** (main section background), darker plum **#291031** (form fields), mauve **#9E6DAD**, lavender-gray **#C0B4C5**, off-white **#F7F7F7**, black top bar/logo, **gold** script logo (the logo is roughly #D4AF6A-ish gold on black; sample it before reuse). Fonts: **Fjalla One** (condensed all-caps headings), **Source Sans Pro** (body). Photography: stock sunset highways, delivery boxes, van interiors, one wheelchair-securement shot. Tone: warm and personal with a luxe feel (purple + gold). Dark-mode page throughout.

**SEO assessment:** weak. One page, no city keywords, no schema, no service pages, no blog, phone not linked, NAP split across two domains and several phone numbers. **Mitresonz ranks on Maps because of its GBP reviews and proximity, not its website.** That is the gap Cura can win on organic.

**Borrow:**
- Breadth of "we can do it" rider types (bariatric, scooters, wheelchair)
- Long-distance / holiday / weekend-by-appointment callouts
- Hiring form (driver recruiting)
- Service-issue feedback form + "call 911 for emergencies" disclaimer
- Warm, family-centred tagline ("you and your loved ones")

**Avoid:**
- Single page
- No city name
- Non-clickable phone
- Gmail address
- No reviews, even though they have 185
- Hidden payer info
- All-caps condensed type for long headings (hard to read for seniors)
- Dark low-contrast body text (#C0B4C5 on #371841 is borderline)

---

## Synthesis: what the client seems to like

1. **A booking path right in the hero.** Three of four put a form or "Book/Reserve" button above the fold, with the phone right beside it. The client clearly expects "request a ride" online plus a big phone number.
2. **Service or audience cards** with short blurbs. Every site has a 4–6 card grid (dialysis, doctor appointments, hospital discharge, wheelchair, seniors).
3. **Warm, family-focused tone over clinical.** Recurring phrases: "you and your loved ones", "peace of mind", "treat my father like family", "comfort and dignity". His survey voice (Professional, Empathetic/Warm, Friendly) matches.
4. **Real vehicle and people photography.** The sites he likes show wheelchair vans with lifts and caregivers, not abstract graphics.
5. **A clear payer stance.** Two sites lead with "private pay, no insurance" and one leads with "Medicaid/Medicare/brokers accepted." **Cura must decide and state it.** This is the biggest open question for positioning.
6. **Trust stacking:** ADA-compliant fleet, licensed & insured, trained drivers, on-time, live tracking, owner identity (veteran-owned). Cura's honest version: new vans, licensed and insured (verify), trained and certified drivers (verify PASS/CPR), local owner Michael Veal, Baton Rouge-based.
7. **Local proof:** named hospitals, dialysis centers, neighborhoods and ZIPs (MoRide, Golden Rides). This is also the SEO win.
8. **Colour:** no single palette recurs (green/yellow, teal/blue, red/navy, plum/gold). He is choosing layouts and business model, not a colour. Take Cura's palette from his own logo in `brand/`. Mitresonz's purple/gold is his consultant's brand; don't imitate it or Cura may look like a sub-brand.

**Recommended Cura homepage skeleton (derived):** payer banner (once confirmed) → header with tap-to-call + "Book a Ride" → hero (real van photo, "Non-Emergency Medical Transportation in Baton Rouge, LA", short warm subline, Book + Call, 3 trust checks, form on desktop) → 4-step how it works → services grid → who we serve (patients | facilities) → why Cura (honest trust tiles) → where we go (BR hospitals, dialysis, parishes) → reviews (GBP widget once live) → FAQ (cost, payer, same-day, wheelchair, area) → final CTA → footer (NAP, hours, 911 disclaimer, careers).

---

## Cura likely services (from Mitresonz minus luxury)

Each is **[INFERRED from consultant site — confirm with client]**. Michael said: "Everything that she has with the exception of the luxury services is what I provide."

| # | Service (Mitresonz wording) | Suggested Cura framing | Status |
|---|---|---|---|
| 1 | Non-Emergency Medical Transportation | NEMT to doctor visits, therapy, dialysis, outpatient procedures, hospital discharge | [INFERRED from consultant site — confirm with client] |
| 2 | ADA Passenger Transport | Wheelchair transportation (ramp/lift van, securement) | [INFERRED from consultant site — confirm with client] |
| 3 | Passenger Transport | Ambulatory / general passenger rides (work, events, errands) | [INFERRED from consultant site — confirm with client] |
| 4 | Senior transportation (H1 / About) | Senior rides and companion-style assistance | [INFERRED from consultant site — confirm with client] |
| 5 | Bariatric transport + oversized scooters | Bariatric-capable transport (needs a suitable lift rating) | [INFERRED from consultant site — confirm with client] |
| 6 | Long-distance ("YES WE TRAVEL LONG DISTANCE") | Long-distance medical trips (New Orleans, Houston, etc.) | [INFERRED from consultant site — confirm with client] |
| 7 | Prescription Drop Offs | Prescription / pharmacy delivery | [INFERRED from consultant site — confirm with client] |
| 8 | Small Delivery | Small-package delivery | [INFERRED from consultant site — confirm with client] |
| 9 | Courier Services | Document / parcel courier for businesses (clinics, law offices) | [INFERRED from consultant site — confirm with client] |
| 10 | Child school pick up and drop off | School transportation | [INFERRED from consultant site — confirm with client] (licensing/insurance for minors may differ) |
| 11 | Grocery pick up and drop off | Grocery / errand runs | [INFERRED from consultant site — confirm with client] |
| — | ~~Premier Luxury Vehicle Transport~~ | **EXCLUDED** (client said no luxury) | Excluded |

**Also confirm with client (Mitresonz is silent or ambiguous on these):**
- Payer model: private pay only, or Louisiana Medicaid via brokers (e.g. MTM / Verida, the LA Medicaid NEMT brokers; verify current broker list), or both? Does Cura have an NPI or Medicaid enrollment yet?
- Stretcher / gurney service: **not offered by Mitresonz**, so assume no.
- Hours: 24/7 or business hours like Mitresonz (M–Th 8–5, Fri 8–12, weekends by appointment)? Holidays?
- Service area: which parishes (East Baton Rouge, Ascension, Livingston, West Baton Rouge, Iberville…)?
- Fleet: number and type of vans, ramp vs lift, bariatric weight capacity
- Driver credentials (PASS, CPR/First Aid, background checks), licensing and insurance to cite (per `06-Reports/records-check.md` guardrail)
- Online booking and payment (Stripe/GHL payments?) or request-a-ride form only; live ride tracking?
- Hospital-discharge and facility accounts (nursing homes, dialysis centers)?

---

## SEO takeaways for Cura

- **Nobody in this set owns "Baton Rouge NEMT" organically.** MoRide has one Ads LP (FL company), and Mitresonz has no city keywords at all. A real local site with service pages + Baton Rouge/parish pages + MedicalBusiness/LocalBusiness + FAQPage schema can outrank on organic even while Mitresonz dominates the Maps pack on reviews.
- Copy the CareMove/Golden Rides architecture: `/services/{service}/`, `/nemt-in-{city}-la/`, `/faqs/`, `/blog/`, `/book-a-ride/`.
- Early blog topics modelled on Golden Rides and CareMove: "How much does NEMT cost in Baton Rouge (2026)", "How to schedule Medicaid transportation in Louisiana", "Dialysis transportation in Baton Rouge", "Wheelchair van vs ambulance", "Private-pay NEMT for seniors in Baton Rouge".
- Keep NAP consistent from day one (Mitresonz's split domains and phone numbers are the cautionary example).
