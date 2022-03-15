<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Department;
use App\Models\Team;
use App\Models\User;

class Usersdropdown extends Component
{

    public $departments;
    public $teams;
    public $users;

    public $selectedDepartment = NULL;
    public $selectedTeam = NULL;

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function mount()
    {
        $this->departments = Department::all();
        $this->teams = collect();
        $this->users = collect();
    }

    public function render()
    {
        return view('livewire.usersdropdown');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function updatedSelectedDepartment($department)
    {
        $this->teams = Team::whereIn('department_id', $department)->get();
        $this->teams = null;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function updatedSelectedTeam($team)
    {
        if (!is_null($team)) {
            $this->users = User::whereIn('team_id', $team)->get();
        }
    }
}
