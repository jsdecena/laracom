<ul class="list-unstyled" style="padding-left: 25px">
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
    @endforeach
</ul>