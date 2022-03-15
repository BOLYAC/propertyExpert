@if($mode === 'edit')
    <div>
        <div class="card-header b-t-primary b-b-primary p-2 d-flex justify-content-between">
            @if($client->id === auth()->id() || auth()->user()->hasRole('Admin') || auth()->hasRole('Call center HP'))
                <h5 class="mr-auto mt-2">{{ __('Editing Lead') }}
                    : {{ $client->full_name ?? $client->complete_name ?? '' }}</h5>
            @endif
            <button wire:click="updateMode('show')" class="btn btn-sm btn-warning mr-2"><i
                    class="icon-arrow-left"></i> {{ __('Back') }}</button>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="editLead">
                <div class="row">
                    <div class="col-md">
                        @if(auth()->id() === 31 || auth()->id() === 125 || auth()->id() === 1 || auth()->id() === 8)
                            <div class="form-group">
                                <label for="">{{ __('Full name') }}</label>
                                <input type="text" class="form-control form-control-sm"
                                       wire:model="full_name_edit"
                                       value="{{ $full_name_edit }}">
                            </div>
                            <div class="form-group">
                                <label for="">{{ __('Phone number Format (+90xxxxxxxxx)') }}</label>
                                <input type="text" class="form-control form-control-sm"
                                       pattern="[+ 0-9]{12}"
                                       wire:model="phone_number_edit"
                                       value="{{ $phone_number_edit }}">
                            </div>
                            <div class="form-group">
                                <label for="">{{ __('Phone number 2 Format (+90xxxxxxxxx)') }}</label>
                                <input type="text" class="form-control form-control-sm"
                                       pattern="[+ 0-9]{12}"
                                       wire:model="phone_number_2_edit"
                                       value="{{ $client->phone_number_2_edit }}">
                            </div>
                        @else
                            @if(is_null($phone_number_edit))
                                <div class="form-group">
                                    <label for="">{{ __('Phone number Format (+90xxxxxxxxx)') }}</label>
                                    <input type="text" class="form-control form-control-sm"
                                           pattern="[+ 0-9]{12}"
                                           wire:model="phone_number_edit"
                                           value="{{ $phone_number_edit }}">
                                </div>
{{--                                <input type="text" wire:model="bank_account" wire:change="formatBankAccount"  wire:keyup="formatBankAccount"><br />--}}
{{--                                @error('bank_account') <span class="text-red-500">{{ $message }}</span>@enderror--}}
                            @endif
                            @if(is_null($client->phone_number_2_edit))
                                <div class="form-group">
                                    <label for="">{{ __('Phone number 2 Format (+90xxxxxxxxx)') }}</label>
                                    <input type="text" class="form-control form-control-sm"
                                           pattern="[+ 0-9]{12}"
                                           wire:model="phone_number_2_edit"
                                           value="{{ $client->phone_number_2_edit }}">
                                </div>
                            @endif
                        @endif
                        <div class="form-group input-group-sm" wire:ignore>
                            <label for="country">{{ __('Country') }}</label>
                            <select class="js-country-all custom-select custom-select-sm"
                                    id="country" multiple wire:model="country_edit">
                                @php $clientCountry = collect($country_edit)->toArray() @endphp
                                @foreach($clientCountry as $lang)
                                    <option value="{{ $lang }}" selected>
                                        {{ $lang }}</option>
                                @endforeach
                            </select>
                            <script>
                                $('.js-country-all').select2({
                                    theme: 'classic',
                                    ajax: {
                                        url: "{{ route('country.name') }}",
                                        dataType: 'json',
                                        delay: 250,
                                        processResults: function (data) {
                                            return {
                                                results: $.map(data, function (item) {
                                                    return {
                                                        text: item.name,
                                                        id: item.name
                                                    }
                                                })
                                            };
                                        },
                                        cache: true
                                    }
                                });
                                $('.js-country-all').on('change', function (e) {
                                    var data = $('.js-country-all').select2("val");
                                @this.set('country_edit', data);
                                });
                            </script>
                            @if(is_null($client->country))
                                <div class="col-form-label">
                                    Old: {{ $client->getRawOriginal('country') ?? '' }}</div>
                            @endif
                        </div>
                        <div class="form-group input-group-sm" wire:ignore>
                            <label for="nationality">{{ __('Nationality') }}</label>
                            <select
                                class="js-nationality-all custom-select custom-select-sm"
                                multiple="multiple" wire:model="nationality_edit"
                                id="nationality">
                                <script>
                                    $('.js-nationality-all').select2({
                                        theme: 'classic',
                                        ajax: {
                                            url: "{{ route('nationality.name') }}",
                                            dataType: 'json',
                                            delay: 250,
                                            processResults: function (data) {
                                                return {
                                                    results: $.map(data, function (item) {
                                                        return {
                                                            text: item.name,
                                                            id: item.name
                                                        }
                                                    })
                                                };
                                            },
                                            cache: true
                                        }
                                    });
                                    $('.js-nationality-all').on('change', function (e) {
                                        var data = $('.js-nationality-all').select2("val");
                                    @this.set('nationality_edit', data);
                                    });
                                </script>
                                @php $clientNationality = collect($nationality_edit)->toArray() @endphp
                                @foreach($clientNationality as $nat)
                                    <option value="{{ $nat }}" selected>
                                        {{ $nat }}</option>
                                @endforeach
                            </select>
                            @if(is_null($client->country))
                                <div class="col-form-label">
                                    Old: {{ $client->getRawOriginal('nationality') ?? '' }}</div>
                            @endif
                        </div>
                        <div class="form-group input-group-sm" wire:ignore>
                            <label for="lang">{{ __('Languages') }}</label>
                            <select class="js-language-all custom-select custom-select-sm"
                                    multiple="multiple" wire:model="lang_edit" id="lang">
                                <script>
                                    $('.js-language-all').select2({
                                        theme: 'classic',
                                        ajax: {
                                            url: "{{ route('language.name') }}",
                                            dataType: 'json',
                                            delay: 250,
                                            processResults: function (data) {
                                                return {
                                                    results: $.map(data, function (item) {
                                                        return {
                                                            text: item.name,
                                                            id: item.name
                                                        }
                                                    })
                                                };
                                            },
                                            cache: true
                                        }
                                    });
                                    $('.js-language-all').on('change', function (e) {
                                        let data = $('.js-language-all').select2("val");
                                    @this.set('lang_edit', data);
                                    });
                                </script>
                                @php $clientLang = collect($lang_edit)->toArray() @endphp
                                @foreach( $clientLang as $lang)
                                    <option value="{{ $lang }}" selected>
                                        {{ $lang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" wire:ignore>
                            <textarea x-data wire:model.lazy="description_edit"
                                      id="summernote">{!! $description_edit !!}</textarea>
                            <script>
                                $('#summernote').summernote({
                                    tabsize: 2,
                                    height: 200,
                                    toolbar: [
                                        ['style', ['style']],
                                        ['font', ['bold', 'underline', 'clear']],
                                        ['color', ['color']],
                                        ['para', ['ul', 'ol', 'paragraph']],
                                    ],
                                    callbacks: {
                                        onChange: function (contents, $editable) {
                                        @this.set('description_edit', contents);
                                        }
                                    }
                                })
                            </script>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="row">
                            <div class="form-group col-md-12 col-lg-6">
                                <label for="status">{{ __('Status') }}</label>
                                <select wire:model="status_edit" id="status"
                                        class="custom-select custom-select-sm">
                                    <option value="" selected> {{ __('-- Client status --') }}
                                    </option>
                                    @if(auth()->user()->current_team_id === 3 || auth()->user()->current_team_id === 17)
                                        <option
                                            value="1" {{ old('status', $client->status) == 1 ? 'selected' : '' }}>
                                            {{ __('New Lead') }}
                                        </option>
                                        <option
                                            value="8" {{ old('status', $client->status) == 8 ? 'selected' : '' }}>
                                            {{ __('No Answer') }}
                                        </option>
                                        <option
                                            value="12" {{ old('status', $client->status) == 12 ? 'selected' : '' }}>
                                            {{ __('In progress') }}
                                        </option>
                                        <option
                                            value="3" {{ old('status', $client->status) == 3 ? 'selected' : '' }}>
                                            {{ __('Potential appointment') }}
                                        </option>
                                        <option
                                            value="4" {{ old('status', $client->status) == 4 ? 'selected' : '' }}>
                                            {{ __('Appointment set') }}
                                        </option>
                                        <option
                                            value="10" {{ old('status', $client->status) == 10 ? 'selected' : '' }}>
                                            {{ __('Appointment follow up') }}
                                        </option>
                                        <option
                                            value="5" {{ old('status', $client->status) == 5 ? 'selected' : '' }}>
                                            {{ __('Sold') }}
                                        </option>
                                        <option
                                            value="13" {{ old('status', $client->status) == 13 ? 'selected' : '' }}>
                                            {{ __('Unreachable') }}
                                        </option>
                                        <option
                                            value="7" {{ old('status', $client->status) == 7 ? 'selected' : '' }}>
                                            {{ __('Not interested') }}
                                        </option>
                                        <option
                                            value="11" {{ old('status', $client->status) == 11 ? 'selected' : '' }}>
                                            {{ __('Low budget') }}
                                        </option>
                                        <option
                                            value="9" {{ old('status', $client->status) == 9 ? 'selected' : '' }}>
                                            {{ __('Wrong Number') }}
                                        </option>
                                        <option
                                            value="14" {{ old('status', $client->status) == 14 ? 'selected' : '' }}>
                                            {{ __('Unqualified') }}
                                        </option>
                                        <option
                                            value="15" {{ old('status', $client->status) == 15 ? 'selected' : '' }}>
                                            {{ __('Lost') }}
                                        </option>
                                    @else
                                        <option
                                            value="1" {{ old('status_edit', $client->status) == 1 ? 'selected' : '' }}>
                                            {{ __('New Lead') }}
                                        </option>
                                        <option
                                            value="16" {{ old('status_edit', $client->status) == 16 ? 'selected' : '' }}>
                                            {{ __('Unassigned') }}
                                        </option>
                                        <option
                                            value="17" {{ old('status_edit', $client->status) == 17 ? 'selected' : '' }}>
                                            {{ __('One Month') }}
                                        </option>
                                        <option
                                            value="18" {{ old('status_edit', $client->status) == 18 ? 'selected' : '' }}>
                                            {{ __('2-3 Months') }}
                                        </option>
                                        <option
                                            value="19" {{ old('status_edit', $client->status) == 19 ? 'selected' : '' }}>
                                            {{ __('Over 3 Months') }}
                                        </option>
                                        <option
                                            value="20" {{ old('status_edit', $client->status) == 20 ? 'selected' : '' }}>
                                            {{ __('In Istanbul') }}
                                        </option>
                                        <option
                                            value="21" {{ old('status_edit', $client->status) == 21 ? 'selected' : '' }}>
                                            {{ __('Agent') }}
                                        </option>
                                        <option
                                            value="5" {{ old('status_edit', $client->status) == 5 ? 'selected' : '' }}>
                                            {{ __('Sold') }}
                                        </option>
                                        <option
                                            value="15" {{ old('status_edit', $client->status) == 15 ? 'selected' : '' }}>
                                            {{ __('Lost') }}
                                        </option>
                                        <option
                                            value="23" {{ old('status_edit', $client->status) == 23 ? 'selected' : '' }}>
                                            {{ __('Transferred') }}
                                        </option>
                                        <option
                                            value="24" {{ old('status_edit', $client->status) == 24 ? 'selected' : '' }}>
                                            {{ __('No Answering') }}
                                        </option>
                                    @endif
                                </select>
                                @error('status_edit')<span class="error text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-12 col-lg-6" id="lost_reason_input">
                                <label
                                    for="lost_reason">{{ __('Lost Reason') }}</label>
                                <select wire:model="lost_reason_edit" id="lost_reason"
                                        class="custom-select custom-select-sm">
                                    <option value=""
                                            selected> {{ __('-- Select Lost Reason --') }}
                                    </option>
                                    <option
                                        value="1" {{ $client->status_new == '1' ? 'selected' : '' }}>{{ __('lost to competition') }}</option>
                                    <option
                                        value="2" {{ $client->status_new == '2' ? 'selected' : '' }}>{{ __('Applied by mistake') }}</option>
                                    <option
                                        value="3" {{ $client->status_new == '3' ? 'selected' : '' }}>{{ __('Budget was not enough') }}</option>
                                    <option
                                        value="4" {{ $client->status_new == '4' ? 'selected' : '' }}>{{ __('Client was looking for something else') }}</option>
                                    <option
                                        value="5" {{ $client->status_new == '5' ? 'selected' : '' }}>{{ __('Decided not to buy in Turkey') }}</option>
                                    <option
                                        value="6" {{ $client->status_new == '6' ? 'selected' : '' }}>{{ __('Wrong contact details') }}</option>
                                    <option
                                        value="7" {{ $client->status_new == '7' ? 'selected' : '' }}>{{ __('Unqualified') }}</option>
                                    <option
                                        value="8" {{ $client->status_new == '8' ? 'selected' : '' }}>{{ __('Unreachable') }}</option>
                                    <option
                                        value="9" {{ $client->status_new == '9' ? 'selected' : '' }}>{{ __('Postponed buying idea') }}</option>
                                    <option
                                        value="10" {{ $client->status_new == '10' ? 'selected' : '' }}>{{ __('Different language') }}</option>
                                </select>
                                @error('lost_reason_edit')<span class="error text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-12 col-lg-6" id="lost_reason_input_2">
                                <label
                                    for="lost_reason_description_edit">{{ __('Details') }}</label>
                                <textarea wire:model="lost_reason_description_edit" id="lost_reason_description_edit"
                                          class="form-control form-control-sm">
                                    </textarea>
                                @error('lost_reason_description_edit')<span
                                    class="error text-danger">{{ $message }}</span>@enderror
                            </div>

                        </div>
                        <div class="form-group">
                            <label
                                for="priority">{{ auth()->user()->department_id <> 1 ? __('Priority') : __('Qualification') }}</label>
                            <select wire:model="priority_edit" id="priority"
                                    class="custom-select custom-select-sm">
                                <option value=""
                                        selected> {{ auth()->user()->department_id <> 1 ? __('-- Priority --') : __('-- Qualification --') }}
                                </option>
                                <option
                                    value="1" {{ $client->priority == '1' ? 'selected' : '' }}>
                                    {{ __('Low') }}
                                </option>
                                <option
                                    value="2" {{ $client->priority == '2' ? 'selected' : '' }}>
                                    {{ __('Medium') }}
                                </option>
                                <option
                                    value="3" {{ $client->priority == '3' ? 'selected' : '' }}>
                                    {{ __('High') }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group" wire:ignore>
                            <label for="budget_request">{{ __('Budget') }}</label>
                            <select class="js-budgets-all custom-select custom-select-sm"
                                    multiple
                                    wire:model="budget_request_edit">

                                <script>
                                    $('.js-budgets-all').select2({
                                        theme: 'classic',
                                    })
                                    $('.js-budgets-all').on('change', function (e) {
                                        let data = $('.js-budgets-all').select2("val");
                                    @this.set('budget_request_edit', data);
                                    });
                                </script>
                                @php $r = collect($budget_request_edit)->toArray() @endphp
                                @foreach($budget_request_list as $item)
                                    <option value="{{ $item['id'] }}" {{ in_array($item['id'], $r) ? 'selected' : ''}}>
                                        {{$item['text']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" wire:ignore>
                            <label for="rooms_request">{{ __('Request') }}</label>
                            <select class="js-rooms-all custom-select custom-select-sm"
                                    wire:model="rooms_request_edit" multiple>
                                <script>
                                    $('.js-rooms-all').select2({
                                        theme: 'classic',
                                    })
                                    $('.js-rooms-all').on('change', function (e) {
                                        let data = $('.js-rooms-all').select2("val");
                                    @this.set('rooms_request_edit', data);
                                    });
                                </script>
                                @php $r = collect($rooms_request_edit)->toArray() @endphp
                                @foreach($rooms_request_list as $item)
                                    <option value="{{ $item['id'] }}" {{ in_array($item['id'], $r) ? 'selected' : ''}}>
                                        {{$item['text']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" wire:ignore>
                            <label for="requirements_request">{{ __('Requirement') }}</label>
                            <select class="js-requirements-all custom-select custom-select-sm"
                                    multiple id="requirements_request"
                                    wire:model="requirements_request_edit">
                                <script>
                                    $('.js-requirements-all').select2({
                                        theme: 'classic',
                                    })
                                    $('.js-requirements-all').on('change', function (e) {
                                        let data = $('.js-requirements-all').select2("val");
                                    @this.set('requirements_request_edit', data);
                                    });
                                </script>
                                @php $r = collect($requirements_request_edit)->toArray() @endphp
                                @foreach($requirements_request_list as $item)
                                    <option value="{{ $item['id'] }}" {{ in_array($item['id'], $r) ? 'selected' : ''}}>
                                        {{$item['text']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="source">{{ __('Source') }}</label>
                            <select wire:model="source_id_edit" id="source"
                                    class="custom-select custom-select-sm @error('source_id') form-control-danger @enderror">
                                <option selected disabled> {{ __('-- Select source --') }}
                                </option>
                                @foreach($sources as $source)
                                    <option value="{{ $source->id }}"
                                        {{ $client->source_id == $source->id ? 'selected' : '' }}>
                                        {{ $source->name }}</option>
                                @endforeach
                            </select>
                            @error('source_id')
                            <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 col-lg-6">
                                <label for="">{{ __('Campaign name') }}</label>
                                <input type="text" class="form-control form-control-sm"
                                       wire:model="campaign_name_edit"
                                       value="{{ $client->campaigne_name }}">
                            </div>

                            <div class="form-group col-md-12 col-lg-6">
                                <label for="source">{{ __('Agency') }}</label>
                                <select wire:model="agency_id_edit" id="agency"
                                        class="custom-select custom-select-sm @error('agency_id') form-control-danger @enderror js-agency-all">
                                    <option value="{{ $client->agency_id_edit }}">
                                        {{ $client->agency->name }}
                                    </option>
                                </select>
                                <script>
                                    $('.js-agency-all').select2({
                                        ajax: {
                                            url: "{{ route('agency.name') }}",
                                            dataType: 'json',
                                            delay: 250,
                                            processResults: function (data) {
                                                return {
                                                    results: $.map(data, function (item) {
                                                        return {
                                                            text: item.name,
                                                            id: item.id
                                                        }
                                                    })
                                                };
                                            },
                                            cache: true
                                        }
                                    });
                                    $('.js-country-all').on('change', function (e) {
                                        var data = $('.js-country-all').select2("val");
                                    @this.set('country_edit', data);
                                    });
                                </script>
                                @error('agency_id_edit')
                                <span class="invalid-feedback" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md">
                                <label for="appointment_date">{{ __('Date of coming') }}</label>
                                <input wire:model="appointment_date_edit" id="appointment_date"
                                       class="form-control form-control-sm"
                                       value="{{ old('appointment_date', optional($client->appointment_date)->format('Y-m-d') ) }}"
                                       type="date"/>
                            </div>
                            <div class="form-group col-md">
                                <label for="duration_stay">{{ __('Duration of Stay')}}</label>
                                <select wire:model="duration_stay_edit" id="duration_stay"
                                        class="form-control form-control-sm">
                                    <option value=""
                                            selected>{{ __('-- Select duration of Stay --') }}</option>
                                    <option
                                        value="1" {{ old('duration_stay', $client->duration_stay) == 1 ? 'selected' : '' }}>
                                        {{ __('1 Day') }}
                                    </option>
                                    <option
                                        value="2" {{ old('duration_stay', $client->duration_stay) == 2 ? 'selected' : '' }}>
                                        {{ __('2 Days') }}
                                    </option>
                                    <option
                                        value="3" {{ old('duration_stay', $client->duration_stay) == 3 ? 'selected' : '' }}>
                                        {{ __('3 Days') }}
                                    </option>
                                    <option
                                        value="4" {{ old('duration_stay', $client->duration_stay) == 4 ? 'selected' : '' }}>
                                        {{ __('4 Days') }}
                                    </option>
                                    <option
                                        value="5" {{ old('duration_stay', $client->duration_stay) == 5 ? 'selected' : '' }}>
                                        {{ __('5 Days') }}
                                    </option>
                                    <option
                                        value="6" {{ old('duration_stay', $client->duration_stay) == 6 ? 'selected' : '' }}>
                                        {{ __('6 Days') }}
                                    </option>
                                    <option
                                        value="7" {{ old('duration_stay', $client->duration_stay) == 7 ? 'selected' : '' }}>
                                        {{ __('7 Days') }}
                                    </option>
                                    <option
                                        value="8" {{ old('duration_stay', $client->duration_stay) == 8 ? 'selected' : '' }}>
                                        {{ __('8 Days') }}
                                    </option>
                                    <option
                                        value="9" {{ old('duration_stay', $client->duration_stay) == 9 ? 'selected' : '' }}>
                                        {{ __('9 Days') }}
                                    </option>
                                    <option
                                        value="10" {{ old('duration_stay', $client->duration_stay) == 10 ? 'selected' : '' }}>
                                        {{ __('10 Days') }}
                                    </option>
                                    <option
                                        value="11" {{ old('duration_stay', $client->duration_stay) == 11 ? 'selected' : '' }}>
                                        {{ __('11 Days') }}
                                    </option>
                                    <option
                                        value="12" {{ old('duration_stay', $client->duration_stay) == 12 ? 'selected' : '' }}>
                                        {{ __('12 Days') }}
                                    </option>
                                    <option
                                        value="13" {{ old('duration_stay', $client->duration_stay) == 13 ? 'selected' : '' }}>
                                        {{ __('13 Days') }}
                                    </option>
                                    <option
                                        value="14" {{ old('duration_stay', $client->duration_stay) == 14 ? 'selected' : '' }}>
                                        {{ __('14 Days') }}
                                    </option>
                                    <option
                                        value="15" {{ old('duration_stay', $client->duration_stay) == 15 ? 'selected' : '' }}>
                                        {{ __('16 Days') }}
                                    </option>
                                    <option
                                        value="30" {{ old('duration_stay', $client->duration_stay) == 30 ? 'selected' : '' }}>
                                        {{ __('1 Month') }}
                                    </option>
                                    <option
                                        value="60" {{ old('duration_stay', $client->duration_stay) == 60 ? 'selected' : '' }}>
                                        {{ __('2 Months') }}
                                    </option>
                                    <option
                                        value="90" {{ old('duration_stay', $client->duration_stay) == 90 ? 'selected' : '' }}>
                                        {{ __('3 Months') }}
                                    </option>
                                    <option
                                        value="99" {{ old('duration_stay', $client->duration_stay) == 99 ? 'selected' : '' }}>
                                        {{ __('Unspecified') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right">
                            {{ __('Submit') }}
                            <i class="fa fa-save"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <script>
            $(function () {
                if ($('#status').val() === '15') {
                    $('#lost_reason_input').show();
                    $('#lost_reason_input_2').show();
                } else {
                    $('#lost_reason_input').hide();
                    $('#lost_reason_input_2').hide();
                }

                $('#status').on('change', function () {
                    if ($('#status').val() === '15') {
                        $('#lost_reason_input').show();
                        $('#lost_reason_input_2').show();
                    } else {
                        $('#lost_reason_input').hide();
                        $('#lost_reason_input_2').hide();
                    }
                });
            });
        </script>
    </div>

@endif
@if($mode === 'show')
    <div>
        <div class="card-header b-t-primary b-b-primary p-2 d-flex justify-content-between">
            <h5 class="mr-auto mt-2">{{ __('Lead') }}
                : {{ $client->complete_name ?? $client->full_name ?? '' }}</h5>
            <a href="{{ route('clients.index') }}" class="btn btn-sm btn-warning mr-2"><i
                    class="icon-arrow-left"></i> {{ __('Back') }}</a>
            @if($client->user_id == auth()->id() || auth()->id() === 8 || auth()->id() === 1)
                <button wire:click="updateMode('edit')" class="btn btn-sm btn-primary">
                    {{ __('Edit') }}
                </button>
            @endif
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <table class="table m-0">
                        <tbody>
                        <tr>
                            <th scope="row">Id</th>
                            <td>{{ $client->public_id ?? '' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('Full Name') }}</th>
                            <td>{{ $client->complete_name ?? $client->full_name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('Phone(s)') }}</th>
                            <td>
                                @if($client->created_at <= now()->subYear())
                                    {{ str_pad(substr($client->client_number, -4), strlen($client->client_number), '*', STR_PAD_LEFT) }}
                                @else
                                    {{ $client->client_number }}
                                    <a href="https://wa.me/{{$client->client_number}}" target="_blank"
                                       class="btn btn-xs btn-outline-success float-right mr-2"><i
                                            class="fa fa-whatsapp"></i></a>
                                @endif
                                <a href="javascript:void(0)"
                                   class="btn btn-xs btn-outline-primary float-right"
                                   wire:click="makeCall('ph1')"><i
                                        class="fa fa-phone"></i></a>
                                <br>
                                @if($client->created_at <= now()->subYear())
                                    {{ str_pad(substr($client->client_number_2, -4), strlen($client->client_number_2), '*', STR_PAD_LEFT) }}
                                @else
                                    {{ $client->client_number_2 }}
                                    <a href="https://wa.me/{{$client->client_number_2}}" target="_blank"
                                       class="btn btn-xs btn-outline-success float-right mr-2"><i
                                            class="fa fa-whatsapp"></i></a>
                                @endif
                                <a href="javascript:void(0)"
                                   class="btn btn-xs btn-outline-primary float-right"
                                   wire:click="makeCall('ph2')"><i
                                        class="fa fa-phone"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('Email(s)') }}</th>
                            <td>
                                <a href="mailto:{{$client->client_email}}"
                                   class="btn btn-xs btn-outline-primary"><i
                                        class="icon-email"></i> {{ __('Send email') }}
                                </a>
                                <a href="mailto:{{$client->client_email_2}}"
                                   class="btn btn-xs btn-outline-primary"><i
                                        class="icon-email"></i> {{ __('Send email') }}
                                </a>
                            </td>
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
                            <th>{{ __('Description') }}</th>
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
                                    $i = $client->status;
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
                                    case 16:
                                    echo '<span class="badge badge-light-primary">'.__('Unassigned').'</span>';
                                    break;
                                    case 17:
                                    echo '<span class="badge badge-light-primary">'.__('One Month').'</span>';
                                    break;
                                    case 18:
                                    echo '<span class="badge badge-light-primary">'.__('2-3 Months').'</span>';
                                    break;
                                    case 19:
                                    echo '<span class="badge badge-light-primary">'.__('Over 3 Months').'</span>';
                                    break;
                                    case 20:
                                    echo '<span class="badge badge-light-primary">'.__('In Istanbul').'</span>';
                                    break;
                                    case 21:
                                    echo '<span class="badge badge-light-success">'.__('Agent').'</span>';
                                    break;
                                    case 22:
                                    echo '<span class="badge badge-light-danger">'.__('Sold').'</span>';
                                    break;
                                    case 23:
                                    echo '<span class="badge badge-light-danger">'.__('Transferred').'</span>';
                                    break;
                                    case 24:
                                    echo '<span class="badge badge-light-danger">'.__('No Answering').'</span>';
                                    break;
                                    }

                                    $i = $client->status_new;
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
                                    echo '<span class="badge badge-light-danger">'.__('Client was looking for something else').'</span>';
                                    break;
                                    case 5:
                                    echo '<span class="badge badge-light-danger">'.__('Decided not to buy in Turkey').'</span>';
                                    break;
                                    case 6:
                                    echo '<span class="badge badge-light-danger">'.__('Wrong contact details').'</span>';
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
                                <br>
                                <p><strong>Details: </strong>{!! $client->lost_reason_description !!}</p>
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
                                    if (is_null($budget_request_edit)) {
                                        echo $client->getRawOriginal('budget_request') ?? '';
                                    } else {
                                        $cou = '';
                                        $budgets = collect($budget_request_edit)->toArray();
                                        $newArr = array_filter($budget_request_list, function($var) use ($budgets){
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
                                    if (is_null($rooms_request_edit)) {
                                        echo $client->getRawOriginal('rooms_request') ?? '';
                                    } else {
                                        $cou = '';
                                        $rooms = collect($rooms_request_edit)->toArray();
                                        $newArr = array_filter($rooms_request_list, function($var) use ($rooms){
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
                                    if (is_null($requirements_request_edit)) {
                                        echo $client->getRawOriginal('requirements_request') ?? '';
                                    } else {
                                        $cou = '';
                                        $requirements = collect($requirements_request_edit)->toArray();
                                        $newArr = array_filter($requirements_request_list, function($var) use ($requirements){
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
                                {{ optional($client->source)->name }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('Companies name') }}</th>
                            <td>
                                {{ optional($client)->campaigne_name }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('Agency') }}</th>
                            <td>
                                {{ optional($client->agency)->name }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
