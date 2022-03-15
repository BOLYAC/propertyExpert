<div class="card card-with-border mt-4">
    <div class="card-body b-t-primary">
        <div class="order-history dt-ext table-responsive">
            <table id="res-config" class="table task-list-table table-striped table-bordered nowrap"
                   style="width:100%">

                <thead>
                <tr>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Owner') }}</th>
                    <th>{{ __('Sales representative') }}</th>
                    <th>{{ __('Created at') }}</th>
                    <th>{{ __('Result') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($subject->events as $event)
                    <tr>
                        <td>
                            <a href="{{ route('events.show', $event) }}">{{ $event->name }}</a>
                        </td>
                        <td>
                            {{ $event->event_date->format('Y-m-d H:m') }}
                        </td>
                        <td>
                            {{ $event->user->name ?? '' }}
                        </td>
                        <td>
                            @php $sellRep = collect($event->sells_name)->toArray() @endphp
                            @foreach( $sellRep as $name)
                                <span class="badge badge-light-primary">{{ $name }}</span>
                            @endforeach
                        </td>
                        <td>
                            {{ $event->created_at->format('Y-m-d H:m') }}
                        </td>
                        <td>
                            @php
                                $i = $event->results;
                                switch ($i) {
                                case 0:
                                echo __('None');
                                break;
                                case 1:
                                echo __('Under evaluation');
                                break;
                                case 2:
                                echo __('Postponed');
                                break;
                                case 3:
                                echo __('Negative');
                                break;
                                case 4:
                                echo __('Appointment not met');
                                break;
                                case 5:
                                echo __('Reservation');
                                break;
                                case 6:
                                echo __('Reservation Cancellation');
                                break;
                                case 7:
                                echo __('Sale');
                                break;
                                case 8:
                                echo __('Sale Cancellation');
                                break;
                                case 9:
                                echo __('After Sale');
                                break;
                                case 10:
                                echo __('Presentation');
                                break;
                                case 11:
                                echo __('Follow up');
                                break;
                                }
                            @endphp
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

