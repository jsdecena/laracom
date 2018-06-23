@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if(!$products->isEmpty())
            <div class="box">
                <div class="box-body">
                    <h2>Products</h2>
                    @include('layouts.search', ['route' => route('admin.products.index')])
                    @include('admin.shared.products')
                    {{ $products->links() }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
