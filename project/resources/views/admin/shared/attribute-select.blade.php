<div class="form-group"><br />
    <label for="weight">Weight </label>
    <div class="form-inline">
        <input type="text" class="form-control col-md-8" id="weight" name="weight" placeholder="0" value="{{ number_format($product->weight, 2) }}">
        <label for="mass_unit" class="sr-only">Mass unit</label>
        <select name="mass_unit" id="mass_unit" class="form-control col-md-4 select2">
            @foreach($weight_units as $key => $unit)
                <option @if($default_weight == $unit) selected="selected" @endif value="{{ $unit }}">{{ $key }} - ({{ $unit }})</option>
            @endforeach
        </select>
    </div>
    <div class="clearfix"></div>
    <small class="text text-warning">optional</small>
</div>