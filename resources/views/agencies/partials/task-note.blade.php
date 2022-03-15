<div class="row">
<div class="col-md">
    @livewire('notes', ['client' => $agency, 'type' => 'agency'])
</div>
<div class="col-md">
    @livewire('tasks', ['client' => $agency, 'type' => 'agency'])
</div>
</div>
