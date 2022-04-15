@extends('layouts.administrator.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/izitoast/dist/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
@endpush
@section('contents')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Create Package</h1>
      </div>

      <div class="section-body">
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-danger ">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <form action="/admin/system/packages" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row-upload">
                                <label>Upload Images Package</label><br>
                                <img id="output" src="https://upload.wikimedia.org/wikipedia/commons/6/6b/Picture_icon_BLACK.svg" width="100" height="100">
                                <br>
                                <input name="images[]" type="file" id="files" multiple accept="image/*" class="btn btn-success mb-3 mt-3" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">

                            </div>
                            <div class="form-group">
                                <label for="select">Select Category</label>
                                <select name="category" id="category" class="form-control select2">
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{ucwords($category->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-input type="text" field="name"/>
                            <div class="row">
                                <div class="col-md-6">
                                    <x-input type="number" field="price"/>
                                </div>
                                <div class="col-md-6">
                                    <x-input type="number" field="minimal"/>
                                </div>
                            </div>
                            <x-textarea type="text" field="include"/>
                            <x-textarea type="text" field="description"/>
                            <div class="row">
                                <div class="form-group col-6 country">
                                  <label>Country</label>
                                  <select id="country-dd" class="select2 form-control" name="country">
                                    <option value="" selected>Select Your Country</option>
                                    @foreach ($countries as $country)
                                      <option value="{{ $country->iso2 }}">{{ $country->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="form-group col-6 state">
                                  <label>State</label>
                                  <select id="state-dd" class="form-control select2" name="state">
                                  </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 city">
                                  <label>City</label>
                                  <select id="city-dd" class="form-control select2" name="city">
                                  </select>
                                </div>
                                <div class="form-group col-6">
                                  <label>Area</label>
                                  <input type="text" class="form-control" placeholder="Area" required name="area">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@push('scripts')
<script src="{{ asset('vendor/izitoast/dist/js/iziToast.min.js') }}"></script>
<script src="{{ asset('vendor/select2/dist/js/select2.full.min.js') }}"></script>
<?php
    if (session('error')){
    ?>
        <script>
            iziToast.error({
                title: 'Invalid',
                message: '{{ session('error') }}',
                position: 'bottomRight'
            });
        </script>
   <?php
    }
?>
<script>
    $(document).ready(()=> {
        var ciso = "";
        var siso = "";
        $('#country-dd').on('change', function () {
          ciso = this.value;
          $("#state-dd").html('');
          $.ajax({
            url: "/api/get-states",
            type: "POST",
            data: {
              ciso: ciso,
              _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (result) {
              $('#state-dd').html('<option value="">Select State</option>');
              $.each(result, function (key, value) {
                $('#state-dd').append('<option value="'+ value.iso2 +'">'+ value.name +'</option>');
              });
              $('#city-dd').html('<option value="">Select City</option>');
            }
        });
    });
    $('#state-dd').on('change', function () {
        siso = this.value;
        $("#city-dd").html('');
        $.ajax({
            url: "/api/get-cities",
            type: "POST",
            data: {
            ciso: ciso,
            siso: siso,
            _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (response) {
            $('#city-dd').html('<option value="">Select City</option>');
            $.each(response, function (key, value) {
                $("#city-dd").append('<option value="' + value.id + '">' + value.name + '</option>');
            });
            }
        });
    });
});
</script>
@endpush

