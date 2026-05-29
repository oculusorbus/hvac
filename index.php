<?php
/* =====================================================================
   Only HVAC Pros — single-page site
   ---------------------------------------------------------------------
   EDIT YOUR BUSINESS DETAILS HERE. Everything below this block pulls
   from these variables, so you only change them in one place.
   ===================================================================== */
$BIZ = [
  'legal_name'  => 'Only HVAC LLC',
  'brand'       => 'Only HVAC Pros',
  'tagline'     => 'The only HVAC pros you’ll ever need.',
  'owner'       => 'Anthony Akana',
  // Phone intentionally left blank to avoid spam/robocalls. To show a
  // click-to-call number, fill both fields below (display + tel: link)
  // and the phone UI will reappear automatically across the site.
  'phone'       => '',
  'phone_href'  => '',
  // Contact email, base64-encoded so it never sits in plaintext in the
  // source or the served HTML (anti-harvesting). It is assembled into a
  // mailto: link client-side by assets/js/main.js. To change it, run:
  //   php -r "echo base64_encode('new@email.com');"
  'email_b64'   => 'dG9ueWFrYW5hMzNAZ21haWwuY29t',
  'address'     => '9111 Wild Trails St',
  'city_state'  => 'San Antonio, TX 78250',
  'license'     => 'TX State Mechanical Contractor · TACL #000000', // TODO: add license #
  'year'        => date('Y'),
];

// Whether to show click-to-call phone UI anywhere on the site.
$HAS_PHONE = $BIZ['phone'] !== '' && $BIZ['phone_href'] !== '';

// Emits a placeholder link that assets/js/main.js turns into a real
// mailto: with the decoded address. The plaintext email is never sent
// to the browser, so harvesters scraping the HTML come up empty.
function email_link($b64, $label = 'Email us') {
  return '<a class="email-link" href="#" data-email="' . htmlspecialchars($b64) . '">'
       . htmlspecialchars($label) . '</a>';
}

// Flash message after a form submission (set by send-request.php redirect)
$flash = '';
if (isset($_GET['sent']) && $_GET['sent'] === '1') {
  $flash = ['type' => 'ok', 'msg' => 'Thanks! Your request is on its way to our team. We’ll reach out shortly to get you scheduled.'];
} elseif (isset($_GET['error'])) {
  $flash = ['type' => 'err', 'msg' => 'Sorry — something went wrong sending your request. Please try again in a moment, or reach us using the contact details on this page.'];
}

// Curated gallery: file (in /images), thumb (in /images/thumbs), category, caption
$GALLERY = [
  ['20180301_154752',    'commercial', 'Rooftop package-unit installation'],
  ['20180809_192441',    'install',    'Crane-set rooftop unit replacement'],
  ['20180628_112729',    'commercial', 'Commercial duct trunk & air handling'],
  ['20180823_174855',    'residential','Ductless mini-split system'],
  ['20180326_104615',    'commercial', 'New high-efficiency rooftop unit'],
  ['20180628_112806',    'commercial', 'Industrial blower & fan service'],
  ['20180809_192524',    'install',    'Precision rigging on a roof curb'],
  ['20180327_131540',    'commercial', 'Sheet-metal ductwork fabrication'],
  ['20180205_135349',    'residential','Controls & electrical diagnostics'],
  ['20180817_145236',    'commercial', 'Full rooftop equipment line-up'],
  ['20180424_143534_HDR','commercial', 'Curb-mounted system changeout'],
  ['20181016_141000',    'commercial', 'Exhaust fan & ventilation work'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $BIZ['brand'] ?> | HVAC Services in San Antonio, TX</title>
  <meta name="description" content="Only HVAC Pros provides expert air conditioning, heating, and commercial HVAC services across San Antonio, TX. State-licensed mechanical contractor — repairs, installation, and maintenance done right.">
  <meta name="theme-color" content="#00aff0">
  <link rel="canonical" href="https://onlyhvacpros.com/">

  <!-- favicons (already in place) -->
  <link rel="icon" href="favicon.ico" sizes="any">
  <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="favicons/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="192x192" href="favicons/android-chrome-192x192.png">
  <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
  <link rel="manifest" href="favicons/site.webmanifest">

  <!-- Open Graph -->
  <meta property="og:title" content="Only HVAC Pros | San Antonio HVAC Services">
  <meta property="og:description" content="Air conditioning, heating & commercial HVAC done right in San Antonio. State-licensed mechanical contractor.">
  <meta property="og:type" content="website">
  <meta property="og:image" content="logos/OnlyHVACProsIcon.png">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="assets/css/style.css">

  <!-- Local business structured data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "HVACBusiness",
    "name": "<?= $BIZ['brand'] ?>",
    "legalName": "<?= $BIZ['legal_name'] ?>",
    "image": "https://onlyhvacpros.com/logos/OnlyHVACProsIcon.png",
<?php if ($HAS_PHONE): ?>    "telephone": "<?= $BIZ['phone'] ?>",
<?php endif; ?>    "url": "https://onlyhvacpros.com/",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "<?= $BIZ['address'] ?>",
      "addressLocality": "San Antonio",
      "addressRegion": "TX",
      "postalCode": "78250",
      "addressCountry": "US"
    },
    "areaServed": "San Antonio, TX and surrounding areas",
    "priceRange": "$$"
  }
  </script>
</head>
<body>

<!-- ============================ HEADER ============================ -->
<header class="site-header">
  <div class="container nav">
    <a href="#top" class="nav__logo" aria-label="<?= $BIZ['brand'] ?> home">
      <img src="logos/OnlyHVACProsLogo.png" alt="<?= $BIZ['brand'] ?>">
    </a>
    <ul class="nav__links" id="navLinks">
      <li><a href="#services">Services</a></li>
      <li><a href="#why">Why Us</a></li>
      <li><a href="#gallery">Our Work</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#area">Service Area</a></li>
      <li><a href="#contact">Contact</a></li>
    </ul>
    <div class="nav__cta">
      <?php if ($HAS_PHONE): ?><a class="nav__phone" href="tel:<?= $BIZ['phone_href'] ?>"><?= $BIZ['phone'] ?></a><?php endif; ?>
      <a class="btn btn-primary" href="#contact">Request Service</a>
      <button class="nav__toggle" id="navToggle" aria-label="Menu" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>

<a id="top"></a>

<!-- ============================= HERO ============================= -->
<section class="hero">
  <img class="hero__bg" src="images/thumbs/hero.jpg" alt="Commercial rooftop HVAC equipment installed by Only HVAC Pros">
  <div class="container">
    <div class="hero__inner">
      <p class="hero__tagline"><?= $BIZ['tagline'] ?></p>
      <h1>Expert Heating &amp; Air Conditioning for San Antonio</h1>
      <p class="sub">From a quick AC repair to a full commercial rooftop install, our state-licensed
        technicians keep your home or business comfortable all year long — done right the first time.</p>
      <div class="hero__actions">
        <a class="btn btn-primary" href="#contact">Request Service</a>
        <?php if ($HAS_PHONE): ?>
          <a class="btn btn-ghost" href="tel:<?= $BIZ['phone_href'] ?>">Call <?= $BIZ['phone'] ?></a>
        <?php else: ?>
          <a class="btn btn-ghost" href="#contact">Get a Free Estimate</a>
        <?php endif; ?>
      </div>
      <div class="hero__badges">
        <span class="hero__badge"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7fe3ff" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg> State-licensed &amp; insured</span>
        <span class="hero__badge"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7fe3ff" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg> Upfront, honest pricing</span>
        <span class="hero__badge"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7fe3ff" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg> Residential &amp; commercial</span>
      </div>
    </div>
  </div>
</section>

<!-- ============================ TRUST ============================ -->
<div class="trust">
  <div class="container trust__grid">
    <div class="trust__item"><strong>Same-Day</strong>Service available</div>
    <div class="trust__item"><strong>100%</strong>Satisfaction focused</div>
    <div class="trust__item"><strong>Licensed</strong>TX Mechanical Contractor</div>
    <div class="trust__item"><strong>Local</strong>San Antonio owned</div>
  </div>
</div>

<!-- =========================== SERVICES =========================== -->
<section class="section" id="services">
  <div class="container">
    <div class="section-head">
      <span class="eyebrow">What We Do</span>
      <h2>HVAC Services Built Around Your Comfort</h2>
      <p class="lead">Whether you’re sweating through a Texas summer or your heat quits on a January cold front,
        we’ve got the equipment, the expertise, and the cool air to back it up.</p>
    </div>
    <div class="cards">
      <article class="card">
        <div class="card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="11" rx="2"/><path d="M6 20h12M9 16v4M15 16v4M6 9h2M11 9h2M16 9h2"/></svg></div>
        <h3>AC Repair</h3>
        <p>Blowing warm air or making strange noises? We diagnose fast and fix it right — most repairs handled in a single visit.</p>
      </article>
      <article class="card">
        <div class="card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v18M3 12h18M5.6 5.6l12.8 12.8M18.4 5.6 5.6 18.4"/><circle cx="12" cy="12" r="3"/></svg></div>
        <h3>AC Installation &amp; Replacement</h3>
        <p>Right-sized, high-efficiency systems professionally installed to keep you cool and lower your energy bills.</p>
      </article>
      <article class="card">
        <div class="card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2s4 4 4 7a4 4 0 0 1-8 0c0-3 4-7 4-7Z"/><path d="M9 17a3 3 0 0 0 6 0"/></svg></div>
        <h3>Heating &amp; Furnace</h3>
        <p>Furnace and heat-pump repair, tune-ups, and replacement so you stay warm when those cold fronts roll through.</p>
      </article>
      <article class="card">
        <div class="card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="6" rx="1"/><rect x="3" y="14" width="18" height="6" rx="1"/><path d="M7 7h.01M7 17h.01"/></svg></div>
        <h3>Commercial HVAC</h3>
        <p>Rooftop units, crane-set changeouts, and light-commercial systems installed and serviced to keep your business running.</p>
      </article>
      <article class="card">
        <div class="card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7h18v4H3zM3 13h18v4H3z"/><path d="M7 7V4M17 7V4M7 20v-3M17 20v-3"/></svg></div>
        <h3>Ductwork &amp; Air Quality</h3>
        <p>Duct fabrication, sealing, and indoor air-quality upgrades that improve airflow, comfort, and the air you breathe.</p>
      </article>
      <article class="card">
        <div class="card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-9-9"/><path d="M12 7v5l3 2"/><path d="M16 3l5 0 0 5"/></svg></div>
        <h3>Maintenance Plans</h3>
        <p>Seasonal tune-ups that catch small problems before they become big ones — and keep your warranty intact.</p>
      </article>
    </div>
  </div>
</section>

<!-- ============================ WHY US ============================ -->
<section class="section section--tint" id="why">
  <div class="container split">
    <div class="split__text">
      <span class="eyebrow">Why Only HVAC Pros</span>
      <h2>Comfort You Can Count On — Without the Runaround</h2>
      <p>We’re a locally owned, state-licensed mechanical contractor that treats every job like it’s in our own
        home. No upselling, no surprise fees — just straight answers and quality work that lasts.</p>
      <ul class="feature-list">
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6 9 17l-5-5"/></svg>
          <span class="fi-title">Licensed, insured &amp; experienced</span>
          A Texas State Mechanical Contractor with the credentials to back up the work.
        </li>
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6 9 17l-5-5"/></svg>
          <span class="fi-title">Upfront, honest pricing</span>
          You approve the price before we start — no surprises when the job’s done.
        </li>
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6 9 17l-5-5"/></svg>
          <span class="fi-title">Residential &amp; commercial</span>
          From a backyard condenser to a rooftop unit set by crane, we handle it all.
        </li>
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6 9 17l-5-5"/></svg>
          <span class="fi-title">Work we stand behind</span>
          Clean installs, quality parts, and a team that shows up when we say we will.
        </li>
      </ul>
    </div>
    <div class="split__media">
      <img src="images/thumbs/20180809_192441.jpg" alt="Only HVAC Pros technician rigging a rooftop unit" loading="lazy">
    </div>
  </div>
</section>

<!-- =========================== GALLERY =========================== -->
<section class="section" id="gallery">
  <div class="container">
    <div class="section-head">
      <span class="eyebrow">Our Work</span>
      <h2>Real Jobs, Done Right</h2>
      <p class="lead">A look at the residential and commercial systems we’ve installed and serviced
        across the San Antonio area.</p>
    </div>

    <div class="gallery-filters">
      <button class="filter-btn is-active" data-filter="all">All</button>
      <button class="filter-btn" data-filter="residential">Residential</button>
      <button class="filter-btn" data-filter="commercial">Commercial</button>
      <button class="filter-btn" data-filter="install">Installations</button>
    </div>

    <div class="gallery">
      <?php foreach ($GALLERY as $g): [$file,$cat,$cap] = $g; ?>
      <figure class="gallery__item" data-cat="<?= $cat ?>"
              data-full="images/<?= $file ?>.jpg" data-cap="<?= htmlspecialchars($cap) ?>">
        <img src="images/thumbs/<?= $file ?>.jpg" alt="<?= htmlspecialchars($cap) ?>" loading="lazy">
        <figcaption class="gallery__cap"><?= htmlspecialchars($cap) ?></figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================ ABOUT ============================ -->
<section class="section section--tint" id="about">
  <div class="container split">
    <div class="split__media">
      <img src="images/thumbs/20180326_104615.jpg" alt="High-efficiency rooftop unit installed by Only HVAC Pros" loading="lazy">
    </div>
    <div class="split__text">
      <span class="eyebrow">About Us</span>
      <h2>San Antonio’s Friendly Neighborhood HVAC Crew</h2>
      <p>Only HVAC Pros was founded by <strong><?= $BIZ['owner'] ?></strong> on a simple idea: San Antonio
        deserves heating and cooling service that’s honest, skilled, and genuinely easy to work with.</p>
      <p>As a Texas State Mechanical Contractor, we bring the licensing and expertise of a big company with the
        care and accountability of a local, owner-operated business. We take pride in clean installs, tidy job
        sites, and treating your home or business with respect.</p>
      <p>When the Texas heat is relentless, you want a team that answers the phone and shows up ready to work.
        That’s us — and we’d love to earn your business.</p>
      <a class="btn btn-outline" href="#contact">Get a Free Estimate</a>
    </div>
  </div>
</section>

<!-- =========================== REVIEWS =========================== -->
<section class="section">
  <div class="container">
    <div class="section-head">
      <span class="eyebrow">Kind Words</span>
      <h2>Neighbors Who Stay Cool With Us</h2>
      <p class="lead">A few words from folks around San Antonio.
        <!-- TODO: replace these sample testimonials with real customer reviews. --></p>
    </div>
    <div class="reviews">
      <article class="review">
        <div class="review__stars">★★★★★</div>
        <p class="review__text">“Our AC died on the hottest day of the year and they had us cool again the same afternoon. Professional, friendly, and the price was exactly what they quoted.”</p>
        <div class="review__name">Marisol G.</div>
        <div class="review__loc">Northwest San Antonio</div>
      </article>
      <article class="review">
        <div class="review__stars">★★★★★</div>
        <p class="review__text">“They replaced two rooftop units at our shop without shutting us down for a single day. Clean work and a crew that clearly knows what they’re doing.”</p>
        <div class="review__name">Derrick W.</div>
        <div class="review__loc">Leon Valley, TX</div>
      </article>
      <article class="review">
        <div class="review__stars">★★★★★</div>
        <p class="review__text">“Finally an HVAC company that explains things in plain English and doesn’t try to upsell you. New system runs great and our power bill dropped.”</p>
        <div class="review__name">Angela R.</div>
        <div class="review__loc">Helotes, TX</div>
      </article>
    </div>
  </div>
</section>

<!-- ========================= SERVICE AREA ========================= -->
<section class="section section--blue" id="area">
  <div class="container">
    <div class="section-head">
      <span class="eyebrow">Where We Work</span>
      <h2>Proudly Serving Greater San Antonio</h2>
      <p class="lead">Based in San Antonio and serving the surrounding communities. Not sure if you’re in our
        area? Just ask — there’s a good chance we can help.</p>
    </div>
    <p style="text-align:center; font-size:1.1rem; line-height:2.2; max-width:820px; margin:0 auto;">
      San Antonio &nbsp;•&nbsp; Helotes &nbsp;•&nbsp; Leon Valley &nbsp;•&nbsp; Alamo Heights &nbsp;•&nbsp;
      Converse &nbsp;•&nbsp; Schertz &nbsp;•&nbsp; Universal City &nbsp;•&nbsp; Boerne &nbsp;•&nbsp;
      Live Oak &nbsp;•&nbsp; Cibolo &nbsp;•&nbsp; Stone Oak &nbsp;•&nbsp; Shavano Park &nbsp;•&nbsp;
      Fair Oaks Ranch &nbsp;•&nbsp; Castle Hills
    </p>
  </div>
</section>

<!-- =========================== CONTACT =========================== -->
<section class="section" id="contact">
  <div class="container">
    <div class="section-head">
      <span class="eyebrow">Get In Touch</span>
      <h2>Request Service or a Free Estimate</h2>
      <p class="lead">Tell us what’s going on and how to reach you. We’ll get back to you fast to schedule a visit.</p>
    </div>

    <div class="contact-grid">
      <!-- left: info -->
      <div class="contact-info">
        <?php if ($flash): ?>
          <div class="alert alert--<?= $flash['type'] ?>"><?= $flash['msg'] ?></div>
        <?php endif; ?>

        <?php if ($HAS_PHONE): ?>
        <div class="info-row">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.6A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/></svg>
          <div><strong>Call or text</strong><br><a href="tel:<?= $BIZ['phone_href'] ?>"><?= $BIZ['phone'] ?></a></div>
        </div>
        <?php endif; ?>
        <div class="info-row">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg>
          <div><strong>Email</strong><br><?= email_link($BIZ['email_b64'], 'Email us') ?></div>
        </div>
        <div class="info-row">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
          <div><strong><?= $BIZ['legal_name'] ?></strong><br><?= $BIZ['address'] ?><br><?= $BIZ['city_state'] ?></div>
        </div>

        <h3>Hours</h3>
        <table class="hours-table">
          <tr><td>Monday – Friday</td><td>8:00 AM – 6:00 PM</td></tr>
          <tr><td>Saturday</td><td>9:00 AM – 2:00 PM</td></tr>
          <tr><td>Sunday</td><td>Emergency service</td></tr>
        </table>
      </div>

      <!-- right: form -->
      <div class="form-card">
        <form action="send-request.php" method="post" id="requestForm" novalidate>
          <div class="form-row">
            <div class="field">
              <label for="name">Name <span class="req">*</span></label>
              <input type="text" id="name" name="name" required autocomplete="name">
            </div>
            <div class="field">
              <label for="phone">Phone <span class="req">*</span></label>
              <input type="tel" id="phone" name="phone" required autocomplete="tel">
            </div>
          </div>
          <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" autocomplete="email">
          </div>
          <div class="field">
            <label for="address">Service address</label>
            <input type="text" id="address" name="address" autocomplete="street-address" placeholder="Where do you need service?">
          </div>
          <div class="form-row">
            <div class="field">
              <label for="service">Service needed</label>
              <select id="service" name="service">
                <option value="">Select one…</option>
                <option>AC Repair</option>
                <option>AC Installation / Replacement</option>
                <option>Heating / Furnace</option>
                <option>Commercial HVAC</option>
                <option>Ductwork / Air Quality</option>
                <option>Maintenance / Tune-Up</option>
                <option>Other</option>
              </select>
            </div>
            <div class="field">
              <label for="urgency">How soon?</label>
              <select id="urgency" name="urgency">
                <option value="">Select one…</option>
                <option>Emergency — as soon as possible</option>
                <option>Within a few days</option>
                <option>Just getting an estimate</option>
              </select>
            </div>
          </div>
          <div class="field">
            <label for="message">How can we help?</label>
            <textarea id="message" name="message" placeholder="Tell us a little about what’s going on…"></textarea>
          </div>

          <!-- Honeypot anti-spam field (hidden from humans, ignore it) -->
          <div class="hp" aria-hidden="true">
            <label for="company">Company</label>
            <input type="text" id="company" name="company" tabindex="-1" autocomplete="off">
          </div>

          <!-- Cloudflare Turnstile will drop in here later -->
          <!-- <div class="cf-turnstile" data-sitekey="YOUR_SITE_KEY"></div> -->

          <button type="submit" class="btn btn-primary btn-block">Send My Request</button>
          <p class="form-note">We’ll only use your info to respond to your request. No spam, ever.</p>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ============================ FOOTER ============================ -->
<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <img src="logos/OnlyHVACProsLogo.png" alt="<?= $BIZ['brand'] ?>">
        <p><?= $BIZ['tagline'] ?> Honest, professional heating and cooling for homes and businesses across
          the San Antonio area.</p>
        <p class="footer-license"><?= $BIZ['license'] ?></p>
      </div>
      <div>
        <h4>Quick Links</h4>
        <ul class="footer-links">
          <li><a href="#services">Services</a></li>
          <li><a href="#gallery">Our Work</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#area">Service Area</a></li>
          <li><a href="#contact">Request Service</a></li>
        </ul>
      </div>
      <div>
        <h4>Contact</h4>
        <ul class="footer-links">
          <?php if ($HAS_PHONE): ?><li><a href="tel:<?= $BIZ['phone_href'] ?>"><?= $BIZ['phone'] ?></a></li><?php endif; ?>
          <li><?= email_link($BIZ['email_b64'], 'Email us') ?></li>
          <li><?= $BIZ['address'] ?></li>
          <li><?= $BIZ['city_state'] ?></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© <?= $BIZ['year'] ?> <?= $BIZ['legal_name'] ?>. All rights reserved.</span>
      <span><?= $BIZ['legal_name'] ?> doing business as <?= $BIZ['brand'] ?>.</span>
    </div>
  </div>
</footer>

<!-- ========================== LIGHTBOX ========================== -->
<div class="lightbox" id="lightbox" aria-hidden="true">
  <button class="lightbox__btn lightbox__close" id="lbClose" aria-label="Close">&times;</button>
  <button class="lightbox__btn lightbox__prev" id="lbPrev" aria-label="Previous">&#8249;</button>
  <img id="lbImg" src="" alt="">
  <button class="lightbox__btn lightbox__next" id="lbNext" aria-label="Next">&#8250;</button>
  <div class="lightbox__cap" id="lbCap"></div>
</div>

<script src="assets/js/main.js"></script>
</body>
</html>
