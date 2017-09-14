@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($products)
            <div class="box">
                <div class="box-body">
                    <h2>Products</h2>
                    <div class="pull-right">
                        <!-- search form -->
                        <form action="{{route('admin.products.index')}}" method="GET">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Search..." value="{!! request()->input('q') !!}">
                                <span class="input-group-btn">
                                    <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i> Search
                                </button>
                              </span>
                            </div>
                        </form>
                        <!-- /.search form -->
                    </div>
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
