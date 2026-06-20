@extends('layouts.app')
@section('title', 'Edit Product')
@section('content')
<style>
:root{--void:#080b14;--deep:#0f1623;--panel:#151d2e;--border:rgba(255,255,255,0.07);--cyan:#00e5ff;--lime:#b8ff57;--text:#e2e8f4;--muted:#64748b;--rose:#ff4d6d;}
body{background:var(--void);color:var(--text);font-family:'Bricolage Grotesque',sans-serif;}
.wrap{max-width:680px;margin:0 auto;padding:3rem 1.5rem 5rem;}
.page-title{font-family:'Clash Display',serif;font-size:2rem;font-weight:700;margin-bottom:2rem;}
.page-title span{background:linear-gradient(90deg,var(--cyan),var(--lime));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.form-card{background:var(--panel);border:1px solid var(--border);border-radius:20px;padding:2rem;margin-bottom:1.5rem;}
.field{display:flex;flex-direction:column;gap:.4rem;margin-bottom:1rem;}
.field label{font-size:.78rem;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;}
.field input,.field textarea{background:var(--deep);border:1px solid var(--border);border-radius:10px;color:var(--text);padding:.75rem 1rem;font-size:.9rem;font-family:inherit;outline:none;width:100%;transition:border-color .2s;}
.field input:focus,.field textarea:focus{border-color:rgba(0,229,255,.4);}
.row2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
.cur-img{width:120px;height:120px;object-fit:cover;border-radius:10px;border:2px solid rgba(0,229,255,.2);margin-bottom:.5rem;}
.img-preview{width:100%;max-height:200px;object-fit:cover;border-radius:10px;margin-top:.5rem;display:none;}
.btn-submit{background:var(--cyan);color:var(--void);font-family:'Clash Display',sans-serif;font-weight:700;font-size:.95rem;padding:.85rem 2.5rem;border-radius:12px;border:none;cursor:pointer;transition:all .25s;}
.btn-submit:hover{background:#00f0ff;}
.back-link{display:inline-flex;align-items:center;gap:.4rem;font-size:.8rem;color:var(--muted);text-decoration:none;margin-bottom:2rem;transition:color .2s;}
.back-link:hover{color:var(--cyan);}
</style>
<link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@600;700&display=swap" rel="stylesheet">
<div class="wrap">
    <a href="{{ url('/admin/products') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to Products</a>
    <h1 class="page-title">Edit <span>Product</span></h1>
    <form action="{{ url('/admin/products/'.$product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="form-card">
            <div class="field">
                <label>Product Name</label>
                <input type="text" name="name" value="{{ old('name',$product->name) }}" required>
            </div>
            <div class="field">
                <label>Description</label>
                <textarea name="description" rows="4" required>{{ old('description',$product->description) }}</textarea>
            </div>
            <div class="row2">
                <div class="field">
                    <label>Price (PKR)</label>
                    <input type="number" name="price" value="{{ old('price',$product->price) }}" step="0.01" min="0" required>
                </div>
                <div class="field">
                    <label>Stock Quantity</label>
                    <input type="number" name="quantity" value="{{ old('quantity',$product->quantity) }}" min="0" required>
                </div>
            </div>
            <div class="field">
                <label>Product Image — Upload File</label>
                @if($product->image_src)
                    <div style="margin-bottom:.5rem;"><img src="{{ $product->image_src }}" class="cur-img" alt="Current"></div>
                    <small style="color:var(--muted);">Upload or paste URL to replace current image.</small>
                @endif
                <input type="file" name="image" accept="image/*" onchange="previewImage(this)" style="margin-top:.5rem;">
            </div>
            <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1rem;">
                <div style="flex:1;height:1px;background:var(--border);"></div>
                <span style="font-size:.75rem;color:var(--muted);text-transform:uppercase;letter-spacing:.08em;">or</span>
                <div style="flex:1;height:1px;background:var(--border);"></div>
            </div>
            <div class="field">
                <label>Product Image — Paste URL</label>
                <input type="url" name="image_url" value="{{ $product->image_url }}" placeholder="https://example.com/image.jpg" oninput="previewUrl(this)">
            </div>
            <img id="imgPreview" class="img-preview" alt="Preview">
        </div>
        <button type="submit" class="btn-submit"><i class="fas fa-save me-2"></i> Update Product</button>
    </form>
</div>
<script>
function previewImage(input) {
    const preview = document.getElementById('imgPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
function previewUrl(input) {
    const preview = document.getElementById('imgPreview');
    if (input.value) { preview.src = input.value; preview.style.display = 'block'; }
    else { preview.style.display = 'none'; }
}
</script>
@endsection
