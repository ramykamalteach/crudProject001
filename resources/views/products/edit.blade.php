@extends("products.productLayout")

@section("content")

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Product</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
        </div>
    </div>
</div>
   
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
   
<form action="{{ route('products.update', $product->id) }}" method="POST">
    @csrf
    @method("PUT")
    
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Product Name:</strong>
                <input type="text" name="productName" class="form-control" placeholder="ProductName" value="{{ $product->productName}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Product Price:</strong>
                <input type="number" class="form-control" name="productPrice" placeholder="Product Price" value="{{ $product->productPrice}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>product Producer:</strong>
                <input type="text" class="form-control" name="productProducer" placeholder="productProducer" value="{{ $product->productProducer}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>product Description:</strong>
                <textarea name="productDescription" class="form-control" id="productDescription" cols="30" rows="3">{{$product->productDescription}}</textarea>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
   
</form>


@endsection