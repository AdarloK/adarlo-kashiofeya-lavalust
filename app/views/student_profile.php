<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Record &middot; <?= htmlspecialchars($name) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #06070d;
            --panel: rgba(16, 20, 34, 0.62);
            --panel-solid: #0e1220;
            --border: rgba(140, 160, 255, 0.16);
            --border-strong: rgba(140, 160, 255, 0.32);
            --text: #eef1fb;
            --muted: #8790ac;
            --accent: #5b8cff;
            --accent-2: #35e0c9;
            --danger: #ff5c72;
            --glow-blue: #3b5bff;
            --glow-violet: #8b5cf6;
            --mono: 'JetBrains Mono', monospace;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        .glow-field {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background:
                radial-gradient(560px 420px at 18% -8%, rgba(53, 224, 201, 0.16), transparent 70%),
                radial-gradient(620px 480px at 85% 0%, rgba(139, 92, 246, 0.24), transparent 70%),
                radial-gradient(900px 700px at 50% 120%, rgba(59, 91, 255, 0.08), transparent 70%);
        }

        .grid-overlay {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(140,160,255,0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(140,160,255,0.05) 1px, transparent 1px);
            background-size: 46px 46px;
            mask-image: radial-gradient(ellipse 100% 60% at 50% 0%, #000 0%, transparent 75%);
        }

        .wrap {
            position: relative;
            z-index: 1;
            max-width: 1000px;
            margin: 0 auto;
            padding: 34px 24px 60px;
        }

        /* ---------- top bar ---------- */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 34px;
        }

        .brand { display: flex; align-items: center; gap: 11px; }
        .brand .mark { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; }
        .brand .word { font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 1rem; }
        .brand .word span {
            color: var(--muted); font-weight: 500; font-family: var(--mono);
            font-size: 0.72rem; display: block; letter-spacing: 0.14em; margin-top: 1px;
        }

        .navpills {
            display: flex; gap: 6px; background: var(--panel); border: 1px solid var(--border);
            padding: 4px; border-radius: 12px; backdrop-filter: blur(10px);
        }
        .navpills a {
            text-decoration: none; font-family: var(--mono); font-size: 0.72rem; font-weight: 500;
            letter-spacing: 0.04em; color: var(--muted); padding: 8px 16px; border-radius: 9px;
        }
        .navpills a.active { background: linear-gradient(135deg, var(--glow-blue), var(--glow-violet)); color: #fff; }

        /* ---------- status bar ---------- */
        .status-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            background: rgba(53, 224, 201, 0.07);
            border: 1px solid rgba(53, 224, 201, 0.28);
            border-radius: 14px;
            padding: 14px 20px;
            margin-bottom: 26px;
        }

        .status-bar .left { display: flex; align-items: center; gap: 10px; }

        .pulse {
            width: 9px; height: 9px; border-radius: 50%; background: var(--accent-2);
            box-shadow: 0 0 0 0 rgba(53,224,201,0.6);
            animation: pulse 1.8s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(53,224,201,0.5); }
            70% { box-shadow: 0 0 0 9px rgba(53,224,201,0); }
            100% { box-shadow: 0 0 0 0 rgba(53,224,201,0); }
        }

        .status-bar .label {
            font-family: var(--mono); font-size: 0.78rem; font-weight: 600; letter-spacing: 0.06em;
            color: #b7f6ea;
        }

        .status-bar .sub { font-family: var(--mono); font-size: 0.7rem; color: var(--muted); }

        /* ---------- dashboard grid ---------- */
        .dash {
            display: grid;
            grid-template-columns: 0.85fr 1.4fr;
            gap: 20px;
        }

        @media (max-width: 760px) {
            .dash { grid-template-columns: 1fr; }
        }

        /* clearance panel */
        .clearance {
            background: var(--panel-solid);
            border: 1px solid var(--border-strong);
            border-radius: 18px;
            padding: 30px 26px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            box-shadow: 0 30px 70px rgba(0,0,0,0.45);
        }

        .badge-hex {
            width: 92px;
            height: 92px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
        }

        .badge-hex svg { position: absolute; inset: 0; }

        .badge-hex .initial {
            position: relative;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 1.7rem;
            color: #05070f;
        }

        .clearance h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 1.15rem;
            margin-bottom: 6px;
        }

        .clearance .role {
            font-family: var(--mono);
            font-size: 0.72rem;
            color: var(--muted);
            margin-bottom: 18px;
        }

        .verified {
            display: inline-flex; align-items: center; gap: 6px;
            font-family: var(--mono); font-size: 0.66rem; font-weight: 600; letter-spacing: 0.06em;
            color: #b7f6ea; background: rgba(53,224,201,0.1); border: 1px solid rgba(53,224,201,0.3);
            padding: 6px 12px; border-radius: 999px; margin-bottom: 26px;
        }

        .clearance-meta {
            width: 100%;
            text-align: left;
        }

        .clearance-meta .row {
            padding: 11px 0;
            border-top: 1px solid var(--border);
        }
        .clearance-meta .row:last-child { border-bottom: 1px solid var(--border); }

        .clearance-meta .row b {
            display: block;
            font-family: var(--mono);
            font-size: 0.6rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 3px;
            font-weight: 500;
        }

        .clearance-meta .row span { font-size: 0.85rem; font-weight: 500; }

        /* record panel */
        .record {
            background: var(--panel-solid);
            border: 1px solid var(--border-strong);
            border-radius: 18px;
            padding: 28px 28px 24px;
            box-shadow: 0 30px 70px rgba(0,0,0,0.45);
            display: flex;
            flex-direction: column;
        }

        .kicker {
            font-family: var(--mono); font-size: 0.66rem; font-weight: 500;
            letter-spacing: 0.14em; color: var(--accent); margin-bottom: 8px;
        }

        .record h2 {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 22px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 6px;
        }

        .info-row {
            background: rgba(140,160,255,0.05);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 13px 15px;
        }

        .info-row.wide { grid-column: 1 / -1; }

        .info-row .label {
            display: block; font-family: var(--mono); font-size: 0.62rem; font-weight: 500;
            letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted); margin-bottom: 5px;
        }

        .info-row .value { font-size: 0.88rem; font-weight: 500; word-break: break-word; }

        .about {
            margin-top: 14px;
            font-size: 0.85rem;
            color: var(--muted);
            line-height: 1.65;
            border-left: 2px solid var(--accent);
            padding-left: 14px;
        }

        /* route trace / terminal log footer */
        .trace {
            margin-top: auto;
            padding-top: 22px;
        }

        .trace .log {
            background: rgba(0,0,0,0.35);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px 14px;
            font-family: var(--mono);
            font-size: 0.72rem;
            line-height: 1.9;
            color: var(--muted);
        }

        .trace .log .ok { color: var(--accent-2); }
        .trace .log .cursor {
            display: inline-block; width: 6px; height: 12px; background: var(--accent-2);
            vertical-align: middle; margin-left: 4px; animation: blink 1s step-end infinite;
        }

        @keyframes blink { 50% { opacity: 0; } }

        nav { display: flex; gap: 10px; margin-top: 16px; }

        nav a {
            text-decoration: none; font-family: var(--mono); font-weight: 600; font-size: 0.76rem;
            letter-spacing: 0.03em; padding: 11px 20px; border-radius: 11px;
        }

        nav a.primary-link {
            background: linear-gradient(135deg, var(--accent-2), var(--accent));
            color: #05070f;
        }

        nav a.secondary-link {
            color: var(--muted);
            border: 1px solid var(--border-strong);
            background: transparent;
        }
    </style>
    <link rel="stylesheet" href="<?= base_url('css/student-portal.css') ?>">
</head>
<body>
    <div class="portal-shell">
        <header class="portal-header">
            <a class="brand" href="<?= site_url('student') ?>"><span class="brand-mark">K</span><span><span class="brand-name">KASHIOFEYA</span><span class="brand-sub">STUDENT PORTAL</span></span></a>
            <nav class="portal-nav" aria-label="Portal navigation"><a href="<?= site_url('student') ?>">ACCESS</a><a class="active" href="<?= site_url('student/profile') ?>">PROFILE</a></nav>
        </header>

        <main>
            <div class="profile-head"><span class="eyebrow">Private student record</span><h1>A little more <em>about Kashiofeya.</em></h1></div>
            <div class="status-bar"><div class="left"><span class="pulse"></span><span>ACCESS GRANTED</span></div><span class="sub">verified by StudentMiddleware &middot; session key: portal_unlocked=true</span></div>
            <div class="profile-grid">
                <section class="profile-card">
                    <div class="identity"><div class="avatar"><?= strtoupper(substr($name, 0, 1)) ?></div><div><h2><?= htmlspecialchars($name) ?></h2><div class="role"><?= htmlspecialchars($course) ?></div></div></div>
                    <span class="verified">&#10003; VERIFIED IDENTITY</span>
                    <div class="meta-row"><b>Student ID</b><span><?= htmlspecialchars($student_id) ?></span></div>
                    <div class="meta-row"><b>Year &amp; Section</b><span><?= htmlspecialchars($year) ?> &middot; <?= htmlspecialchars($section) ?></span></div>
                    <?php if (!empty($address ?? null)): ?><div class="meta-row"><b>Address</b><span><?= htmlspecialchars($address) ?></span></div><?php endif; ?>
                    <?php if (!empty($social ?? null)): ?><div class="meta-row"><b>Social / Portfolio</b><span><?= htmlspecialchars($social) ?></span></div><?php endif; ?>
                </section>
                <section class="profile-card record">
                    <span class="kicker">Student record</span><h2>Additional information</h2>
                    <div class="info-grid">
                        <div class="info-row wide"><span class="label">Email</span><span class="value"><?= htmlspecialchars($email) ?></span></div>
                        <?php if (!empty($contact ?? null)): ?><div class="info-row"><span class="label">Contact No.</span><span class="value"><?= htmlspecialchars($contact) ?></span></div><?php endif; ?>
                        <?php if (!empty($skills ?? null)): ?><div class="info-row <?= empty($contact ?? null) ? 'wide' : '' ?>"><span class="label">Skills</span><span class="value"><?= htmlspecialchars($skills) ?></span></div><?php endif; ?>
                        <?php if (!empty($hobbies ?? null)): ?><div class="info-row wide"><span class="label">Hobbies</span><span class="value"><?= htmlspecialchars($hobbies) ?></span></div><?php endif; ?>
                    </div>
                    <?php if (!empty($description ?? null)): ?><p class="about">&ldquo;<?= htmlspecialchars($description) ?>&rdquo;</p><?php endif; ?>
                    <div class="trace">
                        <div class="trace-heading"><span>Verification path</span><span class="trace-status">COMPLETE</span></div>
                        <ol class="route-steps">
                            <li><span class="step-number">01</span><span><b>GET /student/profile</b><small>Request received</small></span></li>
                            <li><span class="step-number">02</span><span><b>StudentMiddleware::handle()</b><small class="ok">Access allowed</small></span></li>
                            <li><span class="step-number">03</span><span><b>StudentController::profile()</b><small>Student data loaded</small></span></li>
                            <li><span class="step-number">04</span><span><b>student_profile.php</b><small>View rendered</small></span></li>
                        </ol>
                        <nav class="actions"><a class="button" href="<?= site_url('student') ?>">Back to access</a><a class="button secondary" href="<?= site_url('student/lock') ?>">Lock portal</a></nav>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
