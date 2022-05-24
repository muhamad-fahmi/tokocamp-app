@extends('layouts.app')
<?php
function rupiah($angka){
    $hasil_rupiah = "Rp " . number_format((int)$angka,0,',','.');
    return $hasil_rupiah;
}
?>
@push('styles')
    <link rel="stylesheet" href="{{ asset('userpage/css/pagestyle.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/izitoast/dist/css/iziToast.min.css') }}">
@endpush
@section('contents')
    <!-- CONTENT -->

    <section class="main py-5 product">
        <nav class="navbar navbar-light bg-light fixed-bottom shadow-sm check-mobile">
            <div class="container-fluid">
                <div class="d-flex justify-content-center w-100">
                    <a href="" class="btn btn-outline-success me-3">
                        <i class="fas fa-calendar-check"></i>
                    </a>
                    <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-success w-100" >
                        <i class="fas fa-cart-plus"></i> Masukan Keranjang
                    </button>
                    <!-- Modal -->

                </div>

            </div>
        </nav>
        <div class="modal fade px-3" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                <p class="modal-title" id="exampleModalLabel"><strong>Atur Jumlah Pemesanan</strong></p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex mb-3">
                        <button id="minbtnmbl" class="btn btn-outline-success me-2">-</button>
                        <input type="text" class="form-control me-2 text-center" id="qtyinputmbl" value="1" readonly>
                        <button id="addbtnmbl" class="btn btn-success">+</button>
                    </div>
                    <small class="text-muted">Min pemesanan 12</small>
                    <div class="d-flex justify-content-between mt-3">
                        <small>Subtotal</small>
                        <h5 id="subtotal"><strong>Rp 12.000</strong></h5>
                    </div>
                    <form action="/cart" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $package->id }}">
                        <input type="hidden" name="qty" id="qty" value="1">
                        <input type="hidden" name="type" value="1">
                        <button type="submit" class="btn btn-success w-100 mt-3">Masukan Keranjang</button>
                    </form>
                    <div class="d-flex justify-content-evenly mt-3 text-center">
                        <a href="" class="text-decoration-none text-secondary">
                            <small><i class="fas fa-calendar-check me-2"></i> Kalender</small>
                        </a>
                        <a href="" class="text-decoration-none text-secondary">
                            <small><i class="fas fa-share-alt me-2"></i> Bagikan</small>
                        </a>
                    </div>
                </div>

                </div>
            </div>
        </div>
        <div class="container mt-5"><br>
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='18' height='18'%3E%3Cpath fill='none' d='M0 0h24v24H0z'/%3E%3Cpath d='M7.752 5.439l10.508 6.13a.5.5 0 0 1 0 .863l-10.508 6.13A.5.5 0 0 1 7 18.128V5.871a.5.5 0 0 1 .752-.432z'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb" class="broad mb-5">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page" class="text-decoration-none">Library</li>
                </ol>
            </nav>
            <div class="row">
                <div class="px-0 col-12 col-sm-12 col-lg-4">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                          @foreach (json_decode($package->images) as $images)
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $loop->index }}">
                            </button>
                          @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach (json_decode($package->images) as $image)
                                <div class="carousel-item {{ $loop->first ? 'active' : ''}}">
                                    <img src="{{ asset('images/packages/'.$image) }}" class="d-block w-100" alt="{{ $package->name }}">
                                </div>
                            @endforeach

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Next</span>
                        </button>
                      </div>
                </div>
                <div class="col-12 col-sm-12 col-lg-5 px-4">
                    <h4 class="title-prod mb-2">
                        {{ ucwords($package->name) }}
                    </h4>
                    <p class="rate mt-3 text-muted">
                        <i class="fa-solid fa-star text-warning me-1"></i> 38 Reviews
                    </p>
                    <h3 class="price mb-4" data-price="2555">
                        <strong id="price">
                            {{ rupiah($package->price) }}
                        </strong>
                    </h3>

                    <div class="description pt-3 border-1 border-top">
                        <p>{{ ucfirst($package->description) }}</p>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-lg-3">
                    <div class="card check-desk">
                        <div class="card-body">
                                <p><strong>Atur Jumlah Pemesanan</strong></p>
                                <div class="d-flex mb-3">
                                    <button id="minbtndesk" class="btn btn-outline-success me-2">-</button>
                                    <input type="text" class="form-control me-2 text-center" id="qtyinputdesk"  readonly>
                                    <button id="addbtndesk" class="btn btn-success">+</button>
                                </div>
                                <small class="text-muted">Min pemesanan 12</small>
                                <div class="d-flex justify-content-between mt-3">
                                    <small>Subtotal</small>
                                    <h5 id="subtotaldesk"><strong>Rp 12.000</strong></h5>
                                </div>
                                <form action="/cart" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $package->id }}">
                                    <input type="hidden" name="qty" id="qtydesk" value="1">
                                    {{ var_dump($package) }}
                                    <input type="hidden" name="type" value="1">
                                    <button type="submit" class="btn btn-success w-100 mt-3">Masukan Keranjang</button>
                                </form>
                                <div class="d-flex justify-content-evenly mt-3 text-center">
                                    <a href="" class="text-decoration-none text-secondary">
                                        <small><i class="fas fa-calendar-check me-2"></i> Kalender</small>
                                    </a>
                                    <a href="" class="text-decoration-none text-secondary">
                                        <small><i class="fas fa-share-alt me-2"></i> Bagikan</small>
                                    </a>
                                </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="other-prod border-1 border-top mt-5">
                <h4 class="mt-3 mb-4">
                    <strong>
                        Lainnya dikategori ini
                    </strong>
                </h4>
                <div class="row">
                   @foreach ($packages as $package)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="card border border-0 shadow">
                                <img src="{{ asset('images/packages/'.json_decode($package->images)[0]) }}" class="card-img-top" alt="{{ $package->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ ucwords($package->name) }}</h5>
                                    <p class="card-text price"><strong>{{ rupiah($package->price) }}</strong></p>
                                    <p class="card-text location"><i class="fa-solid fa-location-dot me-1 text-success"></i> {{ ucwords($package->subcategory->area . " (" .str_replace('Kabupaten', 'Kab', $package->subcategory->city).")") }}</p>
                                    <p class="card-text review"><i class="fa-solid fa-star text-warning me-1"></i> 5 Reviews</p>
                                </div>
                            </div>
                        </div>
                   @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- END CONTENT -->
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('vendor/izitoast/dist/js/iziToast.min.js') }}"></script>
    <script>
        function rupiah (num) {
            return "Rp " + num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
        }

        $(document).ready(()=>{
            $('#subtotal').text($('#price').text())
            $('#subtotaldesk').text($('#price').text())
            if($('#qtyinputmbl').val() <= 1){
                $('#minbtnmbl').addClass('disabled')
            }
            if($('#qtyinputdesk').val() <= 1){
                $('#qtyinputdesk').val(1)
                $('#minbtndesk').addClass('disabled')
            }

            $('#addbtnmbl').click(()=>{
                $('#qtyinputmbl').val(parseInt($('#qtyinputmbl').val()) + 1);
                $('#subtotal').text(rupiah($('#price').text().replace(/[^0-9]/g,'') * $('#qtyinputmbl').val()))
                $('#qty').val(parseInt($('#qtyinputmbl').val()))
                if($('#qtyinputmbl').val() > 1){
                    $('#minbtnmbl').removeClass('disabled')
                }
            });
            $('#minbtnmbl').click(()=>{
                $('#qtyinputmbl').val(parseInt($('#qtyinputmbl').val()) - 1);
                $('#subtotal').text(rupiah($('#price').text().replace(/[^0-9]/g,'') * $('#qtyinputmbl').val()))
                $('#qty').val(parseInt($('#qtyinputmbl').val()))
                if($('#qtyinputmbl').val() <= 1){
                    $('#minbtnmbl').addClass('disabled')
                }
            });
            $('#addbtndesk').click(()=>{
                $('#qtyinputdesk').val(parseInt($('#qtyinputdesk').val()) + 1);
                $('#subtotaldesk').text(rupiah($('#price').text().replace(/[^0-9]/g,'') * $('#qtyinputdesk').val()))
                $('#qtydesk').val(parseInt($('#qtyinputdesk').val()))
                if($('#qtyinputdesk').val() > 1){
                    $('#minbtndesk').removeClass('disabled')
                }
            });
            $('#minbtndesk').click(()=>{
                $('#qtyinputdesk').val(parseInt($('#qtyinputdesk').val()) - 1);
                $('#subtotaldesk').text(rupiah($('#price').text().replace(/[^0-9]/g,'') * $('#qtyinputdesk').val()))
                $('#qtydesk').val(parseInt($('#qtyinputdesk').val()))
                if($('#qtyinputdesk').val() <= 1){
                    $('#minbtndesk').addClass('disabled')
                }
            });

        });

    </script>
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
@endpush
