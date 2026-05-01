@extends('layouts.app')

@section('content')

<h2>Place Order</h2>

<form method="POST" action="{{ route('orders.placeorder') }}">
    @csrf

    <table class="table table-condensed table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
        </thead>

        <tbody>
            @php
                $ttlCost = 0;
                $ttlQty = 0;
            @endphp

            @foreach($lineitems as $lineitem)
                @php
                    $product = $lineitem['product'];
                    $qty = $lineitem['qty'];
                    $ttlQty = $ttlQty + $qty;
                    $ttlCost = $ttlCost + ($product->price * $qty);
                @endphp

                <tr>
                    <td>
                        <input size="3"
                               style="border:none"
                               type="text"
                               name="productid[]"
                               readonly
                               value="{{ $product->id }}">
                    </td>

                    <td>{{ $product->name }}</td>

                    <td>{{ $product->price }}</td>

                    <td>
                        <input size="3"
                               style="border:none"
                               type="text"
                               name="quantity[]"
                               readonly
                               value="{{ $qty }}">
                    </td>
                </tr>
            @endforeach

            <tr>
                <td colspan="3"><strong>Total Quantity</strong></td>
                <td>{{ $ttlQty }}</td>
            </tr>

            <tr>
                <td colspan="3"><strong>Total Cost</strong></td>
                <td>{{ $ttlCost }}</td>
            </tr>
        </tbody>
    </table>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection