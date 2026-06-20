@extends('layouts.app')
@section('title', 'All Orders')
@section('content')
<style>
:root{--void:#080b14;--deep:#0f1623;--panel:#151d2e;--border:rgba(255,255,255,0.07);--cyan:#00e5ff;--lime:#b8ff57;--violet:#8b5cf6;--rose:#ff4d6d;--amber:#fbbf24;--text:#e2e8f4;--muted:#64748b;}
body{background:var(--void);color:var(--text);font-family:'Bricolage Grotesque',sans-serif;}
.wrap{max-width:1100px;margin:0 auto;padding:3rem 1.5rem 5rem;}
.page-title{font-family:'Clash Display',serif;font-size:2rem;font-weight:700;margin-bottom:2rem;}
.page-title span{background:linear-gradient(90deg,var(--cyan),var(--lime));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.order-card{background:var(--panel);border:1px solid var(--border);border-radius:20px;margin-bottom:1.25rem;overflow:hidden;transition:border-color .25s;}
.order-card:hover{border-color:rgba(0,229,255,.15);}
.order-head{display:flex;align-items:center;justify-content:space-between;padding:1rem 1.5rem;background:rgba(255,255,255,.02);border-bottom:1px solid var(--border);flex-wrap:wrap;gap:.5rem;}
.order-id{color:var(--cyan);font-family:'Clash Display',sans-serif;font-weight:600;font-size:.9rem;}
.order-date{font-size:.78rem;color:var(--muted);}
.order-total{font-family:'Clash Display',sans-serif;font-size:1rem;font-weight:700;color:var(--lime);}
.order-body{padding:1.25rem 1.5rem;}
.buyer-row{font-size:.85rem;color:var(--muted);margin-bottom:.75rem;}
.buyer-row strong{color:var(--text);}
.items-ul{list-style:none;margin:0 0 1rem;padding:0;display:flex;flex-wrap:wrap;gap:.35rem;}
.items-ul li{background:rgba(255,255,255,.03);border:1px solid var(--border);border-radius:8px;padding:.25rem .65rem;font-size:.78rem;color:var(--text);}

/* Status badge */
.status-badge{display:inline-flex;align-items:center;gap:.4rem;font-size:.75rem;font-weight:700;padding:.3rem .75rem;border-radius:8px;}

/* Update form */
.update-form{background:var(--deep);border:1px solid var(--border);border-radius:14px;padding:1.25rem;display:none;}
.update-form.open{display:block;}
.form-row{display:grid;grid-template-columns:repeat(3,1fr) auto;gap:.75rem;align-items:end;flex-wrap:wrap;}
@media(max-width:700px){.form-row{grid-template-columns:1fr;}}
.field label{font-size:.72rem;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);display:block;margin-bottom:.3rem;}
.field input,.field select,.field textarea{background:var(--panel);border:1px solid var(--border);border-radius:8px;color:var(--text);padding:.6rem .85rem;font-size:.85rem;font-family:inherit;outline:none;width:100%;}
.field input:focus,.field select:focus{border-color:rgba(0,229,255,.4);}
.field select option{background:var(--deep);}
.btn-update{background:var(--cyan);color:var(--void);font-weight:700;font-size:.85rem;padding:.65rem 1.25rem;border:none;border-radius:8px;cursor:pointer;white-space:nowrap;transition:all .2s;}
.btn-update:hover{background:#00f0ff;}
.toggle-btn{background:rgba(0,229,255,.08);border:1px solid rgba(0,229,255,.15);color:var(--cyan);font-size:.78rem;padding:.35rem .8rem;border-radius:8px;cursor:pointer;transition:all .2s;}
.toggle-btn:hover{background:rgba(0,229,255,.15);}
</style>
<link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@600;700&display=swap" rel="stylesheet">
<div class="wrap">
    <h1 class="page-title">Manage <span>Orders</span></h1>
    @if(session('success'))<div style="background:rgba(184,255,87,.1);border:1px solid rgba(184,255,87,.2);color:var(--lime);border-radius:10px;padding:.75rem 1rem;margin-bottom:1.5rem;font-size:.875rem;"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>@endif
    @foreach($orders as $order)
    @php $si = $order->status_info; @endphp
    <div class="order-card">
        <div class="order-head">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <span class="order-id">#{{ str_pad($order->id,4,'0',STR_PAD_LEFT) }}</span>
                <span class="order-date"><i class="fas fa-calendar-days me-1"></i>{{ $order->created_at->format('d M Y, h:i A') }}</span>
                <span class="status-badge" style="background:{{ $si['color'] }}22;border:1px solid {{ $si['color'] }}44;color:{{ $si['color'] }};">
                    <i class="fas {{ $si['icon'] }}"></i> {{ $si['label'] }}
                </span>
            </div>
            <div style="display:flex;align-items:center;gap:.75rem;">
                <span class="order-total">PKR {{ number_format($order->total_price,2) }}</span>
                <button class="toggle-btn" onclick="toggleForm({{ $order->id }})"><i class="fas fa-edit me-1"></i> Update</button>
            </div>
        </div>
        <div class="order-body">
            <div class="buyer-row">
                <strong>{{ $order->buyer_name }}</strong> &bull; {{ $order->phone }} &bull; {{ $order->address }}
                @if($order->tracking_number) &bull; <span style="color:var(--cyan);">Track: {{ $order->tracking_number }}</span>@endif
            </div>
            <ul class="items-ul">
                @foreach($order->items as $item)
                <li><i class="fas fa-box me-1" style="opacity:.4;"></i>{{ $item->product->name ?? 'Product' }} × {{ $item->quantity }}</li>
                @endforeach
            </ul>

            <!-- Update Form -->
            <div class="update-form" id="form-{{ $order->id }}">
                <form action="{{ route('admin.orders.updateStatus',['order'=>$order->id]) }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="field">
                            <label>Status</label>
                            <select name="status">
                                @foreach($statuses as $key => $info)
                                <option value="{{ $key }}" {{ $order->status===$key?'selected':'' }}>{{ $info['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <label>Courier Name</label>
                            <input type="text" name="courier" value="{{ $order->courier }}" placeholder="e.g. TCS, Leopards">
                        </div>
                        <div class="field">
                            <label>Tracking #</label>
                            <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" placeholder="auto-generated or custom">
                        </div>
                        <div class="field" style="align-self:flex-end;">
                            <button type="submit" class="btn-update"><i class="fas fa-save me-1"></i> Save</button>
                        </div>
                    </div>
                    <div class="field" style="margin-top:.75rem;">
                        <label>Delivery Notes</label>
                        <textarea name="delivery_notes" rows="2" placeholder="Optional note to buyer...">{{ $order->delivery_notes }}</textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    @if($orders->isEmpty())<div style="text-align:center;padding:4rem;color:var(--muted);"><i class="fas fa-receipt" style="font-size:2rem;display:block;margin-bottom:.75rem;"></i>No orders yet.</div>@endif
</div>
<script>
function toggleForm(id) {
    const el = document.getElementById('form-'+id);
    el.classList.toggle('open');
}
</script>
@endsection
