@extends('layouts.front.app')

@section('content')
    @include('layouts.front.home-slider')

    @if(!is_null($newests))
        <section class="new-product t100 home">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title b100">
                            <h2>Newest Products</h2>
                            <p>dolor sit amet</p>
                        </div>
                    </div>
                </div>
                @include('front.products.product-list', ['products' => $newests])
                <div id="browse-all-btn"> <a class="btn btn-default browse-all-btn" href="#" role="button">browse all items</a></div>
            </div>
        </section>
    @endif

    <section  class="container">
        <hr>
    </section>

    @if(!is_null($features))
        <section class="new-product t100 home">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title b100">
                            <h2>Featured Products</h2>
                            <p>dolor sit amet</p>
                        </div>
                    </div>
                </div>

                @include('front.products.product-list', ['products' => $features])

                <div id="browse-all-btn"> <a class="btn btn-default browse-all-btn" href="#" role="button">browse all items</a></div>

            </div>
        </section>
    @endif

    <section class="brand-section  t100">
        <div class="container">
            <div class="row">

                <div id="brand-logo">

                    <div class="item">
                        <img src="{{ asset('front/images/brand/1.png') }}" alt="Owl Image">
                    </div>
                    <div class="item">
                        <img src="{{ asset('front/images/brand/2.png') }}" alt="Owl Image">
                    </div>
                    <div class="item">
                        <img src="{{ asset('front/images/brand/3.png') }}" alt="Owl Image">
                    </div>
                    <div class="item">
                        <img src="{{ asset('front/images/brand/4.png') }}" alt="Owl Image">
                    </div>
                    <div class="item">
                        <img src="{{ asset('front/images/brand/5.png') }}" alt="Owl Image">
                    </div>
                    <div class="item">
                        <img src="{{ asset('front/images/brand/6.png') }}" alt="Owl Image">
                    </div>
                    <div class="item">
                        <img src="{{ asset('front/images/brand/1.png') }}" alt="Owl Image">
                    </div>
                    <div class="item">
                        <img src="{{ asset('front/images/brand/2.png') }}" alt="Owl Image">
                    </div>
                    <div class="item">
                        <img src="{{ asset('front/images/brand/3.png') }}" alt="Owl Image">
                    </div>

                </div>

            </div>
        </div>
    </section>

    <section class="blog-section  t100">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title b100">
                        <h2>Blog Post</h2>
                        <p>dolor sit amet</p>
                    </div>
                </div>
            </div>

            <div class="row">


                <div class="col-md-6">
                    <div class="media">
                        <div class="media-left"> <a href="#"> <img class="media-object" src="images/blog/1.jpg" alt="one"> </a> </div>
                        <div class="media-body">
                            <h3 class="media-heading">Lorem Dolor Amet Consectetur Dipisicing</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod incididunt</p>
                            <a href="" class="read-more">Read more <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="media">
                        <div class="media-left"> <a href="#"> <img class="media-object" src="images/blog/2.jpg" alt="one"> </a> </div>
                        <div class="media-body">
                            <h3 class="media-heading">Lorem Dolor Amet Consectetur Dipisicing</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod incididunt</p>
                            <a href="" class="read-more">Read more <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="media">
                        <div class="media-left"> <a href="#"> <img class="media-object" src="images/blog/4.jpg" alt="one"> </a> </div>
                        <div class="media-body">
                            <h3 class="media-heading">Lorem Dolor Amet Consectetur Dipisicing</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod incididunt</p>
                            <a href="" class="read-more">Read more <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="media">
                        <div class="media-left"> <a href="#"> <img class="media-object" src="images/blog/1.jpg" alt="one"> </a> </div>
                        <div class="media-body">
                            <h3 class="media-heading">Lorem Dolor Amet Consectetur Dipisicing</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod incididunt</p>
                            <a href="" class="read-more">Read more <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
                        </div>
                    </div>
                </div>


            </div>

            <div id="browse-all-btn"> <a class="btn btn-default browse-all-btn" href="#" role="button">read all post</a></div>

        </div>
    </section>

    <section class="subscribe-section t100">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h3>Join 100,000 members already collaborating </h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                    </p>
                    <div class="form-field-section">
                        <input type="email" class="newsletter-input subscribe-form-control" placeholder="Your email address">
                        <button type="submit" class="btn btn-subscribe">Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection