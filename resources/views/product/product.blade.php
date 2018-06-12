@extends('layout.default')
@section('jquery')

<script type="text/javascript">
$(document).ready(function() {
  $(".delete").click(function(event){
    var id = $(this).attr('product_id');
    alert(id);
    event.preventDefault();
    $( "#dialog" ).dialog({
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
          "Delete all items": function() {
            $("#product-"+id).submit();


          },
          Cancel: function() {
            $( this ).dialog( "close" );
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

  <div class="row">
    <div class="col-xs-12 text-right">
      <a href="{{ url('product/add_product') }}" class="btn btn-primary">
        <span class="glyphicon glyphicon-plus">ADD</span>
      </a>
    </div>
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Table of Product</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center">Id</th>
                <th class="text-center">Name</th>
                <th class="text-center">Detail</th>
                <th class="text-center">Photo</th>
                <th class="text-center">Action</th>
            </thead>
          </tr>
            <tbody>
              @foreach($products as $product)

              <tr>
                <td class="text-center">{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->detail }}</td>
                <td><img src="{{ $product->photo1 }}" alt=" tidak tampil" weidth="200px" height="150px"></td>

                <td class="text-center">
                    <!--Button Edit-->
                    

                    <!--Button Remove-->
                    
                    <form class="" id="products-{{$product->id}}" action="{{action('ProductController@destroy')}}" method="post">
                        <a href="{{ action('ProductController@edit', ['id' => $product->id]) }}" name="button" class="btn btn-info">
                      <span class="glyphicon glyphicon-pencil">Edit</span>
                    </a>
                    <button type="submit" class="glyphicon glyphicon-remove btn btn-danger delete" product_id="{{$product->id}}" data-toggle="confirmation" data-placement="bottom">Delete</button>
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$product->id}}">
                    <input type="hidden" name="_method" value="delete">
                  </form>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {{ $products->links() }}
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <div id="dialog" title="Empty the recycle bin?" style="display: none;">
      <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>These items will be permanently deleted and cannot be recovered. Are you sure?</p>
    </div>
  </section>
@endsection
