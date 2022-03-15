<div class="row">
    <div class="col-md">
        @livewire('notes', ['client' => $company, 'type' => 'company'])
    </div>
    <div class="col-md">
        @livewire('tasks', ['client' => $company, 'type' => 'company'])
    </div>
</div>
