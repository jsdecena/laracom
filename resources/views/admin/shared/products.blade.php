@if(isset($products))
    <table class="table">
        <tbody>
        <tr>
            <td class="col-md-2">Name</td>
            <td class="col-md-2">Description</td>
            <td class="col-md-2">Cover</td>
            <td class="col-md-1">Quantity</td>
            <td class="col-md-1">Price</td>
            <td class="col-md-1">Status</td>
            <td class="col-md-3">Actions</td>
        </tr>
        </tbody>
        <tbody>
        @foreach ($products as $product)
            <tr>
                <td><a href="{{ route('admin.products.show', $product->id) }}">{{ $product->name }}</a></td>
                <td>{{ $product->description }}</td>
                <td class="text-center">
                    @if(isset($product->cover))
                        <img src="{{ asset("storage/$product->cover") }}" alt="" class="img-responsive">
                    @else
                        -
                    @endif
                </td>
                <td>{{ $product->quantity }}</td>
                <td>Php {{ $product->price }}</td>
                <td>@include('layouts.status', ['status' => $product->status])</td>
                <td>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="delete">
                        <div class="btn-group">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                            <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>
                        </div>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif