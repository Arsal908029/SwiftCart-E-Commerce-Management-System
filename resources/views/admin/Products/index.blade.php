@extends('layouts.app')
@section('title', 'Admin Products')
@section('content')
<style>
:root{--void:#080b14;--deep:#0f1623;--panel:#151d2e;--border:rgba(255,255,255,0.07);--cyan:#00e5ff;--lime:#b8ff57;--violet:#8b5cf6;--rose:#ff4d6d;--text:#e2e8f4;--muted:#64748b;}
body{background:var(--void);color:var(--text);font-family:'Bricolage Grotesque',sans-serif;}
.wrap{max-width:1100px;margin:0 auto;padding:3rem 1.5rem 5rem;}
.top-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;}
.page-title{font-family:'Clash Display',serif;font-size:2rem;font-weight:700;}
.page-title span{background:linear-gradient(90deg,var(--cyan),var(--lime));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.btn-add{background:var(--cyan);color:var(--void);font-family:'Clash Display',sans-serif;font-weight:700;font-size:.875rem;padding:.7rem 1.5rem;border-radius:10px;text-decoration:none;transition:all .2s;display:inline-flex;align-items:center;gap:.4rem;}
.btn-add:hover{background:#00f0ff;color:var(--void);transform:translateY(-2px);}
.prod-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.25rem;}
.prod-card{background:var(--panel);border:1px solid var(--border);border-radius:18px;overflow:hidden;transition:all .25s;}
.prod-card:hover{border-color:rgba(0,229,255,.15);transform:translateY(-3px);}
.prod-img{width:100%;height:180px;object-fit:cover;}
.prod-img-ph{width:100%;height:180px;background:var(--deep);display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:2.5rem;}
.prod-body{padding:1rem 1.25rem;}
.prod-name{font-weight:700;font-size:.95rem;color:var(--text);margin-bottom:.2rem;}
.prod-desc{font-size:.78rem;color:var(--muted);margin-bottom:.6rem;line-height:1.4;}
.prod-meta{display:flex;justify-content:space-between;margin-bottom:.75rem;}
.prod-price{font-family:'Clash Display',sans-serif;font-size:1rem;font-weight:700;color:var(--lime);}
.prod-stock{font-size:.78rem;color:var(--muted);}
.prod-actions{display:flex;gap:.4rem;}
.btn-edit{flex:1;background:rgba(0,229,255,.08);border:1px solid rgba(0,229,255,.15);color:var(--cyan);font-size:.78rem;font-weight:600;padding:.45rem;border-radius:7px;text-decoration:none;text-align:center;transition:all .2s;}
.btn-edit:hover{background:rgba(0,229,255,.15);color:var(--cyan);}
.btn-del{flex:1;background:rgba(255,77,109,.08);border:1px solid rgba(255,77,109,.15);color:var(--rose);font-size:.78rem;font-weight:600;padding:.45rem;border-radius:7px;cursor:pointer;transition:all .2s;font-family:inherit;}
.btn-del:hover{background:rgba(255,77,109,.15);}
.alert-success{background:rgba(184,255,87,.1);border:1px solid rgba(184,255,87,.2);color:var(--lime);border-radius:10px;padding:.75rem 1rem;margin-bottom:1.5rem;font-size:.875rem;}
</style>
<link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@600;700&display=swap" rel="stylesheet">
<div class="wrap">
    <div class="top-row">
        <h1 class="page-title">Manage <span>Products</span></h1>
        <a href="{{ url('/admin/products/create') }}" class="btn-add"><i class="fas fa-plus"></i> Add Product</a>
    </div>
    @if(session('success'))<div class="alert-success"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>@endif
    <div class="prod-grid">
        @foreach($products as $product)
        <div class="prod-card">
            @if($product->image_src)
                <img src="{{ $product->image_src }}" class="prod-img" alt="{{ $product->name }}">
            @else
                <div class="prod-img-ph"><i class="fas fa-image"></i></div>
            @endif
            <div class="prod-body">
                <div class="prod-name">{{ $product->name }}</div>
                <div class="prod-desc">{{ Str::limit($product->description,80) }}</div>
                <div class="prod-meta">
                    <span class="prod-price">PKR {{ number_format($product->price,2) }}</span>
                    <span class="prod-stock">Stock: {{ $product->quantity }}</span>
                </div>
                <div class="prod-actions">
                    <a href="{{ url('/admin/products/'.$product->id.'/edit') }}" class="btn-edit"><i class="fas fa-pen me-1"></i> Edit</a>
                    <form action="{{ url('/admin/products/'.$product->id) }}" method="POST" onsubmit="return confirm('Delete this product?')" style="flex:1;display:flex;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-del" style="width:100%;"><i class="fas fa-trash me-1"></i> Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @if($products->isEmpty())<div style="text-align:center;padding:4rem;color:var(--muted);"><i class="fas fa-box-open" style="font-size:2rem;display:block;margin-bottom:.75rem;"></i>No products yet. <a href="{{ url('/admin/products/create') }}" style="color:var(--cyan);">Add your first product.</a></div>@endif
</div>
@endsection
