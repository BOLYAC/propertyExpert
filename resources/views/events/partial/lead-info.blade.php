<div class="card card-with-border">
    <div class="card-header b-t-primary b-b-primary p-2 d-flex justify-content-between">
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
        <h5 class="mr-auto mt-2">{{ __('Lead') }}
            : {{ $client->lead_name ?? $client->client->complete_name ?? '' }}</h5>
        <a class="btn btn-sm btn-primary"
           href="{{ route('leads.show', $client->lead_id) }}">{{ __('Show') }}</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6">
                <table class="table m-0">
                    <tbody>
                    <tr>
                        <th scope="row">{{ __('Full Name') }}</th>
                        <td>{{ $client->lead_name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Country') }}</th>
                        <td>
                            @php
                                if (is_null($client->country)){
                                    echo $client->getRawOriginal('country') ?? '';
                                } else  {
                                    $cou = '';
                                    $countries = collect($client->country)->toArray();
                                foreach( $countries as $name) {
                                    $cou .=  '<span class="badge badge-dark">' .  $name . '</span>';
                                }
                                    echo $cou;
                                }
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Nationality') }}</th>
                        <td>
                            @php
                                if (is_null($client->nationality)){
                                echo $client->getRawOriginal('nationality') ?? '';
                                } else  {
                                $cou = '';
                                $countries = collect($client->nationality)->toArray();
                                foreach( $countries as $name) {
                                $cou .=  '<span class="badge badge-dark">' .  $name . '</span>';
                                }
                                echo $cou;
                                }
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Languages') }}</th>
                        <td>
                            @php
                                if (is_null($client->lang)){
                                    echo $client->getRawOriginal('lang') ?? '';
                                } else  {
                                $cou = '';
                                $countries = collect($client->lang)->toArray();
                                foreach( $countries as $name) {
                                $cou .=  '<span class="badge badge-dark">' .  $name . '</span>';
                                }
                                echo $cou;
                                }
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('Desciption') }}</th>
                        <td>
                            {!! $client->description ?? '' !!}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- end of table col-lg-6 -->
            <div class="col-md-6">
                <table class="table">
                    <tbody>
                    <tr>
                        <th scope="row">{{__('Status')}}</th>
                        <td>
                            @php
                                $i = $client->status_id;
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
                                echo '<span class="badge badge-light-danger">'.__('Lost').'</span>';
                                break;
                                }
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Priority') }}</th>
                        <td>
                            @php
                                $i = $client->priority;
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
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Budget') }}</th>
                        <td>
                            @php
                                if (is_null($client->budget_request)) {
                                    echo $client->getRawOriginal('budget_request') ?? '';
                                } else {
                                    $cou = '';
                                    $budgets = collect($client->budget_request)->toArray();
                                    $newArr = array_filter($budget_request, function($var) use ($budgets){
                                        return in_array($var['id'], $budgets);
                                    });
                                    foreach ($newArr as $val) {
                                        $cou .= '<span class="badge badge-light-primary">' . $val['text'] . '</span><br>';
                                    }
                                        echo $cou;
                                }
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Rooms Request') }}</th>
                        <td>
                            @php
                                if (is_null($client->rooms_request)) {
                                    echo $client->getRawOriginal('rooms_request') ?? '';
                                } else {
                                    $cou = '';
                                    $rooms = collect($client->rooms_request)->toArray();
                                    $newArr = array_filter($rooms_request, function($var) use ($rooms){
                                        return in_array($var['id'], $rooms);
                                    });
                                    foreach ($newArr as $val) {
                                        $cou .= '<span class="badge badge-light-primary">' . $val['text'] . '</span><br>';
                                    }
                                    echo $cou;
                                }
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Requirement') }}</th>
                        <td>
                            @php
                                if (is_null($client->requirement_request)) {
                                    echo $client->getRawOriginal('requirement_request') ?? '';
                                } else {
                                    $cou = '';
                                    $requirements = collect($client->requirements_request)->toArray();
                                    $newArr = array_filter($requirements_request, function($var) use ($requirements){
                                        return in_array($var['id'], $requirements);
                                    });
                                    foreach ($newArr as $val) {
                                            $cou .= '<span class="badge badge-light-primary">' . $val['text'] . '</span><br>';
                                }
                                    echo $cou;
                                }
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Source') }}</th>
                        <td>
                            {{ $client->source_name ?? ''}}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Companies name') }}</th>
                        <td>
                            {{ optional($client)->campaigne_name }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- end of table col-lg-6 -->
        </div>
    </div>
</div>
