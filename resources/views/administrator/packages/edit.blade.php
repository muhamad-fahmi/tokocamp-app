@extends('layouts.administrator.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/izitoast/dist/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
@endpush
@section('contents')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Edit Category</h1>
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
                        <form action="/admin/system/packages/{{$package->id}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row-upload">
                                    <label>Upload Images Package</label><br>
                                    <img id="output" src="https://upload.wikimedia.org/wikipedia/commons/6/6b/Picture_icon_BLACK.svg" width="100" height="100">
                                    <br>
                                    <input name="images[]" type="file" id="files" multiple accept="image/*" class="btn btn-success mb-3 mt-3" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="hidden" name="category" value="{{ $package->category->id }}">
                                    <x-input type="text" field="category name" value="{{$package->category->name}}" read="readonly"/>
                                </div>
                                <div class="col-md-4">
                                    <x-input type="number" field="price" value="{{$package->price}}"/>
                                </div>
                                <div class="col-md-4">
                                    <x-input type="number" field="minimal" value="{{$package->minimal}}"/>
                                </div>
                            </div>
                            <x-input type="text" field="name" value="{{$package->name}}"/>
                            <x-textarea type="text" field="include" rows="5" value="{{$package->include}}"/>
                            <x-textarea type="text" field="description" value="{{$package->description}}"/>
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

