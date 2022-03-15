<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class RadialNotes extends Component
{

    public $notes, $body_note, $notePin;

    protected $rules = [
        'body_note' => 'required',
    ];

    public function render()
    {
        return view('livewire.radial-notes');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    private function resetInputFields()
    {
        $this->body_note = '';
        $this->notePin = false;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function createNote()
    {
        $this->validate();

        $clientId = session()->get('client_called_id');
        $source = \App\Models\Client::find($clientId);

        $note = [
            'body' => $this->body_note,
            'favorite' => $this->notePin,
            'date' => now(),
            'user_id' => Auth::id(),
            'client_id' => $source->id
        ];



        $note = $source->notes()->create($note);

        if ($note) {

            $this->resetInputFields();

            $this->emit('alert', ['type' => 'success', 'message' => 'Note created successfully!']);
        } else {
            $this->emit('alert', ['type' => 'danger', 'message' => 'There is something wrong!, Please try again.']);
        }

    }
}
