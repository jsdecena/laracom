<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        @foreach($breadcumbs as $breadcumb)
            @if($loop->last)
                <li><a href="#" class="active">@if(isset($breadcumb["icon"]))<i
                                class="{{$breadcumb["icon"]}}"></i> @endif {{$breadcumb["name"]}}</a></li>
            @else
                <li><a href="{{ $breadcumb["url"] }}">@if(isset($breadcumb["icon"]))<i
                                class="{{$breadcumb["icon"]}}"></i> @endif {{$breadcumb["name"]}}</a></li>
            @endif
        @endforeach
    </ol>
</section>
