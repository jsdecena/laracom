<section class="subscribe-section t100">
    @if(session()->has('message'))
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
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h3>Join 100,000 people already collaborating </h3>
                <p>This e-commerce app is licenced with MIT and can be forked in Github <i class="fa fa-heart text-danger"></i><br />So what are you waiting for? Set an online shop <strong>NOW!</strong></p>
                <form action="{{route('mailchimp.store')}}" class="form-inline form-field-section" method="post">
                    {{csrf_field()}}
                    <input type="email" name="email" class="newsletter-input subscribe-form-control" placeholder="Your email address" value="">
                    <button type="submit" class="btn btn-subscribe">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</section>