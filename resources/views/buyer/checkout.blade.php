@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<style>
.checkout-wrap { max-width:760px; margin:0 auto; }
.checkout-title { font-family:'Clash Display',sans-serif; font-size:1.8rem; font-weight:700; color:var(--text); margin-bottom:1.75rem; display:flex; align-items:center; gap:.6rem; }
.checkout-title i { color:var(--lime); }
.checkout-grid { display:grid; grid-template-columns:1fr 380px; gap:1.5rem; align-items:start; }
@media(max-width:780px){ .checkout-grid{grid-template-columns:1fr;} }

/* Form card */
.form-card { background:var(--panel); border:1px solid var(--border); border-radius:20px; padding:1.75rem; }
.fc-title { font-size:.72rem; text-transform:uppercase; letter-spacing:.1em; color:var(--muted); margin-bottom:1.25rem; }
.field { display:flex; flex-direction:column; gap:.4rem; margin-bottom:1rem; }
.field label { font-size:.78rem; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:.06em; }
.field input, .field textarea { background:var(--deep); border:1px solid var(--border); border-radius:10px; color:var(--text); padding:.75rem 1rem; font-size:.9rem; font-family:inherit; outline:none; width:100%; transition:border-color .2s; }
.field input:focus, .field textarea:focus { border-color:rgba(0,229,255,.4); }
.field textarea { resize:vertical; }

/* Order summary */
.order-summary { background:var(--panel); border:1px solid var(--border); border-radius:20px; padding:1.5rem; position:sticky; top:9rem; }
.os-title { font-family:'Clash Display',sans-serif; font-size:1rem; font-weight:700; color:var(--text); margin-bottom:1rem; }
.os-item { display:flex; align-items:center; gap:.75rem; padding:.6rem 0; border-bottom:1px solid var(--border); }
.os-item:last-of-type { border-bottom:none; margin-bottom:.5rem; }
.os-img { width:46px; height:46px; border-radius:10px; object-fit:cover; background:var(--deep); flex-shrink:0; display:flex; align-items:center; justify-content:center; color:var(--muted); overflow:hidden; font-size:1.1rem; }
.os-img img { width:100%; height:100%; object-fit:cover; }
.os-info { flex:1; min-width:0; }
.os-name { font-size:.82rem; font-weight:600; color:var(--text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.os-qty { font-size:.72rem; color:var(--muted); }
.os-price { font-size:.85rem; font-weight:700; color:var(--lime); white-space:nowrap; }
.divider { border:none; border-top:1px solid var(--border); margin:.75rem 0; }
.total-row { display:flex; justify-content:space-between; align-items:center; }
.total-label { font-size:.875rem; color:var(--muted); }
.total-val { font-family:'Clash Display',sans-serif; font-size:1.3rem; font-weight:700; color:var(--lime); }
.btn-place { width:100%; background:var(--lime); color:var(--void); font-family:'Clash Display',sans-serif; font-weight:700; font-size:.95rem; padding:.9rem; border-radius:14px; border:none; cursor:pointer; transition:all .25s; margin-top:1rem; display:flex; align-items:center; justify-content:center; gap:.5rem; }
.btn-place:hover { background:#c8ff70; transform:translateY(-2px); box-shadow:0 0 30px rgba(184,255,87,.25); }
.btn-back { display:flex; align-items:center; justify-content:center; gap:.4rem; background:transparent; border:1px solid var(--border); color:var(--muted); font-size:.82rem; padding:.65rem; border-radius:12px; text-decoration:none; margin-top:.5rem; transition:all .2s; }
.btn-back:hover { color:var(--text); border-color:rgba(255,255,255,.15); }

@keyframes fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
</style>

@php
$cartItems = \App\Models\Cart::with('product')->get();
$grandTotal = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
@endphp

<div class="checkout-wrap" style="animation:fadeUp .5s ease both">
    <div class="checkout-title"><i class="fas fa-bag-shopping"></i> Checkout</div>

    <div class="checkout-grid">
        <!-- Form -->
        <div>
            <form action="{{ url('buyer/checkout') }}" method="POST" id="checkoutForm">
                @csrf
                <div class="form-card">
                    <div class="fc-title"><i class="fas fa-user me-1"></i> Delivery Details</div>
                    <div class="field">
                        <label>Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required placeholder="Your full name">
                    </div>
                    <div class="field">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" required placeholder="+92 300 0000000">
                    </div>
                    <div class="field">
                        <label>Delivery Address</label>
                        <textarea name="address" rows="3" required placeholder="Full delivery address...">{{ old('address', $user->address ?? '') }}</textarea>
                    </div>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <div class="os-title"><i class="fas fa-receipt me-2" style="color:var(--cyan);"></i>Order Summary</div>
            @foreach($cartItems as $item)
            @php $sub = $item->product->price * $item->quantity; @endphp
            <div class="os-item">
                <div class="os-img">
                    @if($item->product->image_src)
                        <img src="{{ $item->product->image_src }}" alt="">
                    @else
                        <i class="fas fa-image"></i>
                    @endif
                </div>
                <div class="os-info">
                    <div class="os-name">{{ $item->product->name }}</div>
                    <div class="os-qty">Qty: {{ $item->quantity }}</div>
                </div>
                <span class="os-price">PKR {{ number_format($sub,0) }}</span>
            </div>
            @endforeach
            <hr class="divider">
            <div class="total-row">
                <span class="total-label">Total</span>
                <span class="total-val">PKR {{ number_format($grandTotal,2) }}</span>
            </div>
            <button type="submit" form="checkoutForm" class="btn-place"><i class="fas fa-bolt"></i> Place Order</button>
            <a href="{{ url('buyer/cart') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Cart</a>
        </div>
    </div>
</div>
@endsection
