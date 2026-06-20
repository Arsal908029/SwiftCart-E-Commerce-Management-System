@extends('layouts.app')
@section('title', 'My Cart')
@section('content')
<style>
.cart-wrap { max-width:860px; margin:0 auto; }
.cart-title { font-family:'Clash Display',sans-serif; font-size:1.8rem; font-weight:700; color:var(--text); margin-bottom:1.75rem; display:flex; align-items:center; gap:.6rem; }
.cart-title i { color:var(--cyan); }

/* Cart items */
.cart-item { background:var(--panel); border:1px solid var(--border); border-radius:18px; padding:1.1rem 1.25rem; display:flex; align-items:center; gap:1.1rem; margin-bottom:.75rem; transition:border-color .2s; }
.cart-item:hover { border-color:rgba(0,229,255,.15); }
.ci-img { width:72px; height:72px; border-radius:14px; object-fit:cover; flex-shrink:0; background:var(--deep); display:flex; align-items:center; justify-content:center; color:var(--muted); font-size:1.5rem; overflow:hidden; }
.ci-img img { width:100%; height:100%; object-fit:cover; }
.ci-info { flex:1; min-width:0; }
.ci-name { font-family:'Clash Display',sans-serif; font-size:.95rem; font-weight:700; color:var(--text); margin-bottom:.2rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.ci-unit { font-size:.78rem; color:var(--muted); }
.ci-qty { background:rgba(184,255,87,.08); border:1px solid rgba(184,255,87,.2); color:var(--lime); font-size:.78rem; font-weight:700; padding:.25rem .7rem; border-radius:8px; white-space:nowrap; }
.ci-sub { font-family:'Clash Display',sans-serif; font-size:1rem; font-weight:700; color:var(--lime); white-space:nowrap; min-width:100px; text-align:right; }
.btn-remove { background:rgba(255,77,109,.08); border:1px solid rgba(255,77,109,.18); color:var(--rose); border-radius:10px; padding:.45rem .75rem; font-size:.8rem; cursor:pointer; transition:all .2s; font-family:inherit; white-space:nowrap; }
.btn-remove:hover { background:rgba(255,77,109,.2); }

/* Summary card */
.summary-card { background:var(--panel); border:1px solid var(--border); border-radius:20px; padding:1.5rem 1.75rem; margin-top:1.25rem; }
.summary-row { display:flex; justify-content:space-between; align-items:center; padding:.5rem 0; border-bottom:1px solid var(--border); font-size:.875rem; color:var(--muted); }
.summary-row:last-child { border-bottom:none; }
.summary-total { font-family:'Clash Display',sans-serif; font-size:1.4rem; font-weight:700; color:var(--lime); }
.summary-label-total { font-size:1rem; font-weight:600; color:var(--text); }
.btn-checkout { width:100%; background:var(--cyan); color:var(--void); font-family:'Clash Display',sans-serif; font-weight:700; font-size:1rem; padding:1rem; border-radius:14px; border:none; cursor:pointer; transition:all .25s; margin-top:1.1rem; display:flex; align-items:center; justify-content:center; gap:.5rem; text-decoration:none; }
.btn-checkout:hover { background:#00f0ff; color:var(--void); transform:translateY(-2px); box-shadow:0 0 30px rgba(0,229,255,.25); }
.btn-continue { display:flex; align-items:center; justify-content:center; gap:.4rem; background:transparent; border:1px solid var(--border); color:var(--muted); font-size:.85rem; padding:.7rem; border-radius:12px; text-decoration:none; margin-top:.6rem; transition:all .2s; }
.btn-continue:hover { border-color:rgba(255,255,255,.15); color:var(--text); }

.empty-cart { text-align:center; padding:5rem 2rem; }
.empty-icon { width:90px; height:90px; background:rgba(0,229,255,.06); border:1px solid rgba(0,229,255,.1); border-radius:24px; display:flex; align-items:center; justify-content:center; font-size:2.5rem; color:var(--cyan); margin:0 auto 1.5rem; }
.empty-title { font-family:'Clash Display',sans-serif; font-size:1.5rem; font-weight:700; color:var(--text); margin-bottom:.5rem; }
.empty-sub { font-size:.9rem; color:var(--muted); margin-bottom:2rem; }
.btn-shop { display:inline-flex; align-items:center; gap:.5rem; background:var(--cyan); color:var(--void); font-family:'Clash Display',sans-serif; font-weight:700; padding:.8rem 2rem; border-radius:12px; text-decoration:none; transition:all .25s; }
.btn-shop:hover { background:#00f0ff; color:var(--void); transform:translateY(-2px); box-shadow:0 0 30px rgba(0,229,255,.25); }

@keyframes fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
</style>

<div class="cart-wrap" style="animation:fadeUp .5s ease both">
    <div class="cart-title"><i class="fas fa-cart-shopping"></i> My Cart</div>

    @if($cartItems->isEmpty())
    <div class="empty-cart">
        <div class="empty-icon"><i class="fas fa-cart-shopping"></i></div>
        <div class="empty-title">Your cart is empty</div>
        <p class="empty-sub">Add some products to get started.</p>
        <a href="{{ url('buyer/products') }}" class="btn-shop"><i class="fas fa-bolt"></i> Browse Products</a>
    </div>
    @else
    @php $grandTotal = 0; @endphp

    <div>
        @foreach($cartItems as $item)
        @php $subtotal = $item->product->price * $item->quantity; $grandTotal += $subtotal; @endphp
        <div class="cart-item">
            <div class="ci-img">
                @if($item->product->image_src)
                    <img src="{{ $item->product->image_src }}" alt="{{ $item->product->name }}">
                @else
                    <i class="fas fa-image"></i>
                @endif
            </div>
            <div class="ci-info">
                <div class="ci-name">{{ $item->product->name }}</div>
                <div class="ci-unit">PKR {{ number_format($item->product->price,2) }} each</div>
            </div>
            <span class="ci-qty">× {{ $item->quantity }}</span>
            <span class="ci-sub">PKR {{ number_format($subtotal,2) }}</span>
            <form action="{{ url('buyer/cart/remove/'.$item->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-remove"><i class="fas fa-trash-can me-1"></i> Remove</button>
            </form>
        </div>
        @endforeach
    </div>

    <div class="summary-card">
        <div class="summary-row"><span>Items ({{ $cartItems->count() }})</span><span>PKR {{ number_format($grandTotal,2) }}</span></div>
        <div class="summary-row"><span>Delivery</span><span style="color:var(--lime);">Free</span></div>
        <div class="summary-row" style="border-bottom:none;padding-top:.75rem;">
            <span class="summary-label-total">Total</span>
            <span class="summary-total">PKR {{ number_format($grandTotal,2) }}</span>
        </div>
        <a href="{{ url('buyer/checkout') }}" class="btn-checkout"><i class="fas fa-bolt"></i> Proceed to Checkout</a>
        <a href="{{ url('buyer/products') }}" class="btn-continue"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
    </div>
    @endif
</div>
@endsection
