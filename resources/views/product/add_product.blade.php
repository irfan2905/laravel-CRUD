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
//--------------------------------------------------------------------------

</script>
@endsection
@section('content')
<section class="content-header">

</section>

    <section class="content">
      <h2 class="text-center">Add New Product</h2>
      <div class="row">
        <div class="col-lg-4">
          {{ Form::open(array('url' => 'product', 'name' => 'add_product', 'onsubmit' => 'return redirect()', 'enctype' => 'multipart/form-data')) }}
            <div class="form-group">
              <label for="product_name">Name</label>
              <input type="text" data-validation-length="min4" name="name" class="form-control" placeholder="Enter Produk">
              @if ($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            
            <div class="form-group">
              <label for="product_detail">Detail</label>
              <input type="text" data-validation-length="min4" name="name" class="form-control" placeholder="Enter Produk Detail">
              @if ($errors->has('detail'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('detail') }}</strong>
                    </span>
                @endif
            </div>

            <!-- input file -->
            <div class="form-group">
                <label for="photo1">Photo</label>
                <input type="file" name="photo" id="imgInp" multiple>
                @if ($errors->has('photo1'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('photo1') }}</strong>
                    </span>
                @endif
            </div>

            <!-- show file -->
            <div class="form-group">
              <div class="thumbnail">
                <div class="gallery"></div>
              </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>

          </form>
      </div>
  </section>
@endsection
