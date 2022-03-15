<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;

class EditName extends Component
{
    public $taskId;
    public $origName; // initial task name state
    public $newName; // dirty task name state
    public $isName; // determines whether to display it in bold text

    public function mount(Task $task)
    {
        $this->taskId = $task->id;
        $this->origName = $task->task_body;

        $this->init($task); // initialize the component state
    }

    public function render()
    {
        return view('livewire.edit-name');
    }

    public function save()
    {
        $task = Task::findOrFail($this->taskId);
        $newName = $this->newName;

        $task->task_body = $newName ?? null;
        $task->save();

        $this->init($task); // re-initialize the component state with fresh data after saving
        $this->emit('alert', ['type' => 'success', 'message' => 'Task description updated successfully!']);
    }

    private function init(Task $task)
    {
        $this->origName = $task->task_body;
        $this->newName = $this->origName;
        $this->isName = $task->task_body ?? false;
    }
}
