@extends('layouts.front.app')

@section('content')
    @include('layouts.front.home-slider')

    @if(!is_null($newests))
        <section class="new-product t100 home">
            <div class="container">
                <div class="section-title b50">
                    <h2>Newest Products</h2>
                </div>
                @include('front.products.product-list', ['products' => $newests])
                <div id="browse-all-btn"> <a class="btn btn-default browse-all-btn" href="#" role="button">browse all items</a></div>
            </div>
        </section>
    @endif
    <hr>
    @if(!is_null($features))
        <div class="container">
            <div class="section-title b100">
                <h2>Featured Products</h2>
            </div>
            @include('front.products.product-list', ['products' => $features])
            <div id="browse-all-btn"> <a class="btn btn-default browse-all-btn" href="#" role="button">browse all items</a></div>
        </div>
    @endif
@endsection