@if(session('status'))
    <div class="pr-3 pl-3">
        <div class="alert alert-success text-center" role="alert">
            <h5 class="mb-0">{{session('status')}}</h5>
            @if(session('link'))
                <a class="card-link" href="{{session('link')}}">{{session('link')}}</a>
            @endif
        </div>
    </div>
@endif
