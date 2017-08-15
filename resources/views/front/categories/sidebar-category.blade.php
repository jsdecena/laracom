<ul class="nav sidebar-menu">
    @foreach($categories as $category)
        <li @if(request()->segment(2) == $category->slug) class="active" @endif><a href="{{ route('front.category.slug', $category->slug) }}">{{ $category->name }}</a></li>
    @endforeach
</ul>