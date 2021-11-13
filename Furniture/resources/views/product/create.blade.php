@extends('layout.index')
@section('content')


    @if($errors->any())
        <div class="alert aler-danger">
            <strong>Oops!</strong>There were some problems with your input. <br><br>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>

        </div>
    @endif

    <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Product Code</strong>
                    <input type="text" name="productCode"  class="form-control" placeholder="Product Code">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Product Name</strong>
                    <input name="productName"  placeholder="Product Name" class="form-control"></input>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Price</strong>
                    <input type="number" name="price" class="form-control"  placeholder="Price">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Avatar</strong>
                    <input type="file" name="avatar" class="form-control"  placeholder="Avatar">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>


    </form>

@endsection
