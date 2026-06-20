@extends('layouts.app')
@section('title', 'My Profile')
@section('content')
<style>
:root{--void:#080b14;--deep:#0f1623;--panel:#151d2e;--border:rgba(255,255,255,0.07);--cyan:#00e5ff;--lime:#b8ff57;--violet:#8b5cf6;--rose:#ff4d6d;--amber:#fbbf24;--text:#e2e8f4;--muted:#64748b;}
body{background:var(--void);color:var(--text);font-family:'Bricolage Grotesque','Segoe UI',sans-serif;min-height:100vh;}
.prof-wrap{max-width:900px;margin:0 auto;padding:3rem 1.5rem 5rem;}
.back-link{display:inline-flex;align-items:center;gap:.4rem;font-size:.8rem;color:var(--muted);text-decoration:none;margin-bottom:2rem;transition:color .2s;}
.back-link:hover{color:var(--cyan);}
.kicker{display:inline-flex;align-items:center;gap:.5rem;font-size:.72rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:var(--cyan);margin-bottom:.75rem;}
.kicker-dot{width:6px;height:6px;background:var(--cyan);border-radius:50%;animation:pulse 2s ease-in-out infinite;}
.page-title{font-family:'Clash Display',serif;font-size:2.2rem;font-weight:700;letter-spacing:-.04em;margin-bottom:.3rem;}
.page-title span{background:linear-gradient(90deg,var(--cyan),var(--lime));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}

/* Avatar card */
.avatar-card{background:var(--panel);border:1px solid var(--border);border-radius:20px;padding:2rem;display:flex;align-items:center;gap:1.5rem;margin-bottom:2rem;animation:fadeUp .6s ease .1s both;}
.avatar-img{width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid rgba(0,229,255,.3);}
.avatar-placeholder{width:90px;height:90px;border-radius:50%;background:rgba(0,229,255,.08);border:3px solid rgba(0,229,255,.3);display:flex;align-items:center;justify-content:center;font-size:2.2rem;color:var(--cyan);flex-shrink:0;}
.avatar-info .user-name{font-family:'Clash Display',sans-serif;font-size:1.4rem;font-weight:700;color:var(--text);}
.avatar-info .user-email{font-size:.85rem;color:var(--muted);}
.role-badge{background:rgba(184,255,87,.1);border:1px solid rgba(184,255,87,.2);color:var(--lime);font-size:.72rem;font-weight:700;padding:.2rem .7rem;border-radius:6px;text-transform:uppercase;letter-spacing:.08em;margin-top:.4rem;display:inline-block;}

/* Tabs */
.tab-row{display:flex;gap:.5rem;margin-bottom:1.5rem;background:var(--panel);border:1px solid var(--border);border-radius:14px;padding:.4rem;animation:fadeUp .6s ease .15s both;}
.tab-btn{flex:1;padding:.65rem 1rem;border:none;background:transparent;color:var(--muted);font-size:.875rem;font-family:'Bricolage Grotesque',sans-serif;border-radius:10px;cursor:pointer;transition:all .2s;text-align:center;}
.tab-btn.active{background:rgba(0,229,255,.1);color:var(--cyan);font-weight:600;}
.tab-pane{display:none;animation:fadeUp .4s ease both;}
.tab-pane.active{display:block;}

/* Form */
.form-card{background:var(--panel);border:1px solid var(--border);border-radius:20px;padding:2rem;margin-bottom:1.5rem;}
.form-section-title{font-size:.72rem;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);margin-bottom:1.25rem;}
.field-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;}
@media(max-width:600px){.field-grid{grid-template-columns:1fr;}}
.field-full{grid-column:span 2;}
@media(max-width:600px){.field-full{grid-column:span 1;}}
.field{display:flex;flex-direction:column;gap:.4rem;}
.field label{font-size:.78rem;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;}
.field input,.field textarea,.field select{background:var(--deep);border:1px solid var(--border);border-radius:10px;color:var(--text);padding:.75rem 1rem;font-size:.9rem;font-family:inherit;transition:border-color .2s;outline:none;}
.field input:focus,.field textarea:focus{border-color:rgba(0,229,255,.4);}
.btn-save{background:var(--cyan);color:var(--void);font-family:'Clash Display',sans-serif;font-weight:700;font-size:.9rem;padding:.8rem 2rem;border-radius:12px;border:none;cursor:pointer;transition:all .25s;margin-top:.5rem;}
.btn-save:hover{background:#00f0ff;transform:translateY(-2px);box-shadow:0 0 30px rgba(0,229,255,.25);}
.btn-danger{background:rgba(255,77,109,.1);border:1px solid rgba(255,77,109,.2);color:var(--rose);}
.btn-danger:hover{background:var(--rose);color:#fff;}

/* Recent Orders mini */
.order-mini{display:flex;align-items:center;justify-content:space-between;padding:.75rem 1rem;background:rgba(255,255,255,.02);border:1px solid var(--border);border-radius:12px;margin-bottom:.5rem;text-decoration:none;transition:border-color .2s;}
.order-mini:hover{border-color:rgba(0,229,255,.2);}
.om-id{color:var(--cyan);font-size:.85rem;font-weight:600;}
.om-date{font-size:.78rem;color:var(--muted);}
.om-total{font-size:.9rem;color:var(--lime);font-weight:600;}
.status-dot{display:inline-block;width:8px;height:8px;border-radius:50%;margin-right:.4rem;}

@keyframes pulse{0%,100%{opacity:1;}50%{opacity:.4;}}
@keyframes fadeUp{from{opacity:0;transform:translateY(18px);}to{opacity:1;transform:translateY(0);}}
</style>
<link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@400;600;700&family=Bricolage+Grotesque:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="prof-wrap">
    <a href="{{ url('/buyer/dashboard') }}" class="back-link"><i class="fas fa-arrow-left"></i> Dashboard</a>

    <div style="margin-bottom:2rem;animation:fadeUp .6s ease both">
        <div class="kicker"><div class="kicker-dot"></div> Account</div>
        <h1 class="page-title">My <span>Profile</span></h1>
    </div>

    @if(session('success'))<div style="background:rgba(184,255,87,.1);border:1px solid rgba(184,255,87,.2);color:var(--lime);border-radius:10px;padding:.9rem 1.2rem;margin-bottom:1.5rem;font-size:.875rem;">{{ session('success') }}</div>@endif
    @if(session('error'))<div style="background:rgba(255,77,109,.1);border:1px solid rgba(255,77,109,.2);color:var(--rose);border-radius:10px;padding:.9rem 1.2rem;margin-bottom:1.5rem;font-size:.875rem;">{{ session('error') }}</div>@endif

    <!-- Avatar Card -->
    <div class="avatar-card">
        @if($user->avatar)
            <img src="{{ asset('storage/'.$user->avatar) }}" class="avatar-img" alt="Avatar">
        @else
            <div class="avatar-placeholder"><i class="fas fa-user"></i></div>
        @endif
        <div class="avatar-info">
            <div class="user-name">{{ $user->name }}</div>
            <div class="user-email">{{ $user->email }}</div>
            <div class="role-badge">{{ ucfirst($user->role) }}</div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tab-row">
        <button class="tab-btn active" onclick="switchTab('profile',this)"><i class="fas fa-user me-1"></i> Profile</button>
        <button class="tab-btn" onclick="switchTab('security',this)"><i class="fas fa-lock me-1"></i> Security</button>
        <button class="tab-btn" onclick="switchTab('orders',this)"><i class="fas fa-receipt me-1"></i> Orders</button>
        <button class="tab-btn" onclick="switchTab('reviews',this)"><i class="fas fa-star me-1"></i> My Reviews</button>
    </div>

    <!-- Profile Tab -->
    <div class="tab-pane active" id="tab-profile">
        <form action="{{ route('buyer.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-card">
                <div class="form-section-title"><i class="fas fa-id-card me-1"></i> Personal Information</div>
                <div class="field-grid">
                    <div class="field">
                        <label>Full Name</label>
                        <input type="text" name="name" value="{{ old('name',$user->name) }}" required>
                    </div>
                    <div class="field">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone',$user->phone) }}" placeholder="+92 300 0000000">
                    </div>
                    <div class="field">
                        <label>City</label>
                        <input type="text" name="city" value="{{ old('city',$user->city) }}" placeholder="e.g. Peshawar">
                    </div>
                    <div class="field">
                        <label>Date of Birth</label>
                        <input type="date" name="dob" value="{{ old('dob', $user->dob?->format('Y-m-d')) }}">
                    </div>
                    <div class="field field-full">
                        <label>Delivery Address</label>
                        <textarea name="address" rows="2" placeholder="Your default delivery address...">{{ old('address',$user->address) }}</textarea>
                    </div>
                    <div class="field field-full">
                        <label>Profile Picture</label>
                        <input type="file" name="avatar" accept="image/*">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-save"><i class="fas fa-save me-2"></i> Save Changes</button>
        </form>
    </div>

    <!-- Security Tab -->
    <div class="tab-pane" id="tab-security">
        <form action="{{ route('buyer.profile.password') }}" method="POST">
            @csrf
            <div class="form-card">
                <div class="form-section-title"><i class="fas fa-key me-1"></i> Change Password</div>
                <div class="field-grid">
                    <div class="field field-full">
                        <label>Current Password</label>
                        <input type="password" name="current_password" required>
                    </div>
                    <div class="field">
                        <label>New Password</label>
                        <input type="password" name="password" required>
                    </div>
                    <div class="field">
                        <label>Confirm New Password</label>
                        <input type="password" name="password_confirmation" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-save btn-danger"><i class="fas fa-lock me-2"></i> Update Password</button>
        </form>
    </div>

    <!-- Orders Tab -->
    <div class="tab-pane" id="tab-orders">
        <div class="form-card">
            <div class="form-section-title"><i class="fas fa-receipt me-1"></i> Recent Orders</div>
            @forelse($orders as $order)
            @php $si = $order->status_info; @endphp
            <a href="{{ route('buyer.track',['id'=>$order->id]) }}" class="order-mini">
                <div>
                    <span class="om-id">#{{ str_pad($order->id,4,'0',STR_PAD_LEFT) }}</span>
                    <span class="om-date" style="margin-left:.5rem;">{{ $order->created_at->format('d M Y') }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:1rem;">
                    <span style="font-size:.8rem;"><span class="status-dot" style="background:{{ $si['color'] }}"></span>{{ $si['label'] }}</span>
                    <span class="om-total">PKR {{ number_format($order->total_price,0) }}</span>
                </div>
            </a>
            @empty
            <div style="text-align:center;padding:2rem;color:var(--muted);font-size:.9rem;">No orders yet. <a href="{{ url('/buyer/products') }}" style="color:var(--cyan);">Start shopping!</a></div>
            @endforelse
        </div>
        <a href="{{ url('/buyer/orders') }}" style="display:inline-flex;align-items:center;gap:.5rem;color:var(--cyan);font-size:.85rem;text-decoration:none;"><i class="fas fa-arrow-right"></i> View All Orders</a>
    </div>

    <!-- Reviews Tab -->
    <div class="tab-pane" id="tab-reviews">
        <div class="form-card">
            <div class="form-section-title"><i class="fas fa-star me-1"></i> My Feedback</div>
            @forelse($feedbacks as $fb)
            <div style="background:rgba(255,255,255,.02);border:1px solid var(--border);border-radius:12px;padding:1rem;margin-bottom:.75rem;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:.5rem;">
                    <div>
                        @for($i=1;$i<=5;$i++)<i class="fas fa-star" style="color:{{ $i<=$fb->rating?'#fbbf24':'var(--border)' }};font-size:.8rem;"></i>@endfor
                        @if($fb->subject)<span style="font-size:.85rem;font-weight:600;color:var(--text);margin-left:.5rem;">{{ $fb->subject }}</span>@endif
                    </div>
                    <span style="font-size:.75rem;color:var(--muted);">{{ $fb->created_at->format('d M Y') }}</span>
                </div>
                <p style="font-size:.875rem;color:var(--muted);margin:0;">{{ $fb->message }}</p>
            </div>
            @empty
            <div style="text-align:center;padding:2rem;color:var(--muted);font-size:.9rem;">No feedback yet. <a href="{{ route('buyer.feedback') }}" style="color:var(--cyan);">Leave your first review!</a></div>
            @endforelse
        </div>
    </div>
</div>

<script>
function switchTab(name, btn) {
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-'+name).classList.add('active');
    btn.classList.add('active');
}
</script>
@endsection
