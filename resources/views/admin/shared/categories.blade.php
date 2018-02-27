<ul class="list-unstyled">
    @foreach($categories as $category)
        <li>
            @if(in_array($category->id, $ids))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" checked="checked" name="categories[]" value="{{ $category->id }}"> {{ $category->name }}
                    </label>
                </div>
            @else
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"> {{ $category->name }}
                    </label>
                </div>
            @endif
        </li>
        @if($category->children()->count() >= 1)
            @include('admin.shared.category-children', ['categories' => $category->children, 'ids' => $ids])
        @endif
    @endforeach
</ul>