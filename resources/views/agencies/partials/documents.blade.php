<!-- info card start -->
<div class="card">
    <div class="card-header">
        <h5 class="card-header-text">{{ __('Documents') }}</h5>
        <div class="pull-right">
            @can('task-create')
                <button data-toggle="modal"
                        data-target="#document-in-modal"
                        class="btn btn-primary form-control">{{ __('Add Documents') }} <i class="ti-plus"></i>
                </button>
            @endcan
        </div>
    </div>
    <div class="card-body">
        @if($agency->documents->count() > 0)
            <div class="table-responsive">
                <div class="dt-responsive table-responsive">
                    <table id="res-config" class="table table-bordered nowrap">
                        <thead>
                        <tr>
                            <th width="20%">{{ __('File') }}</th>
                            <th width="60%">{{ __('Title') }}</th>
                            <th width="10%">{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($agency->documents as $file)
                            <tr data-id="{{ $file->id }}">
                                <td class="img-pro text-center">
                                    <a href="{{ asset('storage/' . $file->full) }}" data-lightbox="{{ $file->id }}" data-title="{{ $file->title }}">
                                        <img src="{{ asset('storage/' . $file->full) }}" alt="" class="img-fluid img-thumbnail img-fluid d-inline-block img-70">
                                    </a>
                                </td>
                                <td class="pro-name">
                                    <h6>{{ $file->title }}</h6>
                                    <span
                                        class="text-muted f-12">{{ $file->excerpt }}</span>
                                </td>
                                <td class="action-icon text-center">
                                    <!--<a href="" class="m-r-15 text-muted f-18"><i class="icofont icofont-ui-edit"></i></a>-->
                                    @can('task-delete')
                                        <a href="#" class="text-muted f-18 delete"><i
                                                class="icofont icofont-delete-alt"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- info card end -->
<!-- Create modal start -->
<div class="modal fade" id="document-in-modal" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('New document') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ $agency->getCreateDocumentEndpoint() }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-b-0">
                    <input type="hidden" name="client_id" value="{{ $agency->id }}">
                    <div class="form-group">
                        <label>{{ __('Title') }}</label>
                        <input type="text" class="form-control" name="title">
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
                    <button type="button" class="btn btn-warning" data-dismiss="modal">{{ __('Cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Create modal end -->
