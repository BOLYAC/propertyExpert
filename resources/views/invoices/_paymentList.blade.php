<div class="card b-t-primary">
    <div class="card-body">
        <div class="order-history dt-ext table-responsive">
            <table class="table table-striped display table-bordered nowrap"
                   width="100%" cellspacing="0" id="payments-table">
                <h3>{{ __('Commission') }}</h3>
                <thead>
                <tr>
                    <th>{{ __('Date add') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Amount') }}</th>
                    <th>{{ __('Description') }}</th>
                    <th></th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@section('script_after')
    <script>
        $(function () {
            let table = $('#payments-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                bFilter: false,
                bPaginate: false,
                ajax: '{!! route('invoice.paymentsDataTable', $invoice->external_id) !!}',
                columns: [
                    {data: 'payment_date', name: 'payment_date', searchable: false},
                    {data: 'payment_source', name: 'payment_source', searchable: false},
                    {data: 'amount', name: 'amount', searchable: false},
                    {data: 'description', name: 'description', orderable: false, searchable: false},
                        @can('payment-delete')
                    {
                        data: 'delete',
                        name: 'delete',
                        orderable: false,
                        searchable: false,
                        class: 'fit-action-delete-th table-actions'
                    },
                    @endcan
                ]
            });

        });
    </script>
@endsection
