@extends('layout.index')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center">Edit Product</h2>
        </div>
        <div class="col-lg-12 text-center" style="margin-top: 10px;margin-bottom: 10px">
            <a href="{{route('product.index')}}" class="btn btn-primary">Back</a>

        </div>

    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Error</strong>Check your input data <br><br>
            <ul>
                @foreach($errors->all as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>

        </div>
    @endif

    <form action="{{route('product.update',$product->id)}}" method="post">
        @csrf
        @method('PUT')
        <div class="row">


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Product Name</strong>
                    <input name="productName" class="form-control" value="{{$product->productName}}"  placeholder="Product Description"></input>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Price</strong>
                    <input type="number" name="price" class="form-control" value="{{$product->price}}" placeholder="Price">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Avatar</strong>
                    <input type="file" name="avatar" class="form-control" value="{{$product->avatar}}" placeholder="Avatar">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>


    </form>
@endsection
