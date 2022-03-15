<?php

namespace App\Http\Livewire;

use AloTech\Click2;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class AgencyCalls extends Component
{

    public $agency;

    public function render()
    {
        return view('livewire.agency-calls');
    }

    public function makeCall()
    {
        $phone = $this->agency->phone;

        if (is_null($phone)) {
            $this->emit('alert', ['type' => 'danger', 'message' => 'There no phone number']);
            return;
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
        Session::put('client_called_id', $this->agency->id);

        $this->emit('alert', ['type' => 'success', 'message' => 'Call started']);
        $this->dispatchBrowserEvent('radial-status', [
            'radialStatus' => 'open', 'leadNameRadial' => ($this->agency->name ?? '')
        ]);

    }
}
