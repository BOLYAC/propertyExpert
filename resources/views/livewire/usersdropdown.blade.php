<div>
    <div class="form-group mb-2" wire:ignore>
        <div class="col-form-label">{{ __('Departments') }}</div>
        <select name="department_filter" id="department_filter"
                class="js-example-placeholder-multiple col-sm-12" wire:model="selectedDepartment" multiple>
            <option value="">{{ __('Department') }}</option>
            @foreach($departments as $row)
                <option value="{{ $row->id }}">{{ $row->name }}</option>
            @endforeach
        </select>
    </div>
    @if(!is_null($selectedDepartment))
        <div class="form-group mb-2" wire:ignore>
            <div class="col-form-label">{{ __('Team') }}</div>
            <select name="team_filter" id="team_filter"
                    class="js-example-placeholder-multiple col-sm-12" wire:model="selectedTeam" multiple>
                <option value="">{{ __('Team') }}</option>
                @foreach($teams as $row)
                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                @endforeach
            </select>
        </div>
    @endif
    @if(!is_null($selectedTeam))
        <div class="form-group mb-2" wire:ignore>
            <div class="col-form-label">{{ __('Users') }}</div>
            <select name="user_filter" id="user_filter"
                    class="js-example-placeholder-multiple col-sm-12" multiple>
                <option value="">{{ __('Team') }}</option>
                @foreach($users as $row)
                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                @endforeach
            </select>
        </div>
    @endif

</div>

@push('scripts')

    <script>
        $(document).ready(function () {
            $('#department_filter').on('change', function (e) {
                @this.set('selectedDepartment', $(this).val())
            });
            $('#team_filter').on('change', function (e) {
                @this.set('selectedTeam', $(this).val())
            });
        });
    </script>

@endpush
