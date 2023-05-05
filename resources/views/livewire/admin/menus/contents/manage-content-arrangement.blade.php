<div>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalManageArrangement"><i
            class="fa fa-list"></i> Modify Content Arrangement</button>


    <div wire:ignore.self class="modal fade" id="modalManageArrangement" tabindex="-1" role="dialog"
        aria-labelledby="modalManageArrangement" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Manage Content Arrangement</strong></h5>
                </div>
                <div class="modal-body text-left">
                    <table class="table table-responsive-sm table-striped" id="tableSource">
                        <thead class="thead-dark">
                            <tr class="">
                                <th scope="col">Title</th>
                                <th scope="col">Sort</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($contents)
                                @foreach ($contents as $content)
                                    <tr>
                                        <td hidden>
                                            <input type="text" value="{{ $content['id'] }}"
                                                name="{{ $content['id'] }}" readonly>
                                        </td>
                                        <td class="">
                                            {{ $content['title'] }}
                                        </td>
                                        <td>
                                            <button class="move-up btn btn-primary"><i class="fas fa-arrow-up"></i></button>
                                            <button class="move-down btn btn-primary"><i class="fas fa-arrow-down"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button id="btnSave" class="btn btn-primary">Save</button>
                    <button class="btn btn-secondary" type="button" wire:click="closeModal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
