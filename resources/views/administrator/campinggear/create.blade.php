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
                        <form action="/admin/system/campinggear" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row-upload">
                                <label>Upload Images Package</label><br>
                                <img id="output" src="https://upload.wikimedia.org/wikipedia/commons/6/6b/Picture_icon_BLACK.svg" width="100" height="100">
                                <br>
                                <input name="image" type="file" id="files" multiple accept="image/*" class="btn btn-success mb-3 mt-3" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">

                            </div>

                            <x-input type="text" field="name"/>
                            <div class="form-group">
                                <label for="select">Select Category</label>
                                <select name="category" id="category" class="form-control select2">
                                    @foreach ($campinggearcats as $category)
                                        <option value="{{$category->id}}">{{ucwords($category->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <x-input type="number" field="price"/>
                                </div>
                                <div class="col-md-6">
                                    <x-input type="number" field="stok"/>
                                </div>
                            </div>
                            <x-textarea type="text" field="description"/>
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
@endpush

