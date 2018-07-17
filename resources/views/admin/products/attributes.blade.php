@if(!$productAttributes->isEmpty())
    <p class="alert alert-info">You can only set 1 default combination</p>
    <ul class="list-unstyled">
        <li>
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Sale Price</th>
                    <th>Attributes</th>
                    <th>Is default?</th>
                    <th>Remove</th>
                </tr>
                </thead>
                <tbody>
                @foreach($productAttributes as $pa)
                    <tr>
                        <td>{{ $pa->id }}</td>
                        <td>{{ $pa->quantity }}</td>
                        <td>{{ $pa->price }}</td>
                        <td>{{ $pa->sale_price }}</td>
                        <td>
                            <ul class="list-unstyled">
                                @foreach($pa->attributesValues as $item)
                                    <li>{{ $item->attribute->name }} : {{ $item->value }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @if($pa->default == 1)
                                <button class="btn btn-success"><i class="fa fa-check"></i></button>
                            @else
                                <button class="btn btn-danger"><i class="fa fa-remove"></i></button>
                            @endif
                        </td>
                        <td class="btn-group">
                            <a
                                    onclick="return confirm('Are you sure?')"
                                    href="{{ route('admin.products.edit', [$product->id, 'combination' => 1, 'delete' => 1, 'pa' => $pa->id]) }}"
                                    class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </li>
    </ul>
@else
    <p class="alert alert-warning">No combination yet.</p>
@endif