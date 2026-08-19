<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Student Portal') ?></title>
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

        /* ambient glow field */
        .glow-field {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background:
                radial-gradient(560px 420px at 22% -6%, rgba(59, 91, 255, 0.32), transparent 70%),
                radial-gradient(620px 480px at 88% 8%, rgba(139, 92, 246, 0.24), transparent 70%),
                radial-gradient(900px 700px at 50% 120%, rgba(53, 224, 201, 0.06), transparent 70%);
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
            max-width: 1120px;
            margin: 0 auto;
            padding: 34px 24px 60px;
        }

        /* ---------- top bar ---------- */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 56px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .brand .mark {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand .word {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 0.01em;
        }

        .brand .word span {
            color: var(--muted);
            font-weight: 500;
            font-family: var(--mono);
            font-size: 0.72rem;
            display: block;
            letter-spacing: 0.14em;
            margin-top: 1px;
        }

        .navpills {
            display: flex;
            gap: 6px;
            background: var(--panel);
            border: 1px solid var(--border);
            padding: 4px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .navpills a {
            text-decoration: none;
            font-family: var(--mono);
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.04em;
            color: var(--muted);
            padding: 8px 16px;
            border-radius: 9px;
        }

        .navpills a.active {
            background: linear-gradient(135deg, var(--glow-blue), var(--glow-violet));
            color: #fff;
        }

        /* ---------- hero + terminal ---------- */
        .stage {
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 30px;
            align-items: start;
        }

        @media (max-width: 880px) {
            .stage { grid-template-columns: 1fr; }
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-family: var(--mono);
            font-size: 0.68rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            color: var(--accent-2);
            background: rgba(53, 224, 201, 0.08);
            border: 1px solid rgba(53, 224, 201, 0.28);
            padding: 6px 12px;
            border-radius: 999px;
            margin-bottom: 22px;
        }

        .eyebrow .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent-2);
            box-shadow: 0 0 8px var(--accent-2);
        }

        h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: clamp(1.7rem, 3.4vw, 2.5rem);
            line-height: 1.22;
            letter-spacing: -0.01em;
            margin-bottom: 18px;
        }

        h1 em {
            font-style: normal;
            background: linear-gradient(120deg, var(--accent), var(--accent-2));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .lead {
            color: var(--muted);
            font-size: 0.95rem;
            line-height: 1.7;
            max-width: 440px;
            margin-bottom: 40px;
        }

        .lead code {
            font-family: var(--mono);
            background: rgba(140,160,255,0.08);
            border: 1px solid var(--border);
            padding: 1px 6px;
            border-radius: 5px;
            color: var(--text);
            font-size: 0.85em;
        }

        /* stat strip */
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        @media (max-width: 460px) {
            .stats { grid-template-columns: 1fr; }
        }

        .stat {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px 16px;
            backdrop-filter: blur(10px);
        }

        .stat .k {
            display: block;
            font-family: var(--mono);
            font-size: 0.62rem;
            letter-spacing: 0.1em;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .stat .v {
            font-family: var(--mono);
            font-size: 0.86rem;
            font-weight: 500;
        }

        .stat .v.ok { color: var(--accent-2); }
        .stat .v.no { color: var(--danger); }

        /* ---------- terminal card ---------- */
        .terminal {
            background: var(--panel-solid);
            border: 1px solid var(--border-strong);
            border-radius: 18px;
            padding: 0;
            box-shadow: 0 30px 70px rgba(0,0,0,0.5), 0 0 0 1px rgba(140,160,255,0.03);
            overflow: hidden;
        }

        .terminal .bar {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 13px 18px;
            border-bottom: 1px solid var(--border);
            background: rgba(140,160,255,0.03);
        }

        .terminal .bar .chip {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: rgba(140,160,255,0.18);
        }

        .terminal .bar .path {
            margin-left: 8px;
            font-family: var(--mono);
            font-size: 0.7rem;
            color: var(--muted);
            letter-spacing: 0.02em;
        }

        .terminal .body {
            padding: 28px 26px 26px;
        }

        .kicker {
            font-family: var(--mono);
            font-size: 0.66rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            color: var(--accent);
            margin-bottom: 10px;
        }

        .terminal h2 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .terminal .desc {
            font-size: 0.84rem;
            color: var(--muted);
            line-height: 1.65;
            margin-bottom: 20px;
        }

        .terminal .desc code {
            font-family: var(--mono);
            background: rgba(140,160,255,0.08);
            padding: 1px 6px;
            border-radius: 5px;
            color: var(--text);
        }

        .flash {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            font-size: 0.8rem;
            font-weight: 500;
            padding: 12px 14px;
            border-radius: 11px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .flash .led {
            width: 7px;
            height: 7px;
            margin-top: 5px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .flash.ok { background: rgba(53,224,201,0.08); border: 1px solid rgba(53,224,201,0.28); color: #b7f6ea; }
        .flash.ok .led { background: var(--accent-2); box-shadow: 0 0 8px var(--accent-2); }

        .flash.err { background: rgba(255,92,114,0.08); border: 1px solid rgba(255,92,114,0.3); color: #ffc4cd; }
        .flash.err .led { background: var(--danger); box-shadow: 0 0 8px var(--danger); }

        .flash.locked { background: rgba(140,160,255,0.06); border: 1px solid var(--border-strong); color: var(--muted); }
        .flash.locked .led { background: var(--muted); }

        form label {
            display: block;
            font-family: var(--mono);
            font-size: 0.66rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            color: var(--muted);
            margin-bottom: 9px;
        }

        .pin-row {
            display: flex;
            gap: 10px;
        }

        input[name="pin"] {
            flex: 1;
            min-width: 0;
            font-family: var(--mono);
            font-weight: 600;
            font-size: 1.25rem;
            letter-spacing: 0.55em;
            text-align: center;
            padding: 14px 10px 14px 22px;
            border-radius: 12px;
            border: 1px solid var(--border-strong);
            background: rgba(0,0,0,0.35);
            color: var(--text);
            outline: none;
        }

        input[name="pin"]::placeholder { color: rgba(140,160,255,0.3); letter-spacing: 0.55em; }
        input[name="pin"]:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(91,140,255,0.15); }

        button[type="submit"] {
            font-family: var(--mono);
            font-weight: 600;
            font-size: 0.78rem;
            letter-spacing: 0.06em;
            color: #05070f;
            background: linear-gradient(135deg, var(--accent-2), var(--accent));
            border: none;
            padding: 14px 22px;
            border-radius: 12px;
            cursor: pointer;
            transition: filter 0.15s ease, transform 0.15s ease;
        }

        button[type="submit"]:hover { filter: brightness(1.08); transform: translateY(-1px); }

        .hint {
            margin-top: 18px;
            font-size: 0.75rem;
            color: var(--muted);
            line-height: 1.65;
        }

        .hint code {
            font-family: var(--mono);
            background: rgba(140,160,255,0.08);
            padding: 1px 6px;
            border-radius: 5px;
            color: var(--text);
        }

        .profile-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 18px;
            text-decoration: none;
            font-family: var(--mono);
            font-weight: 500;
            font-size: 0.8rem;
            color: var(--accent-2);
        }

        .stage-bottom {
            margin-top: 30px;
        }
    </style>
    <link rel="stylesheet" href="<?= base_url('css/student-portal.css') ?>">
</head>
<body>
    <div class="portal-shell">
        <header class="portal-header">
            <a class="brand" href="<?= site_url('student') ?>">
                <span class="brand-mark">S</span>
                <span><span class="brand-name">KASHIOFEYA</span><span class="brand-sub">STUDENT PORTAL</span></span>
            </a>
            <nav class="portal-nav" aria-label="Portal navigation">
                <a class="active" href="<?= site_url('student') ?>">ACCESS</a>
                <a href="<?= site_url('student/profile') ?>">PROFILE</a>
            </nav>
        </header>

        <main class="access-layout">
            <section>
                <span class="eyebrow">Private student record</span>
                <h1>Your profile, <em>kept personal.</em></h1>
                <p class="lead">A calm, secure home for Kashiofeya's student information. Enter the four-digit access PIN to continue to the protected profile.</p>
                <div class="stats">
                    <div class="stat"><span class="k">ROUTE</span><span class="v">GET /student</span></div>
                    <div class="stat"><span class="k">GUARD</span><span class="v">StudentMiddleware</span></div>
                    <div class="stat"><span class="k">STATUS</span><span class="v <?= $unlocked ? 'ok' : 'no' ?>"><?= $unlocked ? 'UNLOCKED' : 'LOCKED' ?></span></div>
                </div>
            </section>

            <section class="access-card" aria-labelledby="access-title">
                <div class="card-top"><span class="lights"><i></i><i></i><i></i></span><span>student / access</span></div>
                <div class="card-body">
                    <span class="kicker">Welcome back</span>
                    <h2 id="access-title">Unlock your profile</h2>
                    <p class="desc">This page is protected by StudentMiddleware. Enter your personal access PIN below.</p>
                    <?php if (!empty($message)):
                        $tone = 'locked';
                        if (stripos($message, 'granted') !== false) $tone = 'ok';
                        elseif (stripos($message, 'incorrect') !== false) $tone = 'err';
                    ?>
                        <div class="flash <?= $tone ?>"><span class="led"></span><span><?= htmlspecialchars($message) ?></span></div>
                    <?php elseif (!$unlocked): ?>
                        <div class="flash locked"><span class="led"></span><span>Profile access is currently locked.</span></div>
                    <?php endif; ?>
                    <form action="<?= site_url('student/verify') ?>" method="post">
                        <label for="pin">Four-digit access PIN</label>
                        <div class="pin-row">
                            <input type="text" id="pin" name="pin" inputmode="numeric" maxlength="4" autocomplete="off" placeholder="••••" required>
                            <button type="submit">Continue</button>
                        </div>
                    </form>
                    <p class="hint">Your PIN is used only to verify this session before the profile page renders.</p>
                    <?php if ($unlocked): ?><a class="profile-link" href="<?= site_url('student/profile') ?>">View student profile &rarr;</a><?php endif; ?>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
