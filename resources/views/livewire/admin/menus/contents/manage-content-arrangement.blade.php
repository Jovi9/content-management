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
                    <button class="btn btn-primary mb-3 float-end" wire:click="resetFormCounts">Reset Arrangement</button>
                    <table class="table table-responsive-sm" id="">
                        <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($contents)
                                @foreach ($contents as $content)
                                    <tr>
                                        <td hidden>{{ $content['id'] }}</td>
                                        <td>{{ $content['title'] }}</td>
                                        <td>
                                            <select name="" id="" class="form-select"
                                                value="{{ $content['arrangement'] }}">
                                                <option value="{{ $content['arrangement'] }}" selected>
                                                    {{ $content['arrangement'] }}</option>
                                                @if ($counts)
                                                    @foreach ($counts as $count)
                                                        @if (!($count['count'] == $content['arrangement']))
                                                            <option value="{{ $count['count'] }}"
                                                                wire:click="updateArrangement('{{ $count['count'] }}','{{ $content['id'] }}')">
                                                                {{ $count['count'] }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button"
                        wire:click="closeModal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
