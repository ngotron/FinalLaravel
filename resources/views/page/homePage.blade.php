@extends('layouts.master')
@section('content')
    <div class="fullwidthbanner-container">
        <div class="fullwidthbanner">
            <div class="bannercontainer">
                <div class="banner">
                    <ul>
                        <!-- THE FIRST SLIDE -->
                        @foreach ($slide as $sl)
                            <li data-transition="boxfade" data-slotamount="20" class="active-revslide"
                                style="width: 100%; height: 100%; overflow: hidden; z-index: 18; visibility: hidden; opacity: 0;">
                                <div class="slotholder" style="width:100%;height:100%;" data-duration="undefined"
                                    data-zoomstart="undefined" data-zoomend="undefined" data-rotationstart="undefined"
                                    data-rotationend="undefined" data-ease="undefined" data-bgpositionend="undefined"
                                    data-bgposition="undefined" data-kenburns="undefined" data-easeme="undefined"
                                    data-bgfit="undefined" data-bgfitend="undefined" data-owidth="undefined"
                                    data-oheight="undefined">
                                    <div class="tp-bgimg defaultimg" data-lazyload="undefined" data-bgfit="cover"
                                        data-bgposition="center center" data-bgrepeat="no-repeat" data-lazydone="undefined"
                                        src="source/image/slide/{{ $sl->image }}"
                                        data-src="source/image/slide/{{ $sl->image }}"
                                        style="background-color: rgba(0, 0, 0, 0); background-repeat: no-repeat; background-image: url('source/image/slide/{{ $sl->image }}'); background-size: cover; background-position: center center; width: 100%; height: 100%; opacity: 1; visibility: inherit;">
                                    </div>
                                </div>

                            </li>
                        @endforeach


                    </ul>
                </div>
            </div>

            <div class="tp-bannertimer"></div>
        </div>
    </div>
    <div class="container">
        <div id="content" class="space-top-none">
            <div class="main-content">
                <div class="space60">&nbsp;</div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="beta-products-list">
                            <h4>Sản phẩm mới</h4>
                            <div class="beta-products-details">
                                <p class="pull-left">{{ count($newProduct) }} styles found</p>
                                <div class="clearfix"></div>
                            </div>

                            <div class="row">
                                @foreach ($newProduct as $newPro)
                                    <div class="col-sm-3" style="padding:30">
                                        <div class="single-item">
                                            @if ($newPro->promotion_price != 0)
                                                <div class="ribbon-wrapper">
                                                    <div class="ribbon sale">Sale</div>
                                                </div>
                                            @endif
                                            <div class="single-item-header">
                                                <a href="product.html"><img src="source/image/product/{{ $newPro->image }}"
                                                        alt=""
                                                        style="height: 15rem; width:15rem; object-fit:cover; object-position:50% 50%"></a>
                                            </div>

                                            <div class="single-item-body">
                                                <p class="single-item-title">{{ $newPro->name }}</p>
                                                <p class="single-item-price">
                                                    @if ($newPro->promotion_price == 0)
                                                        <span
                                                            class="flash-sale">${{ number_format($newPro->unit_price) }}</span>
                                                    @else
                                                        <span
                                                            class="flash-del">${{ number_format($newPro->unit_price) }}</span>
                                                        <span
                                                            class="flash-sale">${{ number_format($newPro->promotion_price) }}</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="single-item-caption">
                                                <a class="add-to-cart pull-left"
                                                    href="{{ route('adtocart', $newPro->id) }}"><i
                                                        class="fa fa-shopping-cart"></i></a>
                                                <a class="btn btn-danger" href="{{ route('AddWishlist', $newPro->id) }}"><i
                                                        class="fa fa-heart"></i></a>
                                                <a class="beta-btn primary"
                                                    href="{{ route('detail', $newPro->id) }}">Details <i
                                                        class="fa fa-chevron-right"></i></a>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <div class="row">{{ $newProduct->links() }}</div>
                        </div> <!-- .beta-products-list -->

                        <div class="space50">&nbsp;</div>

                        <div class="beta-products-list">
                            <h4>Sản phẩm khuyến mãi</h4>
                            <div class="beta-products-details">
                                <p class="pull-left">{{ count($productSale) }} styles found</p>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row">
                                @foreach ($productSale as $proSale)
                                    <div class="col-sm-3">
                                        <div class="single-item">
                                            @if ($newPro->promotion_price != 0)
                                                <div class="ribbon-wrapper">
                                                    <div class="ribbon sale">Sale</div>
                                                </div>
                                            @endif
                                            <div class="single-item-header">
                                                <a href="product.html"><img
                                                        src="source/image/product/{{ $proSale->image }}" alt=""
                                                        style="height: 15rem; width:15rem; object-fit:cover; object-position:50% 50%"></a>
                                            </div>
                                            <div class="single-item-body">
                                                <p class="single-item-title">{{ $proSale->name }}</p>
                                                <p class="single-item-price">
                                                    @if ($proSale->promotion_price == 0)
                                                        <span
                                                            class="flash-sale">${{ number_format($proSale->unit_price) }}</span>
                                                    @else
                                                        <span
                                                            class="flash-del">${{ number_format($proSale->unit_price) }}</span>
                                                        <span
                                                            class="flash-sale">${{ number_format($proSale->promotion_price) }}</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="single-item-caption">
                                                <a class="add-to-cart pull-left"
                                                    href="{{ route('adtocart', $newPro->id) }}"><i
                                                        class="fa fa-shopping-cart"></i></a>
                                                <a class="btn btn-danger"
                                                    href="{{ route('AddWishlist', $newPro->id) }}"><i
                                                        class="fa fa-heart"></i></a>
                                                <a class="beta-btn primary"
                                                    href="{{ route('detail', $newPro->id) }}">Details <i
                                                        class="fa fa-chevron-right"></i></a>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">{{ $productSale->links() }}</div>
                        </div>
                    </div> <!-- .beta-products-list -->
                </div>
            </div> <!-- end section with sidebar and main content -->


        </div> <!-- .main-content -->
    </div> <!-- #content -->
    </div> <!-- .container -->
@endsection
