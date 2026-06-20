<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        \DB::table('payments')->delete();
        \DB::table('order_items')->delete();
        Order::query()->delete();

        $buyers = [
            ['name'=>'Ahmed Khan',    'phone'=>'+92 312 1234567', 'address'=>'House 45, Street 7, Gulberg III, Lahore'],
            ['name'=>'Sara Malik',    'phone'=>'+92 333 9876543', 'address'=>'Flat 12B, Block 5, Clifton, Karachi'],
            ['name'=>'Usman Tariq',   'phone'=>'+92 321 5556677', 'address'=>'House 9, F-7/2, Islamabad'],
            ['name'=>'Ayesha Noor',   'phone'=>'+92 345 1122334', 'address'=>'University Town, Peshawar'],
            ['name'=>'Bilal Hassan',  'phone'=>'+92 301 9988776', 'address'=>'Block D, Eden Gardens, Faisalabad'],
            ['name'=>'Zara Ahmed',    'phone'=>'+92 315 4433221', 'address'=>'Shah Rukn-e-Alam Colony, Multan'],
            ['name'=>'Omar Farooq',   'phone'=>'+92 300 7788990', 'address'=>'Bahria Town Phase 7, Rawalpindi'],
            ['name'=>'Hina Siddiqui', 'phone'=>'+92 322 6655443', 'address'=>'Jinnah Town, Quetta'],
            ['name'=>'Fahad Qureshi', 'phone'=>'+92 336 2211009', 'address'=>'Cantt Area, Sialkot'],
            ['name'=>'Nadia Awan',    'phone'=>'+92 344 8877665', 'address'=>'Latifabad Unit 10, Hyderabad'],
        ];

        $couriers   = ['TCS Express', 'Leopards Courier', 'M&P Courier', 'PostEx', 'Trax Courier'];
        $allStatuses = ['pending','confirmed','processing','shipped','out_for_delivery','delivered','delivered','delivered'];
        $products   = Product::all();

        if ($products->isEmpty()) return;

        for ($i = 0; $i < 40; $i++) {
            $buyer   = $buyers[array_rand($buyers)];
            $status  = $allStatuses[array_rand($allStatuses)];
            $courier = $couriers[array_rand($couriers)];
            $trackNo = 'TRK' . strtoupper(substr(md5(uniqid()), 0, 8));
            $daysAgo = rand(0, 60);

            $shippedAt   = null;
            $deliveredAt = null;
            if (in_array($status, ['shipped','out_for_delivery','delivered'])) {
                $shippedAt = now()->subDays($daysAgo)->subHours(rand(1,48));
            }
            if ($status === 'delivered') {
                $deliveredAt = $shippedAt ? $shippedAt->copy()->addDays(rand(1,5)) : now()->subDays(rand(1,10));
            }

            $order = Order::create([
                'buyer_name'      => $buyer['name'],
                'phone'           => $buyer['phone'],
                'address'         => $buyer['address'],
                'total_price'     => 0,
                'status'          => $status,
                'tracking_number' => $trackNo,
                'courier'         => in_array($status, ['shipped','out_for_delivery','delivered']) ? $courier : null,
                'shipped_at'      => $shippedAt,
                'delivered_at'    => $deliveredAt,
                'delivery_notes'  => $status === 'delivered' ? 'Package delivered successfully.' : null,
                'created_at'      => now()->subDays($daysAgo)->subHours(rand(1,12)),
                'updated_at'      => now()->subDays(max(0,$daysAgo-1)),
            ]);

            // 1-4 items per order
            $itemCount  = rand(1, 4);
            $pickedProds = $products->random(min($itemCount, $products->count()));
            $total = 0;

            foreach ($pickedProds as $product) {
                $qty  = rand(1, 3);
                $price = $product->price;
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $qty,
                    'price'      => $price,
                ]);
                $total += $price * $qty;
            }

            $order->update(['total_price' => $total]);

            Payment::create([
                'order_id' => $order->id,
                'amount'   => $total,
            ]);
        }
    }
}
