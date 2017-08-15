<h2>Categories</h2>
@foreach($categories as $key => $category)
    @if(in_array($category->id, $selectCategories))
        <div class="checkbox">
            <label>
                <input type="checkbox" checked="checked" name="categories[]" value="{{ $category->id ?: old('name') }}"> {{ $category->name }}
            </label>
        </div>
    @else
        <div class="checkbox">
            <label>
                <input type="checkbox" name="categories[]" value="{{ $category->id ?: old('name') }}"> {{ $category->name }}
            </label>
        </div>
    @endif
@endforeach