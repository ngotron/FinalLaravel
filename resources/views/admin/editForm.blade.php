<!DOCTYPE html>
<html lang="en">

<head>
    <title>Them sản phẩm</title>
    @include('layouts.linkHead')
</head>

<body>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form class="container" method="post" action="{{ route('updateEditAdmin', $product->id) }}"
        enctype="multipart/form-data">
        @csrf
        <a href="{{ route('admin') }}">Trở về</a>
        <h2 style="text-align: center">Sửa một sản phẩm</h2>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Name</label>
            <input name="name" type="text " class="form-control" id="exampleInputPassword1" placeholder="Name"
                value="{{ $product->name }}">

        </div>
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input name="image" type="file" class="form-control" id="exampleInputEmail1"
                aria-describedby="emailHelp" placeholder="Image" value="{{ $product->image }}">
        </div>
        <img class="mt-3" src="/source/image/product/{{ $product->image }}" alt="" style="width: 5rem"><br />
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Type</label>
            <input name="id_price" type="text " class="form-control" id="exampleInputPassword1" placeholder="Type"
                value="{{ $product->id_type }}">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Unit Price</label>
            <input name="unit_price" type="text " class="form-control" id="exampleInputPassword1"
                placeholder="Unit price" value="{{ $product->unit_price }}">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Promotion price</label>
            <input name="promotion_price" type="text " class="form-control" id="exampleInputPassword1"
                placeholder="Promotion price" value="{{ $product->promotion_price }}">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Description</label>
            <input name="description" type="text " class="form-control" id="exampleInputPassword1"
                placeholder="description" value="{{ $product->description }}">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Unit</label>
            <input name="unit" type="text " class="form-control" id="exampleInputPassword1" placeholder="Unit"
                value="{{ $product->unit }}">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">New</label>
            <input name="new" type="text " class="form-control" id="exampleInputPassword1"
                placeholder="New"value="{{ $product->new }}">
        </div>
        <button type="submit" class="btn btn-primary">Edit </button>
    </form>

</body>

</html>
