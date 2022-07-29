@extends('layouts.master')
@section('content')
    <div class="container">
        <div id="content">
            <form action="{{ route('showSignup') }}" method="post" class="beta-form-checkout" enctype="multipart/form-data">
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
                    @if (Session::has('thanhcong'))
                        <div class="alert alert-success">{{ Session::get('thanhcong') }}</div>
                    @endif
                    <div class="col-sm-6">
                        <h4>Đăng kí</h4>
                        <div class="space20">&nbsp;</div>
                        <div class="form-block">
                            <label for="email">Email address*</label>
                            <input name="email" type="email" id="email" placeholder="Email address">
                        </div>

                        <div class="form-block">
                            <label for="your_last_name">Fullname*</label>
                            <input name="fullName" type="text" id="your_last_name" placeholder="Full name">
                        </div>

                        <div class="form-block">
                            <label for="adress">Address*</label>
                            <input name="address" type="text" id="adress" value="" placeholder="Address">
                        </div>


                        <div class="form-block">
                            <label for="phone">Phone*</label>
                            <input name="phone" type="text" id="phone" placeholder="phone">
                        </div>
                        <div class="form-block">
                            <label for="phone">Password*</label>
                            <input name="password" type="password" id="phone" placeholder="Password">
                        </div>
                        <div class="form-block">
                            <label for="phone">Re password*</label>
                            <input name="rePassword" type="password" id="phone" placeholder="Re password">
                        </div>
                        <div class="form-block">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </div>
                    <div class="col-sm-3"></div>
                </div>
            </form>
        </div> <!-- #content -->
    </div>
@endsection
