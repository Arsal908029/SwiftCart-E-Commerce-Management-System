<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — SwiftCart</title>
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
            --rose: #ff4d6d;
            --text: #e2e8f4;
            --muted: #64748b;
            --glow-cyan: 0 0 40px rgba(0,229,255,0.25);
            --glow-lime: 0 0 40px rgba(184,255,87,0.2);
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
        .orb { position: fixed; border-radius: 50%; filter: blur(90px); pointer-events: none; z-index: 0; }
        .orb-1 { width: 500px; height: 500px; background: rgba(0,229,255,0.06); top: -150px; left: -100px; }
        .orb-2 { width: 400px; height: 400px; background: rgba(184,255,87,0.06); bottom: -100px; right: -100px; }

        /* ── LEFT PANEL ── */
        .left-panel {
            background: linear-gradient(160deg, rgba(184,255,87,0.04) 0%, rgba(0,229,255,0.06) 100%);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .left-panel::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(184,255,87,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(184,255,87,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }

        .brand {
            font-family: 'Clash Display', sans-serif;
            font-weight: 700; font-size: 1.5rem;
            text-decoration: none;
            display: flex; align-items: center; gap: 0.5rem;
            letter-spacing: -0.02em;
            position: relative; z-index: 1;
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

        .panel-content { position: relative; z-index: 1; }

        .panel-eyebrow {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(184,255,87,0.08);
            border: 1px solid rgba(184,255,87,0.2);
            color: var(--lime);
            font-size: 0.7rem; font-weight: 600;
            letter-spacing: 0.1em; text-transform: uppercase;
            padding: 0.35rem 0.9rem;
            border-radius: 100px;
            margin-bottom: 1.5rem;
        }
        .eyebrow-dot { width: 5px; height: 5px; background: var(--lime); border-radius: 50%; }

        .panel-content h2 {
            font-family: 'Clash Display', sans-serif;
            font-size: clamp(2rem, 3.5vw, 3rem);
            font-weight: 700; line-height: 1.05;
            letter-spacing: -0.04em; margin-bottom: 1.25rem;
            color: var(--text);
        }
        .panel-content h2 .highlight {
            background: linear-gradient(90deg, var(--lime), var(--cyan));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .panel-content p { color: var(--muted); font-size: 0.95rem; line-height: 1.75; max-width: 340px; margin-bottom: 2rem; }

        .steps-list { position: relative; z-index: 1; }
        .step-item {
            display: flex; align-items: flex-start; gap: 1rem;
            margin-bottom: 1.25rem;
        }
        .step-num-badge {
            width: 30px; height: 30px; min-width: 30px;
            border-radius: 50%;
            background: rgba(184,255,87,0.1);
            border: 1px solid rgba(184,255,87,0.2);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Clash Display', sans-serif;
            font-size: 0.78rem; font-weight: 700;
            color: var(--lime);
        }
        .step-text { font-size: 0.85rem; color: var(--muted); line-height: 1.6; padding-top: 0.3rem; }

        .panel-footer { font-size: 0.78rem; color: var(--muted); position: relative; z-index: 1; }

        /* ── RIGHT PANEL ── */
        .right-panel {
            background: var(--deep);
            display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            padding: 3rem 3.5rem;
            position: relative; z-index: 1;
            overflow-y: auto;
        }

        .form-box { width: 100%; max-width: 420px; }

        .form-box h1 {
            font-family: 'Clash Display', sans-serif;
            font-size: 2rem; font-weight: 700;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem; color: var(--text);
        }
        .form-box .sub { color: var(--muted); font-size: 0.9rem; margin-bottom: 1.75rem; }
        .form-box .sub a { color: var(--cyan); font-weight: 600; text-decoration: none; }
        .form-box .sub a:hover { color: #00f0ff; text-decoration: underline; }

        .form-label {
            font-family: 'Clash Display', sans-serif;
            font-size: 0.75rem; font-weight: 600;
            letter-spacing: 0.08em; text-transform: uppercase;
            color: var(--muted); margin-bottom: 0.4rem; display: block;
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
        .invalid-feedback { font-size: 0.78rem; color: #fca5a5; margin-top: 0.25rem; display: block; }

        .input-group { display: flex; }
        .input-group .form-control { border-radius: 12px 0 0 12px; border-right: none; }
        .btn-toggle-pw {
            background: var(--panel); border: 1px solid var(--border2);
            border-left: none; border-radius: 0 12px 12px 0;
            color: var(--muted); padding: 0 1rem; cursor: pointer; transition: color 0.2s, background 0.2s;
        }
        .btn-toggle-pw:hover { color: var(--cyan); background: var(--panel2); }
        .input-group:focus-within .btn-toggle-pw { border-color: var(--cyan); }

        /* ── ROLE SELECTOR ── */
        .role-selector { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1.25rem; }
        .role-option { display: none; }
        .role-label {
            display: flex; flex-direction: column; align-items: center; gap: 0.4rem;
            border: 1px solid var(--border2);
            border-radius: 14px; padding: 1.1rem 0.75rem;
            cursor: pointer; transition: all 0.2s; text-align: center;
            background: var(--panel);
        }
        .role-label i { font-size: 1.4rem; color: var(--muted); transition: color 0.2s; }
        .role-label .r-title { font-family: 'Clash Display', sans-serif; font-size: 0.875rem; font-weight: 600; color: var(--text); }
        .role-label .r-desc { font-size: 0.72rem; color: var(--muted); line-height: 1.4; }

        /* Buyer selected = cyan theme */
        #role_buyer:checked + .role-label {
            border-color: var(--cyan);
            background: rgba(0,229,255,0.08);
            box-shadow: 0 0 0 3px rgba(0,229,255,0.08);
        }
        #role_buyer:checked + .role-label i,
        #role_buyer:checked + .role-label .r-title { color: var(--cyan); }

        /* Admin selected = lime theme */
        #role_admin:checked + .role-label {
            border-color: var(--lime);
            background: rgba(184,255,87,0.08);
            box-shadow: 0 0 0 3px rgba(184,255,87,0.08);
        }
        #role_admin:checked + .role-label i,
        #role_admin:checked + .role-label .r-title { color: var(--lime); }

        .btn-submit {
            width: 100%;
            background: var(--cyan); color: var(--void);
            font-family: 'Clash Display', sans-serif; font-weight: 700; font-size: 1rem;
            padding: 0.9rem; border: none; border-radius: 12px;
            cursor: pointer; transition: all 0.25s; margin-top: 0.25rem;
            display: flex; align-items: center; justify-content: center; gap: 0.6rem;
        }
        .btn-submit:hover { background: #00f0ff; transform: translateY(-2px); box-shadow: var(--glow-cyan); }

        .error-msg {
            background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.25);
            border-radius: 10px; padding: 0.75rem 1rem;
            font-size: 0.875rem; color: #fca5a5; margin-bottom: 1.5rem;
            display: flex; align-items: center; gap: 0.5rem;
        }

        .signin-link { text-align: center; margin-top: 1.5rem; font-size: 0.875rem; color: var(--muted); }
        .signin-link a { color: var(--cyan); font-weight: 600; text-decoration: none; }
        .signin-link a:hover { color: #00f0ff; text-decoration: underline; }

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
            New Account
        </div>
        <h2>Join<br><span class="highlight">SwiftCart</span><br>Today.</h2>
        <p>Create your account in seconds. Choose your role and get instant access to your personalized dashboard.</p>
    </div>

    <div class="steps-list">
        <div class="step-item">
            <div class="step-num-badge">1</div>
            <div class="step-text">Fill in your basic details and choose a secure password.</div>
        </div>
        <div class="step-item">
            <div class="step-num-badge">2</div>
            <div class="step-text">Select your role — Admin for management, Buyer for shopping.</div>
        </div>
        <div class="step-item">
            <div class="step-num-badge">3</div>
            <div class="step-text">You're automatically redirected to your role-specific dashboard.</div>
        </div>
    </div>

    <div class="panel-footer">SwiftCart &copy; {{ date('Y') }}. Built with Laravel.</div>
</div>

<!-- Right Panel -->
<div class="right-panel">
    <div class="form-box">
        <h1>Create Account</h1>
        <p class="sub">Already have one? <a href="{{ route('login') }}">Sign in →</a></p>

        @if($errors->any())
        <div class="error-msg">
            <i class="fas fa-circle-exclamation"></i>
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Role Selector -->
            <div class="mb-3">
                <label class="form-label">I am a...</label>
                <div class="role-selector">
                    <div>
                        <input type="radio" name="role" id="role_admin" class="role-option" value="admin" {{ old('role') === 'admin' ? 'checked' : '' }}>
                        <label for="role_admin" class="role-label">
                            <i class="fas fa-shield-halved"></i>
                            <span class="r-title">Admin</span>
                            <span class="r-desc">Manage products & orders</span>
                        </label>
                    </div>
                    <div>
                        <input type="radio" name="role" id="role_buyer" class="role-option" value="buyer" {{ old('role', 'buyer') === 'buyer' ? 'checked' : '' }}>
                        <label for="role_buyer" class="role-label">
                            <i class="fas fa-bag-shopping"></i>
                            <span class="r-title">Buyer</span>
                            <span class="r-desc">Browse & purchase products</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" placeholder="you@example.com" required>
                @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="pw"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Min. 8 characters" required>
                    <button type="button" class="btn-toggle-pw" onclick="togglePw('pw','pw-icon')">
                        <i class="fas fa-eye" id="pw-icon"></i>
                    </button>
                </div>
                @error('password')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <div class="input-group">
                    <input type="password" name="password_confirmation" id="pw2" class="form-control" placeholder="Repeat password" required>
                    <button type="button" class="btn-toggle-pw" onclick="togglePw('pw2','pw2-icon')">
                        <i class="fas fa-eye" id="pw2-icon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-user-plus"></i> Create Account
            </button>
        </form>

        <p class="signin-link">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
    </div>
</div>

<script>
function togglePw(id, iconId) {
    const pw = document.getElementById(id);
    const icon = document.getElementById(iconId);
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
