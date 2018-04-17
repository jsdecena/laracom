<ul class="list-unstyled">
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
        @if($category->children->count() >= 1)
            @include('admin.shared.category-children', ['categories' => $category->children, 'selectedIds' => $selectedIds])
        @endif
    @endforeach
</ul>