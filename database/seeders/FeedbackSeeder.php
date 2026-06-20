<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feedback;
use App\Models\Product;
use App\Models\Order;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        Feedback::query()->delete();

        $reviewers = [
            ['name'=>'Ahmed Khan',    'email'=>'ahmed@example.com'],
            ['name'=>'Sara Malik',    'email'=>'sara@example.com'],
            ['name'=>'Usman Tariq',   'email'=>'usman@example.com'],
            ['name'=>'Ayesha Noor',   'email'=>'ayesha@example.com'],
            ['name'=>'Bilal Hassan',  'email'=>'bilal@example.com'],
            ['name'=>'Zara Ahmed',    'email'=>'zara@example.com'],
            ['name'=>'Omar Farooq',   'email'=>'omar@example.com'],
            ['name'=>'Hina Siddiqui', 'email'=>'hina@example.com'],
            ['name'=>'Fahad Qureshi', 'email'=>'fahad@example.com'],
            ['name'=>'Nadia Awan',    'email'=>'nadia@example.com'],
            ['name'=>'Kamran Shah',   'email'=>'kamran@example.com'],
            ['name'=>'Sana Butt',     'email'=>'sana@example.com'],
        ];

        $generalMessages = [
            ['r'=>5,'s'=>'Excellent Service!',      'm'=>'SwiftCart has the best prices in Pakistan. Delivery was super fast and packaging was secure. Will definitely order again!'],
            ['r'=>5,'s'=>'Highly Recommended',       'm'=>'Amazing platform. Found everything I needed in one place. Customer service was responsive and helpful.'],
            ['r'=>4,'s'=>'Great Experience',         'm'=>'Very smooth shopping experience overall. The website is easy to navigate and checkout was seamless.'],
            ['r'=>4,'s'=>'Good Platform',            'm'=>'Good variety of products and competitive pricing. Delivery was on time. Minor UI glitches but nothing major.'],
            ['r'=>5,'s'=>'Love This Store',          'm'=>'I have been shopping here for 3 months now and never had an issue. The order tracking feature is really helpful.'],
            ['r'=>3,'s'=>'Average Experience',       'm'=>'Products are good but delivery took a bit longer than expected. Hope the logistics improve in the future.'],
            ['r'=>5,'s'=>'Best Online Store in PK',  'm'=>'Prices are unbeatable. I compared with other stores and SwiftCart always wins. Packaging is solid too.'],
            ['r'=>4,'s'=>'Satisfied Customer',       'm'=>'Happy with my purchases so far. The profile page is a great feature — easy to track all my orders in one place.'],
        ];

        $productMessages = [
            ['r'=>5,'s'=>'Exactly As Described',     'm'=>'The product matches the description perfectly. Build quality is excellent and it arrived well-packaged.'],
            ['r'=>5,'s'=>'Superb Quality',            'm'=>'Honestly impressed. The quality is far better than I expected for this price point. Highly recommend!'],
            ['r'=>4,'s'=>'Good Value for Money',      'm'=>'Great product for the price. Does exactly what it promises. Delivery was quick and packaging was protective.'],
            ['r'=>4,'s'=>'Works Perfectly',           'm'=>'Product works exactly as advertised. Setup was easy and instructions were clear. Very happy with the purchase.'],
            ['r'=>3,'s'=>'Decent Product',            'm'=>'Product is okay, not the best quality but acceptable for the price. Would prefer better build materials.'],
            ['r'=>5,'s'=>'Exceeded Expectations',     'm'=>'I was skeptical at first but this product has blown me away. Amazing quality and super fast delivery!'],
            ['r'=>2,'s'=>'Not As Expected',           'm'=>'The product looks different from the photos. Quality could be better. However customer support helped resolve my issue.'],
            ['r'=>5,'s'=>'Perfect Purchase',          'm'=>'Exactly what I was looking for. The product is premium quality and the image URL showed the product accurately.'],
        ];

        $orderMessages = [
            ['r'=>5,'s'=>'Lightning Fast Delivery',   'm'=>'Ordered on Monday, received by Tuesday! The tracking system is really accurate and kept me informed at every step.'],
            ['r'=>4,'s'=>'Good Delivery Service',     'm'=>'Delivery was smooth and the tracking updates were timely. Courier was professional and handled the package carefully.'],
            ['r'=>5,'s'=>'Excellent Packaging',       'm'=>'Products were bubble-wrapped and double-boxed. Nothing was damaged. This is how online shopping should be!'],
            ['r'=>3,'s'=>'Delivery Delayed',          'm'=>'Order arrived 2 days late but the support team kept me updated. Product was fine once it arrived.'],
            ['r'=>5,'s'=>'Perfect Order',             'm'=>'All items were correct, packaging was great and delivery was on time. The order tracking page is very well designed.'],
            ['r'=>4,'s'=>'Happy with Order',          'm'=>'Smooth experience from checkout to delivery. Will order again. The tracking number helped me monitor my shipment.'],
        ];

        $products = Product::inRandomOrder()->take(30)->get();
        $orders   = Order::where('status','delivered')->take(20)->get();

        // General feedback (8)
        foreach ($generalMessages as $idx => $fb) {
            $rev = $reviewers[$idx % count($reviewers)];
            Feedback::create([
                'name'       => $rev['name'],
                'email'      => $rev['email'],
                'rating'     => $fb['r'],
                'subject'    => $fb['s'],
                'message'    => $fb['m'],
                'type'       => 'general',
                'is_public'  => true,
                'created_at' => now()->subDays(rand(1, 45)),
                'updated_at' => now()->subDays(rand(0, 5)),
            ]);
        }

        // Product feedback (8)
        foreach ($productMessages as $idx => $fb) {
            $rev     = $reviewers[($idx + 3) % count($reviewers)];
            $product = $products->get($idx % $products->count());
            Feedback::create([
                'name'       => $rev['name'],
                'email'      => $rev['email'],
                'rating'     => $fb['r'],
                'subject'    => $fb['s'],
                'message'    => $fb['m'],
                'type'       => 'product',
                'product_id' => $product ? $product->id : null,
                'is_public'  => true,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 3)),
            ]);
        }

        // Order feedback (6)
        foreach ($orderMessages as $idx => $fb) {
            $rev   = $reviewers[($idx + 6) % count($reviewers)];
            $order = $orders->get($idx % max(1, $orders->count()));
            Feedback::create([
                'name'       => $rev['name'],
                'email'      => $rev['email'],
                'rating'     => $fb['r'],
                'subject'    => $fb['s'],
                'message'    => $fb['m'],
                'type'       => 'order',
                'order_id'   => $order ? $order->id : null,
                'is_public'  => true,
                'created_at' => now()->subDays(rand(1, 20)),
                'updated_at' => now()->subDays(rand(0, 2)),
            ]);
        }
    }
}
