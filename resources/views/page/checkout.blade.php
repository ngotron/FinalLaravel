@extends('layouts.master')
@section('content')
    <div class="container">
        <div id="content">

            <form method="post" class="beta-form-checkout" enctype="multipart/form-data" action="{{ route('showCheckout') }}">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <h4>Đặt hàng</h4>
                        <div class="space20">&nbsp;</div>

                        <div class="form-block">
                            <label for="name">Họ tên*</label>
                            <input type="text" name="name" id="name" placeholder="Họ tên">
                        </div>
                        <div class="form-block">
                            <label>Giới tính </label>
                            <input id="gender" name="gender" type="radio" class="input-radio" name="gender"
                                value="nam" checked="checked" style="width: 10%"><span
                                style="margin-right: 10%">Nam</span>
                            <input id="gender" type="radio" class="input-radio" name="gender" value="nữ"
                                style="width: 10%"><span>Nữ</span>

                        </div>

                        <div class="form-block">
                            <label for="email">Email*</label>
                            <input type="email" name="email" id="email" placeholder="expample@gmail.com">
                        </div>

                        <div class="form-block">
                            <label for="address">Địa chỉ*</label>
                            <input type="text" name="address" id="address" placeholder="Street Address">
                        </div>


                        <div class="form-block">
                            <label for="phone">Điện thoại*</label>
                            <input type="text" name="phone" id="phone">
                        </div>

                        <div class="form-block">
                            <label for="notes">Ghi chú</label>
                            <textarea name="notes" id="notes"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="your-order">
                            <div class="your-order-head">
                                <h5>Đơn hàng của bạn</h5>
                            </div>
                            <div class="your-order-body" style="padding: 0px 10px">
                                <div class="your-order-item">
                                    <div>

                                        <!--  one item	 -->
                                        @if (Session::has('cart'))
                                            @foreach ($product_cart as $product)
                                                <div class="media">
                                                    <img width="25%"
                                                        src="source/image/product/{{ $product['item']['image'] }}"
                                                        alt="" class="pull-left">
                                                    <div class="media-body">
                                                        <p class="font-large">{{ $product['item']['name'] }}</p>
                                                        <span class="color-gray your-order-info">Unit price:
                                                            {{ $product['item']['promotion_price'] == 0
                                                                ? number_format($product['item']['unit_price'])
                                                                : number_format($product['item']['promotion_price']) }}</span>
                                                        <span class="color-gray your-order-info">Qty:
                                                            {{ $product['qty'] }}</span>
                                                    </div>
                                                </div>
                                                <!-- end one item -->
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="your-order-item">
                                    <div class="pull-left">
                                        <p class="your-order-f18">Tổng tiền:</p>
                                    </div>
                                    <div class="pull-right">
                                        <h5 class="color-black">
                                            @if (Session::has('cart'))
                                                {{ number_format($totalPrice) }}
                                            @else
                                                0
                                            @endif đ
                                        </h5>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="your-order-head">
                                <h5>Hình thức thanh toán</h5>
                            </div>

                            <div class="your-order-body">
                                <ul class="payment_methods methods">
                                    <li class="payment_method_bacs">
                                        <input id="payment_method_bacs" type="radio" class="input-radio"
                                            name="payment_method" value="COD" checked="checked" data-order_button_text=""
                                            name="payment">
                                        <label for="payment_method_bacs">Thanh toán khi nhận hàng </label>
                                        <div class="payment_box payment_method_bacs" style="display: block;">
                                            Cửa hàng sẽ gửi hàng đến địa chỉ của bạn, bạn xem hàng rồi thanh toán tiền cho
                                            nhân viên giao hàng
                                        </div>
                                    </li>

                                    <li class="payment_method_cheque">
                                        <input id="payment_method_cheque" type="radio" class="input-radio"
                                            name="payment_method" value="ATM" data-order_button_text="" name="payment">
                                        <label for="payment_method_cheque">Chuyển khoản </label>
                                    </li>
                                    
                                    <li class="payment_method_cheque"><input id="payment_method_cheque" type="radio"
                                            class="input-radio" name="payment_method" value="VNPAY"
                                            data-order_button_text="">
                                        <label for="payment_method_cheque">Thanh toán online</label>
                                    </li>

                                </ul>
                            </div>

                            <div class="text-center"><button type="submit" class="beta-btn primary">Đặt
                                    hàng <i class="fa fa-chevron-right"></i></button>
                            </div> <!-- .your-order -->
                        </div>
                    </div>
            </form>
        </div> <!-- #content -->
    </div> <!-- .container -->
@endsection
