@foreach($subs as $sub)
    <a href="{{ route('front.category.slug', $category->slug) }}">{{ $category->name }}</a>
    <ul class="list-unstyled sidebar-category-sub">
        <li @if(request()->segment(2) == $sub->slug) class="active" @endif ><a href="{{ route('front.category.slug', $sub->slug) }}">{{ $sub->name }}</a></li>
    </ul>
@endforeach