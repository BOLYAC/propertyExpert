@if( auth()->id() == 1 || in_array(auth()->id(), $event->sellers) || auth()->user()->hasPermissionTo('write-feedback'))
    @can('chose-results')
        <div class="form-group">
            <label for="results">{{ __('Results') }}</label>
            <select name="results" id="results" class="form-control form-control-sm">
                <option value="0"> - {{ __('None') }} -</option>
                <option value="1" {{ $event->results === '1' ? 'selected' : '' }}>{{ __('Under evaluation') }}</option>
                <option value="2" {{ $event->results === '2' ? 'selected' : '' }}>{{ __('Postponed') }}</option>
                <option value="3" {{ $event->results === '3' ? 'selected' : '' }}>{{ __('Negative') }}</option>
                <option value="4" {{ $event->results === '4' ? 'selected' : '' }}>{{ __('Appointment') }} not met
                </option>
                <option value="5" {{ $event->results === '5' ? 'selected' : '' }}>{{ __('Reservation') }}</option>
                <option
                    value="6" {{ $event->results === '6' ? 'selected' : '' }}>{{ __('Reservation Cancellation') }}</option>
                <option value="7" {{ $event->results === '7' ? 'selected' : '' }}>{{ __('Sale') }}</option>
                <option value="8" {{ $event->results === '8' ? 'selected' : '' }}>{{ __('Sale Cancellation') }}</option>
                <option value="9" {{ $event->results === '9' ? 'selected' : '' }}>{{ __('After Sale') }}</option>
                <option value="10" {{ $event->results === '10' ? 'selected' : '' }}>{{ __('Presentation') }}</option>
                <option value="11" {{ $event->results === '11' ? 'selected' : '' }}>{{ __('Follow up') }}</option>
            </select>
        </div>
    @endcan

    @can('write-feedback')
        <div class="form-group">
            <label for="feedback">{{ __('Feedback') }}</label>
            <textarea name="feedback"
                      id="feedback">{{ old('feedback', $event->feedback) }}</textarea>
        </div>
    @endcan
    @can('chose-negativity')
        <div class="form-group" id="negative-form">
            <label for="negativity">{{ __('Negativity criterion:') }}</label>
            <select name="negativity" id="negativity" class="form-control form-control-sm">
                <option value="1" {{ $event->negativity === '1' ? 'selected' : '' }}> - {{ __('None') }} -</option>
                <option value="2" {{ $event->negativity === '2' ? 'selected' : '' }}>{{ __('Low Budget') }}</option>
                <option value="3" {{ $event->negativity === '3' ? 'selected' : '' }}>{{ __('Other Agencies') }}</option>
                <option value="4" {{ $event->negativity === '4' ? 'selected' : '' }}>{{ __('Trust Issues') }}</option>
                <option value="5" {{ $event->negativity === '5' ? 'selected' : '' }}>{{__('Customer not interested')}}
                </option>
                <option
                    value="6" {{ $event->negativity === '6' ? 'selected' : '' }}>{{ __('Issues with projects') }}</option>
                <option
                    value="7" {{ $event->negativity === '7' ? 'selected' : '' }}>{{ __('Issues with payment plans') }}
                </option>
            </select>
        </div>
    @endcan
@else
    <div class="general-info">
        <div class="row">
            <div class="col-md">
                <table class="table m-0">
                    <tbody>
                    <tr>
                        <th scope="row">{{ __('Results') }}</th>
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
                            @endphp</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Feedback') }}</th>
                        <td>{!! $event->feedback ?? '' !!}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Negativity criterion:') }}</th>
                        <td>
                            @php
                                $i = $event->Negativity;
                                switch ($i) {
                                case 1:
                                echo __('None');
                                break;
                                case 2:
                                echo __('Low Budget');
                                break;
                                case 3:
                                echo __('Other Agencies');
                                break;
                                case 4:
                                echo __('Trust Issues');
                                break;
                                case 5:
                                echo __('Customer not interested');
                                break;
                                case 6:
                                echo __('Issues with projects');
                                break;
                                case 7:
                                echo __('Issues with payment plans');
                                break;
                                }
                            @endphp
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

