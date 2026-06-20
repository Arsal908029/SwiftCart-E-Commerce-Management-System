@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Payment Records</h2>

        @if($payments->isEmpty())
            <div class="alert alert-info">No payments found.</div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order ID</th>
                        <th>Amount (PKR)</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->order_id }}</td>
                            <td>PKR {{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
