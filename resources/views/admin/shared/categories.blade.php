<ul class="checkbox-list">
    @foreach($categories as $category)
        <li>
            <div class="radio">
                <label>
                    <input
                            type="radio"
                            @if(isset($selectedIds) && in_array($category->id, $selectedIds))checked="checked" @endif
                            name="categories[]"
                            value="{{ $category->id }}">
                    {{ $category->name }}
                </label>
            </div>
        </li>
        @if($category->children->count() >= 1)
            @include('admin.shared.categories', ['categories' => $category->children, 'selectedIds' => $selectedIds])
        @endif
    @endforeach
</ul>