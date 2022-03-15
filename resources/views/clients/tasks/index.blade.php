@foreach($tasks as $task)
    <div class="to-do-list">
        <div class="checkbox-fade fade-in-primary">
            <label class="check-task {{ $task->archive === true ? 'done-task' : '' }} ">
                <input type="checkbox"
                       id="archive-{{$task->id}}"
                       onchange="archiveTask({{$task->id}});"
                    {{ $task->archive === true ? 'checked disabled' : '' }}
                >
                <span class="cr">
                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                </span>
                <span class="col-6">{{ $task->title }}   -   {{ $task->body ?? '' }}</span><small
                    class="col-6"> {{ $task->date->format('Y-m-d') ?? '' }} </small>
            </label>
        </div>
        <div class="f-right">
            <a href="#" class="delete_todolist">
                <i class="icofont icofont-ui-delete"></i>
            </a>
        </div>
    </div>
@endforeach
