@extends('layouts.master')
@section('content')
    <div class="container">
        <div id="content">
            <div class="row">
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-4">
                            <img src="/source/image/product/{{ $detailPro->image }}" alt="rong"
                                style="height: 15rem; width:15rem; object-fit:cover; object-position:50% 50%">
                        </div>
                        <div class="col-sm-8">
                            <div class="single-item-body">
                                <p class="single-item-title">{{ $detailPro->name }}</p>
                                <p class="single-item-price">
                                    @if ($detailPro->promotion_price == 0)
                                        <span class="flash-sale">${{ number_format($detailPro->unit_price) }}</span>
                                    @else
                                        <span class="flash-del">${{ number_format($detailPro->unit_price) }}</span>
                                        <span class="flash-sale">${{ number_format($detailPro->promotion_price) }}</span>
                                    @endif
                                </p>
                            </div>

                            <div class="clearfix"></div>
                            <div class="space20">&nbsp;</div>

                            <div class="single-item-desc">
                                <p>{{ $detailPro->description }}</p>
                            </div>
                            <div class="space20">&nbsp;</div>

                            <p>Số lượng:</p>
                            <div class="single-item-options">
                                <select class="wc-select" name="size">
                                    <option>Size</option>
                                    <option value="XS">XS</option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                </select>
                                <select class="wc-select" name="color">
                                    <option>Color</option>
                                    <option value="Red">Red</option>
                                    <option value="Green">Green</option>
                                    <option value="Yellow">Yellow</option>
                                    <option value="Black">Black</option>
                                    <option value="White">White</option>
                                </select>
                                <select class="wc-select" name="color">
                                    <option>Qty</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                <a class="add-to-cart" href="#"><i class="fa fa-shopping-cart"></i></a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="space40">&nbsp;</div>


                    <div class="woocommerce-tabs">
                        <ul class="tabs">
                            <li><a href="#tab-description">Description</a></li>
                            <li><a href="#tab-comment">Comments</a></li>
                        </ul>

                        <div class="panel" id="tab-description">
                            <p>{{ $detailPro->description }}</p>
                        </div>
                        <div class="panel" id="tab-comment">
                            <div class="container">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card-body">
                                            <form method="post" action="{{ route('AddComment', $detailPro->id) }}">
                                                @csrf
                                                <div class="form-group">
                                                    <textarea class="form-control" name="comment" required></textarea>
                                                </div>
                                                <button type="submit" class="beta-btn primary">Bình luận</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if (isset($comments))
                                @foreach ($comments as $comment)
                                    <p class="border-bottom">
                                    <p><b class="pull-left">{{ $comment->username }}</b></p><br />
                                    <p>{{ $comment->comment }}</p>
                                    <form method="POST" action="{{ route('deleteComment', $comment->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        {{-- @method('delete') --}}
                                        <td>
                                            <button type="submit" class="btn btn-dark">Delete</button>
                                        </td>
                                    </form>
                                @endforeach
                            @else
                                <p>Chưa có bình luận nào cả!</p>
                            @endif
                        </div>
                    </div>

                    <div class="space50">&nbsp;</div>
                    <div class="beta-products-list">
                        <h4>Sản phẩm tương tự</h4>

                        <div class="row">
                            @foreach ($relatePro as $relaPro)
                                <div class="col-sm-4">
                                    <div class="single-item">
                                        <div class="single-item-header">
                                            <a href="product.html"><img src="/source/image/product/{{ $relaPro->image }}"
                                                    alt=""
                                                    style="height: 15rem; width:15rem; object-fit:cover; object-position:50% 50%"></a>
                                        </div>
                                        <div class="single-item-body">
                                            <p class="single-item-title">{{ $relaPro->name }}</p>
                                            <p class="single-item-price">
                                                @if ($relaPro->promotion_price == 0)
                                                    <span
                                                        class="flash-sale">${{ number_format($relaPro->unit_price) }}</span>
                                                @else
                                                    <span
                                                        class="flash-del">${{ number_format($relaPro->unit_price) }}</span>
                                                    <span
                                                        class="flash-sale">${{ number_format($relaPro->promotion_price) }}</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="single-item-caption">
                                            <a class="add-to-cart pull-left" href="product.html"><i
                                                    class="fa fa-shopping-cart"></i></a>
                                            <a class="beta-btn primary" href="product.html">Details <i
                                                    class="fa fa-chevron-right"></i></a>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">{{ $relatePro->links() }}</div>
                    </div>

                </div>
                <div class="col-sm-3 aside">
                    <div class="widget">
                        <h3 class="widget-title">Best Sellers</h3>
                        <div class="widget-body">
                            <div class="beta-sales beta-lists">
                                <div class="media beta-sales-item">
                                    <a class="pull-left" href="product.html"><img
                                            src="/source/assets/dest/images/products/sales/1.png" alt=""></a>
                                    <div class="media-body">
                                        Sample Woman Top
                                        <span class="beta-sales-price">$34.55</span>
                                    </div>
                                </div>
                                <div class="media beta-sales-item">
                                    <a class="pull-left" href="product.html"><img
                                            src="/source/assets/dest/images/products/sales/2.png" alt=""></a>
                                    <div class="media-body">
                                        Sample Woman Top
                                        <span class="beta-sales-price">$34.55</span>
                                    </div>
                                </div>
                                <div class="media beta-sales-item">
                                    <a class="pull-left" href="product.html"><img
                                            src="/source/assets/dest/images/products/sales/3.png" alt=""></a>
                                    <div class="media-body">
                                        Sample Woman Top
                                        <span class="beta-sales-price">$34.55</span>
                                    </div>
                                </div>
                                <div class="media beta-sales-item">
                                    <a class="pull-left" href="product.html"><img
                                            src="/source/assets/dest/images/products/sales/4.png" alt=""></a>
                                    <div class="media-body">
                                        Sample Woman Top
                                        <span class="beta-sales-price">$34.55</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- best sellers widget -->
                    <div class="widget">
                        <h3 class="widget-title">New Products</h3>
                        <div class="widget-body">
                            <div class="beta-sales beta-lists">
                                <div class="media beta-sales-item">
                                    <a class="pull-left" href="product.html"><img
                                            src="source/assets/dest/images/products/sales/1.png" alt=""></a>
                                    <div class="media-body">
                                        Sample Woman Top
                                        <span class="beta-sales-price">$34.55</span>
                                    </div>
                                </div>
                                <div class="media beta-sales-item">
                                    <a class="pull-left" href="product.html"><img
                                            src="source/assets/dest/images/products/sales/2.png" alt=""></a>
                                    <div class="media-body">
                                        Sample Woman Top
                                        <span class="beta-sales-price">$34.55</span>
                                    </div>
                                </div>
                                <div class="media beta-sales-item">
                                    <a class="pull-left" href="product.html"><img
                                            src="source/assets/dest/images/products/sales/3.png" alt=""></a>
                                    <div class="media-body">
                                        Sample Woman Top
                                        <span class="beta-sales-price">$34.55</span>
                                    </div>
                                </div>
                                <div class="media beta-sales-item">
                                    <a class="pull-left" href="product.html"><img
                                            src="source/assets/dest/images/products/sales/4.png" alt=""></a>
                                    <div class="media-body">
                                        Sample Woman Top
                                        <span class="beta-sales-price">$34.55</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- best sellers widget -->
                </div>
            </div>
        </div> <!-- #content -->
    </div> <!-- .container -->
@endsection
