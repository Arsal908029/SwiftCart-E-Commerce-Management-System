@extends('layouts.app')
@section('title', 'Feedbacks')
@section('content')
<style>
:root{--void:#080b14;--deep:#0f1623;--panel:#151d2e;--border:rgba(255,255,255,0.07);--cyan:#00e5ff;--lime:#b8ff57;--violet:#8b5cf6;--rose:#ff4d6d;--text:#e2e8f4;--muted:#64748b;}
body{background:var(--void);color:var(--text);font-family:'Bricolage Grotesque',sans-serif;}
.wrap{max-width:960px;margin:0 auto;padding:3rem 1.5rem 5rem;}
.page-title{font-family:'Clash Display',serif;font-size:2rem;font-weight:700;margin-bottom:2rem;}
.page-title span{background:linear-gradient(90deg,var(--cyan),var(--lime));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.fb-card{background:var(--panel);border:1px solid var(--border);border-radius:16px;padding:1.25rem 1.5rem;margin-bottom:.75rem;display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;}
.fb-meta .fb-name{font-size:.9rem;font-weight:600;color:var(--text);}
.fb-meta .fb-info{font-size:.78rem;color:var(--muted);margin-top:.2rem;}
.fb-stars{color:#fbbf24;font-size:.8rem;}
.fb-msg{font-size:.875rem;color:var(--muted);margin-top:.4rem;}
.type-badge{font-size:.68rem;text-transform:uppercase;letter-spacing:.08em;font-weight:700;padding:.15rem .5rem;border-radius:5px;margin-left:.4rem;}
.tb-general{background:rgba(0,229,255,.1);color:var(--cyan);}
.tb-product{background:rgba(139,92,246,.1);color:var(--violet);}
.tb-order{background:rgba(184,255,87,.1);color:var(--lime);}
.del-btn{background:rgba(255,77,109,.08);border:1px solid rgba(255,77,109,.2);color:var(--rose);border-radius:8px;padding:.35rem .75rem;font-size:.78rem;cursor:pointer;transition:all .2s;white-space:nowrap;}
.del-btn:hover{background:var(--rose);color:#fff;}
.empty{text-align:center;padding:4rem;color:var(--muted);}
</style>
<link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@600;700&display=swap" rel="stylesheet">
<div class="wrap">
    <h1 class="page-title">Customer <span>Feedbacks</span></h1>
    @if(session('success'))<div style="background:rgba(184,255,87,.1);border:1px solid rgba(184,255,87,.2);color:var(--lime);border-radius:10px;padding:.75rem 1rem;margin-bottom:1.5rem;font-size:.875rem;">{{ session('success') }}</div>@endif
    @if($feedbacks->isEmpty())
    <div class="empty"><i class="fas fa-comments" style="font-size:2rem;margin-bottom:.75rem;display:block;"></i>No feedback yet.</div>
    @else
    @foreach($feedbacks as $fb)
    <div class="fb-card">
        <div style="flex:1;">
            <div class="fb-meta">
                <span class="fb-name">{{ $fb->name }}</span>
                <span class="type-badge tb-{{ $fb->type }}">{{ $fb->type }}</span>
                <span style="font-size:.75rem;color:var(--muted);margin-left:.4rem;">{{ $fb->created_at->format('d M Y') }}</span>
            </div>
            <div class="fb-stars">@for($i=1;$i<=5;$i++)<i class="fas fa-star" style="{{ $i<=$fb->rating?'':'opacity:.25' }}"></i>@endfor</div>
            @if($fb->subject)<div style="font-size:.85rem;font-weight:600;color:var(--text);margin-top:.2rem;">{{ $fb->subject }}</div>@endif
            <div class="fb-msg">{{ $fb->message }}</div>
            @if($fb->product)<div class="fb-info" style="margin-top:.3rem;"><i class="fas fa-box me-1"></i>Product: {{ $fb->product->name }}</div>@endif
            @if($fb->order)<div class="fb-info"><i class="fas fa-receipt me-1"></i>Order #{{ str_pad($fb->order_id,4,'0',STR_PAD_LEFT) }}</div>@endif
        </div>
        <form action="{{ route('admin.feedbacks.delete',['feedback'=>$fb->id]) }}" method="POST" onsubmit="return confirm('Delete this feedback?')">
            @csrf @method('DELETE')
            <button type="submit" class="del-btn"><i class="fas fa-trash"></i></button>
        </form>
    </div>
    @endforeach
    @endif
</div>
@endsection
