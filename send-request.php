<?php
/* =====================================================================
   Only HVAC Pros — service request form handler
   ---------------------------------------------------------------------
   Receives the contact form, validates it, and emails the lead to the
   business. On success it redirects back to the homepage with ?sent=1
   (the homepage shows a thank-you message). On failure it redirects
   with ?error=1.

   Uses PHP's built-in mail(). On most shared hosts this works out of
   the box. If your host requires SMTP auth, swap the mail() call for
   PHPMailer (see the note near the bottom).
   ===================================================================== */

// ---- CONFIG ---------------------------------------------------------
// Lead destination, base64-encoded so the plaintext address isn't sitting
// in the source. Decoded only here, at send time. To change it, run:
//   php -r "echo base64_encode('new@email.com');"
$TO_EMAIL   = base64_decode('dG9ueWFrYW5hMzNAZ21haWwuY29t'); // where leads are delivered
$FROM_EMAIL = 'no-reply@onlyhvacpros.com';      // must be a domain you control
$SITE_NAME  = 'Only HVAC Pros';

// Cloudflare Turnstile (leave blank until you set it up).
// When you add your secret key here, verification turns on automatically.
$TURNSTILE_SECRET = '';
// ---------------------------------------------------------------------

function redirect($qs) {
  header('Location: index.php' . $qs . '#contact');
  exit;
}

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  redirect('?error=1');
}

// Honeypot: real users never fill the hidden "company" field. Bots do.
if (!empty($_POST['company'])) {
  // Silently pretend it worked so bots don't learn anything.
  redirect('?sent=1');
}

// ---- Cloudflare Turnstile verification (only if a secret is set) ----
if ($TURNSTILE_SECRET !== '') {
  $token = $_POST['cf-turnstile-response'] ?? '';
  $verify = @file_get_contents(
    'https://challenges.cloudflare.com/turnstile/v0/siteverify',
    false,
    stream_context_create(['http' => [
      'method'  => 'POST',
      'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
      'content' => http_build_query([
        'secret'   => $TURNSTILE_SECRET,
        'response' => $token,
        'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
      ]),
      'timeout' => 8,
    ]])
  );
  $ok = $verify ? json_decode($verify, true) : null;
  if (empty($ok['success'])) {
    redirect('?error=1');
  }
}

// ---- Collect & sanitize ---------------------------------------------
function clean($key) {
  return isset($_POST[$key]) ? trim(strip_tags($_POST[$key])) : '';
}
$name    = clean('name');
$phone   = clean('phone');
$email   = clean('email');
$address = clean('address');
$service = clean('service');
$urgency = clean('urgency');
$message = clean('message');

// Required fields
if ($name === '' || $phone === '') {
  redirect('?error=1');
}
// If they gave an email, make sure it's a real one
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  redirect('?error=1');
}

// ---- Build the email ------------------------------------------------
$subject = "New service request from {$name}" . ($service ? " — {$service}" : '');

$lines = [
  "You have a new service request from the {$SITE_NAME} website.",
  str_repeat('-', 52),
  "Name:       {$name}",
  "Phone:      {$phone}",
  "Email:      " . ($email ?: '(not provided)'),
  "Address:    " . ($address ?: '(not provided)'),
  "Service:    " . ($service ?: '(not specified)'),
  "How soon:   " . ($urgency ?: '(not specified)'),
  str_repeat('-', 52),
  "Message:",
  $message !== '' ? $message : '(none)',
  '',
  str_repeat('-', 52),
  "Submitted: " . date('l, F j, Y \a\t g:i A T'),
];
$body = implode("\r\n", $lines);

// Headers — set Reply-To to the customer so a reply goes straight to them.
$headers   = [];
$headers[] = "From: {$SITE_NAME} <{$FROM_EMAIL}>";
if ($email !== '') {
  $headers[] = "Reply-To: {$name} <{$email}>";
}
$headers[] = "Content-Type: text/plain; charset=UTF-8";
$headers[] = "X-Mailer: PHP/" . phpversion();

// ---- Send -----------------------------------------------------------
$sent = @mail($TO_EMAIL, $subject, $body, implode("\r\n", $headers));

/*
   NOTE: If mail() doesn't deliver on your host (common with Gmail
   delivery from shared hosting), install PHPMailer and send via SMTP
   instead — the rest of this file can stay exactly the same. Ask your
   developer to wire up SMTP credentials when you're ready.
*/

redirect($sent ? '?sent=1' : '?error=1');
