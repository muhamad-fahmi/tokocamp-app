<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('userpage/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('userpage/css/style.cs') }}s">
    <link rel="stylesheet" href="{{ asset('userpage/css/responsive.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    @stack('styles')
    <title>Tokocamp</title>
</head>

<body>
    <!-- NAVBAR START -->
    <nav class="navbar navbar-light bg-white navbar-expand-lg fixed-top shadow">
        <div class="container-fluid py-2 px-lg-5 px-md-5 px-sm-2">
            <a class="navbar-brand me-5" href="#">
                <img src="{{ asset('userpage/images/logo/logo-tokocamp.png') }}" alt="Tokocamp Indonesia">
            </a>
            <div class="nav-mobile">
                <a href="" class="btn btn-light bg-white rounded-circle"><i class="fa-solid fa-cart-shopping text-secondary"></i></a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu Utama</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="nav-desktop w-100 d-flex">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Kategori
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                                    @if ($categories->count() == 0)
                                        <li class="px-2">Kosong</li>
                                    @else
                                        @foreach ($categories as $category)
                                        <li><a class="dropdown-item" href="/category/{{ $category->slug }}"><small>{{ ucwords($category->name) }}</small></a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        </ul>

                        <form class="w-100 me-3 ">
                            <div class="input-group ">
                                <input class="form-control shadow-none rounded-pill rounded-end" type="search" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                                <button class="btn btn-light border border-1 border-gray-700 text-center rounded-pill rounded-start" type="button" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                        <div class="d-flex">
                            <a href="/cart" class="btn btn-light bg-white rounded-circle me-3 "><i class="fa-solid fa-cart-shopping text-secondary"></i></a>

                            @if (auth()->user())
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle p-0" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="rounded-circle avatar m-0">
                                    </a>
                                        <ul class="dropdown-menu profile border-0 shadow" aria-labelledby="offcanvasNavbarDropdown">
                                            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user me-2"></i> Profile</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-alt me-2"></i> Transaksi</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('logoutuser')}}"><i class="fas fa-sign-out me-2"></i> Logout</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            @else
                                <a href="/login" class="btn btn-success rounded-pill">Masuk</a>
                            @endif
                        </div>
                    </div>
                    <div class="nav-mobile">
                        @if (auth()->user())
                           <div class="d-flex flex-column justify-content-center border-bottom border-1 pb-4 border-gray-500">
                            <div class="row w-100">
                              <div class="col-4">
                                <a href="/profile" class="d-flex justify-content-start p-0">
                                  <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }} Profile" class="rounded-circle" style="width:80%">
                                </a>
                              </div>
                              <div class="col-6 d-flex justify-content-start flex-column align-content-center pt-1 p-0">
                                <p class="text-dark mb-0">
                                  {{ auth()->user()->name }}
                                </p>
                                <small class="text-muted"><i>User Tokocamp</i></small>
                              </div>
                              <div class="col-2 d-flex align-items-center justify-content-end  p-0">
                                <a href="/settings">
                                  <i class="fa-solid fa-gear"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                           @else
                           <div class="border-bottom border-1 pb-4 border-gray-500">
                            <a href="/login" class="btn btn-outline-success me-2 w-100">Masuk</a>
                         </div>
                           @endif

                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item pt-4">
                                <p><strong>Aktivitas Saya</strong></p>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href=""><i class="fas fa-file-alt me-2"></i> Transaksi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-star me-2"></i> Ulasan</a>
                            </li>
                            <li class="nav-item pt-4">
                                <p><strong>Hubungi Kami</strong></p>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href=""><i class="fab fa-whatsapp me-2"></i> Customer Service</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-envelope me-2"></i> Customer Service</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- NAVBAR END -->
    <!-- HEADER START -->
    <section class="header mt-5">
        <div class="container">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://images.tokopedia.net/img/cache/1208/NsjrJu/2022/3/24/d5132038-53dd-4f8d-9782-43cddb2e6f79.jpg.webp" class="d-block w-100 img-header" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://images.tokopedia.net/img/cache/1208/NsjrJu/2022/3/24/c82b698a-2006-43c6-bbf5-e4696ee78778.jpg.webp" class="d-block w-100 img-header" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://images.tokopedia.net/img/cache/1208/NsjrJu/2021/7/30/74d32a7f-6a2d-49a3-b325-114de4b055c5.jpg.webp" class="d-block w-100 img-header" alt="...">
                    </div>
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
    </section>
    <!-- HEADER END -->

    @yield('contents')

    <!-- FOOTER SECTION  -->
    <section class="footer">
        <footer class="footer bg-success mt-5">
            <div class="container border-bottom border-1 pb-4 border-warning">
                <div class="row">

                    <div class=" col-sm-4 col-md col-sm-4  col-12 col">
                        <h4 class="headin6_amrc col_white_amrc pt2">Find us</h4>
                        <p class="mb-3"><i class="fa fa-location-arrow me-3"></i> Jakarta - Indonesia </p>
                        <p class="mb-3"><i class="fa fa-phone me-3"></i> +62 812 2475 2917 </p>
                        <p class="mb-3"><i class="fa fa fa-envelope me-3"></i> cs@tokocamp.com </p>
                    </div>

                    <div class=" col-sm-4 col-md  col-6 col">
                        <h5 class="headin5_amrc col_white_amrc pt2">Kategori Terbaik</h5>
                        <ul class="footer_ul_amrc">
                            <li class="mb-3"><a href="" class="text-decoration-none">Create Wedding Invitation</a></li>
                            <li class="mb-3"><a href="" class="text-decoration-none">Create Birthday Invitation</a></li>
                            <li class="mb-3"><a href="" class="text-decoration-none">Create Webbinar Invitation</a></li>
                            <li class="mb-3"><a href="" class="text-decoration-none">Create Other Event Invitation</a></li>
                        </ul>
                    </div>

                    <div class=" col-sm-4 col-md  col-6 col">
                        <h5 class="headin5_amrc col_white_amrc pt2">Quick links</h5>
                        <ul class="footer_ul_amrc">
                            <li class="mb-3"><a href="" class="text-decoration-none">How Our System Work</a></li>
                            <li class="mb-3"><a href="" class="text-decoration-none">Our Features</a></li>
                            <li class="mb-3"><a href="" class="text-decoration-none">Pricing</a></li>
                            <li class="mb-3"><a href="" class="text-decoration-none">Testimonials</a></li>
                            <li class="mb-3"><a href="" class="text-decoration-none">Our Articles</a></li>
                        </ul>
                    </div>

                    <div class=" col-sm-4 col-md  col-12 col">
                        <h5 class="headin5_amrc col_white_amrc pt2">Follow us</h5>
                        <ul class="footer_ul2_amrc">
                            <li class="text-light mb-3">
                                <i class="fab fa-twitter fleft me-3"></i> <a href="#" class="text-decoration-none text-light">@tokocamp</a>
                            </li>
                            <li class="text-light mb-3">
                                <i class="fab fa-facebook fleft me-3"></i> <a href="#" class="text-decoration-none text-light">tokocamp</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="container">
                <p class="text-center mb-0 mt-4">Copyright 2021 | Designed & Developed by <a href="#" class="text-decoration-none text-light">mFahmi</a></p>
            </div>

        </footer>
    </section>
    <!-- END FOOTER SECTION -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="{{ asset('userpage/bootstrap/js/bootstrap.min.js') }}"></script>

    @stack('scripts')

</body>

</html>
