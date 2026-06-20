@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Sales Overview</h2>

@if(count($orders) === 0)
    <div class="alert alert-info">No sales data available.</div>
@else
    <div class="mb-3">
        <h5 class="text-success fw-bold">Total Sales: PKR {{ number_format($totalSales, 2) }}</h5>
        <p class="text-muted">Total Orders: {{ count($orders) }}</p>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="text-center">
                <tr>
                    <th>Order ID</th>
                    <th>Buyer Name</th>
                    <th>Total Price (PKR)</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="text-center">
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->buyer_name }}</td>
                        <td>PKR {{ number_format($order->total_price, 2) }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
</div>
@endsection
