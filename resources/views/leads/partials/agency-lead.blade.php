<div class="card card-with-border">
    <div class="card-header b-t-primary b-b-primary p-2 d-flex justify-content-between">
        @php
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
        @endphp
        <h5 class="mr-auto mt-2">{{ __('Lead') }}
            : {{ $agency->lead_name  ?? '' }}
        </h5>
        <a class="btn btn-sm btn-primary"
           href="{{ route('agencies.show', $agency->origin_id) }}">{{ __('Show') }}</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6">
                <table class="table m-0">
                    <tbody>
                    <tr>
                        <th scope="row">{{ __('Agency type') }}</th>
                        <td>{{ $agency->company_type === 1 ? __('Company') : __('Freelance') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Company name') }}</th>
                        <td>{{ $agency->agency_name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Tax ID') }}</th>
                        <td>{{ $agency->agency_tax_number }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Tax Branch') }}</th>
                        <td>{{ $agency->agency_tax_branch }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Phone number') }}</th>
                        <td>{{ $agency->agency_phone }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Email') }}</th>
                        <td>{{ $agency->agency_email }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- end of table col-lg-6 -->
            <div class="col-md-6">
                <table class="table">
                    <tbody>
                    <tr>
                        <th scope="row">{{ __('Customer Name') }}</th>
                        <td>{{ $agency->customer_name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Customer Passport ID') }}</th>
                        <td>{{ $agency->customer_passport_id }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Customer Phone') }}</th>
                        <td>
                            {{ $agency->lead_phone ??  ''}}
                            <a href="https://wa.me/{{$agency->lead_phone ?? '' }}"
                               target="_blank"
                               class="btn btn-xs btn-outline-success float-right mr-2"><i
                                    class="fa fa-whatsapp"></i></a>

                        </td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Languages') }}</th>
                        <td>
                            @php

                                $cou = '';
                                $countries = collect($agency->language)->toArray();
                                foreach( $countries as $name) {
                                    $cou .=  '<span class="badge badge-dark">' .  $name . '</span>';
                                }
                                echo $cou;
                                
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Budget') }}</th>
                        <td>
                            @php
                                if (is_null($agency->budget_request)) {
                                    echo $agency->getRawOriginal('budget_request') ?? '';
                                } else {
                                    $cou = '';
                                    $budgets = collect($agency->budget_request)->toArray();
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
                    </tbody>
                </table>
            </div>
            <!-- end of table col-lg-6 -->
        </div>
    </div>
</div>
