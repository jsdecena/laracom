@extends('layouts.front.app')

@section('content')
    <div class="container">
        <hr>
        <div class="row">
            <div class="category-top col-md-12">
                <h2>Search Results</h2>
            </div>
        </div>
        <hr>
        <div class="col-md-3">
            @include('front.categories.sidebar-category')
        </div>
        <div class="col-md-9">
            <div class="row">
                @include('front.products.product-list', ['products' => $products])
            </div>
        </div>
    </div>
@endsection