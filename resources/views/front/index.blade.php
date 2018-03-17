@extends('layouts.front.app')

@section('og')
    <meta property="og:type" content="home"/>
    <meta property="og:title" content="{{ config('app.name') }}"/>
    <meta property="og:description" content="{{ config('app.name') }}"/>
@endsection

@section('content')
    @include('layouts.front.home-slider')

    @if(!$newArrivals->products->isEmpty())
        <section class="new-product t100 home">
            <div class="container">
                <div class="section-title b50">
                    <h2>New Arrivals</h2>
                </div>
                @include('front.products.product-list', ['products' => $newArrivals->products])
                <div id="browse-all-btn"> <a class="btn btn-default browse-all-btn" href="{{ route('front.category.slug', $newArrivals->slug) }}" role="button">browse all items</a></div>
            </div>
        </section>
    @endif
    <hr>
    @if(!$featured->products->isEmpty())
        <div class="container">
            <div class="section-title b100">
                <h2>Featured Products</h2>
            </div>
            @include('front.products.product-list', ['products' => $featured->products])
            <div id="browse-all-btn"> <a class="btn btn-default browse-all-btn" href="{{ route('front.category.slug', $featured->slug) }}" role="button">browse all items</a></div>
        </div>
    @endif
    <hr />
    @include('mailchimp::mailchimp')
@endsection