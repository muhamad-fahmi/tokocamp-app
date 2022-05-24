@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{asset('userpage/css/pagestyle.css')}}">
<link rel="stylesheet" href="{{ asset('vendor/izitoast/dist/css/iziToast.min.css') }}">
<style>
    .form-check-input:checked {
        background-color: #146b02 !important;
    }
    @media screen and (max-width: 660px) {
        .footer {
            display:none;
        }
    }
</style>
@endpush
@section('contents')
<section class="content">

     <div class="container">
        <div class="row">
            <?php
                   function rupiah($angka){
                        $hasil_rupiah = "Rp " . number_format((int)$angka,0,',','.');
                        return $hasil_rupiah;
                   }
                   $ptotal = [];
                   $ltotal = [];
              ?>
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 mb-5">
                <h5><strong>Keranjang </strong></h5>
                @if ($packagecart->count() > 0)
                <ul class="list-group list-group-flush mt-5">

                    @foreach ($packagecart as $pcart)
                        <li class="list-group-item  px-0 d-flex">
                            <input class="form-check-input me-3" type="checkbox" id="" value="" checked aria-label="{{ $pcart->name }}">
                            <div class="contain w-100">
                                <a href="" class="text-decoration-none text-success">
                                    <b>{{ ucwords($pcart->package->subcategory->name) }}</b>
                                </a>
                                <p><small>{{ ucwords($pcart->package->subcategory->area . " - " . str_replace("Kabupaten", "Kab", $pcart->package->subcategory->city)) }}</small></p>
                                <div class="row">
                                    <div class="col-4 col-lg-3">
                                        <img src="{{ asset('images/packages/'.json_decode($pcart->package->images)[0]) }}" alt="{{ $pcart->package->name }}" class="w-100 rounded-3">
                                    </div>
                                    <div class="col-8 col-lg-9">
                                        <p class="mb-1">{{ ucwords($pcart->package->name) }}</p>
                                        <p><strong id="price">{{ rupiah($pcart->package->price) }}</strong></p>
                                        <div class="d-flex pt-4 border-1 border-top">
                                            <button class="btn btn-danger me-3" data-bs-toggle="modal" data-bs-target="#modalDeletepackage{{ $pcart->id }}"><i class="fas fa-trash-alt"></i></button>
                                            <button id="minbtnmbl" class="btn btn-outline-success me-2">-</button>
                                            <input type="text" class="form-control me-2 text-center" id="qtyinputmbl" value="{{ $pcart->total }}" readonly>
                                            <button id="addbtnmbl" class="btn btn-success">+</button>
                                        </div>
                                        <!-- Modal Delete-->
                                        <div class="modal fade" id="modalDeletepackage{{ $pcart->id }}" tabindex="-1" aria-labelledby="modalDeletepackage{{ $pcart->id }}Label" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="modalDeletepackage{{ $pcart->id }}Label"><i class="fas fa-exclamation-circle"></i> Delete Alert</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                Will you delete this item from your cart ?
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <form action="/cart/package/{{ $pcart->id }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Continue</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $ptotal[] = $pcart->package->price * $pcart->total;
                                        @endphp
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @endif
                @if ($campinggearcart->count() > 0)
                {{-- LOGITICS CART --}}

                    @foreach ($campinggearcart as $lcart)
                    <li class="list-group-item  px-0 d-flex">
                        <input class="form-check-input me-3" type="checkbox" value="" aria-label="{{ $lcart->name }}">
                        <div class="contain w-100">
                            <a href="" class="text-decoration-none text-success">
                                <b>{{ ucwords($lcart->campinggear->subcategory->name) }}</b>
                            </a>
                            <p><small>{{ $lcart->campinggear->stok }}</small></p>
                            <div class="row">
                                <div class="col-3">
                                    <img src="{{ asset('images/packages/'.json_decode($lcart->campinggear->images)[0]) }}" alt="{{ $lcart->campinggear->name }}" class="w-100 rounded-3">
                                </div>
                                <div class="col-9">
                                    <p class="mb-1">{{ ucwords($lcart->campinggear->name) }}</p>
                                    <p><strong>{{ rupiah($lcart->campinggear->price) }}</strong></p>
                                    <div class="d-flex pt-4 border-1 border-top">
                                        <button class="btn btn-danger me-3" data-bs-toggle="modal" data-bs-target="#modalDeleteCampinggear{{ $lcart->id }}"><i class="fas fa-trash-alt"></i></button>
                                        <button id="minbtnmbl" class="btn btn-outline-success me-2">-</button>
                                        <input type="text" class="form-control me-2 text-center" id="qtyinputmbl" value="1" readonly>
                                        <button id="addbtnmbl" class="btn btn-success">+</button>
                                    </div>
                                    <!-- Modal Delete -->
                                    <div class="modal fade" id="modalDeleteCampinggear{{ $lcart->id }}" tabindex="-1" aria-labelledby="modalDeleteCampinggear{{ $lcart->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="modalDeleteCampinggear{{ $lcart->id }}Label"><i class="fas fa-exclamation-circle"></i> Delete Alert</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            Will you delete this item from your cart ?
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <form action="/cart/campinggear/{{ $lcart->id }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Continue</button>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $ptotal[] = $lcart->campinggear->price * $lcart->total;
                                    @endphp
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>

            <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                <div class="card check-desk">
                    <div class="card-body">
                        <p class="border-1 border-bottom pb-3"><strong>Ringkasan Belanja</strong></p>

                        <p class="text-mutwd">Total Harga</p>
                        <h5 id="total"><strong>{{ rupiah(array_sum($ptotal)) }}</strong></h5>
                        <form action="/checkout" method="post" class="mt-3">
                            @csrf
                            <div class="form-group">
                                <label for="Date">Tanggal Pemesanan</label>
                                <input type="date" name="bookdate" class="form-control mt-3" required>
                            </div>
                            @foreach ($packagecart as $pcart)
                            <input type="hidden" name="packages[]" value="{{ $pcart->id }}">
                            @endforeach
                            @foreach ($campinggearcart as $lcart)
                            <input type="hidden" name="logistics[]" value="{{ $lcart->id }}">
                            @endforeach

                            <button type="submit" class="btn btn-success mt-3" style="width: 100%"><b>CHECKOUT</b></button>
                        </form>
                    </div>
                </div>
            </div>

            @if ($campinggearcart->count() <= 0 AND $packagecart->count() <= 0)
                <div class="col-md-12 col-sm-12 mb-4" data-animate-effect="fadeIn">
                    <div class="card mb-4">
                        <div class="card-body">
                                Your cart is empty. Please select our service package or item !
                        </div>
                    </div><br>
                </div>

            @endif
        </div>
     </div>
     <nav class="navbar navbar-light bg-light fixed-bottom shadow-sm check-mobile">
        <div class="container-fluid">
            <div class="d-flex justify-content-between w-100">
                <div class="harga">
                    <p class="text-muted mb-0"><small>Total Harga</small></p>
                    <h5 class="mb-0" id="total"><strong>{{ rupiah(array_sum($ptotal)) }}</strong></h5>
                </div>
                <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-success w-50" >
                    <i class="fas fa-check-circle"></i> Checkout
                </button>
                <!-- Modal -->

            </div>

        </div>
    </nav>
</section>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('vendor/izitoast/dist/js/iziToast.min.js') }}"></script>
    <?php
        if (session('warning')){
        ?>
            <script>
                iziToast.warning({
                    title: 'warning',
                    message: '{{ session('warning') }}',
                    position: 'bottomRight'
                });
            </script>
        <?php
        }
    ?>
    <script>
        function rupiah (num) {
            return "Rp " + num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
        }

        $(document).ready(()=>{
            $('#total').text(rupiah($('#price').text().replace(/[^0-9]/g,'') * $('#qtyinputmbl').val()))
            $('#totaldesk').text($('#price').text())
            if($('#qtyinputmbl').val() <= 1){
                $('#minbtnmbl').addClass('disabled')
            }
            if($('#qtyinputdesk').val() <= 1){
                $('#minbtndesk').addClass('disabled')
            }

            $('#addbtnmbl').click(()=>{
                $('#qtyinputmbl').val(parseInt($('#qtyinputmbl').val()) + 1);
                $('#total').text(rupiah($('#price').text().replace(/[^0-9]/g,'') * $('#qtyinputmbl').val()))
                $('#qty').val(parseInt($('#qtyinputmbl').val()) + 1)
                if($('#qtyinputmbl').val() > 1){
                    $('#minbtnmbl').removeClass('disabled')
                }
            });
            $('#minbtnmbl').click(()=>{
                $('#qtyinputmbl').val(parseInt($('#qtyinputmbl').val()) - 1);
                $('#total').text(rupiah($('#price').text().replace(/[^0-9]/g,'') * $('#qtyinputmbl').val()))
                $('#qty').val(parseInt($('#qtyinputmbl').val()) - 1)
                if($('#qtyinputmbl').val() <= 1){
                    $('#minbtnmbl').addClass('disabled')
                }
            });
            $('#addbtndesk').click(()=>{
                $('#qtyinputdesk').val(parseInt($('#qtyinputdesk').val()) + 1);
                $('#totaldesk').text(rupiah($('#price').text().replace(/[^0-9]/g,'') * $('#qtyinputdesk').val()))
                $('#qtydesk').val(parseInt($('#qtyinputdesk').val()) + 1)
                if($('#qtyinputdesk').val() > 1){
                    $('#minbtndesk').removeClass('disabled')
                }
            });
            $('#minbtndesk').click(()=>{
                $('#qtyinputdesk').val(parseInt($('#qtyinputdesk').val()) - 1);
                $('#totaldesk').text(rupiah($('#price').text().replace(/[^0-9]/g,'') * $('#qtyinputdesk').val()))
                $('#qtydesk').val(parseInt($('#qtyinputdesk').val()) - 1)
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
