<ul class="list-unstyled" style="padding-left: 25px">
    @foreach($categories as $category)
        <li>
            <div class="checkbox">
                <label>
                    <input
                            type="checkbox"
                            @if(isset($selectedIds) && in_array($category->id, $selectedIds))checked="checked" @endif
                            name="categories[]"
                            value="{{ $category->id }}">
                            {{ $category->name }}
                </label>
            </div>
        </li>
    @endforeach
</ul>