<div>
    <div class="card {{ $lead->stage_id >= 4 ? 'visible': 'invisible' }}">
        <div class="card-header b-b-primary b-t-primary p-2">
            <h6>{{ __('Reservation form') }}</h6>
        </div>
        <div class="card-body row">
            <div class="col-lg-6">
                <table class="table m-0">
                    <tbody>
                    <tr>
                        <th scope="row">{{ __('Project name') }}</th>
                        <td>{{ $lead->project_name ?? ''}}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Province/Country') }}</th>
                        <td>{{ $lead->country_province ?? ''}}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Section/Plot') }}</th>
                        <td>{{ $lead->block_num ?? '' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Block No') }}</th>
                        <td>{{ $lead->block_num ?? ''}}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('No of Rooms') }}</th>
                        <td>{{ $lead->room_number ?? ''}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-6">
                <table class="table m-0">
                    <tbody>
                    <tr>
                        <th scope="row">{{ __('Floor No:') }}</th>
                        <td>{{ $lead->floor_number ?? ''}}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Gross M²') }}</th>
                        <td>{{ $lead->gross_square ?? '' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Flat No') }}</th>
                        <td>{{ $lead->flat_num ?? ''}}</td>
                    </tr>

                    <tr>
                        <th scope="row">{{ __('Reservation Amount') }}</th>
                        <td>{{ $lead->reservation_amount ?? ''}}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Sale price') }}</th>
                        <td>{{ $lead->sale_price ?? ''}}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('File path') }}</th>
                        <td>{{ $lead->file_path ?? ''}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
