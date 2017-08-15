@extends('layouts.front.app')

@section('content')
    <div class="container product">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"> <i class="fa fa-home"></i> Home</a></li>
                    <li><a href="#">Category</a></li>
                    <li class="active">Product</li>
                </ol>
            </div>
        </div>
        @include('layouts.front.product')
    </div>
@endsection