<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        @foreach($breadcrumbs as $breadcrumb)
            @if($loop->last)
                <li><a href="#" class="active">@if(isset($breadcrumb["icon"]))<i
                                class="{{$breadcrumb["icon"]}}"></i> @endif {{$breadcrumb["name"]}}</a></li>
            @else
                <li><a href="{{ $breadcrumb["url"] }}">@if(isset($breadcrumb["icon"]))<i
                                class="{{$breadcrumb["icon"]}}"></i> @endif {{$breadcrumb["name"]}}</a></li>
            @endif
        @endforeach
    </ol>
</section>
