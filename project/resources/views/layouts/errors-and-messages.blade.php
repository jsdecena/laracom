@if($errors->all())
    @foreach($errors->all() as $message)
        <div class="box no-border">
            <div class="box-tools">
                <p class="alert alert-warning alert-dismissible">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </p>
            </div>
        </div>
    @endforeach

@elseif(session()->has('message'))
    <div class="box no-border">
        <div class="box-tools">
            <p class="alert alert-success alert-dismissible">
                {{ session()->get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </p>
        </div>
    </div>
@elseif(session()->has('error'))
    <div class="box no-border">
        <div class="box-tools">
            <p class="alert alert-danger alert-dismissible">
                {{ session()->get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </p>
        </div>
    </div>
@endif