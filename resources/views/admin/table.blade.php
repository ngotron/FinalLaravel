@include('layouts.linkHead')

<body>

    <script>
        var msg = '{{ Session::get('alert') }}';
        var exist = '{{ Session::has('alert') }}';
        if (exist) {
            alert(msg);
        }
    </script>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 style="text-align: center">Danh sách sản phẩm</h1>
                <h5 class="col-12 col-md-6" style="background: rgb(23, 21, 21);color:white">Số sản phẩm:
                    {{ count($products) }}
                </h5>
                <div class="col-12 col-md-6" style=" background: rgb(134, 134, 142);color:white">Đã bán:
                    <br />
                    <p>Tổng: {{ $sumSold }}</p>
                    <p>Hôm nay: 1</p>
                    <p>Tháng này: 3</p>
                    <p>Năm nay: 4</p>
                </div>
                {{-- <div class="pull-left">
            <h2>List</h2>
        </div> --}}
                {{-- <div class="pull-right">
            <a href="{{ route('export') }}" class="btn btn-primary">
                Xuất ra PDF
            </a>
        </div> --}}
                <a href="{{ route('showAddAdmin') }}">Add</a>
                <table class="table container">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Image</th>
                            <th scope="col">Type</th>
                            <th scope="col">Unit price</th>
                            <th scope="col">Promotion price</th>
                            <th scope="col">Description</th>
                            <th scope="col">Unit</th>
                            <th scope="col">New</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td><img width="300" src="source/image/product/{{ $product->image }}" /></td>
                                <td>{{ $product->id_type }}</td>
                                <td>{{ $product->unit_price }}</td>
                                <td>{{ $product->promotion_price }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->unit }}</td>
                                <td>{{ $product->new }}</td>
                                <td><a href="{{ route('showEditAdmin', $product->id) }}" type="button"
                                        class="btn btn-dark">Edit</a>
                                </td>
                                <form method="POST" action="{{ route('DeltetetAdmin', $product->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    {{-- @method('delete') --}}
                                    <td><button type="submit" class="btn btn-dark">Delete</button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row">{{ $products->links() }}</div>
            </div>
</body>

</html>
