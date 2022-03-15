@if($mode === 'create')
    <div class="card">
        <div class="card-header b-t-primary b-b-primary p-2 d-flex justify-content-between">
            <h6 class="mb-0 f-w-600">{{ __('Notes') }}</h6>
            @can('note-create')
                <button wire:click="updateMode('show')" class="btn btn-primary btn-sm"><i
                        class="icon-arrow-left"></i> {{ __('Return to note list') }}
                </button>
            @endcan
        </div>
        <div class="card-body">
            <form wire:submit.prevent="createNote">
                <div class="checkbox checkbox-success">
                    <input id="checkbox-primary" type="checkbox" wire:model="notePin">
                    <label for="checkbox-primary">{{ __('Pin') }}</label>
                </div>
                <div class="form-group" wire:ignore>
                    <input x-data wire:model.lazy="body_note" id="summernote">
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
                                @this.set('body_note', contents);
                                }
                            }
                        })
                    </script>
                    @error('body')
                    <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <input type="hidden" id="client_id" name="client_id" value="{{ $client }}">
                <button type="submit" class="btn btn-outline-primary">
                    {{ __('Submit') }}
                </button>
            </form>
        </div>
    </div>
@endif
@if($mode === 'show')
    <div class="email-right-aside bookmark-tabcontent">
        <div class="card email-body radius-left">
            <div class="pl-0">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="pills-created" role="tabpanel"
                         aria-labelledby="pills-created-tab">
                        <div class="card mb-0">
                            <div class="card-header p-2 b-t-primary b-b-primary d-flex justify-content-between">
                                <h6 class="mb-0 f-w-600"><i class="file-text"></i> {{ __('Notes') }}</h6>
                                @can('note-create')
                                    <button wire:click="updateMode('create')" class="btn btn-outline-primary btn-sm">{{ __('Add
                                    Note') }} <i class="icon-plus"></i>
                                    </button>
                                @endcan
                            </div>
                            <div class="card-body p-0">
                                <div class="taskadd">
                                    <div class="table-responsive">
                                        <table class="table">
                                            @forelse($notes as $note)
                                                <tr class="border-bottom-primary">
                                                    <td width="col">
                                                        <div class="pretty p-icon p-round p-jelly mb-4">
                                                            <input type="checkbox" wire:click="pinNote({{ $note->id }})"
                                                                {{ $note->favorite === true ? 'checked' : '' }} />
                                                            <div class=" state p-success">
                                                                <i class="icon mdi mdi-check"></i>
                                                                <label>Favorite</label>
                                                            </div>
                                                        </div>
                                                        <p>
                                                            {!! optional($note)->body !!}
                                                        </p>
                                                        <p class="text-muted">
                                                            {{ Carbon\Carbon::parse($note->date)->format('d-m-Y H:i') }}
                                                            {{ __('By:') }} {{ $note->user->name ?? '' }}
                                                        </p>
                                                    </td>
                                                    <td width="col">
                                                        @can('note-delete')
                                                            <button class="btn btn-outline-warning btn-xs"
                                                                    wire:click="deleteNote({{ $note->id }})"
                                                                    type="submit">
                                                                <i class="icon-trash"></i></button>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @empty
                                                <h5 class="p-25 text-center text-primary f-w-900">{{ __('Nothing') }} <i
                                                        class="icon-face-sad"></i></h5>
                                            @endforelse
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
@endif

