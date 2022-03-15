<div class="dt-ext table-responsive">
    <table class="stripe hover display" id="report-table">
        <h3>{{ __('Companies') }}</h3>
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
        @foreach ($companies as $company)
            <tr>
                @foreach ($fields as $field)
                    <td>
                        @if($field == 'user_id')
                            {{ $company->user->name ?? '' }}
                        @elseif($field == 'team_id')
                            {{ $company->user->currentTeam->name ?? ''}}
                        @elseif($field == 'source_id')
                            {{ $company->source->name ?? '' }}
                        @elseif($field == 'address')
                            {!! $company->address ?? '' !!}
                        @elseif($field == 'description')
                            {!! $company->description ?? '' !!}
                        @elseif($field == 'tasks')
                            @foreach($company->tasks as $task)
                                <span class="f-w-600">{{ $task->title ?? '' }}</span>
                                <span class="f-w-400">{{ $task->body ?? '' }}</span>
                                <span
                                    class="text-muted f-w-600">{{ Carbon\Carbon::parse($task->date)->format('d-m-Y H:i') }}</span>
                                <br>
                            @endforeach
                        @elseif($field == 'notes')
                            @foreach($company->notes as $note)
                                {!! $note->body ?? '' !!}
                                <br>
                                <span
                                    class="text-muted f-w-600">{{ Carbon\Carbon::parse($note->date)->format('d-m-Y H:i') }}</span>
                            @endforeach
                        @else
                            {{ $company->$field }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
