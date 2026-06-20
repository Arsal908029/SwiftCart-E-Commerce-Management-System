@extends('layouts.app')

@section('content')
<h2>Product List</h2>
<a href="/admin/products/create" class="btn btn-primary mb-3">Add New Product</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th><th>Description</th><th>Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $p)
        <tr>
            <td>{{ $p->name }}</td>
            <td>{{ $p->description }}</td>
            <td>PKR {{ number_format($p->price, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
