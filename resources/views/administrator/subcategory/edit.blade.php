@extends('layouts.administrator.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/izitoast/dist/css/iziToast.min.css') }}">
@endpush
@section('contents')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Edit Sub Category</h1>
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
                        <form action="/admin/system/subcategory/{{$subcategory->id}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="category" value="{{ $subcategory->category->id }}">
                            <x-input type="text" field="package category" read="1" value="{{$subcategory->name}}"/>
                            <x-input type="text" field="name" value="{{$subcategory->name}}"/>
                            <x-textarea type="text" field="description" rows="5" value="{{$subcategory->description}}"/>
                            <x-input type="file" field="image" fileform="form-control-file"/>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">

                                  @if ($subcategory->status == "1")
                                    <input type="checkbox" name="status" value="0" checked class="custom-control-input" tabindex="3" id="status-me">
                                    <label class="custom-control-label" for="status-me">Status On</label>
                                  @else
                                    <input type="checkbox" name="status" value="1" class="custom-control-input" tabindex="3" id="status-me">
                                    <label class="custom-control-label" for="status-me">Status Off</label>
                                  @endif
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

