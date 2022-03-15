<?php

namespace App\Http\Livewire;

use AloTech\Click2;
use App\Agency;
use App\Models\Source;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Client extends Component
{

    public $mode, $client, $updateMode, $sources, $agencies;

    public $budget_request_list = [
        ['id' => 1, 'text' => 'Less then 50K'],
        ['id' => 2, 'text' => '50K-100K'],
        ['id' => 3, 'text' => '100K-150K'],
        ['id' => 4, 'text' => '150K200K'],
        ['id' => 5, 'text' => '200K-300K'],
        ['id' => 6, 'text' => '300K-400k'],
        ['id' => 7, 'text' => '400k-500K'],
        ['id' => 8, 'text' => '500K-600k'],
        ['id' => 9, 'text' => '600K-1M'],
        ['id' => 10, 'text' => '1M-2M'],
        ['id' => 11, 'text' => 'More then 2M'],
    ];
    public $rooms_request_list = [
        ['id' => 1, 'text' => '0 + 1'],
        ['id' => 2, 'text' => '1 + 1'],
        ['id' => 3, 'text' => '2 + 1'],
        ['id' => 4, 'text' => '3 + 1'],
        ['id' => 5, 'text' => '4 + 1'],
        ['id' => 6, 'text' => '5 + 1'],
        ['id' => 7, 'text' => '6 + 1'],
    ];
    public $requirements_request_list = [
        ['id' => 1, 'text' => 'Investments'],
        ['id' => 2, 'text' => 'Life style'],
        ['id' => 3, 'text' => 'Investments + Life style'],
        ['id' => 4, 'text' => 'Citizenship'],
    ];
    public $country_edit, $nationality_edit, $lang_edit, $description_edit,
        $status_edit, $lost_reason_edit, $lost_reason_description_edit, $priority_edit, $budget_request_edit, $rooms_request_edit,
        $requirements_request_edit, $source_id_edit, $campaign_name_edit, $agency_id_edit,
        $appointment_date_edit, $duration_stay_edit = [], $phone_number_edit, $phone_number_2_edit, $full_name_edit;

    protected $rules = [
        'status_edit' => 'required',
        'lost_reason_edit' => 'required_if:status_edit,15',
        'lost_reason_description_edit' => 'required_if:status_edit,15'
    ];

    protected $messages = [
        'status_edit' => 'The Status cannot be empty.',
        'lost_reason_edit' => 'The lost reason field is required when status is lost.',
        'lost_reason_edit.required_if' => 'This cannot be blank',
        'lost_reason_description_edit' => 'The lost reason description field is required when status is Lost.',
        'lost_reason_description_edit.required_if' => 'This cannot be blank',
    ];

    protected $validationAttributes = [
        'status_edit' => 'status',
        'lost_reason_edit' => 'lost reason',
        'lost_reason_description_edit' => 'lost reason description'
    ];


    public function mount($client)
    {
        $this->mode = 'show';
        $this->sources = Source::all();
        $this->country_edit = $client->country;
        $this->nationality_edit = $client->nationality;
        $this->lang_edit = $client->lang;
        $this->description_edit = $client->description;
        $this->status_edit = $client->status;
        $this->lost_reason_edit = $client->status_new;
        $this->lost_reason_description_edit = $client->lost_reason_description;
        $this->priority_edit = $client->priority;
        $this->budget_request_edit = $client->budget_request;
        $this->rooms_request_edit = $client->rooms_request;
        $this->requirements_request_edit = $client->requirements_request;
        $this->source_id_edit = $client->source_id;
        $this->campaign_name_edit = $client->campaign_name;
        $this->agency_id_edit = $client->agency_id;
        $this->appointment_date_edit = $client->appointment_date;
        $this->duration_stay_edit = $client->duration_stay;
        $this->phone_number_edit = $client->client_number;
        $this->phone_number_2_edit = $client->client_number_2;
        $this->full_name_edit = $client->full_name;
    }

    public function render()
    {
        return view('livewire.client')->extends('layouts.vertical.master');
    }

    public function updateMode($mode)
    {
        $this->mode = $mode;
    }

    public function editLead()
    {
        $this->validate();

        $oldStatus = $this->client->status;

        $data = [
            'country' => $this->country_edit,
            'nationality' => $this->nationality_edit,
            'lang' => $this->lang_edit,
            'description' => $this->description_edit,
            'status' => $this->status_edit,
            'status_new' => $this->lost_reason_edit,
            'lost_reason_description' => $this->lost_reason_description_edit,
            'priority' => $this->priority_edit,
            'budget_request' => $this->budget_request_edit,
            'rooms_request' => $this->rooms_request_edit,
            'requirements_request' => $this->requirements_request_edit,
            'source_id' => $this->source_id_edit,
            'campaigne_name' => $this->campaign_name_edit,
            'agency_id' => $this->agency_id_edit,
            'appointment_date' => $this->appointment_date_edit,
            'duration_stay' => $this->duration_stay_edit,
            'client_number' => $this->phone_number_edit,
            'client_number_2' => $this->phone_number_2_edit,
            'full_name' => $this->full_name_edit
        ];

        if ($data) {
            $this->client->update($data);

            if ($data['status'] !== $oldStatus) {
                $i = $data['status'];
                switch ($i) {
                    case 1:
                        $status = 'New Lead';
                        break;
                    case 8:
                        $status = 'No Answer';
                        break;
                    case 12:
                        $status = 'In progress';
                        break;
                    case 3:
                        $status = 'Potential appointment';
                        break;
                    case 4:
                        $status = 'Appointment set';
                        break;
                    case 10:
                        $status = 'Appointment follow up';
                        break;
                    case 5:
                        $status = 'Sold';
                        break;
                    case 13:
                        $status = 'Unreachable';
                        break;
                    case 7:
                        $status = 'Not interested';
                        break;
                    case 11:
                        $status = 'Low budget';
                        break;
                    case 9:
                        $status = 'Wrong Number';
                        break;
                    case 14:
                        $status = 'Unqualified';
                        break;
                    case 15:
                        $status = 'Lost';
                        break;
                    case 16:
                        $status = 'Unassigned';
                        break;
                    case 17:
                        $status = 'One Month';
                        break;
                    case 18:
                        $status = '2-3 Months';
                        break;
                    case 19:
                        $status = 'Over 3 Months';
                        break;
                    case 20:
                        $status = 'In Istanbul';
                        break;
                    case 21:
                        $status = 'Agent';
                        break;
                    case 22:
                        $status = 'Transferred';
                        break;
                    case 23:
                        $status = 'No Answering';
                        break;
                }
                $this->client->StatusLog()->create([
                    'status_name' => $status,
                    'updated_by' => \auth()->id(),
                    'user_name' => \auth()->user()->name,
                    'status_id' => $data['status']
                ]);
            }
            $this->updateMode('show');
            $this->emit('alert', ['type' => 'success', 'message' => 'Lead updated successfully!']);
        } else {
            $this->emit('alert', ['type' => 'danger', 'message' => 'There is something wrong!, Please try again.']);
        }
    }

    public function makeCall($phone)
    {

        if ($phone === 'ph1') {
            $phone = $this->client->client_number;
        } else {
            $phone = $this->client->client_number_2;
        }

        if (session()->has('current_call')) {
            $this->emit('alert', ['type' => 'danger', 'message' => 'Already in Call']);
            return;
        }

        $aloTech = Session::get('alotech');
        $phoneNumber = $phone;
        $click2 = new Click2($aloTech);

        $res = $click2->call([
            'phonenumber' => $phoneNumber,
            'hangup_url' => 'http://crm.hashim.com.tr/',
            'masked' => '1'
        ]);

        Session::put('current_call', $click2);
        Session::put('client_called_id', $this->client->id);

        $this->emit('alert', ['type' => 'success', 'message' => 'Call started']);
        $this->dispatchBrowserEvent('radial-status', [
            'radialStatus' => 'open', 'leadNameRadial' => ($this->client->complete_name ?? $this->client->full_name)
        ]);

    }
}
