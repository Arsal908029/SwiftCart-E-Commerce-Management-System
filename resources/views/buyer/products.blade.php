@extends('layouts.app')
@section('title', 'Shop Products')
@section('content')
<style>
:root{--void:#080b14;--deep:#0f1623;--panel:#151d2e;--border:rgba(255,255,255,0.07);--cyan:#00e5ff;--lime:#b8ff57;--violet:#8b5cf6;--rose:#ff4d6d;--text:#e2e8f4;--muted:#64748b;}
body{background:var(--void);color:var(--text);font-family:'Bricolage Grotesque',sans-serif;}
.shop-wrap{max-width:1200px;margin:0 auto;padding:3rem 1.5rem 5rem;}
.page-title{font-family:'Clash Display',serif;font-size:2.2rem;font-weight:700;letter-spacing:-.04em;margin-bottom:.3rem;}
.page-title span{background:linear-gradient(90deg,var(--cyan),var(--lime));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}

/* Filters */
.filter-bar{background:var(--panel);border:1px solid var(--border);border-radius:16px;padding:1.25rem 1.5rem;margin-bottom:2rem;display:flex;gap:.75rem;flex-wrap:wrap;align-items:flex-end;}
.filter-group{display:flex;flex-direction:column;gap:.3rem;flex:1;min-width:130px;}
.filter-group label{font-size:.72rem;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);}
.filter-group input,.filter-group select{background:var(--deep);border:1px solid var(--border);border-radius:8px;color:var(--text);padding:.6rem .85rem;font-size:.85rem;font-family:inherit;outline:none;width:100%;}
.filter-group input:focus,.filter-group select:focus{border-color:rgba(0,229,255,.4);}
.filter-group select option{background:var(--deep);}
.btn-filter{background:var(--cyan);color:var(--void);font-weight:700;font-size:.85rem;padding:.65rem 1.25rem;border:none;border-radius:8px;cursor:pointer;transition:all .2s;white-space:nowrap;}
.btn-filter:hover{background:#00f0ff;}
.btn-reset{background:var(--panel);border:1px solid var(--border);color:var(--muted);font-size:.85rem;padding:.65rem 1rem;border-radius:8px;text-decoration:none;white-space:nowrap;transition:all .2s;}
.btn-reset:hover{color:var(--text);border-color:var(--text);}

/* Grid */
.products-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.25rem;}
.prod-card{background:var(--panel);border:1px solid var(--border);border-radius:20px;overflow:hidden;transition:all .3s cubic-bezier(.25,.8,.25,1);display:flex;flex-direction:column;}
.prod-card:hover{border-color:rgba(0,229,255,.2);transform:translateY(-4px);box-shadow:0 20px 40px rgba(0,0,0,.3);}
.prod-img{width:100%;height:200px;object-fit:cover;display:block;}
.prod-img-ph{width:100%;height:200px;background:linear-gradient(135deg,var(--deep),var(--panel));display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:3rem;}
.prod-body{padding:1.25rem;flex:1;display:flex;flex-direction:column;}
.prod-name{font-family:'Clash Display',sans-serif;font-size:1.05rem;font-weight:700;color:var(--text);margin-bottom:.4rem;}
.prod-desc{font-size:.825rem;color:var(--muted);flex:1;margin-bottom:.75rem;line-height:1.5;}
.prod-cats{display:flex;flex-wrap:wrap;gap:.3rem;margin-bottom:.75rem;}
.cat-tag{background:rgba(139,92,246,.1);border:1px solid rgba(139,92,246,.2);color:var(--violet);font-size:.68rem;padding:.15rem .5rem;border-radius:5px;}
.prod-price-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem;}
.prod-price{font-family:'Clash Display',sans-serif;font-size:1.15rem;font-weight:700;color:var(--lime);}
.prod-stock{font-size:.75rem;color:var(--muted);}
.add-form{display:flex;gap:.5rem;margin-top:auto;}
.qty-input{background:var(--deep);border:1px solid var(--border);border-radius:8px;color:var(--text);padding:.55rem .75rem;font-size:.875rem;width:70px;outline:none;font-family:inherit;}
.qty-input:focus{border-color:rgba(0,229,255,.4);}
.btn-add{flex:1;background:rgba(0,229,255,.08);border:1px solid rgba(0,229,255,.2);color:var(--cyan);font-size:.85rem;font-weight:600;border-radius:8px;padding:.55rem;cursor:pointer;transition:all .2s;}
.btn-add:hover{background:rgba(0,229,255,.15);}
.alert-success{background:rgba(184,255,87,.1);border:1px solid rgba(184,255,87,.2);color:var(--lime);border-radius:10px;padding:.75rem 1rem;margin-bottom:1.5rem;font-size:.875rem;}
.alert-danger{background:rgba(255,77,109,.1);border:1px solid rgba(255,77,109,.2);color:var(--rose);border-radius:10px;padding:.75rem 1rem;margin-bottom:1.5rem;font-size:.875rem;}
.empty-msg{text-align:center;padding:4rem;color:var(--muted);}
@keyframes fadeUp{from{opacity:0;transform:translateY(18px);}to{opacity:1;transform:translateY(0);}}
</style>
<link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@400;600;700&family=Bricolage+Grotesque:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="shop-wrap">
    <div style="margin-bottom:2rem;animation:fadeUp .6s ease both">
        <h1 class="page-title">Shop <span>Products</span></h1>
        <p style="color:var(--muted);font-size:.9rem;">{{ $products->count() }} products available</p>
    </div>

    @if(session('success'))<div class="alert-success"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert-danger">{{ session('error') }}</div>@endif

    <!-- Filter Bar -->
    <form method="GET" action="{{ url('/buyer/products') }}">
        <div class="filter-bar">
            <div class="filter-group" style="flex:2;min-width:200px;">
                <label>Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products...">
            </div>
            <div class="filter-group">
                <label>Category</label>
                <select name="category">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label>Min Price</label>
                <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="0" min="0">
            </div>
            <div class="filter-group">
                <label>Max Price</label>
                <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="99999" min="0">
            </div>
            <div class="filter-group">
                <label>Sort By</label>
                <select name="sort_by">
                    <option value="latest" {{ request('sort_by','latest')==='latest'?'selected':'' }}>Latest</option>
                    <option value="price_low" {{ request('sort_by')==='price_low'?'selected':'' }}>Price: Low–High</option>
                    <option value="price_high" {{ request('sort_by')==='price_high'?'selected':'' }}>Price: High–Low</option>
                    <option value="oldest" {{ request('sort_by')==='oldest'?'selected':'' }}>Oldest</option>
                </select>
            </div>
            <button type="submit" class="btn-filter"><i class="fas fa-search me-1"></i> Filter</button>
            <a href="{{ url('/buyer/products') }}" class="btn-reset">Reset</a>
        </div>
    </form>

    @if($products->isEmpty())
    <div class="empty-msg"><i class="fas fa-box-open" style="font-size:2.5rem;margin-bottom:.75rem;display:block;"></i>No products found.</div>
    @else
    <div class="products-grid">
        @foreach($products as $product)
        <div class="prod-card">
            @if($product->image_src)
                <img src="{{ $product->image_src }}" class="prod-img" alt="{{ $product->name }}">
            @else
                <div class="prod-img-ph"><i class="fas fa-image"></i></div>
            @endif
            <div class="prod-body">
                <div class="prod-name">{{ $product->name }}</div>
                <div class="prod-desc">{{ Str::limit($product->description,100) }}</div>
                @if($product->categories->count())
                <div class="prod-cats">@foreach($product->categories->take(3) as $c)<span class="cat-tag">{{ $c->name }}</span>@endforeach</div>
                @endif
                <div class="prod-price-row">
                    <span class="prod-price">PKR {{ number_format($product->price,2) }}</span>
                    <span class="prod-stock"><i class="fas fa-boxes-stacked me-1"></i>{{ $product->quantity }} left</span>
                </div>
                <form action="{{ url('buyer/cart/add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="buyer_name" value="{{ auth()->user()->name ?? 'Guest' }}">
                    <div class="add-form">
                        <input type="number" name="quantity" class="qty-input" value="1" min="1" max="{{ $product->quantity }}" required>
                        <button type="submit" class="btn-add"><i class="fas fa-cart-plus me-1"></i> Add to Cart</button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
