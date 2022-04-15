@extends('layouts.administrator.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/izitoast/dist/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">

@endpush
<?php
    function rupiah($angka){
        $hasil_rupiah = "Rp " . number_format((int)$angka,0,',','.');
        return $hasil_rupiah;
    }
?>
@section('contents')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Packages</h1>
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
                              <th>Name</th>
                              <th>Category</th>
                              <th>Price</th>
                              <th>Min</th>
                              <th>Include</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($packages as $package)
                              <tr>
                                <td>1</td>
                                <td>{{ ucwords($package->category->name) }}</td>
                                <td>{{ ucwords($package->name) }}</td>
                                <td>{{ rupiah($package->price) }}</td>
                                <td>{{ $package->minimal }}</td>
                                <td>
                                  {{ substr($package->include, 0, 100) }}...
                                </td>
                                <td>
                                <div class="btn-group">
                                  <a href="/admin/system/packages/{{$package->id}}/edit" class="btn btn-primary btn-sm">Edit</a>
                                  <button class="btn btn-danger btn-sm" id="swal-6" data-id="{{$package->id}}">Delete</button>
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
      text: 'Once deleted, you will not be able to recover this package data !',
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url: '/admin/system/packages/'+id,
            type: 'delete',
            data: {
              "id": id,
              "_token": token,
            },
            success: function(response){
              window.location.reload(true);
              swal('Poof! Package data has been deleted!', {
                icon: 'success',
              });
            }
        });

      } else {
        swal('Package data is safe!');
      }
    });
  });
</script>
@endpush
