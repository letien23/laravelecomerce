@extends('admin.layout.master')
@section('content')

    <div class="space50">&nbsp;</div>
    <div class="container beta-relative">
        <div class="pull-left">
            <h2 class="center">DANH SÁCH SẢN PHẨM</h2>
        </div>
     
        <table id="table_admin_product" class="table table-striped display">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Description</th>
                    <th scope="col">Unit_price</th>
                    <th scope="col">Promotion_price</th>
                    <th scope="col">Unit</th>
                    <th scope="col">New</th>
                    <th scope="col"><a href="{{ route('add-product') }}" class="btn btn-primary"
                            style="width:80px;">Add</a></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="products-list-admin">
                        <th scope="row">{{ $product->id }}</th>
                        <th><img src="/source/image/product/{{ $product->image }}" alt="image"
                                style="height:80px;width:80px;" /></th>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->id_type }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->unit_price }}</td>
                        <td>{{ $product->promotion_price }}</td>
                        <td>{{ $product->unit }}</td>
                        <td>{{ $product->new }}</td>
                        <td>
                            <a href="{{ route('get-edit-product', $product->id) }}" type="submit" class="btn btn-info"
                                style="width:80px;margin-bottom:20px">Edit</a>
                            <form role="form" action="{{ route('post-delete-product', $product->id) }}" method="post">
                                @csrf
                                <button name="edit" type="submit" class="btn btn-danger" style="width:80px;"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa không')">Delete
                                </button>
                            </form>
                        </td>
                        {{-- <td>
                           
                        </td> --}}
                    </tr>
                @endforeach
                
                  <td colspan="10">
                    <nav aria-label="Page navigation">
                      {{ $products->links() }}

                  </nav>
                  </td>
                    
               
            </tbody>


        </table>
        <div class="space50">&nbsp;</div>
    </div>
    <script>
        $(document).ready(function() {
            $('#table_admin_product').DataTable();
        });
    </script>
@endsection