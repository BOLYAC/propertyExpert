<div class="card card-with-border">
    <div class="row">
        <div class="col-md">
            @livewire('notes', ['client' => $client, 'type' => 'client'])
        </div>
        <div class="col-md">
            @livewire('tasks', ['client' => $client, 'type' => 'client'])
        </div>
    </div>
</div>

