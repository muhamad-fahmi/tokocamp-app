@extends('layouts.administrator.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/izitoast/dist/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/summernote/dist/summernote-bs4.css') }}">
@endpush
@section('contents')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Create Article</h1>
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
                        <form action="/admin/system/blogs" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select class="form-control select2" name="category">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ ucwords($category->title) }}</option>
                                    @endforeach
                                </select>
                                @if ($categories->count() == 0)
                                    <a href="/admin/system/blogcategory/create" class="btn btn-outline-primary btn-sm mt-3">Create New Category</a>
                                @endif
                            </div>
                            <x-input type="text" field="title"/>
                            <div class="form-group">
                                <label class="">Article</label>
                                <textarea class="summernote" name="article"></textarea>
                            </div>
                            <x-input type="file" field="thumbnail" fileform="form-control-file"/>
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
<script src="{{ asset('vendor/summernote/dist/summernote-bs4.j') }}s"></script>

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

