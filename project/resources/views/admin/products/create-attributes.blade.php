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
                    <select name="attributeValue[]" id="attributeValue{{ $attribute->id }}" class="form-control select2" style="width: 100%" disabled>
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
    <label for="productAttributeQuantity">Quantity <span class="text text-danger">*</span></label>
    <input type="text" name="productAttributeQuantity" id="productAttributeQuantity" class="form-control" placeholder="Set quantity" disabled>
</div>
<div class="form-group">
    <label for="productAttributePrice">Price</label>
    <div class="input-group">
        <span class="input-group-addon">{{ config('cart.currency') }}</span>
        <input type="text" name="productAttributePrice" id="productAttributePrice" class="form-control" placeholder="Price" disabled>
    </div>
</div>
<div class="form-group">
    <label for="salePrice">Sale Price</label>
    <div class="input-group">
        <span class="input-group-addon">{{ config('cart.currency') }}</span>
        <input type="text" name="salePrice" id="salePrice" class="form-control" placeholder="Sale Price" disabled>
    </div>
</div>
<div class="form-group">
    <label for="default">Show as default price?</label> <br />
    <select name="default" id="default" class="form-control select2">
        <option value="0" selected="selected">No</option>
        <option value="1">Yes</option>
    </select>
</div>
<div class="box-footer">
    <div class="btn-group">
        <button type="button" class="btn btn-sm btn-default" onclick="backToInfoTab()">Back</button>
        <button id="createCombinationBtn" type="submit" class="btn btn-sm btn-primary" disabled="disabled">Create combination</button>
    </div>
</div>