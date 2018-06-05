@extends('layout.default')
@section('jquery')

<script type="text/javascript">
  function just_num(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
    return true;
    }
    //--------------------------------------------------------------------------
    //Multi Input File
    $(function() {
        // Multiple images preview in browser
        var imagesPreview = function(input, placeToInsertImagePreview) {

            if (input.files) {
                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        $($.parseHTML('<img width="100px">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                    }

                    reader.readAsDataURL(input.files[i]);
                }
            }

        };

        $('#imgInp').on('change', function() {
            imagesPreview(this, 'div.gallery');
        });
    });
</script>
@endsection
@section('content')

    <div class="container">
      <h2 class="">Edit Produk</h2>
      <div class="row">
        <form class="" action="{{action('ProductController@update')}}" method="post" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="_method" value="PUT"/>
          <input type="hidden" name="id" value="{{ $products->id }}">
          <div class="col-lg-6">

              <div class="form-group">
                <label for="product_name">Name</label>
                <input type="text" data-validation-length="min4" name="name" class="form-control" placeholder="Enter Product" value="{{ $products->name }}">
                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
              </div>

              <div class="form-group">
                <label for="product_detail">Detail</label>
                <input type="text" data-validation-length="min4" name="detail" class="form-control" placeholder="Enter Detail" value="{{ $products->detail }}">
                @if ($errors->has('detail'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('detail') }}</strong>
                    </span>
                @endif
              </div>

              <div class="form-group">
                  <label for="photo1">Photo</label>
                  <input type="file" name="photo1" id="imgInp" title="{{ $products->photo1 }}" enctype="multipart/form-data">
                  @if ($errors->has('photo1'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('photo1') }}</strong>
                    </span>
                @endif
              </div>

              <div class="form-group">
                <div class="thumbnail">
                  <div class="gallery"></div>
                </div>
              </div>

              <button type="submit" class="btn btn-primary">Update</button>

            </div>
          </div>
        </form>
      </div>
    </div>

@endsection
