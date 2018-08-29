@extends('layouts.front.app')

@section('og')
    <meta property="og:type" content="home"/>
    <meta property="og:title" content="{{ config('app.name') }}"/>
    <meta property="og:description" content="{{ config('app.name') }}"/>
@endsection

@section('content')
    @include('layouts.front.home-slider')

    @if($cat1->products->isNotEmpty())
        <section class="new-product t100 home">
            <div class="container">
                <div class="section-title b50">
                    <h2>{{ $cat1->name }}</h2>
                </div>
                @include('front.products.product-list', ['products' => $cat1->products->where('status', 1)])
                <div id="browse-all-btn"> <a class="btn btn-default browse-all-btn" href="{{ route('front.category.slug', $cat1->slug) }}" role="button">browse all items</a></div>
            </div>
        </section>
    @endif
    <hr>
    @if($cat2->products->isNotEmpty())
        <div class="container">
            <div class="section-title b100">
                <h2>{{ $cat2->name }}</h2>
            </div>
            @include('front.products.product-list', ['products' => $cat2->products->where('status', 1)])
            <div id="browse-all-btn"> <a class="btn btn-default browse-all-btn" href="{{ route('front.category.slug', $cat2->slug) }}" role="button">browse all items</a></div>
        </div>
    @endif
    <hr />
    @include('mailchimp::mailchimp')
@endsection