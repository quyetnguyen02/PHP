@extends('layout.index')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center">Product management</h2>
        </div>
        <div class="col-lg-12 text-center" style="margin-top: 10px;margin-bottom: 10px" >
            <a href="{{route('product.create')}}" class="btn btn-success">Add</a>
        </div>

    </div>
    @if($message = Session::get('success'))
        <div class="alert alert-success">
            {{$message}}
        </div>
    @endif

    @if(sizeof($products) > 0)
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Avatar</th>
                <th width="280px">More</th>
            </tr>
            @foreach($products as $product)
                <tr>
                    <td>{{++$i}}</td>
                    <td>{{$product->productCode}}</td>
                    <td>{{$product->productName}}</td>
                    <td>{{$product->price}}</td>
                    <td><img src="{{$product->avatar}}" alt=""></td>
                    <td>
                        <form action="{{route('product.destroy',$product->id)}}" method="post">

                            <a href="{{route('product.edit',$product->id)}}" class="btn btn-primary">Edit</a>
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete </button>
                        </form>


                    </td>
                </tr>
            @endforeach

        </table>
    @else
        <div class="alert alert-alert">Start Adding to the Database</div>
    @endif
    {!! $products->links() !!}

@endsection
