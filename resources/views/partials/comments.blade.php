<?php $count = 0; ?>
<?php $i = 1 ?>
@foreach($subject->comments as $comment)
    <div class="card card-with-border">
        <div class="card-body">
            <div class="tablet__body tablet__tigthen">
                <p class="smalltext"># {{$i++}}</p>
                <p>  {!! $comment->description !!}</p>
            </div>
            <div class="tablet__footer tablet__tigthen">
                <p class="smalltext">{{ __('Comment by') }}: <a
                        href="{{route('users.show', $comment->user)}}"> {{$comment->user->name}} </a>
                </p>
                <p class="smalltext">{{ __('Created at') }}:
                    {{ date($comment->created_at)}}
                    @if($comment->updated_at != $comment->created_at)
                        <br/>{{ __('Modified') }} : {{date($comment->updated_at)}}
                    @endif</p>
            </div>
        </div>
    </div>
@endforeach

<div class="card card-with-border">
    <div class="card-body">
        <form action="{{  $subject->getCreateCommentEndpoint() }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="summernote">{{ __('Add comment') }}</label>
                <textarea name="description" id="summernote"></textarea>
            </div>
            <button type="submit" class="btn btn-outline-primary">{{ __('Add Comment') }}</button>
        </form>
    </div>
</div>
