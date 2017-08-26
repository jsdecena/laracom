<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    @include('layouts.front.category-nav')
    <ul  class="nav navbar-nav navbar-right">
        @if(Auth::check())
            <li><a href="{{ route('accounts') }}"><i class="fa fa-home"></i> My Account</a></li>
            <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
        @else
            <li><a href="{{ route('login') }}"> <i class="fa fa-lock"></i> Login</a></li>
            <li><a href="{{ route('register') }}"> <i class="fa fa-sign-in"></i> Register</a></li>
        @endif
        <li id="cart" class="menubar-cart">
            <a href="{{ route('cart.index') }}" title="View Cart" class="awemenu-icon menu-shopping-cart">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                <span class="cart-number">{{ $cartCount }}</span>
            </a>
        </li>
    </ul>
</div><!-- /.navbar-collapse -->