@extends('layouts.app')
@section('title', 'My Orders')
@section('content')
<style>
:root{--void:#080b14;--deep:#0f1623;--panel:#151d2e;--border:rgba(255,255,255,0.07);--cyan:#00e5ff;--lime:#b8ff57;--violet:#8b5cf6;--rose:#ff4d6d;--amber:#fbbf24;--text:#e2e8f4;--muted:#64748b;}
body{background:var(--void);color:var(--text);font-family:'Bricolage Grotesque','Segoe UI',sans-serif;min-height:100vh;}
.orders-wrapper{max-width:960px;margin:0 auto;padding:3rem 1.5rem 5rem;}
.orders-header{margin-bottom:3rem;animation:fadeUp .6s ease both;}
.orders-kicker{display:inline-flex;align-items:center;gap:.5rem;font-size:.72rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:var(--cyan);margin-bottom:.75rem;}
.orders-kicker-dot{width:6px;height:6px;background:var(--cyan);border-radius:50%;animation:pulse 2s ease-in-out infinite;}
.orders-title{font-family:'Clash Display','Georgia',serif;font-size:2.4rem;font-weight:700;letter-spacing:-.04em;color:var(--text);margin-bottom:.5rem;}
.orders-title span{background:linear-gradient(90deg,var(--cyan),var(--lime));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.orders-sub{font-size:.9rem;color:var(--muted);}
.summary-bar{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:2.5rem;animation:fadeUp .6s ease .1s both;}
.summary-tile{background:var(--panel);border:1px solid var(--border);border-radius:16px;padding:1.25rem 1.5rem;display:flex;align-items:center;gap:1rem;transition:border-color .25s;}
.summary-tile:hover{border-color:rgba(0,229,255,.2);}
.summary-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;}
.si-cyan{background:rgba(0,229,255,.1);color:var(--cyan);}
.si-lime{background:rgba(184,255,87,.1);color:var(--lime);}
.si-violet{background:rgba(139,92,246,.1);color:var(--violet);}
.summary-info .s-val{font-family:'Clash Display',sans-serif;font-size:1.4rem;font-weight:700;color:var(--text);line-height:1;}
.summary-info .s-lbl{font-size:.75rem;color:var(--muted);margin-top:.2rem;}
.order-card{background:var(--panel);border:1px solid var(--border);border-radius:20px;margin-bottom:1.25rem;overflow:hidden;transition:all .3s cubic-bezier(.25,.8,.25,1);animation:fadeUp .5s ease both;}
.order-card:hover{border-color:rgba(0,229,255,.18);transform:translateY(-3px);box-shadow:0 16px 40px rgba(0,0,0,.3);}
.order-header{display:flex;align-items:center;justify-content:space-between;padding:1.25rem 1.75rem;background:rgba(255,255,255,.02);border-bottom:1px solid var(--border);flex-wrap:wrap;gap:.75rem;}
.order-id-group{display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;}
.order-id-badge{background:rgba(0,229,255,.08);border:1px solid rgba(0,229,255,.2);color:var(--cyan);font-family:'Clash Display',sans-serif;font-size:.85rem;font-weight:600;padding:.3rem .85rem;border-radius:8px;}
.order-date{font-size:.8rem;color:var(--muted);display:flex;align-items:center;gap:.4rem;}
.status-badge{display:inline-flex;align-items:center;gap:.4rem;font-size:.73rem;font-weight:700;padding:.3rem .75rem;border-radius:8px;}
.order-total{font-family:'Clash Display',sans-serif;font-size:1.1rem;font-weight:700;color:var(--lime);}
.order-body{padding:1.5rem 1.75rem;}
.address-row{display:flex;align-items:flex-start;gap:.6rem;font-size:.875rem;color:var(--muted);margin-bottom:1.25rem;background:rgba(255,255,255,.02);border:1px solid var(--border);border-radius:10px;padding:.75rem 1rem;}
.address-row i{color:var(--cyan);margin-top:.1rem;flex-shrink:0;}
.items-label{font-size:.72rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);margin-bottom:.75rem;}
.items-list{list-style:none;display:flex;flex-direction:column;gap:.5rem;margin-bottom:1rem;}
.item-row{display:flex;align-items:center;gap:1rem;padding:.65rem 1rem;background:rgba(255,255,255,.02);border:1px solid var(--border);border-radius:10px;transition:border-color .2s;}
.item-row:hover{border-color:rgba(184,255,87,.15);}
.item-thumb{width:38px;height:38px;border-radius:8px;object-fit:cover;flex-shrink:0;}
.item-thumb-ph{width:38px;height:38px;border-radius:8px;background:var(--deep);display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:.9rem;flex-shrink:0;}
.item-name{font-size:.875rem;color:var(--text);font-weight:500;flex:1;}
.item-qty{background:rgba(184,255,87,.1);border:1px solid rgba(184,255,87,.2);color:var(--lime);font-size:.72rem;font-weight:700;padding:.2rem .6rem;border-radius:6px;}
.order-actions{display:flex;gap:.5rem;flex-wrap:wrap;}
.btn-track{display:inline-flex;align-items:center;gap:.4rem;background:rgba(0,229,255,.08);border:1px solid rgba(0,229,255,.2);color:var(--cyan);font-size:.8rem;font-weight:600;padding:.5rem 1rem;border-radius:9px;text-decoration:none;transition:all .2s;}
.btn-track:hover{background:rgba(0,229,255,.15);color:var(--cyan);}
.btn-fb{display:inline-flex;align-items:center;gap:.4rem;background:rgba(139,92,246,.08);border:1px solid rgba(139,92,246,.2);color:var(--violet);font-size:.8rem;font-weight:600;padding:.5rem 1rem;border-radius:9px;text-decoration:none;transition:all .2s;}
.btn-fb:hover{background:rgba(139,92,246,.15);color:var(--violet);}
.tracking-chip{background:rgba(0,229,255,.06);border:1px solid rgba(0,229,255,.12);border-radius:8px;padding:.4rem .8rem;font-size:.75rem;color:var(--muted);margin-bottom:1rem;}
.tracking-chip code{color:var(--cyan);}
.empty-state{text-align:center;padding:5rem 2rem;animation:fadeUp .6s ease both;}
.empty-icon{width:80px;height:80px;background:rgba(0,229,255,.06);border:1px solid rgba(0,229,255,.1);border-radius:22px;display:flex;align-items:center;justify-content:center;font-size:2rem;margin:0 auto 1.5rem;color:var(--cyan);}
.empty-title{font-family:'Clash Display',sans-serif;font-size:1.5rem;font-weight:700;color:var(--text);margin-bottom:.5rem;}
.empty-sub{font-size:.9rem;color:var(--muted);margin-bottom:2rem;}
.btn-shop{display:inline-flex;align-items:center;gap:.5rem;background:var(--cyan);color:var(--void);font-family:'Clash Display',sans-serif;font-weight:600;font-size:.9rem;padding:.8rem 1.75rem;border-radius:12px;text-decoration:none;transition:all .25s;}
.btn-shop:hover{background:#00f0ff;color:var(--void);transform:translateY(-2px);box-shadow:0 0 30px rgba(0,229,255,.25);}
.back-link{display:inline-flex;align-items:center;gap:.4rem;font-size:.8rem;color:var(--muted);text-decoration:none;margin-bottom:2rem;transition:color .2s;}
.back-link:hover{color:var(--cyan);}
@keyframes fadeUp{from{opacity:0;transform:translateY(18px);}to{opacity:1;transform:translateY(0);}}
@keyframes pulse{0%,100%{opacity:1;}50%{opacity:.4;}}
</style>
<link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@400;500;600;700&family=Bricolage+Grotesque:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="orders-wrapper">
    <a href="{{ url('/buyer/dashboard') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>

    <div class="orders-header">
        <div class="orders-kicker"><div class="orders-kicker-dot"></div> My Account</div>
        <h1 class="orders-title">Order <span>History</span></h1>
        <p class="orders-sub">Every purchase you've made, right here.</p>
    </div>

    @if($orders->count())
    <div class="summary-bar">
        <div class="summary-tile">
            <div class="summary-icon si-cyan"><i class="fas fa-receipt"></i></div>
            <div class="summary-info"><div class="s-val">{{ $orders->count() }}</div><div class="s-lbl">Total Orders</div></div>
        </div>
        <div class="summary-tile">
            <div class="summary-icon si-lime"><i class="fas fa-boxes-stacked"></i></div>
            <div class="summary-info"><div class="s-val">{{ $orders->sum(fn($o)=>$o->items->count()) }}</div><div class="s-lbl">Items Ordered</div></div>
        </div>
        <div class="summary-tile">
            <div class="summary-icon si-violet"><i class="fas fa-wallet"></i></div>
            <div class="summary-info"><div class="s-val">PKR {{ number_format($orders->sum('total_price'),0) }}</div><div class="s-lbl">Total Spent</div></div>
        </div>
    </div>

    @foreach($orders as $i => $order)
    @php $si = $order->status_info; @endphp
    <div class="order-card" style="animation-delay:{{ $i*.08 }}s">
        <div class="order-header">
            <div class="order-id-group">
                <span class="order-id-badge">#{{ str_pad($order->id,4,'0',STR_PAD_LEFT) }}</span>
                <span class="order-date"><i class="fas fa-calendar-days"></i>{{ $order->created_at->format('d M, Y') }} &bull; {{ $order->created_at->format('h:i A') }}</span>
                <span class="status-badge" style="background:{{ $si['color'] }}22;border:1px solid {{ $si['color'] }}44;color:{{ $si['color'] }};"><i class="fas {{ $si['icon'] }}"></i> {{ $si['label'] }}</span>
            </div>
            <div class="order-total">PKR {{ number_format($order->total_price,2) }}</div>
        </div>
        <div class="order-body">
            @if($order->tracking_number)
            <div class="tracking-chip"><i class="fas fa-route me-1"></i> Tracking: <code>{{ $order->tracking_number }}</code>@if($order->courier) &bull; {{ $order->courier }}@endif</div>
            @endif
            <div class="address-row"><i class="fas fa-location-dot"></i><span>{{ $order->address }}</span></div>
            <div class="items-label">Items in this order</div>
            <ul class="items-list">
                @foreach($order->items as $item)
                <li class="item-row">
                    @if($item->product && $item->product->image_src)
                    <img src="{{ $item->product->image_src }}" class="item-thumb" alt="">
                    @else
                        <div class="item-thumb-ph"><i class="fas fa-image"></i></div>
                    @endif
                    <span class="item-name">{{ $item->product->name ?? 'Product' }}</span>
                    <span class="item-qty">× {{ $item->quantity }}</span>
                </li>
                @endforeach
            </ul>
            <div class="order-actions">
                <a href="{{ route('buyer.track',['id'=>$order->id]) }}" class="btn-track"><i class="fas fa-map-marker-alt"></i> Track Order</a>
                <a href="{{ route('buyer.feedback') }}" class="btn-fb"><i class="fas fa-star"></i> Leave Feedback</a>
            </div>
        </div>
    </div>
    @endforeach

    @else
    <div class="empty-state">
        <div class="empty-icon"><i class="fas fa-bag-shopping"></i></div>
        <div class="empty-title">No orders yet</div>
        <p class="empty-sub">Start shopping to see your history here.</p>
        <a href="{{ url('/buyer/products') }}" class="btn-shop"><i class="fas fa-bolt"></i> Browse Products</a>
    </div>
    @endif
</div>
@endsection
