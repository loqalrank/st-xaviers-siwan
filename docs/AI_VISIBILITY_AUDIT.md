# AI Search Visibility Audit — St. Xavier's High School, Siwan

**Project path:** `C:\Client Project\St Xaviers Siwan\Option3`  
**Technology:** Plain PHP (no framework), PHP 7.4 CLI available  
**Public web root:** Project folder itself (`index.php` is homepage)  
**Audit date:** 2026-11-04  
**Audited by:** Kilo (Senior Technical SEO Engineer / AI Search Optimization)

---

## 1. Project Overview

| Item | Detail |
|------|--------|
| Framework | None (plain PHP includes) |
| PHP version | 7.4.0 (CLI) |
| Entry point | `index.php` |
| Shared header | `header.php` |
| Shared footer | `footer.php` |
| Styles | `assets/css/style.css` + local Bootstrap 5.3 / Bootstrap Icons / Font Awesome |
| Scripts | `assets/js/site.js` + local Bootstrap bundle |
| Images | `assets/images/` (gallery, local, hero) |
| Public pages | 11 content pages + 3 utility scripts (send-otp, submit-enquiry, verify-otp) |

### Public page inventory

| Page | URL path | Notes |
|------|----------|-------|
| Home | `index.php` | Hero carousel, stats, features, FAQ accordion |
| About | `about.php` | Vision, mission, values |
| Academics | `academics.php` | CBSE curriculum, class levels |
| Admissions | `admissions.php` | Enquiry form + process |
| Facilities | `facilities.php` | Campus facilities list |
| Leadership Messages | `messages.php` | Draft leadership messages |
| FAQ | `faq.php` | Accordion FAQ (20 questions) |
| Gallery | `gallery.php` | Image gallery with filters |
| Blog | `blog.php` | Sample blog cards |
| Blog Detail | `blog-detail.php` | Sample article |
| Mandatory Disclosure | `mandatory-disclosure.php` | PDF links hosted externally |
| (utility) | `send-otp.php`, `submit-enquiry.php`, `verify-otp.php` | OTP/enquiry backend (not SEO pages) |

---

## 2. Existing Problems (Phase 1 Audit)

### Critical

| # | Problem | File(s) | Severity | Recommended fix | Status |
|---|---------|---------|----------|-----------------|--------|
| C1 | No `robots.txt` exists | (missing) | Critical | Create `robots.txt` with sitemap reference and bot policies | Pending |
| C2 | No `sitemap.xml` exists | (missing) | Critical | Create static `sitemap.xml` listing all public canonical pages | Pending |
| C3 | No canonical `<link rel="canonical">` tags on any page | All pages | Critical | Add self-referencing canonical URL to `header.php` | Pending |
| C4 | No `llms.txt` AI discovery file | (missing) | Critical | Create `/llms.txt` listing key public pages | Pending |
| C5 | No structured data (JSON-LD) anywhere | All pages | Critical | Add JSON-LD for School/WebSite/Organization/FAQPage/ContactPoint | Pending |
| C6 | No Open Graph / Twitter Card meta tags | `header.php` | High | Add `og:`, `twitter:` meta tags in header | Pending |
| C7 | No `lang` / hreflang beyond basic `lang="en"` | `header.php` | Medium | Keep `lang="en"`; add `og:locale` | Pending |
| C8 | Invented facts published in FAQ (#3 affiliation number "330972", #4 established "2014") | `faq.php` lines 28-29 | Critical | Remove/replace with verification-required text; log in CONTENT_INFORMATION_REQUIRED.md | Pending |
| C9 | No 404 page handling | All | Medium | Add soft 404 handling guidance; ensure missing URLs return 404 | Pending |

### High

| # | Problem | File(s) | Severity | Recommended fix | Status |
|---|---------|---------|----------|-----------------|--------|
| H1 | Meta title/description only; no page-specific Open Graph | `header.php` | High | Add `og:title`, `og:description`, `og:image`, `og:url`, `twitter:card`, etc. | Pending |
| H2 | No `rel="noopener noreferrer"` consistency audit on external links | All pages | Medium | Verify all external `target="_blank"` links have `rel="noopener noreferrer"` | Pending |
| H3 | Footer states "CBSE education" and home states "CBSE-affiliated" but affiliation is unverified in project | `footer.php` line 5, `index.php` | High | Mark CBSE affiliation as requiring verification in CONTENT_INFORMATION_REQUIRED.md | Pending |
| H4 | Images lack `width`/`height` attributes (CLS risk) | All pages | Medium | Add width/height to `` tags where dimensions known | Pending |
| H5 | No `loading="lazy"` on below-the-fold images | All pages | Medium | Add `loading="lazy"` to non-hero images | Pending |
| H6 | FAQ accordion content is client-rendered (Bootstrap collapse) — AI crawlers can still read HTML, but FAQ schema not present | `faq.php` | High | Add FAQPage JSON-LD | Pending |
| H7 | No breadcrumb structured data | All pages with breadcrumbs | Medium | Add BreadcrumbList JSON-LD | Pending |

### Medium

| # | Problem | File(s) | Severity | Recommended fix | Status |
|---|---------|---------|----------|-----------------|--------|
| M1 | `submit-enquiry.php`, `send-otp.php`, `verify-otp.php` are backend scripts with no SEO value but are public | Root | Low | Exclude from sitemap; consider robots disallow | Pending |
| M2 | `st_xaviers_logo_enhanced.pdf` in root is not an SEO page | Root | Low | Exclude from sitemap | Pending |
| M3 | No `lastmod` source for sitemap (static dates acceptable) | `sitemap.xml` | Low | Use static recent dates or file mtimes | Pending |
| M4 | Image filenames are generic (`hero-slide-1.png`) | `assets/images/` | Low | Descriptive names already mostly present in gallery; leave hero images as-is to avoid breaking references | Pending |
| M5 | No `hreflang` alternate links | `header.php` | Low | Not required for single-language site | N/A |

### Low

| # | Problem | File(s) | Severity | Recommended fix | Status |
|---|---------|---------|----------|-----------------|--------|
| L1 | No SEO validation script | (missing) | Low | Create `docs/SEO_VALIDATION_REPORT.md` and optional check script | Pending |
| L2 | No deployment/rollback documentation | (missing) | Low | Create in implementation report | Pending |

---

## 3. Files Responsible (by problem area)

| Area | File(s) |
|------|---------|
| Shared SEO head | `header.php` |
| Shared footer NAP/social | `footer.php` |
| Homepage content/schema | `index.php` |
| About content/schema | `about.php` |
| Academics content/schema | `academics.php` |
| Admissions form/schema | `admissions.php` |
| Contact form/map/schema | `contact.php` |
| FAQ schema/content | `faq.php` |
| Gallery images/schema | `gallery.php` |
| Mandatory disclosure | `mandatory-disclosure.php` |
| Messages | `messages.php` |
| Blog/listing | `blog.php`, `blog-detail.php` |
| Styles | `assets/css/style.css` |
| Frontend behaviour | `assets/js/site.js` |

---

## 4. Implementation Roadmap

| Phase | Deliverable | Files to create | Files to modify |
|-------|-------------|-----------------|-----------------|
| 1 | Audit report | `docs/AI_VISIBILITY_AUDIT.md` | — |
| 2 | robots.txt, sitemap.xml, canonicals | `robots.txt`, `sitemap.xml` | `header.php` |
| 3 | OG/Twitter meta, language | — | `header.php` |
| 4 | JSON-LD structured data | `includes/seo-schema.php` (reusable) | `header.php`, all pages |
| 5 | Content audit / info required | `docs/CONTENT_INFORMATION_REQUIRED.md` | `faq.php` (fix invented facts) |
| 6 | FAQ schema | — | `faq.php` |
| 7 | Image SEO | — | All pages (width/height/lazy) |
| 8 | Local SEO / NAP | — | `footer.php`, `contact.php` |
| 9 | llms.txt, crawler guide | `llms.txt`, `docs/AI_CRAWLER_GUIDE.md` | — |
| 10 | Performance/accessibility | — | `assets/css/style.css`, `assets/js/site.js` |
| 11 | Security/quality review | — | — |
| 12 | Validation report | `docs/SEO_VALIDATION_REPORT.md` | — |
| 13 | Final documentation | `docs/AI_VISIBILITY_IMPLEMENTATION.md` | — |

---

## 5. Immediate Content Corrections Required

Before SEO implementation, the following **invented facts** must be corrected or removed (see `docs/CONTENT_INFORMATION_REQUIRED.md`):

1. `faq.php` line 28: CBSE affiliation number `330972` — **invented**, remove or mark for verification.
2. `faq.php` line 29: Established year `2014` — **invented**, remove or mark for verification.
3. `footer.php` line 5: "Providing CBSE education" — claim requires school verification.

No CBSE affiliation number, establishment date, student count, faculty count, ranking, or award should be published unless confirmed by school administration.

---

*End of Phase 1 audit summary. Full detail is maintained in this file; implementation tracking follows in Phase 13 documents.*
