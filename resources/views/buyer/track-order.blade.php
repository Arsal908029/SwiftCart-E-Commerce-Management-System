@extends('layouts.app')
@section('title', 'Track Order')
@section('content')
<style>
:root{--void:#080b14;--deep:#0f1623;--panel:#151d2e;--border:rgba(255,255,255,0.07);--cyan:#00e5ff;--lime:#b8ff57;--violet:#8b5cf6;--rose:#ff4d6d;--amber:#fbbf24;--text:#e2e8f4;--muted:#64748b;}
body{background:var(--void);color:var(--text);font-family:'Bricolage Grotesque','Segoe UI',sans-serif;min-height:100vh;}
.track-wrap{max-width:860px;margin:0 auto;padding:3rem 1.5rem 5rem;}
.back-link{display:inline-flex;align-items:center;gap:.4rem;font-size:.8rem;color:var(--muted);text-decoration:none;margin-bottom:2rem;transition:color .2s;}
.back-link:hover{color:var(--cyan);}
.track-header{margin-bottom:2.5rem;}
.kicker{display:inline-flex;align-items:center;gap:.5rem;font-size:.72rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:var(--cyan);margin-bottom:.75rem;}
.kicker-dot{width:6px;height:6px;background:var(--cyan);border-radius:50%;animation:pulse 2s ease-in-out infinite;}
.page-title{font-family:'Clash Display','Georgia',serif;font-size:2.2rem;font-weight:700;letter-spacing:-.04em;margin-bottom:.3rem;}
.page-title span{background:linear-gradient(90deg,var(--cyan),var(--lime));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.track-num{font-size:.85rem;color:var(--muted);}
.track-num code{color:var(--cyan);background:rgba(0,229,255,.08);padding:.2rem .6rem;border-radius:6px;border:1px solid rgba(0,229,255,.15);}

/* Info grid */
.info-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;margin-bottom:2rem;}
@media(max-width:600px){.info-grid{grid-template-columns:1fr;}}
.info-card{background:var(--panel);border:1px solid var(--border);border-radius:16px;padding:1.25rem 1.5rem;}
.info-label{font-size:.72rem;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);margin-bottom:.4rem;}
.info-value{font-size:.95rem;color:var(--text);font-weight:500;}

/* Status stepper */
.stepper{background:var(--panel);border:1px solid var(--border);border-radius:20px;padding:2rem;margin-bottom:2rem;}
.stepper-title{font-size:.72rem;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);margin-bottom:1.75rem;}
.steps{display:flex;flex-direction:column;gap:0;}
.step{display:flex;align-items:flex-start;gap:1rem;position:relative;}
.step:not(:last-child)::after{content:'';position:absolute;left:19px;top:38px;width:2px;height:calc(100% - 10px);background:var(--border);}
.step.done::after{background:var(--cyan);}
.step-icon-wrap{width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0;border:2px solid var(--border);background:var(--deep);color:var(--muted);z-index:1;}
.step.done .step-icon-wrap{background:rgba(0,229,255,.1);border-color:var(--cyan);color:var(--cyan);}
.step.active .step-icon-wrap{background:rgba(184,255,87,.1);border-color:var(--lime);color:var(--lime);box-shadow:0 0 20px rgba(184,255,87,.2);}
.step-body{padding-bottom:1.75rem;}
.step-name{font-size:.9rem;font-weight:600;color:var(--muted);margin-bottom:.2rem;}
.step.done .step-name,.step.active .step-name{color:var(--text);}
.step-time{font-size:.75rem;color:var(--muted);}

/* Items */
.items-section{background:var(--panel);border:1px solid var(--border);border-radius:20px;padding:1.75rem;margin-bottom:2rem;}
.section-title{font-size:.72rem;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);margin-bottom:1rem;}
.item-row{display:flex;align-items:center;gap:1rem;padding:.75rem 1rem;background:rgba(255,255,255,.02);border:1px solid var(--border);border-radius:12px;margin-bottom:.5rem;}
.item-thumb{width:50px;height:50px;border-radius:10px;object-fit:cover;background:var(--deep);}
.item-thumb-placeholder{width:50px;height:50px;border-radius:10px;background:var(--deep);display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:1.2rem;flex-shrink:0;}
.item-info{flex:1;}
.item-name{font-size:.875rem;font-weight:500;color:var(--text);}
.item-price{font-size:.78rem;color:var(--muted);}
.item-qty{background:rgba(184,255,87,.1);border:1px solid rgba(184,255,87,.2);color:var(--lime);font-size:.72rem;font-weight:700;padding:.2rem .6rem;border-radius:6px;}

.total-row{display:flex;justify-content:space-between;align-items:center;padding-top:1rem;border-top:1px solid var(--border);margin-top:.5rem;}
.total-label{font-size:.85rem;color:var(--muted);}
.total-val{font-family:'Clash Display',sans-serif;font-size:1.3rem;font-weight:700;color:var(--lime);}

/* Courier */
.courier-card{background:var(--panel);border:1px solid var(--border);border-radius:20px;padding:1.75rem;margin-bottom:2rem;}
.courier-row{display:flex;align-items:center;gap:1rem;}
.courier-icon{width:48px;height:48px;background:rgba(0,229,255,.08);border:1px solid rgba(0,229,255,.15);border-radius:14px;display:flex;align-items:center;justify-content:center;color:var(--cyan);font-size:1.3rem;flex-shrink:0;}
.courier-name{font-size:1rem;font-weight:600;color:var(--text);}
.courier-track{font-size:.82rem;color:var(--muted);}

@keyframes pulse{0%,100%{opacity:1;}50%{opacity:.4;}}
@keyframes fadeUp{from{opacity:0;transform:translateY(18px);}to{opacity:1;transform:translateY(0);}}
</style>
<link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@400;600;700&family=Bricolage+Grotesque:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="track-wrap">
    <a href="{{ url('/buyer/orders') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to Orders</a>

    <div class="track-header" style="animation:fadeUp .6s ease both">
        <div class="kicker"><div class="kicker-dot"></div> Order Tracking</div>
        <h1 class="page-title">Track Your <span>Delivery</span></h1>
        <p class="track-num">Order #{{ str_pad($order->id,4,'0',STR_PAD_LEFT) }}
            @if($order->tracking_number)
            &nbsp;·&nbsp; Tracking: <code>{{ $order->tracking_number }}</code>
            @endif
        </p>
    </div>

    <!-- Info Grid -->
    <div class="info-grid" style="animation:fadeUp .6s ease .1s both">
        <div class="info-card">
            <div class="info-label"><i class="fas fa-user me-1"></i> Recipient</div>
            <div class="info-value">{{ $order->buyer_name }}</div>
        </div>
        <div class="info-card">
            <div class="info-label"><i class="fas fa-phone me-1"></i> Phone</div>
            <div class="info-value">{{ $order->phone }}</div>
        </div>
        <div class="info-card" style="grid-column:span 2">
            <div class="info-label"><i class="fas fa-location-dot me-1"></i> Delivery Address</div>
            <div class="info-value">{{ $order->address }}</div>
        </div>
    </div>

    @php
        $allSteps = [
            'pending'         => ['icon'=>'fa-clock',     'label'=>'Order Placed',     'sub'=>'Your order has been received'],
            'confirmed'       => ['icon'=>'fa-check',     'label'=>'Order Confirmed',  'sub'=>'Seller confirmed your order'],
            'processing'      => ['icon'=>'fa-cog',       'label'=>'Processing',       'sub'=>'Preparing your items'],
            'shipped'         => ['icon'=>'fa-truck',     'label'=>'Shipped',          'sub'=>'Order handed to courier'],
            'out_for_delivery'=> ['icon'=>'fa-motorcycle','label'=>'Out for Delivery', 'sub'=>'Rider is on the way'],
            'delivered'       => ['icon'=>'fa-box-open',  'label'=>'Delivered',        'sub'=>'Package received!'],
        ];
        $statusOrder = array_keys($allSteps);
        $currentIdx  = array_search($order->status, $statusOrder);
        if($order->status === 'cancelled') $currentIdx = -1;
    @endphp

    <!-- Stepper -->
    <div class="stepper" style="animation:fadeUp .6s ease .15s both">
        <div class="stepper-title"><i class="fas fa-route me-1"></i> Delivery Progress</div>
        @if($order->status === 'cancelled')
            <div style="text-align:center;padding:2rem 0;color:var(--rose);">
                <i class="fas fa-times-circle" style="font-size:2.5rem;margin-bottom:.75rem;display:block;"></i>
                <div style="font-size:1.1rem;font-weight:600;">Order Cancelled</div>
                <div style="font-size:.85rem;color:var(--muted);margin-top:.3rem;">This order has been cancelled.</div>
            </div>
        @else
        <div class="steps">
            @foreach($allSteps as $key => $step)
            @php
                $idx = array_search($key, $statusOrder);
                $isDone   = $idx < $currentIdx;
                $isActive = $idx === $currentIdx;
            @endphp
            <div class="step {{ $isDone?'done':'' }} {{ $isActive?'active':'' }}">
                <div class="step-icon-wrap"><i class="fas {{ $step['icon'] }}"></i></div>
                <div class="step-body">
                    <div class="step-name">{{ $step['label'] }}</div>
                    <div class="step-time">{{ $step['sub'] }}
                        @if($isActive) &mdash; <strong style="color:var(--lime)">Current Status</strong> @endif
                        @if($key==='shipped' && $order->shipped_at) &mdash; {{ $order->shipped_at->format('d M Y, h:i A') }} @endif
                        @if($key==='delivered' && $order->delivered_at) &mdash; {{ $order->delivered_at->format('d M Y, h:i A') }} @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    @if($order->courier || $order->tracking_number)
    <div class="courier-card" style="animation:fadeUp .6s ease .2s both">
        <div class="section-title"><i class="fas fa-shipping-fast me-1"></i> Courier Info</div>
        <div class="courier-row">
            <div class="courier-icon"><i class="fas fa-truck"></i></div>
            <div>
                <div class="courier-name">{{ $order->courier ?? 'Courier Assigned' }}</div>
                @if($order->tracking_number)<div class="courier-track">Tracking: <strong>{{ $order->tracking_number }}</strong></div>@endif
                @if($order->delivery_notes)<div class="courier-track mt-1">Note: {{ $order->delivery_notes }}</div>@endif
            </div>
        </div>
    </div>
    @endif

    <!-- Items -->
    <div class="items-section" style="animation:fadeUp .6s ease .25s both">
        <div class="section-title"><i class="fas fa-boxes-stacked me-1"></i> Items in This Order</div>
        @foreach($order->items as $item)
        <div class="item-row">
            @if($item->product && $item->product->image_src)
                <img src="{{ $item->product->image_src }}" class="item-thumb" alt="">
            @else
                <div class="item-thumb-placeholder"><i class="fas fa-image"></i></div>
            @endif
            <div class="item-info">
                <div class="item-name">{{ $item->product->name ?? 'Product' }}</div>
                <div class="item-price">PKR {{ number_format($item->price,2) }} each</div>
            </div>
            <span class="item-qty">× {{ $item->quantity }}</span>
        </div>
        @endforeach
        <div class="total-row">
            <span class="total-label">Order Total</span>
            <span class="total-val">PKR {{ number_format($order->total_price,2) }}</span>
        </div>
    </div>

    <div style="text-align:center;">
        <a href="{{ route('buyer.feedback') }}" style="display:inline-flex;align-items:center;gap:.5rem;background:var(--panel);border:1px solid var(--border);color:var(--cyan);text-decoration:none;padding:.75rem 1.5rem;border-radius:12px;font-size:.875rem;transition:all .2s;">
            <i class="fas fa-star"></i> Leave Feedback for this Order
        </a>
    </div>
</div>
@endsection
