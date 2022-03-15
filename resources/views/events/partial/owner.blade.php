@if( auth()->id() == 1 || in_array(auth()->id(), $event->sellers))
    <div class="row">
        <div class="form-group input-group-sm col-md-6">
            <label for="name">{{ __('Title') }}</label>
            <input class="form-control sm" type="text" name="name" id="name"
                   value="{{ old('name', $event->name) }}">
        </div>
        <div class="form-group input-group-sm col-md-6">
            <label for="event_date">{{ __('Date of appointment') }}</label>
            <input name="event_date" id="event_date" class="form-control" onclick="myFunction()"
                   value="{{ old('event_date', Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i')) }}"
                   type="datetime-local"/>
        </div>
        <div class="col-md-12 row">
            <div class="form-group input-group-sm col-2">
                <label for="color">{{ __('Colors') }}</label>
                <div>
                    <input id="color" name="color" type="color" list="presetColors" value="{{ $event->color }}">
                    <datalist id="presetColors">
                        <option {{ $event->color === '#0B8043' ? 'selected' : '' }}>#0B8043</option>
                        <option {{ $event->color === '#D50000' ? 'selected' : '' }}>#D50000</option>
                        <option {{ $event->color === '#F4511E' ? 'selected' : '' }}>#F4511E</option>
                        <option {{ $event->color === '#8E24AA' ? 'selected' : '' }}>#8E24AA</option>
                        <option {{ $event->color === '#3F51B5' ? 'selected' : '' }}>#3F51B5</option>
                        <option {{ $event->color === '#039BE5' ? 'selected' : '' }}>#039BE5</option>
                    </datalist>
                </div>
            </div>
            <div class="checkbox checkbox-primary col m-t-20">
                <input id="zoom_meeting" name="zoom_meeting" type="checkbox"
                    {{ $event->zoom_meeting == 1 ? 'checked' : '' }}
                >
                <label for="zoom_meeting">
                    {{ __('Zoom meeting') }}
                </label>
            </div>
        </div>
        <div class="form-group input-group-sm col-md-2">
            <label for="currency">{{ __('Currency') }}</label>
            <select class="form-control form-control-sm" id="currency" name="currency">
                <option value="try" {{ $event->currency === 'try' ? 'selected' : '' }}>TRY</option>
                <option value="usd" {{ $event->currency === 'usd' ? 'selected' : '' }}>USD</option>
                <option value="eur" {{ $event->currency === 'eur' ? 'selected' : '' }}>EURO</option>
            </select>
        </div>
        <div class="form-group input-group-sm col-md">
            <label for="lead_budget">{{ __('Budget') }}</label>
            <select name="lead_budget[]" id="lead_budget" class="js-budgets-all form-control form-control-sm" multiple>
            </select>
            @if(is_null($event->budget))
                <div class="col-form-label">
                    <span>{{ __('Old:') }} <b>{{ $event->budget }}</b></span></div>
            @endif
        </div>
    </div>
    <div class="form-group input-group-sm">
        <label for="description">{{__('Description')}}</label>
        <textarea class="summernote" type="text" name="description"
                  id="description"> {{ old('description', $event->description) }}</textarea>
    </div>
    <div class="form-group input-group-sm">
        <label for="place">{{ __('Place') }}</label>
        <input class="form-control form-control-sm" type="text" name="place" id="place"
               value="{{ old('place', $event->place) }}">
    </div>
@else
    <div class="general-info">
        <div class="row">
            <div class="col-md-6">
                <table class="table m-0">
                    <tbody>
                    <tr>
                        <th scope="row">{{ __('Title') }}</th>
                        <td>{{ $event->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Budget') }}</th>
                        @if(is_null($event->lead_budget))
                            <td> {{ $event->budget ?? '' }} - {{ $event->currency ?? '' }} </td>
                        @else
                            <td> {{ $event->lead_budget ?? '' }} - {{ $event->currency ?? '' }} </td>
                        @endif
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Description') }}</th>
                        <td>{!! $event->description !!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table m-0">
                    <tbody>
                    <tr>
                        <th scope="row">{{ __('place') }}</th>
                        <td>{{ $event->place }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Sells') }}</th>
                        <td>
                            @php $sellRep = collect($event->sells_name)->toArray() @endphp
                            @foreach( $sellRep as $name)
                                <span class="badge badge-dark">{{ $name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- end of row -->
    </div>
@endif

