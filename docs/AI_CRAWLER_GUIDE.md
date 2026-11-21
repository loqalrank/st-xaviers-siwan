# AI Crawler Guide — St. Xavier's High School, Siwan

This document explains the crawler and bot policies for the St. Xavier's High School website (`https://www.stxavierssiwan.com/`). It is intended as a reference for search-engine crawlers, AI search agents, and site administrators.

---

## 1. Search crawling vs model-training crawling

**Search crawling** (indexing pages so they can be returned in search results and AI search answers) is desired and permitted for legitimate public-search crawlers.

**Model-training crawling** (using website content to train generative AI foundation models) is NOT permitted for this site. The site owner does not grant a license to use its content for training AI models.

## 2. Bot policies

| Bot | Purpose | Policy | Source |
|-----|---------|--------|--------|
| Googlebot | Google Search indexing | Allow | Google |
| Bingbot | Bing Search indexing | Allow | Microsoft |
| OAI-SearchBot | ChatGPT Search (search indexing) | Allow | OpenAI |
| PerplexityBot | Perplexity AI search indexing | Allow | Perplexity |
| ClaudeBot | Claude search indexing | Allow | Anthropic |
| Claude-SearchBot | Claude search indexing | Allow | Anthropic |
| GPTBot | ChatGPT model training | **Disallow** | OpenAI |
| CCBot | Common Crawl / model training | **Disallow** | Common Crawl |

Note: `GPTBot` and `OAI-SearchBot` are different crawlers. Allowing `OAI-SearchBot` supports ChatGPT Search visibility; blocking `GPTBot` prevents use of site content for model training. Both policies are honored independently in `robots.txt`.

## 3. Sensitive paths blocked

The following paths are disallowed to all crawlers (these are backend/private routes, not public SEO pages):

- `/send-otp.php`
- `/submit-enquiry.php`
- `/verify-otp.php`
- `/admin/`
- `/login/`
- `/private/`
- `/includes/`
- `/.kilo/`
- `*.pdf$` (PDF disclosure documents are linked from the public Mandatory Disclosure page but are not sitemap entries)

`robots.txt` is a polite directive, not a security mechanism. Sensitive data must be protected by authentication and access controls, not by `robots.txt` alone.

## 4. Sitemap

Location: `https://www.stxavierssiwan.com/sitemap.xml`

Contains all public canonical pages. Excludes backend scripts, admin routes, private files, and noindex pages.

## 5. Structured data

The site publishes JSON-LD schema.org structured data:
- `School` / `Organization` — identity, address, phones, email, social profiles
- `WebSite` — site search action
- `BreadcrumbList` — navigation structure
- `FAQPage` — visible questions and answers
- `Article` — blog article pages

Validate at https://validator.schema.org/

## 6. AI discovery file

Location: `https://www.stxavierssiwan.com/llms.txt`

A plain-text summary of the organization, key pages, and contact details for AI agents and LLMs.

## 7. Verification and monitoring

- Google Search Console: https://search.google.com/search-console
- Bing Webmaster Tools: https://www.bing.com/webmasters/
- Google Rich Results Test: https://search.google.com/test/rich-results

Indexing and AI recommendations are not guaranteed. These practices improve discoverability and eligibility only.

---

*Maintained as part of the AI Search Visibility project for St. Xavier's High School, Siwan.*
