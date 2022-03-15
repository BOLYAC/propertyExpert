<div class="dt-ext table-responsive">
    <table class="stripe hover display" id="report-table">
        @php
            $requirements_request = [
                            ['id' => 1,'text' => 'Investments'],
                            ['id' => 2,'text' => 'Life style'],
                            ['id' => 3,'text' => 'Investments + Life style'],
                            ['id' => 4,'text' => 'Citizenship'],
                        ];
            $budget_request= [
                            ['id' => 1,'text' => 'Less then 50K'],
                            ['id' => 2,'text' => '50K-100K'],
                            ['id' => 3,'text' => '100K-150K'],
                            ['id' => 4,'text' => '150K200K'],
                            ['id' => 5,'text' => '200K-300K'],
                            ['id' => 6,'text' => '300K-400k'],
                            ['id' => 7,'text' => '400k-500K'],
                            ['id' => 8,'text' => '500K-600k'],
                            ['id' => 9,'text' => '600K-1M'],
                            ['id' => 10,'text' => '1M-2M'],
                            ['id' => 11,'text' => 'More then 2M'],
                        ];
            $rooms_request = [
                            ['id' => 1,'text' => '0 + 1'],
                            ['id' => 2,'text' => '1 + 1'],
                            ['id' => 3,'text' => '2 + 1'],
                            ['id' => 4,'text' => '3 + 1'],
                            ['id' => 5,'text' => '4 + 1'],
                            ['id' => 6,'text' => '5 + 1'],
                            ['id' => 7,'text' => '6 + 1'],
                        ];
        @endphp

        <h3>{{ __('Leads') }}</h3>
        <thead>
        <tr>
            @forelse ($fields as $field)
                <th>{{ __('leads-report.' . $field) }}</th>
            @empty
                <p>{{ __('Nothing to show') }}</p>
            @endforelse
        </tr>
        </thead>
        <tbody>
        @foreach ($leads as $lead)
            <tr>
                @foreach ($fields as $field)
                    <td>
                        @if($field == 'status')
                            @php
                                $i = $lead->status;
                                switch ($i) {
                                case 1:
                                echo '<span class="badge badge-light-primary">'.__('New Lead').'</span>';
                                break;
                                case 8:
                                echo '<span class="badge badge-light-primary">'.__('No Answer').'</span>';
                                break;
                                case 12:
                                echo '<span class="badge badge-light-primary">'.__('In progress').'</span>';
                                break;
                                case 3:
                                echo '<span class="badge badge-light-primary">'.__('Potential appointment').'</span>';
                                break;
                                case 4:
                                echo '<span class="badge badge-light-primary">'.__('Appointment set').'</span>';
                                break;
                                case 10:
                                echo '<span class="badge badge-light-primary">'.__('Appointment follow up').'</span>';
                                break;
                                case 5:
                                echo '<span class="badge badge-light-success">'.__('Sold').'</span>';
                                break;
                                case 13:
                                echo '<span class="badge badge-light-danger">'.__('Unreachable').'</span>';
                                break;
                                case 7:
                                echo '<span class="badge badge-light-danger">'.__('Not interested').'</span>';
                                break;
                                case 11:
                                echo '<span class="badge badge-light-danger">'.__('Low budget').'</span>';
                                break;
                                case 9:
                                echo '<span class="badge badge-light-danger">'.__('Wrong Number').'</span>';
                                break;
                                case 14:
                                echo '<span class="badge badge-light-danger">'.__('Unqualified').'</span>';
                                break;
                                case 15:
                                echo '<span class="badge badge-light-warning mr-2">' . __('Lost') . '</span>';
                                break;
                                case 16:
                                echo '<span class="badge badge-light-warning mr-2">' . __('Unassigned') . '</span>';
                                break;
                                case 17:
                                echo '<span class="badge badge-light-primary mr-2">' . __('One Month') . '</span>';
                                break;
                                case 18:
                                echo '<span class="badge badge-light-primary mr-2">' . __('2-3 Months') . '</span>';
                                break;
                                case 19:
                                echo '<span class="badge badge-light-primary mr-2">' . __('Over 3 Months') . '</span>';
                                break;
                                case 20:
                                echo '<span class="badge badge-light-primary mr-2">' . __('In Istanbul') . '</span>';
                                break;
                                case 21:
                                echo '<span class="badge badge-light-primary mr-2">' . __('Agent') . '</span>';
                                break;
                                case 22:
                                echo '<span class="badge badge-light-primary mr-2">' . __('Transferred') . '</span>';
                                break;
                                case 23:
                                echo '<span class="badge badge-light-warning mr-2">' . __('No Answering') . '</span>';
                                break;
                                }
                            @endphp
                        @elseif($field == 'status_new')
                            @php
                                $i = $lead->status_new;
                                switch ($i) {
                                case 1:
                                echo '<span class="badge badge-light-danger">'.__('lost to competition').'</span>';
                                break;
                                case 2:
                                echo '<span class="badge badge-light-danger">'.__('Applied by mistake').'</span>';
                                break;
                                case 3:
                                echo '<span class="badge badge-light-danger">'.__('Budget was not enough').'</span>';
                                break;
                                case 4:
                                echo '<span class="badge badge-light-danger">'. __('Client was looking for something else').'</span>';
                                break;
                                case 5:
                                echo '<span class="badge badge-light-danger">'.__('Decided not to buy in Turkey').'</span>';
                                break;
                                case 6:
                                echo '>span class="badge badge-light-danger">'.__('Wrong contact details').'</span>';
                                break;
                                case 7:
                                echo '<span class="badge badge-light-danger">'.__('Unqualified').'</span>';
                                break;
                                case 8:
                                echo '<span class="badge badge-light-danger">'.__('Unreachable').'</span>';
                                break;
                                case 9:
                                echo '<span class="badge badge-light-danger">'.__('Postponed buying idea').'</span>';
                                break;
                                case 10:
                                echo '<span class="badge badge-light-danger">'.__('Different language').'</span>';
                                break;
                                }
                            @endphp
                        @elseif($field == 'lost_reason_description')
                            {!! $lead->lost_reason_description ?? '' !!}
                        @elseif($field == 'user_id')
                            {{ $lead->user->name ?? '' }}
                        @elseif($field == 'duration_stay')
                            @php
                                $i = $lead->duration_stay;
                                switch ($i) {
                                case 1:
                                echo __('1 Day');
                                break;
                                case 2:
                                echo __('2 Days');
                                break;
                                case 3:
                                echo __('3 Days');
                                break;
                                case 4:
                                echo __('4 Days');
                                break;
                                case 5:
                                echo __('5 Days');
                                break;
                                case 6:
                                echo __('6 Days');
                                break;
                                case 7:
                                echo __('7 Days');
                                break;
                                case 8:
                                echo __('8 Days');
                                break;
                                case 9:
                                echo __('9 Days');
                                break;
                                case 10:
                                echo __('10 Days');
                                break;
                                case 11:
                                echo __('11 Days');
                                break;
                                case 12:
                                echo __('12 Days');
                                break;
                                case 13:
                                echo __('13 Days');
                                break;
                                case 14:
                                echo __('14 Days');
                                break;
                                case 15:
                                echo __('15 Days');
                                break;
                                case 30:
                                echo __('1 Month');
                                break;
                                case 60:
                                echo __('2 Months');
                                break;
                                case 90:
                                echo __('3 Months');
                                break;
                                case 99:
                                echo __('Unspecified');
                                break;
                                }
                            @endphp
                        @elseif($field == 'team_id')
                            {{ $lead->user->currentTeam->name ?? ''}}
                        @elseif($field == 'source_id')
                            {{ $lead->source->name ?? '' }}
                        @elseif($field == 'priority')
                            @php
                                $i = $lead->priority;
                                switch ($i) {
                                case 1:
                                echo '<span class="txt-success f-w-600">'.__('Low').'</span>';
                                break;
                                case 2:
                                echo '<span class="txt-warning f-w-600">'.__('Medium').'</span>';
                                break;
                                case 3:
                                echo '<span class="txt-danger f-w-600">'.__('High').'</span>';
                                break;
                                }
                            @endphp
                        @elseif($field == 'agency_id')
                            {{ $lead->agency->name ?? ''}}
                        @elseif($field == 'description')
                            {!! $lead->description ?? '' !!}
                        @elseif($field == 'country')
                            @php
                                if (is_null($lead->country)) {
                                    echo $lead->getRawOriginal('country') ?? '';
                                } else {
                                    $cou = '';
                                    $countries = collect($lead->country)->toArray();
                                foreach ($countries as $name) {
                                    $cou .= '<span class="badge badge-light-primary">' . $name . '</span><br>';
                                }
                                    echo $cou;
                                }
                            @endphp
                        @elseif($field == 'nationality')
                            @php
                                if (is_null($lead->nationality)) {
                                    echo $lead->getRawOriginal('nationality') ?? '';
                                } else {
                                    $cou = '';
                                    $countries = collect($lead->nationality)->toArray();
                                foreach ($countries as $name) {
                                    $cou .= '<span class="badge badge-light-primary">' . $name . '</span><br>';
                                }
                                    echo $cou;
                                }
                            @endphp
                        @elseif($field == 'lang')
                            @php
                                if (is_null($lead->lang)) {
                                    echo $lead->getRawOriginal('lang') ?? '';
                                } else {
                                    $cou = '';
                                    $countries = collect($lead->lang)->toArray();
                                foreach ($countries as $name) {
                                    $cou .= '<span class="badge badge-light-primary">' . $name . '</span><br>';
                                }
                                    echo $cou;
                                }
                            @endphp
                        @elseif($field == 'requirements_request')
                            @php
                                if (is_null($lead->requirements_request)) {
                                    echo $lead->getRawOriginal('requirements_request') ?? '';
                                } else {
                                    $cou = '';
                                    $requirements = collect($lead->requirements_request)->toArray();
                                    $newArr = array_filter($requirements_request, function($var) use ($requirements){
                                        return in_array($var['id'], $requirements);
                                    });
                                    foreach ($newArr as $val) {
                                            $cou .= '<span class="badge badge-light-primary">' . $val['text'] . '</span><br>';
                                }
                                    echo $cou;
                                }
                            @endphp
                        @elseif($field == 'budget_request')
                            @php
                                if (is_null($lead->budget_request)) {
                                    echo $lead->getRawOriginal('budget_request') ?? '';
                                } else {
                                    $cou = '';
                                    $budgets = collect($lead->budget_request)->toArray();
                                    $newArr = array_filter($budget_request, function($var) use ($budgets){
                                        return in_array($var['id'], $budgets);
                                    });
                                    foreach ($newArr as $val) {
                                        $cou .= '<span class="badge badge-light-primary">' . $val['text'] . '</span><br>';
                                    }
                                        echo $cou;
                                }
                            @endphp
                        @elseif($field == 'rooms_request')
                            @php
                                if (is_null($lead->rooms_request)) {
                                    echo $lead->getRawOriginal('rooms_request') ?? '';
                                } else {
                                    $cou = '';
                                    $rooms = collect($lead->rooms_request)->toArray();
                                    $newArr = array_filter($rooms_request, function($var) use ($rooms){
                                        return in_array($var['id'], $rooms);
                                    });
                                    foreach ($newArr as $val) {
                                        $cou .= '<span class="badge badge-light-primary">' . $val['text'] . '</span><br>';
                                    }
                                    echo $cou;
                                }
                            @endphp
                        @elseif($field == 'tasks')
                            @foreach($lead->tasks as $task)
                                <span class="f-w-600">{{ $task->title ?? '' }}</span>
                                <span class="f-w-400">{{ $task->body ?? '' }}</span>
                                <span
                                    class="text-muted f-w-600">{{ Carbon\Carbon::parse($task->date)->format('d-m-Y H:i') }}</span>
                                <br>
                            @endforeach
                        @elseif($field == 'notes')
                            @foreach($lead->notes as $note)
                                {!! $note->body ?? '' !!}
                                <br>
                                <span
                                    class="text-muted f-w-600">{{ Carbon\Carbon::parse($note->date)->format('d-m-Y H:i') }}</span>
                            @endforeach
                        @else
                            {{ $lead->$field }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
