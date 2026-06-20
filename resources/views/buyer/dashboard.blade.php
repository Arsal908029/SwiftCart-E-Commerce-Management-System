@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<style>
/* ── Reset for this page ── */
.card { border-radius: 20px !important; }
.card-img-top { border-radius: 16px 16px 0 0 !important; }

/* ── Hero ── */
.hero { position:relative; background:linear-gradient(135deg,rgba(0,229,255,.06) 0%,rgba(139,92,246,.06) 100%); border:1px solid var(--border); border-radius:24px; padding:2.5rem 2rem; margin-bottom:2rem; overflow:hidden; }
.hero::before { content:''; position:absolute; top:-60px; right:-60px; width:220px; height:220px; background:radial-gradient(circle,rgba(0,229,255,.12),transparent 70%); border-radius:50%; pointer-events:none; }
.hero-greeting { font-size:.78rem; font-weight:600; letter-spacing:.12em; text-transform:uppercase; color:var(--cyan); margin-bottom:.5rem; }
.hero-name { font-family:'Clash Display',sans-serif; font-size:2rem; font-weight:700; letter-spacing:-.04em; color:var(--text); margin-bottom:.3rem; }
.hero-name span { background:linear-gradient(90deg,var(--cyan),var(--lime)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.hero-sub { font-size:.9rem; color:var(--muted); }

/* ── Quick actions ── */
.actions-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:.75rem; margin-bottom:2rem; }
@media(max-width:900px){ .actions-grid{grid-template-columns:repeat(3,1fr);} }
@media(max-width:500px){ .actions-grid{grid-template-columns:repeat(2,1fr);} }
.action-tile { display:flex; flex-direction:column; align-items:center; justify-content:center; gap:.5rem; background:var(--panel); border:1px solid var(--border); border-radius:18px; padding:1.25rem .75rem; text-decoration:none; color:var(--muted); transition:all .25s; text-align:center; }
.action-tile:hover { color:var(--text); transform:translateY(-3px); box-shadow:0 12px 30px rgba(0,0,0,.25); }
.action-tile:hover .at-icon { transform:scale(1.1); }
.at-icon { width:44px; height:44px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; transition:transform .25s; flex-shrink:0; }
.at-cyan  { background:rgba(0,229,255,.1);   color:var(--cyan);   border:1px solid rgba(0,229,255,.2); }
.at-lime  { background:rgba(184,255,87,.1);  color:var(--lime);   border:1px solid rgba(184,255,87,.2); }
.at-violet{ background:rgba(139,92,246,.1);  color:var(--violet); border:1px solid rgba(139,92,246,.2); }
.at-amber { background:rgba(251,191,36,.1);  color:#fbbf24;       border:1px solid rgba(251,191,36,.2); }
.at-rose  { background:rgba(255,77,109,.1);  color:var(--rose);   border:1px solid rgba(255,77,109,.2); }
.at-label { font-size:.78rem; font-weight:600; line-height:1.2; }

/* ── Section header ── */
.sec-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem; }
.sec-title { font-family:'Clash Display',sans-serif; font-size:1.25rem; font-weight:700; color:var(--text); display:flex; align-items:center; gap:.5rem; }
.sec-title i { color:var(--cyan); }
.sec-link { font-size:.8rem; color:var(--cyan); text-decoration:none; display:flex; align-items:center; gap:.3rem; transition:gap .2s; }
.sec-link:hover { gap:.6rem; color:var(--cyan); }

/* ── Product grid ── */
.prod-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(230px,1fr)); gap:1.1rem; margin-bottom:2rem; }
.prod-card { background:var(--panel); border:1px solid var(--border); border-radius:20px; overflow:hidden; display:flex; flex-direction:column; transition:all .3s cubic-bezier(.25,.8,.25,1); }
.prod-card:hover { border-color:rgba(0,229,255,.2); transform:translateY(-5px); box-shadow:0 20px 40px rgba(0,0,0,.3); }
.prod-img-wrap { position:relative; width:100%; height:190px; overflow:hidden; background:var(--deep); flex-shrink:0; }
.prod-img-wrap img { width:100%; height:100%; object-fit:cover; display:block; transition:transform .4s ease; }
.prod-card:hover .prod-img-wrap img { transform:scale(1.06); }
.prod-img-ph { width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:var(--muted); font-size:3rem; }
.prod-badge { position:absolute; top:.6rem; right:.6rem; background:rgba(8,11,20,.75); backdrop-filter:blur(8px); border:1px solid var(--border); border-radius:8px; padding:.2rem .55rem; font-size:.68rem; font-weight:700; color:var(--lime); }
.prod-body { padding:1rem 1.1rem 1.2rem; flex:1; display:flex; flex-direction:column; }
.prod-name { font-family:'Clash Display',sans-serif; font-size:.95rem; font-weight:700; color:var(--text); margin-bottom:.3rem; line-height:1.3; }
.prod-desc { font-size:.78rem; color:var(--muted); flex:1; margin-bottom:.65rem; line-height:1.5; }
.prod-foot { display:flex; align-items:center; justify-content:space-between; margin-bottom:.65rem; }
.prod-price { font-family:'Clash Display',sans-serif; font-size:1rem; font-weight:700; color:var(--lime); }
.prod-stock { font-size:.72rem; color:var(--muted); }
.prod-cats { display:flex; flex-wrap:wrap; gap:.25rem; margin-bottom:.65rem; }
.cat-tag { background:rgba(139,92,246,.1); border:1px solid rgba(139,92,246,.2); color:var(--violet); font-size:.65rem; padding:.15rem .45rem; border-radius:5px; }
.add-form { display:flex; gap:.4rem; }
.qty-in { background:var(--deep); border:1px solid var(--border); border-radius:8px; color:var(--text); padding:.5rem .6rem; font-size:.82rem; width:62px; outline:none; font-family:inherit; transition:border-color .2s; text-align:center; }
.qty-in:focus { border-color:rgba(0,229,255,.4); }
.btn-add { flex:1; background:rgba(0,229,255,.08); border:1px solid rgba(0,229,255,.2); color:var(--cyan); font-size:.8rem; font-weight:600; border-radius:8px; padding:.5rem; cursor:pointer; transition:all .2s; font-family:inherit; display:flex; align-items:center; justify-content:center; gap:.35rem; }
.btn-add:hover { background:rgba(0,229,255,.18); }

/* ── Recent orders strip ── */
.order-strip { background:var(--panel); border:1px solid var(--border); border-radius:16px; padding:1rem 1.25rem; display:flex; align-items:center; justify-content:space-between; margin-bottom:.6rem; text-decoration:none; transition:border-color .2s; }
.order-strip:hover { border-color:rgba(0,229,255,.18); }
.os-left { display:flex; align-items:center; gap:.75rem; }
.os-id { font-family:'Clash Display',sans-serif; font-size:.85rem; font-weight:700; color:var(--cyan); }
.os-date { font-size:.75rem; color:var(--muted); }
.os-status { font-size:.72rem; font-weight:700; padding:.22rem .6rem; border-radius:6px; }
.os-total { font-family:'Clash Display',sans-serif; font-size:.95rem; font-weight:700; color:var(--lime); }

@keyframes fadeUp { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
</style>

<div style="animation:fadeUp .5s ease both">

    <!-- Hero -->
    <div class="hero">
        <div class="hero-greeting"><i class="fas fa-bolt me-1"></i> Welcome back</div>
        <div class="hero-name">Hey, <span>{{ Auth::user()->name }}</span> 👋</div>
        <div class="hero-sub">Ready to shop? Browse the latest products or track your orders below.</div>
    </div>

    <!-- Quick Actions -->
    <div class="actions-grid">
        <a href="{{ url('buyer/products') }}" class="action-tile">
            <div class="at-icon at-cyan"><i class="fas fa-box-open"></i></div>
            <span class="at-label">Browse Products</span>
        </a>
        <a href="{{ url('buyer/cart') }}" class="action-tile">
            <div class="at-icon at-lime"><i class="fas fa-cart-shopping"></i></div>
            <span class="at-label">My Cart</span>
        </a>
        <a href="{{ url('buyer/orders') }}" class="action-tile">
            <div class="at-icon at-violet"><i class="fas fa-receipt"></i></div>
            <span class="at-label">My Orders</span>
        </a>
        <a href="{{ route('buyer.profile') }}" class="action-tile">
            <div class="at-icon at-amber"><i class="fas fa-user"></i></div>
            <span class="at-label">Profile</span>
        </a>
        <a href="{{ route('buyer.feedback') }}" class="action-tile">
            <div class="at-icon at-rose"><i class="fas fa-star"></i></div>
            <span class="at-label">Feedback</span>
        </a>
    </div>

    @if(session('success'))<div style="background:rgba(184,255,87,.08);border:1px solid rgba(184,255,87,.2);color:var(--lime);border-radius:12px;padding:.8rem 1rem;margin-bottom:1.5rem;font-size:.875rem;"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>@endif
    @if(session('error'))<div style="background:rgba(255,77,109,.08);border:1px solid rgba(255,77,109,.2);color:var(--rose);border-radius:12px;padding:.8rem 1rem;margin-bottom:1.5rem;font-size:.875rem;"><i class="fas fa-circle-exclamation me-2"></i>{{ session('error') }}</div>@endif

    <!-- Recent Products -->
    <div class="sec-head">
        <div class="sec-title"><i class="fas fa-fire-flame-curved"></i> Recent Products</div>
        <a href="{{ url('buyer/products') }}" class="sec-link">View all <i class="fas fa-arrow-right"></i></a>
    </div>

    @if($recentProducts->isEmpty())
        <div style="text-align:center;padding:3rem;color:var(--muted);background:var(--panel);border:1px solid var(--border);border-radius:20px;">
            <i class="fas fa-box-open" style="font-size:2rem;display:block;margin-bottom:.75rem;"></i>No products available yet.
        </div>
    @else
    <div class="prod-grid">
        @foreach($recentProducts as $product)
        <div class="prod-card">
            <div class="prod-img-wrap">
                @if($product->image_src)
                    <img src="{{ $product->image_src }}" alt="{{ $product->name }}" loading="lazy">
                @else
                    <div class="prod-img-ph"><i class="fas fa-image"></i></div>
                @endif
                <span class="prod-badge">PKR {{ number_format($product->price,0) }}</span>
            </div>
            <div class="prod-body">
                <div class="prod-name">{{ $product->name }}</div>
                <div class="prod-desc">{{ Str::limit($product->description, 80) }}</div>
                @if($product->categories->count())
                <div class="prod-cats">@foreach($product->categories->take(2) as $c)<span class="cat-tag">{{ $c->name }}</span>@endforeach</div>
                @endif
                <div class="prod-foot">
                    <span class="prod-price">PKR {{ number_format($product->price,2) }}</span>
                    <span class="prod-stock"><i class="fas fa-cubes me-1"></i>{{ $product->quantity }} left</span>
                </div>
                <form action="{{ url('buyer/cart/add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="buyer_name" value="{{ Auth::user()->name }}">
                    <div class="add-form">
                        <input type="number" name="quantity" class="qty-in" value="1" min="1" max="{{ $product->quantity }}" required>
                        <button type="submit" class="btn-add"><i class="fas fa-cart-plus"></i> Add</button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Recent Orders -->
    @if($recentOrders->count())
    <div class="sec-head" style="margin-top:1rem;">
        <div class="sec-title"><i class="fas fa-clock-rotate-left"></i> Recent Orders</div>
        <a href="{{ url('buyer/orders') }}" class="sec-link">View all <i class="fas fa-arrow-right"></i></a>
    </div>
    @foreach($recentOrders as $order)
    @php $si = $order->status_info; @endphp
    <a href="{{ route('buyer.track',['id'=>$order->id]) }}" class="order-strip">
        <div class="os-left">
            <span class="os-id">#{{ str_pad($order->id,4,'0',STR_PAD_LEFT) }}</span>
            <span class="os-date">{{ $order->created_at->format('d M Y') }}</span>
            <span class="os-status" style="background:{{ $si['color'] }}22;color:{{ $si['color'] }};border:1px solid {{ $si['color'] }}44;"><i class="fas {{ $si['icon'] }} me-1"></i>{{ $si['label'] }}</span>
        </div>
        <span class="os-total">PKR {{ number_format($order->total_price,0) }}</span>
    </a>
    @endforeach
    @endif

</div>
@endsection
