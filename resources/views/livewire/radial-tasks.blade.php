<div>
    <form wire:submit.prevent="createTaskInradial">
        <div class="mt-5">
            <div class="form-group">
                <input wire:model="taskTitle" id="taskTitle" name="taskTitle"
                       class="form-control form-control-sm" type="text"
                       placeholder="{{ __('Task title') }}"/>
                @error('taskTitle')
                <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <input wire:model="taskDate" id="dropper-format"
                       class="form-control form-control-sm"
                       name="taskDate"
                       type="datetime-local"
                       required/>
                @error('taskDate')
                <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <button
            type="submit"
            class="btn btn-xs btn-outline-primary pull-right mb-2"><i
                class="fa fa-save"></i> {{ __('Add Task') }}</button>
    </form>
</div>
