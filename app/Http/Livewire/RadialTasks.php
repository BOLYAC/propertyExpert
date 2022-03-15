<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RadialTasks extends Component
{
    public $taskTitle, $taskDate;


    protected $rules = [
        'taskTitle' => 'required|string|min:6',
        'taskDate' => 'required|date',
    ];

    public function render()
    {
        return view('livewire.radial-tasks');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    private function resetInputFields()
    {
        $this->taskTitle = '';
        $this->taskDate = '';
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function createTaskInradial()
    {
        $this->validate();

        $clientId = session()->get('client_called_id');


        $source = \App\Models\Client::find($clientId);

        $task = [
            'title' => $this->taskTitle,
            'date' => $this->taskDate,
            'user_id' => Auth::id(),
            'client_id' => $source->id
        ];

        $task = $source->tasks()->create($task);

        if ($task) {

            $this->resetInputFields();

            $this->emit('alert', ['type' => 'success', 'message' => 'Task created successfully!']);
        } else {
            $this->emit('alert', ['type' => 'danger', 'message' => 'There is something wrong!, Please try again.']);
        }

    }
}
