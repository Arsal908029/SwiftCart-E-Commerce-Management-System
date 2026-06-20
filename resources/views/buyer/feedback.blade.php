@extends('layouts.app')
@section('title', 'Feedback')
@section('content')
<style>
:root{--void:#080b14;--deep:#0f1623;--panel:#151d2e;--border:rgba(255,255,255,0.07);--cyan:#00e5ff;--lime:#b8ff57;--violet:#8b5cf6;--rose:#ff4d6d;--amber:#fbbf24;--text:#e2e8f4;--muted:#64748b;}
body{background:var(--void);color:var(--text);font-family:'Bricolage Grotesque','Segoe UI',sans-serif;}
.fb-wrap{max-width:860px;margin:0 auto;padding:3rem 1.5rem 5rem;}
.back-link{display:inline-flex;align-items:center;gap:.4rem;font-size:.8rem;color:var(--muted);text-decoration:none;margin-bottom:2rem;transition:color .2s;}
.back-link:hover{color:var(--cyan);}
.kicker{display:inline-flex;align-items:center;gap:.5rem;font-size:.72rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:var(--cyan);margin-bottom:.75rem;}
.kicker-dot{width:6px;height:6px;background:var(--cyan);border-radius:50%;animation:pulse 2s ease-in-out infinite;}
.page-title{font-family:'Clash Display',serif;font-size:2.2rem;font-weight:700;letter-spacing:-.04em;margin-bottom:.3rem;}
.page-title span{background:linear-gradient(90deg,var(--cyan),var(--lime));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}

.form-card{background:var(--panel);border:1px solid var(--border);border-radius:20px;padding:2rem;margin-bottom:2rem;animation:fadeUp .6s ease .1s both;}
.sec-title{font-size:.72rem;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);margin-bottom:1.25rem;}
.field{display:flex;flex-direction:column;gap:.4rem;margin-bottom:1rem;}
.field label{font-size:.78rem;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;}
.field input,.field textarea,.field select{background:var(--deep);border:1px solid var(--border);border-radius:10px;color:var(--text);padding:.75rem 1rem;font-size:.9rem;font-family:inherit;transition:border-color .2s;outline:none;width:100%;}
.field input:focus,.field textarea:focus,.field select:focus{border-color:rgba(0,229,255,.4);}
.field select option{background:var(--deep);}

/* Star rating */
.star-picker{display:flex;flex-direction:row-reverse;gap:.3rem;justify-content:flex-end;}
.star-picker input{display:none;}
.star-picker label{font-size:1.6rem;color:var(--muted);cursor:pointer;transition:color .15s;}
.star-picker input:checked ~ label,.star-picker label:hover,.star-picker label:hover ~ label{color:#fbbf24;}

.row2{display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;}
@media(max-width:600px){.row2{grid-template-columns:1fr;}}

.btn-submit{background:var(--cyan);color:var(--void);font-family:'Clash Display',sans-serif;font-weight:700;font-size:.95rem;padding:.85rem 2.5rem;border-radius:12px;border:none;cursor:pointer;transition:all .25s;}
.btn-submit:hover{background:#00f0ff;transform:translateY(-2px);box-shadow:0 0 30px rgba(0,229,255,.25);}

/* Community reviews */
.reviews-section{animation:fadeUp .6s ease .2s both;}
.rev-card{background:var(--panel);border:1px solid var(--border);border-radius:16px;padding:1.25rem 1.5rem;margin-bottom:.75rem;transition:border-color .2s;}
.rev-card:hover{border-color:rgba(0,229,255,.15);}
.rev-top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:.6rem;}
.rev-name{font-size:.875rem;font-weight:600;color:var(--text);}
.rev-date{font-size:.75rem;color:var(--muted);}
.rev-stars{color:#fbbf24;font-size:.8rem;margin-bottom:.4rem;}
.rev-msg{font-size:.875rem;color:var(--muted);}
.type-badge{font-size:.68rem;text-transform:uppercase;letter-spacing:.08em;font-weight:700;padding:.15rem .5rem;border-radius:5px;margin-left:.5rem;}
.tb-general{background:rgba(0,229,255,.1);color:var(--cyan);}
.tb-product{background:rgba(139,92,246,.1);color:var(--violet);}
.tb-order{background:rgba(184,255,87,.1);color:var(--lime);}

@keyframes pulse{0%,100%{opacity:1;}50%{opacity:.4;}}
@keyframes fadeUp{from{opacity:0;transform:translateY(18px);}to{opacity:1;transform:translateY(0);}}
</style>
<link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@400;600;700&family=Bricolage+Grotesque:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="fb-wrap">
    <a href="{{ url('/buyer/dashboard') }}" class="back-link"><i class="fas fa-arrow-left"></i> Dashboard</a>

    <div style="margin-bottom:2.5rem;animation:fadeUp .6s ease both">
        <div class="kicker"><div class="kicker-dot"></div> Your Voice</div>
        <h1 class="page-title">Leave <span>Feedback</span></h1>
        <p style="font-size:.9rem;color:var(--muted);">Share your experience to help us improve.</p>
    </div>

    @if(session('success'))<div style="background:rgba(184,255,87,.1);border:1px solid rgba(184,255,87,.2);color:var(--lime);border-radius:10px;padding:.9rem 1.2rem;margin-bottom:1.5rem;font-size:.875rem;"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>@endif

    <!-- Feedback Form -->
    <form action="{{ route('buyer.feedback.submit') }}" method="POST">
        @csrf
        <div class="form-card">
            <div class="sec-title"><i class="fas fa-pen me-1"></i> Write a Review</div>

            <div class="row2">
                <div class="field">
                    <label>Your Name</label>
                    <input type="text" name="name" value="{{ old('name',$user->name) }}" required>
                </div>
                <div class="field">
                    <label>Feedback Type</label>
                    <select name="type" id="fbType" onchange="toggleFields()">
                        <option value="general">General Feedback</option>
                        <option value="product">Product Review</option>
                        <option value="order">Order Review</option>
                    </select>
                </div>
            </div>

            <div class="field" id="productField" style="display:none;">
                <label>Select Product</label>
                <select name="product_id">
                    <option value="">-- Choose Product --</option>
                    @foreach($products as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field" id="orderField" style="display:none;">
                <label>Select Order</label>
                <select name="order_id">
                    <option value="">-- Choose Order --</option>
                    @foreach($orders as $o)
                    <option value="{{ $o->id }}">#{{ str_pad($o->id,4,'0',STR_PAD_LEFT) }} — PKR {{ number_format($o->total_price,0) }} ({{ $o->created_at->format('d M Y') }})</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label>Rating</label>
                <div class="star-picker">
                    <input type="radio" name="rating" id="s5" value="5" {{ old('rating',5)==5?'checked':'' }}>
                    <label for="s5"><i class="fas fa-star"></i></label>
                    <input type="radio" name="rating" id="s4" value="4" {{ old('rating')==4?'checked':'' }}>
                    <label for="s4"><i class="fas fa-star"></i></label>
                    <input type="radio" name="rating" id="s3" value="3" {{ old('rating')==3?'checked':'' }}>
                    <label for="s3"><i class="fas fa-star"></i></label>
                    <input type="radio" name="rating" id="s2" value="2" {{ old('rating')==2?'checked':'' }}>
                    <label for="s2"><i class="fas fa-star"></i></label>
                    <input type="radio" name="rating" id="s1" value="1" {{ old('rating')==1?'checked':'' }}>
                    <label for="s1"><i class="fas fa-star"></i></label>
                </div>
            </div>

            <div class="field">
                <label>Subject (optional)</label>
                <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Brief summary...">
            </div>
            <div class="field">
                <label>Message</label>
                <textarea name="message" rows="4" required placeholder="Share your experience in detail...">{{ old('message') }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn-submit"><i class="fas fa-paper-plane me-2"></i> Submit Feedback</button>
    </form>

    <!-- Community Reviews -->
    @if($publicFeedbacks->count())
    <div class="reviews-section" style="margin-top:3rem;">
        <h3 style="font-family:'Clash Display',sans-serif;font-size:1.4rem;font-weight:700;margin-bottom:1.5rem;">Community Reviews</h3>
        @foreach($publicFeedbacks as $fb)
        <div class="rev-card">
            <div class="rev-top">
                <div>
                    <span class="rev-name">{{ $fb->name }}</span>
                    <span class="type-badge tb-{{ $fb->type }}">{{ $fb->type }}</span>
                </div>
                <span class="rev-date">{{ $fb->created_at->format('d M Y') }}</span>
            </div>
            <div class="rev-stars">
                @for($i=1;$i<=5;$i++)<i class="fas fa-star" style="{{ $i<=$fb->rating?'':'opacity:.3' }}"></i>@endfor
            </div>
            @if($fb->subject)<div style="font-size:.875rem;font-weight:600;color:var(--text);margin-bottom:.3rem;">{{ $fb->subject }}</div>@endif
            <div class="rev-msg">{{ $fb->message }}</div>
        </div>
        @endforeach
    </div>
    @endif
</div>
<script>
function toggleFields() {
    const type = document.getElementById('fbType').value;
    document.getElementById('productField').style.display = type==='product' ? 'flex' : 'none';
    document.getElementById('orderField').style.display   = type==='order'   ? 'flex' : 'none';
}
</script>
@endsection
