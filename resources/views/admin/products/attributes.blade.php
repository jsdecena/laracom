@if(!$productAttributes->isEmpty())
    <ul class="list-unstyled">
        <li>
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Attributes</th>
                    <th>Image</th>
                    <th>Add Image</th>
                    <th>Remove Variation</th>
                </tr>
                </thead>
                <tbody>
                @foreach($productAttributes as $pa)
                    <tr>
                        <td>{{ $pa->id }}</td>
                        <td>{{ $pa->quantity }}</td>
                        <td>{{ $pa->price }}</td>
                        <td>
                            <ul class="list-unstyled">
                                @foreach($pa->attributesValues as $item)
                                    <li>{{ $item->attribute->name }} : {{ $item->value }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td></td>
                        <td>
                            <div class="center">
                                <a href="#" data-toggle="modal" data-target="#squarespaceModal-{{ $pa->id }}" class="btn btn-secondary center-block">Add Image
                                </a>
                            </div>
                            <div class="modal fade" id="squarespaceModal-{{ $pa->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                            <h3 class="modal-title" id="lineModalLabel">Add Variation Image</h3>
                                        </div>
                                        <div class="modal-body">

                                            <!-- content goes here -->
                                            <form>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Product Images</label>
                                                    <div class="row">
                                                        @if(isset($product->cover))
                                                        <div class="col-xs-4">
                                                            <img src="{{ asset("storage/$product->cover") }}" class="img-responsive img-radio">
                                                            <button type="button" class="btn btn-primary btn-radio">Select</button>
                                                            <input type="checkbox" id="left-item" class="hidden" name="product_cover" value="{{ $product->id }}">
                                                        </div>
                                                        @endif
                                                        @if($images && !empty($images))
                                                            @foreach($images as $image)
                                                                    <div class="col-xs-4">
                                                                        <img src="{{ asset("storage/$image->src") }}" class="img-responsive img-radio">
                                                                        <button type="button" class="btn btn-primary btn-radio">Select</button>
                                                                        <input type="checkbox" id="left-item" class="hidden" name="product_image" value="{{ $image->id }}">
                                                                    </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-default">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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