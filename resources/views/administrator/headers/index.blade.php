@extends('layouts.administrator.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/izitoast/dist/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">

@endpush
@section('contents')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>headers</h1>
      </div>

      <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                          <thead>
                            <tr>
                              <th class="text-center">
                                #
                              </th>
                              <th>Title</th>
                              <th>Url</th>
                              <th>Image</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($headers as $header)
                              <tr>
                                <td>1</td>
                                <td>{{ucwords($header->title)}}</td>
                                <td>{{$header->url}}</td>
                                <td>
                                  <img alt="image" src="{{asset('images/headers/'.$header->image)}}" width="35" data-toggle="tooltip" title="Wildan Ahdian">
                                </td>
                                <td>
                                <div class="btn-group">
                                  <a href="/admin/system/headers/{{$header->id}}/edit" class="btn btn-primary btn-sm">Edit</a>
                                  <button class="btn btn-danger btn-sm" id="swal-6" data-id="{{$header->id}}">Delete</button>
                                </div>

                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
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
    if (session('success')){
    ?>
        <script>
            iziToast.success({
                title: 'Success',
                message: '{{ session('success') }}',
                position: 'bottomRight'
            });
        </script>
   <?php
    }
?>
<script src="{{ asset('vendor/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
<script>
  $("#table-1").dataTable({
    "columnDefs": [
      { "sortable": false, "targets": [2,3] }
    ]
  });

  $("#swal-6").click(function() {
  swal({
      title: 'Are you sure?',
      text: 'Once deleted, you will not be able to recover this category data !',
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url: '/admin/system/headers/'+id,
            type: 'delete',
            data: {
              "id": id,
              "_token": token,
            },
            success: function(response){
              window.location.reload(true)
              swal('Poof! Category data has been deleted!', {
                icon: 'success',
              });
            }
        });

      } else {
        swal('Category data is safe!');
      }
    });
  });
</script>
@endpush
