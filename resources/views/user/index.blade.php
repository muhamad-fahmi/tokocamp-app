@extends('layouts.app')
<?php
function rupiah($angka){
    $hasil_rupiah = "Rp " . number_format((int)$angka,0,',','.');
    return $hasil_rupiah;
}
?>
@section('contents')
    <!-- CONTENT -->
    <section class="main py-5">
        <div class="container">

            <div class="card mb-5 shadow-sm">
                <div class="card-body py-4">
                    <h4 class="title mb-4 text-dark"><b>Katagori Pupuler</b></h4>
                    <div class="montain-category row row-cols-3 row-cols-md-6">
                        @if ($categories->count() == 0)
                            <div class="col">
                                <a href="" class="icon-category">
                                    <div class="card mx-auto">
                                        <img src="{{ asset('userpage/images/icons/glamping.png') }}" class="card-img-top" alt="...">
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="" class="icon-category">
                                    <div class="card mx-auto">
                                        <img src="{{ asset('userpage/images/icons/camperfun.png') }}" class="card-img-top" alt="...">
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="" class="icon-category">
                                    <div class="card mx-auto">
                                        <img src="{{ asset('userpage/images/icons/riversidecamp.png') }}" class="card-img-top" alt="...">
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="" class="icon-category">
                                    <div class="card mx-auto">
                                        <img src="{{ asset('userpage/images/icons/bushcraft.png') }}" class="card-img-top" alt="...">
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="" class="icon-category">
                                    <div class="card mx-auto">
                                        <img src="{{ asset('userpage/images/icons/lakesidecamp.png') }}" class="card-img-top" alt="...">
                                    </div>
                                </a>
                            </div>
                        @else
                            @foreach ($categories as $category)
                                <div class="col">
                                    <a href="/category/{{ $category->slug }}" class="icon-category">
                                        <div class="card mx-auto">
                                            <img src="{{ asset('images/category/'.$category->image) }}" class="card-img-top" alt="{{ $category->name }}">
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- SORT BY START -->
            <section id="shortby" class="shortby">
                <div class="container my-5 bg-light">
                    <ul class="nav justify-content-between py-3">
                        <h4 class="title text-dark mb-0 mt-1"><i class="fas fa-th"></i> <b>Produk Terbaru</b></h4>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                <i class="fas fa-sort-amount-up me-2"></i> Sortir
                            </a>
                            <ul class="dropdown-menu shadow py-3 border-0 bg-light">
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="#"><small><i class="fas fa-sort-numeric-up me-1"></i> Harga Rendah</small></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="#"><small><i class="fas fa-sort-numeric-up-alt me-1"></i> Harga Tinggi</small></a>
                                </li>
                                <li class="nav-item px-3">
                                    <label for="sortby" class="mb-2 mt-2"><small><i class="fas fa-dollar-sign me-2"></i> Minimal</small></label>
                                    <input type="text" class="form-control form-control-sm">
                                </li>
                                <li class="nav-item px-3">
                                    <label for="sortby" class="mb-2 mt-2"><small><i class="fas fa-dollar-sign me-2"></i> Maksimal</small></label>
                                    <input type="text" class="form-control form-control-sm">
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </section>


            <div class="row">

                @if ($packages->count() == 0)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="card border border-0 shadow">
                        <img src="https://images.tokopedia.net/img/cache/900/VqbcmM/2021/2/25/8e960683-4940-45ff-9e5c-b8a2df4716f7.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Kursi Camping</h5>
                            <p class="card-text price"><strong>Rp. 200.000</strong></p>
                            <p class="card-text location"><i class="fa-solid fa-location-dot me-1 text-success"></i> Sentul Bogor</p>
                            <p class="card-text review"><i class="fa-solid fa-star text-warning me-1"></i> 5 Reviews</p>
                        </div>
                    </div>
                </div>
                @else
                    @foreach ($packages as $package)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <a href="" class="text-decoration-none text-dark">
                                <div class="card border border-0 shadow">
                                    <img src="{{ asset('images/packages/'.json_decode($package->images)[0]) }}" class="card-img-top product" alt="{{ $package->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ ucwords($package->name) }}</h5>
                                        <p class="card-text price"><strong>{{ rupiah($package->price) }}</strong></p>
                                        <p class="card-text location"><i class="fa-solid fa-location-dot me-1 text-success"></i> Sentul Bogor</p>
                                        <p class="card-text review"><i class="fa-solid fa-star text-warning me-1"></i> 5 Reviews</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>
    <!-- END CONTENT -->
@endsection
