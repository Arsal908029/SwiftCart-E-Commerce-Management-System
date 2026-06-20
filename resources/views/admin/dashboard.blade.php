@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Admin Dashboard</h2>

    <div class="row g-4">
        <!-- Products -->
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-primary">
                <div class="card-body text-center">
                    <i class="bi bi-box-seam fs-1 text-primary"></i>
                    <h5 class="mt-2">Products</h5>
                    <h4>{{ $productCount }}</h4>
                    <p class="text-muted">Total products</p>
                    <a href="/admin/products" class="btn btn-outline-primary btn-sm">Manage Products</a>
                </div>
            </div>
        </div>

        <!-- Orders -->
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-success">
                <div class="card-body text-center">
                    <i class="bi bi-cart-check fs-1 text-success"></i>
                    <h5 class="mt-2">Orders</h5>
                    <h4>{{ $orderCount }}</h4>
                    <p class="text-muted">Total orders</p>
                    <a href="/admin/orders" class="btn btn-outline-success btn-sm">View Orders</a>
                </div>
            </div>
        </div>

        <!-- Sales -->
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-warning">
                <div class="card-body text-center">
                    <i class="bi bi-bar-chart-line fs-1 text-warning"></i>
                    <h5 class="mt-2">Revenue</h5>
                    <h4>PKR {{ number_format($totalRevenue, 2) }}</h4>
                    <p class="text-muted">Total sales revenue</p>
                    <a href="/admin/sales" class="btn btn-outline-warning btn-sm">Sales Overview</a>
                </div>
            </div>
        </div>

        <!-- Payments -->
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-danger">
                <div class="card-body text-center">
                    <i class="bi bi-credit-card-2-front fs-1 text-danger"></i>
                    <h5 class="mt-2">Payments</h5>
                    <h4>{{ $paymentCount }}</h4>
                    <p class="text-muted">Completed payments</p>
                    <a href="/admin/payments" class="btn btn-outline-danger btn-sm">View Payments</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Extra Stats Row -->
    <div class="row g-4 mt-2">
        <div class="col-md-6">
            <div class="card shadow-sm" style="border:1px solid rgba(251,191,36,.3);">
                <div class="card-body text-center">
                    <i class="fas fa-clock fs-1" style="color:#fbbf24;"></i>
                    <h5 class="mt-2">Pending Orders</h5>
                    <h4>{{ $pendingOrders }}</h4>
                    <p class="text-muted">Awaiting action</p>
                    <a href="/admin/orders" class="btn btn-outline-warning btn-sm">Manage Orders</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm" style="border:1px solid rgba(139,92,246,.3);">
                <div class="card-body text-center">
                    <i class="fas fa-star fs-1" style="color:#8b5cf6;"></i>
                    <h5 class="mt-2">Customer Feedback</h5>
                    <h4>{{ $recentFeedbacks->count() }}</h4>
                    <p class="text-muted">Recent reviews</p>
                    <a href="{{ route('admin.feedbacks') }}" class="btn btn-sm" style="background:rgba(139,92,246,.1);color:#8b5cf6;border:1px solid rgba(139,92,246,.3);">View All</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Orders Table -->
    <div class="mt-5">
        <h4>Recent Orders</h4>
        @if($latestOrders->isEmpty())
            <p class="text-muted">No recent orders.</p>
        @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Total</th>
                        <th>Ordered Items</th>
                        <th>Status</th>
                        <th>Placed On</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestOrders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer_name ?? 'N/A' }}</td>
                        <td>{{ $order->address }}</td>
                        <td>PKR {{ number_format($order->total_price, 2) }}</td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                @foreach($order->items as $item)
                                    <li>{{ $item->product->name }} (x{{ $item->quantity }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td><span style="font-size:.75rem;font-weight:600;padding:.2rem .6rem;border-radius:6px;background:rgba(0,229,255,.1);color:#00e5ff;">{{ ucfirst($order->status ?? 'pending') }}</span></td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
