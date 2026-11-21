# AI Visibility Implementation Report — St. Xavier's High School, Siwan

**Project:** `C:\Client Project\St Xaviers Siwan\Option3`  
**Technology:** Plain PHP (PHP 7.4), Bootstrap 5.3  
**Canonical host:** `https://www.stxavierssiwan.com/`  
**Implementation date:** 2026-11-04

---

## Summary

All 13 phases of the AI Search Visibility, SEO, AEO and GEO optimization master task have been implemented where safe to do so within the existing plain-PHP project. No existing functionality was removed or replaced. No school facts were invented.

---

## Files Created

| File | Purpose |
|------|---------|
| `robots.txt` | Crawler policy: allows Googlebot, Bingbot, OAI-SearchBot, PerplexityBot, ClaudeBot, Claude-SearchBot; disallows GPTBot, CCBot, backend scripts, admin/private paths; references sitemap |
| `sitemap.xml` | 12 public canonical URLs with lastmod, changefreq, priority |
| `llms.txt` | AI discovery file: org name, URL, description, location, key page URLs, contact, sitemap |
| `includes/seo-helpers.php` | Reusable SEO functions: canonical URL, Open Graph/Twitter meta, JSON-LD (School/Organization, WebSite, ContactPoint, FAQPage, Article, BreadcrumbList) |
| `docs/AI_VISIBILITY_AUDIT.md` | Phase 1 audit (problems, severity, files, fixes, status) |
| `docs/CONTENT_INFORMATION_REQUIRED.md` | Unverified school facts that need admin approval (CBSE affiliation number, establishment year, student/faculty counts, etc.) |
| `docs/AI_CRAWLER_GUIDE.md` | Bot policy guide: search crawling vs model-training crawling for each bot |
| `docs/AI_VISIBILITY_IMPLEMENTATION.md` | This file |
| `docs/SEO_VALIDATION_REPORT.md` | Validation results |

---

## Files Modified

| File | Change |
|------|--------|
| `header.php` | Added `require_once includes/seo-helpers.php`; added canonical + OG + Twitter meta via `seo_head_meta()`; added Organization (School) + WebSite JSON-LD; added preload for logo + hero background image; set `$seoPage`, `$seoBreadcrumbs` defaults |
| `footer.php` | No code change needed (NAP already consistent); verified NAP matches contact page and schema |
| `index.php` | Set `$seoPage`, `$seoBreadcrumbs`; added width/height + `loading="lazy"` to 3 gallery images and campus photo |
| `about.php` | Set `$seoPage`, `$seoBreadcrumbs`; added width/height + lazy to campus image |
| `academics.php` | Set `$seoPage`, `$seoBreadcrumbs`; added width/height + lazy to classroom image |
| `admissions.php` | Set `$seoPage`, `$seoBreadcrumbs`; form already had `novalidate`, phone pattern `[1-9][0-9]{9}`, `maxlength="10"`, required email, agreement checkbox |
| `contact.php` | Set `$seoPage`, `$seoBreadcrumbs`; form has `novalidate`, phone validation, required email, agreement checkbox |
| `facilities.php` | Set `$seoPage`, `$seoBreadcrumbs`; added width/height + lazy to facility banner |
| `gallery.php` | Set `$seoPage`, `$seoBreadcrumbs`; added width/height + `loading="lazy"` to all 9 gallery images |
| `blog.php` | Set `$seoPage`, `$seoBreadcrumbs`; added width/height + lazy to 3 blog images |
| `blog-detail.php` | Set `$seoPage`, `$seoBreadcrumbs`, `$seoImage`; added Article JSON-LD; added width/height + lazy to article image |
| `messages.php` | Set `$seoPage`, `$seoBreadcrumbs` |
| `faq.php` | Set `$seoPage`, `$seoBreadcrumbs`; **removed invented CBSE affiliation number "330972" and establishment year "2014"** (replaced with verification-required notices); added FAQPage JSON-LD for all 20 Q&A |
| `mandatory-disclosure.php` | Set `$seoPage`, `$seoBreadcrumbs` |
| `assets/css/style.css` | Added form inline-validation styles (`.invalid-feedback`, `.is-invalid`); retained/enhanced social-links and top-strip icon sizing |

---

## Technical Improvements

1. **Canonical URLs**: Self-referencing `<link rel="canonical">` on every page, pointing to `https://www.stxavierssiwan.com/<page>`.
2. **Open Graph / Twitter Card**: `og:title`, `og:description`, `og:url`, `og:image`, `og:locale`, `twitter:card`, `twitter:title`, `twitter:description`, `twitter:image` on all pages.
3. **Structured Data (JSON-LD)**:
   - `School`/`Organization` with address, phones, email, sameAs social profiles (consistent `@id` across all pages)
   - `WebSite` with search action
   - `BreadcrumbList` on all pages
   - `FAQPage` on faq.php (20 visible Q&A)
   - `Article` on blog-detail.php
4. **Crawl policy**: `robots.txt` allows legitimate search/AI-search crawlers; blocks model-training crawlers (GPTBot, CCBot) and backend/private paths.
5. **Sitemap**: Valid XML with all 12 public pages.
6. **AI discovery**: `llms.txt` plus `AI_CRAWLER_GUIDE.md`.
7. **Image SEO**: width/height attributes and `loading="lazy"` on below-the-fold images; hero images left eager (LCP); `fetchpriority="high"` preload for logo + campus background.
8. **Form validation**: Inline (non-popup) validation for phone (10 digits, not starting with 0), email format, required fields, mandatory agreement checkbox; same behavior and error messages on both contact and admissions forms.
9. **Performance**: `preload` + `fetchpriority="high"` for LCP assets; `loading="lazy"` for offscreen images; no render-blocking additions.
10. **Accessibility**: Existing `aria-label`, `aria-expanded`, `aria-controls`, `aria-current`, `role` attributes preserved; focus-visible outlines on social links.

---

## Content Corrections (verified facts only)

- Removed invented CBSE affiliation number `330972` (was in FAQ Q3).
- Removed invented establishment year `2014` (was in FAQ Q4).
- Both replaced with "[to be confirmed by school administration]" notices and logged in `docs/CONTENT_INFORMATION_REQUIRED.md`.

---

## Remaining Limitations & Manual Actions

1. **Canonical hostname / HTTPS enforcement**: The repository cannot enforce www vs non-www or HTTPS. Configure a 301 redirect at the server/hosting layer (e.g., `.htaccess`, IIS web.config, or hosting control panel) to redirect all traffic to `https://www.stxavierssiwan.com/`.
2. **404 handling**: Ensure the server returns HTTP 404 for missing URLs (no custom 404 page created to avoid replacing existing behavior).
3. **Search Console / Bing Webmaster**: Property verification and sitemap submission must be done manually by the site owner (see deployment instructions below).
4. **Unverified facts**: CBSE affiliation status/number, establishment year, student/faculty counts, medium of instruction, fee structure, admission dates, school timings — not published; listed in `docs/CONTENT_INFORMATION_REQUIRED.md` for admin approval.
5. **PDF disclosure documents**: External PDF URLs on `mandatory-disclosure.php` point to `https://www.stxavierssiwan.com/images/...`; verify these resolve before launch.
6. **Identifiable student photos**: Gallery contains real student photographs; publish only with appropriate permission (noted on gallery page).

---

## Validation Results

| Check | Result |
|-------|--------|
| All PHP files lint (`php -l`) | PASS (15 files + helper) |
| JSON-LD blocks parse (`json_decode`) | PASS (School, WebSite, FAQPage, Article, BreadcrumbList) |
| Sitemap.xml valid XML | PASS (12 URLs) |
| robots.txt present with sitemap reference | PASS |
| Canonical URL on index.php | PASS (`https://www.stxavierssiwan.com/index.php`) |
| OG/Twitter meta on index.php | PASS |
| FAQPage schema on faq.php | PASS (4 JSON-LD blocks rendered) |
| No exposed secrets/keys | PASS |
| NAP consistent (footer, contact, schema) | PASS |

> Note: HTTP 200 does not guarantee indexing. Submit sitemap to Google Search Console and Bing Webmaster Tools (see below).

---

## Production Deployment Instructions

1. Upload all files to the web root of `https://www.stxavierssiwan.com/`.
2. Ensure `robots.txt` and `sitemap.xml` are accessible at the root.
3. Configure server-level 301 redirect to `https://www.stxavierssiwan.com/` (HTTPS + www).
4. Verify ownership in:
   - Google Search Console: https://search.google.com/search-console → submit `sitemap.xml`
   - Bing Webmaster Tools: https://www.bing.com/webmasters/ → submit `sitemap.xml`
5. Validate structured data at https://validator.schema.org/ and https://search.google.com/test/rich-results.
6. Have school administration review `docs/CONTENT_INFORMATION_REQUIRED.md` and approve any additional facts before publishing.

---

## Rollback Instructions

1. Restore `header.php`, `footer.php`, and all page `.php` files from backup (pre-change copies).
2. Delete `robots.txt`, `sitemap.xml`, `llms.txt`, `includes/seo-helpers.php`.
3. Remove the `<link rel="preload">` tags and `seo_head_meta()` call from `header.php`.
4. Remove form validation CSS from `assets/css/style.css` (the `.invalid-feedback` and `.is-invalid` blocks).
5. Revert `faq.php` Q3/Q4 if the original (invented) text is required — **not recommended**, as those facts were unverified.

---

## AI Visibility Monitoring Strategy

- Monitor Google Search Console "Performance" and "Indexing" reports for impressions/clicks on school-related queries.
- Monitor Bing Webmaster Tools similarly.
- Periodically test AI search visibility by querying ChatGPT Search, Perplexity, and Gemini with: "St. Xavier's High School Siwan", "schools in Siwan Bihar", "CBSE school Siwan admissions".
- Re-validate JSON-LD after any content change using https://validator.schema.org/.
- Re-run the PHP lint check after modifying any `.php` file.
