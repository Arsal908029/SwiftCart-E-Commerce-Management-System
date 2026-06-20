<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['buyer_name','address','phone','total_price','status','tracking_number','courier','shipped_at','delivered_at','delivery_notes'];

    protected $casts = [
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    const STATUSES = [
        'pending'    => ['label'=>'Pending',     'color'=>'#fbbf24', 'icon'=>'fa-clock'],
        'confirmed'  => ['label'=>'Confirmed',   'color'=>'#00e5ff', 'icon'=>'fa-check-circle'],
        'processing' => ['label'=>'Processing',  'color'=>'#8b5cf6', 'icon'=>'fa-cog'],
        'shipped'    => ['label'=>'Shipped',     'color'=>'#3b82f6', 'icon'=>'fa-truck'],
        'out_for_delivery'=>['label'=>'Out for Delivery','color'=>'#f97316','icon'=>'fa-motorcycle'],
        'delivered'  => ['label'=>'Delivered',   'color'=>'#b8ff57', 'icon'=>'fa-box-open'],
        'cancelled'  => ['label'=>'Cancelled',   'color'=>'#ff4d6d', 'icon'=>'fa-times-circle'],
    ];

    public function getStatusInfoAttribute()
    {
        return self::STATUSES[$this->status] ?? ['label'=>ucfirst($this->status),'color'=>'#64748b','icon'=>'fa-circle'];
    }

    public function items() { return $this->hasMany(OrderItem::class); }
    public function payment() { return $this->hasOne(Payment::class); }
    public function feedbacks() { return $this->hasMany(Feedback::class); }
}
