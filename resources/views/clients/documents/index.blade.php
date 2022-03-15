<!-- info card start -->
<div class="card">
    <div class="card-header b-b-primary p-2 d-flex justify-content-between">
        <h6 class="text-muted">{{ __('Documents') }}</h6>
        <button data-toggle="modal"
                data-target="#exampleModalCenter"
                class="btn btn-primary">{{ __('Add') }} <i class="icon-plus"></i>
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive groups-table agent-performance-table">
            <table class="table">
                <tbody>
                @if($clientDocuments->count() > 0)
                    @foreach($clientDocuments as $file)
                        <tr>
                            <td>
                                <div class="d-inline-block align-middle"><a
                                        href="{{ asset('storage/' . $file->full) }}" data-lightbox="{{ $file->id }}"
                                        data-title="{{ $file->title }}"><img
                                            class="img-radius img-40 align-top m-r-15 rounded-circle"
                                            src="{{ asset('storage/' . $file->full) }}" alt=""></a>
                                    <div class="d-inline-block"><span
                                            class="f-w-600 f-12 font-dark">{{ $file->title }}</span><span
                                            class="d-block f-12 font-primary">{{ $file->excerpt }}</span></div>
                                </div>
                            </td>
                            <td>
                                @can('task-delete')
                                    <button class="btn badge-light-primary btn-xs delete"
                                            type="button">{{ __('Delete') }}
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- info card end -->
<!-- Create modal start -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('New document') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span
                        aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ $client->getCreateDocumentEndpoint() }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <div class="form-group">
                        <label>{{ __('Title') }}</label>
                        <input class="form-control" name="title">
                    </div>
                    <div class="form-group">
                        <label>{{ __('Excerpt') }}</label>
                        <input type="text" name="excerpt" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{ __('File') }}</label>
                        <input type="file" name="full" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }} <i class="icon-save"></i></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Create modal end -->
