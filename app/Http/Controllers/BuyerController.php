<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Feedback;

class BuyerController extends Controller
{
    public function dashboard(Request $request)
    {
        $recentProducts = Product::where('quantity', '>', 0)->latest('created_at')->limit(6)->get();
        $categories = Category::all();
        $recentOrders = Order::with('items.product')->latest()->take(3)->get();
        return view('buyer.dashboard', compact('recentProducts','categories','recentOrders'));
    }

    public function products(Request $request)
    {
        $query = Product::where('quantity', '>', 0);
        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function($q) use ($s) {
                $q->where('name','like',"%{$s}%")->orWhere('description','like',"%{$s}%");
            });
        }
        if ($request->filled('category')) {
            $catId = $request->input('category');
            $query->whereHas('categories', fn($q) => $q->where('categories.id',$catId));
        }
        if ($request->filled('price_min')) $query->where('price','>=',$request->input('price_min'));
        if ($request->filled('price_max')) $query->where('price','<=',$request->input('price_max'));
        $sortBy = $request->input('sort_by','latest');
        match($sortBy) {
            'price_low'  => $query->orderBy('price','asc'),
            'price_high' => $query->orderBy('price','desc'),
            'oldest'     => $query->oldest(),
            default      => $query->latest(),
        };
        $products = $query->get();
        $categories = Category::all();
        return view('buyer.products', compact('products','categories'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'buyer_name' => 'required|string|max:255',
        ]);
        $product = Product::findOrFail($request->product_id);
        if ($product->quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock for the selected product.');
        }
        Cart::create(['product_id'=>$request->product_id,'quantity'=>$request->quantity,'buyer_name'=>$request->buyer_name]);
        return redirect('/buyer/cart')->with('success', 'Product added to cart');
    }

    public function viewCart()
    {
        $cartItems = Cart::with('product')->get();
        return view('buyer.cart', compact('cartItems'));
    }

    public function removeFromCart($id)
    {
        Cart::destroy($id);
        return back()->with('success', 'Item removed from cart');
    }

    public function checkoutForm()
    {
        $user = Auth::user();
        return view('buyer.checkout', compact('user'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'phone'   => 'required|string|max:15',
        ]);
        $cartItems = Cart::with('product')->get();
        if ($cartItems->isEmpty()) return back()->with('error','Cart is empty.');
        $total = 0;
        $trackingNum = 'TRK'.strtoupper(uniqid());
        $order = Order::create([
            'buyer_name'      => $request->name,
            'address'         => $request->address,
            'phone'           => $request->phone,
            'total_price'     => 0,
            'status'          => 'pending',
            'tracking_number' => $trackingNum,
        ]);
        foreach ($cartItems as $item) {
            $product = $item->product;
            if ($product->quantity < $item->quantity) {
                $order->delete();
                return back()->with('error','Insufficient stock for '.$product->name);
            }
            OrderItem::create(['order_id'=>$order->id,'product_id'=>$product->id,'quantity'=>$item->quantity,'price'=>$product->price]);
            $product->decrement('quantity',$item->quantity);
            $total += $product->price * $item->quantity;
        }
        $order->update(['total_price'=>$total]);
        Payment::create(['order_id'=>$order->id,'amount'=>$total]);
        Cart::truncate();
        return redirect('/buyer/orders')->with('success','Order placed! Tracking #: '.$trackingNum);
    }

    public function myOrders()
    {
        $orders = Order::with(['items.product','payment'])->latest()->get();
        return view('buyer.orders', compact('orders'));
    }

    public function trackOrder($id)
    {
        $order = Order::with(['items.product','payment'])->findOrFail($id);
        return view('buyer.track-order', compact('order'));
    }

    // Profile
    public function profile()
    {
        $user = Auth::user();
        $orders = Order::with('items.product')->latest()->take(5)->get();
        $feedbacks = Feedback::where('user_id',$user->id)->latest()->get();
        return view('buyer.profile', compact('user','orders','feedbacks'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'city'    => 'nullable|string|max:100',
            'dob'     => 'nullable|date',
            'avatar'  => 'nullable|image|max:2048',
        ]);
        $data = $request->only(['name','phone','address','city','dob']);
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars','public');
            $data['avatar'] = $path;
        }
        $user->update($data);
        return back()->with('success','Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);
        $user = Auth::user();
        if (!Hash::check($request->current_password,$user->password)) {
            return back()->with('error','Current password is incorrect.');
        }
        $user->update(['password'=>Hash::make($request->password)]);
        return back()->with('success','Password updated successfully!');
    }

    // Feedback
    public function feedbackForm()
    {
        $user = Auth::user();
        $orders = Order::with('items.product')->latest()->get();
        $products = Product::all();
        $publicFeedbacks = Feedback::with('user')->where('is_public',true)->latest()->take(10)->get();
        return view('buyer.feedback', compact('user','orders','products','publicFeedbacks'));
    }

    public function submitFeedback(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'rating'     => 'required|integer|min:1|max:5',
            'message'    => 'required|string|min:10',
            'type'       => 'required|in:general,product,order',
            'subject'    => 'nullable|string|max:255',
            'product_id' => 'nullable|exists:products,id',
            'order_id'   => 'nullable|exists:orders,id',
        ]);
        Feedback::create([
            'user_id'    => Auth::id(),
            'name'       => $request->name,
            'email'      => Auth::user()->email ?? null,
            'rating'     => $request->rating,
            'message'    => $request->message,
            'type'       => $request->type,
            'subject'    => $request->subject,
            'product_id' => $request->product_id,
            'order_id'   => $request->order_id,
            'is_public'  => true,
        ]);
        return back()->with('success','Thank you for your feedback!');
    }
}
