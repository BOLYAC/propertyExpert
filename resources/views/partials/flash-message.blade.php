@if ($message = Session::get('success'))
    <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>Success
            ! </strong> {{ $message }}
        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
    </div>
@endif

@if($message = Session::get('errors'))
    <div class="alert alert-warning dark alert-dismissible fade show" role="alert">
        <strong>Error !</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
    </div>
@endif
