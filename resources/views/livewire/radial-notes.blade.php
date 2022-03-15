<div>
    <form wire:submit.prevent="createNote">
        <div class="form-group">
            <textarea wire:model="body_note" class="form-control"></textarea>
            @error('body')
            <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-xs btn-outline-primary pull-right">
            {{ __('Add Note') }}
        </button>
    </form>
</div>
