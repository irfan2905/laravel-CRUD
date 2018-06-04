@extends('layout.default')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Passport
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i> Home</a></li>
        <li class="active">Passport</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    
    @if (\Session::has('success'))
    <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
    </div><br />
    @endif
    
      <div class="col-xs-12 text-right">
        <a href="{{ url('/passport/create') }}" class="btn btn-primary">
          <span class="glyphicon glyphicon-plus">ADD</span>
        </a>
      </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Passport Office</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>

            @foreach($passports as $passport)
            @php
            $date=date('Y-m-d', $passport['date']);
            @endphp
            <tr>
                <td>{{$passport['id']}}</td>
                <td>{{$passport['name']}}</td>
                <td>{{$date}}</td>
                <td>{{$passport['email']}}</td>
                <td>{{$passport['phone_number']}}</td>
                <td>{{$passport['office']}}</td>

                <td>
                    <form id="passport-{{$passport->id}}" action="{{action('PassportController@destroy')}}" method="post">
                        <a href="{{ action('PassportController@edit', ['id' => $passport->id]) }}" class="btn btn-warning">Edit</a>
                        <button type="submit" class="btn btn-danger delete" supplier_id="{{$passport->id}}">Delete</button>
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$passport->id}}">
                        <input type="hidden" name="_method" value="delete">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
<!-- /.content -->