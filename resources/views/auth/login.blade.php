<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — SwiftCart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@400;500;600;700&family=Bricolage+Grotesque:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --void: #080b14;
            --deep: #0f1623;
            --panel: #151d2e;
            --panel2: #1a2236;
            --border: rgba(255,255,255,0.07);
            --border2: rgba(255,255,255,0.12);
            --cyan: #00e5ff;
            --lime: #b8ff57;
            --violet: #8b5cf6;
            --text: #e2e8f4;
            --muted: #64748b;
            --glow-cyan: 0 0 40px rgba(0,229,255,0.25);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Bricolage Grotesque', sans-serif;
            background: var(--void);
            color: var(--text);
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* ── ORBS ── */
        .orb {
            position: fixed; border-radius: 50%;
            filter: blur(90px); pointer-events: none; z-index: 0;
        }
        .orb-1 { width: 500px; height: 500px; background: rgba(0,229,255,0.07); top: -150px; left: -100px; }
        .orb-2 { width: 400px; height: 400px; background: rgba(139,92,246,0.08); bottom: -100px; right: -100px; }

        /* ── LEFT PANEL ── */
        .left-panel {
            background: linear-gradient(160deg, rgba(0,229,255,0.05) 0%, rgba(139,92,246,0.08) 100%);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        /* Decorative grid lines */
        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(0,229,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,229,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }

        .brand {
            font-family: 'Clash Display', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: -0.02em;
            position: relative;
            z-index: 1;
        }
        .brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--cyan), var(--violet));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
        }
        .brand-text { color: var(--text); }
        .brand-text span { color: var(--cyan); }

        .panel-content {
            position: relative;
            z-index: 1;
        }

        .panel-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(0,229,255,0.08);
            border: 1px solid rgba(0,229,255,0.2);
            color: var(--cyan);
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.35rem 0.9rem;
            border-radius: 100px;
            margin-bottom: 1.5rem;
        }
        .eyebrow-dot { width: 5px; height: 5px; background: var(--cyan); border-radius: 50%; }

        .panel-content h2 {
            font-family: 'Clash Display', sans-serif;
            font-size: clamp(2rem, 3.5vw, 3rem);
            font-weight: 700;
            line-height: 1.05;
            letter-spacing: -0.04em;
            margin-bottom: 1.25rem;
            color: var(--text);
        }
        .panel-content h2 .highlight {
            background: linear-gradient(90deg, var(--cyan), var(--lime));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .panel-content p {
            color: var(--muted);
            font-size: 0.95rem;
            line-height: 1.75;
            max-width: 340px;
        }

        .portal-pills {
            display: flex;
            gap: 0.75rem;
            margin-top: 2.5rem;
            flex-wrap: wrap;
        }
        .portal-pill {
            display: flex; align-items: center; gap: 0.5rem;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border2);
            border-radius: 100px;
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            font-family: 'Clash Display', sans-serif;
            font-weight: 600;
            color: var(--text);
        }
        .portal-pill.cyan i { color: var(--cyan); }
        .portal-pill.lime i { color: var(--lime); }

        .panel-footer {
            font-size: 0.78rem;
            color: var(--muted);
            position: relative;
            z-index: 1;
        }

        /* ── RIGHT PANEL ── */
        .right-panel {
            background: var(--deep);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 3.5rem;
            position: relative;
            z-index: 1;
        }

        .form-box { width: 100%; max-width: 400px; }

        .form-box h1 {
            font-family: 'Clash Display', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
            color: var(--text);
        }

        .form-box .sub {
            color: var(--muted);
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }
        .form-box .sub a {
            color: var(--cyan);
            font-weight: 600;
            text-decoration: none;
        }
        .form-box .sub a:hover { color: #00f0ff; text-decoration: underline; }

        .form-label {
            font-family: 'Clash Display', sans-serif;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 0.4rem;
            display: block;
        }

        .form-control {
            background: var(--panel);
            border: 1px solid var(--border2);
            border-radius: 12px;
            padding: 0.8rem 1rem;
            font-size: 0.95rem;
            font-family: 'Bricolage Grotesque', sans-serif;
            color: var(--text);
            transition: all 0.2s;
            width: 100%;
        }
        .form-control::placeholder { color: var(--muted); }
        .form-control:focus {
            outline: none;
            border-color: var(--cyan);
            background: var(--panel2);
            box-shadow: 0 0 0 3px rgba(0,229,255,0.08);
        }
        .form-control.is-invalid { border-color: #ef4444; }

        .input-group { display: flex; }
        .input-group .form-control { border-radius: 12px 0 0 12px; border-right: none; }
        .btn-toggle-pw {
            background: var(--panel);
            border: 1px solid var(--border2);
            border-left: none;
            border-radius: 0 12px 12px 0;
            color: var(--muted);
            padding: 0 1rem;
            cursor: pointer;
            transition: color 0.2s, background 0.2s;
        }
        .btn-toggle-pw:hover { color: var(--cyan); background: var(--panel2); }
        .input-group:focus-within .btn-toggle-pw {
            border-color: var(--cyan);
        }

        .remember-row {
            display: flex; justify-content: space-between; align-items: center;
            margin: 1.25rem 0;
            font-size: 0.875rem;
        }
        .remember-row .form-check-label { color: var(--muted); }
        .form-check-input { background-color: var(--panel); border-color: var(--border2); }
        .form-check-input:checked { background-color: var(--cyan); border-color: var(--cyan); }

        .btn-submit {
            width: 100%;
            background: var(--cyan);
            color: var(--void);
            font-family: 'Clash Display', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            padding: 0.9rem;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.25s;
            display: flex; align-items: center; justify-content: center; gap: 0.6rem;
        }
        .btn-submit:hover {
            background: #00f0ff;
            transform: translateY(-2px);
            box-shadow: var(--glow-cyan);
        }

        .divider {
            text-align: center;
            position: relative;
            margin: 1.5rem 0;
            font-size: 0.8rem;
            color: var(--muted);
        }
        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 44%;
            height: 1px;
            background: var(--border);
        }
        .divider::before { left: 0; }
        .divider::after { right: 0; }

        .btn-register {
            width: 100%;
            background: transparent;
            color: var(--text);
            font-family: 'Clash Display', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.85rem;
            border: 1px solid var(--border2);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.25s;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        .btn-register:hover {
            border-color: rgba(184,255,87,0.4);
            color: var(--lime);
            background: rgba(184,255,87,0.05);
        }

        .error-msg {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.25);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            color: #fca5a5;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        @media (max-width: 768px) {
            body { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { padding: 2rem 1.5rem; min-height: 100vh; }
        }
    </style>
</head>
<body>

<!-- Orbs -->
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<!-- Left Panel -->
<div class="left-panel">
    <a href="{{ url('/') }}" class="brand">
        <div class="brand-icon">⚡</div>
        <span class="brand-text">Swift<span>Cart</span></span>
    </a>

    <div class="panel-content">
        <div class="panel-eyebrow">
            <div class="eyebrow-dot"></div>
            Welcome Back
        </div>
        <h2>Sign in to<br>your <span class="highlight">SwiftCart</span><br>account.</h2>
        <p>Access your personalized dashboard — whether you're managing inventory or shopping for the best products.</p>
        <div class="portal-pills">
            <div class="portal-pill cyan"><i class="fas fa-shield-halved"></i> Admin Portal</div>
            <div class="portal-pill lime"><i class="fas fa-bag-shopping"></i> Buyer Portal</div>
        </div>
    </div>

    <div class="panel-footer">SwiftCart &copy; {{ date('Y') }}. Built with Laravel.</div>
</div>

<!-- Right Panel -->
<div class="right-panel">
    <div class="form-box">
        <h1>Sign In</h1>
        <p class="sub">
            Don't have an account? <a href="{{ route('register') }}">Create one free →</a>
        </p>

        @if($errors->any())
        <div class="error-msg">
            <i class="fas fa-circle-exclamation"></i>
            {{ $errors->first() }}
        </div>
        @endif

        @if(session('error'))
        <div class="error-msg">
            <i class="fas fa-circle-exclamation"></i>{{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
            </div>

            <div class="mb-1">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="pw" class="form-control" placeholder="••••••••" required>
                    <button type="button" class="btn-toggle-pw" onclick="togglePw()">
                        <i class="fas fa-eye" id="pw-icon"></i>
                    </button>
                </div>
            </div>

            <div class="remember-row">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-arrow-right-to-bracket"></i> Sign In
            </button>
        </form>

        <div class="divider">or</div>
        <a href="{{ route('register') }}" class="btn-register">Create New Account</a>
    </div>
</div>

<script>
function togglePw() {
    const pw = document.getElementById('pw');
    const icon = document.getElementById('pw-icon');
    if (pw.type === 'password') {
        pw.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        pw.type = 'password';
        icon.className = 'fas fa-eye';
    }
}
</script>
</body>
</html>
