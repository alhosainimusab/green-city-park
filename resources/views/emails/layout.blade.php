<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>@yield('subject') — Green City Entertainment</title>
<style>
  body { margin:0; padding:0; background:#f4f1ec; font-family:'Helvetica Neue',Arial,sans-serif; color:#333; }
  .wrap { max-width:600px; margin:32px auto; background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
  .header { background:#1B2B3A; padding:28px 32px; text-align:center; }
  .header-brand { font-size:22px; font-weight:800; color:#F0C96B; letter-spacing:.03em; }
  .header-sub { font-size:12px; color:rgba(255,255,255,.5); margin-top:4px; }
  .body { padding:32px; }
  .greeting { font-size:18px; font-weight:700; color:#1B2B3A; margin-bottom:12px; }
  .text { font-size:14px; line-height:1.7; color:#555; margin-bottom:16px; }
  .info-box { background:#f9f7f4; border:1px solid #e8e0d5; border-radius:10px; padding:18px 20px; margin:20px 0; }
  .info-row { display:flex; justify-content:space-between; font-size:13px; padding:6px 0; border-bottom:1px solid #ede8df; }
  .info-row:last-child { border-bottom:none; }
  .info-lbl { color:#888; }
  .info-val { font-weight:700; color:#1B2B3A; }
  .btn { display:inline-block; background:#C8922A; color:#fff !important; text-decoration:none; padding:12px 28px; border-radius:8px; font-weight:700; font-size:14px; margin:16px 0; }
  .highlight { color:#C8922A; font-weight:700; }
  .green { color:#2D6A4F; font-weight:700; }
  .red { color:#dc3545; font-weight:700; }
  .divider { border:none; border-top:1px solid #ede8df; margin:24px 0; }
  .footer { background:#1B2B3A; padding:20px 32px; text-align:center; }
  .footer p { color:rgba(255,255,255,.4); font-size:11px; margin:4px 0; }
  .footer a { color:#F0C96B; text-decoration:none; }
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <div class="header-brand">🌿 Green City Entertainment</div>
    <div class="header-sub">حديقة جرين سيتي الترفيهية — مأرب، اليمن</div>
  </div>
  <div class="body">
    @yield('content')
  </div>
  <div class="footer">
    <p>Green City Entertainment Park — Marib, Yemen</p>
    <p>+967 1 234 5678 · <a href="mailto:info@greencitypark.ye">info@greencitypark.ye</a></p>
    <p style="margin-top:8px;color:rgba(255,255,255,.25);font-size:10px;">This is an automated message, please do not reply directly.</p>
  </div>
</div>
</body>
</html>
