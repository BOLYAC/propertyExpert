@if ($message = Session::get('success'))
    <div class="alert alert-primary dark" role="alert">
        {{ $message }}
    </div>
@endif

@if($message = Session::get('errors'))
    <div class="alert alert-primary" role="alert">
        <h4 class="alert-heading"></h4>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
@endif
