<?php
if (!isset($siteConfig) || !is_array($siteConfig)) {
    $siteConfig = include __DIR__ . '/site-config.php';
}

$popup = isset($siteConfig['admission_popup']) ? $siteConfig['admission_popup'] : [];
if (empty($popup['enabled'])) {
    return;
}

$popupPages  = isset($popup['pages']) && is_array($popup['pages']) ? $popup['pages'] : [];
$currentPage = basename(str_replace('\\', '/', isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : ''));
if (!empty($popupPages) && !in_array($currentPage, $popupPages, true)) {
    return;
}

$popupImage = !empty($popup['image']) ? $popup['image'] : 'assets/images/hero-students.jpg';
$popupLogo  = !empty($popup['logo']) ? $popup['logo'] : 'assets/images/school-logo.png';
$autoOpen   = !empty($popup['auto_open']);
$autoClose  = isset($popup['auto_close_seconds']) ? max(0, (int) $popup['auto_close_seconds']) : 30;
$popupEyebrow     = !empty($popup['eyebrow']) ? $popup['eyebrow'] : 'Admissions Open';
$popupYear        = !empty($popup['year']) ? $popup['year'] : '2026–27';
$popupTitle       = !empty($popup['title']) ? $popup['title'] : 'School';
$popupTitleAccent = !empty($popup['title_accent']) ? $popup['title_accent'] : 'Admission';
$popupSubline     = !empty($popup['subline']) ? $popup['subline'] : 'A strong CBSE foundation with values, discipline and all-round development.';
$popupCta         = !empty($popup['cta_label']) ? $popup['cta_label'] : 'Call Now';
?>
<style>
    .ap-modal .modal-content {
        border: 0;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(41, 41, 41, .28);
        background: #fff;
    }

    .ap-modal .modal-dialog {
        max-width: 860px;
    }

    .ap-modal .modal-body {
        padding: 0;
    }

    .ap-close {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 5;
        width: 36px;
        height: 36px;
        border: 0;
        border-radius: 50%;
        background: rgba(41, 41, 41, .55);
        color: #fff;
        font-size: 20px;
        line-height: 1;
        display: grid;
        place-items: center;
        cursor: pointer;
        transition: background .2s ease;
    }

    .ap-close:hover {
        background: var(--blue2);
    }

    .ap-poster {
        --ap-brand: var(--blue);
        --ap-brand-dark: var(--blue2);
        --ap-brand-light: var(--sky);
        --ap-ink: var(--ink);
        --ap-muted: var(--muted);
        --ap-paper: #fff;
        --ap-accent: var(--yellow);
        --ap-line: var(--line);
        position: relative;
        background: var(--ap-paper);
        color: var(--ap-ink);
        font-family: 'DM Sans', sans-serif;
        line-height: 1.5;
    }

    .ap-poster * {
        box-sizing: border-box;
    }

    .ap-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 16px 24px;
        border-bottom: 1px solid var(--ap-line);
        background: #fff;
    }

    .ap-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: inherit;
    }

    .ap-brand img {
        width: 54px;
        height: 54px;
        object-fit: contain;
    }

    .ap-brand-name {
        font-family: 'English Towne', serif;
        font-size: 3rem;
        font-weight: 400;
        line-height: 1.05;
        color: var(--ap-brand-dark);
    }

    .ap-brand-sub {
        font-size: 10px;
        letter-spacing: .16em;
        text-transform: uppercase;
        color: var(--ap-muted);
    }

    .ap-hero {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
    }

    .ap-photo-wrap {
        position: relative;
        min-height: 250px;
        padding: 22px 0 22px 24px;
    }

    .ap-photo-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        border-radius: 14px;
    }

    .ap-hero-copy {
        padding: 30px 30px 26px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .ap-eyebrow {
        margin: 0 0 6px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .22em;
        text-transform: uppercase;
        color: var(--ap-brand);
    }

    .ap-year {
        font-family: Manrope, sans-serif;
        font-size: 40px;
        font-weight: 700;
        line-height: 1;
        color: var(--ap-accent);
    }

    .ap-title {
        display: block;
        margin: 10px 0 8px;
        font-family: Manrope, sans-serif;
        font-size: 26px;
        font-weight: 700;
        line-height: 1.2;
        color: var(--ap-ink);
    }

    .ap-title span {
        display: block;
        color: var(--ap-brand-dark);
    }

    .ap-subline {
        margin: 0;
        font-size: 13px;
        color: var(--ap-muted);
    }

    .ap-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        padding: 18px 30px;
        border-top: 1px solid var(--ap-line);
    }

    .ap-offer {
        flex: 1 1 auto;
        min-width: 0;
    }

    .ap-offer h2 {
        margin: 0 0 8px;
        font-size: 13px;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--ap-brand-dark);
    }

    .ap-offer ul {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 4px 18px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .ap-offer li {
        position: relative;
        padding-left: 22px;
        margin-bottom: 0;
        font-size: 13px;
        color: var(--ap-ink);
    }

    .ap-offer li:last-child {
        margin-bottom: 0;
    }

    .ap-tick::before {
        content: "";
        position: absolute;
        left: 0;
        top: 4px;
        width: 13px;
        height: 13px;
        border-radius: 50%;
        background: var(--ap-brand);
    }

    .ap-tick::after {
        content: "";
        position: absolute;
        left: 4px;
        top: 6px;
        width: 5px;
        height: 8px;
        border: solid #fff;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .ap-details {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
        padding: 0 30px 20px;
        margin-top: 0;
    }

    .ap-detail {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 10px;
        border-radius: 8px;
        background: var(--ap-brand-light);
        min-width: 0;
    }

    .ap-circle-icon {
        flex: 0 0 auto;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: var(--ap-brand);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .03em;
        display: grid;
        place-items: center;
    }

    .ap-detail h3 {
        margin: 0;
        font-size: 9px;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--ap-muted);
        font-weight: 600;
    }

    .ap-detail p {
        margin: 0;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.25;
        color: var(--ap-ink);
    }

    .ap-actions {
        flex: 0 0 auto;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .ap-cta {
        flex: 0 0 auto;
        display: inline-block;
        padding: 11px 20px;
        border-radius: 999px;
        background: var(--ap-accent);
        color: var(--ink);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        text-decoration: none;
        transition: background .2s ease;
    }

    .ap-cta-alt {
        background: var(--ap-brand);
        color: #fff;
    }

    .ap-cta-alt:hover {
        background: var(--ap-brand-dark);
        color: #fff;
    }

    .ap-cta:hover {
        background: #ffca45;
        color: var(--ink);
    }

    .ap-footer {
        padding: 10px 30px;
        background: #fff;
        border-top: 1px solid var(--ap-line);
        font-size: 10px;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--ap-muted);
        text-align: center;
    }

    @media (max-width: 560px) {
        .ap-topbar {
            padding: 12px 16px;
        }

        .ap-brand img {
            width: 42px;
            height: 42px;
        }

        .ap-brand-name {
            font-size: 1.4rem;
        }

        .ap-hero {
            grid-template-columns: 1fr;
        }

        .ap-photo-wrap {
            padding: 16px 16px 0;
            min-height: 170px;
            max-height: none;
            overflow: visible;
        }

        .ap-photo-wrap img {
            height: 190px;
        }

        .ap-hero-copy {
            padding: 20px 16px;
        }

        .ap-year {
            font-size: 32px;
        }

        .ap-title {
            font-size: 22px;
        }

        .ap-content {
            flex-direction: column;
            align-items: stretch;
            padding: 18px 16px;
            gap: 14px;
        }

        .ap-offer ul {
            grid-template-columns: 1fr;
        }

        .ap-details {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 6px;
            padding: 0 16px 14px;
        }

        .ap-detail {
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
            padding: 8px;
        }

        .ap-circle-icon {
            width: 22px;
            height: 22px;
            font-size: 9px;
        }

        .ap-detail h3 {
            font-size: 8px;
        }

        .ap-detail p {
            font-size: 11px;
        }

        .ap-actions {
            width: 100%;
        }

        .ap-actions .ap-cta {
            flex: 1 1 auto;
            text-align: center;
        }

        .ap-cta {
            text-align: center;
        }

        .ap-footer {
            padding: 8px 16px;
        }
    }

    @media print {
        .ap-modal,
        .ap-close {
            display: none !important;
        }
    }
</style>
<div class="modal fade ap-modal" id="admissionPopup" tabindex="-1" aria-labelledby="admissionPopupTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="ap-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            <div class="modal-body">
                <div class="ap-poster">
                    <div class="ap-topbar">
                        <div class="ap-brand">
                            <div>
                                <div class="ap-brand-name">St. Xavier's High School</div>
                                
                            </div>
                        </div>
                    </div>


                    <div class="ap-hero">
                        <div class="ap-photo-wrap">
                            <img src="<?php echo seo_escape($popupImage); ?>" alt="Students of St. Xavier's High School, Siwan" loading="lazy" decoding="async">
                        </div>
                        <div class="ap-hero-copy">
                            <p class="ap-eyebrow"><?php echo seo_escape($popupEyebrow); ?></p>
                            <div class="ap-year"><?php echo seo_escape($popupYear); ?></div>
                            <div class="ap-title" id="admissionPopupTitle"><?php echo seo_escape($popupTitle); ?><span><?php echo seo_escape($popupTitleAccent); ?></span></div>
                            <p class="ap-subline"><?php echo seo_escape($popupSubline); ?></p>
                        </div>
                    </div>

                    <div class="ap-details">
                        <div class="ap-detail">
                            <span class="ap-circle-icon">01</span>
                            <div>
                                <h3>Session</h3>
                                <p><?php echo seo_escape($popupYear); ?></p>
                            </div>
                        </div>
                        <div class="ap-detail">
                            <span class="ap-circle-icon">02</span>
                            <div>
                                <h3>Classes</h3>
                                <p>Nursery to IX &amp; XI</p>
                            </div>
                        </div>
                        <div class="ap-detail">
                            <span class="ap-circle-icon">03</span>
                            <div>
                                <h3>Board</h3>
                                <p>CBSE (10+2)</p>
                            </div>
                        </div>
                    </div>

                    <div class="ap-content">
                        <div class="ap-offer">
                            <h2>Why Choose Us</h2>
                            <ul>
                                <li class="ap-tick">CBSE curriculum from Nursery to Class 12</li>
                                <li class="ap-tick">Experienced and caring faculty</li>
                                <li class="ap-tick">Smart classrooms and modern laboratories</li>
                                <li class="ap-tick">Safe, disciplined and value-based campus</li>
                            </ul>
                        </div>
                        <div class="ap-actions">
                            <a class="ap-cta ap-cta-alt" href="admissions.php">Enquire Now <i class="bi bi-arrow-right ms-1"></i></a>
                            <a class="ap-cta" href="tel:+91-8000800362"><?php echo seo_escape($popupCta); ?></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($autoOpen): ?>
<script>
    (function () {
        var autoClose = <?php echo (int) $autoClose; ?>;

        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById('admissionPopup');
            if (!el || typeof bootstrap === 'undefined') {
                return;
            }
            var modal = bootstrap.Modal.getOrCreateInstance(el);
            el.addEventListener('shown.bs.modal', function () {
                if (autoClose > 0) {
                    window.setTimeout(function () {
                        modal.hide();
                    }, autoClose * 1000);
                }
            });
            window.setTimeout(function () {
                modal.show();
            }, 1200);
        });
    })();
</script>
<?php endif; ?>


