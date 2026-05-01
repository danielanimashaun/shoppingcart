@extends('layouts.app')

@section('content')

<div style="padding-top:1%">
    <nav class="navbar navbar-right navbar-expand-sm navbar-dark bg-dark">
        <ul class="navbar-nav ms-auto">

            <li class="nav-item">
                <button id="checkOut"
                        onclick="window.location.href=''"
                        type="button"
                        style="margin-right:5px;"
                        class="btn btn-primary navbar-btn center-block">
                    Check Out
                </button>
            </li>

            <li class="nav-item">
                <button id="emptycart"
                        type="button"
                        style="margin-right:5px;"
                        class="btn btn-primary navbar-btn center-block">
                    Empty Cart
                </button>
            </li>

            <li class="nav-item">
                <div class="navbar-text"
                     id="shoppingcart"
                     style="font-size:14pt;margin-left:5px;margin-right:0px;color:white;">
                    0
                </div>
            </li>

            <li class="nav-item">
                <div class="navbar-text"
                     style="font-size:14pt;margin-left:5px;color:white;">
                    Item(s)
                </div>
            </li>

        </ul>
    </nav>
</div>

<div class="d-flex flex-wrap align-content-start bg-light">

    @foreach($products as $product)
        <div class="p-2 border col-4">
            <div class="card text-center">

                <div class="card-header">
                    <h5>{{ $product->name }}</h5>
                </div>

                <div class="card-body">
                    <div style="width:65%; height:200px; background-color:#dddddd; margin:auto; display:flex; align-items:center; justify-content:center;">
                        Product Image
                    </div>
                </div>

                <div class="card-footer">
                    <button type="button"
                            class="btn btn-success mx-auto d-block"
                            onclick="addToCart({{ $product->id }})">
                        Add To Cart
                    </button>
                </div>

            </div>
        </div>
    @endforeach

</div>

<script>
function addToCart(id) {
    fetch('/add-to-cart/' + id)
        .then(response => response.json())
        .then(data => {
            document.getElementById('shoppingcart').innerText = data.count;
        });
}
</script>

@endsection