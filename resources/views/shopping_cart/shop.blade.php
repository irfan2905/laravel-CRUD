@extends('layout.default')
@section('content')
    @if(Session::has('cart'))
    <div class="row">
        <div class="col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
            <ul class="list-group">
                @foreach($products as $product)
                <li class="list-group-item">
                    <span class="badge">{{ $product['qty'] }}</span>
                    <strong>{{ $product['item']['name'] }}</strong>
                    <span class="label label-success">{{ $product['price'] }}</span>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" 
                                data-toggle="dropdown">Action <span class="caret"></span></button>
                    </div>
                    <ul class="dropdown-menu">
                        <li><a href="#">Reduce by 1</a></li>
                        <li><a href="#">Reduce all</a></li>
                    </ul>
                </li>
                @endforeach
            </ul> 
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
            <strong>Total: $ {{ $totalPrice }}</strong>  
        </div>
    </div>
    <hr>
    <div class="row">
        {{ csrf_field() }}
        <div class="col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
            <a method="POST" id="payment-form" role="form" href="{!! URL::route('paywith') !!}" type="button" class="btn btn-success">Checkout</a>  
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
            <h2>No Items in Cart!</h2>
        </div>
    </div>
    @endif
@endsection