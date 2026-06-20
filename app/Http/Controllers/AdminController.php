<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Feedback;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'orderCount'   => Order::count(),
            'paymentCount' => Payment::count(),
            'totalRevenue' => Order::sum('total_price'),
            'latestOrders' => Order::with('items.product')->latest()->take(5)->get(),
            'pendingOrders'=> Order::where('status','pending')->count(),
            'recentFeedbacks' => Feedback::latest()->take(5)->get(),
        ]);
    }

    // Products
    public function products()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }
    public function createProduct()
    {
        return view('admin.products.create');
    }
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'image'       => 'nullable|image|max:4096',
            'image_url'   => 'nullable|url',
        ]);
        $data = $request->only(['name', 'description', 'price', 'quantity']);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('product_images', 'public');
            $data['image_path'] = $path;
            $data['image_url'] = null;
        } elseif ($request->filled('image_url')) {
            $data['image_url'] = $request->image_url;
            $data['image_path'] = null;
        }
        Product::create($data);
        return redirect('/admin/products')->with('success', 'Product added!');
    }
    public function editProduct(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }
    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'image'       => 'nullable|image|max:4096',
            'image_url'   => 'nullable|url',
        ]);
        $data = $request->only(['name', 'description', 'price', 'quantity']);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('product_images', 'public');
            $data['image_path'] = $path;
            $data['image_url'] = null;
        } elseif ($request->filled('image_url')) {
            $data['image_url'] = $request->image_url;
            $data['image_path'] = null;
        }
        $product->update($data);
        return redirect('/admin/products')->with('success', 'Product updated!');
    }
    public function deleteProduct(Product $product)
    {
        $product->delete();
        return redirect('/admin/products')->with('success', 'Product deleted!');
    }

    // Orders
    public function orders()
    {
        $orders = Order::with('items.product')->latest()->get();
        $statuses = Order::STATUSES;
        return view('admin.orders.index', compact('orders','statuses'));
    }
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status'          => 'required|in:pending,confirmed,processing,shipped,out_for_delivery,delivered,cancelled',
            'tracking_number' => 'nullable|string|max:100',
            'courier'         => 'nullable|string|max:100',
            'delivery_notes'  => 'nullable|string',
        ]);
        $data = $request->only(['status','tracking_number','courier','delivery_notes']);
        if ($request->status === 'shipped' && !$order->shipped_at) {
            $data['shipped_at'] = now();
        }
        if ($request->status === 'delivered' && !$order->delivered_at) {
            $data['delivered_at'] = now();
        }
        $order->update($data);
        return back()->with('success', 'Order #'.str_pad($order->id,4,'0',STR_PAD_LEFT).' status updated to '.$request->status.'.');
    }

    // Payments
    public function payments()
    {
        $payments = Payment::all();
        return view('admin.payments.index', compact('payments'));
    }

    // Sales
    public function sales()
    {
        $orders = Order::with('items.product')->latest()->get();
        $totalSales = $orders->sum('total_price');
        return view('admin.sales', compact('orders', 'totalSales'));
    }

    // Feedback
    public function feedbacks()
    {
        $feedbacks = Feedback::with(['user','product','order'])->latest()->get();
        return view('admin.feedbacks.index', compact('feedbacks'));
    }
    public function deleteFeedback(Feedback $feedback)
    {
        $feedback->delete();
        return back()->with('success', 'Feedback deleted.');
    }
}
