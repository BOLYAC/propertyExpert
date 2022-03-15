@foreach($oldTasks as $oldTask)
    <div class="to-do-list">
        <div class="checkbox-fade fade-in-primary">
            <label class="check-task done-task">
                <input
                    type="checkbox"
                    id="archive-{{$oldTask->id}}"
                    onchange="archivedTask({!! $oldTask->id !!});"
                    {{ $oldTask->archive == 1 ? 'checked' : '' }}
                >
                <span class="cr">
                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                <span>{{ $oldTask->body }}</span>
            </label>
        </div>
        <div class="f-right">
            <a href="#" class="delete_todolist"><i class="icofont icofont-ui-delete"></i></a>
        </div>
    </div>
@endforeach
