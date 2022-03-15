<div class="flex items-center justify-between -mx-2 hover:bg-gray-100">
    <div
        class="flex items-center justify-between w-full"
        x-data="
            {
                 isEditing: false,
                 isName: '{{ $isName }}',
                 focus: function() {
                    const textInput = this.$refs.textInput;
                    textInput.focus();
                    textInput.select();
                 }
            }
        "
        x-cloak
    >
        <div
            class="p-2"
            x-show=!isEditing
        >
            <span
                class="border-bottom-danger dotted"
                x-bind:class="{ 'f-w-400': isName }"
                x-on:click="isEditing = true; $nextTick(() => focus())"
            >{{ $origName ?? 'Description For the task' }}</span>
        </div>
        @can('edit-description-task')
            <div x-show=isEditing class="flex flex-col mb-2">
                <form class="flex" wire:submit.prevent="save">
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            x-ref="textInput"
                            wire:model.lazy="newName"
                            x-on:keydown.enter="isEditing = false"
                            x-on:keydown.escape="isEditing = false"
                        >
                        <div class="input-group-append">
                            <button type="button" class="px-1 ml-2 btn btn-warning btn-xs" title="Cancel"
                                    x-on:click="isEditing = false"><i class="fa fa-ban"></i>
                            </button>
                            <button
                                type="submit"
                                class="px-1 ml-1 btn btn-success btn-xs"
                                title="Save"
                                x-on:click="isEditing = false"
                            ><i class="fa fa-check"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <small class="text-xs">Enter to save, Esc to cancel</small>
            </div>
        @endcan
    </div>
</div>
