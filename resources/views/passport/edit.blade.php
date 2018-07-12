@extends('layout.default')
@section('content')
    <section class="content-header">
      <h1 class="text-center">Edit Passport</h1>
    </section>

    <section class="content">
      <h2>Edit A Form</h2><br  />
        <form method="post" action="{{action('PassportController@update')}}">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="PUT"/>
        <input type="hidden" name="id" value="{{ $passport->id }}">
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" value="{{$passport->name}}">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4"></div>
            <div class="form-group col-md-4">
              <label for="email">Email</label>
              <input type="text" class="form-control" name="email" value="{{$passport->email}}">
            </div>
          </div>
        <div class="row">
          <div class="col-md-4"></div>
            <div class="form-group col-md-4">
              <label for="number">Phone Number:</label>
              <input type="text" class="form-control" name="number" value="{{$passport->phone_number}}">
            </div>
          </div>
        <div class="row">
          <div class="col-md-4"></div>
            <div class="form-group col-md-4" style="margin-left:38px">
                <lable>Passport Office</lable>
                <select name="office">
                  <option value="Mumbai"  @if($passport->office=="Mumbai") selected @endif>Mumbai</option>
                  <option value="Chennai"  @if($passport->office=="Chennai") selected @endif>Chennai</option>
                  <option value="Delhi" @if($passport->office=="Delhi") selected @endif>Delhi</option>  
                  <option value="Bangalore" @if($passport->office=="Bangalore") selected @endif>Bangalore</option>
                </select>
            </div>
        </div>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4" style="margin-top:60px">
            <button type="submit" class="btn btn-success" style="margin-left:38px">Update</button>
          </div>
        </div>
      </form>
    </section>
@endsection
