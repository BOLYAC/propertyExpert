<?php

namespace App\Http\Livewire;

use App\Agency;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Note;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Notes extends Component
{
    public $notes, $body_note, $mode, $client, $updateMode, $noteId, $notePin, $type;

    protected $rules = [
        'body_note' => 'required',
    ];

    public function mount($client)
    {
        $this->mode = 'show';
        $this->client = $client->id;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        $client = $this->client;
        $modelsMapping = [
            'agency' => 'App\Agency',
            'client' => 'App\Models\Client',
            'lead' => 'App\Models\Lead',
            'company' => 'App\Models\Company',
        ];
        $model = $modelsMapping[$this->type];
        $this->notes = Note::whereHasMorph(
            'Noteable',
            [$model],
            function ($query, $type) use ($client) {
                if ($type === Agency::class) {
                    $query->where('id', $client);
                }
                if ($type === Client::class) {
                    $query->where('id', $client);
                }
                if ($type === Lead::class) {
                    $query->where('id', $client);
                }
            }
        )->get()->sortByDesc('date')->sortByDesc('favorite');
        return view('livewire.notes');
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

        $modelsMapping = [
            'agency' => 'App\Agency',
            'client' => 'App\Models\Client',
            'company' => 'App\Models\Company',
        ];

        if (!array_key_exists($this->type, $modelsMapping)) {
            Session::flash('flash_message_warning', __('Could not create document, type not found! Please contact support'));
            throw new Exception("Could not create comment with type " . $this->type);
            return redirect()->back();
        }

        $model = $modelsMapping[$this->type];
        $source = $model::where('id', '=', $this->client)->first();

        $note = [
            'body' => $this->body_note,
            'favorite' => $this->notePin,
            'date' => now(),
            'user_id' => Auth::id(),
        ];

        if ($this->type == 'agency') {
            $task['agency_id'] = $this->client;
        }
        if ($this->type == 'client') {
            $task['client_id'] = $this->client;
        }
        if ($this->type == 'lead') {
            $task['lead_id'] = $this->client;
        }


        $note = $source->notes()->create($note);

        if ($note) {

            $this->updateMode('show');

            $this->resetInputFields();

            $this->emit('alert', ['type' => 'success', 'message' => 'Note created successfully!']);
        } else {
            $this->emit('alert', ['type' => 'danger', 'message' => 'There is something wrong!, Please try again.']);
        }

    }

    public function pinNote($noteId)
    {
        $note = Note::find($noteId);
        $note->favorite = !$note->favorite;
        $note->update();
        $this->emit('alert', ['type' => 'success', 'message' => 'Note add to favorite']);
    }

    public function updateMode($mode)
    {
        $this->mode = $mode;
    }

    public function deleteNote($noteId)
    {
        $note = Note::findOrFail($noteId);
        $note->delete();
        $this->emit('alert', ['type' => 'success', 'message' => 'Note deleted successfully!']);

    }
}
