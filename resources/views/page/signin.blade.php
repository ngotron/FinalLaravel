@extends('layouts.master')
@section('content')
    <div class="inner-header">
        <div class="container">
            <div class="pull-left">
                <h6 class="inner-title">Đăng nhập</h6>
            </div>
            <div class="pull-right">
                <div class="beta-breadcrumb">
                    <a href="index.html">Home</a> / <span>Đăng nhập</span>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="container">
        <div id="content">

            <form action="{{ route('showSignin') }}" method="post" class="beta-form-checkout"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-3"></div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (Session::has('thongbao'))
                        <div class="alert alert-success">{{ Session::get('thongbao') }}</div>
                    @else
                        <div>{{ Session::get('thongbao') }}</div>
                    @endif
                    <div class="col-sm-6">
                        <h4>Đăng nhập</h4>
                        <div class="space20">&nbsp;</div>


                        <div class="form-block">
                            <label for="email">Email address*</label>
                            <input name="email" type="email" id="email">
                        </div>
                        <div class="form-block">
                            <label for="phone">Password*</label>
                            <input name="password" type="password" id="phone">
                        </div>
                        <div class="form-block">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                        <div class="form-block">
                            <a class="form-block" href="{{ route('InputEmail') }}">Quên mật khẩu</a>
                        </div>
                    </div>
                    <div class="col-sm-3"></div>
                </div>
                <div></div>
            </form>
        </div> <!-- #content -->
    </div> <!-- .container -->
@endsection
