@extends('layouts.front.app')

@section('content')
    <hr>
    <!-- Main content -->
    <section class="container content">
        <div class="row">
            <div class="col-md-12">@include('layouts.errors-and-messages')</div>
            <div class="col-md-4 col-md-offset-4">
                <h2>Login to your account</h2>
                <form action="{{ route('cart.login') }}" method="post" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" value="" class="form-control" placeholder="xxxxx">
                    </div>
                    <div class="row">
                        <button class="btn btn-default btn-block" type="submit">Login now</button>
                    </div>
                </form>
                <div class="row">
                    <hr>
                    <a href="#">I forgot my password</a><br>
                    <a href="{{ url('/') }}" class="text-center">No account? Register here.</a>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
