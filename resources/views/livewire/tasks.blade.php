@if($mode === 'show')
    <div class="card">
        <div class="card-header b-t-primary b-b-primary p-2 d-flex justify-content-between">
            <h6 class="mb-0 f-w-600">{{ __('Tasks') }}</h6>
            @can('task-create')
                <button wire:click="updateMode('create')" class="btn btn-outline-primary btn-sm">
                    {{ __('Add new task') }} <i class="icon-plus"></i>
                </button>
            @endcan
        </div>
        <div class="card-body">
            <div class="todo">
                <div class="todo-list-wrapper">
                    <div class="todo-list-container">
                        <div class="todo-list-body">
                            <ul id="todo-list">
                                @if($mode === 'show')
                                    @foreach($tasks as $task)
                                        <li class="{{ $task->archive === true ? 'completed' : '' }} task">
                                            <div class="task-container">
                                                <h4 class="task-label">{{ $task->title }}
                                                    @php
                                                        $d = $task->task_priority;
                                                        switch ($d) {
                                                        case 1:
                                                        echo '<span class="badge badge-light-danger ml-2" > ' . __('High') . ' </span > ';
                                                        break;
                                                        case 2:
                                                        echo '<span class="badge badge-light-warning ml-2" > ' . __('Medium') . ' </span > ';
                                                        break;
                                                        case 3:
                                                        echo '<span class="badge badge-light-success ml-2" > ' . __('Low') . ' </span > ';
                                                        break;
                                                        };
                                                    @endphp
                                                </h4>
                                                <div class="flex items-center justify-between -mx-2 hover:bg-gray-100">
                                                    <div
                                                        class="flex items-center justify-between w-full">
                                                        <div class="p-2">
                                                            <span
                                                                class="border-bottom-danger dotted">{{ $task->body }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="float-left mt-2">
                                                <span
                                                    class="badge badge-light-success badge-lg">{{ $task->user->name}}
                                                </span>
                                                    <a href="#"
                                                       id="assign_task"
                                                       data-id="{{ $task->id }}"><i
                                                            class="icofont icofont-plus f-w-600"></i>
                                                    </a>
                                                    <span
                                                        class="text-muted ml-2 f-w-600">{{ Carbon\Carbon::parse($task->date)->format('d-m-Y H:i') }}</span>
                                                </div>
                                                <span class="task-action-btn">
                                                <span wire:click="deleteTask({{ $task->id }})"
                                                      class="action-box large" title="Delete Task">
                                                    <i class="icon"><i class="icon-trash"></i></i>
                                                </span>
                                                <span wire:click="archive({{ $task->id }})"
                                                      class="action-box large"
                                                      title="{{ $task->archive === true ? 'Mark Complete' : 'Mark Incomplete' }}">
                                                    <i class="icon"><i class="icon-check"></i></i>
                                                </span>
                                            </span>

                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@if($mode === 'create')
    <div class="card">
        <div class="card-header b-t-primary b-b-primary p-2 d-flex justify-content-between">
            <h6 class="mb-0 f-w-600">{{ __('Add task') }}</h6>
            <button wire:click="updateMode('show')" class="btn btn-outline-primary btn-sm"><i
                    class="icon-arrow-left"></i> {{ __('Return to tasks list') }}
            </button>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="createTask">
                <div class="form-group mb-4 m-checkbox-inline mb-0 custom-radio-ml">
                    <div class="radio radio-primary">
                        <input wire:model="task_entry" id="task_entry" type="radio"
                               name="task_entry"
                               value="inbound">
                        <label class="mb-0" for="task_entry">{{ __('Inbound') }}</label>
                    </div>
                    <div class="radio radio-primary">
                        <input wire:model="task_entry" type="radio" name="task_entry"
                               id="radioinline2" value="outbound">
                        <label class="mb-0" for="radioinline2">{{ __('Outbound') }}</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title">{{ __('Priority') }}</label>
                    <select wire:model="task_priority" id="task_priority" name="task_priority"
                            class="form-control form-control-sm">
                        <option value=""> -- --</option>
                        <option value="1">{{ __('High') }}</option>
                        *
                        <option value="2">{{ __('Medium') }}</option>
                        <option value="3">{{ __('Low') }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">{{ __('How') }}</label>
                    <select wire:model="contact_type" id="contact_type" name="contact_type"
                            class="form-control form-control-sm" type="text">
                        <option value=""> -- --</option>
                        <option value="1">{{ __('Call') }}</option>
                        <option value="2">{{ __('Email') }}</option>
                        <option value="3">{{ __('Whatsapp') }}</option>
                        <option value="4">{{ __('WhatsApp Call') }}</option>
                    </select>
                    @error('contact_type')
                    <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="title">{{ __('Date') }}</label>
                    <input wire:model="date" id="dropper-format" class="form-control form-control-sm" name="date"
                           type="datetime-local"
                           required/>
                    @error('date')
                    <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <input type="hidden" name="client_id" value="{{ $client }}">
                <button type="submit" class="btn btn-outline-primary">
                    Submit
                </button>
            </form>
        </div>
    </div>
@endif
