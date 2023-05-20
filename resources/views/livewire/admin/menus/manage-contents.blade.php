<div>
    <table class="table table-responsive-sm" id="">
        <thead>
            <tr>
                <th scope="col">Main Menu</th>
                <th scope="col">Sub Menu</th>
                <th scope="col">Title</th>
                <th scope="col">Status</th>
                <th scope="col">Visibility</th>
                <th scope="col">Actions</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @if ($contents)
                @foreach ($contents as $content)
                    <tr>
                        <td>{{ $content['mainMenu'] }}</td>
                        <td>{{ $content['subMenu'] }}</td>
                        <td>{{ $content['title'] }}</td>
                        <td>{{ ucwords($content['status']) }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="{{ $content['id'] }}"
                                    @if ($content['isVisible']) checked @endif
                                    wire:click="toggleVisibility('{{ $content['id'] }}')">
                                <label class="form-check-label" for="{{ $content['id'] }}">
                                    @if ($content['isVisible'])
                                        {{ __('Visible') }}
                                    @else
                                        {{ __('Hidden') }}
                                    @endif
                                </label>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-primary" wire:click="modalShowDetails('{{ $content['id'] }}')">
                                <i class="fa fa-eye"></i>
                            </button>
                            @if (strtolower($content['status']) === 'pending')
                                <button class="btn btn-primary" wire:click="approveContent('{{ $content['id'] }}')"><i
                                        class="fa fa-check"></i></button>
                            @endif
                            <a href="{{ route('admin.contents-edit', ['id' => $content['id'], 'requestFrom' => 'manage-contents']) }}"
                                class="btn btn-primary"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-danger" wire:click="deleteSelected('{{ $content['id'] }}')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                        <td>
                            @if (strtolower($content['subMenu']) === 'none')
                                <a href="{{ route('public-show', ['main' => $content['mainURI']]) }}" target="_blank"
                                    class="btn btn-primary">
                                    <i class="fas fa-eye"></i> View Page
                                </a>
                            @else
                                <a href="{{ route('public-show', ['main' => $content['mainURI'] . '/' . $content['subURI']]) }}"
                                    target="_blank" class="btn btn-primary">
                                    <i class="fas fa-eye"></i> View Page
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="modal fade" id="modalShowDetails" tabindex="-1" role="dialog" aria-labelledby="modalShowDetails"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalShowDetails"><strong>Content Details</strong></h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Main Menu</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0" id="mainMenu"></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Sub Menu</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0" id="subMenu"></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Title</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0" id="title"></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Created By</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0" id="createdBy"></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Created At</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0" id="created_at"></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Updated By</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0" id="updatedBy"></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Updated At</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0" id="updated_at"></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Status</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0" id="status"></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Vsisible</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0" id="visible"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" id="btnClose"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
