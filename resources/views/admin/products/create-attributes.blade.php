<h2>Make combinations</h2>
<div class="form-group">
    <ul class="list-unstyled attribute-lists">
        @foreach($attributes as $attribute)
            <li>
                <label for="attribute{{ $attribute->id }}" class="checkbox-inline">
                    {{ $attribute->name }}
                    <input name="attribute[]" class="attribute" type="checkbox" id="attribute{{ $attribute->id }}" value="{{ $attribute->id }}">
                </label>

                <label for="attributeValue{{ $attribute->id }}" style="display: none; visibility: hidden"></label>
                @if(!$attribute->values->isEmpty())
                    <select name="attributeValue[]" id="attributeValue{{ $attribute->id }}" class="form-control" disabled>
                        @foreach($attribute->values as $attr)
                            <option value="{{ $attr->id }}">{{ $attr->value }}</option>
                        @endforeach
                    </select>
                @endif
            </li>
        @endforeach
    </ul>
</div>
<div class="form-group">
    <label for="productAttributeQuantity">Quantity</label>
    <input type="text" name="productAttributeQuantity" id="productAttributeQuantity" class="form-control" placeholder="Set quantity" disabled>
</div>
<div class="form-group">
    <label for="productAttributePrice">Price</label>
    <div class="input-group">
        <span class="input-group-addon">{{ config('cart.currency') }}</span>
        <input type="text" name="productAttributePrice" id="productAttributePrice" class="form-control" placeholder="Price" disabled>
    </div>
</div>
<div class="box-footer">
    <div class="btn-group">
        <input type="hidden" name="combination" id="combination" value="1" disabled>
        <button type="button" class="btn btn-sm btn-default" onclick="backToInfo()">Back</button>
        <button id="createCombinationBtn" type="submit" class="btn btn-sm btn-primary" disabled="disabled">Create combination</button>
    </div>
</div>