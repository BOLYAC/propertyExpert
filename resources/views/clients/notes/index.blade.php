<div class="email-right-aside bookmark-tabcontent">
    <div class="card email-body radius-left">
        <div class="pl-0">
            <div class="tab-content">
                <div class="tab-pane fade active show" id="pills-created" role="tabpanel"
                     aria-labelledby="pills-created-tab">
                    <div class="card mb-0">
                        <div class="card-header d-flex">
                            <h6 class="mb-0 f-w-600"><i data-feather="file-text"></i> Notes</h6>
                            <a href="#">Add note <i class="mr-2" data-feather="plus"></i></a>
                        </div>
                        <div class="card-body p-0">
                            <div class="taskadd">
                                <div class="table-responsive">
                                    <table class="table">
                                        @foreach($notes as $note)
                                            <tr class="border-bottom-primary">
                                                <td width="col">
                                                    {!! $note->body ?? '' !!}
                                                    <p class="text-muted">
                                                        {{ Carbon\Carbon::parse(now())->format('Y-m-d H:i') }}
                                                        {{ __('By:') }} Admin
                                                    </p>
                                                </td>
                                                <td width="col">
                                                    <a href="#"><i data-feather="link"></i></a>
                                                    @can('note-delete')
                                                        <a>
                                                            <i data-feather="trash-2"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

