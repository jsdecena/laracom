<footer class="footer-section footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">

                <ul class="footer-menu">
                    <li> <a href="{{ route('accounts') }}">Your account</a>  </li>
                    <li> <a href="">Contact us</a>  </li>
                    <li> <a href="">Terms of service</a>  </li>
                </ul>

                <ul class="footer-social">
                    <li> <a href=""> <i class="fa fa-facebook" aria-hidden="true"></i>  </a> </li>
                    <li> <a href=""> <i class="fa fa-twitter" aria-hidden="true"></i>   </a> </li>
                    <li> <a href=""> <i class="fa fa-instagram" aria-hidden="true"></i>  </a> </li>
                    <li> <a href=""> <i class="fa fa-pinterest-p" aria-hidden="true"></i>  </a> </li>
                </ul>

                <p>&copy; <a href="{{ config('app.url') }}">{{ config('app.name') }}</a> | All Rights Reserved</p>

            </div>
        </div>
    </div>
</footer>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('front/js/custom.js') }}"></script>
<script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>