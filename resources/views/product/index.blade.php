@extends('layout.default')


@section('content')
<section class="content-header">
    <h1>
        Products
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i> Home</a></li>
        <li class="active">Products</li>
    </ol>
</section>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

<div class="pull-right">
    <a class="btn btn-success glyphicon glyphicon-plus" href="{{ route('product.create') }}"> Create New Product</a>
</div>

<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Details</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($products as $product)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->detail }}</td>
        <td>
            <form action="{{ route('product.destroy',$product->id) }}" method="POST">


                <a class="btn btn-info" href="{{ route('product.show',$product->id) }}">Show</a>
                <a class="btn btn-primary" href="{{ route('product.edit',$product->id) }}">Edit</a>


                @csrf
                @method('DELETE')


                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>


{{ $products->links() }}


@endsection