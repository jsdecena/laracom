<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FirsTwelve</title>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.fadeshow-0.1.1.min.css') }}" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicons/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png')}}">
    <link rel="manifest" href="{{ asset('favicons/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicons/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100:100i:200:200i:300:400" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="background"></div>
<div class="over-bg"></div>
<main role="slider-container">
    <div class="container">
        @if ($errors->any())
            <div class="alert">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li class="alert alert-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session()->has('message'))
            <div class="alert">
                <ul class="list-unstyled">
                    <li class="alert alert-success">{{ session()->get('message') }}</li>
                </ul>
            </div>
        @endif
        <div class="tab-content text-center">
            <header>
                <img src="{{ asset('images/logo.png') }}" alt="firstwelve.com" class="logo">
                <ul class="list-unstyled list-inline list-pages">
                    <li><a href="#" onclick="javascript: void(0)" data-toggle="modal" data-target="#about">-about-</a></li>
                    <li><a href="#" onclick="javascript: void(0)" data-toggle="modal" data-target="#partner">-partner-</a></li>
                    <li><a href="#" onclick="javascript: void(0)" data-toggle="modal" data-target="#contact">-contact-</a></li>
                </ul>
            </header>
            <section class="tagline">
                <h4>ARE YOU READY FOR A <span>NEW</span> SHOPPING EXPERIENCE?</h4>
            </section>
            <section id="home" class="tab-pane fade in active">
                <article role="countdown" class="countdown-pan">
                    <div id="countdown"></div>
                </article>
            </section>

            <section id="stay-tuned" class="text-center">
                <p>Stay updated with our activities, be first to hear our important announcements!</p>
                <div class="social col-md-4 col-md-offset-4">
                    <ul class="list-unstyled">
                        <li class="fb"><a href="https://www.facebook.com/First-Twelve-1239568282839291/"><span><i class="fa fa-facebook-f"></i></span></a></li>
                        <li class="ig"><a href="https://www.instagram.com/firstwelve/"><span><i class="fa fa-instagram"></i></span></a></li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
</main>
<!-- Modal -->
<div class="modal fade" id="about" tabindex="-1" role="dialog" aria-labelledby="about">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Who we are?</h4>
            </div>
            <div class="modal-body text-left">
                <p><strong>Firstwelve is all about you moms, dads, aunts, uncles -- <span class="text-warning">and your little ones, neices, nephews, babies, and kids.</span></strong></p>
                <p>We aim to provide a seamless, convenient, one-of-a-kind shopping experience.</p>
                <p>From baby bottles and diapers, to carriers and strollers, shopping everything you need for your kids has never been possible in one go.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="partner" tabindex="-1" role="dialog" aria-labelledby="partner">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Why partner with us?</h4>
            </div>
            <div class="modal-body text-left">
                <p><strong>Interested in joining us as we break the <span class="text-warning">structure of standard shopping?</span></strong></p>
                <p>Shoot us an email at <a style="text-decoration: underline" href="mailto:hello@firstwelve.com">hello@firstwelve.com</a></p>
                <p>We can't wait to hear from you!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="contact">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('inquiry.store') }}" class="form-horizontal" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Contact Us</h4>
                </div>
                <div class="modal-body text-left">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" id="firstname" name="first_name" class="form-control" placeholder="Your First Name" />
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" id="lastname" name="last_name" class="form-control" placeholder="Your Last Name" />
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Your Email" />
                        </div>
                        <div class="form-group">
                            <label for="select">I am a:</label>
                            <select name="select" id="select" class="form-control">
                                <option value="mom">Mom</option>
                                <option value="dad">Dad</option>
                                <option value="aunt">Aunt</option>
                                <option value="uncle">Uncle</option>
                                <option value="sister">Sister</option>
                                <option value="brother">Bother</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" rows="5" class="form-control" placeholder="Your Message"></textarea>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Send Now</button>
                </div>
            </form>
        </div>
    </div>
</div>
<footer class="mobile">
    <p>FirsTwelve.com | All rights reserved.</p>
</footer>

<script src="{{ asset('/js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/custom.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/nav-custom.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/countdown-js.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/background.cycle.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/background.cycle-custom.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/html5shiv.js') }}" type="text/javascript"></script>
</body>
</html>
