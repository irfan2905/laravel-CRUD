@extends('layout.default')
@section('jquery')

<script type="text/javascript">
    $(document).ready(function () {
        $(".delete").click(function (event) {
            var id = $(this).attr('product_id');
            alert(id);
            event.preventDefault();
            $("#dialog").dialog({
                resizable: false,
                height: "auto",
                width: 400,
                modal: true,
                buttons: {
                    "Delete all items": function () {
                        $("#product-" + id).submit();


                    },
                    Cancel: function () {
                        $(this).dialog("close");
                    }
                }
            });
            //$("form").submit(function(e){
            //e.preventDefault();

        });
    });
    //});

</script>
@endsection
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Data Product
        <small>Product List Stock</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data Product</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                        @foreach($products as $product)
                        @if($loop->first)
                        {{$loop->count}}
                        @endif
                        @endforeach
                    </h3>
                    <p>Count Product</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        @foreach($products as $product)
                        @if($loop->first)
                        {{$product->sum('id')}}
                        @endif
                        @endforeach
                    </h3>
                    <p>Stock Total</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xs-12 text-right">
        <a href="{{ url('product/create') }}" class="btn btn-primary">
            <span class="glyphicon glyphicon-plus">ADD</span>
        </a>
    </div>
    <div class="row">
        @foreach($products as $product)
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="{{ $product->photo1 }}" class="thumbnail-img" alt=" Cannot Show Image" align="center" weidth="242px" height="200px">
                <h3>{{ $product->name }}</h3>
                <div class=""> $ {{ $product->price }}</div>
                <div class="clearfix">
                    <a href="{{ action('ProductController@getAddToCart', ['id' => $product->id]) }}" role="button" class="btn btn-success pull-right">
                        <span class="glyphicon glyphicon-shopping-cart"> Add To Cart</span>
                    </a>
                    {{csrf_field()}}
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $products->links() }}
    <div id="dialog" title="Empty the recycle bin?" style="display: none;">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>These items will be permanently deleted and cannot be recovered. Are you sure?</p>
    </div>
</section>
@endsection
