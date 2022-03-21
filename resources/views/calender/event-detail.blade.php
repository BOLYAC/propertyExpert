<div class="col-xl-12 xl-50 box-col-6">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <a class="btn btn-link pl-0" data-toggle="collapse" data-target="#collapseicon2" href="{{ route('events.show', $eventDetail) }}"
                        aria-expanded="true" aria-controls="collapseicon2">About
                </a>
            </h5>
        </div>
        <div class="collapse show" id="collapseicon2" aria-labelledby="collapseicon2"
             data-parent="#accordion">
            <div class="card-body filter-cards-view">
                <span class="f-w-600">Made By :</span>
                <p class="f-w-400">
                    {{ $eventDetail->user->name }}
                </p>
                <span class="f-w-600">Title:</span>
                <p>
                    {{ $eventDetail->lead_name ?? $eventDetail->name ?? ''}}
                </p>
                <span class="f-w-600">Description:</span>
                <p>
                    {{ $eventDetail->description}}
                </p>
                <span class="f-w-600">Appointment Date:</span>
                <p>
                    {{ $eventDetail->event_date }}
                </p>
                <div class="social-network theme-form"><span class="f-w-600"></span>
                    <a class="btn social-btn btn-fb mb-2 text-center" href="{{ route('events.show', $eventDetail) }}"><i
                            class="fa fa-eye m-r-5"></i>View the appointment
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

